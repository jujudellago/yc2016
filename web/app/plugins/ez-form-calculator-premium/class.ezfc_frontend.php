<?php

class Ezfc_frontend {
	public function __construct() {
		global $wpdb;
		$this->wpdb = $wpdb;

		$this->tables = array(
			"debug"          => "{$this->wpdb->prefix}ezfc_debug",
			"elements"       => "{$this->wpdb->prefix}ezfc_elements",
			"files"          => "{$this->wpdb->prefix}ezfc_files",
			"forms"			 => "{$this->wpdb->prefix}ezfc_forms",
			"forms_elements" => "{$this->wpdb->prefix}ezfc_forms_elements",
			"forms_options"  => "{$this->wpdb->prefix}ezfc_forms_options",
			"options"        => "{$this->wpdb->prefix}ezfc_options",
			"submissions"    => "{$this->wpdb->prefix}ezfc_submissions"
		);

		$this->debug_enabled = true;
		if (get_option("ezfc_debug_mode", 0) == 1) {
			$this->debug_enabled = true;
			error_reporting(E_ALL);
		}

		// filters
		add_filter("ezfc_label_sanitize", array($this, "label_sanitize"));
	}

	public function debug($msg) {
		if (!$this->debug_enabled) return;

		$this->wpdb->insert(
			$this->tables["debug"],
			array("msg" => $msg),
			array("%s")
		);
	}

	public function form_get($id, $name=null) {
		if (!$id && !$name) return $this->send_message("error", __("No id or name found.", "ezfc"));

		if ($id) {
			$res = $this->wpdb->get_row($this->wpdb->prepare(
				"SELECT * FROM {$this->tables["forms"]} WHERE id=%d",
				$id
			));
		}

		if ($name) {
			$res = $this->wpdb->get_row($this->wpdb->prepare(
				"SELECT * FROM {$this->tables["forms"]} WHERE name=%s",
				$name
			));
		}

		if (!$res) return false;

		return $res;
	}

	public function form_get_options($id) {
		if (!$id) return $this->send_message("error", __("No ID", "ezfc"));

		$settings = $this->array_index_key(Ezfc_settings::get_form_options(true), "id");

		// merge values
		$settings_db = $this->array_index_key($this->wpdb->get_results($this->wpdb->prepare("SELECT o_id, value FROM {$this->tables["forms_options"]} WHERE f_id=%d", $id), ARRAY_A), "o_id");

		foreach ($settings as &$setting) {
			if (!empty($settings_db[$setting["id"]])) $setting["value"] = maybe_unserialize($settings_db[$setting["id"]]["value"]);
		}

		return $settings;
	}

	public function form_get_option_values($id) {
		$settings_tmp = $this->form_get_options($id);
		$settings = array();

		foreach ($settings_tmp as &$setting) {
			$settings[$setting["name"]] = $setting["value"];
		}

		return $settings;
	}

	public function form_get_submission_files($ref_id) {
		if (!$ref_id) return $this->send_message("error", __("No ref_id", "ezfc"));

		$files = $this->wpdb->get_results($this->wpdb->prepare(
			"SELECT * FROM {$this->tables["files"]} WHERE ref_id=%s",
			$ref_id
		));

		return $files;
	}

	/**
		elements
	**/
	public function elements_get() {
		$elements = $this->array_index_key(Ezfc_settings::get_elements(), "id");

		$elements_ext = apply_filters("ezfc_show_backend_elements", array());
		foreach ($elements_ext as $element_name => $element_options) {
			// convert array data to object
			$element_data_json = json_decode(json_encode($element_options));
			$element_data_json->extension = true;

			$elements[$element_name] = $element_data_json;
		}

		return $elements;
	}

	public function element_get($id) {
		if (!$id) return $this->send_message("error", __("No ID.", "ezfc"));

		$elements = $this->array_index_key(Ezfc_settings::get_elements(), "id");

		return $elements[$id];
	}

	/**
		form elements
	**/
	public function form_elements_get($id) {
		if (!$id) return $this->send_message("error", __("No ID given.", "ezfc"));

		$res = $this->wpdb->get_results($this->wpdb->prepare(
			"SELECT * FROM {$this->tables["forms_elements"]} WHERE f_id=%d ORDER BY position DESC",
			$id
		));

		return $res;
	}

	public function form_element_get($fe_id) {
		if (!$fe_id) return $this->send_message("error", __("No ID given.", "ezfc"));

		$res = $this->wpdb->get_row($this->wpdb->prepare(
			"SELECT * FROM {$this->tables["forms_elements"]} WHERE id=%d",
			$fe_id
		));

		return $res;
	}

	/**
		get submission entry
	**/
	public function submission_get($id) {
		if (!$id) return $this->send_message("error", __("No ID.", "ezfc"));

		$res = $this->wpdb->get_row($this->wpdb->prepare(
			"SELECT * FROM {$this->tables["submissions"]} WHERE id=%d",
			$id
		));

		return $res;
	}

	/**
		misc functions
	**/
	public function check_input($id, $data_raw) {
		if (!$id || !$data_raw) return $this->send_message("error", __("No ID or no data.", "ezfc"));

		$data   = $data_raw["ezfc_element"];
		$ref_id = $data_raw["ref_id"];

		$elements      = $this->array_index_key($this->elements_get(), "id");
		$form_elements = $this->array_index_key($this->form_elements_get($id), "id");
		$options       = $this->form_get_option_values($id);

		if ($options["submission_enabled"] == 0) {
			return $this->send_message("error", __("Submission not allowed.", "ezfc"));
		}

		$step_counter = 0;

		foreach ($form_elements as $fe_id => $form_element) {
			// special field - email double check
			if (strpos($fe_id, "email_check") !== false) continue;

			$element_data = json_decode($form_element->data);

			$is_extension = false;
			// check for extension
			if (!empty($element_data->extension)) {
				$extension_settings = apply_filters("ezfc_get_extension_settings_{$element_data->extension}", null);
				$el_type = $extension_settings["type"];

				$is_extension = true;
			}
			else {
				$el_type = $elements[$form_element->e_id]->type;
			}

			// skip non-input fields (and recaptcha since it is verified in ajax.php)
			$skip_check_elements = array("image", "hr", "html", "recaptcha");
			if (in_array($el_type, $skip_check_elements)) continue;

			// check for steps
			if ($el_type == "stepend") {
				if (isset($data_raw["step"]) && $step_counter == (int) $data_raw["step"]) {
					return $this->send_message("step_valid", "");
				}

				$step_counter++;
			}

			// skip if the field was hidden by conditional logic
			if (isset($data[$fe_id]) && !is_array($data[$fe_id]) && strpos($data[$fe_id], "__HIDDEN__") !== false) continue;

			// checkbox (shouldn't be required, really)
			if (isset($data[$fe_id]) && is_array($data[$fe_id]) && $el_type == "checkbox") {
				if (Ezfc_Functions::array_empty($data[$fe_id])) {
					return $this->send_message("error", get_option("ezfc_required_text_element", "This field is required."), $fe_id);
				}
			}
			else {
				$empty = false;

				if (isset($data[$fe_id])) {
					$input_value = $data[$fe_id];

					if (is_array($data[$fe_id])) {
						$empty = Ezfc_Functions::array_empty($data[$fe_id]);
					}
					else {
						$input_value = trim($data[$fe_id]);

						// check if submitted data string is empty
						$empty = ((!is_string($input_value) || $input_value == "") && $el_type != "fileupload") ? true : false;
					}
				}
				// no submit data for this element exists -> empty
				else {
					$empty = true;
				}

				// check if element is required and no value was submitted
				if (property_exists($element_data, "required") && (int) $element_data->required == 1 && $empty) {
					return $this->send_message("error", get_option("ezfc_required_text_element", "This field is required."), $fe_id);
				}

				// run filters
				if (!$empty) {
					switch ($el_type) {
						case "input":
							if (property_exists($element_data, "custom_regex") && !empty($element_data->custom_regex)) {
								if (!preg_match($element_data->custom_regex, $input_value)) {
									return $this->send_message("error", $element_data->custom_error_message, $fe_id);
								}
							}
						break;

						case "daterange":
							if (!is_array($input_value)	||
								!isset($input_value[0]) || !isset($input_value[1]) ||
								!Ezfc_Functions::check_valid_date($options["datepicker_format"], $input_value[0], true) ||
								!Ezfc_Functions::check_valid_date($options["datepicker_format"], $input_value[1], true)) {
								return $this->send_message("error", __("Please enter a valid date range.", "ezfc"), $fe_id);
							}
						break;

						case "email":
							if (!filter_var($input_value, FILTER_VALIDATE_EMAIL)) {
								return $this->send_message("error", __("Please enter a valid email address.", "ezfc"), $fe_id);
							}

							// double check email address
							if (property_exists($element_data, "double_check") && $element_data->double_check == 1) {
								$email_check_name = "{$fe_id}_email_check";

								if (!$data[$email_check_name] ||
									$data[$email_check_name] !== $input_value) {
									return $this->send_message("error", __("Please check your email address.", "ezfc"), $fe_id);
								}
							}
						break;

						case "fileupload":
							// yeah i know, this sucks :/
							if ($element_data->required == 1) {
								$checkfile = $this->wpdb->get_row($this->wpdb->prepare(
									"SELECT id FROM {$this->tables["files"]} WHERE ref_id=%s",
									$ref_id
								));

								if (!$checkfile) return $this->send_message("error", __("No file was uploaded yet.", "ezfc"), $fe_id);
							}
						break;

						case "numbers":
							if (!is_numeric($input_value)) {
								return $this->send_message("error", __("Please enter a valid number.", "ezfc"), $fe_id);
							}

							// min / max values
							if (!empty($element_data->min)) {
								if ($input_value < $element_data->min) return $this->send_message("error", __("Minimum value:", "ezfc") . $element_data->min , $fe_id);
							}
							if (!empty($element_data->max)) {
								if ($input_value > $element_data->max) return $this->send_message("error", __("Maximum value:", "ezfc") . $element_data->max , $fe_id);
							}
						break;
					}
				}

				// custom filter
				if (!empty($element_data->custom_filter)) {
					$filter_result = apply_filters("ezfc_custom_filter_{$element_data->custom_filter}", $element_data, $input_value);

					if (is_array($filter_result) && !empty($filter_result["error"])) {
						return $this->send_message("error", $filter_result["error"]);
					}
				}
			}

			// also check for extension input
			if ($is_extension) {
				$extension_result = apply_filters("ezfc_ext_check_input_{$element_data->extension}", $input_value, $element_data);

				if (!empty($extension_result["error"])) {
					return $this->send_message("error", $extension_result["error"]);
				}
			}
		}

		// no errors found
		return $this->send_message("success", "");
	}

	/**
		prepare submission data
	**/
	public function prepare_submission_data($id, $data, $force_paypal = false, $ref_id = false) {
		// paypal
		if (is_object($data)) {
			$element_data = (array) $data;
		}
		else {
			$element_data   = $data["ezfc_element"];
			$ref_id         = $data["ref_id"];
			$woo_product_id = isset($data["woo_product_id"]) ? $data["woo_product_id"] : 0;
		}

		$raw_values = array();
		foreach ($element_data as $fe_id => $value) {
			$raw_values[$fe_id] = $value;
		}

		$this->submission_data = array(
			"elements"       => $this->array_index_key($this->elements_get(), "id"),
			"form_elements"  => $this->array_index_key($this->form_elements_get($id), "id"),
			"form_id"        => $id,
			"options"        => $this->form_get_option_values($id),
			"raw_values"     => $raw_values,
			"ref_id"         => $ref_id,
			"force_paypal"   => $force_paypal,
			"woo_product_id" => $woo_product_id
		);

		return $this->submission_data;
	}

	/**
		insert submission
	**/
	public function insert($id, $data, $ref_id, $send_mail=true, $payment=array()) {
		if (!$id || !$data || !$this->submission_data) return $this->send_message("error", __("No ID or no data.", "ezfc"));

		if (count($payment) < 1) {
			$payment = array(
				"id"             => 0,
				"token"          => "",
				"transaction_id" => 0
			);
		}

		// spam protection
		$spam_time = $this->submission_data["options"]["spam_time"];
		$spam = $this->wpdb->get_row($this->wpdb->prepare(
			"SELECT 1 FROM {$this->tables["submissions"]} WHERE ip='%s' AND date>=DATE_ADD(NOW(), INTERVAL -{$spam_time} SECOND)",
			$_SERVER["REMOTE_ADDR"]
		));

		if ($spam) {
			return $this->send_message("error", __("Spam protection: you need to wait {$spam_time} seconds before you can submit anything.", "ezfc"));
		}

		$this->debug("Add submission to database start: id={$id}, send_mail={$send_mail}");

		// check for user mail address + create extension list
		$extension_list = array();
		$user_mail = "";
		foreach ($data as $fe_id => $value) {
			// email check
			if (strpos($fe_id, "email_check") !== false) continue;

			// element could not be found
			if (!isset($this->submission_data["form_elements"][$fe_id])) {
				return $this->send_message("error", __("Element could not be found.", "ezfc"));
			}

			$element      = $this->submission_data["form_elements"][$fe_id];
			$element_data = json_decode($element->data);

			if (property_exists($element_data, "use_address") && $element_data->use_address == 1) {
				$user_mail = $this->submission_data["raw_values"][$fe_id];
				$this->debug("User email address found: {$user_mail}");
			}

			if (!empty($element_data->extension)) {
				$extension_list[] = array(
					"form_element"      => $element,
					"form_element_data" => $element_data,
					"raw_value"         => $this->submission_data["raw_values"][$fe_id]
				);
			}
		}

		// mail output
		$output_data = $this->get_mail_output($this->submission_data);

		// check minimum value
		if (isset($this->submission_data["options"]["min_submit_value"]) && (float) $output_data["total"] < (float) $this->submission_data["options"]["min_submit_value"]) {
			$min_submit_value_text = sprintf($this->submission_data["options"]["min_submit_value_text"], $this->submission_data["options"]["min_submit_value"]);

			return $this->send_message("error", $min_submit_value_text);
		}

		// woo add to cart
		$add_to_cart = get_option("ezfc_woocommerce", 0) == 1 && $this->submission_data["options"]["woo_disable_form"] == 0;
		$insert_id   = 0;

		/**
			* hook: before submission
			* @param int $form_id ID of this form
		**/
		do_action("ezfc_before_submission", $id);

		if (!$add_to_cart) {
			// insert into db
			$res = $this->wpdb->insert(
				$this->tables["submissions"],
				array(
					"f_id"           => $id,
					"data"           => json_encode($data),
					"content"        => $output_data["result"],
					"ip"             => $_SERVER["REMOTE_ADDR"],
					"ref_id"         => $ref_id,
					"total"          => $output_data["total"],
					"payment_id"     => $payment["id"],
					"transaction_id" => $payment["transaction_id"],
					"token"          => $payment["token"],
					"user_mail"      => $user_mail
				),
				array(
					"%d",
					"%s",
					"%s",
					"%s",
					"%s",
					"%f",
					"%d",
					"%s",
					"%s",
					"%s"
				)
			);

			$insert_id = $this->wpdb->insert_id;

			if (!$res) return $this->send_message("error", __("Submission failed.", "ezfc"));
			$this->debug("Successfully added submission to db: id={$insert_id}");
		}

		// put submission id into submission data
		$this->submission_data["submission_id"] = $insert_id;

		// replace special {{id}} placeholder
		$output_data["user"]  = str_replace("{{id}}", $insert_id, $output_data["user"]);
		$output_data["admin"] = str_replace("{{id}}", $insert_id, $output_data["admin"]);

		// mailchimp integration
		if ($this->submission_data["options"]["mailchimp_add"] == 1) {
			// load mailchimp api wrapper
			require_once(dirname( __FILE__ ) . "/lib/mailchimp/MailChimp.php");
			$mailchimp_api_key = get_option("ezfc_mailchimp_api_key", -1);

			if (!empty($mailchimp_api_key) && $mailchimp_api_key != -1) {
				$mailchimp = new Drewm_MailChimp($mailchimp_api_key);
				$mres = $mailchimp->call("lists/subscribe", array(
					"id"    => $this->submission_data["options"]["mailchimp_list"],
					"email" => array("email" => $user_mail)
				));

				if (!$mres) {
					$this->debug("Unable to add email address to MailChimp list.");
				}
				else {
					$this->debug("Email address added to MailChimp list id={$this->submission_data["options"]["mailchimp_list"]}");
				}
			}
		}
		// mailpoet integration
		if ($this->submission_data["options"]["mailpoet_add"] == 1) {
			if (!class_exists("WYSIJA")) {
				$this->debug("Mailpoet class does not exist.");
			}
			else {
				$mailpoet_userdata   = array("email" => $user_mail);
				$mailpoet_subscriber = array(
					"user" => $mailpoet_userdata,
					"user_list" => array(
						"list_ids" => array($this->submission_data["options"]["mailpoet_list"])
					)
				);

				$mailpoet_helper = WYSIJA::get("user", "helper");
				$mres = $mailpoet_helper->addSubscriber($mailpoet_subscriber);

				if (!$mres) {
					$this->debug("Unable to add email address to mailpoet list.");
				}
				else {
					$this->debug("Email address added to mailpoet list id={$this->submission_data["options"]["mailpoet_list"]}");
				}
			}
		}

		// add to cart
		if ($add_to_cart) {
			$this->debug("Adding submission to WooCommerce cart...");

			// this is required as anonymous users cannot add an ezfc product to the cart
			if (!WC()->session->has_session()) {
				WC()->session->set_customer_session_cookie(true);
				$this->debug("WC session could not be found -> set customer session cookie");
			}

			// get product ID from form post data (automatically added)
			if (empty($this->submission_data["options"]["woo_product_id"])) {
				$product_id = $this->submission_data["woo_product_id"];
			}
			// get product ID from form options
			else {
				$product_id = $this->submission_data["options"]["woo_product_id"];
			}

			// show full details, simple or values only in checkout page
			$output_details = get_option("ezfc_woocommerce_checkout_details_values", "result");

			$cart_item_key = WC()->instance()->cart->add_to_cart($product_id, 1, 0, array(), array(
				"ezfc_total"  => $output_data["total"],
				"ezfc_values" => $output_data[$output_details]
			));

			if (!$cart_item_key) {
				return $this->send_message("error", sprintf(__("Unable to add product #%s to the cart.", "ezfc"), $product_id));
			}
			
			$this->debug("Submission added to the cart successfully: cart_item_key={$cart_item_key}");
			return $this->send_message("success", get_option("ezfc_woocommerce_text"));
		}

		if ($send_mail) {
			$this->send_mails(false, $output_data, $user_mail);
		}

		/**
			* @hook submission successful
			* @param int $submission_id The ID of this submission
			* @param float $total The total
			* @param string $user_email User email address (if any)
			* @param int $form_id The ID of this form
		**/
		do_action("ezfc_after_submission", $insert_id, $output_data["total"], $user_mail, $id);

		// extension actions after submission
		foreach ($extension_list as $extension) {
			do_action("ezfc_after_submission_ext_{$extension["form_element_data"]->extension}", $insert_id, $extension["form_element"], $extension["form_element_data"], $extension["raw_value"]);
		}

		return $this->send_message("success", $this->submission_data["options"]["success_text"]);
	}

	/**
		get email output
	**/
	public function get_mail_output($submission_data, $summary=false) {
		$currency   = $submission_data["options"]["currency"];
		$total      = 0;
		$out        = array();
		$out_simple = array();
		$out_values = array();

		// output prefix
		$out_pre = "<html><head><meta charset='utf-8' /></head><body>";

		// output suffix
		$out_suf = "</body></html>";

		// result output
		$out[] = "<table class='ezfc-summary-table'>";
		$out_simple[] = "<table class='ezfc-summary-table'>";
		$out_values[] = "<table class='ezfc-summary-table'>";

		$i     = 0;
		$total = 0;
		foreach ($submission_data["form_elements"] as $fe_id => $element) {
			$element_data = json_decode($element->data);

			// skip email double check
			if (property_exists($element_data, "email_check") && $element_data->email_check == 1) continue;

			// only continue if submitted value exists
			if (!isset($submission_data["raw_values"][$fe_id])) continue;

			$value = $submission_data["raw_values"][$fe_id];

			// skip hidden values
			if ($value == "__HIDDEN__") continue;

			// hack for older extension versions
			if (!empty($element_data->extension)) {
				$element_data->e_id = $element_data->extension;
			}

			// Show HTML elements if needed
			if ($submission_data["elements"][$element_data->e_id]->type == "html") {
				// skip html elements since it is disabled in the form options
				if ($this->submission_data["options"]["email_show_html_elements"] == 0) continue;
			
				$value = $element_data->html;
			}
			// post content
			else if ($submission_data["elements"][$element_data->e_id]->type == "post") {
				if ($element_data->post_id == 0) continue;

				$post = get_post($element_data->post_id);
				$value = $this->apply_content_filter($post->post_content);
			}

			$tmp_out = $this->get_element_output($fe_id, $value, $i, $total);
			$i++;

			// check if element exists (e.g. skip email confirmation)
			if (!isset($submission_data["form_elements"][$fe_id])) continue;

			$form_element_data = json_decode($submission_data["form_elements"][$fe_id]->data);
			if (property_exists($form_element_data, "show_in_email") && $form_element_data->show_in_email == "1") {
				$out[] = $tmp_out["output"];

				if (isset($tmp_out["output_simple"])) {
					$out_simple[] = $tmp_out["output_simple"];
				}
				if (isset($tmp_out["output_values"])) {
					$out_values[] = $tmp_out["output_values"];
				}
			}
			
			if ($tmp_out["override"]) $total  = $tmp_out["total"];
			else                      $total += $tmp_out["total"];
		}

		// show total price in email or not
		if ($submission_data["options"]["email_show_total_price"] == 1) {
			$total_text         = isset($submission_data["options"]["email_total_price_text"]) ? $submission_data["options"]["email_total_price_text"] : __("Total", "ezfc");
			$summary_bg_color   = empty($submission_data["options"]["css_summary_total_background"]["color"]) ? "#eee" : $submission_data["options"]["css_summary_total_background"]["color"];
			$summary_text_color = empty($submission_data["options"]["css_summary_total_color"]["color"]) ? "#000" : $submission_data["options"]["css_summary_total_color"]["color"];

			$summary_padding = "5px";
			if (is_array($submission_data["options"]["css_summary_table_padding"]) && $submission_data["options"]["css_summary_table_padding"]["value"] != "") {
				$summary_padding = $submission_data["options"]["css_summary_table_padding"]["value"] . $submission_data["options"]["css_summary_table_padding"]["unit"];
			}

			$price_output  = "<tr class='ezfc-summary-table-total' style='background-color: {$summary_bg_color}; color: {$summary_text_color}; font-weight: bold;'>";
			$price_output .= "	<td style='padding: {$summary_padding};' colspan='2'>" . $total_text . "</td>";
			$price_output .= "	<td style='padding: {$summary_padding}; text-align: right;'>" .  $this->number_format($total) . "</td>";
			$price_output .= "</tr>";

			$price_output_values  = "<tr class='ezfc-summary-table-total' style='background-color: {$summary_bg_color}; color: {$summary_text_color}; font-weight: bold;'>";
			$price_output_values .= "	<td style='padding: {$summary_padding};'>" . $total_text . "</td>";
			$price_output_values .= "	<td style='padding: {$summary_padding}; text-align: right;'>" .  $this->number_format($total) . "</td>";
			$price_output_values .= "</tr>";

			$out[]        = $price_output;
			$out_simple[] = $price_output;
			$out_values[] = $price_output_values;
		}

		$out[] = "</table>";
		$out_simple[] = "</table>";
		$out_values[] = "</table>";

		// summary
		if ($summary) return implode("", $out_values);

		// implode content
		$result_content        = implode("", $out);
		$result_simple_content = implode("", $out_simple);
		$result_values_content = implode("", $out_values);

		// put email text into vars
		$mail_content_replace = $submission_data["options"]["email_text"];
		if ($submission_data["options"]["pp_enabled"] == 1 || $submission_data["force_paypal"]) {
			$mail_content_replace = $submission_data["options"]["email_text_pp"];
		}

		$mail_admin_content_replace = $submission_data["options"]["email_admin_text"];

		// get uploaded files
		$files        = $this->form_get_submission_files($submission_data["ref_id"]);
		$files_output = "";
		$files_raw    = array();

		if (count($files) > 0) {
			$files_output = "<p>Files</p>";

			foreach ($files as $file) {
				$filename      = basename($file->file);
				$files_output .= "<p><a href='{$file->url}' target='_blank'>{$filename}</a></p>";
				$files_raw[]   = $file->file;
			}
		}

		// replace placeholders with form values
		foreach ($submission_data["form_elements"] as $fe_id => $fe) {
			$fe_data = json_decode($submission_data["form_elements"][$fe_id]->data);

			if (!isset($submission_data["raw_values"][$fe_id])) {
				$value_to_replace = "";
			}
			else {
				$value_to_replace = $this->get_text_from_input($fe_data, $submission_data["raw_values"][$fe_id], $fe_id);
			}

			$mail_content_replace       = str_ireplace("{{" . $fe_data->name . "}}", $value_to_replace, $mail_content_replace);
			$mail_admin_content_replace = str_ireplace("{{" . $fe_data->name . "}}", $value_to_replace, $mail_admin_content_replace);
		}

		// replace other values
		$replaces = array(
			"date"          => date_i18n( get_option( 'date_format' ), time() ),
			"files"         => $files_output,
			"form_id"       => $this->submission_data["form_id"],
			"result"        => $result_content,
			"result_simple" => $result_simple_content,
			"result_values" => $result_values_content,
			"time"          => date_i18n( get_option( 'time_format' ), time() ),
			"total"         => $this->number_format($total)
		);

		foreach ($replaces as $replace => $replace_value) {
			$mail_content_replace       = str_ireplace("{{" . $replace . "}}", $replace_value, $mail_content_replace);
			$mail_admin_content_replace = str_ireplace("{{" . $replace . "}}", $replace_value, $mail_admin_content_replace);
		}

		// put together email contents for user
		$mail_content  = $out_pre;
		$mail_content .= $mail_content_replace;
		$mail_content .= $out_suf;

		// put together email contents for admin
		$mail_admin_content  = $out_pre;
		$mail_admin_content .= $mail_admin_content_replace;
		$mail_admin_content .= $out_suf;

		return array(
			"user"          => $mail_content,
			"admin"         => $mail_admin_content,
			"files"         => $files_raw,
			"result"        => $result_content,
			"result_simple" => $result_simple_content,
			"result_values" => $result_values_content,
			"total"         => $total
		);
	}


	/**
		get formatted output text from submitted data
	**/
	public function get_text_from_input($element_data, $value, $fe_id) {
		// extension
		if (!empty($element_data->extension)) {
			$extension_settings = apply_filters("ezfc_get_extension_settings_{$element_data->extension}", null);
			$element_type = $extension_settings["type"];
		}
		// inbuilt element
		else {
			$element_type = $this->submission_data["elements"][$element_data->e_id]->type;
		}
		
		// return value
		$return = false;

		switch ($element_type) {
			case "custom_calculation":
			case "hidden":
			case "numbers":
			case "subtotal":
			case "set":
				$return = $this->number_format($this->submission_data["raw_values"][$fe_id], $element_data);
			break;

			case "checkbox":
				$element_values = $element_data->options;
				$return         = array();

				foreach ($value as $chk_i => $chk_value) {
					// skip hidden field by conditional logic
					if (strpos($chk_value, "__HIDDEN__") !== false) continue;

					// value was not found -> user probably changed it
					if (!isset($element_values[$chk_value])) {
						$return[] = $chk_value . "<br>" . __("Value '{$chk_value}' was not found. Either the user changed it manually or the value was changed otherwise in the meantime.", "ezfc");
					}
					// value found! we are happy!
					else {
						$return[] = esc_html($element_values[$chk_value]->text);
					}
				}
			break;

			case "dropdown":
			case "radio":
			case "payment":
				$element_values = $element_data->options;

				// value was not found -> user probably changed it
				if (!isset($element_values[$value])) {
					$return = $value . "<br>" . __("Value '{$value}' was not found. Either the user changed it manually or the value was changed otherwise in the meantime.", "ezfc");
				}
				// value found! we are happy!
				else {
					$return = esc_html($element_values[$value]->text);
				}
			break;

			case "daterange":
				$placeholder = explode(";;", $element_data->placeholder);
				$placeholder_values = array(
					isset($placeholder[0]) ? $placeholder[0] : __("From", "ezfc"),
					isset($placeholder[1]) ? $placeholder[1] : __("To", "ezfc")
				);

				$return  = $placeholder_values[0] . ": " . $this->submission_data["raw_values"][$fe_id][0] . "<br>";
				$return .= $placeholder_values[1] . ": " . $this->submission_data["raw_values"][$fe_id][1];
			break;

			case "email":
				$return = "<a href='mailto:{$value}'>{$value}</a>";
			break;

			case "html":
				$return = $this->apply_content_filter($element_data->html);
			break;

			case "colorpicker":
				$color = $this->submission_data["raw_values"][$fe_id];
				$return = "{$color}<br><br><div style='width: 100%; height: 50px; background-color: {$color}'></div>";
			break;

			case "post":
				if ($element_data->post_id == 0) return;

				$post = get_post($element_data->post_id);
				$return = $this->apply_content_filter($post->post_content);
			break;

			// no action
			case "hr":
			case "recaptcha":
			case "stepstart":
			case "stepend":
			break;

			default:
				$return = $this->submission_data["raw_values"][$fe_id];
			break;
		}

		// checkbox
		if (is_array($return)) {
			return implode(", ", $return);
		}

		return $return;
	}

	/**
		get email output from form elements
	**/
	public function get_element_output($fe_id, $value, $even=1, $total_loop=0) {
		$element = json_decode($this->submission_data["form_elements"][$fe_id]->data);

		if (!is_array($value)) {
			// skip email double check
			if (strpos($fe_id, "email_check") !== false) return array("output" => "", "output_simple" => "", "total" => 0, "override" => false);

			// skip hidden field by conditional logic
			if (strpos($value, "__HIDDEN__") !== false && empty($element->calculate_when_hidden)) return array("output" => "", "output_simple" => "", "total" => 0, "override" => false);
		}

		$currency         = $this->submission_data["options"]["currency"];
		$discount_total   = 0;
		$el_out           = array();
		$el_out_simple    = array();
		$el_out_values    = array();
		$is_extension     = false;
		$price_override   = false;
		$simple_value     = "";
		$total            = 0;
		$total_out        = array();
		$value_out        = array();

		// check for extension
		if (!empty($element->extension)) {
			$extension_settings = apply_filters("ezfc_get_extension_settings_{$element->extension}", null);
			$element_type = $extension_settings["type"];
			$is_extension = true;
		}
		// inbuilt element
		else {
			$element_type = $this->submission_data["elements"][$element->e_id]->type;
		}

		$element_values = property_exists($element, "value") ? $element->value : "";

		// these operators do not need any target or value
		$operator_no_check = array("ceil", "floor", "round");

		// get output text
		$tmp_out = $this->get_text_from_input($element, $value, $fe_id);
		if ($tmp_out !== false) {
			$value_out[] = $tmp_out;
		}

		if (property_exists($element, "calculate_enabled") && $element->calculate_enabled == 1) {
			// support for older versions
			if (!is_array($value)) $value = array($value);

			// counter value for dateranges so the calculating info will not be displayed twice
			$daterange_counter = 0;
			// checkboxes need their own total price counter in simple result table
			$total_simple = 0;

			foreach ($value as $n => $input_value) {
				// skip second daterange input value
				if ($element_type == "daterange" && $daterange_counter%2==1) continue;

				// total price
				$tmp_total = (double) $this->get_target_value_from_input($fe_id, $input_value, $total_loop);

				// increase element price counter
				if ($element_type == "checkbox") {
					$total_simple += $tmp_total;
				}

				// price details output
				$tmp_total_out = array();
				// show price for current element
				$show_price = true;

				// calculate value * factor
				if (property_exists($element, "factor") && $value) {
					if (empty($element->factor) || !is_numeric($element->factor)) $element->factor = 1;

					// special calculation for daterange element
					if ($element_type == "daterange") {
						$datepicker_format = $this->submission_data["options"]["datepicker_format"];
						$days = Ezfc_Functions::count_days_format($datepicker_format, $value[0], $value[1]);

						$tmp_total = (double) $days * $element->factor;
						$tmp_total_out[] = "= {$days} " . __("day(s)", "ezfc");

						$show_price = false;
						$daterange_counter++;
					}
					else {
						$tmp_total = (double) $input_value * $element->factor;
						$tmp_total_out[] = "{$input_value} * {$element->factor}";
					}
				}

				// custom calculations
				if (!empty($element->calculate)) {
					foreach ($element->calculate as $calc_index => $calc_array) {
						$is_single_operator = in_array($calc_array->operator, $operator_no_check);

						// skip in case of invalid calculation data
						if ($calc_array->operator == "0" || (!$is_single_operator && ($calc_array->target == "0" && empty($calc_array->value)))) continue;

						$use_target_value   = $calc_array->target!="0";
						$use_custom_value   = (!$use_target_value && !empty($calc_array->value));

						// check if target element exists (only when a target was selected)
						if ($use_target_value && !$use_custom_value && !isset($this->submission_data["form_elements"][$calc_array->target])) {
							$tmp_total = 0;
							$tmp_total_out[] = __("No target found:", "ezfc") . $calc_array->target;
						}

						if ($use_target_value || $use_custom_value || $is_single_operator) {
							// use value from target element
							if ($use_target_value) {
								if (isset($this->submission_data["raw_values"][$calc_array->target])) {
									$target_value = $this->get_target_value_from_input($calc_array->target, $this->submission_data["raw_values"][$calc_array->target], $total_loop);
								}
								else {
									$target_value = 0;
								}
							}
							// use custom value
							else {
								$target_value = $calc_array->value;
							}

							// conditionally hidden
							if ($target_value === false) {
								//$tmp_total_out[] = "Target value was hidden";
								continue;
							}

							if ($calc_index == 0 && $element_type == "subtotal") {
								$tmp_total = $total_loop;
							}

							switch ($calc_array->operator) {
								case "add":
									$tmp_total_out[] = "+ {$target_value}";
									$tmp_total       = (double) $tmp_total + $target_value;
								break;

								case "subtract":
									$tmp_total_out[] = "- {$target_value}";
									$tmp_total       = (double) $tmp_total - $target_value;
								break;

								case "multiply":
									$tmp_total_out[] = "* {$target_value}";
									$tmp_total       = (double) $tmp_total * $target_value;
								break;

								case "divide":
									if ($target_value == 0) {
										$tmp_total = 0;
										$tmp_total_out[] = __("Cannot divide by target factor 0", "ezfc");
									}
									else {
										if (property_exists($element, "calculate_before") && $element->calculate_before == "1") {
											$tmp_total_out[] = "{$target_value} / {$tmp_total}";
											$tmp_total       = $target_value / (double) $tmp_total;
										}
										else {
											$tmp_total_out[] = "{$tmp_total} / {$target_value}";
											$tmp_total       = (double) $tmp_total / $target_value;
										}
									}
								break;

								case "equals":
									if (property_exists($this->submission_data["form_elements"][$calc_array->target], "factor")) {
										$target_factor   = $this->submission_data["form_elements"][$calc_array->target]->factor;
										$tmp_total_out[] = "= {$target_factor} * {$currency} {$target_value}";
										$tmp_total       = (double) $target_factor * $target_value;
									}
									else {
										$tmp_total_out[] = "= {$target_value}";	
										$tmp_total       = (double) $target_value;
									}
								break;

								case "power":
									$tmp_total_out[] = "{$tmp_total} ^ {$target_value}";
									$tmp_total       = pow((double) $tmp_total, $target_value);
								break;

								case "ceil":
									$tmp_total_out[] = "ceil({$tmp_total})";
									$tmp_total       = ceil($tmp_total);
								break;

								case "floor":
									$tmp_total_out[] = "floor({$tmp_total})";
									$tmp_total       = floor($tmp_total);
								break;

								case "round":
									$tmp_total_out[] = "round({$tmp_total})";
									$tmp_total       = round($tmp_total);
								break;

								case "subtotal":
									$tmp_total_out[] = "subtotal = {$total_loop}";
									$tmp_total       = $total_loop;
								break;

								case "log":
									$tmp_total_out[] = "log({$target_value})";
									$tmp_total       = log($target_value);
								break;
								case "log2":
									$tmp_total_out[] = "log2({$target_value})";
									$tmp_total       = (log10($target_value) / log10(2));
								break;
								case "log10":
									$tmp_total_out[] = "log10({$target_value})";
									$tmp_total       = log10($target_value);
								break;
							}
						}
					}
				}

				// add element value to total value
				if (property_exists($element, "overwrite_price") && (int) $element->overwrite_price == 1) {
					$price_override = true;
					$total          = $tmp_total;

					$tmp_total_out[] = "<strong>" . __("Price override", "ezfc") . "</strong>";
				}
				else {
					$total += $tmp_total;
				}

				// discount
				// changed since v2.9.1.0:
				// ... && $element_type != "subtotal"
				if (property_exists($element, "discount") && count($element->discount) > 0 && $element->overwrite_price == "subtotal") {
					foreach ($element->discount as $discount) {
						// check if operator is empty
						if (empty($discount->operator)) continue;

						// if fields are left blank, set min/max to infinity
						if (!$discount->range_min && $discount->range_min !== 0) $discount->range_min = -INF;
						if (!$discount->range_max && $discount->range_max !== 0) $discount->range_max = INF;

						if ($tmp_total >= $discount->range_min && $tmp_total <= $discount->range_max) {
							$discount->value = (float) $discount->discount_value;
							$add_to_total = true;

							switch ($discount->operator) {
								case "add":
									$tmp_total_out[] = __("Discount:") . " + " . $this->number_format($discount->discount_value, $element, true);
									$discount_total  = $discount->discount_value;
								break;

								case "subtract":
									$tmp_total_out[] = __("Discount:") . " - " . $this->number_format($discount->discount_value, $element, true);
									$discount_total  = -$discount->discount_value;
								break;

								case "percent_add":
									$tmp_total_out[] = __("Discount:") . " +{$discount->discount_value}%";
									$discount_total  = $tmp_total * ($discount->discount_value / 100);
								break;

								case "percent_sub":
									$tmp_total_out[] = __("Discount:") . " -{$discount->discount_value}%";
									$discount_total  = -($tmp_total * ($discount->discount_value / 100));
								break;

								case "equals":
									$tmp_total_out[] = __("Discount:") . " = " . $this->number_format($discount->discount_value, $element, true);

									// overwrite temporary price here
									$add_to_total   = false;
									$discount_total = 0;

									$total     = $total - $tmp_total + $discount->discount_value;
									$tmp_total = $discount->discount_value;
								break;
							}

							if ($add_to_total) {
								$tmp_total += $discount_total;
								$total     += $discount_total;
							}
						}
					}
				}

				// build string for output
				if ($show_price) {
					$value_out_str = !$tmp_total ? "-" : $this->number_format($tmp_total, $element);

					if ($tmp_total_out) {
						$value_out_str = implode("<br>", $tmp_total_out) . "<br>= {$value_out_str}";
					}
				}
				else {
					$value_out_str = implode("<br>", $tmp_total_out);
				}

				$total_out[] = $value_out_str;

				if ($element_type == "checkbox") {
					$simple_value = !$tmp_total ? "-" : $this->number_format($total_simple, $element);
				}
				// simply use the last element of array output
				else {
					//$last_value   = end((array_values($tmp_total_out)));
					$simple_value = $this->number_format($tmp_total, $element);
				}
			}
		}

		if ($is_extension) {
			$ext_total_out = apply_filters("ezfc_ext_frontend_submission_output_{$extension_settings["id"]}", $total_out, $element, $input_value, $total_loop);
			$ext_total_out = $this->number_format($ext_total_out);
			$total_out     = array($ext_total_out);

			$total = apply_filters("ezfc_ext_frontend_submission_value_{$extension_settings["id"]}", $total, $element, $input_value, $total_loop);
		}

		// background colors
		$color_even = empty($this->submission_data["options"]["css_summary_bgcolor_even"]["color"]) ? "#fff" : $this->submission_data["options"]["css_summary_bgcolor_even"]["color"];
		$color_odd  = empty($this->submission_data["options"]["css_summary_bgcolor_odd"]["color"]) ? "#efefef" : $this->submission_data["options"]["css_summary_bgcolor_odd"]["color"];

		$summary_padding = "5px";
		if (is_array($this->submission_data["options"]["css_summary_table_padding"]) && $this->submission_data["options"]["css_summary_table_padding"]["value"] != "") {
			$summary_padding = $this->submission_data["options"]["css_summary_table_padding"]["value"] . $this->submission_data["options"]["css_summary_table_padding"]["unit"];
		}
		
		$tr_bg = $even%2==1 ? $color_even : $color_odd;

		// detailed
		$el_out[] = "<tr style='background-color: {$tr_bg};'>";
		$el_out[] = "	<td style='padding: {$summary_padding}; vertical-align: top;'>{$element->name}</td>";
		$el_out[] = "	<td style='padding: {$summary_padding}; vertical-align: top;'>" . implode("<hr style='border: 0; border-bottom: #ccc 1px solid;' />", $value_out) . "</td>";
		$el_out[] = "	<td style='padding: {$summary_padding}; vertical-align: top; text-align: right; width: 150px;'>" . implode("<hr style='border: 0; border-bottom: #ccc 1px solid;' />", $total_out) . "</td>";
		$el_out[] = "</tr>";

		// simple
		$el_out_simple[] = "<tr style='background-color: {$tr_bg};'>";
		$el_out_simple[] = "	<td style='padding: {$summary_padding}; vertical-align: top;'>{$element->name}</td>";
		$el_out_simple[] = "	<td style='padding: {$summary_padding}; vertical-align: top;'>" . implode("<hr style='border: 0; border-bottom: #ccc 1px solid;' />", $value_out) . "</td>";
		$el_out_simple[] = "	<td style='padding: {$summary_padding}; vertical-align: top; text-align: right; width: 150px;'>" . $simple_value . "</td>";
		$el_out_simple[] = "</tr>";

		// values only
		$el_out_values[] = "<tr style='background-color: {$tr_bg};'>";
		$el_out_values[] = "	<td style='padding: {$summary_padding}; vertical-align: top;'>{$element->name}</td>";
		$el_out_values[] = "	<td style='padding: {$summary_padding}; vertical-align: top; text-align: right;'>" . implode("<hr style='border: 0; border-bottom: #ccc 1px solid;' />", $value_out) . "</td>";
		$el_out_values[] = "</tr>";

		return array(
			"output"        => implode("", $el_out),
			"output_simple" => implode("", $el_out_simple),
			"output_values" => implode("", $el_out_values),
			"total"         => $total,
			"override"      => $price_override
		);
	}

	public function number_format($number, $element_data = null, $force_format = false) {
		if ((empty($number) && $number != 0) || !is_numeric($number)) return;

		$decimal_numbers = get_option("ezfc_email_price_format_dec_num", 2);
		
		// check if element value should be returned plain
		if ($element_data && !$force_format) {
			if (!property_exists($element_data, "is_currency") ||
				(property_exists($element_data, "is_currency") && $element_data->is_currency == 0)) {

				if (property_exists($element_data, "precision") && $element_data->precision != "") {
					$decimal_numbers = $element_data->precision;
				}

				$number_formatted = number_format(
					$number,
					$decimal_numbers,
					get_option("ezfc_email_price_format_dec_point", "."),
					get_option("ezfc_email_price_format_thousand", ",")
				);

				return apply_filters("ezfc_number_format_nocurrency", $number_formatted, $number, $element_data);
			}
		}

		$currency = $this->submission_data["options"]["currency"];
		$currency_position = $this->submission_data["options"]["currency_position"];

		// todo
		$number_formatted = number_format(
			$number,
			$decimal_numbers,
			get_option("ezfc_email_price_format_dec_point", "."),
			get_option("ezfc_email_price_format_thousand", ",")
		);

		$number_return = "";
		if ($currency_position == 0) {
			$number_return = "{$currency} {$number_formatted}";
		}
		else {
			$number_return = "{$number_formatted} {$currency}";
		}

		return apply_filters("ezfc_number_format", $number_return, $number, $element_data, $force_format);
	}

	public function get_target_value_from_input($target_id, $input_value, $total_loop=0) {
		if (!isset($this->submission_data["form_elements"][$target_id])) return false;

		$target    = $this->submission_data["form_elements"][$target_id];
		$value     = 0;
		$raw_value = $this->submission_data["raw_values"][$target_id];
		$data      = json_decode($target->data);

		if (!empty($data->extension)) {
			$element = $data->extension;
		}
		else {
			$element = $this->submission_data["elements"][$target->e_id]->type;
		}

		if (property_exists($data, "options") && is_array($data->options)) {
			// checkboxes
			if (is_array($input_value)) {
				// wtf?
				if (count($input_value) < 1) return 0;

				// iterate through all checkboxes
				$checkbox_total = 0;
				foreach ($input_value as $i => $checkbox_value) {
					// checkbox index was not found
					if (!array_key_exists($i, $data->options)) return 0;

					$checkbox_total += (float) $data->options[$i]->value;
				}

				return $checkbox_total;
			}
			
			if (!array_key_exists($input_value, $data->options)) return false;
			if (!property_exists($data->options[$input_value], "value")) return false;

			$value = $data->options[$input_value]->value;
		}
		else if ($element == "daterange") {
			$datepicker_format = $this->submission_data["options"]["datepicker_format"];

			if (isset($input_value[0]) && isset($input_value[1])) {
				$days = Ezfc_Functions::count_days_format($datepicker_format, $input_value[0], $input_value[1]);
				
				$value = $days;
				if (property_exists($data, "factor") && $data->factor && $data->factor !== 0) {
					$value *= $data->factor;
				}
			}
			else {
				$value = 0;
			}
		}
		else {
			$value = $raw_value;

			// check for percent calculation
			if (strstr($value, "%")) {
				$value_pct = ((double) $value) / 100;
				$value     = $total_loop * $value_pct;
			}
			else if (property_exists($data, "factor") && $data->factor && $data->factor !== 0) {
				$value *= $data->factor;
			}
		}

		// conditionally hidden
		if (!is_array($raw_value) && strpos($raw_value, "__HIDDEN__") !== false && empty($data->calculate_when_hidden)) return false;

		return $value;
	}

	/**
		calculates total value from submitted data
	**/
	public function get_total($data) {
		$total = 0;

		foreach ($data as $fe_id => $value) {
			$tmp_out = $this->get_element_output($fe_id, $value, null, $total);
			$total  += $tmp_out["total"];

			if ($tmp_out["override"]) $total = $tmp_out["total"];
		}

		return $total;
	}

	/**
		send mails
	**/
	public function send_mails($submission_id, $custom_mail_output=false, $user_mail=false) {
		$this->debug("Preparing to send mail(s)...");

		// generate email content from submission
		// use $this->prepare_submission_data() first!
		if ($submission_id != false) {
			$submission = $this->submission_get($submission_id);
			$user_mail  = $submission->user_mail;

			$mail_output = $this->get_mail_output($this->submission_data);
		}
		// send emails later
		else if ($custom_mail_output != false) {
			$mail_output = $custom_mail_output;
		}

		$this->debug("Target email: $user_mail");

		// use smtp
		$use_smtp = get_option("ezfc_email_smtp_enabled")==1 ? true : false;
		if ($use_smtp) {
			$this->smtp_setup();
		}

		// admin mail
		if (!empty($this->submission_data["options"]["email_recipient"])) {
			$mail_admin_headers   = array();
			$mail_admin_headers[] = "Content-type: text/html";

			// sendername recipient
			if (!empty($this->submission_data["options"]["email_admin_sender_recipient"])) {
				$mail_admin_headers[] = "From: {$this->submission_data["options"]["email_admin_sender_recipient"]}";

				if ($use_smtp) {
					// Convert syntax: Name <hello@ezplugins.de>
					$mail_sendername_recipient_array = explode("<", $this->submission_data["options"]["email_admin_sender_recipient"]);
					if (count($mail_sendername_recipient_array) > 1) {
						$mail_from_address = str_replace(">", "", $mail_sendername_recipient_array[1]);

						$this->smtp->setFrom($mail_from_address, $mail_sendername_recipient_array[0]);
					}
				}
			}

			// add reply-to
			if (!empty($user_mail)) {
				$mail_admin_headers[] = "Reply-to: {$user_mail}";

				if ($use_smtp) {
					$this->smtp->addReplyTo($user_mail);
				}
			}

			// file upload attachment
			$attachment = null;
			if (!empty($this->submission_data["options"]["email_send_files_attachment"])) {
				$attachment = $mail_output["files"];
			}

			// smtp
			if ($use_smtp) {
				$this->smtp->addAddress($this->submission_data["options"]["email_recipient"]);
				$this->smtp->Subject = $this->submission_data["options"]["email_admin_subject"];
				$this->smtp->Body    = nl2br($mail_output["admin"]);

				if ($attachment) {
					foreach ($attachment as $file) {
						$this->smtp->AddAttachment($file);
					}
				}

				$res = $this->smtp->send() ? 1 : 0;
			}
			// wp mail
			else {
				$res = wp_mail(
					$this->submission_data["options"]["email_recipient"],
					$this->submission_data["options"]["email_admin_subject"],
					nl2br($mail_output["admin"]),
					$mail_admin_headers,
					$attachment
				);
			}

			$this->debug("Email delivery to admin: $res ({$this->submission_data["options"]["email_recipient"]})");
			$this->debug(var_export($mail_admin_headers, true));
		}
		else {
			$this->debug("No admin email recipient found.");
		}

		// user mail
		if ($user_mail && !empty($user_mail)) {
			$mail_subject = ($this->submission_data["options"]["pp_enabled"]==1 || $this->submission_data["force_paypal"]) ? $this->submission_data["options"]["email_subject_pp"] : $this->submission_data["options"]["email_subject"];
			$mail_from = !empty($this->submission_data["options"]["email_admin_sender"]) ? $this->submission_data["options"]["email_admin_sender"] : get_bloginfo("name");

			// headers
			$mail_headers   = array();
			$mail_headers[] = "Content-type: text/html";
			$mail_headers[] = "From: {$mail_from}";

			// smtp
			if ($use_smtp) {
				// Convert syntax: Name <hello@ezplugins.de>
				$mail_from_array = explode("<", $mail_from);
				if (count($mail_from_array) > 1) {
					$mail_from_address = str_replace(">", "", $mail_from_array[1]);

					$this->smtp->setFrom($mail_from_address, $mail_from_array[0]);
				}

				$this->smtp->addAddress($user_mail);
				$this->smtp->Subject = $mail_subject;
				$this->smtp->Body    = nl2br($mail_output["user"]);

				$res = $this->smtp->send() ? 1 : 0;
			}
			else {
				$res = wp_mail(
					$user_mail,
					$mail_subject,
					nl2br($mail_output["user"]),
					$mail_headers
				);
			}

			$this->debug("Email delivery to user: $res");
			$this->debug(var_export($mail_headers, true));
		}
		else {
			$this->debug("No user email found.");
		}
	}

	/**
		preview
	**/
	public function get_preview($id, $elements) {
		return $this->get_output($id, null, null, null, true);
	}

	/**
		output
	**/
	public function get_output($id=null, $name=null, $product_id=null, $theme=null, $preview=false) {
		if (!$id && !$name) {
			echo __("No id or name found. Correct syntax: [ezfc id='1' /] or [ezfc name='form-name' /].");
			return;
		}

		if ($id) {
			$form = $this->form_get($id);

			if (!$form) {
				echo __("No form found (ID: {$id}).", "ezfc");
				return;
			}
		}

		else if ($name) {
			$form = $this->form_get(null, $name);

			if (!$form) {
				echo __("No form found (Name: {$name}).", "ezfc");
				return;
			}
		}

		$elements = $this->elements_get();
		//$options  = $this->array_index_key($this->form_get_option_values($form->id), "name");
		$options  = $this->form_get_option_values($form->id);

		// check if recaptcha was already included / defined otherwise
		if (!class_exists("ReCaptchaResponse")) {
			require_once(EZFC_PATH . "lib/recaptcha-php-1.11/recaptchalib.php");
		}
		
		$publickey = get_option("ezfc_captcha_public");

		// frontend output
		$form_elements = $preview ? $preview : $this->form_elements_get($form->id);

		// reference id for file uploads
		$ref_id = uniqid();

		// begin output
		$html = "";

		// count all elements beforehand
		$elements_count = count($form_elements);
		// step counter
		$current_step = 0;
		// get amount of steps
		$step_count = 0;

		foreach ($form_elements as $i => $element) {
			$data = json_decode($element->data);

			// skip if extension element
			if (!empty($data->extension)) continue;
			// step counter
			if ($elements[$element->e_id]->type == "stepstart") $step_count++;
		}
		
		// additional styles
		$css_label_width = get_option("ezfc_css_form_label_width");
		$css_label_width = empty($css_label_width) ? "" : "style='width: {$css_label_width}'";
		$form_class      = isset($options["form_class"]) ? $options["form_class"] : "";
		$wrapper_class   = "";

		// override theme by shortcode
		if (empty($theme)) {
			$theme = isset($options["theme"]) ? $options["theme"] : "default";
		}

		// theme css
		$theme_file = EZFC_PATH . "themes/{$theme}.css";
		$theme_def  = EZFC_PATH . "themes/default.css";
		if (file_exists($theme_file)) {
			wp_enqueue_style("ezfc-theme-style", plugins_url("themes/{$theme}.css", __FILE__), array(), EZFC_VERSION);
		}
		else if (file_exists($theme_def)) {
			wp_enqueue_style("ezfc-theme-default", plugins_url("themes/default.css", __FILE__), array(), EZFC_VERSION);	
		}

		// global custom styling will be added from shortcode
		// form custom styling
		if ($options["load_custom_styling"] == 1) {
			wp_add_inline_style("ezfc-css-frontend", $options["css_custom_styling"]);

			// font
			if (!empty($options["css_font"])) {
				$font_name = $options["css_font"];
				wp_register_style("ezfc-font-{$font_name}", "//fonts.googleapis.com/css?family={$font_name}");
				wp_enqueue_style("ezfc-font-{$font_name}");
			}
		}

		// custom css
		$custom_css = get_option("ezfc_custom_css");
		if (!empty($custom_css)) {
			$html .= $this->remove_nl("<style type='text/css'>{$custom_css}</style>");
		}

		// check if woocommerce is used
		$use_woocommerce = 0;
		if ($options["submission_enabled"] == 1) {
			// submission / woocommerce
			if (get_option("ezfc_woocommerce", 0) == 1 && $options["woo_disable_form"] == 0) {
				$use_woocommerce = 1;
			}
		}

		// js output
		$form_options_js = json_encode(array(
			"calculate_old"             => 0,
			"clear_selected_values_hidden" => !empty($options["clear_selected_values_hidden"]) ? $options["clear_selected_values_hidden"] : 0,
			"counter_duration"          => isset($options["counter_duration"]) ? $options["counter_duration"] : 1000,
			"counter_interval"          => isset($options["counter_interval"]) ? $options["counter_interval"] : 30,
			"currency"                  => $options["currency"],
			"currency_position"         => $options["currency_position"],
			"datepicker_format"         => $options["datepicker_format"],
			"hide_all_forms"            => !empty($options["hide_all_forms"]) ? $options["hide_all_forms"] : 0,
			"price_format"              => !empty($options["price_format"]) ? $options["price_format"] : get_option("ezfc_price_format"),
			"price_position_scroll_top" => !empty($options["price_position_scroll_top"]) ? $options["price_position_scroll_top"] : 0,
			"price_requested"           => 0,
			"price_show_request_before" => !empty($options["price_show_request_before"]) ? $options["price_show_request_before"] : 0,
			"price_show_request"        => !empty($options["price_show_request"]) ? $options["price_show_request"] : 0,
			"price_show_request_text"   => !empty($options["price_show_request_text"]) ? $options["price_show_request_text"] : __("Request price", "ezfc"),
			"redirect_text"             => sprintf($options["redirect_text"], $options["redirect_timer"]),
			"redirect_timer"            => $options["redirect_timer"],
			"redirect_url"              => trim($options["redirect_url"]),
			"reset_after_submission"    => $options["reset_after_submission"],
			"submit_text"               => array(
				"default"     => $options["submit_text"],
				"paypal"      => $options["pp_submittext"],
				"summary"     => $options["summary_button_text"],
				"woocommerce" => $options["submit_text_woo"]
			),
			"summary_enabled"           => $options["summary_enabled"],
			"summary_shown"             => 0,
			"timepicker_format"         => $options["timepicker_format"],
			"use_paypal"                => $options["pp_enabled"],
			"use_woocommerce"           => $use_woocommerce
		));
		$form_options_js_output = str_replace("'", "&apos;", $form_options_js);

		$html .= "<div class='ezfc-wrapper ezfc-form-{$form->id} ezfc-theme-{$theme} {$wrapper_class}'>";
		// adding "novalidate" is essential since required fields can be hidden due to conditional logic
		$html .= "<form class='ezfc-form {$form_class}' name='ezfc-form[{$form->id}]' action='' data-id='{$form->id}' data-currency='{$options["currency"]}' data-vars='{$form_options_js_output}' novalidate>";

		// reference
		$html .= "<input type='hidden' name='id' value='{$form->id}'>";
		$html .= "<input type='hidden' name='ref_id' value='{$ref_id}'>";

		// woo product id
		if (get_option("ezfc_woocommerce_add_forms") == 1 && $product_id) {
			$html .= "<input type='hidden' name='woo_product_id' value='{$product_id}' />";
		}

		// price
		if ($options["currency_position"] == 0) {
			$price_html = "<span class='ezfc-price-currency ezfc-price-currency-before'>{$options["currency"]}</span><span class='ezfc-price-value'>0</span>";
		}
		else {
			$price_html = "<span class='ezfc-price-value'>0</span><span class='ezfc-price-currency ezfc-price-currency-after'>{$options["currency"]}</span>";
		}

		if ($options["show_price_position"] == 2 || $options["show_price_position"] == 3) {
			$html .= "<div class='ezfc-element price-box'>";
			$html .= "	<label class='ezfc-label' {$css_label_width}>" . $options["price_label"] . "</label>";
			$html .= "	<div class='ezfc-price-wrapper'>";
			$html .= "		<span class='ezfc-price'>{$price_html}</span>";
			$html .= "	</div>";
			$html .= "</div>";
		}

		foreach ($form_elements as $i => $element) {
			$element_css = "ezfc-element ezfc-custom-element";

			$data     = json_decode($element->data);
			$el_id    = "ezfc_element-{$element->id}";
			$el_name  = "ezfc_element[{$element->id}]";

			// check for extension
			if (!empty($data->extension)) {
				$extension_settings = apply_filters("ezfc_get_extension_settings_{$data->extension}", null);
				$element_css .= " ezfc-extension ezfc-extension-{$extension_settings["type"]}";
			}

			$el_type       = !empty($data->extension) ? "extension" : $elements[$element->e_id]->type;
			$el_text       = "";
			$required      = "";
			$required_char = "";
			$step          = false;
			if (property_exists($data, "required") && $data->required == 1) {
				$required = "required";

				if ($options["show_required_char"] != 0) {
					$required_char = " <span class='ezfc-required-char'>*</span>";
				}
			}

			$el_data_label = "";
			// element description
			if (!empty($data->description)) {
				$element_description = "<span class='ezfc-element-description' data-ot='" . esc_attr($data->description) . "'></span>";

				$element_description = apply_filters("ezfc_element_description", $element_description, $data->description);
				$el_data_label .= $element_description;
			}

			// trim labels
			if (property_exists($data, "label")) {
				$el_data_label .= trim(htmlspecialchars_decode($data->label));
			}

			// label
			$el_label      = "";
			$default_label = "<label class='ezfc-label' for='{$el_id}' {$css_label_width}>" . $el_data_label . "{$required_char}</label>";

			// calculate values
			$calc_enabled = 0;
			if (property_exists($data, "calculate_enabled")) {
				$calc_enabled = $data->calculate_enabled ? 1 : 0;
			}

			$calc_before = 0;
			if (property_exists($data, "calculate_before")) {
				$calc_before  = $data->calculate_before ? 1 : 0;
			}

			$data_calculate_output = array(
				"operators" => array(),
				"targets"   => array(),
				"values"    => array()
			);
			$data_add = "data-calculate_enabled='{$calc_enabled}' ";

			if (property_exists($data, "calculate") && count($data->calculate) > 0) {
				foreach ($data->calculate as $calculate) {
					$data_calculate_output["operators"][] = property_exists($calculate, "operator") ? $calculate->operator : "";
					$data_calculate_output["targets"][]   = property_exists($calculate, "target") ? $calculate->target : "";
					$data_calculate_output["values"][]    = property_exists($calculate, "value") ? $calculate->value : "";
				}

				$data_add .= "
					data-calculate_operator='" . implode(",", $data_calculate_output["operators"]) . "'
					data-calculate_target='" . implode(",", $data_calculate_output["targets"]) . "'
					data-calculate_values='" . implode(",", $data_calculate_output["values"]) . "'
					data-calculate_before='{$calc_before}'
				";
			}

			if (!empty($data->overwrite_price)) {
				$data_add .= " data-overwrite_price='{$data->overwrite_price}'";
			}

			// conditional values
			$data_conditional_output = array(
				"actions"   => array(),
				"operators" => array(),
				"targets"   => array(),
				"values"    => array(),
				"redirects"  => array()
			);

			if (property_exists($data, "conditional") && count($data->conditional) > 0) {
				foreach ($data->conditional as $conditional) {
					$data_conditional_output["actions"][]      = $conditional->action;
					$data_conditional_output["operators"][]    = $conditional->operator;
					$data_conditional_output["targets"][]      = $conditional->target;
					$data_conditional_output["values"][]       = $conditional->value;
					$data_conditional_output["target_value"][] = property_exists($conditional, "target_value") ? $conditional->target_value : "";
					$data_conditional_output["notoggle"][]     = property_exists($conditional, "notoggle") ? $conditional->notoggle : "0";
					$data_conditional_output["redirects"][]     = property_exists($conditional, "redirect") ? $conditional->redirect : "0";
				}

				$data_conditional = "
					data-conditional_action='"       . implode(",", $data_conditional_output["actions"]) . "'
					data-conditional_operator='"     . implode(",", $data_conditional_output["operators"]) . "'
					data-conditional_target='"       . implode(",", $data_conditional_output["targets"]) . "'
					data-conditional_values='"       . implode(",", $data_conditional_output["values"]) . "'
					data-conditional_target_value='" . implode(",", $data_conditional_output["target_value"]) . "'
					data-conditional_notoggle='"     . implode(",", $data_conditional_output["notoggle"]) . "'
					data-conditional_redirects='"    . implode(",", $data_conditional_output["redirects"]) . "'
				";

				$data_add .= $data_conditional;
			}

			// discount
			$data_discount_output = array(
				"range_min" => array(),
				"range_max" => array(),
				"operator"  => array(),
				"values"    => array()
			);
			$data_discount = "";

			if (property_exists($data, "discount") && count($data->discount) > 0) {
				foreach ($data->discount as $discount) {
					$data_discount_output["range_min"][]       = $discount->range_min;
					$data_discount_output["range_max"][]       = $discount->range_max;
					$data_discount_output["operator"][]        = $discount->operator;
					$data_discount_output["discount_values"][] = $discount->discount_value;
				}

				$data_discount .= "
					data-discount_range_min='" . implode(",", $data_discount_output["range_min"]) . "'
					data-discount_range_max='" . implode(",", $data_discount_output["range_max"]) . "'
					data-discount_operator='" . implode(",", $data_discount_output["operator"]) . "'
					data-discount_values='" . implode(",", $data_discount_output["discount_values"]) . "'
				";

				$data_add .= $data_discount;
			}

			// group
			if (property_exists($data, "group_id") && $data->group_id != 0 && $el_type != "group") {
				$data_add .= " data-group='{$data->group_id}'";
			}

			// set element
			$data_set_output = array();

			if (property_exists($data, "set")) {
				foreach ($data->set as $set_element) {
					$data_set_output[] = $set_element->target;
				}

				$data_add .= " data-set_elements='" . implode(",", $data_set_output) . "'";
				$data_add .= " data-set_operator='{$data->set_operator}'";
			}

			// remove all line breaks (since WP adds these here)
			$data_add = $this->remove_nl($data_add);

			// element price
			$show_price = "";

			// hidden?
			if (property_exists($data, "hidden")) {
				if ($data->hidden == 1) $element_css .= " ezfc-hidden";
				elseif ($data->hidden == 2) $element_css .= " ezfc-hidden ezfc-custom-hidden";
			}

			// factor
			$data_factor = "";
			if (property_exists($data, "factor")) $data_factor = "data-factor='{$data->factor}'";

			// external value
			$data_value_external = "";
			if (property_exists($data, "value_external")) $data_value_external = "data-value_external='{$data->value_external}'";

			// make radio buttons / checkboxes inline
			if (!empty($data->inline)) {
				$element_css .= " ezfc-inline-options";
			}

			// inline style
			$add_style = "";
			if (!empty($data->style)) {
				$add_style = "style='{$data->style}'";
			}

			if (!empty($data->icon)) {
				$el_text .= "<i class='fa {$data->icon}'></i>";
				$data->class .= " ezfc-has-icon";
			}

			// use get parameter value
			if (!empty($data->GET) && property_exists($data, "value")) {
				$data->value = isset($_GET[$data->GET]) ? $_GET[$data->GET] : $data->value;
			}

			switch ($el_type) {
				case "input":
				case "email":
					if ($options["show_element_price"] == 1 && property_exists($data, "factor")) {
						$show_price = apply_filters("ezfc_element_show_price", " <span class='ezfc-element-price'>({$options["currency"]}{$data->factor})</span>", $el_type);
					}

					$add_attr = "data-initvalue='" . esc_attr($data->value) . "'";

					$el_label .= $default_label;

					$el_text .= "<input	class='{$data->class} ezfc-element ezfc-element-input' {$data_factor} name='{$el_name}' placeholder='{$data->placeholder}' type='text' value='{$data->value}' {$add_attr} {$add_style} {$required} />{$show_price}";

					// email double-check
					if (property_exists($data, "double_check") && $data->double_check == 1) {
						$el_email_check_name = "ezfc_element[{$element->id}_email_check]";
						$el_text .= "<br><input class='{$data->class} ezfc-element ezfc-element-input' name='{$el_email_check_name}' type='text' value='{$data->value}' placeholder='{$data->placeholder}' {$add_style} {$required} /> <small>" . __("Confirmation", "ezfc") . "</small>";
					}
				break;

				case "numbers":
					if ($options["show_element_price"] == 1 && property_exists($data, "factor")) {
						$show_price = apply_filters("ezfc_element_show_price", " <span class='ezfc-element-price'>({$options["currency"]}{$data->factor})</span>", $el_type);
					}

					$el_label .= $default_label;
					$el_text_add = "";

					$add_attr = "data-min='{$data->min}' data-max='{$data->max}' data-initvalue='{$data->value}'";
					// use slider
					if (property_exists($data, "slider") && $data->slider == 1) {
						wp_enqueue_script("jquery-ui-slider");

						$steps_slider = 1;
						if (property_exists($data, "steps_slider")) $steps_slider = $data->steps_slider;

						$add_attr    .= " data-stepsslider='{$steps_slider}'";
						$data->class .= " ezfc-slider";

						$el_text_add .= "<div class='ezfc-slider-element' data-target='{$el_id}'></div>";
					}
					// use spinner
					if (property_exists($data, "spinner") && $data->spinner == 1) {
						wp_enqueue_script("jquery-ui-spinner");

						$steps_spinner = 1;
						if (property_exists($data, "steps_spinner")) $steps_spinner = $data->steps_spinner;

						$add_attr    .= " data-stepsspinner='{$steps_spinner}'";
						$data->class .= " ezfc-spinner";
					}
					// pips
					if (property_exists($data, "pips") && $data->pips > 0) {
						wp_enqueue_style("jquery-ui-slider-pips", plugins_url("assets/jquery-ui-slider-pips/css/jquery-ui-slider-pips.css", __FILE__));
						wp_enqueue_script("jquery-ui-slider-pips", plugins_url("assets/jquery-ui-slider-pips/js/jquery-ui-slider-pips.js", __FILE__), array( 'jquery-ui-slider' ), false, false);

						$steps_pips = 1;
						if (property_exists($data, "steps_pips")) $steps_pips = $data->steps_pips;

						$add_attr    .= " data-stepspips='{$steps_pips}'";
						$data->class .= " ezfc-pips";
					}

					$el_text .= "<input	class='{$data->class} ezfc-element ezfc-element-numbers' {$data_factor} name='{$el_name}' placeholder='{$data->placeholder}' type='text' value='{$data->value}' {$add_style} {$required} {$add_attr} />{$show_price}";
					$el_text .= $el_text_add;
				break;

				case "hidden":
					$add_attr = "data-initvalue='" . esc_attr($data->value) . "'";
					$el_text .= "<input class='{$data->class} ezfc-element ezfc-element-input-hidden' {$data_factor} name='{$el_name}' type='hidden' value='{$data->value}' {$add_style} {$add_attr} />";
				break;

				case "dropdown":
					$add_attr = "";

					if (!empty($data->preselect)) {
						$add_attr .= " data-initvalue='{$data->preselect}'";
					}

					$el_label .= $default_label;
					$el_text .= "<select class='{$data->class} ezfc-element ezfc-element-select' name='{$el_name}' {$add_style} {$required} {$add_attr}>";

					foreach ($data->options as $n => $option) {
						$add_data = "";
						if (property_exists($data, "preselect") && $data->preselect == $n) {
							$add_data .= " selected='selected'";
						}

						if (property_exists($option, "disabled")) {
							$add_data .= " disabled='disabled'";
						}

						if ($options["show_element_price"] == 1) {
							$show_price = apply_filters("ezfc_element_show_price", " ({$options["currency"]}{$option->value})", $el_type);
						}

						$el_text .= "<option value='{$n}' data-value='{$option->value}' data-index='{$n}' data-factor='{$option->value}' {$add_data}>{$option->text}{$show_price}</option>";
					}

					$el_text .= "</select>";
				break;

				case "radio":
				case "payment":
					$el_label .= $default_label;

					$i = 0;
					foreach ($data->options as $n => $radio) {
						$el_image = "";
						$el_wrapper_class = "";

						if (!empty($radio->image)) {
							$el_image = $radio->image;
							$el_wrapper_class .= "ezfc-element-option-has-image";
						}

						$el_text .= "<div class='ezfc-element-radio-container {$el_wrapper_class}'>";

						$radio_id = "{$el_id}-{$i}";

						$add_data = "";
						if (property_exists($data, "preselect") && $data->preselect == $i) {
							$add_data .= " checked='checked'";
							$add_data .= " data-initvalue='{$i}'";
						}

						if (property_exists($radio, "disabled")) {
							$add_data .= " disabled='disabled'";
						}

						if ($options["show_element_price"] == 1) {
							$show_price = apply_filters("ezfc_element_show_price", " <span class='ezfc-element-price'>({$options["currency"]}{$radio->value})</span>", $el_type);
						}

						$el_text .= "<div class='ezfc-element-radio'>";
						$el_text .= "	<input class='{$data->class} ezfc-element-radio-input' id='{$radio_id}' type='radio' name='{$el_name}' value='{$i}' data-value='{$radio->value}' data-index='{$i}' data-factor='{$radio->value}' {$add_style} {$add_data}>";
						// image
						if (!empty($el_image)) {
							$el_text .= "<img class='ezfc-element-option-image ezfc-element-radio-image' src='{$el_image}' rel='{$el_id}' alt='' />";
						}
						// addon label
						$el_text .= "	<label class='ezfc-addon-label' for='{$radio_id}'></label>";
						$el_text .= "</div>";

						// text + price
						$radio_text = apply_filters("ezfc_label_sanitize", $radio->text, $radio);

						$el_text .= "<div class='ezfc-element-radio-text'>{$radio_text}<span class='ezfc-element-radio-price'>{$show_price}</span></div>";
						$el_text .= "<div class='ezfc-element-radio-clear'></div>";

						$el_text .= "</div>";

						$i++;
					}
				break;

				case "checkbox":
					$el_label .= $default_label;
					
					$preselect_values = array();
					if (property_exists($data, "preselect")) {
						$preselect_values = explode(",", $data->preselect);
					}

					$i = 0;
					foreach ($data->options as $n => $checkbox) {
						// use different names due to multiple choices
						$el_image         = "";
						$el_name          = "ezfc_element[{$element->id}][$i]";
						$el_wrapper_class = "";
						$checkbox_id      = "{$el_id}-{$i}";

						if (!empty($checkbox->image)) {
							$el_image = $checkbox->image;
							$el_wrapper_class .= "ezfc-element-option-has-image";
						}

						$add_data = "";
						if (in_array((string) $i, $preselect_values)) {
							$add_data .= " checked='checked'";
							$add_data .= " data-initvalue='1'";
						}

						if (property_exists($checkbox, "disabled")) {
							$add_data .= " disabled='disabled'";
						}

						if ($options["show_element_price"] == 1) {
							$show_price = apply_filters("ezfc_element_show_price", " <span class='ezfc-element-price'>({$options["currency"]}{$checkbox->value})</span>", $el_type);
						}

						$el_text .= "<div class='ezfc-element-checkbox-container {$el_wrapper_class}'>";
						$el_text .= "	<div class='ezfc-element-checkbox'>";
						$el_text .= "		<input class='{$data->class} ezfc-element-checkbox-input' id='{$checkbox_id}' type='checkbox' name='{$el_name}' value='{$i}' data-value='{$checkbox->value}' data-index='{$i}' data-factor='{$checkbox->value}' {$add_style} {$add_data} />";
						// image
						if (!empty($el_image)) {
							$el_text .= "<img class='ezfc-element-option-image ezfc-element-checkbox-image' src='{$el_image}' rel='{$el_id}' alt='' />";
						}
						// addon label
						$el_text .= "		<label class='ezfc-addon-label' for='{$checkbox_id}'></label>";
						$el_text .= "	</div>";

						// text + price
						$el_text .= "	<div class='ezfc-element-checkbox-text'>{$checkbox->text}<span class='ezfc-element-checkbox-price'>{$show_price}</span></div>";
						$el_text .= "	<div class='ezfc-element-checkbox-clear'></div>";
						$el_text .= "</div>";

						$i++;
					}
				break;

				case "datepicker":
					$data_settings = json_encode(array(
						"minDate"        => isset($data->minDate) ? $data->minDate : "",
						"maxDate"        => isset($data->maxDate) ? $data->maxDate : "",
						"numberOfMonths" => isset($data->numberOfMonths) ? $data->numberOfMonths : 1,
						"showAnim"       => isset($data->showAnim) ? $data->showAnim : "",
						"showWeek"       => isset($data->showWeek) ? $data->showWeek : "",
						"firstDay"       => isset($data->firstDay) ? $data->firstDay : ""
					));

					$add_attr = "data-initvalue='" . esc_attr($data->value) . "'";

					$el_label .= $default_label;
					$el_text .= "<input class='{$data->class} ezfc-element ezfc-element-input ezfc-element-datepicker' type='text' name='{$el_name}' {$data_value_external} value='{$data->value}' placeholder='{$data->placeholder}' {$add_style} {$required} {$add_attr} data-settings='{$data_settings}' />";
				break;

				case "daterange":
					if (empty($data->value)) $data->value = "";

					$preselected_dates = explode(";;", $data->value);
					$date_values = array(
						isset($preselected_dates[0]) ? $preselected_dates[0] : "",
						isset($preselected_dates[1]) ? $preselected_dates[1] : ""
					);

					$placeholder = explode(";;", $data->placeholder);
					$placeholder_values = array(
						isset($placeholder[0]) ? $placeholder[0] : "",
						isset($placeholder[1]) ? $placeholder[1] : ""
					);

					// mindate
					$minDate = explode(";;", $data->minDate);
					$minDate_values = array(
						isset($minDate[0]) ? $minDate[0] : "",
						isset($minDate[1]) ? $minDate[1] : ""
					);
					// maxdate
					$maxDate = explode(";;", $data->maxDate);
					$maxDate_values = array(
						isset($maxDate[0]) ? $maxDate[0] : "",
						isset($maxDate[1]) ? $maxDate[1] : ""
					);

					$add_attr_minDate = "data-initvalue='" . esc_attr($date_values[0]) . "'";
					$add_attr_maxDate = "data-initvalue='" . esc_attr($date_values[1]) . "'";

					$el_label .= $default_label;

					// element needs an additional container class
					$el_text .= "<div class='ezfc-element-daterange-container' data-factor='{$data->factor}'>";

					// from
					$el_text .= "<input class='{$data->class} ezfc-element ezfc-element-input ezfc-element-daterange ezfc-element-daterange-from' type='text' {$data_factor} name='{$el_name}[0]' {$data_value_external} data-mindays='{$data->minDays}' placeholder='{$placeholder_values[0]}' data-mindate='{$minDate_values[0]}' data-maxdate='{$maxDate_values[0]}' {$add_style} {$required} {$add_attr_minDate} />";
					// to
					$el_text .= "<input class='{$data->class} ezfc-element ezfc-element-input ezfc-element-daterange ezfc-element-daterange-to' type='text' {$data_factor} name='{$el_name}[1]' {$data_value_external} data-mindays='{$data->minDays}' placeholder='{$placeholder_values[1]}' data-mindate='{$minDate_values[1]}' data-maxdate='{$maxDate_values[1]}' {$add_style} {$required} {$add_attr_maxDate} />";

					
					$el_text .= "</div>";
				break;

				case "timepicker":
					wp_enqueue_style("jquery-timepicker", plugins_url("assets/css/jquery.timepicker.css", __FILE__));
					wp_enqueue_script("jquery-timepicker", plugins_url("assets/js/jquery.timepicker.min.js", __FILE__), array("jquery"));

					$data_settings = json_encode(array(
						"format"  => isset($data->format) ? $data->format : $options["timepicker_format"],
						"minTime" => isset($data->minTime) ? $data->minTime : "",
						"maxTime" => isset($data->maxTime) ? $data->maxTime : "",
						"step"    => isset($data->step) ? $data->step : ""
					));

					$add_attr = "data-initvalue='" . esc_attr($data->value) . "'";

					$el_label .= $default_label;
					$el_text .= "<input class='{$data->class} ezfc-element ezfc-element-input ezfc-element-timepicker' type='text' name='{$el_name}' {$data_value_external} value='{$data->value}' placeholder='{$data->placeholder}' {$add_style} {$required} data-settings='{$data_settings}' {$add_attr} />";
				break;

				case "textfield":
					$add_attr = "data-initvalue='" . esc_attr($data->value) . "'";

					$el_label .= $default_label;
					$el_text .= "<textarea class='{$data->class} ezfc-element ezfc-element-textarea' name='{$el_name}' placeholder='{$data->placeholder}' {$add_style} {$required} {$add_attr}>{$data->value}</textarea>";
				break;

				/* old
				case "recaptcha":
					$el_label .= "<label class='ezfc-label' for='{$el_id}' {$css_label_width} {$add_style}>" . $el_data_label . "{$required_char}</label>";
					$el_text .= recaptcha_get_html($publickey, null);
				break;
				*/
				// new
				case "recaptcha":
					$el_label .= "<label class='ezfc-label' for='{$el_id}' {$css_label_width} {$add_style}>" . $el_data_label . "{$required_char}</label>";
					$el_text .= "<div class='g-recaptcha' data-sitekey='{$publickey}'></div>";

					wp_enqueue_script("ezfc-google-recaptcha", "//www.google.com/recaptcha/api.js");
				break;

				case "html":
					$el_text .= "<div>";
					$el_text .= $this->apply_content_filter(html_entity_decode(stripslashes($data->html)));
					$el_text .= "<input class='ezfc-element-html' name='{$el_name}' type='hidden' value='1' />";
					$el_text .= "</div>";
				break;

				case "hr":
					$el_text .= "<hr class='{$data->class}' {$add_style}>";
				break;

				case "image":
					$el_text .= "<img src='{$data->image}' alt='{$data->alt}' class='{$data->class}' {$add_style} />";
				break;

				case "fileupload":
					wp_enqueue_script("jquery-ui-progressbar");
					wp_enqueue_script("jquery-file-upload", plugins_url("assets/js/jquery.fileupload.min.js", __FILE__), array("jquery"));
					wp_enqueue_script("jquery-iframe-transport", plugins_url("assets/js/jquery.iframe-transport.min.js", __FILE__), array("jquery-ui-widget"));

					$el_label .= $default_label;

					$multiple = $data->multiple==1 ? "multiple" : "";
					// file upload input
					$el_text .= "<input type='file' name='ezfc-files' class='{$data->class} ezfc-element-fileupload' placeholder='{$data->placeholder}' {$multiple} {$add_style} />";

					// upload button
					$el_text .= '<button class="btn ezfc-upload-button">' . __("Upload", "ezfc") . '</button>';

					$el_text .= "<p class='ezfc-fileupload-message'></p>";

					// progressbar
					$el_text .= '<div class="ezfc-progress ezfc-progress-striped active">
  									<div class="ezfc-bar ezfc-progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0">
    									<span class="sr-only">0% Complete</span>
							  		</div>
								</div>';
				break;

				case "subtotal":
					$data_settings = json_encode(array(
						"calculate_when_hidden" => isset($data->calculate_when_hidden) ? $data->calculate_when_hidden : 1,
						"precision"             => isset($data->precision)             ? $data->precision : 2,
						"price_format"          => isset($data->price_format)          ? $data->price_format : ""
					));

					$el_label .= $default_label;
					
					$el_type = "subtotal";
					if (property_exists($data, "text_only") && $data->text_only == 1) {
						$data->class .= " ezfc-hidden";
						$el_value = isset($value) ? $value : "";

						// text before/after
						$text_before = isset($data->text_before) ? $data->text_before : "";
						$text_after  = isset($data->text_after)  ? $data->text_after : "";

						// before
						$el_text .= "<span class='ezfc-text-before'>{$text_before}</span>";
						// currency
						$el_text .= "<span class='ezfc-text-currency'>{$options["currency"]}</span>";
						// price text
						$el_text .= "<span class='ezfc-text'>{$el_value}</span>";
						// after
						$el_text .= "<span class='ezfc-text-after'>{$text_after}</span>";
					}

					$el_text .= "<input class='{$data->class} ezfc-element ezfc-element-input ezfc-element-subtotal' type='{$el_type}' name='{$el_name}' value='' {$add_style} data-settings='{$data_settings}' />";
				break;

				case "stepstart":
					$step_class = "ezfc-step ezfc-step-start {$data->class}";
					if ($current_step == 0) $step_class .= " ezfc-step-active";

					$el_text = "<div class='{$step_class}' data-step='{$current_step}'>";

					if (!empty($data->title)) {
						$el_text .= "<div class='ezfc-step-title'>{$data->title}</div>";
					}

					$step = true;
				break;

				case "stepend":
					$el_text = "";

					if (property_exists($data, "add_line") && $data->add_line == 1) {
						$el_text .= "<hr class='ezfc-step-line' />";
					}

					// previous button
					if ($current_step > 0) {
						$el_text .= "	<button class='ezfc-step-button ezfc-step-previous'>{$data->previous_step}</button>";
					}
					// next button
					if ($current_step < $step_count - 1) {
						$el_text .= "	<button class='ezfc-step-button ezfc-step-next'>{$data->next_step}</button>";
					}
					
					$el_text .= "</div>";

					$step = true;
					$current_step++;
				break;

				case "colorpicker":
					wp_enqueue_style("ezfc-element-colorpicker-css", plugins_url("assets/colorpicker/css/bootstrap-colorpicker.min.css", __FILE__));
					wp_enqueue_script("ezfc-element-colorpicker-js", plugins_url("assets/colorpicker/js/bootstrap-colorpicker.min.js", __FILE__), array( 'jquery' ), false, false);

					$el_label .= $default_label;

					$el_text .= "<input class='{$data->class} ezfc-element-input ezfc-element-colorpicker-input' name='{$el_name}' type='text' value='{$data->value}' {$add_style} />";
					$el_text .= "<div class='ezfc-element-colorpicker'><div></div></div>";
				break;

				case "set":
					$data_settings = json_encode(array(
						"calculate_when_hidden" => isset($data->calculate_when_hidden) ? $data->calculate_when_hidden : 1,
						"precision"             => isset($data->precision)             ? $data->precision : 2,
						"price_format"          => isset($data->price_format)          ? $data->price_format : ""
					));

					$el_label .= $default_label;
					
					$el_text .= "<input class='{$data->class} ezfc-element ezfc-element-input ezfc-element-set' type='set' name='{$el_name}' value='' {$add_style} data-settings='{$data_settings}' />";
				break;

				case "post":
					if ($data->post_id == 0) return;

					$post = get_post($data->post_id);

					$el_text .= $this->apply_content_filter($post->post_content);
					$el_text .= "<input class='ezfc-element-post' name='{$el_name}' type='hidden' value='1' />";
				break;

				case "custom_calculation":
					$function_id = "ezfc_custom_calculation_" . uniqid();

					$el_text .= "<div class='ezfc-element-custom-calculation' data-function='{$function_id}'>";
					$el_text .= "<script>function " . $function_id . "(price) {";
					$el_text .= $data->custom_calculation;
					$el_text .= "return price;";
					$el_text .= "}</script>";
					$el_text .= "</div>";

					$el_text .= "<input class='ezfc-element-custom-calculation-input' name='{$el_name}' type='hidden' value='' />";
				break;

				//default: $el_text = $element->id; break;
			}

			// get content from extension
			if (!empty($data->extension)) {
				// add default label
				$el_label = $default_label;

				$el_text = apply_filters("ezfc_ext_get_frontend_{$data->extension}", $el_text, $el_name, $element, $data);
			}

			// add label
			if (!empty($data->label)) {
				$el_text = $el_label . $el_text;
			}

			// column class
			if (!empty($data->columns)) $element_css .= " ezfc-column ezfc-col-{$data->columns}";
			// wrapper class
			if (!empty($data->wrapper_class)) $element_css .= " {$data->wrapper_class}";
			// wrapper style
			if (!empty($data->wrapper_style)) $data_add .= " style=\"" . esc_js($data->wrapper_style) . "\"";

			if (!$step) {
				$element_css .= " ezfc-element-wrapper-{$el_type}";
				
				$html .= "<div class='{$element_css}' id='{$el_id}' data-element='{$el_type}' {$data_add} {$data_value_external}>{$el_text}</div>";
			}
			else {
				$el_text = apply_filters("ezfc_element_output_{$el_type}", $el_text, $el_label, $element);

				$html .= $el_text;
			}
		}

		// summary
		if ($options["summary_enabled"] == 1) {
			$html .= "<div class='ezfc-summary-wrapper ezfc-element ezfc-hidden'>";
			// summary text
			$html .= "  <label class='ezfc-label ezfc-summary-text'>" . $this->apply_content_filter($options["summary_text"]) . "</label>";
			// actual summary
			$html .= "  <div class='ezfc-summary'></div>";
			// summary submit button
			//$html .= "  <input class='ezfc-btn ezfc-element ezfc-element-summary-submit ezfc-submit' id='ezfc-summary-submit-{$form->id}' type='submit' value='" . esc_attr($options["summary_button_text"]) . "' />";
			$html .= "</div>";
		}

		// price
		if ($options["show_price_position"] == 1 ||	$options["show_price_position"] == 3) {
			$html .= "<div class='ezfc-element  price-box'>";
			$html .= "	<label class='ezfc-label' {$css_label_width}>" . $options["price_label"] . "</label>";
			$html .= "	<div class='ezfc-price-wrapper'>";
			$html .= "		<span class='ezfc-price'>{$price_html}</span>";
			$html .= "	</div>";
			$html .= "</div>";
		}
		// fixed price position
		if ($options["show_price_position"] == 4 ||	$options["show_price_position"] == 5) {
			$fixed_price_position = $options["show_price_position"]==4 ? "left" : "right";

			$html .= "<div class='ezfc-fixed-price ezfc-fixed-price-{$fixed_price_position}' data-id='{$form->id}'>";
			$html .= "	<label {$css_label_width}>" . $options["price_label"] . "</label>";
			$html .= "	<div class='ezfc-price-wrapper'>";
			$html .= "		<span class='ezfc-price'>{$price_html}</span>";
			$html .= "	</div>";
			$html .= "</div>";
		}

		// reset button
		if (!empty($options["reset_enabled"]) && $options["reset_enabled"]["enabled"] == 1) {
			$html .= "<div class='ezfc-element ezfc-reset-wrapper'>";
			$html .= "	<label {$css_label_width}></label>";
			$html .= "	<button class='ezfc-btn ezfc-element ezfc-element-reset ezfc-reset' id='ezfc-reset-{$form->id}'>{$options["reset_enabled"]["text"]}</button>";
			$html .= "</div>";
		}

		// submit
		if ($options["submission_enabled"] == 1) {
			// summary
			if ($options["summary_enabled"] == 1) $submit_text = $options["summary_button_text"];
			// submission / woocommerce
			else if ($use_woocommerce == 1) $submit_text = $options["submit_text_woo"];
			// paypal
			else if ($options["pp_enabled"] == 1) $submit_text = $options["pp_submittext"];
			// default
			else $submit_text = $options["submit_text"];

			$html .= "<div class='ezfc-element ezfc-submit-wrapper'>";
			$html .= "	<label {$css_label_width}></label>";
			$html .= "	<input class='ezfc-btn ezfc-element ezfc-element-submit ezfc-submit {$options["submit_button_class"]}' id='ezfc-submit-{$form->id}' type='submit' value='" . esc_attr($submit_text) . "' data-element='submit' />";
			$html .= "	<div class='ezfc-submit-icon'></div>";
			$html .= "</div>";
		}

		// required char
		$required_text = get_option("ezfc_required_text");
		if ($options["show_required_char"] != 0 && !empty($required_text)) {
			$html .= "<div class='ezfc-required-notification'><span class='ezfc-required-char'>*</span> " . $required_text . "</div>";
		}

		$html .= "</form>";

		// error messages
		$html .= "<div class='ezfc-message'></div>";

		// success message
		if (get_option("ezfc_woocommerce") == 1 && $options["woo_disable_form"] == 0) {
			$success_text = get_option("ezfc_woocommerce_text");
		}
		else {
			$success_text = $options["success_text"];
		}
		$html .= "<div class='ezfc-success-text' data-id='{$form->id}'>" . $this->apply_content_filter($success_text) . "</div>";

		// wrapper
		$html .= "</div>";

		// overview
		$html .= "<div class='ezfc-overview' data-id='{$form->id}'></div>";

		return $html;
	}

	public function insert_file($f_id, $ref_id, $file) {
		// insert into db
		$res = $this->wpdb->insert(
			$this->tables["files"],
			array(
				"f_id"   => $f_id,
				"ref_id" => $ref_id,
				"url"    => $file["url"],
				"file"   => $file["file"]
			),
			array(
				"%d",
				"%s",
				"%s",
				"%s"
			)
		);

		if (!$res) return $this->send_message("error", __("File entry failed.", "ezfc"));

		return $this->send_message("success", __("File entry saved.", "ezfc"));
	}

	public function update_submission_paypal($token, $transaction_id) {
		if (!$token) return $this->send_message("error", __("No token.", "ezfc"));

		$submission = $this->wpdb->get_row($this->wpdb->prepare(
			"SELECT id, f_id, data, ref_id FROM {$this->tables["submissions"]} WHERE token=%s",
			$token
		));

		// no submission with $token found
		if (!$submission || count($submission) < 1) return $this->send_message("error", __("Unable to find submission.", "ezfc"));

		$res = $this->wpdb->update(
			$this->tables["submissions"],
			array("transaction_id" => $transaction_id),
			array("id" => $submission->id),
			array("%s"),
			array("%d")
		);

		// reset some session data
		$_SESSION["Payment_Amount"] = null;

		return array("submission" => $submission);
	}

	/**
		when using ob_get() and ob_clean() in a special way, the applied content filter will cause the page to be blank.
	**/
	public function apply_content_filter($content) {
		return apply_filters(get_option("ezfc_content_filter", "the_content"), $content);
	}

	/**
		filters
	**/
	public function label_sanitize($text, $option = null) {
		//$text = htmlentities
		return $text;
	}

	/**
		helper functions
	**/
	public function remove_nl($content) {
		return trim(preg_replace('/\s\s+/', ' ', $content));
	}

	public function array_index_key($array, $key) {
		$ret_array = array();

		foreach ($array as $v) {
			if (is_object($v)) {
				$ret_array[$v->$key] = $v;
			}
			if (is_array($v)) {
				$ret_array[$v[$key]] = $v;
			}
		}

		return $ret_array;
	}

	public function send_message($type, $msg, $id=0) {
		return array(
			$type => $msg,
			"id"  => $id
		);
	}

	public function smtp_setup() {
		require_once(EZFC_PATH . "lib/PHPMailer/PHPMailerAutoload.php");

		$this->smtp = new PHPMailer();
		$this->smtp->isSMTP();
		$this->smtp->SMTPAuth   = true;
		$this->smtp->Host       = get_option("ezfc_email_smtp_host");
		$this->smtp->Username   = get_option("ezfc_email_smtp_user");
		$this->smtp->Password   = get_option("ezfc_email_smtp_pass");
		$this->smtp->Port       = get_option("ezfc_email_smtp_port");
		$this->smtp->SMTPSecure = get_option("ezfc_email_smtp_secure");
		$this->smtp->isHTML(true);
	}
}