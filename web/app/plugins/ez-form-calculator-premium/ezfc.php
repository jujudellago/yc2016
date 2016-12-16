<?php
/*
Plugin Name: ez Form Calculator Premium
Plugin URI: http://www.mials.de/mials/ezfc/
Description: With ez Form Calculator, you can simply create a form calculator for both yourself and your customers. Easily add basic form elements like checkboxes, dropdown menus, radio buttons etc. with only a few clicks. Each form element can be assigned a value which will be calculated automatically.
Version: 2.9.2.0
Author: Michael Schuppenies
Author URI: http://www.mials.de/
*/

defined( 'ABSPATH' ) OR exit;

if (defined("EZFC_VERSION")) return;

/**
	setup
**/
define("EZFC_VERSION", "2.9.2.0");
define("EZFC_PATH", plugin_dir_path(__FILE__));
define("EZFC_SLUG", plugin_basename(__FILE__));
define("EZFC_URL", plugin_dir_url(__FILE__));
define("EZFC_UPDATE_URL", "http://www.ezplugins.de/licensing/versions.php?slug=ezfc");

// ez functions
require_once(EZFC_PATH . "class.ezfc_functions.php");

// wrapper
function ezfc_get_version() {
	return EZFC_VERSION;
}

/**
	install
**/
function ezfc_register() {
	require_once(EZFC_PATH . "ezfc-register.php");
}

/**
	uninstall
**/
function ezfc_uninstall() {
	require_once(EZFC_PATH . "ezfc-uninstall.php");
}

// hooks
register_activation_hook(__FILE__, "ezfc_register");
register_uninstall_hook(__FILE__, "ezfc_uninstall");

// custom filter
add_filter("ezfc_custom_filter_test", "ezfc_test_filter", 0, 2);
function ezfc_test_filter($element_data, $input_value) {
	if ($input_value%2 == 1) {
		return array("error" => "Error!");
	}
}


class EZFC_Premium {
	/**
		init plugin
	**/
	static function init() {
		// setup pages
		add_action("admin_menu", array(__CLASS__, "admin_menu"));
		// check for updates
		add_action("init", array(__CLASS__, "check_updates"));
		// load languages
		add_action("plugins_loaded", array(__CLASS__, "load_language"));

		// load backend scripts / styles
		add_action("admin_enqueue_scripts", array(__CLASS__, "load_scripts"));

		// settings page
		$ezfc_plugin_name = plugin_basename(__FILE__);
		add_filter("plugin_action_links_{$ezfc_plugin_name}", array(__CLASS__, "plugin_settings_page"));

		// ** ajax **
		// backend
		add_action("wp_ajax_ezfc_backend", array(__CLASS__, "ajax"));
		// frontend
		add_action("wp_ajax_ezfc_frontend", array(__CLASS__, "ajax_frontend"));
		add_action("wp_ajax_nopriv_ezfc_frontend", array(__CLASS__, "ajax_frontend"));
		// frontend fileupload
		add_action("wp_ajax_ezfc_frontend_fileupload", array(__CLASS__, "ajax_fileupload"));
		add_action("wp_ajax_nopriv_ezfc_frontend_fileupload", array(__CLASS__, "ajax_fileupload"));

		// tinymce
		add_action("admin_head", array(__CLASS__, "tinymce"));
		add_action("admin_print_scripts", array(__CLASS__, "tinymce_script"));

		// widget
		add_action("widgets_init", array(__CLASS__, "register_widget"));

		if ( ! function_exists( 'is_plugin_active_for_network' ) ) {
			require_once( ABSPATH . '/wp-admin/includes/plugin.php' );
		}
		// woocommerce check
		if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins'))) ||
			is_plugin_active_for_network('woocommerce/woocommerce.php')) {
			add_action("woocommerce_before_calculate_totals", array(__CLASS__, "add_custom_price"));

			// show selected values on checkout page?
			if (get_option("ezfc_woocommerce_checkout_details") == 1) {
				add_filter("woocommerce_get_item_data", array(__CLASS__, "woo_add_item_data"), 10, 2);

				// checkout / emails
				add_action("woocommerce_add_order_item_meta", array(__CLASS__, "woo_add_order_item_meta"), 10, 3);
			}
		}
	}

	/**
		admin pages
	**/
	static function admin_menu() {
		// user role
		$role = "edit_posts";
		
		require_once(EZFC_PATH . "/class.ezfc_backend.php");
		$ezfc_backend = new Ezfc_backend();

		// notification bubble
		//$unread_submissions = $ezfc_backend->get_unread_submissions();

		if (substr($_SERVER['REMOTE_ADDR'], 0, 4) != '127.' && $_SERVER['REMOTE_ADDR'] != '::1') {
			$licensed = get_option("ezfc_license_activated", 0)==1;

			if (!$licensed) {
				add_action('admin_notices', array( __CLASS__, "show_register_notice" ));
			}
		}

		// setup pages
		add_menu_page("ezfc", __("ez Form Calculator", "ezfc"), $role, "ezfc", array(__CLASS__, "page_main"), EZFC_URL . "assets/img/ez-icon.png");
		add_submenu_page("ezfc", __("Form settings", "ezfc"), __("Form settings", "ezfc"), $role, "ezfc-settings-form", array(__CLASS__, "page_settings_form"));
		add_submenu_page("ezfc", __("Form submissions", "ezfc"), __("Form submissions", "ezfc"), $role, "ezfc-submissions", array(__CLASS__, "page_submissions"));
		add_submenu_page("ezfc", __("Global settings", "ezfc"), __("Global settings", "ezfc"), $role, "ezfc-options", array(__CLASS__, "page_settings"));
		add_submenu_page("ezfc", __("Import / export", "ezfc"), __("Import / Export", "ezfc"), $role, "ezfc-importexport", array(__CLASS__, "page_importexport"));
		add_submenu_page("ezfc", __("Help / debug", "ezfc"), __("Help / debug", "ezfc"), $role, "ezfc-help", array(__CLASS__, "page_help"));
		add_submenu_page("ezfc", __("Licensing", "ezfc"), __("Licensing", "ezfc"), $role, "ezfc-licensing", array(__CLASS__, "page_licensing"));
		add_submenu_page("ezfc", __("Templates", "ezfc"), __("Templates", "ezfc"), $role, "ezfc-templates", array(__CLASS__, "page_templates"));
		add_submenu_page("ezfc", __("Update", "ezfc"), __("Update", "ezfc"), $role, "ezfc-update", array(__CLASS__, "page_update"));
	}

	static function show_register_notice() {
		echo '
		<div class="updated">
		  <p>' . __("Hello! Please register your license to receive automatic updates for <strong>ez Form Calculator Premium</strong>.", "ezfc") . ' <a href="' . admin_url('admin.php') . '?page=ezfc-licensing">' . __("Register license", "ezfc") . '</a></p>
		</div>';
	}

	static function page_main() {
		require_once(EZFC_PATH . "ezfc-page-main.php");
	}

	static function page_settings_form() {
		require_once(EZFC_PATH . "ezfc-page-settings-form.php");
	}

	static function page_settings() {
		require_once(EZFC_PATH . "ezfc-page-settings.php");
	}

	static function page_importexport() {
		require_once(EZFC_PATH . "ezfc-page-importexport.php");
	}

	static function page_help() {
		require_once(EZFC_PATH . "ezfc-page-help.php");
	}

	static function page_licensing() {
		require_once(EZFC_PATH . "ezfc-page-licensing.php");
	}

	static function page_submissions() {
		require_once(EZFC_PATH . "ezfc-page-submissions.php");
	}


	static function page_templates() {
		require_once(EZFC_PATH . "ezfc-page-templates.php");
	}

	static function page_update() {
		require_once(EZFC_PATH . "ezfc-page-update.php");
	}

	/**
		add settings to plugins page
	**/
	static function plugin_settings_page($links) { 
		$settings_link = "<a href='" . admin_url("admin.php") . "?page=ezfc-options'>" . __("Global Settings", "ezfc") . "</a>";
		array_unshift($links, $settings_link);

		$form_settings_link = "<a href='" . admin_url("admin.php") . "?page=ezfc-settings-form'>" . __("Form Settings", "ezfc") . "</a>";
		array_unshift($links, $form_settings_link);

		return $links; 
	}

	/**
		ajax
	**/
	// frontend
	static function ajax_frontend() {
		require_once(EZFC_PATH . "ajax.php");
	}

	// frontend file upload
	static function ajax_fileupload() {
		require_once(EZFC_PATH . "ajax-fileupload.php");
	}

	// backend
	static function ajax() {
		require_once(EZFC_PATH . "ajax-admin.php");
	}


	/**
		language domain
	**/
	static function load_language() {
		load_plugin_textdomain("ezfc", false, dirname(plugin_basename(__FILE__)) . '/lang/');
	}

	/**
		scripts
	**/
	static function load_scripts($page, $force_load=false) {
		if (!$force_load && $page != "toplevel_page_ezfc" && substr($page, 0, 23) != "ez-form-calculator_page") return;

		wp_enqueue_media();
		
		wp_enqueue_style("bootstrap-grid", plugins_url("assets/css/bootstrap-grid.min.css", __FILE__));
		wp_enqueue_style("ezfc-jquery-ui", plugins_url("assets/css/jquery-ui.min.css", __FILE__));
		wp_enqueue_style("ezfc-jquery-ui-theme", plugins_url("assets/css/jquery-ui.theme.min.css", __FILE__));
		wp_enqueue_style("jquerytimepicker-css", plugins_url("assets/css/jquery.timepicker.css", __FILE__));
		wp_enqueue_style("opentip", plugins_url("assets/css/opentip.css", __FILE__));
		wp_enqueue_style("thickbox");
		wp_enqueue_style("ezfc-css-backend", plugins_url("style-backend.css", __FILE__), array(), EZFC_VERSION);
		wp_enqueue_style("ezfc-font-awesome", plugins_url("assets/css/font-awesome.min.css", __FILE__));

		wp_enqueue_script("jquery");
		wp_enqueue_script("jquery-ui-core");
		wp_enqueue_script("jquery-ui-mouse");
		wp_enqueue_script("jquery-ui-widget");
		wp_enqueue_script("jquery-ui-dialog");
		wp_enqueue_script("jquery-ui-draggable");
		wp_enqueue_script("jquery-ui-droppable");
		wp_enqueue_script("jquery-ui-selectable");
		wp_enqueue_script("jquery-ui-sortable");
		wp_enqueue_script("jquery-ui-spinner");
		wp_enqueue_script("jquery-ui-tabs");
		wp_enqueue_script("jquery-opentip", plugins_url("assets/js/opentip-jquery.min.js", __FILE__), array("jquery"));
		wp_enqueue_script("numeraljs", plugins_url("assets/js/numeral.min.js", __FILE__), array("jquery"));
		wp_enqueue_script("jquerytimepicker", plugins_url("assets/js/jquery.timepicker.min.js", __FILE__), array("jquery"));
		//wp_enqueue_script("jquery-nestedsortable", plugins_url("assets/js/jquery.mjs.nestedSortable.js", __FILE__), array("jquery"));
		wp_enqueue_script("ezfc-jquery-file-upload", plugins_url("assets/js/jquery.fileupload.min.js", __FILE__), array("jquery"));
		wp_enqueue_script("jquery-iframe-transport", plugins_url("assets/js/jquery.iframe-transport.min.js", __FILE__), array("jquery-ui-widget"));
		wp_enqueue_script("thickbox");
		wp_enqueue_script("wp-color-picker");
		wp_enqueue_script("ezfc-backend", plugins_url("backend.js", __FILE__), array("jquery"), EZFC_VERSION);

		wp_localize_script("ezfc-backend", "ezfc_vars", array(
			"delete" => __("Delete", "ezfc"),
			"delete_form" => __("Really delete the selected form?", "ezfc"),
			"delete_element" => __("Really delete the selected element?", "ezfc"),
			"form_changed" => __("You have changed the form without having saved. Really leave the current form unsaved?"),
			"submit_button" => __("Submit button", "ezfc"),
			"unavailable_element" => __("Unavailable for this element.", "ezfc"),
			"yes_no" => array(
				"yes" => __("Yes", "ezfc"),
				"no"  => __("No", "ezfc")
			),
			"element_option_description" => array(
				"add_line" => __("Add a line above step buttons.", "ezfc"),
				"calculate" => __("Choose the operator and target element to calculate with. <br><br>Example: [ * ] [ field_1 ]<br>Result = current_value + field_1 * this_field.", "ezfc"),
				"calculate_enabled" => __("When checked, this field will be taken into calculations.", "ezfc"),
				"calculate_before" => __("When checked, this field will be calculated first. <br><br><strong>Checked</strong>: this_field / target_calculation_field. <br><br><strong>Unchecked</strong>: target_calculation_field / this_field.", "ezfc"),
				"calculate_when_hidden" => __("Whether to take this element into calculations when it is hidden or not.", "ezfc"),
				"class" => __("Additional CSS class for this element.", "ezfc"),
				"conditional" => __("Conditional fields can show or hide elements. Check out the conditional example from the templates or visit the documentation site for more information.", "ezfc"),
				"custom_regex" => __("Custom regular expression. Only numbers allowed example: /[0-9]/i", "ezfc"),
				"custom_error_message" => __("Error message when element value does not validate regular expression from custom_regex", "ezfc"),
				"description" => __("Users will see the description in a tooltip.", "ezfc"),
				"discount" => __("Discount values", "ezfc"),
				"double_check" => __("Double check email-address", "ezfc"),
				"factor" => __("The value will be automatically multiplied by this factor. Default factor: 1", "ezfc"),
				"GET" => __("This field will be filled from a GET-parameter. Example: <br><br><strong>URL</strong>: http://www.test.com/?test_value=1 <br><strong>GET</strong>: test_value <br><strong>Field value</strong>: 1.", "ezfc"),
				"hidden" => __("Hidden field. If this field is taken into conditional calculations, you need to set this option to Conditional hidden.", "ezfc"),
				"inline" => __("Display options in a row.", "ezfc"),
				"is_currency" => __("Format this field as currency value in submissions.", "ezfc"),
				"label" => __("This text will be displayed in the frontend.", "ezfc"),
				"max" => __("Maximum value", "ezfc"),
				"maxDate" => __("The opposite of minDate.", "ezfc"),
				"min" => __("Minimum value", "ezfc"),
				"minDate" => __("Minimum date of both dates. Example: +1d;;+2d - the first datepicker (from) will only have selectable dates 1 day in the future, the second datepicker (to) will only have selectable dates 2 days in the future", "ezfc"),
				"minDays" => __("The amount of minimum days to select.", "ezfc"),
				"multiple" => __("When checked, multiple files can be uploaded.", "ezfc"),
				"name" => __("Internal name. This value is displayed in submissions/emails only.", "ezfc"),
				"overwrite_price" => __("When checked, this field will override the calculations above. Useful with division operator. <br><br><strong>Checked</strong>: result = target_calculation_field / this_field. <br><br><strong>Unchecked</strong>: result = current_value + target_calculation_field / this_field.", "ezfc"),
				"placeholder" => __("Placeholder only (slight background text when no value is present).", "ezfc"),
				"post_id" => __("Enter the ID of the post you want to show.", "ezfc"),
				"price_format" => __("Custom price format (see numeraljs.com for syntax). Default: 0,0[.]00", "ezfc"),
				"required" => __("Whether this is a required field or not.", "ezfc"),
				"show_in_email" => __("Show this element in emails", "ezfc"),
				"slider" => __("Display a slider instead of a textfield. Needs minimum and maximum fields defined.", "ezfc"),
				"slidersteps" => __("Slider step value", "ezfc"),
				"spinner" => __("Display a spinner instead of a textfield.", "ezfc"),
				"steps_slider" => __("Incremental steps", "ezfc"),
				"steps_spinner" => __("Incremental steps", "ezfc"),
				"style" => __("CSS inline style, example (without quotes): \"color: #f00; margin-top: 1em;\"", "ezfc"),
				"text_after" => __("Text after price", "ezfc"),
				"text_before" => __("Text before price", "ezfc"),
				"use_address" => __("Emails will be sent to this address.", "ezfc"),
				"text_only" => __("Display text only instead of an input field", "ezfc"),
				"value" => __("Predefined value.", "ezfc"),
				"value_external" => __("DOM-selector to get the value from (e.g. #myinputfield).", "ezfc"),
				"wrapper_class" => __("CSS class that will be added to the element wrapper.", "ezfc"),
				"wrapper_style" => __("CSS inline style that will be added to the element wrapper.", "ezfc")
			)
		));
	}

	/**
		tinymce button
	**/
	static function tinymce() {
		global $typenow;

		if( ! in_array( $typenow, array( 'post', 'page' ) ) )
			return;

		add_filter('mce_external_plugins', array(__CLASS__, 'add_tinymce_plugin'));
		add_filter('mce_buttons', array(__CLASS__, 'add_tinymce_button'));
	}

	static function tinymce_script() {
		global $typenow;

		if( ! in_array( $typenow, array( 'post', 'page' ) ) )
			return;

		require_once(EZFC_PATH . "class.ezfc_backend.php");
		$ezfc_backend = new Ezfc_backend();

		echo "<script>ezfc_forms = " . json_encode($ezfc_backend->forms_get()) . ";</script>";
	}

	static function add_tinymce_plugin( $plugin_array ) {
		$plugin_array['ezfc_tinymce'] = plugins_url('/ezfc_tinymce.js', __FILE__ );

		return $plugin_array;
	}

	static function add_tinymce_button( $buttons ) {
		array_push( $buttons, 'ezfc_tinymce_button' );

		return $buttons;
	}

	/**
		woocommerce custom price hook
	**/
	static function add_custom_price( $cart_object ) {
		require_once(EZFC_PATH . "class.ezfc_backend.php");
		$ezfc = new Ezfc_backend();

		foreach ( $cart_object->cart_contents as $key => $value ) {
			// do not mess with other products
			if (!isset($value["ezfc_total"])) return;
			
			// change price
			$value["data"]->set_price($value["ezfc_total"]);
		}
	}

	/**
		woocommerce add cart item data
	**/
	static function woo_add_item_data( $cart_array, $cart_data ) {
		// do not mess with other products
		if (!isset($cart_data["ezfc_values"])) return;
		
		return array(array(
			"name"  => get_option("ezfc_woocommerce_checkout_details_text"),
			"value" => $cart_data["ezfc_values"]
		));
	}

	/**
		wocommerce add item data to checkout / emails
	**/
	static function woo_add_order_item_meta($item_id, $values, $cart_item_key) {
		if (!empty($values["ezfc_values"])) {
			
			woocommerce_add_order_item_meta($item_id, get_option("ezfc_woocommerce_checkout_details_text"), $values["ezfc_values"]);
		}
	}

	/**
		check for updates
	**/
	static function check_updates() {
		$remote_url    = EZFC_UPDATE_URL;
		$purchase_code = get_option("ezfc_purchase_code", "");

		if (!empty($purchase_code)) {
			$remote_url .= "&code={$purchase_code}";
		}

		require_once(EZFC_PATH . "/plugin-updates/plugin-update-checker.php");
		PucFactory::buildUpdateChecker(
			$remote_url,
			__FILE__,
			"ezfc"
		);
	}

	/**
		widget
	**/
	static function register_widget() {
		require_once(EZFC_PATH . "widget.php");

		return register_widget("Ezfc_widget");
	}
}
EZFC_Premium::init();

/**
	shortcodes
**/
class Ezfc_shortcode {
	static $add_script;
	static $ezfc_frontend;

	static function init() {
		require_once(EZFC_PATH . "class.ezfc_frontend.php");
		self::$ezfc_frontend = new Ezfc_frontend();

		add_shortcode("ezfc", array(__CLASS__, "get_output"));
		add_shortcode("ezfc_verify", array(__CLASS__, "paypal_verify"));

		add_action("wp_head", array(__CLASS__, "wp_head"));
		add_action("wp_footer", array(__CLASS__, "print_script"));

		// woocommerce add form hook
		$woo_add_hook = get_option("ezfc_woocommerce_add_hook");
		if (!empty($woo_add_hook) && get_option("ezfc_woocommerce_add_forms") == 1) {
			add_action($woo_add_hook, array(__CLASS__, "woo_add_form"));
		}
	}

	static function get_form_output($id, $name=null, $product_id=null, $theme=null) {
		return self::$ezfc_frontend->get_output($id, $name, $product_id, $theme);
	}

	static function get_output($atts) {
		self::$add_script = true;

		extract(shortcode_atts(array(
			"id"    => null,
			"name"  => null,
			"theme" => null
		), $atts));

		$id = (int) $id;

		return self::get_form_output($id, $name, null, $theme);
	}

	static function paypal_verify($atts, $content = null) {
		require_once(EZFC_PATH . "lib/paypal/expresscheckout.php");

		if (!isset($_GET["PayerID"])) return __("No PayerID.", "ezfc");

		// verify paypal payment
		$_SESSION["payer_id"] = $_GET["PayerID"];
		$confirmation = Ezfc_paypal::confirm();

		// no payment
		if (!$confirmation || isset($confirmation["error"])) {
			return __("Payment could not be verified. :(", "ezfc");
		}

		// user paid $$$ --> update submission
		$update = self::$ezfc_frontend->update_submission_paypal($_GET["token"], $confirmation["transaction_id"]);

		if (!$update || isset($update["error"])) return $update["error"];

		// get form options
		$options = self::$ezfc_frontend->array_index_key(self::$ezfc_frontend->form_get_options($update["submission"]->f_id), "name");

		// prepare submission data for mails
		self::$ezfc_frontend->prepare_submission_data($update["submission"]->f_id, json_decode($update["submission"]->data), false, $update["submission"]->ref_id);
		// send mails
		self::$ezfc_frontend->send_mails($update["submission"]->id);

		return $options["pp_paid_text"]->value;
	}

	static function woo_add_form() {
		$product_id = get_the_ID();
		// check if we are in the loop
		if (!$product_id) return;

		// check post meta
		$form_id = get_post_meta($product_id, "ezfc_form_id", true);

		// no single form id found -> get global form id instead
		if (!$form_id) {
			$global_form_id = get_option("ezfc_woocommerce_global_form_id");

			// no global form found
			if (empty($global_form_id)) return;

			// check if form is restricted to categories
			$form_options = self::$ezfc_frontend->form_get_option_values($global_form_id);
			$cat_forms = explode(",", $form_options["woo_categories"]);

			if (is_array($cat_forms) && count($cat_forms) > 0) {
				$category_name = wp_get_post_terms($product_id, "product_cat");
				$form_add = false;

				foreach ($category_name as $cat) {
					if (in_array($cat->slug, $cat_forms)) {
						$form_add = true;
						break;
					}
				}

				if (!$form_add) return;
			}

			$form_id = $global_form_id;
		}

		self::$add_script = true;

		echo self::get_form_output($form_id, null, $product_id);
	}

	static function wp_head() {
		wp_register_style("ezfc-css-frontend", plugins_url("style-frontend.css", __FILE__), array(), EZFC_VERSION);

		if (get_option("ezfc_load_custom_styling", 0) == 1) {
			wp_add_inline_style("ezfc-css-frontend", get_option("ezfc_css_custom_styling", ""));
		}
	}

	static function print_script() {
		if ( ! self::$add_script )
			return;

		if (get_option("ezfc_jquery_ui") == 1) {
			wp_enqueue_style("jquery-ui", plugins_url("assets/css/jquery-ui.min.css", __FILE__));
			wp_enqueue_style("jquery-ui", plugins_url("assets/css/jquery-ui.theme.min.css", __FILE__));
		}
		wp_enqueue_style("opentip", plugins_url("assets/css/opentip.css", __FILE__));
		wp_enqueue_style("ezfc-font-awesome", plugins_url("assets/css/font-awesome.min.css", __FILE__));
		wp_enqueue_style("ezfc-css-frontend", plugins_url("style-frontend.css", __FILE__), array(), EZFC_VERSION);

		// datepicker language
		if (get_option("ezfc_datepicker_load_languages", 0) == 1) {
			wp_enqueue_script("jquery-languages", plugins_url("assets/js/jquery.ui.i18n.all.min.js", __FILE__));
		}

		wp_enqueue_script("jquery");
		wp_enqueue_script("jquery-ui-core");
		wp_enqueue_script("jquery-ui-datepicker");
		wp_enqueue_script("jquery-ui-dialog");
		wp_enqueue_script("jquery-ui-widget");
		wp_enqueue_script("jquery-touch-punch", plugins_url("assets/js/jquery.ui.touch-punch.min.js", __FILE__), array("jquery"));
		wp_enqueue_script("jquery-opentip", plugins_url("assets/js/opentip-jquery.min.js", __FILE__), array("jquery"));
		wp_enqueue_script("numeraljs", plugins_url("assets/js/numeral.min.js", __FILE__), array("jquery"));
		wp_enqueue_script("jquery-countto", plugins_url("assets/js/jquery.countTo.min.js", __FILE__), array("jquery"));

		if (get_option("ezfc_debug_mode", 0) == 0) {
			wp_enqueue_script("ezfc-frontend", plugins_url("frontend.min.js", __FILE__), array("jquery"), EZFC_VERSION);	
		}
		else {
			wp_enqueue_script("ezfc-frontend", plugins_url("frontend.js", __FILE__), array("jquery"), microtime(true));
		}

		// woocommerce addon
		if (get_option("ezfc_woocommerce_add_forms") == 1) {
			wp_enqueue_script("ezfc-frontend-woo", plugins_url("frontend-woo.js", __FILE__), array("jquery", "ezfc-frontend"), EZFC_VERSION);	
		}

		// general options
		wp_localize_script("ezfc-frontend", "ezfc_vars", array(
			"ajaxurl"   => admin_url( 'admin-ajax.php' ),
			"form_vars" => array(),

			"auto_scroll_steps"         => get_option("ezfc_auto_scroll_steps", 1),
			"datepicker_language"       => get_option("ezfc_datepicker_language", "en"),
			"debug_mode"                => get_option("ezfc_debug_mode", 0),
			"noid"                      => __("No form with the requested ID found.", "ezfc"),
			"price_format"              => get_option("ezfc_price_format"),
			"price_format_dec_num"      => get_option("ezfc_email_price_format_dec_num", 2),
			"price_format_dec_point"    => get_option("ezfc_email_price_format_dec_point", "."),
			"price_format_dec_thousand" => get_option("ezfc_email_price_format_thousand", ","),
			"uploading"                 => __("Uploading...", "ezfc"),
			"upload_success"            => __("File upload successful.", "ezfc"),
			"yes_no" => array(
				"yes" => __("Yes", "ezfc"),
				"no"  => __("No", "ezfc")
			)
		));

		// extension scripts / styles
		do_action("ezfc_ext_enqueue_scripts");
	}
}
Ezfc_shortcode::init();