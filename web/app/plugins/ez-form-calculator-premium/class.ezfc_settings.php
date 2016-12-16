<?php

abstract class Ezfc_settings {
	/**
		form elements
	**/
	static function get_elements() {
		$elements = array(
			array(
				"id" => 1,
				"name" => "Input",
				"description" => __("Basic input field with no restrictions", "ezfc"),
				"type" => "input",
				"data" => array(
					"name" => "Input",
					"label" => "Text",
					"required" => 0,
					"value" => "",
					"value_external" => "",
					"placeholder" => "",
					"icon" => "",
					"custom_regex" => "",
					"custom_error_message" => "",
					"custom_filter" => "",
					"show_in_email" => 1,
					"description" => "",
					"class" => "",
					"wrapper_class" => "",
					"style" => "",
					"wrapper_style" => "",
					"GET" => "",
					"hidden" => 0,
					"columns" => 6,
					"group_id" => 0
				),
				"icon" => "fa-pencil-square-o",
				"category" => "basic"
			),
			array(
				"id" => 2,
				"name" => "Email",
				"description" => __("Email input field", "ezfc"),
				"type" => "email",
				"data" => array(
					"name" => "Email",
					"label" => "Email",
					"required" => 0,
					"use_address" => 1,
					"double_check" => 0,
					"value" => "",
					"value_external" => "",
					"placeholder" => "",
					"icon" => "",
					"show_in_email" => 1,
					"description" => "",
					"class" => "",
					"wrapper_class" => "",
					"style" => "",
					"wrapper_style" => "",
					"GET" => "",
					"hidden" => 0,
					"columns" => 6,
					"group_id" => 0
				),
				"icon" => "fa-envelope-o",
				"category" => "basic"
			),
			array(
				"id" => 3,
				"name" => "Textfield",
				"description" => __("Large text field", "ezfc"),
				"type" => "textfield",
				"data" => array(
					"name" => "Textfield",
					"label" => "Textfield",
					"required" => 0,
					"value" => "",
					"value_external" => "",
					"placeholder" => "",
					"icon" => "",
					"show_in_email" => 1,
					"description" => "",
					"class" => "",
					"wrapper_class" => "",
					"style" => "",
					"wrapper_style" => "",
					"GET" => "",
					"hidden" => 0,
					"columns" => 6,
					"group_id" => 0
				),
				"icon" => "fa-align-justify",
				"category" => "basic"
			),
			array(
				"id" => 4,
				"name" => "Dropdown",
				"description" => __("Dropdown list", "ezfc"),
				"type" => "dropdown",
				"data" => array(
					"name" => "Dropdown",
					"label" => "Dropdown",
					"required" => 0,
					"calculate_enabled" => 1,
					"is_currency" => 1,
					"options" => array(array("value" => "0", "text" => "Option 0")),
					"calculate" => array(array("operator" => "", "target" => 0,"value" => "")),
					"overwrite_price" => 0,
					"calculate_when_hidden" => 1,
					"calculate_before" => 0,
					"conditional" => array(array("action" => "", "target" => 0,"operator" => "", "value" => "")),
					"discount" => array(array("range_min" => "", "range_max" => "", "operator" => "", "discount_value" => "")),
					"show_in_email" => 1,
					"description" => "",
					"class" => "",
					"wrapper_class" => "",
					"style" => "",
					"wrapper_style" => "",
					"hidden" => 0,
					"columns" => 6,
					"group_id" => 0
				),
				"icon" => "fa-list-ul",
				"category" => "calc"
			),
			array(
				"id" => 5,
				"name" => "Radio Button",
				"description" => __("Used for single-choice elements.", "ezfc"),
				"type" => "radio",
				"data" => array(
					"name" => "Radio",
					"label" => "Radio",
					"required" => 0,
					"calculate_enabled" => 1,
					"is_currency" => 1,
					"options" => array(array("value" => "0", "text" => "Option 0")),
					"calculate" => array(array("operator" => "", "target" => 0,"value" => "")),
					"overwrite_price" => 0,
					"calculate_when_hidden" => 1,
					"calculate_before" => 0,
					"conditional" => array(array("action" => "", "target" => 0,"operator" => "", "value" => "")),
					"discount" => array(array("range_min" => "", "range_max" => "", "operator" => "", "discount_value" => "")),
					"show_in_email" => 1,
					"description" => "",
					"inline" => 0,
					"class" => "",
					"wrapper_class" => "",
					"style" => "",
					"wrapper_style" => "",
					"hidden" => 0,
					"columns" => 6,
					"group_id" => 0
				),
				"icon" => "fa-dot-circle-o",
				"category" => "calc"
			),
			array(
				"id" => 6,
				"name" => "Checkbox",
				"description" => __("Checky check!", "ezfc"),
				"type" => "checkbox",
				"data" => array(
					"name" => "Checkbox",
					"label" => "Checkbox",
					"required" => 0,
					"calculate_enabled" => 1,
					"is_currency" => 1,
					"options" => array(array("value" => "0", "text" => "Checkbox 0")),
					"calculate" => array(array("operator" => "", "target" => 0,"value" => "")),
					"overwrite_price" => 0,
					"calculate_when_hidden" => 1,
					"calculate_before" => 0,
					"conditional" => array(array("action" => "", "target" => 0,"operator" => "", "value" => "")),
					"discount" => array(array("range_min" => "", "range_max" => "", "operator" => "", "discount_value" => "")),
					"show_in_email" => 1,
					"inline" => 0,
					"description" => "",
					"class" => "",
					"wrapper_class" => "",
					"style" => "",
					"wrapper_style" => "",
					"hidden" => 0,
					"columns" => 6,
					"group_id" => 0
				),
				"icon" => "fa-check-circle-o",
				"category" => "calc"
			),
			array(
				"id" => 7,
				"name" => "Numbers",
				"description" => __("Numbers only", "ezfc"),
				"type" => "numbers",
				"data" => array(
					"name" => "Numbers",
					"label" => "Numbers",
					"required" => 0,
					"calculate_enabled" => 1,
					"is_currency" => 1,
					"factor" => "",
					"value" => "",
					"value_external" => "",
					"min" => "",
					"max" => "",
					"slider" => 0,
					"steps_slider" => 1,
					"spinner" => 0,
					"steps_spinner" => 1,
					"pips" => 0,
					"steps_pips" => 1,
					"calculate" => array(array("operator" => "", "target" => 0,"value" => "")),
					"overwrite_price" => 0,
					"calculate_when_hidden" => 1,
					"calculate_before" => 0,
					"conditional" => array(array("action" => "", "target" => 0,"operator" => "", "value" => "")),
					"discount" => array(array("range_min" => "", "range_max" => "", "operator" => "", "discount_value" => "")),
					"custom_filter" => "",
					"placeholder" => "",
					"icon" => "",
					"show_in_email" => 1,
					"description" => "",
					"class" => "",
					"wrapper_class" => "",
					"style" => "",
					"wrapper_style" => "",
					"GET" => "",
					"hidden" => 0,
					"columns" => 6,
					"group_id" => 0
				),
				"icon" => "fa-html5",
				"category" => "calc"
			),
			array(
				"id" => 8,
				"name" => "Date",
				"description" => __("Datepicker", "ezfc"),
				"type" => "datepicker",
				"data" => array(
					"name" => "Datepicker",
					"label" => "Datepicker",
					"required" => 0,
					"value" => "",
					"value_external" => "",
					"placeholder" => "",
					"icon" => "",
					"show_in_email" => "1",
					"description" => "",
					"minDate" => "",
					"maxDate" => "",
					"numberOfMonths" => "1",
					"showAnim" => "fadeIn",
					"showWeek" => "0",
					"firstDay" => "1",
					"class" => "",
					"wrapper_class" => "",
					"style" => "",
					"wrapper_style" => "",
					"GET" => "",
					"hidden" => 0,
					"columns" => 6,
					"group_id" => 0
				),
				"icon" => "fa-calendar",
				"category" => "basic"
			),
			array(
				"id" => 9,
				"name" => "Image",
				"description" => __("Shows images", "ezfc"),
				"type" => "image",
				"data" => array(
					"name" => "Image",
					"image" => "",
					"alt" => "",
					"show_in_email" => 1,
					"class" => "",
					"wrapper_class" => "",
					"style" => "",
					"wrapper_style" => "",
					"GET" => "",
					"hidden" => 0,
					"columns" => 6,
					"group_id" => 0
				),
				"icon" => "fa-picture-o",
				"category" => "other"
			),
			
			array(
				"id" => 10,
				"name" => "Hidden",
				"description" => __("Hidden input field", "ezfc"),
				"type" => "hidden",
				"data" => array(
					"name" => "Hidden",
					"label" => "Hidden",
					"required" => 0,
					"calculate_enabled" => 1,
					"is_currency" => 1,
					"calculate" => array(array("operator" => "", "target" => 0,"value" => "")),
					"overwrite_price" => 0,
					"calculate_when_hidden" => 1,
					"factor" => "", 
					"value" => "",
					"value_external" => "",
					"conditional" => array(array("action" => "", "target" => 0,"operator" => "", "value" => "")),
					"discount" => array(array("range_min" => "", "range_max" => "", "operator" => "", "discount_value" => "")),
					"show_in_email" => 1,
					"class" => "",
					"wrapper_class" => "",
					"style" => "",
					"wrapper_style" => "",
					"GET" => "",
					"hidden" => 0,
					"columns" => 6,
					"group_id" => 0
				),
				"icon" => "fa-square-o",
				"category" => "other"
			),
			array(
				"id" => 11,
				"name" => "Line",
				"description" => __("Horizontal line", "ezfc"),
				"type" => "hr",
				"data" => array(
					"name" => "",
					"class" => "",
					"wrapper_class" => "",
					"style" => "",
					"wrapper_style" => "",
					"hidden" => 0,
					"columns" => 6,
					"group_id" => 0
				),
				"icon" => "fa-minus",
				"category" => "other"
			),
			array(
				"id" => 12,
				"name" => "HTML",
				"description" => __("Custom HTML or basic text", "ezfc"),
				"type" => "html",
				"data" => array(
					"name" => "HTML",
					"html" => "",
					"show_in_email" => 0,
					"hidden" => 0,
					"columns" => 6,
					"group_id" => 0
				),
				"icon" => "fa-code",
				"category" => "other"
			),
			array(
				"id" => 13,
				"name" => "Recaptcha",
				"description" => __("Recaptcha", "ezfc"),
				"type" => "recaptcha",
				"data" => array(
					"name" => "Verification",
					"label" => "Verification",
					"required" => 1,
					"value" => "",
					"value_external" => "",
					"placeholder" => "",
					"class" => "",
					"wrapper_class" => "",
					"style" => "",
					"wrapper_style" => "",
					"hidden" => 0,
					"columns" => 6,
					"group_id" => 0
				),
				"icon" => "fa-lock",
				"category" => "other"
			),
			array(
				"id" => 14,
				"name" => "File upload",
				"description" => __("File upload", "ezfc"),
				"type" => "fileupload",
				"data" => array(
					"name" => "File upload",
					"label" => "File upload",
					"required" => 0,
					"multiple" => 0,
					"placeholder" => "",
					"class" => "",
					"wrapper_class" => "",
					"hidden" => 0,
					"columns" => 6,
					"group_id" => 0
				),
				"icon" => "fa-file-o",
				"category" => "other"
			),
			array(
				"id" => 15,
				"name" => "Subtotal",
				"description" => __("This element holds the subtotal value up to the point the element is placed at.", "ezfc"),
				"type" => "subtotal",
				"data" => array(
					"name" => "Subtotal",
					"label" => "Subtotal",
					"calculate_enabled" => 1,
					"is_currency" => 1,
					"overwrite_price" => 1,
					"calculate_when_hidden" => 1,
					"price_format" => "",
					"precision" => 2,
					"text_only" => 0,
					"text_before" => "",
					"text_after" => "",
					"calculate" => array(array("operator" => "", "target" => 0,"value" => "")),
					"conditional" => array(array("action" => "", "target" => 0,"operator" => "", "value" => "")),
					"discount" => array(array("range_min" => "", "range_max" => "", "operator" => "", "discount_value" => "")),
					"show_in_email" => 1,
					"description" => "",
					"class" => "",
					"wrapper_class" => "",
					"style" => "",
					"wrapper_style" => "",
					"hidden" => 0,
					"columns" => 6,
					"group_id" => 0
				),
				"icon" => "fa-thumb-tack",
				"category" => "calc"
			),
			array(
				"id" => 16,
				"name" => "Payment",
				"description" => __("User can choose the payment type", "ezfc"),
				"type" => "payment",
				"data" => array(
					"name" => "Payment type",
					"label" => "Payment type",
					"required" => 1,
						"options" => array(
						array("value" => "bank", "text" => "Bank transfer"),
						array("value" => "cash", "text" => "Cash on delivery"),
						array("value" => "paypal", "text" => "PayPal")
					),
					"conditional" => array(array("action" => "", "target" => 0,"operator" => "", "value" => "")),
					"discount" => array(array("range_min" => "", "range_max" => "", "operator" => "", "discount_value" => "")),
					"show_in_email" => 1,
					"description" => "",
					"inline" => 0,
					"class" => "",
					"wrapper_class" => "",
					"style" => "",
					"wrapper_style" => "",
					"hidden" => 0,
					"columns" => 6,
					"group_id" => 0
				),
				"icon" => "fa-usd",
				"category" => "other"
			),
			array(
				"id" => 17,
				"name" => "Timepicker",
				"description" => __("Timepicker", "ezfc"),
				"type" => "timepicker",
				"data" => array(
					"name" => "Timepicker",
					"label" => "Timepicker",
					"required" => 0,
					"value" => "",
					"value_external" => "",
					"placeholder" => "",
					"icon" => "",
					"show_in_email" => 1,
					"description" => "",
					"format" => "",
					"minTime" => "",
					"maxTime" => "",
					"steps" => "30",
					"class" => "",
					"wrapper_class" => "",
					"style" => "",
					"wrapper_style" => "",
					"GET" => "",
					"hidden" => 0,
					"columns" => 6,
					"group_id" => 0
				),
				"icon" => "fa-clock-o",
				"category" => "basic"
			),
			array(
				"id" => 18,
				"name" => "Step start",
				"description" => __("Divide form into steps - Start of a step", "ezfc"),
				"type" => "stepstart",
				"data" => array(
					"name" => "Step",
					"title" => "",
					"class" => "",
					"wrapper_class" => "",
					"columns" => 6,
					"group_id" => 0
				),
				"icon" => "fa-caret-square-o-down",
				"category" => "steps"
			),
			array(
				"id" => 19,
				"name" => "Step end",
				"description" => __("Divide form into steps - End of a step", "ezfc"),
				"type" => "stepend",
				"data" => array(
					"name" => "Step end",
					"previous_step" => "Previous Step",
					"next_step" => "Next Step",
					"add_line" => "1",
					"columns" => 6,
					"group_id" => 0
				),
				"icon" => "fa-caret-square-o-up",
				"category" => "steps"
			),
			array(
				"id" => 20,
				"name" => "Date range",
				"description" => __("Use this element when you want to calculate a date range (e.g. number of days)", "ezfc"),
				"type" => "daterange",
				"data" => array(
					"name" => "Date range",
					"label" => "Date range",
					"required" => 0,
					"calculate_enabled" => 1,
					"value" => "",
					"factor" => "",
					"minDate" => "+1d;;+2d",
					"maxDate" => "+2w;;+3w",
					"minDays" => "1",
					"overwrite_price" => 0,
					"calculate" => array(array("operator" => "", "target" => 0,"value" => "")),
					"conditional" => array(array("action" => "", "target" => 0,"operator" => "", "value" => "")),
					"discount" => array(array("range_min" => "", "range_max" => "", "operator" => "", "discount_value" => "")),
					"placeholder" => "From;;To",
					"icon" => "",
					"show_in_email" => 1,
					"description" => "",
					"class" => "",
					"wrapper_class" => "",
					"style" => "",
					"wrapper_style" => "",
					"hidden" => 0,
					"columns" => 6,
					"group_id" => 0
				),
				"icon" => "fa-calendar",
				"category" => "calc"
			),
			array(
				"id" => 21,
				"name" => "Colorpicker",
				"description" => __("Colorpicker", "ezfc"),
				"type" => "colorpicker",
				"data" => array(
					"name" => "Colorpicker",
					"label" => "Pick your color",
					"required" => 0,
					"value" => "",
					"show_in_email" => 1,
					"description" => "",
					"class" => "",
					"wrapper_class" => "",
					"style" => "",
					"wrapper_style" => "",
					"GET" => "",
					"hidden" => 0,
					"columns" => 6,
					"group_id" => 0
				),
				"icon" => "fa-eyedropper",
				"category" => "basic"
			),
			array(
				"id" => 22,
				"name" => "Set",
				"description" => __("Apply a math operator to a set of elements (e.g. choose lowest / highest value, average, etc.)", "ezfc"),
				"type" => "set",
				"data" => array(
					"name" => "Set",
					"label" => "Set",
					"calculate_enabled" => 1,
					"is_currency" => 1,
					"overwrite_price" => 1,
					"calculate_when_hidden" => 1,
					"price_format" => "",
					"precision" => 2,
					"text_only" => 0,
					"text_before" => "",
					"text_after" => "",
					"set_operator" => "min",
					"set" => array("target" => "" ),
					"calculate" => array(array("operator" => "", "target" => 0,"value" => "")),
					"conditional" => array(array("action" => "", "target" => 0,"operator" => "", "value" => "")),
					"discount" => array(array("range_min" => "", "range_max" => "", "operator" => "", "discount_value" => "")),
					"show_in_email" => 1,
					"description" => "",
					"class" => "",
					"wrapper_class" => "",
					"style" => "",
					"wrapper_style" => "",
					"hidden" => 0,
					"columns" => 6,
					"group_id" => 0
				),
				"icon" => "fa-bars",
				"category" => "calc"
			),
			array(
				"id" => 23,
				"name" => "Post",
				"description" => __("Show the content of a WordPress post.", "ezfc"),
				"type" => "post",
				"data" => array(
					"name" => "Post",
					"label" => "Post",
					"post_id" => "",
					"show_in_email" => 1,
					"description" => "",
					"class" => "",
					"wrapper_class" => "",
					"style" => "",
					"wrapper_style" => "",
					"hidden" => 0,
					"columns" => 6,
					"group_id" => 0
				),
				"icon" => "fa-thumb-tack",
				"category" => "other"
			),
			array(
				"id" => 24,
				"name" => "Custom JS",
				"description" => __("Custom JavaScript code. Uses price as argument and returns the price (no need to add function name or return value).", "ezfc"),
				"type" => "custom_calculation",
				"data" => array(
					"name" => "Custom Calculation",
					"calculate_enabled" => 1,
					"is_currency" => 1,
					"overwrite_price" => 1,
					"calculate_when_hidden" => 1,
					"custom_calculation" => "",
					"show_in_email" => 1,
					"columns" => 6,
					"group_id" => 0
				),
				"icon" => "fa-calculator",
				"category" => "calc"
			),
			array(
				"id" => 25,
				"name" => "Group",
				"description" => __("Group", "ezfc"),
				"type" => "group",
				"data" => array(
					"name" => "Group",
					"wrapper_class" => "",
					"wrapper_style" => "",
					"hidden" => 0,
					"columns" => 6,
					"group_id" => 0
				),
				"icon" => "fa-folder",
				"category" => "other"
			)
		);

		return json_decode(json_encode($elements));
	}

	/**
		global settings
	**/
	static function get_global_settings($flat = false) {
		$settings = array(
			"Customization" => array(
				"jquery_ui"                    => array("description" => __("Add default jQuery UI stylesheet", "ezfc"), "description_long" => __("If your theme looks differently after installing this plugin, set this option to 'No' and see again. It may break due to the default jQuery UI stylesheet.", "ezfc"), "type" => "yesno", "default" => 1),
				"css_form_label_width"         => array("description" => __("CSS label width", "ezfc"), "description_long" => __("Width of the labels. Default: 15em", "ezfc"), "type" => "input"),
				"custom_css"                   => array("description" => __("Custom CSS", "ezfc"), "description_long" => __("Add your custom styles here.", "ezfc"), "type" => "textarea"),
				"required_text"                => array("description" => __("Required text", "ezfc"), "description_long" => __("This text is shown below the form.", "ezfc"), "type" => "input", "default" => "Required"),
				"required_text_element"        => array("description" => __("Required element text", "ezfc"), "description_long" => __("This text will be shown when a required element is empty. Default: 'This field is required'", "ezfc"), "type" => "input", "default" => "This field is required."),
				"datepicker_language"          => array("description" => __("Datepicker language", "ezfc"), "description_long" => __("Datepicker language. Default: 'en'", "ezfc"), "type" => "input"),
				"datepicker_load_languages"    => array("description" => __("Load datepicker languages", "ezfc"), "description_long" => __("Load additional datepicker languages. Only set this option to 'Yes' when using a different language than English since all languages will be loaded with an additional ~40kb file. If you know what you are doing, you can remove all unneccessary data from the file /ez-form-calculator-premium/assets/js/jquery.ui.u18n.all.min.js", "ezfc"), "type" => "yesno"),
				"auto_scroll_steps"   => array("description" => __("Auto scroll steps", "ezfc"), "description_long" => __("Automatically scroll to top upon changing steps.", "ezfc"), "type" => "yesno", "default" => 1)
			),

			"Price" => array(
				"price_format"                 => array("description" => __("Price format", "ezfc"), "description_long" => __("See <a href='http://numeraljs.com/' target='_blank'>numeraljs.com</a> for syntax documentation", "ezfc"), "type" => "input", "default" => "0,0[.]00"),
				"email_price_format_thousand"  => array("description" => __("Price format thousands separator", "ezfc"), "description_long" => __("Thousands separator", "ezfc"), "type" => "input", "default" => ","),
				"email_price_format_dec_point" => array("description" => __("Price format decimal point", "ezfc"), "description_long" => __("Decimal point separator", "ezfc"), "type" => "input", "default" => ".")
			),

			"Captcha" => array(
				"captcha_public"  => array("description" => __("Recaptcha public key", "ezfc"), "description_long" => __("", "ezfc"), "type" => "input"),
				"captcha_private" => array("description" => __("Recaptcha private key", "ezfc"), "description_long" => __("", "ezfc"), "type" => "input")
			),

			"Email" => array(
				"email_price_format_dec_num" => array("description" => __("Price format decimals", "ezfc"), "description_long" => __("Number of decimals in email prices", "ezfc"), "type" => "input", "default" => 2),
				"email_smtp_enabled" => array("description" => __("Enable SMTP", "ezfc"), "description_long" => __("", "ezfc"), "type" => "yesno"),
				"email_smtp_host"    => array("description" => __("SMTP Host", "ezfc"), "description_long" => __("", "ezfc"), "type" => "input"),
				"email_smtp_user"    => array("description" => __("SMTP Username", "ezfc"), "description_long" => __("", "ezfc"), "type" => "input"),
				"email_smtp_pass"    => array("description" => __("SMTP Password", "ezfc"), "description_long" => __("", "ezfc"), "type" => "password"),
				"email_smtp_port"    => array("description" => __("SMTP Port", "ezfc"), "description_long" => __("", "ezfc"), "type" => "input"),
				"email_smtp_secure"  => array("description" => __("SMTP Encryption", "ezfc"), "description_long" => __("", "ezfc"), "type" => "dropdown", "options" => array(
					"0"   => "No encryption",
					"ssl" => "SSL",
					"tls" => "TLS"
				))
			),

			"PayPal" => array(
				"pp_api_username"         => array("description" => __("PayPal API username", "ezfc"), "description_long" => __("See <a href='https://developer.paypal.com/docs/classic/api/apiCredentials/'>PayPal docs</a> to read how to get your API credentials.", "ezfc"), "type" => "input"),
				"pp_api_password"         => array("description" => __("PayPal API password", "ezfc"), "description_long" => __("", "ezfc"), "type" => "password"),
				"pp_api_signature"        => array("description" => __("PayPal API signature", "ezfc"), "description_long" => __("", "ezfc"), "type" => "input"),
				"pp_return_url"           => array("description" => __("Return URL", "ezfc"), "description_long" => __("The return URL is the location where buyers return to when a payment has been succesfully authorized. <br>You need to use this shortcode on the return page/post or else it will not work:<br>[ezfc_verify]", "ezfc"), "type" => "input"),
				"pp_cancel_url"           => array("description" => __("Cancel URL", "ezfc"), "description_long" => __("The cancelURL is the location buyers are sent to when they hit the cancel button during authorization of payment during the PayPal flow.", "ezfc"), "type" => "input"),
				"pp_currency_code"        => array("description" => __("Currency code", "ezfc"), "description_long" => __("", "ezfc"), "type" => "currencycodes"),
				"pp_sandbox"              => array("description" => __("Use sandbox", "ezfc"), "description_long" => __("Set to 'yes' for testing purposes.", "ezfc"), "type" => "yesno", "default" => 0),
				"pp_acount_required"      => array("description" => __("Account required", "ezfc"), "description_long" => __("Whether a PayPal account is required or not. If an account is optional, you still need to do the following step: Log in to your PayPal account, go to the Profile subtab, click on Website Payment Preferences under the Selling Preferences column, and check the yes/no box under PayPal Account Optional.", "ezfc"), "type" => "yesno", "default" => 1)
			),

			"Styling" => array(
				"load_custom_styling" => array(
					"name" => "load_custom_styling",
					"description" => __("Load custom styling", "ezfc"),
					"description_long" => __("Only enable this option if you want to use the styling below.", "ezfc"),
					"type" => "yesno",
					"default" => 0,
					"value" => ""
				),
				// will be generated automatically
				"css_custom_styling" => array(
					"name" => "css_custom_styling",
					"description" => __("", "ezfc"),
					"description_long" => "",
					"type" => "hidden",
					"default" => "",
					"value" => ""
				),
				"css_font" => array(
					"name" => "css_font",
					"description" => __("Font", "ezfc"),
					"type" => "font",
					"css" => array(
						"selector" => ".ezfc-form",
						"property" => "font-family"
					),
					"value" => ""
				),
				"css_font_size" => array(
					"name" => "css_font_size",
					"description" => __("Font size", "ezfc"),
					"type" => "dimensions",
					"css" => array(
						"selector" => ".ezfc-form",
						"property" => "font-size"
					),
					"value" => ""
				),
				"css_background_image" => array(
					"name" => "css_background_image",
					"description" => __("Background image", "ezfc"),
					"type" => "image",
					"css" => array(
						"selector" => ".ezfc-form",
						"property" => "background-image",
						"is_url"   => true
					),
					"value" => ""
				),
				"css_background_color" => array(
					"name" => "css_background_color",
					"description" => __("Background color", "ezfc"),
					"type" => "colorpicker",
					"css" => array(
						"selector" => ".ezfc-form",
						"property" => "background-color"
					),
					"value" => ""
				),
				"css_text_color" => array(
					"name" => "css_text_color",
					"description" => __("Text color", "ezfc"),
					"type" => "colorpicker",
					"css" => array(
						"selector" => ".ezfc-form",
						"property" => "color"
					),
					"value" => ""
				),
				// input
				"css_input_background_color" => array(
					"name" => "css_input_background_color",
					"description" => __("Input background color", "ezfc"),
					"type" => "colorpicker",
					"css" => array(
						"selector" => ".ezfc-element-input,.ezfc-element-numbers,.ezfc-element-textarea,.ezfc-element-select",
						"property" => "background-color"
					),
					"value" => ""
				),
				"css_input_text_color" => array(
					"name" => "css_input_text_color",
					"description" => __("Input text color", "ezfc"),
					"type" => "colorpicker",
					"css" => array(
						"selector" => ".ezfc-element-input,.ezfc-element-numbers,.ezfc-element-textarea,.ezfc-element-select",
						"property" => "color"
					),
					"value" => ""
				),
				"css_input_border" => array(
					"name" => "css_input_border",
					"description" => __("Input border", "ezfc"),
					"description_long" => __("Color, size (px), style, border-radius (px)", "ezfc"),
					"type" => "border",
					"separator" => " ",
					"css" => array(
						"selector" => ".ezfc-element-input,.ezfc-element-numbers,.ezfc-element-textarea,.ezfc-element-select",
						"property" => "border"
					),
					"value" => ""
				),
				"css_input_padding" => array(
					"name" => "css_input_padding",
					"description" => __("Input padding", "ezfc"),
					"type" => "dimensions",
					"css" => array(
						"selector" => ".ezfc-element-input,.ezfc-element-numbers,.ezfc-element-textarea,.ezfc-element-select",
						"property" => "padding"
					),
					"value" => ""
				),
				// submit button
				"css_submit_image" => array(
					"name" => "css_submit_image",
					"description" => __("Submit button image", "ezfc"),
					"type" => "image",
					"css" => array(
						"selector" => ".ezfc-element-submit",
						"property" => "background-image",
						"is_url"   => true,
						"add"      => array(
							"background-repeat" => "no-repeat",
							"background-size" => "contain"
						),
						"hover_override" => true
					),
					"value" => ""
				),
				"css_submit_background" => array(
					"name" => "css_submit_background",
					"description" => __("Submit button background", "ezfc"),
					"type" => "colorpicker",
					"css" => array(
						"selector" => ".ezfc-element-submit",
						"property" => "background-color"
					),
					"value" => ""
				),
				"css_submit_text_color" => array(
					"name" => "css_submit_text_color",
					"description" => __("Submit button text color", "ezfc"),
					"type" => "colorpicker",
					"css" => array(
						"selector" => ".ezfc-element-submit",
						"property" => "color"
					),
					"value" => ""
				),
				"css_submit_border" => array(
					"name" => "css_submit_border",
					"description" => __("Submit button border", "ezfc"),
					"description_long" => __("Color, size (px), style, border-radius (px)", "ezfc"),
					"type" => "border",
					"separator" => " ",
					"css" => array(
						"selector" => ".ezfc-element-submit",
						"property" => "border"
					),
					"value" => ""
				),
				// step styling
				"css_step_button_image" => array(
					"name" => "css_step_button_image",
					"description" => __("Step button image", "ezfc"),
					"type" => "image",
					"css" => array(
						"selector" => ".ezfc-step-button",
						"property" => "background-image",
						"is_url"   => true,
						"add"      => array(
							"background-repeat" => "no-repeat",
							"background-size" => "contain"
						),
						"hover_override" => true
					),
					"value" => ""
				),
				"css_step_button_background" => array(
					"name" => "css_step_button_background",
					"description" => __("Step button background", "ezfc"),
					"type" => "colorpicker",
					"css" => array(
						"selector" => ".ezfc-step-button",
						"property" => "background-color"
					),
					"value" => ""
				),
				"css_step_button_text_color" => array(
					"name" => "css_step_button_text_color",
					"description" => __("Step button text color", "ezfc"),
					"type" => "colorpicker",
					"css" => array(
						"selector" => ".ezfc-step-button",
						"property" => "color"
					),
					"value" => ""
				),
				"css_step_button_border" => array(
					"name" => "css_step_button_border",
					"description" => __("Step button border", "ezfc"),
					"description_long" => __("Color, size (px), style, border-radius (px)", "ezfc"),
					"type" => "border",
					"separator" => " ",
					"css" => array(
						"selector" => ".ezfc-step-button",
						"property" => "border"
					),
					"value" => ""
				),
				"css_title_font_size" => array(
					"name" => "css_title_font_size",
					"description" => __("Step title font size", "ezfc"),
					"type" => "dimensions",
					"css" => array(
						"selector" => ".ezfc-step-title",
						"property" => "font-size"
					),
					"value" => ""
				),
				// fixed price
				"css_fixed_price_font_size" => array(
					"name" => "css_fixed_price_font_size",
					"description" => __("Fixed price font size", "ezfc"),
					"type" => "dimensions",
					"css" => array(
						"selector" => ".ezfc-fixed-price",
						"property" => "font-size"
					),
					"value" => ""
				),
				"css_fixed_price_background_color" => array(
					"name" => "css_fixed_price_background_color",
					"description" => __("Fixed price background color", "ezfc"),
					"type" => "colorpicker",
					"css" => array(
						"selector" => ".ezfc-fixed-price",
						"property" => "background-color"
					),
					"value" => ""
				),
				"css_fixed_price_text_color" => array(
					"name" => "css_fixed_price_text_color",
					"description" => __("Fixed price color", "ezfc"),
					"type" => "colorpicker",
					"css" => array(
						"selector" => ".ezfc-fixed-price",
						"property" => "color"
					),
					"value" => ""
				),
				// other
				"css_form_padding" => array(
					"name" => "css_form_padding",
					"description" => __("Form padding", "ezfc"),
					"type" => "dimensions",
					"css" => array(
						"selector" => ".ezfc-form",
						"property" => "padding"
					),
					"value" => ""
				),
				"css_form_width" => array(
					"name" => "css_form_width",
					"description" => __("Form width", "ezfc"),
					"type" => "dimensions",
					"css" => array(
						"selector" => ".ezfc-form",
						"property" => "width"
					),
					"value" => ""
				)
			),

			"WooCommerce" => array(
				"woocommerce"            => array("description" => __("Integrate with WooCommerce", "ezfc"), "description_long" => __("Integrate with WooCommerce", "ezfc"), "type" => "yesno"),
				"woocommerce_text"       => array("description" => __("'Added to cart' text", "ezfc"), "description_long" => __("This text will be displayed after a submission was added to the cart.", "ezfc"), "type" => "input"),
				"woocommerce_add_forms"  => array("description" => __("Add forms to products", "ezfc"), "description_long" => __("When this option is enabled, forms will be added to products automatically. If you want to show individual forms for products, please make sure you add a custom field to the product:<br>
					custom field name: ezfc_form_id<br>custom field value: &lt;form_id&gt;<br>
					If you want to show one form for all products, please enter a form ID in 'Global form ID' below.<br>
					<strong>This will replace the 'Add to cart'-button from Woocommerce!</strong><br>
					More information here: <a href='http://www.mials.de/mials/ezfc/documentation/woocommerce-integration/' target='_blank'>ezfc Woocommerce Integration</a>", "ezfc"), "type" => "yesno"),
				"woocommerce_global_form_id"  => array("description" => __("Global form ID", "ezfc"), "description_long" => __("Form with this ID will be added to the WooCommerce product when 'Add forms to products' is set to 'Yes'", "ezfc"), "type" => "input"),
				"woocommerce_checkout_details" => array("description" => __("Show selected values in checkout", "ezfc"), "description_long" => __("Show the selected values in a table on the checkout page", "ezfc"), "type" => "yesno"),
				"woocommerce_checkout_details_text" => array("description" => __("Checkout details text", "ezfc"), "description_long" => __("If 'Show selected values in checkout' is enabled, display this text above the details table.", "ezfc"), "type" => "input", "default" => "Selected values"),
				"woocommerce_checkout_details_values" => array("description" => __("Checkout details values", "ezfc"), "description_long" => __("Details text in checkout: 'Full Details' shows all values and calculations. 'Simple details' shows values and prices. 'Values only' shows the selected values only. <strong>Note: only applies to products added after this values was changed.</strong>", "ezfc"), "type" => "dropdown", "default" => "result", "options" => array(
					"result" => "Full details",
					"result_simple" => "Simple details",
					"result_values" => "Values only"
				)),
				"woocommerce_add_hook"  => array("description" => __("Form display hook", "ezfc"), "description_long" => __("WooCommerce hook when forms are added to products (for a full list, see <a href='http://docs.woothemes.com/document/hooks/' target='_blank'>docs.woothemes.com</a>)", "ezfc"), "type" => "input", "default" => "woocommerce_after_single_product"),
				"woocommerce_product_id" => array("description" => __("WooCommerce product id", "ezfc"), "description_long" => __("<strong>NOTE:</strong> this value is deprecated since v2.7.3 and has no effect - set the WooCommerce product id in the form options", "ezfc"), "type" => "input")
			),

			"Other" => array(
				"mailchimp_api_key"      => array("description" => __("Mailchimp API key", "ezfc"), "description_long" => __("<a href='http://kb.mailchimp.com/accounts/management/about-api-keys'>How to find your API key</a> (mailchimp.com)", "ezfc"), "type" => "input"),
				"content_filter"         => array("description" => "Content filter", "description_long" => "WordPress filter to apply html elements on. If you see a blank page when using a form, make this field blank and check again. Default: the_content", "type" => "input", "default" => "the_content"),
				"debug_mode"             => array("description" => __("Enable debug mode", "ezfc"), "description_long" => __("", "ezfc"), "type" => "dropdown", "default" => 0, "options" => array(
					0 => "No",
					1 => "Yes",
					2 => "Yes + Frontend details"
				)),
				"uninstall_keep_data"    => array("description" => __("Keep data after uninstall", "ezfc"), "description_long" => __("The plugin will keep all plugin-related data in the databse when uninstalling. Only select 'Yes' if you want to upgrade the script.", "ezfc"), "type" => "yesno")
			)
		);

		// get values
		foreach ($settings as $cat => &$settings_cat) {
			foreach ($settings_cat as $name => &$setting) {
				$default = isset($setting["default"]) ? $setting["default"] : "";

				$setting["value"] = get_option("ezfc_{$name}", $default);
			}
		}

		if ($flat) {
			$settings = self::flatten($settings);
		}

		return $settings;
	}

	/**
		update global settings
	**/
	public static function update_global_settings($submitted_values) {
		$settings = self::get_global_settings(true);

		// css array builder
		$css_builder = new EZ_CSS_Builder(".ezfc-wrapper");

		foreach ($settings as $setting_key => $setting) {
			if (!isset($submitted_values[$setting_key])) continue;

			// get post value
			$value = $submitted_values[$setting_key];

			if (is_array($value)) {
				$value = serialize($value);
			}
			else {
				$value = stripslashes($value);
			}

			// update wp option
			update_option("ezfc_{$setting_key}", $value);

			// check for css
			if (!empty($setting["css"]) && !empty($value)) {
				$css_builder->add_css($setting["css"], $value);
			}
		}

		// build css output
		$css_output = $css_builder->get_output();
		update_option("ezfc_css_custom_styling", $css_output);
	}

	/**
		form options
	**/
	static function get_form_options($flat = false) {
		$settings = array(
			"Email" => array(
				"email_recipient" => array(
					"id" => 1,
					"name" => "email_recipient",
					"default" => "",
					"description" => __("Email recipient", "ezfc"),
					"description_long" => __("Notifications will be sent to this email. Leave blank for no notifications.", "ezfc"),
					"type" => "",
					"value" => ""
				),
				"email_admin_sender" => array(
					"id" => 10,
					"name" => "email_admin_sender",
					"default" => "",
					"description" => __("Sender name", "ezfc"),
					"description_long" => __("Sender name in emails. Use this syntax: Sendername &lt;sender@mail.com&gt;", "ezfc"),
					"type" => "",
					"value" => ""
				),
				"email_admin_sender_recipient" => array(
					"id" => 91,
					"name" => "email_admin_sender_recipient",
					"default" => "",
					"description" => __("Sender name (admin)", "ezfc"),
					"description_long" => __("Sender name in emails sent to the admin (recipient). Use this syntax: Sendername &lt;sender@mail.com&gt;", "ezfc"),
					"type" => "",
					"value" => ""
				),
				"email_subject" => array(
					"id" => 11,
					"name" => "email_subject",
					"default" => "Your submission",
					"description" => __("Email subject", "ezfc"),
					"description_long" => __("", "ezfc"),
					"type" => "",
					"value" => ""
				),
				"email_text" => array(
					"id" => 12,
					"name" => "email_text",
					"default" => "Thank you for your submission, we will contact you soon!\n\n{{result_simple}}",
					"description" => __("Email text", "ezfc"),
					"description_long" => __("Email text sent to the user. Use {{result}} for submission details, {{result_simple}} for no calculation details, {{result_values}} for values only. Use {{Elementname}} for single element values (where Elementname is the internal name of the element). Use {{files}} for attached files (you should not send these to the customer for security reasons)", "ezfc"),
					"type" => "editor",
					"value" => ""
				),
				"email_admin_subject" => array(
					"id" => 13,
					"name" => "email_admin_subject",
					"default" => "New submission",
					"description" => __("Admin email subject", "ezfc"),
					"description_long" => __("", "ezfc"),
					"type" => "",
					"value" => ""
				),
				"email_admin_text" => array(
					"id" => 14,
					"name" => "email_admin_text",
					"default" => "You have received a new submission:\n\n{{result}}",
					"description" => __("Admin email text", "ezfc"),
					"description_long" => __("Email text sent to the admin. Use {{result}} for submission details. Use {{Elementname}} for single element values (where Elementname is the internal name of the element). Use {{files}} for attached files (you should not send these to the customer for security reasons)", "ezfc"),
					"type" => "editor",
					"value" => ""
				),
				"email_subject_pp" => array(
					"id" => 24,
					"name" => "email_subject_pp",
					"default" => "Your submission",
					"description" => __("Email Paypal subject", "ezfc"),
					"description_long" => __("", "ezfc"),
					"type" => "",
					"value" => ""
				),
				"email_text_pp" => array(
					"id" => 25,
					"name" => "email_text_pp",
					"default" => "Thank you for your submission,\n\nwe have received your payment via PayPal.",
					"description" => __("Email Paypal text", "ezfc"),
					"description_long" => __("Email text sent to the user when paid with PayPal.", "ezfc"),
					"type" => "editor",
					"value" => ""
				),
				"email_total_price_text" => array(
					"id" => 92,
					"name" => "email_total_price_text",
					"default" => "",
					"description" => __("Total price text", "ezfc"),
					"description_long" => __("This text will be shown before the total price in emails.", "ezfc"),
					"type" => "",
					"value" => __("Total", "ezfc")
				),
				"email_show_total_price" => array(
					"id" => 18,
					"name" => "email_show_total_price",
					"default" => "1",
					"description" => __("Show total price in email", "ezfc"),
					"description_long" => __("Whether the total price of a submission should be shown or not. (Disable this option when you don't have a calculation form)", "ezfc"),
					"type" => "yesno",
					"value" => ""
				),
				"email_send_files_attachment" => array(
					"id" => 41,
					"name" => "email_send_files_attachment",
					"default" => "0",
					"description" => __("Send files as attachment", "ezfc"),
					"description_long" => __("Uploaded files will be sent to the admin email recipient as attachments", "ezfc"),
					"type" => "yesno",
					"value" => ""
				),
				"email_show_html_elements" => array(
					"id" => 75,
					"name" => "email_show_html_elements",
					"default" => "0",
					"description" => __("Show HTML elements", "ezfc"),
					"description_long" => __("HTML elements can be shown in emails. You need to make sure that HTML elements have the option 'Show_in_email' enabled as well.", "ezfc"),
					"type" => "yesno",
					"value" => ""
				),
				"mailchimp_add" => array(
					"id" => 30,
					"name" => "mailchimp_add",
					"default" => "0",
					"description" => __("Enable MailChimp", "ezfc"),
					"description_long" => __("Enable MailChimp integration", "ezfc"),
					"type" => "yesno",
					"value" => ""
				),
				"mailchimp_list" => array(
					"id" => 31,
					"name" => "mailchimp_list",
					"default" => "",
					"description" => __("Mailchimp list", "ezfc"),
					"description_long" => __("Email addresses will be added to this list upon form submission.", "ezfc"),
					"type" => "mailchimp_list",
					"value" => ""
				),
				"mailpoet_add" => array(
					"id" => 48,
					"name" => "mailpoet_add",
					"default" => "0",
					"description" => __("Enable Mailpoet", "ezfc"),
					"description_long" => __("Enable Mailpoet integration", "ezfc"),
					"type" => "yesno",
					"value" => ""
				),
				"mailpoet_list" => array(
					"id" => 49,
					"name" => "mailpoet_list",
					"default" => "",
					"description" => __("Mailpoet list", "ezfc"),
					"description_long" => __("Email addresses will be added to this list upon form submission.", "ezfc"),
					"type" => "mailpoet_list",
					"value" => ""
				)
			),

			"Form" => array(
				"success_text" => array(
					"id" => 2,
					"name" => "success_text",
					"default" => "Thank you for your submission!",
					"description" => __("Submission message", "ezfc"),
					"description_long" => __("Frontend message after successful submission.", "ezfc"),
					"type" => "editor",
					"value" => ""
				),
				"spam_time" => array(
					"id" => 3,
					"name" => "spam_time",
					"default" => "60",
					"description" => __("Spam protection in seconds", "ezfc"),
					"description_long" => __("Every x seconds, a user (identified by IP address) can add an entry. Default: 60.", "ezfc"),
					"type" => "",
					"value" => ""
				),
				"submission_enabled" => array(
					"id" => 8,
					"name" => "submission_enabled",
					"default" => "1",
					"description" => __("Submission enabled", "ezfc"),
					"description_long" => __("", "ezfc"),
					"type" => "yesno",
					"value" => ""
				),
				"redirect_url" => array(
					"id" => 27,
					"name" => "redirect_url",
					"default" => "",
					"description" => __("Redirect URL", "ezfc"),
					"description_long" => __("Redirect users to this URL upon form submission. Note: URL must start with http://", "ezfc"),
					"type" => "",
					"value" => ""
				),
				"min_submit_value" => array(
					"id" => 28,
					"name" => "min_submit_value",
					"default" => "0",
					"description" => __("Minimum submission value", "ezfc"),
					"description_long" => __("", "ezfc"),
					"type" => "",
					"value" => ""
				),
				"min_submit_value_text" => array(
					"id" => 29,
					"name" => "min_submit_value_text",
					"default" => "Minimum submission value is %s",
					"description" => __("Minimum submission value text", "ezfc"),
					"description_long" => __("This text will be displayed when the user's total value is less than the minimum value.", "ezfc"),
					"type" => "",
					"value" => ""
				),
				"hide_all_forms" => array(
					"id" => 32,
					"name" => "hide_all_forms",
					"default" => "0",
					"description" => __("Hide all forms on submission", "ezfc"),
					"description_long" => __("If this option is set to 'yes', all forms on the relevant page will be hidden upon submission (useful for product comparisons).", "ezfc"),
					"type" => "yesno",
					"value" => ""
				),
				"price_format" => array(
					"id" => 34,
					"name" => "price_format",
					"default" => "",
					"description" => __("Price format", "ezfc"),
					"description_long" => __("If left blank, the global price format will be used. See numeraljs.com for syntax documentation", "ezfc"),
					"type" => "",
					"value" => ""
				),
				"clear_selected_values_hidden" => array(
					"id" => 36,
					"name" => "clear_selected_values_hidden",
					"default" => "0",
					"description" => __("Clear selected values when hiding", "ezfc"),
					"description_long" => __("When elements are hidden, clear the selected values (numbers, dropdowns, radio buttons etc.). Please note that preselected values will be cleared as well!", "ezfc"),
					"type" => "yesno",
					"value" => ""
				),
				"price_show_request" => array(
					"id" => 38,
					"name" => "price_show_request",
					"default" => "0",
					"description" => __("Request price", "ezfc"),
					"description_long" => __("Enable this option if you do not want to show the price immediately.", "ezfc"),
					"type" => "yesno",
					"value" => ""
				),
				"price_show_request_text" => array(
					"id" => 39,
					"name" => "price_show_request_text",
					"default" => "Request price",
					"description" => __("Request price text", "ezfc"),
					"description_long" => __("Text in request price button", "ezfc"),
					"type" => "input",
					"value" => ""
				),
				"price_show_request_before" => array(
					"id" => 40,
					"name" => "price_show_request_before",
					"default" => "-",
					"description" => __("Price text before request", "ezfc"),
					"description_long" => __("", "ezfc"),
					"type" => "input",
					"value" => ""
				),
				"reset_enabled" => array(
					"id" => 76,
					"name" => "reset_enabled",
					"default" => array(
						"enabled" => 0,
						"text" => __("Reset", "ezfc")
					),
					"description" => __("Enable reset button", "ezfc"),
					"description_long" => __("The reset button is used to reset the form elements to their initial values.", "ezfc"),
					"type" => "bool_text",
					"value" => ""
				),
				"reset_after_submission" => array(
					"id" => 89,
					"name" => "reset_after_submission",
					"default" => 0,
					"description" => __("Reset form after submission", "ezfc"),
					"description_long" => __("When the form was submitted successfully, reset the form to its initial values.", "ezfc"),
					"type" => "yesno",
					"value" => ""
				),
				"redirect_timer" => array(
					"id" => 77,
					"name" => "redirect_timer",
					"default" => 3,
					"description" => __("Redirect timer", "ezfc"),
					"description_long" => __("Duration after which the user will be redirected when the conditional action 'redirect' is executed (in seconds).", "ezfc"),
					"type" => "",
					"value" => ""
				),
				"redirect_text" => array(
					"id" => 78,
					"name" => "redirect_text",
					"default" => __("You will be redirected in %s seconds...", "ezfc"),
					"description" => __("Redirect text", "ezfc"),
					"description_long" => __("This text will be shown when the user will be redirected (conditional action only). Use %s as the placeholder for the redirect timer.", "ezfc"),
					"type" => "",
					"value" => ""
				),
				"summary_enabled" => array(
					"id" => 79,
					"name" => "summary_enabled",
					"default" => 0,
					"description" => __("Show summary", "ezfc"),
					"description_long" => __("Show a summary of the selected values at the end of the form.", "ezfc"),
					"type" => "yesno",
					"value" => ""
				),
				"summary_text" => array(
					"id" => 80,
					"name" => "summary_text",
					"default" => __("Summary", "ezfc"),
					"description" => __("Summary text", "ezfc"),
					"description_long" => __("This text will be shown above the summary.", "ezfc"),
					"type" => "",
					"value" => __("Summary", "ezfc")
				),
				"summary_button_text" => array(
					"id" => 81,
					"name" => "summary_button_text",
					"default" => __("Check your order", "ezfc"),
					"description" => __("Summary button text", "ezfc"),
					"description_long" => __("Text on the summary submit button.", "ezfc"),
					"type" => "",
					"value" => __("Check your order", "ezfc")
				)
			),

			"Layout" => array(
				"show_required_char" => array(
					"id" => 4,
					"name" => "show_required_char",
					"default" => "1",
					"description" => __("Show required char", "ezfc"),
					"description_long" => __("", "ezfc"),
					"type" => "yesno",
					"value" => ""
				),
				"currency" => array(
					"id" => 5,
					"name" => "currency",
					"default" => "$",
					"description" => __("Currency", "ezfc"),
					"description_long" => __("", "ezfc"),
					"type" => "",
					"value" => ""
				),
				"price_label" => array(
					"id" => 6,
					"name" => "price_label",
					"default" => "Price",
					"description" => __("Price label", "ezfc"),
					"description_long" => __("Calculated field label (default: Price)", "ezfc"),
					"type" => "",
					"value" => ""
				),
				"show_element_price" => array(
					"id" => 7,
					"name" => "show_element_price",
					"default" => "0",
					"description" => __("Show element prices", "ezfc"),
					"description_long" => __("", "ezfc"),
					"type" => "yesno",
					"value" => ""
				),
				"show_price_position" => array(
					"id" => 9,
					"name" => "show_price_position",
					"default" => "1",
					"description" => __("Total price position", "ezfc"),
					"description_long" => __("Price can be displayed above or below the form (or both) as well as fixed (scrolls with window)", "ezfc"),
					"type" => "select,Hidden|Below|Above|Below and above|Fixed left|Fixed right",
					"value" => ""
				),
				"submit_text" => array(
					"id" => 15,
					"name" => "submit_text",
					"default" => "Submit",
					"description" => __("Submit text", "ezfc"),
					"description_long" => __("Text in submit buttons", "ezfc"),
					"type" => "",
					"value" => ""
				),
				"submit_text_woo" => array(
					"id" => 16,
					"name" => "submit_text_woo",
					"default" => "Add to cart",
					"description" => __("Submit text WooCommerce", "ezfc"),
					"description_long" => __("Text used for WooCommerce submissions", "ezfc"),
					"type" => "",
					"value" => ""
				),
				"submit_button_class" => array(
					"id" => 17,
					"name" => "submit_button_class",
					"default" => "",
					"description" => __("Submit button CSS class", "ezfc"),
					"description_long" => __("", "ezfc"),
					"type" => "",
					"value" => ""
				),
				"theme" => array(
					"id" => 19,
					"name" => "theme",
					"default" => "default",
					"description" => __("Form theme", "ezfc"),
					"description_long" => __("", "ezfc"),
					"type" => "themes",
					"value" => ""
				),
				"currency_position" => array(
					"id" => 20,
					"name" => "currency_position",
					"default" => "0",
					"description" => __("Currency position", "ezfc"),
					"description_long" => __("", "ezfc"),
					"type" => "select,Before|After",
					"value" => ""
				),
				"datepicker_format" => array(
					"id" => 21,
					"name" => "datepicker_format",
					"default" => "mm/dd/yy",
					"description" => __("Datepicker format", "ezfc"),
					"description_long" => __("See jqueryui.com for date formats.", "ezfc"),
					"type" => "",
					"value" => ""
				),
				"timepicker_format" => array(
					"id" => 33,
					"name" => "timepicker_format",
					"default" => "H:i",
					"description" => __("Timepicker format", "ezfc"),
					"description_long" => __("See php.net for time formats", "ezfc"),
					"type" => "",
					"value" => ""
				),
				"form_class" => array(
					"id" => 42,
					"name" => "form_class",
					"default" => "",
					"description" => __("Form class", "ezfc"),
					"description_long" => __("Additional css classes for the form", "ezfc"),
					"type" => "input",
					"value" => ""
				),
				"price_position_scroll_top" => array(
					"id" => 43,
					"name" => "price_position_scroll_top",
					"default" => "0",
					"description" => __("Price scroll top position", "ezfc"),
					"description_long" => __("Top position of the price with fixed position. Some designs may overlay a navigation (or something else) on the top of the page. Enter a number without any dimension here.", "ezfc"),
					"type" => "input",
					"value" => ""
				),
				"counter_duration" => array(
					"id" => 46,
					"name" => "counter_duration",
					"default" => "1000",
					"description" => __("Number counter duration", "ezfc"),
					"description_long" => __("Duration of the number counter to count after each change (in ms). Set to 0 to disable the counter.", "ezfc"),
					"type" => "input",
					"value" => ""
				),
				"counter_interval" => array(
					"id" => 47,
					"name" => "counter_interval",
					"default" => "30",
					"description" => __("Number counter interval", "ezfc"),
					"description_long" => __("Interval rate at which the counter updates the numbers (in ms).", "ezfc"),
					"type" => "input",
					"value" => ""
				),
			),

			"PayPal" => array(
				"pp_enabled" => array(
					"id" => 22,
					"name" => "pp_enabled",
					"default" => "0",
					"description" => __("Force PayPal payment", "ezfc"),
					"description_long" => __("Enabling this option will force the user to use PayPal. If you want to let the user choose how to pay, disable this option and add the Payment element (do not change the paypal value).", "ezfc"),
					"type" => "yesno",
					"value" => ""
				),
				"pp_submittext" => array(
					"id" => 23,
					"name" => "pp_submittext",
					"default" => "Check out with PayPal",
					"description" => __("Submit text PayPal", "ezfc"),
					"description_long" => __("Text used for PayPal checkouts", "ezfc"),
					"type" => "input",
					"value" => ""
				),
				"pp_paid_text" => array(
					"id" => 26,
					"name" => "pp_paid_text",
					"default" => "We have received your payment, thank you!",
					"description" => __("PayPal payment success text", "ezfc"),
					"description_long" => __("This text will be displayed when the user has successfully paid and returns to the site.", "ezfc"),
					"type" => "editor",
					"value" => ""
				),
				"pp_item_name" => array(
					"id" => 44,
					"name" => "pp_item_name",
					"default" => "",
					"description" => __("Item name", "ezfc"),
					"description_long" => __("This text will be displayed as item name on the PayPal checkout page.", "ezfc"),
					"type" => "input",
					"value" => ""
				),
				"pp_item_desc" => array(
					"id" => 45,
					"name" => "pp_item_desc",
					"default" => "",
					"description" => __("Item description", "ezfc"),
					"description_long" => __("This text will be displayed as description below the item name on the PayPal checkout page.", "ezfc"),
					"type" => "input",
					"value" => ""
				),
			),

			"Styling" => array(
				"load_custom_styling" => array(
					"id" => 50,
					"name" => "load_custom_styling",
					"description" => __("Load custom styling", "ezfc"),
					"description_long" => __("Only enable this option if you want to use the styling below.", "ezfc"),
					"type" => "yesno",
					"default" => 0,
					"value" => ""
				),
				// will be generated automatically
				"css_custom_styling" => array(
					"id" => 51,
					"name" => "css_custom_styling",
					"description" => __("", "ezfc"),
					"description_long" => "",
					"type" => "hidden",
					"default" => "",
					"value" => ""
				),
				"css_font" => array(
					"id" => 58,
					"name" => "css_font",
					"description" => __("Font", "ezfc"),
					"type" => "font",
					"css" => array(
						"selector" => ".ezfc-form",
						"property" => "font-family"
					),
					"value" => ""
				),
				"css_font_size" => array(
					"id" => 59,
					"name" => "css_font_size",
					"description" => __("Font size", "ezfc"),
					"type" => "dimensions",
					"css" => array(
						"selector" => ".ezfc-form",
						"property" => "font-size"
					),
					"value" => ""
				),
				"css_background_image" => array(
					"id" => 52,
					"name" => "css_background_image",
					"description" => __("Background image", "ezfc"),
					"type" => "image",
					"css" => array(
						"selector" => ".ezfc-form",
						"property" => "background-image",
						"is_url"   => true
					),
					"value" => ""
				),
				"css_background_color" => array(
					"id" => 53,
					"name" => "css_background_color",
					"description" => __("Background color", "ezfc"),
					"type" => "colorpicker",
					"css" => array(
						"selector" => ".ezfc-form",
						"property" => "background-color"
					),
					"value" => ""
				),
				"css_text_color" => array(
					"id" => 54,
					"name" => "css_text_color",
					"description" => __("Text color", "ezfc"),
					"type" => "colorpicker",
					"css" => array(
						"selector" => ".ezfc-form,.ezfc-element-wrapper-subtotal span",
						"property" => "color"
					),
					"value" => ""
				),
				"css_input_background_color" => array(
					"id" => 55,
					"name" => "css_input_background_color",
					"description" => __("Input background color", "ezfc"),
					"type" => "colorpicker",
					"css" => array(
						"selector" => ".ezfc-element-input,.ezfc-element-numbers,.ezfc-element-textarea,.ezfc-element-select",
						"property" => "background-color"
					),
					"value" => ""
				),
				"css_input_text_color" => array(
					"id" => 56,
					"name" => "css_input_text_color",
					"description" => __("Input text color", "ezfc"),
					"type" => "colorpicker",
					"css" => array(
						"selector" => ".ezfc-element-input,.ezfc-element-numbers,.ezfc-element-textarea,.ezfc-element-select",
						"property" => "color"
					),
					"value" => ""
				),
				"css_input_border" => array(
					"id" => 57,
					"name" => "css_input_border",
					"description" => __("Input border", "ezfc"),
					"description_long" => __("Color, size (px), style, border-radius (px)", "ezfc"),
					"type" => "border",
					"separator" => " ",
					"css" => array(
						"selector" => ".ezfc-element-input,.ezfc-element-numbers,.ezfc-element-textarea,.ezfc-element-select",
						"property" => "border"
					),
					"value" => ""
				),
				"css_input_padding" => array(
					"id" => 71,
					"name" => "css_input_padding",
					"description" => __("Input padding", "ezfc"),
					"type" => "dimensions",
					"css" => array(
						"selector" => ".ezfc-element-input,.ezfc-element-numbers,.ezfc-element-textarea,.ezfc-element-select",
						"property" => "padding"
					),
					"value" => ""
				),
				// submit button
				"css_submit_image" => array(
					"id" => 60,
					"name" => "css_submit_image",
					"description" => __("Submit button image", "ezfc"),
					"type" => "image",
					"css" => array(
						"selector" => ".ezfc-element-submit",
						"property" => "background-image",
						"is_url"   => true,
						"add"      => array(
							"background-repeat" => "no-repeat",
							"background-size" => "contain"
						),
						"hover_override" => true
					),
					"value" => ""
				),
				"css_submit_background" => array(
					"id" => 61,
					"name" => "css_submit_background",
					"description" => __("Submit button background", "ezfc"),
					"type" => "colorpicker",
					"css" => array(
						"selector" => ".ezfc-element-submit",
						"property" => "background-color"
					),
					"value" => ""
				),
				"css_submit_text_color" => array(
					"id" => 62,
					"name" => "css_submit_text_color",
					"description" => __("Submit button text color", "ezfc"),
					"type" => "colorpicker",
					"css" => array(
						"selector" => ".ezfc-element-submit",
						"property" => "color"
					),
					"value" => ""
				),
				"css_submit_border" => array(
					"id" => 63,
					"name" => "css_submit_border",
					"description" => __("Submit button border", "ezfc"),
					"description_long" => __("Color, size (px), style, border-radius (px)", "ezfc"),
					"type" => "border",
					"separator" => " ",
					"css" => array(
						"selector" => ".ezfc-element-submit",
						"property" => "border"
					),
					"value" => ""
				),
				// step styling
				"css_step_button_image" => array(
					"id" => 64,
					"name" => "css_step_button_image",
					"description" => __("Step button image", "ezfc"),
					"type" => "image",
					"css" => array(
						"selector" => ".ezfc-step-button",
						"property" => "background-image",
						"is_url"   => true,
						"add"      => array(
							"background-repeat" => "no-repeat",
							"background-size" => "contain"
						),
						"hover_override" => true
					),
					"value" => ""
				),
				"css_step_button_background" => array(
					"id" => 65,
					"name" => "css_step_button_background",
					"description" => __("Step button background", "ezfc"),
					"type" => "colorpicker",
					"css" => array(
						"selector" => ".ezfc-step-button",
						"property" => "background-color"
					),
					"value" => ""
				),
				"css_step_button_text_color" => array(
					"id" => 66,
					"name" => "css_step_button_text_color",
					"description" => __("Step button text color", "ezfc"),
					"type" => "colorpicker",
					"css" => array(
						"selector" => ".ezfc-step-button",
						"property" => "color"
					),
					"value" => ""
				),
				"css_step_button_border" => array(
					"id" => 67,
					"name" => "css_step_button_border",
					"description" => __("Step button border", "ezfc"),
					"description_long" => __("Color, size (px), style, border-radius (px)", "ezfc"),
					"type" => "border",
					"separator" => " ",
					"css" => array(
						"selector" => ".ezfc-step-button",
						"property" => "border"
					),
					"value" => ""
				),
				"css_title_font_size" => array(
					"id" => 68,
					"name" => "css_title_font_size",
					"description" => __("Step title font size", "ezfc"),
					"type" => "dimensions",
					"css" => array(
						"selector" => ".ezfc-step-title",
						"property" => "font-size"
					),
					"value" => ""
				),
				// fixed price
				"css_fixed_price_font_size" => array(
					"id" => 72,
					"name" => "css_fixed_price_font_size",
					"description" => __("Fixed price font size", "ezfc"),
					"type" => "dimensions",
					"css" => array(
						"selector" => ".ezfc-fixed-price",
						"property" => "font-size"
					),
					"value" => ""
				),
				"css_fixed_price_background_color" => array(
					"id" => 73,
					"name" => "css_fixed_price_background_color",
					"description" => __("Fixed price background color", "ezfc"),
					"type" => "colorpicker",
					"css" => array(
						"selector" => ".ezfc-fixed-price",
						"property" => "background-color"
					),
					"value" => ""
				),
				"css_fixed_price_text_color" => array(
					"id" => 74,
					"name" => "css_fixed_price_text_color",
					"description" => __("Fixed price color", "ezfc"),
					"type" => "colorpicker",
					"css" => array(
						"selector" => ".ezfc-fixed-price",
						"property" => "color"
					),
					"value" => ""
				),
				// summary table
				"css_summary_width" => array(
					"id" => 82,
					"name" => "css_summary_width",
					"description" => __("Summary table width", "ezfc"),
					"type" => "dimensions",
					"css" => array(
						"selector" => ".ezfc-summary-table",
						"property" => "width"
					),
					"value" => ""
				),
				"css_summary_bgcolor_even" => array(
					"id" => 83,
					"name" => "css_summary_bgcolor_even",
					"description" => __("Summary table even row", "ezfc"),
					"type" => "colorpicker",
					"css" => array(
						"selector" => ".ezfc-summary-table tr:nth-child(even)",
						"property" => "background-color"
					),
					"value" => ""
				),
				"css_summary_bgcolor_odd" => array(
					"id" => 84,
					"name" => "css_summary_bgcolor_odd",
					"description" => __("Summary table odd row", "ezfc"),
					"type" => "colorpicker",
					"css" => array(
						"selector" => ".ezfc-summary-table tr:nth-child(odd)",
						"property" => "background-color"
					),
					"value" => ""
				),
				"css_summary_text_color" => array(
					"id" => 85,
					"name" => "css_summary_text_color",
					"description" => __("Summary table text color", "ezfc"),
					"type" => "colorpicker",
					"css" => array(
						"selector" => ".ezfc-summary-table",
						"property" => "color"
					),
					"value" => ""
				),
				"css_summary_total_background" => array(
					"id" => 86,
					"name" => "css_summary_total_background",
					"description" => __("Summary total row color", "ezfc"),
					"type" => "colorpicker",
					"css" => array(
						"selector" => ".ezfc-summary-table .ezfc-summary-table-total",
						"property" => "background-color"
					),
					"value" => ""
				),
				"css_summary_total_color" => array(
					"id" => 87,
					"name" => "css_summary_total_color",
					"description" => __("Summary total text color", "ezfc"),
					"type" => "colorpicker",
					"css" => array(
						"selector" => ".ezfc-summary-table .ezfc-summary-table-total",
						"property" => "color"
					),
					"value" => ""
				),
				"css_summary_table_padding" => array(
					"id" => 88,
					"name" => "css_summary_table_padding",
					"description" => __("Summary table padding", "ezfc"),
					"type" => "dimensions",
					"css" => array(
						"selector" => ".ezfc-summary-table td",
						"property" => "padding"
					),
					"value" => ""
				),
				// other
				"css_form_padding" => array(
					"id" => 69,
					"name" => "css_form_padding",
					"description" => __("Form padding", "ezfc"),
					"type" => "dimensions",
					"css" => array(
						"selector" => ".ezfc-form",
						"property" => "padding"
					),
					"value" => ""
				),
				"css_form_width" => array(
					"id" => 70,
					"name" => "css_form_width",
					"description" => __("Form width", "ezfc"),
					"type" => "dimensions",
					"css" => array(
						"selector" => ".ezfc-form",
						"property" => "width"
					),
					"value" => ""
				)
			),
			
			"WooCommerce" => array(
				"woo_product_id" => array(
					"id" => 35,
					"name" => "woo_product_id",
					"default" => "",
					"description" => __("WooCommerce Product ID", "ezfc"),
					"description_long" => __("WooCommerce product ID for this form", "ezfc"),
					"type" => "",
					"value" => ""
				),
				"woo_disable_form" => array(
					"id" => 37,
					"name" => "woo_disable_form",
					"default" => "0",
					"description" => __("Disable WooCommerce for this form", "ezfc"),
					"description_long" => __("In case you don't want to add products from this form (e.g. use it as a contact form), you can set this to 'Yes'.", "ezfc"),
					"type" => "yesno",
					"value" => ""
				),
				"woo_categories" => array(
					"id" => 90,
					"name" => "woo_categories",
					"default" => "",
					"description" => __("Categories", "ezfc"),
					"description_long" => __("Add form to these product categories only. Separate categories by comma. <strong>Use category slug, not name!</strong>. Leave blank to add the form to all categories.", "ezfc"),
					"type" => "input",
					"value" => ""
				)
			)
		);

		if ($flat) {
			$settings = self::flatten($settings);
		}

		return $settings;
	}

	static function flatten($settings) {
		$settings_flat = array();

		foreach ($settings as $cat => $settings_cat) {
			foreach ($settings_cat as $name => $setting) {
				$tmp_id = "";
				
				if (is_array($setting)) {
					if (!empty($setting["id"])) $tmp_id = $setting["id"];
					else if (!empty($setting["name"])) $tmp_id = $setting["name"];
					else $tmp_id = $name;
				}
				else if (is_object($setting)) {
					if (!empty($setting->id)) $tmp_id = $setting->id;
					else if (!empty($setting->name)) $tmp_id = $setting->name;
					else $tmp_id = $name;
				}

				$settings_flat[$tmp_id] = $setting;
			}
		}

		return $settings_flat;
	}
}