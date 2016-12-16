<?php

class Ezfc_backend {
	public function __construct() {
		global $wpdb;
		$this->wpdb = $wpdb;

		$this->tables = array(
			"debug"          => "{$this->wpdb->prefix}ezfc_debug",
			"elements"       => "{$this->wpdb->prefix}ezfc_elements", // deprecated
			"files"          => "{$this->wpdb->prefix}ezfc_files",
			"forms"			 => "{$this->wpdb->prefix}ezfc_forms",
			"forms_elements" => "{$this->wpdb->prefix}ezfc_forms_elements",
			"forms_options"  => "{$this->wpdb->prefix}ezfc_forms_options",
			"options"        => "{$this->wpdb->prefix}ezfc_options",
			"submissions"    => "{$this->wpdb->prefix}ezfc_submissions",
			"templates"      => "{$this->wpdb->prefix}ezfc_templates",
			"tmp"            => "{$this->wpdb->prefix}ezfc_tmptable"
		);

		$this->elements = $this->array_index_key(Ezfc_settings::get_elements(), "id");
		//$this->elements = Ezfc_settings::get_elements();

		// extension elements
		$elements_ext = apply_filters("ezfc_show_backend_elements", array());
		foreach ($elements_ext as $element_name => $element_options) {
			// convert array data to object
			$element_data_json = json_decode(json_encode($element_options));
			$element_data_json->extension = true;

			$this->elements[$element_name] = $element_data_json;
		}
	}

	public function get_debug_log() {
		$res = $this->wpdb->get_results("SELECT * FROM {$this->tables["debug"]} ORDER BY id DESC LIMIT 500");

		if (count($res) < 1) return "No debug logs found.";

		$logs = array();
		foreach ($res as $log) {
			$logs[] = "{$log->time}: {$log->msg}";
		}

		return implode("\n", $logs);
	}

	public function clear_debug_log() {
		$this->wpdb->query("TRUNCATE TABLE `{$this->tables["debug"]}`");
	}

	public function debug($msg) {
		if (get_option("ezfc_debug_mode", 0) == 0) return;

		$this->wpdb->insert(
			$this->tables["debug"],
			array("msg" => $msg),
			array("%s")
		);
	}

	/**
		forms
	**/
	public function form_add($template_id=0, $import_data=false) {
		$form_name = __("New form", "ezfc");

		if ($import_data) {
			if (!property_exists($import_data, "form")) return $this->send_message("error", __("Corrupt form data.", "ezfc"));

			$form_name = $import_data->form->name;
		}

		$res = $this->wpdb->insert(
			$this->tables["forms"],
			array("name" => $form_name),
			array("%s")
		);

		$insert_id = $this->wpdb->insert_id;

		// template / import
		$template_id = (int) $template_id;
		$template = null;

		// add by template
		if ($template_id != 0) {
			$template = $this->form_template_get($template_id);
			$template_elements = json_decode($template->data);
			$template_options  = json_decode($template->options);
		}
		// add by import data
		else if ($import_data && property_exists($import_data, "elements")) {
			$template = $import_data;
			$template_elements = $template->elements;
			$template_options  = $template->options;
		}

		// template data exists -> import them
		if (is_object($template)) {
			foreach ($template_elements as $element) {
				$el_insert_id = $this->form_element_add($insert_id, $element->e_id, $element->data, $element->position);

				if (!$el_insert_id) return $this->send_message("error", __("Could not insert element data from template.", "ezfc"));

				$element->id = $el_insert_id;
			}

			// replace calculate positions with target ids
			$template_elements_indexed = $this->array_index_key($template_elements, "position");

			foreach ($template_elements_indexed as $pos => $element) {
				if (!property_exists($element, "data")) continue;

				$element_data = json_decode($element->data);
				if (!is_object($element_data)) {
					$this->debug("Error while importing:");
					$this->debug(var_export($element->data, true));
					continue;
				}

				$element_data_sql = null;

				// calculate elements
				if (property_exists($element_data, "calculate") &&
					!empty($element_data->calculate) &&
					count($element_data->calculate) > 0) {

					// convert object to array
					if (!is_array($element_data->calculate)) {
						$element_data->calculate = (array) $element_data->calculate;
					}

					foreach ($element_data->calculate as &$calc_value) {
						if ($calc_value->target == 0) continue;

						if (!isset($template_elements_indexed[$calc_value->target])) continue;

						$target_element = $template_elements_indexed[$calc_value->target];
						$calc_id = $target_element->id;

						$calc_value->target = $calc_id;
						// unset id due to duplication
						unset($element_data->id);

						$element_data_sql = json_encode($element_data);
					}
				}

				// conditional elements
				if (property_exists($element_data, "conditional") &&
					!empty($element_data->conditional) &&
					count($element_data->conditional) > 0) {

					// convert object to array
					if (!is_array($element_data->conditional)) {
						$element_data->conditional = (array) $element_data->conditional;
					}

					foreach ($element_data->conditional as &$cond_value) {
						if ($cond_value->target == 0) continue;

						if (!isset($template_elements_indexed[$cond_value->target])) continue;

						$target_element = $template_elements_indexed[$cond_value->target];
						$cond_id = $target_element->id;

						$cond_value->target = $cond_id;
						// unset id due to duplication
						unset($element_data->id);

						$element_data_sql = json_encode($element_data);
					}
				}

				// groups
				if (!empty($element_data->group_id)) {
					if (!isset($template_elements_indexed[$element_data->group_id])) continue;

					$target_element = $template_elements_indexed[$element_data->group_id];
					$target_id      = $target_element->id;

					$element_data->group_id = $target_id;
					// unset id due to duplication
					//unset($element_data->id); needed?

					$element_data_sql = json_encode($element_data);
				}

				// element data was changed -> update element in sql db
				if (!empty($element_data_sql)) {
					$this->wpdb->query($this->wpdb->prepare(
						"UPDATE {$this->tables["forms_elements"]} SET data=%s WHERE id=%d",
						$element_data_sql, $element->id
					));
				}
			}
		}

		// add default options
		$default_options = $this->wpdb->query($this->wpdb->prepare(
			"INSERT INTO {$this->tables["forms_options"]} (f_id, o_id, value)
			(SELECT %d, id, value FROM {$this->tables["options"]})",
			$insert_id
		));

		// import options
		if (isset($template_options)) {
			foreach ($template_options as $export_option_id => $o) {
				// fallback
				$option_id = empty($o->o_id) ? $export_option_id : $o->o_id;

				$this->wpdb->query($this->wpdb->prepare(
					"UPDATE {$this->tables["forms_options"]}
					SET value=%s
					WHERE f_id=%d AND o_id=%d",
					$o->value, $insert_id, $option_id
				));
			}
		}

		$this->add_missing_element_options($insert_id);

		return $insert_id;
	}

	public function form_add_post($id) {
		$post_name = "ezfc-form-{$id}";

		$post_exists = get_posts(array(
			"name"           => $post_name,
			"post_status"    => "private",
			"post_type"      => "post",
			"posts_per_page" => 1
		));

		$post_id = null;
		if ($post_exists) {
			$post_id = $post_exists[0]->ID;
		}

		$new_post_id = wp_insert_post(array(
			"ID"           => $post_id,
			"post_content" => "[ezfc id='{$id}' /]",
			"post_name"    => $post_name,
			"post_status"  => "private",
			"post_title"   => "EZFC Form #{$id}",
			"post_type"    => "post"
		));

		if (!$new_post_id) return $this->send_message("error", __("Unable to add post", "ezfc"));

		// return permalink
		return $this->send_message("success", urlencode(get_permalink($new_post_id)));
	}

	public function form_clear($id) {
		$id = (int) $id;

		$res = $this->wpdb->delete(
			$this->tables["forms_elements"],
			array("f_id" => $id),
			array("%d")
		);

		return $this->send_message("success", __("Form cleared.", "ezfc"));
	}

	public function form_delete($id) {
		$id = (int) $id;

		$res = $this->wpdb->delete(
			$this->tables["forms"],
			array("id" => $id),
			array("%d")
		);

		if ($res === false) return $this->send_message("error", __("Could not delete form: {$wpdb->last_error}"));

		$res = $this->wpdb->delete(
			$this->tables["forms_elements"],
			array("f_id" => $id),
			array("%d")
		);

		if ($res === false) return $this->send_message("error", __("Could not delete form elements: {$wpdb->last_error}"));

		$res = $this->wpdb->delete(
			$this->tables["forms_options"],
			array("f_id" => $id),
			array("%d")
		);

		if ($res === false) return $this->send_message("error", __("Could not delete form options: {$wpdb->last_error}"));

		return $this->send_message("success", __("Form deleted.", "ezfc"));
	}

	public function form_delete_submissions($f_id) {
		if (empty($f_id)) return $this->send_message("error", __("No form selected.", "ezfc"));

		$res = $this->wpdb->delete(
			$this->tables["submissions"],
			array("f_id" => $f_id),
			array("%d")
		);

		if ($res === false) return $this->send_message("error", sprintf(__("Unable to delete form submissions: %s", "ezfc"), $wpdb->last_error));

		return $this->send_message("success", __("Submissions deleted.", "ezfc"));
	}

	public function form_duplicate($id) {
		// get import data
		$form_data = $this->form_get_export_data(null, $id);
		// convert objects
		$form_object = json_decode(json_encode($form_data));
		// add form
		$new_form_id = $this->form_add(0, $form_object);
		
		// get form data
		$ret = array(
			"elements" => $this->form_elements_get($new_form_id),
			"form"     => $this->form_get($new_form_id),
			"options"  => $this->form_get_options($new_form_id)
		);

		return $ret;
	}

	public function form_file_delete($id) {
		$id = (int) $id;

		$file = $this->wpdb->get_row($this->wpdb->prepare(
			"SELECT * FROM {$this->tables["files"]} WHERE id=%d",
			$id
		));

		if (!unlink($file->file)) return $this->send_message("error", __("Could not delete file from server.", "ezfc"));

		$res = $this->wpdb->delete(
			$this->tables["files"],
			array("id" => $id),
			array("%d")
		);

		if ($res === false) return $this->send_message("error", __("Could not delete file entry: {$wpdb->last_error}", "ezfc"));

		return $this->send_message("success", __("File deleted.", "ezfc"));
	}

	public function forms_get() {
		$res = $this->wpdb->get_results("SELECT * FROM {$this->tables["forms"]}");

		return $res;
	}

	public function form_get($id) {
		if (!$id) return $this->send_message("error", __("No ID", "ezfc"));

		$res = $this->wpdb->get_row($this->wpdb->prepare(
			"SELECT * FROM {$this->tables["forms"]} WHERE id=%d",
			$id
		));

		return $res;
	}

	public function form_get_options($id, $values_only = false) {
		if (!$id) return $this->send_message("error", __("No ID", "ezfc"));

		$settings = $this->array_index_key($this->get_settings_fields(true), "id");

		// merge values
		$settings_db = $this->array_index_key($this->wpdb->get_results($this->wpdb->prepare("SELECT o_id, value FROM {$this->tables["forms_options"]} WHERE f_id=%d", $id), ARRAY_A), "o_id");

		foreach ($settings as &$setting) {
			if (!empty($settings_db[$setting["id"]])) $setting["value"] = maybe_unserialize($settings_db[$setting["id"]]["value"]);

			if ($values_only) {
				$setting = array("value" => maybe_serialize($setting["value"]));
			}
		}

		return $settings;
	}

	/**
		$import_data = json_object
	**/
	public function form_import($import_data) {
		$new_form_id = $this->form_add(null, $import_data);

		$this->add_missing_element_options($new_form_id);

		$ret = array(
			"elements" => $this->form_elements_get($new_form_id),
			"form"     => $this->form_get($new_form_id),
			"options"  => $this->form_get_options($new_form_id)
		);

		return $ret;
	}

	/**
		submissions
	**/
	public function get_submission($id, $woo=false) {
		if (!$id) return $this->send_message("error", __("No ID", "ezfc"));

		$res = $this->wpdb->get_row($this->wpdb->prepare(
			"SELECT * FROM {$this->tables["submissions"]} WHERE id=%d",
			$id
		));

		return $res;
	}

	public function form_get_submissions($id) {
		if (!$id) return $this->send_message("error", __("No ID", "ezfc"));

		$res = $this->wpdb->get_results($this->wpdb->prepare(
			"SELECT * FROM {$this->tables["submissions"]} WHERE f_id=%d ORDER BY id DESC",
			$id
		));

		return $res;
	}

	public function form_get_submissions_count($id) {
		if (!$id) return $this->send_message("error", __("No ID", "ezfc"));

		$res = $this->wpdb->get_var($this->wpdb->prepare(
			"SELECT COUNT(*) FROM {$this->tables["submissions"]} WHERE f_id=%d",
			$id
		));

		return $res;
	}

	public function form_get_submissions_csv($id) {
		if (!$id) return $this->send_message("error", __("No ID", "ezfc"));

		$submissions = $this->form_get_submissions($id);

		// no submissions
		if (count($submissions) < 1) return $this->send_message("error", __("No submissions found.", "ezfc"));

		// get form elements
		$form_elements = $this->form_elements_get($id, true);

		// convert to array
		$submission_array = json_decode(json_encode($submissions), true);

		$keys = array_keys($submission_array[0]);
		$keys[] = "data_edited";

		$csv_array = array();
		$csv_array[] = Ezfc_Functions::arrayToCsv($keys);

		foreach ($submission_array as $submission) {
			$tmp_data = array();

			// replace id with element name
			if (!empty($submission["data"])) {
				$submission_form_elements = json_decode($submission["data"], true);

				foreach ($submission_form_elements as $e_id => $value) {
					if (is_array($value)) $value = implode(",", $value);

					// form element not found
					if (!isset($form_elements[$e_id])) {
						$tmp_data[] = $e_id . ": " . $value;
						continue;
					}

					$form_element_data = json_decode($form_elements[$e_id]->data);

					$tmp_data[] = $form_element_data->name . ": " . $value;
				}
			}

			$submission["data_edited"] = implode("\n", $tmp_data);

			$csv_array[] = Ezfc_Functions::arrayToCsv($submission);
		}

		$csv_output = implode("\n", $csv_array); 

		$file = Ezfc_Functions::write_tmp_file($csv_output, "export_csv", "csv");

		return $file;
	}

	public function form_get_submissions_files($id) {
		if (!$id) return $this->send_message("error", __("No ID", "ezfc"));

		$res = $this->wpdb->get_results($this->wpdb->prepare(
			"SELECT * FROM {$this->tables["files"]} WHERE f_id=%d ORDER BY id DESC",
			$id
		));

		$files = array();
		// index by ref_id
		foreach ($res as $file) {
			$files[$file->ref_id][] = $file;
		}

		return $files;
	}

	public function form_submission_delete($id) {
		$res = $this->wpdb->delete(
			$this->tables["submissions"],
			array("id" => $id),
			array("%d")
		);

		if ($res === false) return $this->send_message("error", sprintf(__("Unable to delete form submission: %s", "ezfc"), $wpdb->last_error));

		return $this->send_message("success", __("Submission deleted.", "ezfc"));
	}

	public function form_save_template($id, $form_data=null) {
		// save template from data
		if ($form_data) {
			$form          = $form_data->form;
			$form_elements = (array) $form_data->elements;
			$form_options  = $form_data->options;
		}
		// save template from form
		else {
			$id = (int) $id;
			
			$form          = $this->form_get($id);
			$form_elements = $this->form_elements_get($id, true);
			$form_options  = $this->form_get_options($id);
		}

		// replace calculate target ids with positions
		foreach ($form_elements as $pos => $element) {
			if (!property_exists($element, "data")) continue;
			$element_data = json_decode($element->data);

			if (!property_exists($element_data, "calculate")) continue;
			if (count($element_data->calculate) < 1) continue;
			
			foreach ($element_data->calculate as $calc_key => $calc_value) {
				if ($calc_value->target == 0) continue;

				if (!$form_elements[$calc_value->target]) continue;

				$target_element = $form_elements[$calc_value->target];
				$calc_position = $target_element->position;

				$element_data->calculate[$calc_key]->target = $calc_position;
				$element->data = json_encode($element_data);
			}
		}

		// replace conditional target ids with positions
		foreach ($form_elements as $pos => $element) {
			if (!property_exists($element, "data")) continue;
			$element_data = json_decode($element->data);

			if (!property_exists($element_data, "conditional")) continue;
			if (count($element_data->conditional) < 1) continue;
			
			foreach ($element_data->conditional as $cond_key => $cond_value) {
				if ($cond_value->target == 0) continue;

				if (!isset($form_elements[$cond_value->target])) continue;

				$target_element = $form_elements[$cond_value->target];
				$calc_position = $target_element->position;

				$element_data->conditional[$cond_key]->target = $calc_position;
				$element->data = json_encode($element_data);
			}
		}

		$form_elements_json = json_encode($form_elements);
		$form_options_json  = json_encode($form_options);

		$res = $this->wpdb->insert(
			$this->tables["templates"],
			array(
				"name"    => $form->name,
				"data"    => $form_elements_json,
				"options" => $form_options_json
			),
			array(
				"%s",
				"%s",
				"%s"
			)
		);

		if (!$res) return $this->send_message("error", __("Could not insert template", "ezfc") . ": " . $this->wpdb->last_error);

		return $this->wpdb->insert_id;
	}

	public function form_template_delete($id) {
		$id = (int) $id;

		$res = $this->wpdb->delete(
			$this->tables["templates"],
			array("id" => $id),
			array("%d")
		);

		if ($res === false) return $this->send_message("error", __("Could not delete template: {$wpdb->last_error}"));

		return $this->send_message("success", __("Template deleted.", "ezfc"));
	}

	public function form_update($id, $name) {
		$id = (int) $id;

		$res = $this->wpdb->update(
			$this->tables["forms"],
			array("name" => $name),
			array("id" => $id),
			array("%s"),
			array("%d")
		);

		return $res;
	}

	public function form_update_options($id, $options) {	
		if (count($options) < 1) return $this->send_message("error", __("No settings", "ezfc"));

		$settings_fields       = $this->get_settings_fields(true);
		$settings_fields_assoc = $this->array_index_key($settings_fields, "name");
		$css_builder           = new EZ_CSS_Builder(".ezfc-form-{$id}");

		foreach ($options as $o_id => $value) {
			$settings_field = json_decode(json_encode($settings_fields[$o_id]), true);

			// check for css
			if (!empty($settings_field["css"]) && !empty($value)) {
				$css_builder->add_css($settings_field["css"], $value);
			}

			if (is_array($value)) {
				$value = serialize($value);
			}
			else {
				$value = stripslashes($value);
			}

			$res = $this->wpdb->replace(
				$this->tables["forms_options"],
				array(
					"f_id"  => $id,
					"o_id"  => $o_id,
					"value" => $value
				),
				array(
					"%d",
					"%d",
					"%s"
				)
			);

			if ($res === false) {
				return $this->send_message("error", $this->wpdb->last_error);
			}
		}

		// write css output
		$css_output = $css_builder->get_output();

		$this->wpdb->replace(
			$this->tables["forms_options"],
			array(
				"f_id"  => $id,
				"o_id"  => $settings_fields_assoc["css_custom_styling"]["id"],
				"value" => $css_output
			),
			array(
				"%d",
				"%d",
				"%s"
			)
		);

		return $this->send_message("success", __("Settings updated", "ezfc"));
	}

	/**
		elements
		(deprecated since elements are added upon construction)
	**/
	public function elements_get() {
		return $this->elements;
	}

	public function element_get($id) {
		if (!$id) return $this->send_message("error", __("No ID.", "ezfc"));

		return $this->elements[$id];
	}

	/**
		form elements
	**/
	public function form_elements_get($id, $index=false, $key="id", $merge=true) {
		if (!$id) return $this->send_message("error", __("No ID given.", "ezfc"));

		$res = $this->wpdb->get_results($this->wpdb->prepare(
			"SELECT * FROM {$this->tables["forms_elements"]} WHERE f_id=%d ORDER BY position DESC",
			$id
		));

		// not needed yet
		if ($merge) {
			foreach ($res as &$element) {
				// extension elements (todo)
				if (!isset($this->elements[$element->e_id])) continue;

				$tmp_element = (array) $this->elements[$element->e_id]->data;
				$tmp_array = (array) json_decode($element->data);
				$data = json_encode(Ezfc_Functions::array_merge_recursive_distinct($tmp_element, $tmp_array));

				$element->data = $data;
			}
		}

		if ($index) $res = $this->array_index_key($res, $key);

		return $res;
	}

	public function form_element_get($id) {
		if (!$id) return $this->send_message("error", __("No ID given.", "ezfc"));

		$res = $this->wpdb->get_row($this->wpdb->prepare(
			"SELECT * FROM {$this->tables["forms_elements"]} WHERE id=%d",
			$id
		));

		return $res;
	}

	public function form_element_add($f_id, $e_id, $data=null, $element_data=array()) {
		// get default element data
		$element_default_data = $this->elements[$e_id];
		$default_data         = $element_default_data->data;

		// put e_id into default data
		$default_data->e_id = $e_id;

		// ... and merge it with the data provided
		if ($data) {
			$element_default_data_array = json_decode(json_encode($default_data), true);

			if (!is_array($data)) {
				$data = json_decode($data, true);
			}

			$default_data = Ezfc_Functions::array_merge_recursive_distinct($element_default_data_array, $data);
		}

		if (is_array($default_data)) {
			$default_data = json_decode(json_encode($default_data));
		}

		// set position
		$position = isset($element_data["position"]) ? $element_data["position"] : 0;
		// group id
		if (isset($element_data["group_id"])) $default_data->group_id = $element_data["group_id"];

		// convert some element properties to htmlentities
		$default_data_object = is_object($default_data) ? $default_data : json_decode($default_data);
		$default_data_object = $this->convert_html_fields($default_data_object, "decode");
		$default_data        = json_encode($default_data_object);

		$res = $this->wpdb->insert(
			$this->tables["forms_elements"],
			array(
				"f_id"     => $f_id,
				"e_id"     => $e_id,
				"data"     => $default_data,
				"position" => $position
			),
			array(
				"%d",
				"%d",
				"%s",
				"%d"
			)
		);

		if (!$res) return $this->send_message("error", __("Could not insert element to form", "ezfc") . ": " . $this->wpdb->last_error);

		return $this->wpdb->insert_id;
	}

	public function form_element_delete($id, $child_element_ids = null) {
		$id = (int) $id;

		$res = $this->wpdb->delete(
			$this->tables["forms_elements"],
			array("id" => $id),
			array("%d")
		);

		if ($child_element_ids) {
			$child_element_array = explode(",", $child_element_ids);

			foreach ($child_element_array as $e_id) {
				$this->form_element_delete($e_id);
			}
		}

		return $this->send_message("success", __("Element deleted.", "ezfc"));
	}

	public function form_element_duplicate($id) {
		$id = (int) $id;

		$element = $this->form_element_get($id);
		if (!$element) {
			return $this->send_message("error", __("Failed to duplicate element.", "ezfc"));
		}

		$new_element_id = $this->form_element_add($element->f_id, $element->e_id, $element->data);
		return $this->form_element_get($new_element_id);
	}

	public function form_elements_save($id, $data) {
		if (!$id) return $this->send_message("error", __("No ID.", "ezfc"));

		// no elements present --> save complete
		if (count($data) < 1) return 1;

		$max = count($data);
		foreach ($data as $id => $element) {
			$element_data = $this->convert_html_fields($element, "encode");
			$element_data = json_encode($element_data);

			$res = $this->wpdb->update(
				$this->tables["forms_elements"],
				array(
					"data"     => $element_data,
					"position" => $max--
				),
				array("id" => $id),
				array(
					"%s",
					"%d"
				),
				array("%d")
			);

			if (!$res && $res!=0) return $this->send_message("error", __("Form elements update error:", "ezfc") . $this->wpdb->last_error);
		}

		return 1;
	}


	/**
		form templates
	**/
	public function form_templates_get() {
		$res = $this->wpdb->get_results("SELECT * FROM {$this->tables["templates"]}");

		return $res;
	}

	public function form_template_get($id) {
		if (!$id) return $this->send_message("error", __("No ID given.", "ezfc"));

		$res = $this->wpdb->get_row($this->wpdb->prepare(
			"SELECT * FROM {$this->tables["templates"]} WHERE id=%d",
			$id
		));

		return $res;
	}


	/**
		form settings
	**/
	public function get_settings_fields($flat = false) {
		return Ezfc_settings::get_form_options($flat);
	}

	/**
		form default settings
	**/
	public function get_options($flat = false) {
		$settings = $this->get_settings_fields();

		// merge values
		$settings_db = $this->array_index_key($this->wpdb->get_results("SELECT id, value FROM {$this->tables["options"]}", ARRAY_A), "id");

		foreach ($settings as $cat => &$settings_cat) {
			foreach ($settings_cat as &$setting) {
				if (!empty($settings_db[$setting["id"]])) {
					$setting["value"] = $settings_db[$setting["id"]]["value"];
				}
			}
		}

		if ($flat) return Ezfc_settings::flatten($settings);

		return $settings;
	}
	
	public function update_options($settings, $overwrite=0, $upgrade=0) {
		$settings_fields       = $this->get_settings_fields(true);
		$settings_fields_assoc = $this->array_index_key($settings_fields, "name");
		$css_builder           = new EZ_CSS_Builder();

		if (!$settings) $settings = array();
		
		foreach ($settings as $o_id => $value) {
			$settings_field = json_decode(json_encode($settings_fields[$o_id]), true);

			// check for css
			if (!empty($settings_field["css"]) && !empty($value)) {
				$css_builder->add_css($settings_field["css"], $value);
			}

			if (is_array($value)) {
				$value = serialize($value);
			}
			else {
				$value = stripslashes($value);
			}

			// update option in db
			$res = $this->wpdb->replace(
				$this->tables["options"],
				array(
					"id"    => $o_id,
					"name"  => $settings_field["name"],
					"value" => $value
				),
				array(
					"%d",
					"%s",
					"%s"
				)
			);

			if ($res === false) {
				return $this->send_message("error", $this->wpdb->last_error);
			}

			// overwrite settings, skip on name
			if ($overwrite == 0) continue;

			$res = $this->wpdb->replace(
				$this->tables["forms_options"],
				array(
					"o_id"  => $o_id,
					"name"  => $settings_field["name"],
					"value" => $value
				),
				array(
					"%d",
					"%s",
					"%s"
				)
			);
		}

		// write css output
		$css_output = $css_builder->get_output();

		$this->wpdb->replace(
			$this->tables["options"],
			array(
				"id" => $settings_fields_assoc["css_custom_styling"]["id"],
				"name"  => "css_custom_styling",
				"value" => $css_output
			),
			array(
				"%d",
				"%s",
				"%s"
			)
		);

		// manual upgrade
		if ($upgrade == 1) {
			$this->setup_db();
			$this->upgrade();
		}

		return $this->send_message("success", __("Settings updated", "ezfc"));
	}

	public function add_missing_element_options($f_id=-1) {
		$elements = $this->array_index_key(Ezfc_settings::get_elements(), "id");

		if ($f_id != -1) {
			$forms = array($this->form_get($f_id));
		}
		else {
			$forms = $this->forms_get();
		}

		foreach ($forms as $fi => $form) {
			// insert missing options
			$query = "SELECT 
				o.id, o.value
			FROM
				{$this->tables["options"]} as o
				left join {$this->tables["forms_options"]} as fo on (o.id = fo.o_id AND fo.f_id = {$form->id})
			WHERE
				fo.o_id is NULL";

			$missing_options = $this->wpdb->get_results($query);
			if (count($missing_options) > 0) {
				foreach ($missing_options as $mo) {
					$mo_res = $this->wpdb->insert(
						$this->tables["forms_options"],
						array(
							"f_id"  => $form->id,
							"o_id"  => $mo->id,
							"value" => $mo->value
						),
						array(
							"%d",
							"%d",
							"%s"
						)
					);

					if ($mo_res === false) {
						return $this->send_message("error", $this->wpdb->last_error);
					}
				}
			}

			// insert missing element options
			$form_elements_data = $this->wpdb->get_results($this->wpdb->prepare("SELECT id, e_id, data FROM {$this->tables["forms_elements"]} WHERE f_id=%d", $form->id));
			if (count($form_elements_data) > 0) {
				foreach ($form_elements_data as $element_data) {
					// invalid element or extension (skip for now)
					if ($element_data->e_id == 0 || !$elements[$element_data->e_id]) continue;

					$data_array    = $elements[$element_data->e_id]->data;
					$data_el_array = $element_data->data;

					if (!is_array($elements[$element_data->e_id]->data)) {
						$data_array    = json_decode(json_encode($elements[$element_data->e_id]->data), true);
					}
					if (!is_array($data_el_array)) {
						$data_el_array = json_decode($element_data->data, true);
					}

					if (!is_array($data_array) || !is_array($data_el_array)) continue;
					
					// merge global element data with form element data
					$data_merged = Ezfc_Functions::array_merge_recursive_distinct($data_array, $data_el_array);
					$data_new    = json_encode($data_merged);

					$res = $this->wpdb->update(
						$this->tables["forms_elements"],
						array("data" => $data_new),
						array("id" => $element_data->id),
						array("%s"),
						array("%d")
					);

					if ($res === false) {
						return $this->send_message("error", $this->wpdb->last_error);
					}
				}
			}
		}
	}

	public function setup_db() {
		$query = file_get_contents(dirname(__FILE__) . "/db.sql");
		if (!$query) {
			die("Error opening file 'db.sql'");
		}

		$query_replaced = str_replace("__PREFIX__", $this->wpdb->prefix, $query);
		$this->execute_multiline_sql($query_replaced);
	}

	public function upgrade() {
		$old_version = get_option("ezfc_version", "1.0");

		$this->add_missing_element_options();

		// do not perform table changes when old version is current version
		if (version_compare($old_version, EZFC_VERSION) == 0) return;

		// version specific upgrades
		$query_upgrade = array();

		if (version_compare($old_version, "2.7.4.0") < 0) {
			// change theme values (int to string) as theme integration was changed
			$query_upgrade[] = "UPDATE `{$this->tables["forms_options"]}` SET `value`='default' WHERE `o_id`=19 AND `value`=1;";
			$query_upgrade[] = "UPDATE `{$this->tables["forms_options"]}` SET `value`='default-alternative' WHERE `o_id`=19 AND `value`=2;";
			$query_upgrade[] = "UPDATE `{$this->tables["options"]}` SET `value`='default' WHERE `name`='theme' AND `value`=1;";
			$query_upgrade[] = "UPDATE `{$this->tables["options"]}` SET `value`='default-alternative' WHERE `name`='theme' AND `value`=2;";

			// remove group element (accidentally put in production)
			$query_upgrade[] = "DELETE FROM `{$this->tables["elements"]}` WHERE `name`='Group';";
			$query_upgrade[] = "DELETE FROM `{$this->tables["forms_elements"]}` WHERE `e_id`=21;";
		}

		// do it already!
		foreach ($query_upgrade as $q) {
			$res = $this->wpdb->query($q);
		}

		// all upgrades finished, update version
		update_option("ezfc_version", EZFC_VERSION);
	}

	/**
		get all export data
	**/
	public function get_export_data() {
		$forms_export           = array();
		$global_settings_export = array();
		$settings_export        = array();

		// forms
		$forms = $this->forms_get();
		if (count($forms) > 0) {
			foreach ($forms as $f) {
				$forms_export[] = $this->form_get_export_data($f);
			}
		}

		// global settings
		$global_settings_tmp = Ezfc_settings::get_global_settings(true);
		foreach ($global_settings_tmp as $name => $setting) {
			$global_settings_export[$name] = $setting["value"];
		}

		// form settings
		$settings_tmp = $this->get_options(true);
		if (count($settings_tmp) > 0) {
			foreach ($settings_tmp as $s) {
				$settings_export[$s["id"]] = $s["value"];
			}
		}

		return array(
			"forms"           => $forms_export,
			"global_settings" => $global_settings_export,
			"settings"        => $settings_export
		);
	}

	/**
		get form export data
	**/
	public function form_get_export_data($form=null, $f_id=null) {
		if (!$form && $f_id) $form = $this->form_get($f_id);

		// replace calculation targets with positions
		$elements = $this->form_elements_get($form->id);
		$elements_indexed = $this->array_index_key($elements, "id");

		if (count($elements) > 0) {
			foreach ($elements as $i => $e) {
				$data = json_decode($e->data);
				if (!is_object($data)) continue;

				if (property_exists($data, "calculate")) {
					// for some reason, calculate arrays are stored as objects. wtf?
					if (!is_array($data->calculate)) {
						$data->calculate = (array) $data->calculate;
					}

					foreach ($data->calculate as &$calc) {
						if ($calc->target != 0 && array_key_exists($calc->target, $elements_indexed)) {
							$calc->target = $elements_indexed[$calc->target]->position;
						}
					}
				}

				if (property_exists($data, "conditional")) {
					// see above.
					if (!is_array($data->conditional)) {
						$data->conditional = (array) $data->conditional;
					}

					foreach ($data->conditional as &$cond) {
						if ($cond->target != 0 && isset($elements_indexed[$cond->target])) {
							$cond->target = $elements_indexed[$cond->target]->position;
						}
					}
				}

				if (!empty($data->group_id)) {
					$data->group_id = $elements_indexed[$data->group_id]->position;
				}

				// convert some element properties to htmlentities
				$data = $this->convert_html_fields($data, "encode");
				$elements[$i]->data = json_encode($data);
			}
		}

		return array(
			"form"     => $form,
			"elements" => $elements,
			"options"  => $this->form_get_options($form->id, true),
			"version"  => EZFC_VERSION
		);
	}

	/**
		download form
	**/
	public function form_get_export_download($f_id) {
		$export_data      = $this->form_get_export_data(null, $f_id);
		$export_data_json = json_encode($export_data);

		$file = EZFC_Functions::zip_write($export_data_json, "ezfc_form_export_data.json");

		return $file;
	}


	public function convert_html_fields($object, $convert="encode") {
		$convert_html_keys = array(
			"name"    => 1,
			"label"   => 1,
			"html"    => 1,
			"options" => array("text")
		);

		// convert array to object
		if (is_array($object)) $object = json_decode(json_encode($object));
		// invalid data -> return object
		if (!is_object($object)) return $object;

		foreach ($convert_html_keys as $key => $val) {
			if (!property_exists($object, $key)) continue;

			// options
			if (is_array($val) && (is_array($object->$key) || is_object($object->$key))) {
				foreach ($val as $array_val) {
					if (count($object->$key) < 1) continue;

					foreach ($object->$key as &$option_array) {
						if (!property_exists($option_array, $array_val)) continue;

						$option_array->$array_val = $this->normalize_encoding($option_array->$array_val, $convert);
					}
				}
			}
			// name, label etc.
			else {
				$object->$key = $this->normalize_encoding($object->$key, $convert);
			}
		}

		return $object;
	}

	// this will encode/decode entities correctly (also &acute; and other damned characters!)
	public function normalize_encoding($string, $encode = "encode") {
		// encode
		if ($encode == "encode") {
			$string = htmlentities($string, ENT_COMPAT, "UTF-8", false);
		}
		// decode
		else {
			$string = mb_convert_encoding($string, "HTML-ENTITIES", "UTF-8");
			$string = html_entity_decode($string, ENT_COMPAT, "UTF-8");
		}

		return $string;
    }


	/**
		import all data
	**/
	public function import_data($data, $stripslashes=true) {
		$sanitized_json = $stripslashes ? stripslashes($data) : $data;
		$data_json      = json_decode($sanitized_json);

		if (!$data_json) return $this->send_message("error", __("Corrupt form data.", "ezfc"));

		// import global settings
		if (property_exists($data_json, "global_settings")) {
			foreach ($data_json->global_settings as $name => $value) {
				update_option("ezfc_{$name}", $value);
			}
		}

		// import settings
		if (property_exists($data_json, "settings")) {
			$this->update_options($data_json->settings, 0, 0);
		}

		// import forms + form settings
		if (property_exists($data_json, "forms") && count($data_json->forms) > 0) {
			foreach ($data_json->forms as $i => $f) {
				$this->form_import($f);
			}
		}

		return $this->send_message("success", __("Data import complete.", "ezfc"));
	}

	/**
		test mail
	**/
	public function send_test_mail($recipient) {
		$subject = __("ez Form Calculator Test Email", "ezfc");
		$text    = __("This is a test email sent by ez Form Calculator.", "ezfc");

		// use smtp
		if (get_option("ezfc_email_smtp_enabled") == 1) {
			require_once(EZFC_PATH . "lib/PHPMailer/PHPMailerAutoload.php");

			$mail = new PHPMailer();
			$mail->isSMTP();
			$mail->SMTPAuth   = true;
			//$mail->SMTPDebug  = 3;
			$mail->Host       = get_option("ezfc_email_smtp_host");
			$mail->Username   = get_option("ezfc_email_smtp_user");
			$mail->Password   = get_option("ezfc_email_smtp_pass");
			$mail->Port       = get_option("ezfc_email_smtp_port");
			$mail->SMTPSecure = get_option("ezfc_email_smtp_secure");

			$mail->addAddress($recipient);
			$mail->Subject = $subject;
			$mail->Body    = $text;

			if ($mail->send()) {
				$res = __("Mail successfully sent.", "ezfc");
			}
			else {
				$res = __("Unable to send mails:", "ezfc") . $mail->ErrorInfo;
			}

			return $res;
		}
		else {
			$res = wp_mail(
				$recipient,
				$subject,
				$text
			);

			return $res==1 ? __("Mail successfully sent.", "ezfc") : __("Unable to send mails.", "ezfc");
		}
	}

	/**
		ajax message
	**/
	public function send_message($type, $msg, $id=0) {
		return array(
			$type 	=> $msg,
			"id"	=> $id
		);
	}

	public function array_index_key($array, $key) {
		$ret_array = array();

		if (count($array) < 1) return $ret_array;

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

	private function execute_multiline_sql($sql, $delim=";") {
	    global $wpdb;
	    
	    $sqlParts = $this->split_sql_file($sql, $delim);
	    foreach($sqlParts as $part) {
	        $res = $wpdb->query($part);

	        if ($res === false) {
	        	$wpdb->print_error();
	        	return false;
	        }
	    }

	    return true;
	}

	private function split_sql_file($sql, $delimiter) {
	   // Split up our string into "possible" SQL statements.
	   $tokens = explode($delimiter, $sql);

	   // try to save mem.
	   $sql = "";
	   $output = array();

	   // we don't actually care about the matches preg gives us.
	   $matches = array();

	   // this is faster than calling count($oktens) every time thru the loop.
	   $token_count = count($tokens);
	   for ($i = 0; $i < $token_count; $i++)
	   {
	      // Don't wanna add an empty string as the last thing in the array.
	      if (($i != ($token_count - 1)) || (strlen($tokens[$i] > 0)))
	      {
	         // This is the total number of single quotes in the token.
	         $total_quotes = preg_match_all("/'/", $tokens[$i], $matches);
	         // Counts single quotes that are preceded by an odd number of backslashes,
	         // which means they're escaped quotes.
	         $escaped_quotes = preg_match_all("/(?<!\\\\)(\\\\\\\\)*\\\\'/", $tokens[$i], $matches);

	         $unescaped_quotes = $total_quotes - $escaped_quotes;

	         // If the number of unescaped quotes is even, then the delimiter did NOT occur inside a string literal.
	         if (($unescaped_quotes % 2) == 0)
	         {
	            // It's a complete sql statement.
	            $output[] = $tokens[$i];
	            // save memory.
	            $tokens[$i] = "";
	         }
	         else
	         {
	            // incomplete sql statement. keep adding tokens until we have a complete one.
	            // $temp will hold what we have so far.
	            $temp = $tokens[$i] . $delimiter;
	            // save memory..
	            $tokens[$i] = "";

	            // Do we have a complete statement yet?
	            $complete_stmt = false;

	            for ($j = $i + 1; (!$complete_stmt && ($j < $token_count)); $j++)
	            {
	               // This is the total number of single quotes in the token.
	               $total_quotes = preg_match_all("/'/", $tokens[$j], $matches);
	               // Counts single quotes that are preceded by an odd number of backslashes,
	               // which means they're escaped quotes.
	               $escaped_quotes = preg_match_all("/(?<!\\\\)(\\\\\\\\)*\\\\'/", $tokens[$j], $matches);

	               $unescaped_quotes = $total_quotes - $escaped_quotes;

	               if (($unescaped_quotes % 2) == 1)
	               {
	                  // odd number of unescaped quotes. In combination with the previous incomplete
	                  // statement(s), we now have a complete statement. (2 odds always make an even)
	                  $output[] = $temp . $tokens[$j];

	                  // save memory.
	                  $tokens[$j] = "";
	                  $temp = "";

	                  // exit the loop.
	                  $complete_stmt = true;
	                  // make sure the outer loop continues at the right point.
	                  $i = $j;
	               }
	               else
	               {
	                  // even number of unescaped quotes. We still don't have a complete statement.
	                  // (1 odd and 1 even always make an odd)
	                  $temp .= $tokens[$j] . $delimiter;
	                  // save memory.
	                  $tokens[$j] = "";
	               }

	            } // for..
	         } // else
	      }
	   }

	   return $output;
	}

	public function removeslashes($string)	{
		$string=implode("",explode("\\",$string));
		return stripslashes(trim($string));
	}

	public function sort_by_position($a, $b) {
		if (is_object($a)) {
			if (!property_exists($a, "position")) return 0;

			return $a->position > $b->position;
		}
		else if (is_array($a)) {
			if (!isset($a["position"])) return 0;

			return $a["position"] > $b["position"];
		}
	}
}