jQuery(document).ready(function($) {
	/**
		global functions for custom calculation codes
	**/
	ezfc_functions = {
		get_value_from: function(id, is_text) {
			return ezfc_get_value_from_element(null, id, is_text);
		}
	};

	// listeners for external values on change
	var external_listeners = [];
	var ezfc_price_old_global = [];

	numeral.language("ezfc", {
		delimiters: {
			decimal:   ezfc_vars.price_format_dec_point,
			thousands: ezfc_vars.price_format_dec_thousand
		},
		abbreviations: {
            thousand: 'k',
            million: 'm',
            billion: 'b',
            trillion: 't'
        },
        ordinal: function (number) {
            var b = number % 10;
            return (~~ (number % 100 / 10) === 1) ? 'th' :
                (b === 1) ? 'st' :
                (b === 2) ? 'nd' :
                (b === 3) ? 'rd' : 'th';
        },
        currency: {
            symbol: '$'
        }
	});
	numeral.language("ezfc");

	var defaultFormat = ezfc_vars.price_format ? ezfc_vars.price_format : "0,0[.]00";
	numeral.defaultFormat(defaultFormat);

	// datepicker language
	$.datepicker.setDefaults($.datepicker.regional[ezfc_vars.datepicker_language]);

	// image option listener
	$(".ezfc-element-option-image").click(function() {
		// radio option image listener
		if ($(this).hasClass("ezfc-element-radio-image")) {
			var $parent_container = $(this).parents(".ezfc-element-wrapper-radio");

			// remove selected class from images
			$parent_container.find(".ezfc-selected").removeClass("ezfc-selected");
			// "uncheck"
			$parent_container.find(".ezfc-element-radio-input").prop("checked", false).trigger("change");
			// check radio input
			$(this).siblings(".ezfc-element-radio-input").prop("checked", true).trigger("change");
			// add selected class
			$(this).addClass("ezfc-selected");
		}
		else if ($(this).hasClass("ezfc-element-checkbox-image")) {
			var checkbox_el = $(this).siblings(".ezfc-element-checkbox-input");
			
			// uncheck it -> remove selected class
			if (checkbox_el.prop("checked")) {
				checkbox_el.prop("checked", false).trigger("change");
				$(this).removeClass("ezfc-selected");
			}
			// check it
			else {
				checkbox_el.prop("checked", true).trigger("change");
				$(this).addClass("ezfc-selected");
			}
		}
	});

	// init vars / events for each form
	var ezfc_form_vars = [];
	// init form functions
	var ezfc_form_functions = [];
	$(".ezfc-form").each(function(i) {
		var form    = this;
		var form_id = $(this).data("id");
		
		ezfc_form_vars[form_id] = $(this).data("vars");
		if (typeof ezfc_form_vars[form_id] !== "object") {
			ezfc_form_vars[form_id] = $.parseJSON($(this).data("vars"));
		}

		// init listener for each form
		external_listeners[form_id] = [];

		// set request price text
		if (ezfc_form_vars[form_id].price_show_request == 1) {
			ezfc_price_request_toggle(form_id, false);
		}

		// init datepicker
		$(this).find(".ezfc-element-datepicker").each(function() {
			var el_settings = {};
			if ($(this).data("settings")) {
				el_settings = $(this).data("settings");
			}

			$(this).datepicker({
				dateFormat:     ezfc_form_vars[form_id].datepicker_format,
				minDate:        el_settings.minDate ? el_settings.minDate : "",
				maxDate:        el_settings.maxDate ? el_settings.maxDate : "",
				numberOfMonths: el_settings.numberOfMonths ? parseInt(el_settings.numberOfMonths) : 1,
				showAnim:       el_settings.showAnim ? el_settings.showAnim : "fadeIn",
				showWeek:       el_settings.showWeek=="1" ? el_settings.showWeek : false,
      			firstDay:       el_settings.firstDay ? el_settings.firstDay : false
			});
		});

		// init timepicker
		$(this).find(".ezfc-element-timepicker").each(function() {
			var el_settings = {};
			if ($(this).data("settings")) {
				el_settings = $(this).data("settings");
			}

			$(this).timepicker({
				minTime:    el_settings.minTime ? el_settings.minTime : null,
				maxTime:    el_settings.maxTime ? el_settings.maxTime : null,
				step:       el_settings.step ? el_settings.step : 30,
				timeFormat: el_settings.format ? el_settings.format : ezfc_form_vars[form_id].timepicker_format
			});
		});

		// date range setup
		$(this).find(".ezfc-element-daterange").each(function() {
			var date_format = ezfc_form_vars[form_id].datepicker_format;
			var element = $(this);

			// from
			if ($(this).hasClass("ezfc-element-daterange-from")) {
				$(this).datepicker({
					dateFormat: date_format,
					minDate: $(this).data("mindate"),
					maxDate: $(this).data("maxdate"),
					onSelect: function(selectedDate) {
						var minDays = $(this).data("mindays") || 0;
						var minDate = $.datepicker.parseDate(date_format, selectedDate);
						minDate.setDate(minDate.getDate() + minDays);

						element.siblings(".ezfc-element-daterange-to").datepicker("option", "minDate", minDate);
						element.trigger("change");
					}
				});
			}
			// to
			else {
				$(this).datepicker({
					dateFormat: ezfc_form_vars[form_id].datepicker_format,
					minDate: $(this).data("mindate"),
					maxDate: $(this).data("maxdate"),
					onSelect: function(selectedDate) {
						var minDays = $(this).data("mindays") || 0;
						var maxDate = $.datepicker.parseDate(date_format, selectedDate);
						maxDate.setDate(maxDate.getDate() - minDays);

						element.siblings(".ezfc-element-daterange-from").datepicker("option", "maxDate", maxDate);
						element.trigger("change");
					}
				});
			}
		});

		// colorpicker
		$(this).find(".ezfc-element-colorpicker").each(function() {
			var holder = $(this);
			var input  = holder.parents(".ezfc-element").find(".ezfc-element-colorpicker-input");

			var colorpicker = holder.colorpicker({
				container: holder
			}).on("changeColor.colorpicker", function(ev) {
				holder.css("background-color", ev.color.toHex());
				input.val(ev.color.toHex());
			});

			$(input).on("click focus", function() {
				colorpicker.colorpicker("show");
			}).on("change", function() {
				colorpicker.colorpicker("setValue", $(this).val());
			});
		});

		// if steps are used, move the submission button + summary table to the last step
		var steps = $(this).find(".ezfc-step");
		if (steps.length > 0) {
			var last_step = steps.last();
			
			$(this).find(".ezfc-summary-wrapper").appendTo(last_step);
			$(this).find(".ezfc-submit-wrapper").appendTo(last_step).addClass("ezfc-submit-step");
		}

		// put elements into groups
		$(".ezfc-custom-element[data-group]").each(function() {
			var group_id = $(this).data("group");
			var $group_element = $("#ezfc_element-" + group_id);

			// append element to group
			if ($group_element.length > 0) {
				$(this).appendTo($group_element);
			}
		});

		ezfc_set_price($(this));

		// init debug info
		if (ezfc_vars.debug_mode == "2") {
			$(this).append("<button id='ezfc-show-all-elements'>Show/hide elements</button>");

			$("#ezfc-show-all-elements").click(function() {
				if ($(this).hasClass("ezfc-debug-visible")) {
					$(this).removeClass("ezfc-debug-visible");
					$(form).find(".ezfc-tmp-visible").removeClass("ezfc-tmp-visible").hide();
				}
				else {
					$(this).addClass("ezfc-debug-visible");
					$(form).find(".ezfc-hidden").addClass("ezfc-tmp-visible").show().css("display", "inline-block");
				}

				return false;
			});
		}
	});

	$(".ezfc-element-fileupload").each(function(i, el) {
		var parent   = $(this).parents(".ezfc-element");
		var btn      = $(parent).find(".ezfc-upload-button");

		// build form data
		var form     = $(this).parents("form.ezfc-form");
		var form_id  = form.find("input[name='id']").val();
		var ref_id   = form.find("input[name='ref_id']").val();

		var formData = {
			action: "ezfc_frontend_fileupload",
			data: "id=" + form_id + "&ref_id=" + ref_id
		};

		$(this).fileupload({
			formData: formData,
			dataType: 'json',
		    add: function (e, data) {
		    	$(parent).find(".ezfc-bar").css("width", 0);
		    	$(parent).find(".progress").addClass("active");
		    	$(parent).find(".ezfc-fileupload-message").text("");

	            btn.click(function() {
	            	if ($(el).val() == "") return false;

	                data.submit();
	                $(btn).attr("disabled", "disabled");

	                e.preventDefault();
	                return false;
	            });
	        },
	        done: function (e, data) {
	        	if (data.result.error) {
	        		$(btn).removeAttr("disabled");
	        		$(parent).find(".ezfc-fileupload-message").text(data.result.error);
	        		$(parent).find(".ezfc-bar").css("width", 0);

	        		return false;
	        	}

	        	if ($(this).attr("multiple")) {
	        		$(this).val("");
	        		$(btn).removeAttr("disabled");
	        	}

	        	$(parent).find(".progress").removeClass("active");
	        	$(parent).find(".ezfc-fileupload-message").text(ezfc_vars.upload_success);
	        },
	        progressall: function (e, data) {
		        var progress = parseInt(data.loaded / data.total * 100, 10);
		        $(parent).find(".ezfc-bar").css("width", progress + "%");
		    },
		    replaceFileInput: false,
	        url: ezfc_vars.ajaxurl
		});
	});

	$(".ezfc-overview").dialog({
		autoOpen: false,
		modal: true
	});

	/**
		ui events
	**/
	// form has changed -> recalc price
	$(".ezfc-form input, .ezfc-form select").on("change keyup", function() {
		var form = $(this).parents(".ezfc-form");
		ezfc_form_change(form);
	});

	// number-slider
	$(".ezfc-slider").each(function(i, el) {
		var target = $(this);
		var $slider_element = $(el).parents(".ezfc-element").find(".ezfc-slider-element");

		$slider_element.slider({
			min:   target.data("min") || 0,
			max:   target.data("max") || 100,
			step:  target.data("stepsslider") || 1,
			value: target.val() || 0,
			slide: function(e, ui) {
				target.val(ui.value);
			},
			stop: function(e, ui) {
				target.trigger("change");
			}
		});

		if (target.hasClass("ezfc-pips")) {
			$slider_element.slider("pips", {
				rest: "label",
				step: target.data("stepspips") || 1
			});
		}

		// slider compatibility for mobile devices
		target.draggable();
	});

	// number-spinner
	$(".ezfc-spinner").each(function(i, el) {
		var target = $(this);

		target.spinner({
			min:  target.data("min") || 0,
			max:  target.data("max") || 100,
			step: target.data("stepsspinner") || 1,
			change: function() {
				target.trigger("change");
			},
			spin: function(ev, ui) {
				// change value before trigger
				target.val(ui.value);
				
				target.trigger("change");
			}
		});
	});

	// steps
	$(".ezfc-step-button").on("click", function() {
		var form_wrapper = $(this).parents(".ezfc-form");
		var current_step = parseInt(form_wrapper.find(".ezfc-step-active").data("step"));
		var next_step    = current_step + ($(this).hasClass("ezfc-step-next") ? 1 : -1);
		var verify_step  = $(this).hasClass("ezfc-step-next") ? 1 : 0;

		ezfc_set_step(form_wrapper, next_step, verify_step);
		return false;
	});

	// payment option text switch
	$(".ezfc-element-wrapper-payment input").on("change", function() {
		var form_id   = $(this).parents(".ezfc-form").data("id");

		// submit text will be toggled by ezfc_price_request_toggle()
		if (ezfc_form_vars[form_id].price_show_request == 1 || ezfc_form_vars[form_id].summary_enabled) return;

		var is_paypal     = $(this).data("value")=="paypal";
		var submit_text   = is_paypal ? ezfc_form_vars[form_id].submit_text.paypal : ezfc_form_vars[form_id].submit_text.default;
		var submit_button = $(this).parents(".ezfc-form").find(".ezfc-element-submit").val(submit_text);
	});

	// fixed price
	$(window).scroll(function() {
		ezfc_scroll();
	});
	ezfc_scroll();

	$(".ezfc-form").submit(function(e) {
		var form = $(this);

		ezfc_form_submit(form, -1);

		e.preventDefault();
		return false;
	});

	// reset button
	$(".ezfc-reset").click(function() {
		var $form = $(this).parents(".ezfc-form");
		ezfc_reset_form($form);

		return false;
	});

	// form has changed
	function ezfc_form_change(form) {
		var form_id = $(form).data("id");

		// clear hidden values
		ezfc_clear_hidden_values(form);

		// form has changed -> reset price + summary
		ezfc_form_vars[form_id].price_requested = 0;
		ezfc_form_vars[form_id].summary_shown = 0;

		$(form).find(".ezfc-summary-wrapper").fadeOut();
		
		// do not calculate when price request is enabled
		if (ezfc_form_vars[form_id].price_show_request == 1) {
			ezfc_price_request_toggle(form_id, false);
			
			return false;
		}
		
		ezfc_set_price(form);
		ezfc_set_submit_text(form);
	}

	/**
		form submitted
	**/
	function ezfc_form_submit(form, step) {
		$(".ezfc-loading").show();

		// set spinner icon to submit field
		var submit_icon = $(form).find(".ezfc-submit-icon");
		submit_icon.fadeIn();
		var submit_element = $(form).find("input[type='submit']");
		submit_element.attr("disabled", "disabled");

		// clear hidden elements (due to conditional logic)
		$(form).find(".ezfc-custom-hidden").each(function() {
			$(this).find("input, :selected").val("__HIDDEN__").addClass("ezfc-has-hidden-placeholder");

			// empty radio buttons --> select first element to submit __hidden__ data
			var radio_empty = $(this).find(".ezfc-element-radio:not(:has(:radio:checked))");
			if (radio_empty.length) {
				$(radio_empty).first().find("input").prop("checked", true);
			}
		});

		var id   = $(form).data("id");
		var data = "id=" + id + "&" + $(form).serialize();

		// request price for the first time
		if (ezfc_form_vars[id].price_requested == 0) {
			data += "&price_requested=1";
		}

		// summary
		if (ezfc_form_vars[id].summary_shown == 0) {
			data += "&summary=1";
		}

		// next/previous step
		if (step != -1) {
			data += "&step=" + step;
		}

		$.ajax({
			type: "post",
			url: ezfc_vars.ajaxurl,
			data: {
				action: "ezfc_frontend",
				data: data
			},
			success: function(response) {
				$(".ezfc-loading").hide();
				submit_element.removeAttr("disabled");
				submit_icon.fadeOut();

				if (ezfc_vars.debug_mode == "1") console.log(response);

				response = $.parseJSON(response);
				if (!response) {
					$(form).find(".ezfc-message").text("Something went wrong. :(");
					if (typeof Recaptcha !== "undefined") Recaptcha.reload();

					ezfc_reset_disabled_fields(form, true);
						
					return false;
				}

				// error occurred -> invalid form fields
				if (response.error) {
					ezfc_reset_disabled_fields(form, true);

					if (response.id) {
						// error tip (if the form uses steps, do not show this if all fields are valid up until this step)
						var show_error_tip = true;
						// error tip data
						var el_target = "#ezfc_element-" + response.id;
						var el_tip    = $(el_target).find(".ezfc-element").first();

						// check if form uses steps
						var use_steps = $(form).find(".ezfc-step-active").length > 0 ? true : false;
						if (use_steps) {
							var error_step = parseInt($(el_target).parents(".ezfc-step").data("step"));
							
							// if invalid field is not on the current step, do not show the tip. also, do not show the tip when submitting the form (step = -1)
							if (error_step != step && step != -1) {
								show_error_tip = false;
								ezfc_set_step(form, step + 1);
							}
						}

						if (show_error_tip) {
							if (!el_tip.length) {
								el_tip = $(el_target);
							}
							var tip_delay = use_steps ? 1000 : 400;

							$(el_tip).opentip(response.error, {
								delay: 800,
								hideDelay: 0.1,
								hideTriggers: ["closeButton", "target"],
								removeElementsOnHide: true,
								showOn: null,
								target: el_target,
								tipJoint: "middle right"
							}).show();

							ezfc_scroll_to(el_target);
						}
					}
					else {
						var message_wrapper = $(form).parents(".ezfc-wrapper").find(".ezfc-message");
						message_wrapper.text(response.error).fadeIn().delay(7500).fadeOut();
					}

					if (typeof Recaptcha !== "undefined") Recaptcha.reload();

					return false;
				}
				// next step
				else if (response.step_valid) {
					ezfc_reset_disabled_fields(form);
					ezfc_set_step(form, step + 1);

					return false;
				}
				// summary
				else if (response.summary) {
					$(form).find(".ezfc-summary-wrapper").fadeIn().find(".ezfc-summary").html(response.summary);
					ezfc_form_vars[id].summary_shown = 1;

					ezfc_reset_disabled_fields(form);

					return false;
				}

				// prevent spam
				if (typeof Recaptcha !== "undefined") Recaptcha.reload();

				// submit paypal form
				if (response.paypal) {
					// disable submit button again to prevent doubleclicking
					submit_element.attr("disabled", "disabled");
					// redirect to paypal express checkout url
					window.location.href = response.paypal;
				}
				else {
					// price request
					if (response.price_requested || response.price_requested === 0) {
						ezfc_price_request_toggle(id, true, response.price_requested);
						return;
					}

					// submission successful

					// reset form after submission
					if (ezfc_form_vars[id].reset_after_submission && ezfc_form_vars[id].reset_after_submission == 1) {
						ezfc_reset_form(form);

						$(".ezfc-success-text[data-id='" + id + "']").fadeIn().delay(7500).fadeOut();
						return;
					}

					// hide all forms
					if (ezfc_form_vars[id].hide_all_forms && ezfc_form_vars[id].hide_all_forms == 1) {
						$(".ezfc-form, .ezfc-required-notification").fadeOut();
					}
					else {
						$(form).fadeOut();
						$(form).find(".ezfc-required-notification").fadeOut();
					}

					$(".ezfc-success-text[data-id='" + id + "']").fadeIn();

					// redirect the user
					if (ezfc_form_vars[id] && ezfc_form_vars[id].redirect_url && ezfc_form_vars[id].redirect_url.length > 0) {
						window.location.href = ezfc_form_vars[id].redirect_url;
					}
				}
			}
		});
	}

	/**
		external values
	**/
	function calculate_get_external_values(form, form_id, el_object, el_type) {
		var value_external_element = el_object.data("value_external");
		if (value_external_element && $(value_external_element).length > 0) {
			// get external value
			var value_external;

			if ($(value_external_element).is("input[type='radio']")) {
				value_external = $(value_external_element).find(":checked").val();
			}
			else if ($(value_external_element).is("input, input[type='text'], textarea")) {
				value_external = $(value_external_element).val();
			}
			else if ($(value_external_element).is("select")) {
				value_external = $(value_external_element).find(":selected").text();
			}
			else {
				value_external = $(value_external_element).text();
			}

			// set external value
			if (el_type == "input" || el_type == "numbers" || el_type == "subtotal") {
				el_object.find("input").val(value_external);
			}
			else if (el_type == "dropdown") {
				el_object.find(":selected").removeAttr("selected");
				el_object.find("option[value='" + value_external + "']").attr("selected", "selected");
			}
			else if (el_type == "radio") {
				el_object.find(":checked").removeAttr("checked");
				el_object.find("input[value='" + value_external + "']").attr("checked", "checked");
			}
			else if (el_type == "checkbox") {
				el_object.find(":checked").removeAttr("checked");
				el_object.find("input[value='" + value_external + "']").attr("checked", "checked");
			}

			// set event listener
			if (!external_listeners[form_id][value_external_element]) {
				external_listeners[form_id][value_external_element] = 1;

				$(value_external_element).on("change keyup", function() {
					ezfc_set_price($(form));
				});
			}
		}
	}


	/**
		conditionals
	**/
	function calculate_conditionals(form, form_id, el_object, el_type) {
		var cond_action       = el_object.data("conditional_action");
		var cond_operator     = el_object.data("conditional_operator");
		var cond_target       = el_object.data("conditional_target");
		var cond_value        = el_object.data("conditional_values");
		var cond_target_value = el_object.data("conditional_target_value");
		var cond_notoggle     = el_object.data("conditional_notoggle");
		var cond_redirects    = el_object.data("conditional_redirects");

		// check if there should be conditional actions
		if (!cond_action || cond_action == 0) return;

		var cond_actions_elements    = cond_action.toString().split(",");
		var cond_operator_elements   = cond_operator.toString().split(",");
		var cond_target_elements     = cond_target.toString().split(",");
		var cond_custom_values       = cond_value.toString().split(",");
		var cond_custom_target_value = cond_target_value.toString().split(",");
		var cond_notoggle_values     = cond_notoggle.toString().split(",");
		var cond_redirects_values    = cond_redirects.toString().split(",");

		// value of this element
		var el_value = parseFloat(el_object.val());
			
		// get selected value from input fields
		if (el_type == "input" || el_type == "numbers" || el_type == "subtotal") {
			el_value = parseFloat(el_object.find("input").val());
		}
		// get selected value from dropdowns
		else if (el_type == "dropdown") {
			el_value = parseFloat(el_object.find(":selected").data("value"));
		}
		// get selected value from radio
		else if (el_type == "radio") {
			el_value = parseFloat(el_object.find(":checked").data("value"));
		}
		// get selected values from checkboxes
		else if (el_type == "checkbox") {
			el_value = 0;
			el_object.find(":checked").each(function(ct, ct_el) {
				el_value += parseFloat($(ct_el).data("value"));
			});
		}
		// get amount of days from date range
		else if (el_type == "daterange") {
			var tmp_target_value = [
				// from
				$(el_object).find(".ezfc-element-daterange-from").datepicker("getDate"),
				// to
				$(el_object).find(".ezfc-element-daterange-to").datepicker("getDate")
			];

			el_value = jqueryui_date_diff(tmp_target_value[0], tmp_target_value[1]);
		}

		// go through all conditionals
		$.each(cond_actions_elements, function(ic, action) {
			// get conditional target element
			var cond_target;
			if (cond_target_elements[ic] == "submit_button") {
				cond_target = $(form).find(".ezfc-submit");
			}
			else {
				cond_target = $("#ezfc_element-" + cond_target_elements[ic]);
			}
			// no target element found
			if (cond_target.length < 1 && cond_redirects_values.length < 1) return;

			// do not parse float for input elements
			var cond_custom_value;
			if (el_type == "input") cond_custom_value = cond_custom_values[ic];
			else                    cond_custom_value = parseFloat(cond_custom_values[ic]);

			var do_action;
			// check if conditional is true - separate text and number elements
			if (el_type == "input") {
				do_action = cond_custom_value.toLowerCase()==cond_target.val().toLowerCase();
			}
			else {
				var cond_value_min_max = cond_custom_values[ic].split(":");

				switch (cond_operator_elements[ic]) {
					case "gr": do_action = el_value > cond_custom_value;
					break;
					case "gre": do_action = el_value >= cond_custom_value;
					break;

					case "less": do_action = el_value < cond_custom_value;
					break;
					case "lesse": do_action = el_value <= cond_custom_value;
					break;

					case "equals": do_action = el_value == cond_custom_value;
					break;

					case "between":
						if (cond_value_min_max.length < 2) {
							do_action = false;
						}
						else {
							do_action = (el_value >= cond_value_min_max[0] && el_value <= cond_value_min_max[1]);
						}
					break;

					case "not":
						if (cond_value_min_max.length < 2) {
							do_action = el_value != cond_custom_value;
						}
						else {
							do_action = (el_value < cond_value_min_max[0] && el_value > cond_value_min_max[1]);
						}
					break;

					case "hidden": do_action = el_object.hasClass("ezfc-custom-hidden");
					break;

					case "visible": do_action = !el_object.hasClass("ezfc-custom-hidden");
					break;

					case "mod0": do_action = el_value > 0 && (el_value % cond_custom_value) == 0;
					break;
					case "mod1": do_action = el_value > 0 && (el_value % cond_custom_value) != 0;
					break;

					case "bit_and": do_action = el_value & cond_custom_value;
					break;

					case "bit_or": do_action = el_value | cond_custom_value;
					break;

					default: do_action = false;
					break;
				}
			}

			// conditional actions
			var js_action, js_counter_action;
			// when cond_notoggle_element is true, the opposite action will not be executed
			var cond_notoggle_element = cond_notoggle_values[ic];
			// target element type
			var cond_target_type = cond_target.data("element");

			// set cond_target to all direct child elements when it's a group
			if (cond_target_type == "group") {
				cond_target.push($(cond_target).find("> .ezfc-custom-element"));
			}

			// set values
			if (action == "set" && do_action) {
				if (cond_target_type == "input" || cond_target_type == "numbers" || cond_target_type == "subtotal" || cond_target_type == "set") {
					cond_target.find("input").val(cond_custom_target_value[ic]);
				}
				else if (cond_target_type == "dropdown") {
					cond_target.find(":selected").removeAttr("selected");
					cond_target.find("option[data-value='" + cond_custom_target_value[ic] + "']").prop("selected", "selected");
				}
				else if (cond_target_type == "radio") {
					cond_target.find(":checked").removeAttr("checked");
					cond_target.find("input[data-value='" + cond_custom_target_value[ic] + "']").prop("checked", true);
				}
				else if (cond_target_type == "checkbox") {
					cond_target.find("input[data-value='" + cond_custom_target_value[ic] + "']").prop("checked", true);
				}
				else if (cond_target_type == "checkbox") {
					cond_target.text(cond_custom_target_value[ic]);
				}
			}
			// activate element
			else if (action == "activate") {
				// activate
				if (do_action) {
					if (cond_target_type == "submit") cond_target.prop("disabled", false);
					else cond_target.data("calculate_enabled", 1);
				}
				// deactivate
				else if (cond_notoggle_element != 1) {
					if (cond_target_type == "submit") cond_target.prop("disabled", true);
					else cond_target.data("calculate_enabled", 0);
				}
			}
			// deactivate element
			else if (action == "deactivate") {
				// deactivate
				if (do_action) {
					if (cond_target_type == "submit") cond_target.prop("disabled", true);
					else cond_target.data("calculate_enabled", 0);
				}
				// activate
				else if (cond_notoggle_element != 1) {
					if (cond_target_type == "submit") cond_target.prop("disabled", false);
					cond_target.data("calculate_enabled", 1);
				}
			}
			// load form
			else if (action == "redirect" && do_action) {
				// set message
				var message_wrapper = $(form).parents(".ezfc-wrapper").find(".ezfc-message");
				message_wrapper.text(ezfc_form_vars[form_id].redirect_text).fadeIn();

				// hide the form
				$(form).fadeOut();

				setTimeout(function() {
					window.location.href = cond_redirects_values[ic];
				}, ezfc_form_vars[form_id].redirect_timer * 1000);
			}
			// show / hide elements
			else {
				if (action == "show") {
					js_action         = "removeClass";
					js_counter_action = "addClass";
				}
				else if (action == "hide") {
					js_action         = "addClass"
					js_counter_action = "removeClass";
				}
				else return;

				if (do_action) {
					cond_target[js_action]("ezfc-hidden ezfc-custom-hidden");
					
					// fade in
					if (action == "show") {
						cond_target.addClass("ezfc-fade-in");
					}
					// fade out
					else {
						$(cond_target).fadeOut(500, function() {
							cond_target.removeClass("ezfc-fade-in");

							if (ezfc_form_vars[form_id].clear_selected_values_hidden == 1) {
								// clear values
								ezfc_clear_hidden_values_element();
							}
						});
					}
				}
				// only do the counter action when notoggle is not enabled
				else if (cond_notoggle_element != 1) {
					cond_target[js_counter_action]("ezfc-hidden ezfc-custom-hidden");

					if (action == "show") { cond_target.removeClass("ezfc-fade-in"); }
					else { cond_target.addClass("ezfc-fade-in"); }
				}
			}
		});
	}


	/**
		element calculations
	**/
	function calculate_elements(form, form_id, el_object, el_type, price) {
		var calc_enabled    = el_object.data("calculate_enabled");
		var calc_operator   = el_object.data("calculate_operator") || 0;
		var calc_targets    = el_object.data("calculate_target") || 0;
		var calc_values     = el_object.data("calculate_values") || 0;
		var overwrite_price = el_object.data("overwrite_price");
	

		// dropdowns / radios / checkboxes could contain more values
		var calc_list = el_object.find(".ezfc-element-numbers, .ezfc-element-input-hidden, .ezfc-element-subtotal, .ezfc-element-daterange-container, .ezfc-element-set, .ezfc-element-extension, :selected, :checked, .ezfc-element-custom-calculation");

		$(calc_list).each(function(cl, cl_object) {
			var el_settings = {};
			if ($(this).data("settings")) {
				el_settings = $(this).data("settings");
			}

			// skip when calculation is disabled for hidden elements
			if ($(el_object).hasClass("ezfc-custom-hidden") && (!el_settings.hasOwnProperty("calculate_when_hidden") || el_settings.calculate_when_hidden == 0)) {
				ezfc_add_debug_info("calculate", el_object, "Skipped as element is hidden and calculate_when_hidden is not enabled.");
				return;
			}

			// no target or values to calculate with were found. skip for subtotals / hidden.
			if ((!calc_enabled || calc_enabled == 0) &&
			    !calc_targets &&
			    !calc_values &&
				el_type != "subtotal" &&
				el_type != "hidden" &&
				el_type != "extension") {
				ezfc_add_debug_info("calculate", el_object, "No target or values were found to calculate with. Subtotals and hidden elements are skipped.");
				return;
			}

			// check if calculation is enabled for this element
			if (!calc_enabled || calc_enabled == 0) {
				ezfc_add_debug_info("calculate", el_object, "Calculation is disabled.");
				return;
			}

			var factor       = parseFloat($(cl_object).data("factor"));
			var value_raw    = $(cl_object).val();
			var value        = parseFloat(value_raw);
			var value_pct    = value / 100;
			var value_is_pct = value_raw.indexOf("%") >= 0;

			// default values
			if (!value || isNaN(value)) value = 0;
			if ((!factor || isNaN(factor)) && factor !== 0) factor = 1;

			// set addprice to value first
			var addPrice = value;

			// basic calculations
			switch (el_type) {
				case "numbers":
				case "hidden":
				case "extension":
				case "set":
					addPrice = value * factor;
				break;

				case "dropdown":
				case "radio":
				case "checkbox":
					addPrice = parseFloat($(cl_object).data("value"));
					if (isNaN(addPrice)) addPrice = 0;
				break;

				case "subtotal":
					addPrice = price;
				break;

				case "daterange":
					var tmp_target_value = [
						// from
						$(cl_object).find(".ezfc-element-daterange-from").datepicker("getDate"),
						// to
						$(cl_object).find(".ezfc-element-daterange-to").datepicker("getDate")
					];

					addPrice = jqueryui_date_diff(tmp_target_value[0], tmp_target_value[1]) * factor;
				break;

				// custom calculation function
				case "custom_calculation":
					var function_name = $(el_object).find(".ezfc-element-custom-calculation").data("function");

					addPrice = parseFloat(window[function_name](price));
					$(el_object).find(".ezfc-element-custom-calculation-input").val(addPrice);

					// improve performance here
					if (ezfc_vars.debug_mode == 2) {
						var function_text = $(el_object).find(".ezfc-element-custom-calculation script").text();
						ezfc_add_debug_info("custom_calculation", el_object, "custom_calculation:\n" + function_text);
					}
				break;
			}

			// percent calculation
			if (value_is_pct) {
				addPrice = price * value_pct;
			}

			// advanced calculations
			var	calc_operator_elements = calc_operator.toString().split(",");
				calc_target_elements   = calc_targets.toString().split(",");
				calc_custom_values     = calc_values.toString().split(",");

			// check if any advanced calculations are present
			if (calc_operator_elements.length > 0 && calc_operator_elements[0] != 0) {
				// iterate through all operators elements
				$.each(calc_operator_elements, function(n, operator) {
					// no calculation operator
					if (!operator) {
						ezfc_add_debug_info("calculate", el_object, "#" + n + ": No operator found here.");
						return;
					}

					// target to be calculated with
					var calc_target = $("#ezfc_element-" + calc_target_elements[n]);

					// skip hidden element
					if (calc_target.hasClass("ezfc-custom-hidden")) {
						ezfc_add_debug_info("calculate", el_object, "#" + n + ": Skipping this element as it is conditionally hidden.");
						return;
					}

					// custom value used when no target was found
					var calc_value = calc_custom_values[n];

					// use value from target
					var target_value;
					if (calc_target.length > 0) {
						var calc_target_element = calc_target.data("element");

						// get value from numbers-element (multiplied with factor)
						if (calc_target_element == "numbers" || calc_target_element == "subtotal" || calc_target_element == "hidden") {
							var calc_target_input = calc_target.find("input");
							var target_factor     = parseFloat(calc_target_input.data("factor"));
							if (!target_factor || isNaN(target_factor)) target_factor = 1;

							target_value = parseFloat(calc_target_input.val()) * target_factor;
						}
						// get selected value from dropdowns
						else if (calc_target_element == "dropdown") {
							target_value = parseFloat(calc_target.find(":selected").data("value"));
						}
						// get selected value from radio
						else if (calc_target_element == "radio") {
							target_value = parseFloat(calc_target.find(":checked").data("value"));
						}
						// get selected values from checkboxes
						else if (calc_target_element == "checkbox") {
							target_value = 0;
							calc_target.find(":checked").each(function(ct, ct_el) {
								target_value += parseFloat($(ct_el).data("value"));
							});
						}
						// get amount of days from date range
						else if (calc_target_element == "daterange") {
							var tmp_target_value = [
								// from
								$(calc_target).find(".ezfc-element-daterange-from").datepicker("getDate"),
								// to
								$(calc_target).find(".ezfc-element-daterange-to").datepicker("getDate")
							];

							var target_factor = parseFloat($(calc_target).find(".ezfc-element-daterange-container").data("factor"));
							if (!target_factor || isNaN(target_factor)) target_factor = 1;

							target_value = jqueryui_date_diff(tmp_target_value[0], tmp_target_value[1]) * target_factor;
						}
						// get value from custom function
						else if (calc_target_element == "custom_calculation") {
							var function_name = $(calc_target).find(".ezfc-element-custom-calculation").data("function");

							target_value = parseFloat(window[function_name](calc_value));
						}
					}
					else if (calc_value != "0") {
						target_value = parseFloat(calc_value);
					}

					if (!target_value || isNaN(target_value)) target_value = 0;

					switch (operator) {
						case "add":	addPrice += target_value;
						break;

						case "subtract": addPrice -= target_value;
						break;

						case "multiply": addPrice *= target_value;
						break;

						case "divide": 
							if (target_value == 0) {
								ezfc_add_debug_info("calculate", el_object, "#" + n + ": Division by 0.");
								return;
							}

							addPrice /= target_value;

							// still necessary?
							if ($(cl_object).data("calculate_before") == "1") {
								overwrite_price = 1;
								addPrice = target_value / value;
							}
						break;

						case "equals":
							addPrice = target_value;
						break;

						case "power":
							addPrice = Math.pow(addPrice, target_value);
						break;

						case "ceil":
							addPrice = Math.ceil(addPrice);
						break;

						case "floor":
							addPrice = Math.floor(addPrice);
						break;

						case "round":
							addPrice = Math.round(addPrice);
						break;

						case "subtotal":
							addPrice = price;
						break;

						case "log":
							if (target_value == 0) return;
							addPrice = Math.log(target_value);
						break;
						case "log2":
							if (target_value == 0) return;
							addPrice = Math.log2(target_value);
						break;
						case "log10":
							if (target_value == 0) return;
							addPrice = Math.log10(target_value);
						break;
					}

					ezfc_add_debug_info("calculate", el_object, "#" + n + ": operator = " + operator + "\ntarget_value = " + target_value + "\ncalc_value = " + calc_value + "\naddPrice = " + addPrice);
				});
			}

			ezfc_add_debug_info("calculate", el_object, "\nprice = " + price + "\naddPrice = " + addPrice + "\nfactor = " + factor);

			if (overwrite_price == "1") {
				price = addPrice;
			}
			else if (calc_enabled == "1") {
				price += addPrice;
			}

			if (el_type == "subtotal") {
				var tmp_price = overwrite_price==1 ? price : addPrice;

				var precision = 2;
				if ($(cl_object).data("settings")) {
					el_settings = $(cl_object).data("settings");
					precision   = el_settings.precision;
				}

				var price_to_write = tmp_price.toFixed(precision);
				el_object.find("input").val(price_to_write);
			}
		});

		return price;
	}


	/**
		discount calculations
	**/
	function calculate_discounts(form, form_id, el_object, el_type, price) {
		var discount_range_min = el_object.data("discount_range_min");
		var discount_range_max = el_object.data("discount_range_max");
		var discount_operator  = el_object.data("discount_operator");
		var discount_value     = el_object.data("discount_values");

		// check if there should be conditional actions
		if (discount_value || discount_value == 0) {
			var discount_range_min_values = discount_range_min.toString().split(",");
			var discount_range_max_values = discount_range_max.toString().split(",");
			var discount_operator_values  = discount_operator.toString().split(",");
			var discount_value_values     = discount_value.toString().split(",");

			var el_value = 0;
			var factor   = 1;

			// get selected value from input fields
			if (el_type == "input" || el_type == "numbers" || el_type == "subtotal" || el_type == "hidden" || el_type == "extension") {
				var el_input = el_object.find("input");

				factor = parseFloat(el_input.data("factor"));
				if ((!factor || isNaN(factor)) && factor !== 0) factor = 1;

				el_value = parseFloat(el_input.val());
			}
			// get selected value from dropdowns
			else if (el_type == "dropdown") {
				el_value = parseFloat(el_object.find(":selected").data("value"));
			}
			// get selected value from radio
			else if (el_type == "radio") {
				el_value = parseFloat(el_object.find(":checked").data("value"));
			}
			// get selected values from checkboxes
			else if (el_type == "checkbox") {
				el_value = 0;
				el_object.find(":checked").each(function(ct, ct_el) {
					el_value += parseFloat($(ct_el).data("value"));
				});
			}
			// get amount of days from date range
			else if (el_type == "daterange") {
				var tmp_target_value = [
					// from
					el_object.find(".ezfc-element-daterange-from").datepicker("getDate"),
					// to
					el_object.find(".ezfc-element-daterange-to").datepicker("getDate")
				];

				el_value = jqueryui_date_diff(tmp_target_value[0], tmp_target_value[1]);
			}

			// go through all discounts
			$.each(discount_operator_values, function(id, operator) {
				if (!discount_range_min_values[id] && discount_range_min_values[id] !== 0) discount_range_min_values[id] = Number.NEGATIVE_INFINITY;
				if (!discount_range_max_values[id] && discount_range_max_values[id] !== 0) discount_range_max_values[id] = Number.POSITIVE_INFINITY;

				var discount_value_write_to_input;

				if (el_value >= parseFloat(discount_range_min_values[id]) && el_value <= parseFloat(discount_range_max_values[id])) {
					var disc_value = parseFloat(discount_value_values[id]);
					var discount_value_operator;

					switch (operator) {
						case "add":
							discount_value_operator = disc_value;
							discount_value_write_to_input = discount_value_operator;

							price += discount_value_write_to_input;
						break;

						case "subtract":
							discount_value_operator = disc_value;
							discount_value_write_to_input = discount_value_operator;

							price -= discount_value_write_to_input;
						break;

						case "percent_add":
							discount_value_operator = el_value * factor * (disc_value / 100);
							discount_value_write_to_input = price + discount_value_operator;

							price = discount_value_write_to_input;
						break;

						case "percent_sub":
							discount_value_operator = el_value * factor * (disc_value / 100);
							discount_value_write_to_input = price - discount_value_operator;

							price = discount_value_write_to_input;
						break;

						case "equals":
							discount_value_operator = disc_value;
							discount_value_write_to_input = discount_value_operator;

							price = discount_value_write_to_input;
						break;
					}

					if (el_type == "subtotal" && !isNaN(discount_value_write_to_input)) {
						$(el_object).find("input").val(discount_value_write_to_input.toFixed(2));
					}

					ezfc_add_debug_info("discount", el_object, "discount = " + discount_value_operator + "\nprice after discount = " + price);
				}
			});
		}


		return price;
	}

	/**
		set values for set elements
	**/
	function calculate_set_elements(form, form_id, el_object, el_type, price) {
		var set_operator = el_object.data("set_operator");
		var tmp_targets = el_object.data("set_elements");

		// check if there should be conditional actions
		if (!tmp_targets) return;

		var targets = tmp_targets.toString().split(",");
		var value_to_write;
		
		$.each(targets, function(i, v) {
			var target_object = $("#ezfc_element-" + v);

			if (!target_object) return;

			var target_type = $(target_object).data("element");

			// get selected value from input fields
			if (target_type == "input" || target_type == "numbers" || target_type == "subtotal" || target_type == "hidden" || target_type == "extension" || target_type == "set") {
				var el_input = target_object.find("input");

				factor = parseFloat(el_input.data("factor"));
				if ((!factor || isNaN(factor)) && factor !== 0) factor = 1;

				el_value = parseFloat(el_input.val());
			}
			// get selected value from dropdowns
			else if (target_type == "dropdown") {
				el_value = parseFloat(target_object.find(":selected").data("value"));
			}
			// get selected value from radio
			else if (target_type == "radio") {
				el_value = parseFloat(target_object.find(":checked").data("value"));
			}
			// get selected values from checkboxes
			else if (target_type == "checkbox") {
				el_value = 0;
				target_object.find(":checked").each(function(ct, ct_el) {
					el_value += parseFloat($(ct_el).data("value"));
				});
			}
			// get amount of days from date range
			else if (target_type == "daterange") {
				var tmp_target_value = [
					// from
					target_object.find(".ezfc-element-daterange-from").datepicker("getDate"),
					// to
					target_object.find(".ezfc-element-daterange-to").datepicker("getDate")
				];

				el_value = jqueryui_date_diff(tmp_target_value[0], tmp_target_value[1]);
			}

			// first element
			if (i == 0) {
				value_to_write = el_value;
				return;
			}

			switch (set_operator) {
				case "min":
					if (el_value < value_to_write) value_to_write = el_value;
				break;

				case "max":
					if (el_value > value_to_write) value_to_write = el_value;
				break;

				case "avg":
				case "sum":
					value_to_write += el_value;
				break;

				case "dif":
					value_to_write -= el_value;
				break;

				case "prod":
					value_to_write *= el_value;
				break;

				case "quot":
					if (el_value != 0) value_to_write /= el_value;
				break;
			}
		});

		if (set_operator == "avg") {
			value_to_write = value_to_write / targets.length;
		}

		el_object.find("input").val(value_to_write);
	}

	// price calculation
	function calculatePrice(form) {
		var price = 0;

		// remove debug info
		ezfc_remove_debug_info();	

		// find all elements first
		$(form).find(".ezfc-custom-element").each(function(i, element) {
			var form_id   = $(form).data("id");
			var el_object = $(element);
			var el_type   = $(element).data("element");

			// classes may have changed meanwhile
			if ($(this).hasClass("ezfc-hidden") &&
				el_type != "subtotal" &&
				el_type != "hidden" &&
				ezfc_form_vars[form_id].calculate_old == 1) return;

			// get external value if present
			calculate_get_external_values(form, form_id, el_object, el_type);

			// check conditionals
			calculate_conditionals(form, form_id, el_object, el_type);

			// classes may have changed meanwhile
			if ($(this).hasClass("ezfc-hidden") &&
				el_type != "subtotal" &&
				el_type != "hidden") return;

			// set elements
			calculate_set_elements(form, form_id, el_object, el_type);

			// process calculations
			price = calculate_elements(form, form_id, el_object, el_type, price);

			// discount
			price = calculate_discounts(form, form_id, el_object, el_type, price);

			// check conditionals again
			calculate_conditionals(form, form_id, el_object, el_type);
		});

		return price;
	}

	function ezfc_set_price(form, price_old) {
		var form_id = $(form).data("id");

		// calculate price
		if (!price_old || price_old !== 0) {
			price = calculatePrice($(form));
		}

		ezfc_set_subtotal_values($(form));

		// show price after request
		if (ezfc_form_vars[form_id].price_show_request == 1 && ezfc_form_vars[form_id].price_requested == 0) {
			ezfc_price_request_toggle(form_id, false);

			return;
		}

		if (typeof ezfc_price_old_global[form_id] === "undefined") ezfc_price_old_global[form_id] = 0;
		if (ezfc_price_old_global[form_id] == price) return;

		if (ezfc_form_vars[form_id].counter_duration != 0) {
			$(form).find(".ezfc-price-value").countTo({
				from: ezfc_price_old_global[form_id],
				to: price,
				speed: ezfc_form_vars[form_id].counter_duration,
				refreshInterval: ezfc_form_vars[form_id].counter_interval,
				formatter: function (value, options) {
					return ezfc_format_price(form_id, value);
				}
			});
		}
		else {
			$(form).find(".ezfc-price-value").text(ezfc_format_price(form_id, price));
		}

		ezfc_price_old_global[form_id] = price;
	}

	function ezfc_format_price(form_id, price, currency, custom_price_format) {
		var form_price_format = defaultFormat;
		var form_currency     = currency || ezfc_form_vars[form_id].currency;

		// use price format from form settings
		if (ezfc_form_vars[form_id].price_format && ezfc_form_vars[form_id].price_format.length > 0) {
			form_price_format = ezfc_form_vars[form_id].price_format;
		}

		// if defined, use custom price format
		if (custom_price_format && custom_price_format.length > 0) {
			form_price_format = custom_price_format;
		}

		var price_formatted = numeral(price).format(form_price_format);

		return price_formatted;
	}

	// price request toggler
	function ezfc_price_request_toggle(form_id, enable, price) {
		var form = $(".ezfc-form[data-id='" + form_id + "']");

		// enable submit
		if (enable) {
			ezfc_price_old_global[form_id] = 0;
			ezfc_form_vars[form_id].price_requested = 1;
			ezfc_set_price(form, price);

			ezfc_set_submit_text(form);
		}
		else {
			ezfc_form_vars[form_id].price_requested = 0;

			$(form).find(".ezfc-price-value").text(ezfc_form_vars[form_id].price_show_request_before);
			$(form).find(".ezfc-submit").val(ezfc_form_vars[form_id].price_show_request_text);
		}
	}

	function ezfc_set_subtotal_values(form) {
		$(form).find("[data-element='subtotal']").each(function(i, el) {
			var $subtotal_element = $(el).find(".ezfc-element-subtotal");
			var value             = $subtotal_element.val();
			var price_format      = null;

			var el_settings, text;

			if ($subtotal_element.data("settings")) {
				el_settings  = $subtotal_element.data("settings");
				price_format = el_settings.price_format;
			}

			text = ezfc_format_price($(form).data("id"), value, null, price_format);

			$(el).find(".ezfc-text").text(text);
		});
	}

	function ezfc_scroll() {
		$(".ezfc-fixed-price").each(function() {
			var offset             = $(this).offset();
			var form_id            = $(this).data("id");
			var form               = $(".ezfc-form[data-id='" + form_id + "']");
			var form_height        = form.outerHeight();
			var form_offset        = form.offset();
			var window_top         = $(window).scrollTop();
			var price_position_top = parseFloat(ezfc_form_vars[form_id].price_position_scroll_top);

			var diff = form_offset.top - window_top - price_position_top;
			if (diff < 0 && diff > -form_height) $(this).offset({ top: window_top + price_position_top });
			if (diff > 0 && offset.top > form_offset.top) $(this).offset({ top: form_offset.top });
		});
	}

	// reset disabled fields and restore initial values (since they may have changed due to conditional logic). also, set the relevant submit button text
	function ezfc_reset_disabled_fields(form, error) {
		$(form).find(".ezfc-custom-hidden").each(function() {
			$.each($(this).find("input, :selected"), function(i, v) {
				$(this).val($(this).data("index")).removeAttr("disabled");
			});
		});

		ezfc_set_submit_text(form, error);
	}

	// reset the whole form
	function ezfc_reset_form($form) {
		// reset values
		$form.find(".ezfc-custom-element").each(function() {
			var el_type = $(this).data("element");
			var initvalue = $(this).find("[data-initvalue]").data("initvalue");

			switch (el_type) {
				case "checkbox":
					$(this).find("input").each(function() {
						var initvalue = $(this).data("initvalue");

						if (initvalue == 1)
							$(this).prop("checked", true);
						else
							$(this).removeAttr("checked");
					});
				break;

				case "dropdown":
					$(this).find("option").removeAttr("selected");
					$(this).find("option[data-index='" + initvalue + "']").prop("selected", true);
				break;

				case "radio":
					$(this).find("input").removeAttr("checked");
					$(this).find("input[data-initvalue]").prop("checked", true);
				break;

				default:
					$(this).find("input").val(initvalue);
				break;
			}
		});

		ezfc_form_change($form);
	}

	function ezfc_set_step(form, new_step, verify) {
		var current_step = parseInt(form.find(".ezfc-step-active").data("step"));
		var step_wrapper = form.find("[data-step='" + current_step + "']");
		var form_id      = form.data("id");

		// check ajax
		if (verify == 1) {
			var submit_icon = $(form).find(".ezfc-submit-icon");
			submit_icon.fadeIn();

			ezfc_form_submit(form, new_step - 1);

			$(".ezfc-has-hidden-placeholder").val("").removeClass("ezfc-has-hidden-placeholder");
			return;
		}

		step_wrapper.fadeOut(200, function() {
			var step_wrapper_next = form.find("[data-step='" + new_step + "']");
			
			step_wrapper_next.fadeIn(200).addClass("ezfc-step-active");
			$(this).removeClass("ezfc-step-active");

			if (ezfc_vars.auto_scroll_steps == 1) {
				ezfc_scroll_to(step_wrapper_next, 200);
			}
		});

		return false;
	}

	function ezfc_scroll_to(element, custom_offset) {
		var element_offset = $(element).offset().top;
		var offset_add = custom_offset || 50;

		$("html, body").animate({ scrollTop: element_offset - custom_offset });
	}

	function ezfc_get_value_from_element($el_object, e_id, is_text) {
		if (!$el_object) $el_object = $("#ezfc_element-" + e_id);

		var el_type      = $el_object.data("element");
		var value_raw    = $el_object.val();
		var value        = parseFloat(value_raw);
		var value_pct    = value / 100;
		var value_is_pct = value_raw ? value_raw.indexOf("%") >= 0 : 0;

		// default values
		if (!value || isNaN(value)) value = 0;

		// set addprice to value first
		var addPrice = value;

		// basic calculations
		switch (el_type) {
			case "subtotal":
			case "numbers":
			case "hidden":
			case "extension":
			case "set":
				var $input_element = $el_object.find("input");
				var factor = parseFloat($input_element.data("factor"));

				if ((!factor || isNaN(factor)) && factor !== 0) factor = 1;

				value = parseFloat($input_element.val());

				addPrice = value * factor;
			break;

			case "dropdown":
			case "radio":
			case "checkbox":
				$el_object.find(":selected, :checked").each(function() {
					addPrice += parseFloat($(this).data("value"));
				});
			break;

			case "daterange":
				var tmp_target_value = [
					// from
					$el_object.find(".ezfc-element-daterange-from").datepicker("getDate"),
					// to
					$el_object.find(".ezfc-element-daterange-to").datepicker("getDate")
				];

				var factor = parseFloat($el_object.find(".ezfc-element-daterange-from").data("factor"));

				if ((!factor || isNaN(factor)) && factor !== 0) factor = 1;

				addPrice = jqueryui_date_diff(tmp_target_value[0], tmp_target_value[1]) * factor;
			break;

			// custom calculation function
			case "custom_calculation":
				var function_name = $el_object.find(".ezfc-element-custom-calculation").data("function");

				addPrice = parseFloat($el_object.find(".ezfc-element-custom-calculation-input").val());
			break;
		}

		// percent calculation
		if (value_is_pct) {
			addPrice = price * value_pct;
		}

		if (isNaN(addPrice)) addPrice = 0;

		if (!is_text) {
			return !addPrice ? 0 : parseFloat(addPrice);
		}
		else {
			return addPrice;
		}
	}

	function ezfc_clear_hidden_values(form) {
		var form_id = $(form).data("id");
		if (ezfc_form_vars[form_id].clear_selected_values_hidden != 1) return;

		$(form).find(".ezfc-custom-hidden").each(function() {	
			$(this).find("input[type='text']").val("");
    		$(this).find(":checkbox, :radio").prop("checked", false);
		});
	}

	function ezfc_clear_hidden_values_element(element) {
		var cond_target_type = element.data("element");

		if (cond_target_type == "input" || cond_target_type == "numbers" || cond_target_type == "subtotal") {
			cond_target.find("input").val("");
		}
		else if (cond_target_type == "dropdown") {
			cond_target.find(":selected").removeAttr("selected");
		}
		else if (cond_target_type == "radio" || cond_target_type == "checkbox") {
			cond_target.find(":checked").removeAttr("checked");
		}
	}

	function ezfc_set_submit_text(form, error) {
		var form_id = $(form).data("id");

		// default submit text
		var submit_text = ezfc_form_vars[form_id].submit_text.default;
		
		// price request
		if (ezfc_form_vars[form_id].price_show_request == 1 && error) {
			ezfc_price_request_toggle(form_id, false);
			return false;
		}
		// summary
		else if (ezfc_form_vars[form_id].summary_enabled == 1 && ezfc_form_vars[form_id].summary_shown == 0) {
			submit_text = ezfc_form_vars[form_id].submit_text.summary;
		}
		// paypal
		else if (ezfc_form_vars[form_id].use_paypal == 1) {
			submit_text = ezfc_form_vars[form_id].submit_text.paypal;
		}
		// woocommerce
		else if (ezfc_form_vars[form_id].use_woocommerce == 1) {
			submit_text = ezfc_form_vars[form_id].submit_text.woocommerce;
		}
		// default text
		else {
			var is_paypal = false;

			// check is payment method is used
			var payment_method_element = $(form).find(".ezfc-element-wrapper-payment");
			if (payment_method_element.length > 0) {
				is_paypal = $(payment_method_element).find(":checked").data("value") == "paypal";
			}

			submit_text = is_paypal ? ezfc_form_vars[form_id].submit_text.paypal : ezfc_form_vars[form_id].submit_text.default;
		}

		$(form).find(".ezfc-submit").val(submit_text);
	}

	/**
		debug
	**/
	function ezfc_remove_debug_info() {
		$(".ezfc-debug-info").remove();
	}

	function ezfc_add_debug_info(type, element, text) {
		if (ezfc_vars.debug_mode != 2) return;

		console.log(text, element);

		$(element).append("<pre class='ezfc-debug-info ezfc-debug-type-" + type + "'>[" + type + "]\n" + text + "</pre>");
	}

	/**
		misc
	**/
	function jqueryui_date_diff(start, end) {
		if (!start || !end)  return 0;

		return (end - start) / 1000 / 60 / 60 / 24;
	}
});

// global functions for custom calculation codes
ezfc_functions = {};