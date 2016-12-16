jQuery(document).ready(function($) {
	/**
		ui
	**/
	$.fx.speeds._default = 200;
	if (typeof tinyMCE !== "undefined") {
		tinyMCE.init({
			plugins: "wordpress wplink",
			menubar: false
		});
	}

	// colorpicker
	$(".ezfc-element-colorpicker-input").wpColorPicker();

	ezfc_z_index = 10;
	form_changed = false;

	/**
		operator lists
	**/
	var ezfc_operators = [
		{ value: "0", text: " " },
		{ value: "add", text: "+" },
		{ value: "subtract", text: "-" },
		{ value: "multiply", text: "*" },
		{ value: "divide", text: "/" },
		{ value: "equals", text: "=" },
		{ value: "power", text: "^" },
		{ value: "floor", text: "floor" },
		{ value: "ceil", text: "ceil" },
		{ value: "round", text: "round" },
		{ value: "subtotal", text: "subtotal" },
		{ value: "log", text: "log" },
		{ value: "log2", text: "log2" },
		{ value: "log10", text: "log10" }
	];

	var ezfc_operators_discount = [
		{ value: "0", text: " " },
		{ value: "add", text: "+" },
		{ value: "subtract", text: "-" },
		{ value: "percent_add", text: "%+" },
		{ value: "percent_sub", text: "%-" },
		{ value: "equals", text: "=" }
	];

	var ezfc_cond_operators = [
		{ value: "0", text: " " },
		{ value: "gr", text: ">" },
		{ value: "gre", text: ">=" },
		{ value: "less", text: "<" },
		{ value: "lesse", text: "<=" },
		{ value: "equals", text: "=" },
		{ value: "between", text: "between" },
		{ value: "not", text: "not" },
		{ value: "hidden", text: "is hidden" },
		{ value: "visible", text: "is visible" },
		{ value: "mod0", text: "%x = 0" },
		{ value: "mod1", text: "%x != 0" },
		{ value: "bit_and", text: "bitwise AND" },
		{ value: "bit_or", text: "bitwise OR" }
	];

	var ezfc_cond_actions = [
		{ value: "0", text: " " },
		{ value: "show", text: "Show" },
		{ value: "hide", text: "Hide" },
		{ value: "set", text: "Set" },
		{ value: "activate", text: "Activate" },
		{ value: "deactivate", text: "Deactivate" },
		{ value: "redirect", text: "Redirect" }
	];

	var ezfc_set_operators = [
		{ value: "min", text: "Minimum" },
		{ value: "max", text: "Maximum" },
		{ value: "avg", text: "Average" },
		{ value: "sum", text: "Sum" },
		{ value: "dif", text: "Difference" },
		{ value: "prod", text: "Product" },
		{ value: "quot", text: "Quotient" }
	];

	// tabs
	$("#tabs").tabs();

	// dialogs
	var dialog_default_attr = {
		autoOpen: false,
		height: Math.min(800, $(window).height() - 200),
		width: Math.min(1200, $(window).width() - 200),
		modal: true
	};

	var dialog_options_buttons = {
		buttons: {
			"Update options": function() {
				$(".ezfc-option-save").click();
			},
			"Cancel": function() {
				$(this).dialog("close");
			}
		}
	};

	var dialog_import_buttons = {
		buttons: {
			"Import text data": function() {
				$("[data-action='form_import_data']").click();
			},
			"Cancel": function() {
				$(this).dialog("close");
			}
		}
	};

	var dialog_default_buttons = {
		buttons: {
			"Close": function() {
				$(this).dialog("close");
			}
		}
	}

	$(".ezfc-options-dialog").dialog($.extend(dialog_default_attr, dialog_options_buttons));
	$(".ezfc-import-dialog").dialog($.extend(dialog_default_attr, dialog_import_buttons));
	$(".ezfc-default-dialog").dialog($.extend(dialog_default_attr, dialog_default_buttons));

	// ajax actions
	$("body").on("click", "[data-action]", function() {
		if ($(this).data("action") == "form_get" && form_changed) {
			if (!confirm(ezfc_vars.form_changed)) {
				$(".ezfc-loading").hide();
				return false;
			}
		}

		var selectgroup = $(this).data("selectgroup");
		if (selectgroup) {
			$(".button-primary[data-selectgroup='" + selectgroup + "']").removeClass("button-primary");
			$(this).addClass("button-primary");
		}

		do_action($(this));

		return false;
	});

	// toggle form element data
	$("body").on("click", ".ezfc-form-element-name", function() {
		var form_element_data = $(this).parent().find("> .ezfc-form-element-data");
		// toggle element data and increase z-index
		form_element_data.toggle().css("z-index", ++ezfc_z_index);

		custom_trigger_change(form_element_data);
	});
	// toggle submission data
	$("body").on("click", ".ezfc-form-submission-name", function() {
		$(this).parent().find(".ezfc-form-submission-data").toggle();
	});

	// image upload
	$("body").on("click", ".ezfc-image-upload", function(event) {
		event.preventDefault();

		var file_frame;
		var _this = this;

	    file_frame = wp.media.frames.file_frame = wp.media({
	      title: jQuery( this ).data( 'uploader_title' ),
	      button: {
	        text: jQuery( this ).data( 'uploader_button_text' ),
	      },
	      multiple: false
	    });
	 
	    file_frame.on( 'select', function() {
	    	var attachment = file_frame.state().get('selection').first().toJSON();
	    	$(_this).parent().find("input").val(attachment.url);
	    	$(_this).parent().find(".ezfc-image-preview").attr("src", attachment.url);
	    });
	 
	    file_frame.open();
    });
    // clear image
    $("body").on("click", ".ezfc-clear-image", function() {
    	var $parent = $(this).parent();

    	$parent.find("input").val("");
    	$parent.find("img").attr("src", "");

    	return false;
    });

	// hide/show element data
	$(".ezfc-toggle-show").on("click", function() {
		$(".ezfc-form-element-data, .ezfc-form-submission-data").show();
	});
	$(".ezfc-toggle-hide").on("click", function() {
		$(".ezfc-form-element-data, .ezfc-form-submission-data").hide();
	});
	// toggle expand view
	$(".ezfc-toggle-expand").on("click", function() {
		$(".ezfc-form-elements-container").toggleClass("full-width");
	});

	// add option
	$("body").on("click", ".ezfc-form-element-option-add", function() {
		form_changed = true;

		var target_element_id = $(this).data("element_id");
		var target            = $($(this).data("target") + "[data-element_id='" + target_element_id + "']:last");
		var target_row_new    = parseInt($(target).data("row")) + 1;

		$(target).clone()
			.attr("data-row", target_row_new) // .data("row", 1) does not work here :/
			.insertAfter(target)
			.find("input, select, textarea").each(function() {
				var option_array = $(this).attr("name").replace(/\]/g, "").split("[");

				var option_type = option_array[2];
				var option_name = option_array.splice(-1);
				var option_name_new;

				if ($(this).attr("type") == "radio") {
					option_name_new = "elements[" + target_element_id + "][" + option_name + "]";

					$(this).val(parseInt($(this).val()) + 1);
				}
				else {
					option_name_new = "elements[" + target_element_id + "][" + option_type + "][" + target_row_new + "][" + option_name + "]";
				}

				$(this).attr("name", option_name_new);
			});

		custom_trigger_change($(this).parents(".ezfc-form-element-data"));

		return false;
	});
	// delete option
	$("body").on("click", ".ezfc-form-element-option-delete", function() {
		var target            = $(this).parents($(this).data("target"));
		var target_element_id = $(this).data("element_id");

		var target_length = $($(this).data("target") + "[data-element_id='" + target_element_id + "']").length;
		if (target_length <= 1) return false;

		$(target).remove();

		return false;
	});

	// move option fields
	$("body").on("click", ".ezfc-form-element-move", function() {
		var target_selector = $(this).data("target");
		var target = $(this).parents(target_selector);
		var target_swap;

		// move up
		if ($(this).hasClass("ezfc-form-element-move-up")) {
			if ($(target).prev(target_selector).length < 1) return false;
			
			target_swap = $(target).prev(target_selector);

			$(target).slideUp(function() {
				$(target).after($(target).prev(target_selector)).slideDown();
			});
		}
		// move down
		else {
			if ($(target).next(target_selector).length < 1) return false;

			target_swap = $(target).next(target_selector);

			$(target).slideUp(function() {
				$(target).before($(target).next(target_selector)).slideDown();
			});
		}

		// change input fields
		$(target).find("select, input").each(function() {
			var input_class = $(this).attr("class");
			var input_name  = $(this).attr("name");

			var input_swap_name = $(target_swap).find("[class='" + input_class + "']").attr("name");

			$(this).attr("name", input_swap_name);
			$(target_swap).find("[class='" + input_class + "']").attr("name", input_name);
		});

		return false;
	});

	// restrict calculation target / value field
	var trigger_change_classes = ".ezfc-form-element-calculate-target, .ezfc-form-element-calculate-operator, .ezfc-form-element-conditional-action";
	$("body").on("change", trigger_change_classes, function() {
		custom_trigger_change($(this).closest(".ezfc-form-element-data"));
	});

	// refresh calculation fields
	$("body").on("click", ".ezfc-form-calculate-refresh", function() {
		fill_calculate_fields();

		return false;
	});

	// label name keyboard input
	$("body").on("keyup", ".ezfc-form-element-data .element-label-listener", function() {
		var text = $(this).val();

		$(this).closest(".ezfc-form-element").find(".element-label").text(text);
	});

	// add changed class upon change
	$("body").on("keyup change", ".ezfc-form-element-data input, .ezfc-form-element-data select", function() {
		ezfc_form_has_changed(this);
	});
	// add changed class when options were added / removed
	$("body").on("click", ".ezfc-form-element-data button", function() {
		ezfc_form_has_changed(this);
	});

	// required toggle char
	$("body").on("click", ".ezfc-form-element-required-toggle", function() {
		form_changed = true;

		var req_char = $(this).val()==1 ? "*" : "";
		$(this).closest(".ezfc-form-element").find(".ezfc-form-element-required-char").text(req_char);
	});

	// preview suppress submit
	$("body").on("click", "form .ezfc-element-submit", function() {
		return false;
	});

	// column change
	$("body").on("click", ".ezfc-form-element-column-left", function() {
		change_columns($(this), -1);
		return false;
	});
	$("body").on("click", ".ezfc-form-element-column-right", function() {
		change_columns($(this), 1);
		return false;
	});

	// group toggle
	$("body").on("click", ".ezfc-form-element-group-toggle", function() {
		$(this).closest(".ezfc-form-element").find("> .ezfc-group").toggle();

		var icon_set = ["fa-toggle-up", "fa-toggle-down"];

		var $group_icon_el = $(this).find(".fa");
		var old_icon       = $group_icon_el.hasClass(icon_set[0]) ? icon_set[0] : icon_set[1];
		var set_icon       = old_icon == icon_set[0] ? icon_set[1] : icon_set[0];
		
		$group_icon_el.removeClass(old_icon).addClass(set_icon);
		return false;
	});

	// tinymce toggle
	$("body").on("click", ".ezfc-html-tinymce-toggle", function() {
		if (typeof tinyMCE !== "undefined" && typeof tinyMCE.execCommand === "function") {
			var target = $(this).data("target");
			tinymce.execCommand("mceToggleEditor", false, target);
		}

		return false;
	});

	// icon dialog
	$("body").on("click", ".ezfc-icon-button", function() {
		icon_target = $(this).data("target");
		$(".ezfc-icons-dialog").dialog("open");

		return false;
	});
	$(".ezfc-icons-dialog i").on("click", function() {
		var icon = $(this).data("icon");
		
		$("#" + icon_target).val(icon);
		$("#" + icon_target + "-icon").attr("class", "fa " + icon);

		$(".ezfc-icons-dialog").dialog("close");
	});

	// image dialog
	$("body").on("click", ".ezfc-option-image-button", function() {
		event.preventDefault();

		var file_frame;
		var _this = this;

	    file_frame = wp.media.frames.file_frame = wp.media({
	      title: jQuery( this ).data( 'uploader_title' ),
	      button: {
	        text: jQuery( this ).data( 'uploader_button_text' ),
	      },
	      multiple: false
	    });
	 
	    file_frame.on( 'select', function() {
	    	var attachment = file_frame.state().get('selection').first().toJSON();
	    	$(_this).parent().find("input").val(attachment.url);
	    	$(_this).parent().find(".ezfc-option-image-placeholder").attr("src", attachment.url);
	    });
	 
	    file_frame.open();

		return false;
	});
	// image remove
	$("body").on("click", ".ezfc-option-image-remove", function() {
		$(this).siblings(".ezfc-form-element-option-image").val("");
		$(this).siblings(".ezfc-option-image-placeholder").attr("src", "");

		return false;
	});

	// functions help dialog
	$("body").on("click", ".ezfc-open-function-dialog", function() {
		$("#ezfc-custom-calculation-functions").dialog("open");
		
		return false;
	});

	/**
		import data via file
	**/
	if ($("#ezfc_import_file").length > 0) {
		var import_btn          = $(".ezfc-import-upload");
		var import_message_el   = $("#ezfc-import-message");
		var import_progress_bar = import_btn.siblings(".ezfc-bar");

		$("#ezfc_import_file").fileupload({
			formData: {
				action: "ezfc_backend",
				data: "action=form_import_upload&nonce=" + ezfc_nonce
			},
		    add: function (e, data) {
		    	data.submit();

		    	$(".ezfc-loading").fadeIn();
	        },
	        done: function (e, data) {
	        	import_message_el.text("");
	        	import_progress_bar.css("width", 0).text("");
	        	$(this).val("");

	        	if (data.result.error) {
	        		import_message_el.text(data.result.error);

	        		return false;
	        	}

	        	var result_json = $.parseJSON(data.result);

	        	form_add(result_json);
				form_show(result_json);

				$(".ezfc-dialog").dialog("close");
		        $(".ezfc-loading").fadeOut();
	        },
	        progressall: function (e, data) {
		        var progress = parseInt(data.loaded / data.total * 100, 10);
		        import_progress_bar.css("width", progress + "%").text("Importing...");
		    },
		    replaceFileInput: false,
	        url: ajaxurl
		});
	}

	/**
		ui functions
	**/
	function init_ui() {
		set_form_elements_height();

		var sortable_options = {
			connectWith: ".ezfc-group",
			distance: 5,
			forcePlaceholderSize: true,
			handle: ".ezfc-form-element-name",
			placeholder: "ui-state-highlight",
			stop: function(ev, ui) {
				var $item = $(ui.item[0]);

				var index = $item.index("li");

				// not dropped
				if (index < 0) {
					return false;
				}

				// closest but exclude self first
				var group_id = $item.parent().closest(".ezfc-form-element-group").data("id");

				// set group id value to element
				$item.find("[data-element-name='group_id']").val(group_id);
			}
		}

		// sortable elements (main view)
		$("#form-elements-list").sortable(sortable_options);
		// group list
		$(".ezfc-group").sortable($.extend(sortable_options, { connectWith: "#form-elements-list,.ezfc-group" }));

		// put elements into groups
		$("#form-elements-list .ezfc-form-element").each(function() {
			var group_id = $(this).find("[data-element-name='group_id']").val();

			if (!group_id || group_id < 1) return;

			var group_list = $(".ezfc-form-element[data-id='" + group_id + "'] > .ezfc-group");

			// check if group element exists
			if (!group_list || group_list.length < 1) return;

			$(this).appendTo(group_list);
		});

		// draggable elements (add elements)
		$(".ezfc-elements-add .ezfc-elements li").draggable({
			connectToSortable: "#form-elements-list,.ezfc-group",
			helper: "clone",
			start: function(ev, ui) {
				$(ui.helper[0]).attr("id", "ezfc-element-drag-placeholder");
			},
			stop: function(ev, ui) {
				set_form_elements_height();

				var $item = $(ui.helper[0]);
				var item_count = $("#form-elements-list li").length;
				var index = item_count - $item.index("#form-elements-list li");

				// not dropped
				if (index < 0) {
					$(ui.helper[0]).remove();
					return false;
				}

				// closest but exclude self first
				var $parent_group = $item.parent().closest(".ezfc-form-element-group");
				var group_id      = $parent_group.length ? $parent_group.data("id") : 0;

				//do_action
				do_action($(ui.helper[0]), { position: index, group_id: group_id });

				// hide first
				$("#ezfc-element-drag-placeholder").html("<i class='fa fa-cog fa-spin'></i>");
			}
		});

		// tooltips
		$(".ezfc-elements-show [data-ot]").each(function(i, el) {
			$(el).opentip($(el).data("ot"), {
				fixed: true,
				tipJoint: "bottom"
			});
		});

		// remove tinymce editors from html elements
		if (typeof tinyMCE !== "undefined" && typeof tinyMCE.execCommand === "function") {
			$(".ezfc-html").each(function() {
				tinyMCE.execCommand("mceRemoveEditor", false, $(this).attr("id"));
			});
		}

		// spinner
		$(".ezfc-spinner").spinner();
	}

	// restrict certain fields upon change
	function custom_trigger_change(element) {
		// calculation target / value field
		var calculate_wrapper = $(element).find(".ezfc-form-element-calculate-wrapper");

		$(calculate_wrapper).each(function(i, cw) {
			var selected_operator = $(cw).find(".ezfc-form-element-calculate-operator :selected").val();
			var selected_target   = $(cw).find(".ezfc-form-element-calculate-target");
			var selected_value    = $(cw).find(".ezfc-form-element-calculate-value");

			// if ceil/floor/round was selected, disable target element + value
			if (selected_operator == "floor" || selected_operator == "ceil" || selected_operator == "round" || selected_operator == "subtotal") {
				selected_target.attr("disabled", "disabled");
				selected_value.attr("disabled", "disabled");
			}
			else {
				selected_target.removeAttr("disabled");
				selected_value.removeAttr("disabled");

				if (selected_target.val() == 0) {
					selected_value.removeAttr("disabled");
				}
				else {
					selected_value.attr("disabled", "disabled");
				}
			}
		});

		// conditional target value
		var conditional_wrapper = $(element).find(".ezfc-form-element-conditional-wrapper");

		$(conditional_wrapper).each(function(i, cw) {
			var selected_action     = $(cw).find(".ezfc-form-element-conditional-action :selected").val();
			var target_value_object = $(cw).find(".ezfc-form-element-conditional-target-value");
			var redirect_wrapper        = $(cw).find(".ezfc-conditional-redirect-wrapper");

			// if 'set' was selected, enable target value field
			if (selected_action == "set") {
				target_value_object.removeAttr("disabled");
			}
			else {
				target_value_object.attr("disabled", "disabled");
			}

			// show form field
			if (selected_action == "redirect") {
				redirect_wrapper.removeClass("ezfc-hidden");
			}
			else {
				redirect_wrapper.addClass("ezfc-hidden");
			}
		});

		// add visual editor to html fields
		var html_id = $(element).find("textarea.ezfc-html").attr("id");

		if (typeof tinyMCE !== "undefined" && typeof tinyMCE.execCommand === "function") {
			tinyMCE.execCommand("mceAddEditor", false, html_id);
		}
	}

	/**
		forms
	**/
	// add form
	function form_add(data) {
		var html = "";
		html += "<li class='button ezfc-form' data-id='" + data.form.id + "' data-action='form_get' data-selectgroup='forms'>";
		html += "	<i class='fa fa-fw fa-list-alt'></i> ";
		html += 	data.form.id + " - ";
		html += "	<span class='ezfc-form-name'>" + data.form.name + "</span>";
		html += "</li>";

		$(".ezfc-forms-list").append(html);

		$(".ezfc-form.button-primary").removeClass("button-primary");
		$(".ezfc-form[data-id='" + data.form.id + "']").addClass("button-primary");

		form_show(data);
	}

	function form_clear() {
		$(".ezfc-form-element").remove();
	}

	function form_delete(id) {
		$(".ezfc-form-elements-actions, .ezfc-form-elements-container, .ezfc-form-options-wrapper").addClass("ezfc-hidden");
		$(".ezfc-form[data-id='" + id + "']").remove();
	}

	function form_file_delete(id) {
		$(".ezfc-form-file[data-id='" + id + "']").remove();
	}

	function form_preview(data) {
		$(".ezfc-form-preview").html(data);

		if (data.length < 1) return false;

		$("html, body").animate({
			scrollTop: $(".ezfc-form-preview").offset().top-50
		}, 1337);
	}

	// show single form
	function form_show(data) {
		form_changed = false;
		var out = [];

		if (data) {
			if (data.elements) {
				$.each(data.elements, function(i, element) {
					out.push(element_add(element));
				});
			}
			//out.push("<div class='clearfix'></div>");

			$(".ezfc-form-elements").html(out.join(""));

			$("#ezfc-form-save, #ezfc-form-delete, #ezfc-form-clear").data("id", data.form.id);
			$("#ezfc-shortcode-id").val("[ezfc id='" + data.form.id + "' /]");
			$("#ezfc-shortcode-name").val("[ezfc name='" + data.form.name + "' /]");
			$("#ezfc-form-name").val(ezfc_stripslashes(data.form.name).replace(/&apos;/g, "'"));

			// calculate fields
			fill_calculate_fields();

			// populate form option fields
			form_show_options(data.options);

			// set submission entries
			$("#ezfc-form-submissions-count").text(data.submissions_count);
		}

		$(".ezfc-form-submissions").addClass("ezfc-hidden");
		$(".ezfc-form-elements-actions, .ezfc-form-elements-container, .ezfc-form-options-wrapper").removeClass("ezfc-hidden");

		// scroll to form
		$(".ezfc-forms-list").animate({ scrollTop: $(".ezfc-forms-list")[0].scrollHeight }, "slow");

		elements_add_div     = $("#ezfc-elements-add");
		elements_add_div_top = elements_add_div.offset().top;

		init_ui();
		change_columns();
	}

	/**
		show form options
	**/
	function form_show_options(options) {
		$.each(options, function(i, v) {
			var option_row = "#ezfc-table-option-" + v.id;
			var target = "#opt-" + v.id;

			switch (v.type) {
    			case "border":
    				if (!v.value) {
    					v.value = {
    						color: "",
    						width: "",
    						style: "",
    						radius: ""
    					};
    				}

    				$(option_row + " .ezfc-element-border-color").val(v.value.color).trigger("change");
    				$(option_row + " .ezfc-element-border-width").val(v.value.width);
    				$(option_row + " .ezfc-element-border-style option[value='" + v.value.style + "']").attr("selected", "selected");
    				$(option_row + " .ezfc-element-border-radius").val(v.value.radius);

    				if (v.value.transparent) {
    					$(option_row + " .ezfc-element-border-transparent").attr("selected", "selected");
    				}
    			break;

    			case "colorpicker":
    				if (!v.value) {
    					v.value = {
    						color: "",
    						transparent: false
    					};
    				}

    				$(option_row + " .ezfc-element-colorpicker-input").val(v.value.color).trigger("change");
    				
    				if (v.value.transparent) {
    					$(option_row + " .ezfc-element-colorpicker-transparent").attr("selected", "selected");
    				}
    			break;

    			case "dimensions":
    				if (!v.value) {
    					v.value = {
    						value: "",
    						unit: ""
    					};
    				}

    				$(option_row + " input").val(v.value.value);
    				$(option_row + " select option[value='" + v.value.unit + "']").attr("selected", "selected");
    			break;

    			case "editor":
    				// visual editor
    				$("#editor_" + v.id + "_ifr").contents().find("body").html(nl2br(v.value));
    				// textarea
    				$("#editor_" + v.id).val(v.value);
    			break;

    			case "image":
    				$(option_row + " .ezfc-image-upload-hidden").val(v.value);
    				$(option_row + " img").attr("src", v.value);
    			break;

    			case "lang":
    			case "yesno":
    				$(target + " option").removeAttr("selected");
    				$(target + " option[value='" + v.value + "']").attr("selected", "selected");
    			break;   			

    			default:
    				$(target).val(v.value);
    			break;
    		}
		});
	}

	// show form submissions
	function form_show_submissions(submissions) {
		// no submissions
		if (!submissions) {
			submissions = { submissions: [] };
		}
		
		// update counter
		$(".ezfc-forms-list .button-primary .ezfc-submission-counter").text(submissions.submissions.length);

		form_changed = false;
		var out = "<ul>";

		$.each(submissions.submissions, function(i, submission) {
			var date    = ezfc_parse_date(submission.date);
			var addIcon = "";

			if (submission.payment_id == 1) {
				addIcon += " <i class='fa fa-fw fa-paypal' data-ot='PayPal used'></i>";

				if (submission.transaction_id.length>0) addIcon += " <i class='fa fa-fw fa-check' data-ot='Payment verified.'></i>";
				else addIcon += " <i class='fa fa-fw fa-times' data-ot='Payment denied or cancelled'></i>";
			}

			out += "<li class='ezfc-form-submission' data-id='" + submission.id + "'>";
			out += "	<div class='ezfc-form-submission-name'>";
			out += "		<i class='fa fa-fw fa-envelope'></i>" + addIcon + " ID: " + submission.id + " - " + date.toUTCString();
			out += "		<button class='ezfc-form-submission-delete button' data-action='form_submission_delete' data-id='" + submission.id + "'><i class='fa fa-times'></i></button>";
			out += "	</div>";

			// additional data (toggle)
			out += "	<div class='ezfc-form-submission-data hidden'>";

			// paypal info
			if (submission.payment_id == 1) {
				out += "<div>";
				out += "	<p><strong>Paid with Paypal</strong></p>";
				out += "	<p>Transaction-ID: " + submission.transaction_id;
				out += "</div>";
			}

			out += submission.content;

			// files
			if (submissions.files[submission.ref_id]) {
				out += "	<div class='ezfc-form-files'>";
				out += "		<p>Files</p>";

				$.each(submissions.files[submission.ref_id], function(fi, file) {
					var filename = file.url.split("/").slice(-1);

					out += "	<ul>";
					out += "		<li class='ezfc-form-file' data-id='" + file.id + "'>";
					out += "			<a href='" + file.url + "'>" + filename + "</a>";
					out += "			<button class='ezfc-form-file-delete button' data-action='form_file_delete' data-id='" + file.id + "'><i class='fa fa-times'></i></button>";
					out += "	</li>";
					out += "	</ul>";
				});

				out += "	</div>";
			}

			out += "</li>";
		});

		out += "</ul>";

		$(".ezfc-form-submissions").removeClass("ezfc-hidden").html(out);
		$(".ezfc-form-elements-container, .ezfc-form-options-wrapper").addClass("ezfc-hidden");

		// meh
		$(".ezfc-form-submission-data h2").remove();
	}

	// add element
	function element_add(element) {
		// form element data
		var data_el = $.parseJSON(element.data);

		if (!data_el) {
			var ret_error = "";
			ret_error += "<li class='ezfc-form-element ezfc-form-element-error ezfc-col-6'>";
			ret_error += "    <div class='ezfc-form-element-name'>Corrupt element";
			ret_error += "        <button class='ezfc-form-element-delete button' data-action='form_element_delete' data-id='" + element.id + "'><i class='fa fa-times'></i></button>";
			ret_error += "    </div>";
			ret_error += "    <div class='container-fluid ezfc-form-element-data ezfc-form-element-input hidden'>";

			if (typeof element === "object") {
				ret_error += "        <p>" + JSON.stringify(element) + "</p>";
			}
			
			ret_error += "    </div>";
			ret_error += "</li>";

			return ret_error;
		}

		var columns             = 6;
		var element_name_header = "";
		var req_char            = "";
		var html                = [];
		var is_extension        = false;
		var extension_id        = "";

		// data wrapper for inbuilt / extension elements
		var data_element_wrapper;

		if (element.e_id == 0) {
			is_extension = true;
			extension_id = data_el.extension;

			// check if extension exists
			var extension_element = $(".ezfc-element[data-id='" + extension_id + "']");
			if (extension_element.length < 1) {
				// error message
				return;
			}

			// get element data
			var extension_element_data = extension_element.data("extension_data");

			data_element_wrapper = {
				icon: extension_element_data.icon,
				name: extension_element_data.name,
				type: extension_element_data.type
			};

			// add extension field
			html.push("<input type='hidden' value='" + extension_element_data.id + "' name='elements[" + element.id + "][extension]' />");
		}
		else {
			data_element_wrapper = ezfc.elements[element.e_id];
		}

		html.push("<input type='hidden' class='ezfc-form-element-e_id' value='" + element.e_id + "' name='elements[" + element.id + "][e_id]' />");

		var element_prefix = "";
		var element_suffix = "";

		$.each(data_el, function(name, value) {
			// skip id
			if (name == "e_id" || name == "preselect" || name == "extension") return;

			var input_id   = "elements-" + name + "-" + element.id;
			var input_raw  = "elements[" + element.id + "]";
			var input_name = "elements[" + element.id + "][" + name + "]";

			var input = "";

			// replace &apos;
			value = ezfc_sanitize_value(value);

			input += "<input type='text' value='" + value + "' name='" + input_name + "' data-element-name='" + name + "' id='" + input_id + "' />";

			var el_description = ezfc_get_element_option_description(name);

			switch (name) {
				case "columns":
					columns = value;
					html.push("<input name='" + input_name + "' id='" + input_id + "' data-element-name='" + name + "' type='hidden' value='" + value + "' />");
					// skip because we don't want this field to be displayed
					return;
				break;

				case "group_id":
					html.push("<input class='ezfc-form-group-id' name='" + input_name + "' id='" + input_id + "' data-element-name='" + name + "' type='hidden' value='" + value + "' />");
					// skip because we don't want this field to be displayed
					return;
				break;

				case "name":
					var data_class = (data_element_wrapper.type=="group" || data_element_wrapper.type=="html") ? "element-label-listener" : "";

					input = "<input class='" + data_class + "' type='text' value='" + value + "' name='" + input_name + "' data-element-name='" + name + "' id='" + input_id + "' />";
					element_name_header = value;
				break;

				case "label":
					var data_class = (data_element_wrapper.type!="group" && data_element_wrapper.type!="html") ? "element-label-listener" : "";

					input = "<input class='" + data_class + "' type='text' value='" + value + "' name='" + input_name + "' data-element-name='" + name + "' id='" + input_id + "' />";
					element_name_header = value;
				break;

				case "html":
					// wp tinymce hack (next version)
					input = '<div class="wp-editor-tools hide-if-no-js"><div class="wp-media-buttons">';
					input += '<a href="#" id="insert-media-button" class="button insert-media add_media" data-editor="' + input_id + '" title="Add Media"><span class="wp-media-buttons-icon"></span> Add Media</a>';
					input += "<button class='button ezfc-html-tinymce-toggle' data-target='" + input_id + "'>Toggle view</button>";
					input += '</div></div>';

					input += "<textarea class='ezfc-html' name='" + input_name + "' id='" + input_id + "'>" + ezfc_stripslashes(value) + "</textarea>";
				break;

				case "required":
					req_char = value==1 ? "*" : "";

					input = "<select class='ezfc-form-element-required-toggle' name='" + input_name + "' id='" + input_id + "' data-element-name='" + name + "'>";
					input += "	<option value='0'>" + ezfc_vars.yes_no.no + "</option>";
					input += "	<option value='1'" + (value==1 ? "selected" : "") + ">" + ezfc_vars.yes_no.yes + "</option>";
					input += "</select>";
				break;

				case "add_line":
				case "calculate_enabled":
				case "calculate_before":
				case "calculate_when_hidden":
				case "double_check":
				case "inline":
				case "is_currency":
				case "overwrite_price":
				case "show_in_email":
				case "showWeek":
				case "slider":
				case "spinner":
				case "use_address":
				case "text_only":
					input = "<select class='ezfc-form-element-" + name + "' name='" + input_name + "' id='" + input_id + "' data-element-name='" + name + "'>";
					input += "	<option value='0'>" + ezfc_vars.yes_no.no + "</option>";
					input += "	<option value='1'" + (value==1 ? "selected" : "") + ">" + ezfc_vars.yes_no.yes + "</option>";
					input += "</select>";
				break;

				case "hidden":
					input = "<select class='ezfc-form-element-" + name + "' name='" + input_name + "' id='" + input_id + "' data-element-name='" + name + "'>";
					input += "	<option value='0'>" + ezfc_vars.yes_no.no + "</option>";
					input += "	<option value='1'" + (value==1 ? "selected" : "") + ">Yes</option>";
					input += "	<option value='2'" + (value==2 ? "selected" : "") + ">Conditional hidden</option>";
					input += "</select>";
				break;

				case "steps_slider":
				case "steps_spinner":
					input = "<input class='ezfc-spinner' type='text' value='" + value + "' name='" + input_name + "' data-element-name='" + name + "' id='" + input_id + "' />";
				break;

				case "multiple":
					input = "<select class='ezfc-form-element-multiple' name='" + input_name + "' id='" + input_id + "' data-element-name='" + name + "'>";
					input += "	<option value='0'>" + ezfc_vars.yes_no.no + "</option>";
					input += "	<option value='1'" + (value==1 ? "selected" : "") + ">" + ezfc_vars.yes_no.yes + "</option>";
					input += "</select>";
				break;

				// used for radio-buttons, checkboxes
				case "options":
					input = "<button class='button ezfc-form-element-option-add' data-target='.ezfc-form-element-option' data-element_id='" + element.id + "'>Add option</button></div>";
					
					input += "<div class='col-xs-3'>Value</div>";
					input += "<div class='col-xs-3'>Text</div>";
					input += "<div class='col-xs-3'>Image</div>";
					input += "<div class='col-xs-3'>";
					input += "	<abbr title='Preselect values'>Sel</abbr>&nbsp;";
					input += "	<abbr title='Disabled'>Dis</abbr>&nbsp;";
					input += "</div>";

					input += "<div class='ezfc-form-element-move-container'>";

					var n              = 0,
						preselect      = (data_el.preselect || data_el.preselect == 0) ? data_el.preselect : "",
						preselect_html = "",
						preselect_type = "",
						preselect_val  = "";

					switch (data_element_wrapper.type) {
						case "checkbox":
							preselect_name = input_raw + "[preselect]";
							preselect_type = "checkbox";
							preselect_val  = [];

							if (preselect.length > 1) {
								preselect_val  = $.map(preselect.split(","), function(v) {
									return parseInt(v);
								});
							}
						break;

						default:
							preselect_name = input_raw + "[preselect]";
							preselect_type = "radio";
							preselect_val  = parseInt(preselect);
						break;
					}

					$.each(value, function(opt_val, opt_text) {
						input += "<div class='ezfc-form-element-option' data-element_id='" + element.id + "' data-row='" + n + "'>";
						// value
						input += "	<div class='col-xs-3'><input class='ezfc-form-element-option-value small' name='" + input_name + "[" + n + "][value]' value='" + opt_text.value + "' type='text' /></div>";
						// text
						input += "	<div class='col-xs-3'><input class='ezfc-form-element-option-text' name='" + input_name + "[" + n + "][text]' type='text' value='" + opt_text.text + "' /></div>";

						// image wrapper
						input += "	<div class='col-xs-3'>";
						// image
						if (data_element_wrapper.type == "radio" || data_element_wrapper.type == "checkbox") {
							var tmp_img_src = "";
							if (opt_text.image) tmp_img_src = opt_text.image;

							input += "	<input class='ezfc-form-element-option-image' name='" + input_name + "[" + n + "][image]' type='hidden' value='" + tmp_img_src + "' />";

							input += "	<img class='ezfc-option-image-placeholder' src='" + tmp_img_src + "' />";
							input += "	<button class='button ezfc-option-image-button' data-ot='Choose image'><i class='fa fa-image'></i></button>";
							input += "	<button class='button ezfc-option-image-remove' data-ot='Remove image'><i class='fa fa-times'></i></button>";
						}
						else if (data_element_wrapper.type == "dropdown") {
							input += ezfc_vars.unavailable_element;
						}

						input += "	</div>";

						// preselect
						preselect_html = "";

						// checkbox element can have multiple preselect values
						if (data_element_wrapper.type == "checkbox") {
							preselect_html = $.inArray(n, preselect_val)!=-1 ? "checked='checked'" : "";
						}
						else {
							preselect_html = preselect_val == n ? "checked='checked'" : "";
						}

						// disabled
						disabled_html = opt_text.disabled ? "checked='checked'" : "";

						input += "	<div class='col-xs-3'>";
						// preselect
						input += "		<input class='ezfc-form-element-option-" + preselect_type + "' name='" + preselect_name + "' type='" + preselect_type + "' data-element_id='" + element.id + "' value='" + n + "' " + preselect_html + " />&nbsp;";
						// disabled
						input += "		<input class='ezfc-form-element-option-disabled' name='" + input_name + "[" + n + "][disabled]' type='checkbox' data-element_id='" + element.id + "' value='1' " + disabled_html + " />&nbsp;";
						// move up
						input += "		<button class='button ezfc-form-element-move ezfc-form-element-move-up' data-target='.ezfc-form-element-option' data-element_id='" + element.id + "'><i class='fa fa-sort-up'></i></button>";
						// move down
						input += "		<button class='button ezfc-form-element-move ezfc-form-element-move-down' data-target='.ezfc-form-element-option' data-element_id='" + element.id + "'><i class='fa fa-sort-down'></i></button>";
						// remove
						input += "		<button class='button ezfc-form-element-option-delete' data-target='.ezfc-form-element-option' data-element_id='" + element.id + "' data-target_row='" + n + "'><i class='fa fa-times'></i></button>";
						input += "	</div>";

						input += "	<div class='clearfix'></div>";
						input += "</div>";
						
						n++;
					});

					input += "</div>"; // move container

					if (preselect_type == "checkbox") {
						input += "<input class='ezfc-form-option-preselect' type='hidden' name='" + input_raw + "[preselect]' data-element_id='" + element.id + "' value='" + preselect + "' />";
					}
					else if (preselect_type == "radio") {
						preselect_html = preselect==-1 ? "checked='checked'" : "";

						input += "<div class='col-xs-9'>No preselected value</div>";
						input += "<div class='col-xs-3'><input class='ezfc-form-element-option-radio' name='" + input_raw + "[preselect]' type='radio' data-element_id='" + element.id + "' value='-1' " + preselect_html + " /></div>";
					}

					input += "<div>";
				break;

				// calculate
				case "calculate":
					input = "<button class='button ezfc-form-element-option-add' data-target='.ezfc-form-element-calculate-wrapper' data-element_id='" + element.id + "'>Add calculation field</button>&nbsp;";
					input += "<button class='ezfc-form-calculate-refresh button' data-ot='Refresh fields'><span class='fa fa-refresh'></span></button>";
					input += "</div>";

					input += "<div class='col-xs-2'><span class='fa fa-question-circle' data-ot='Operator'></span> Operator</div>";
					input += "<div class='col-xs-5'>" + get_tip("Target element to calculate with") + " Target element</div>";
					input += "<div class='col-xs-3'><span class='fa fa-question-circle' data-ot='Only enabled when no target element is selected.'></span> Value</div>";
					input += "<div class='col-xs-2'></div>";
					input += "<div class='clearfix'></div>";

					input += "<div class='ezfc-form-element-move-container'>";

					// calculation fields
					var n = 0;
					$.each(value, function(calc_key, calc_text) {
						input += "<div class='ezfc-form-element-calculate-wrapper' data-element_id='" + element.id + "' data-row='" + n + "'>";
						// operator
						input += "	<div class='col-xs-2'>";
						input += "		<select class='ezfc-form-element-calculate-operator' name='" + input_name + "[" + n + "][operator]' data-element-name='" + name + "'>";

						// iterate through operators
						$.each(ezfc_operators, function(nn, operator) {
							var selected = "";
							if (calc_text.operator == operator.value) selected = "selected='selected'";

							input += "<option value='" + operator.value + "' " + selected + ">" + operator.text + "</option>";
						});

						input += "		</select>";
						input += "	</div>";

						// other elements (will be filled in from function fill_calculate_fields())
						input += "	<div class='col-xs-5'>";
						input += "		<select class='ezfc-form-element-calculate-target fill-elements' name='" + input_name + "[" + n + "][target]' id='" + input_id + "-target' data-element-name='" + name + "' data-target='" + calc_text.target + "'>";
						input += "		</select>";
						input += "	</div>";

						// value when no element was selected
						if (!calc_text.value) calc_text.value = "";
						input += "	<div class='col-xs-3'>";
						input += "		<input class='ezfc-form-element-calculate-value' name='" + input_name + "[" + n + "][value]' id='" + input_id + "-value' data-element-name='" + name + "' value='" + calc_text.value + "' type='text' />";
						input += "	</div>";

						// actions
						input += "	<div class='col-xs-2'>";
						// move up
						input += "		<button class='button ezfc-form-element-move ezfc-form-element-move-up' data-target='.ezfc-form-element-calculate-wrapper' data-element_id='" + element.id + "'><i class='fa fa-sort-up'></i></button>";
						// move down
						input += "		<button class='button ezfc-form-element-move ezfc-form-element-move-down' data-target='.ezfc-form-element-calculate-wrapper' data-element_id='" + element.id + "'><i class='fa fa-sort-down'></i></button>";
						// remove
						input += "		<button class='button ezfc-form-element-option-delete' data-target='.ezfc-form-element-calculate-wrapper' data-element_id='" + element.id + "'><i class='fa fa-times'></i></button>";
						input += "	</div>";

						input += "	<div class='clearfix'></div>";
						input += "</div>";

						n++;
					});

					input += "</div>"; // move container
					input += "<div>";
				break;

				// conditional fields
				case "conditional":
					input = "<button class='button ezfc-form-element-option-add' data-target='.ezfc-form-element-conditional-wrapper' data-element_id='" + element.id + "'>Add conditional field</button>&nbsp;";
					input += "<button class='ezfc-form-calculate-refresh button' data-ot='Refresh fields'><span class='fa fa-refresh'></span></button>";
					input += "</div>";

					input += "<div class='col-xs-2'>" + get_tip("This action will be performed") + " Action</div>";
					input += "<div class='col-xs-3'>" + get_tip("Target element to show/hide") + " Target element</div>";
					input += "<div class='col-xs-1'>" + get_tip("Set target element value to this value") + " TV</div>";
					input += "<div class='col-xs-2'>" + get_tip("Conditional operator: when the value of this element equals/is less than/is greater/in between than the conditional value. When using \"in between\", use a colon (:) as separator.") + " CO</div>";
					input += "<div class='col-xs-2'>" + get_tip("Conditional value") + " Value</div>";
					input += "<div class='col-xs-2'>" + get_tip("Conditional toggle: when this field is checked, the opposite action will not be executed when this condition is triggered") + " CT</div>";
					input += "<div class='clearfix'></div>";

					var n = 0;
					$.each(value, function(calc_key, calc_text) {
						input += "<div class='ezfc-form-element-conditional-wrapper' data-element_id='" + element.id + "' data-row='" + n + "'>";

						// show or hide
						input += "	<div class='col-xs-2'>";
						input += "		<select class='ezfc-form-element-conditional-action' name='" + input_name + "[" + n + "][action]' id='" + input_id + "-action' data-element-name='" + name + "'>";

						// iterate through conditional operators
						$.each(ezfc_cond_actions, function(nn, operator) {
							var selected = "";
							if (calc_text.action == operator.value) selected = "selected='selected'";

							input += "<option value='" + operator.value + "' " + selected + ">" + operator.text + "</option>";
						});

						input += "		</select>";
						input += "	</div>";

						// field to show
						input += "	<div class='col-xs-3'>";
						input += "		<select class='ezfc-form-element-conditional-target fill-elements' name='" + input_name + "[" + n + "][target]' data-element-name='" + name + "' data-target='" + calc_text.target + "' data-show_all='true'>";
						input += "		</select>";
						input += "	</div>";

						// target value
						if (!calc_text.target_value) calc_text.target_value = "";
						input += "	<div class='col-xs-1'>";
						input += "		<input class='ezfc-form-element-conditional-target-value' name='" + input_name + "[" + n + "][target_value]' id='" + input_id + "-target-value' data-element-name='" + name + "' value='" + calc_text.target_value + "' type='text' />";
						input += "	</div>";

						// conditional operator
						input += "	<div class='col-xs-2'>";
						input += "		<select class='ezfc-form-element-conditional-operator' name='" + input_name + "[" + n + "][operator]' id='" + input_id + "-target' data-element-name='" + name + "'>";

						// iterate through conditional operators
						$.each(ezfc_cond_operators, function(nn, operator) {
							var selected = "";
							if (calc_text.operator == operator.value) selected = "selected='selected'";

							input += "<option value='" + operator.value + "' " + selected + ">" + operator.text + "</option>";
						});

						input += "		</select>";
						input += "	</div>";

						// conditional value
						if (!calc_text.value) calc_text.value = "";
						input += "	<div class='col-xs-2'>";
						input += "		<input class='ezfc-form-element-conditional-value' name='" + input_name + "[" + n + "][value]' id='" + input_id + "-value' data-element-name='" + name + "' value='" + calc_text.value + "' type='text' />";
						input += "	</div>";

						// conditional toggle
						var cond_toggle = (calc_text.notoggle && calc_text.notoggle=="1") ? "checked='checked'" : "";
						input += "	<div class='col-xs-2'>";
						input += "		<input class='ezfc-form-element-conditional-notoggle' name='" + input_name + "[" + n + "][notoggle]' id='" + input_id + "-notoggle' data-element-name='" + name + "' value='1' type='checkbox' " + cond_toggle + " />";

						// move up
						input += "		<button class='button ezfc-form-element-move ezfc-form-element-move-up' data-target='.ezfc-form-element-conditional-wrapper' data-element_id='" + element.id + "'><i class='fa fa-sort-up'></i></button>";
						// move down
						input += "		<button class='button ezfc-form-element-move ezfc-form-element-move-down' data-target='.ezfc-form-element-conditional-wrapper' data-element_id='" + element.id + "'><i class='fa fa-sort-down'></i></button>";
						// remove
						input += "		<button class='button ezfc-form-element-option-delete' data-target='.ezfc-form-element-conditional-wrapper' data-element_id='" + element.id + "'><i class='fa fa-times'></i></button>";
						input += "  </div>";

						// redirect
						input += "	<div class='col-xs-4 ezfc-hidden ezfc-conditional-redirect-wrapper'>URL: ";
						input += "		<input class='ezfc-form-element-conditional-redirect' name='" + input_name + "[" + n + "][redirect]' id='" + input_id + "-redirect' data-element-name='" + name + "' value='" + (calc_text.redirect ? calc_text.redirect : "") + "' type='text' />";
						input += "  </div>";

						input += "	<div class='clearfix'></div>";
						input += "</div>";

						n++;
					});

					input += "<div>";
				break;

				// discount
				case "discount":
					input = "<button class='button ezfc-form-element-option-add' data-target='.ezfc-form-element-discount-wrapper' data-element_id='" + element.id + "'>Add discount field</button>&nbsp;";
					input += "<button class='ezfc-form-calculate-refresh button' data-ot='Refresh fields'><span class='fa fa-refresh'></span></button>";
					input += "</div>";

					input += "<div class='col-xs-3'>" + get_tip("Minimum value for this discount condition (leave blank for negative infinity)") + " Value min</div>";
					input += "<div class='col-xs-3'>" + get_tip("Maximum value for this discount condition (leave blank for positive infinity)") + " Value max</div>";
					input += "<div class='col-xs-2'>" + get_tip("Discount operator for the following discount value") + " Op</div>";
					input += "<div class='col-xs-3'>" + get_tip("Discount value") + " Discount value</div>";
					input += "<div class='col-xs-1'>Remove</div>";
					input += "<div class='clearfix'></div>";

					// discount fields
					var n = 0;
					$.each(value, function(discount_key, discount_text) {
						input += "<div class='ezfc-form-element-discount-wrapper' data-element_id='" + element.id + "' data-row='" + n + "'>";

						// range_min
						input += "	<div class='col-xs-3'>";
						input += "		<input class='ezfc-form-element-discount-range_min' name='" + input_name + "[" + n + "][range_min]' id='" + input_id + "-value' data-element-name='" + name + "' value='" + discount_text.range_min + "' type='text' />";
						input += "	</div>";

						// range_max
						input += "	<div class='col-xs-3'>";
						input += "		<input class='ezfc-form-element-discount-range_max' name='" + input_name + "[" + n + "][range_max]' id='" + input_id + "-value' data-element-name='" + name + "' value='" + discount_text.range_max + "' type='text' />";
						input += "	</div>";

						// operator
						input += "	<div class='col-xs-2'>";
						input += "		<select class='ezfc-form-element-discount-operator' name='" + input_name + "[" + n + "][operator]' data-element-name='" + name + "'>";

						// iterate through operators
						$.each(ezfc_operators_discount, function(nn, operator) {
							var selected = "";
							if (discount_text.operator == operator.value) selected = "selected='selected'";

							input += "<option value='" + operator.value + "' " + selected + ">" + operator.text + "</option>";
						});

						input += "		</select>";
						input += "	</div>";

						// other elements (will be filled in from function fill_calculate_fields())
						input += "	<div class='col-xs-3'>";
						input += "		<input class='ezfc-form-element-discount-discount_value' name='" + input_name + "[" + n + "][discount_value]' id='" + input_id + "-value' data-element-name='" + name + "' value='" + discount_text.discount_value + "' type='text' />";
						input += "	</div>";

						// remove
						input += "	<div class='col-xs-1'>";
						input += "		<button class='button ezfc-form-element-option-delete' data-target='.ezfc-form-element-discount-wrapper' data-element_id='" + element.id + "'><i class='fa fa-times'></i></button>";
						input += "	</div>";

						input += "	<div class='clearfix'></div>";
						input += "</div>";
						n++;
					});

					input += "<div>";
				break;

				case "set":
					input = "<button class='button ezfc-form-element-option-add' data-target='.ezfc-form-element-set-wrapper' data-element_id='" + element.id + "'>Add element to set</button>&nbsp;";
					input += "<button class='ezfc-form-calculate-refresh button' data-ot='Refresh fields'><span class='fa fa-refresh'></span></button>";
					input += "</div>";

					input += "<div class='col-xs-12'>Element / Remove</div>";
					input += "<div class='clearfix'></div>";

					// set fields
					var n = 0;
					$.each(value, function(set_key, set_text) {
						input += "<div class='ezfc-form-element-set-wrapper' data-element_id='" + element.id + "' data-row='" + n + "'>";

						// field to show
						input += "	<div class='ezfc-form-element-set-element'>";
						input += "		<select class='ezfc-form-element-set-target fill-elements' name='" + input_name + "[" + n + "][target]' data-element-name='" + name + "' data-target='" + set_text.target + "'>";
						input += "		</select>";

						// remove
						input += "		<button class='button ezfc-form-element-option-delete' data-target='.ezfc-form-element-set-wrapper' data-element_id='" + element.id + "'><i class='fa fa-times'></i></button>";
						input += "	</div>";
						input += "</div>";
						n++;
					});

					input += "<div>";
				break;
				case "set_operator":
					input = "<select class='ezfc-form-element-" + name + "' name='" + input_name + "' id='" + input_id + "' data-element-name='" + name + "'>";

					// iterate through operators
					$.each(ezfc_set_operators, function(nn, operator) {
						var selected = "";
						if (value == operator.value) selected = "selected='selected'";

						input += "<option value='" + operator.value + "' " + selected + ">" + operator.text + "</option>";
					});

					input += "</select>";
				break;

				// image
				case "image":
					input += "<button class='button ezfc-image-upload'>Choose image</button>";
					input += "<br><img src='" + value + "' class='ezfc-image-preview' />";
				break;
				
				case "slidersteps":
					input = "<input class='ezfc-spinner' name='" + input_name + "' value='" + value + "' />";
				break;

				case "icon":
					input += "<i class='fa " + value + "' id='" + input_id + "-icon' data-previewicon></i>";
					input += "<button class='ezfc-icon-button' data-target='" + input_id + "'>Choose icon</button>";
				break;

				// wordpress posts
				case "post_id":
					input = "<select class='ezfc-form-element-" + name + "' name='" + input_name + "' id='" + input_id + "' data-element-name='" + name + "'>";

					// iterate through operators
					$.each(ezfc_wp_posts, function(post_id, post) {
						var selected = "";
						if (value == post.id) selected = "selected='selected'";

						input += "<option value='" + post.id + "' " + selected + ">" + post.title + "</option>";
					});

					input += "</select>";
				break;

				// custom calculation
				case "custom_calculation":
					input = "<textarea class='ezfc-custom-calculation' name='" + input_name + "' id='" + input_id + "'>" + ezfc_stripslashes(value) + "</textarea>";
					input += "<button class='ezfc-open-function-dialog'>Functions</button>";
				break;
			}

			html.push("<div class='row'>");
			html.push("	<div class='col-xs-4'>");

			if (el_description.length > 0) {
				html.push("		<span class='fa fa-question-circle' data-ot='" + el_description + "'></span> &nbsp;");
			}

			html.push("		<label for='" + input_name + "'>" + name.capitalize() + "</label>");
			html.push("	</div>");
			html.push("	<div class='col-xs-8'>");
			html.push(input);
			html.push("	</div>");
			html.push("</div>");

			//html += "<div class='clearfix'></div>";
		});

		var out = element_prefix;

		// element label
		var element_label = " - <span class='element-label'>" + element_name_header + "</span>";

		out += "<li class='ezfc-form-element ezfc-cat-" + data_element_wrapper.category + " ezfc-form-element-" + data_element_wrapper.type + " ezfc-col-" + columns + "' data-columns='" + columns + "' data-id='" + element.id + "'>";
		out += "	<div class='ezfc-form-element-name'>";
		
		// group buttons
		if (data_element_wrapper.type == "group") {
			out += "	<button class='ezfc-form-element-action ezfc-form-element-group-toggle button'><i class='fa fa-toggle-up'></i></button>";
		}

		// column buttons
		out += "		<button class='ezfc-form-element-action ezfc-form-element-column-left button'><i class='fa fa-toggle-left'></i></button>";
		out += "		<button class='ezfc-form-element-action ezfc-form-element-column-right button'><i class='fa fa-toggle-right'></i></button>";

		out += "        <span class='ezfc-form-element-id'>ID: " + element.id + "</span>";
		out += "		<span class='fa fa-fw " + data_element_wrapper.icon + "'></span>";
		out += "		<span class='ezfc-form-element-required-char'>" + req_char + "</span> ";
		out += "		<span class='ezfc-form-element-type'>" + data_element_wrapper.name + "</span> " + element_label;

		// duplicate element button
		if (data_element_wrapper.type != "group") {
			out += "		<button class='ezfc-form-element-duplicate button' data-action='form_element_duplicate' data-id='" + element.id + "'><i class='fa fa-files-o' data-ot='Duplicate element'></i></button>";
		}

		// delete element button
		out += "		<button class='ezfc-form-element-delete button' data-action='form_element_delete' data-id='" + element.id + "'><i class='fa fa-times'></i></button>";
		out += "		</div>";
		out += "	<div class='container-fluid ezfc-form-element-data ezfc-form-element-" + data_element_wrapper.name.replace(" ", "-").toLowerCase() + " hidden'>" + html.join("") + "</div>";

		// group suffix
		if (data_element_wrapper.type == "group") {
			out += "<ul class='ezfc-group'></ul>";
		}

		out += "</li>";

		out += element_suffix;

		return out;
	}

	function fill_calculate_fields(show_all) {
		var elements = $(".ezfc-form-element-data");
		var elements_filtered = elements.not(".ezfc-form-element-email, .ezfc-form-element-date, .ezfc-form-element-image, .ezfc-form-element-line, .ezfc-form-element-date, .ezfc-form-element-html, .ezfc-form-element-recaptcha, .ezfc-form-element-file-upload, .ezfc-form-element-group");

		var elements_html = "<option value='0'> </option>";
		$(elements).each(function(ie, element) {
			var $el_parent = $(element).closest(".ezfc-form-element");
			var el_id      = $el_parent.data("id");

			var name_selector = "input[data-element-name='name']";
			var type_selector = ".ezfc-form-element-type";

			if ($el_parent.hasClass("ezfc-form-element-group")) {
				name_selector = "> .ezfc-form-element-data " + name_selector;
				type_selector = "> .ezfc-form-element-name " + type_selector;
			}

			var name = $el_parent.find(name_selector).val();
			var type = $el_parent.find(type_selector).text();

			elements_html += "<option value='" + el_id + "'>" + name + " (" + type + ")</option>";
		});

		var elements_filtered_html = "<option value='0'> </option>";
		$(elements_filtered).each(function(ie, element) {
			var $el_parent = $(element).closest(".ezfc-form-element");
			var el_id      = $el_parent.data("id");

			var name_selector = "input[data-element-name='name']";
			var type_selector = ".ezfc-form-element-type";

			var name = $el_parent.find(name_selector).val();
			var type = $el_parent.find(type_selector).text();

			elements_filtered_html += "<option value='" + el_id + "'>" + name + " (" + type + ")</option>";
		});

		$(".fill-elements").each(function(i, calculate_element) {
			var selected = $(this).find(":selected").val() || $(this).data("target");
			var show_all = $(this).data("show_all") ? true : false;

			var is_calculation = $(this).hasClass("ezfc-form-element-calculate-target");
			var is_conditional = $(this).hasClass("ezfc-form-element-conditional-target");

			// skip elements which cannot be calculated with
			var elements_to_insert = show_all ? elements_html : elements_filtered_html;

			// add submit button to conditionals
			if (is_conditional) {
				elements_to_insert += "<option value='submit_button'>" + ezfc_vars.submit_button + "</option>";
			}

			$(calculate_element).html(elements_to_insert);

			var el_parent = $(calculate_element).parent();

			// calculate
			if (is_calculation) {
				var operator = $(this).closest(".ezfc-form-element-calculate-wrapper").find(".ezfc-form-element-calculate-operator");

				el_parent.parent().find(".ezfc-form-element-calculate-operator option[value='" + operator + "']").prop("selected", "selected");
				el_parent.parent().find(".ezfc-form-element-calculate-target option[value='" + selected + "']").prop("selected", "selected");
			}
			// conditional
			else if (is_conditional) {
				el_parent.find(".ezfc-form-element-conditional-action option[value='" + selected + "']").prop("selected", "selected");
				el_parent.find(".ezfc-form-element-conditional-target option[value='" + selected + "']").prop("selected", "selected");
			}
			// set
			else if ($(this).hasClass("ezfc-form-element-set-target")) {
				el_parent.find(".ezfc-form-element-set-target option[value='" + selected + "']").prop("selected", "selected");
			}
		});
	}

	/**
		ajax
	**/
	function do_action(el, settings) {
		$(".ezfc-loading").fadeIn("fast");

		var action = $(el).data("action");
		var f_id   = $(".ezfc-forms-list .button-primary").data("id");
		var id     = $(el).data("id");
		var data   = "action=" + action;

		var el_disabled_list;

		switch (action) {
			case "form_add":
				id = $("#ezfc-form-template-id option:selected").val();
			break;

			case "form_duplicate":
			case "form_preview":
				form_clear(id);
			break;

			case "form_element_add":
				if (!f_id) return false;
				var e_id = id;

				// check if element is an extension
				if ($(el).data("extension") != 0) {
					data += "&extension=1";
				}

				// custom position from dropped element
				if (settings) {
					for (key in settings) {
						data += "&element_settings[" + key + "]=" + settings[key];
					}
				}
				
				data += "&e_id=" + e_id + "&f_id=" + f_id;
			break;

			case "form_clear":
			case "form_delete":
			case "form_delete_submissions":
			case "form_submission_delete":
			case "form_template_delete":
			case "form_file_delete":
				if (action == "form_template_delete") {
					id = $("#ezfc-form-template-id option:selected").val();

					if (id == 0) {
						$(".ezfc-loading").hide();
						return false;
					}
				} 

				if (!confirm(ezfc_vars.delete_element)) {
					$(".ezfc-loading").hide();
					return false;
				}
			break;

			case "form_element_delete":
				var $el_parent = $(el).closest(".ezfc-form-element");

				// check if group
				if ($el_parent.hasClass("ezfc-form-element-group")) {
					// put together child element ids
					var child_element_ids = [];
					
					$el_parent.find(".ezfc-form-element").each(function() {
						child_element_ids.push($(this).data("id"));
					});

					data += "&child_element_ids=" + child_element_ids.join(",");
				}
				
				if (!confirm(ezfc_vars.delete_element)) {
					$(".ezfc-loading").hide();
					return false;
				}
			break;

			case "form_show":
				$(".ezfc-loading").hide();
				form_show(null);
				return false;
			break;

			// import dialog
			case "form_show_import":
				$(".ezfc-loading").hide();
				$(".ezfc-import-dialog").dialog("open");
				$("#form-import-data").val("");
				return false;
			break;

			// import form data
			case "form_import_data":
				data += "&import_data=" + encodeURIComponent($("#form-import-data").val().replace(/'/g, "&apos;"));
			break;

			case "form_save":
			case "form_save_post":
			case "form_preview":
				tinyMCE.triggerSave();

				// temporarily remove disabled fields
				el_disabled_list = $("#form-elements [disabled='disabled']");
				el_disabled_list.removeAttr("disabled");

				// concatenate preselect checkboxes
				$(".ezfc-form-element-checkbox").each(function() {
					var preselect = [];
					$(this).find(".ezfc-form-element-option-checkbox").each(function(i, checkbox) {
						if ($(checkbox).is(":checked")) {
							preselect.push($(checkbox).val());
						}
					});

					$(this).find(".ezfc-form-option-preselect").val(preselect.join(","));
				});

				var data_elements = encodeURIComponent(JSON.stringify($("#form-elements").serializeArray()));
				var data_options  = encodeURIComponent(JSON.stringify($("#form-options").serializeArray()));

				var form_name = encodeURIComponent($("#ezfc-form-name").val());
				data += "&elements=" + data_elements + "&options=" + data_options + "&ezfc-form-name=" + form_name;

				if (action == "form_save_post") id = f_id;
			break;

			case "form_show_options":
				$(".ezfc-loading").hide();
				$(".ezfc-options-dialog").dialog("open");
				return false;
			break;

			case "form_update_options":
				tinyMCE.triggerSave();
				
				var save_data = $("#form-options").serialize();
				data += "&" + save_data;
			break;

			case "form_element_duplicate":
				// check if element was changed before duplicating
				if ($(el).parents(".ezfc-form-element-name").hasClass("ezfc-changed")) {
					ezfc_message("Please update the form before duplicating elements.");
					$(".ezfc-loading").hide();

					return false;
				}
			break;

			case "toggle_element_ids":
				$(".ezfc-form-element-id").toggle();
				$(".ezfc-loading").hide();

				return false;
			break;
		}

		// auto append id
		if (id) {
			data += "&id=" + id;
		}
		if (f_id) {
			data += "&f_id=" + f_id;
		}

		// nonce
		data += "&nonce=" + ezfc_nonce;

		$.ajax({
			type: "post",
			url: ajaxurl,
			data: {
				action: "ezfc_backend",
				data: data
			},
			success: function(response) {
				$(".ezfc-loading").fadeOut("fast");

				if (ezfc_debug_mode == 1 && console) console.log(response);

				response_json = $.parseJSON(response);
				if (!response_json) {
					$(".ezfc-error").text("Something went wrong. :(");
						
					return false;
				}

				if (response_json.error) {
					$(".ezfc-error").text(response_json.error);

					return false;
				}
				$(".ezfc-error").text("");

				if (response_json.message) {
					ezfc_message(response_json.message);
				} 

				if (response_json.download_url) {
					$("body").append("<iframe src='" + response_json.download_url + "' style='display: none;' ></iframe>");
					//window.location.href = response_json.download_url;
				}

				/**
					call functions after ajax request
				**/
				switch (action) {
					case "element_get":
						element_show(response_json.element[0]);
					break;

					case "form_add":
					case "form_duplicate":
						form_add(response_json);
					break;

					case "form_delete_submissions":
						form_show_submissions();
					break;

					case "form_get":
						form_show(response_json);
					break;

					case "form_get_submissions":
						form_show_submissions(response_json);
					break;

					case "form_clear":
						form_clear();
					break;

					case "form_delete":
						form_changed = false;
						form_delete(id);
					break;

					case "form_file_delete":
						form_file_delete(id);
					break;

					case "form_save_post":
					case "form_save":
						form_changed = false;
						$(".ezfc-changed").removeClass("ezfc-changed");
						el_disabled_list.attr("disabled", "disabled");

						// update name in forms list
						var form_name = $("#ezfc-form-name").val();
						$(".ezfc-form[data-id='" + id + "'] .ezfc-form-name").text(form_name);
						// update name shortcodes
						$("#ezfc-shortcode-name").val("[ezfc name='" + form_name + "' /]");

						if (action == "form_save_post") window.open(decodeURIComponent(response_json.success), "ezfc_" + id);
					break;

					case "form_save_template":
						var template_name = $("#ezfc-form-name").val();
						$("#ezfc-form-template-id").append("<option value='" + response_json + "'>" + template_name + "</option>");
					break;

					case "form_template_delete":
						$("#ezfc-form-template-id option[value='" + id + "']").remove();
					break;

					case "form_element_delete":
						$(el).closest(".ezfc-form-element").remove();
						fill_calculate_fields();
					break;

					case "form_element_add":
					case "form_element_duplicate":
						var element_new = element_add(response_json);

						// dropped element
						if (settings) {
							$("#ezfc-element-drag-placeholder").after(element_new);
							$("#ezfc-element-drag-placeholder").remove();
						}
						else {
							$(".ezfc-form-elements").append(element_new);
						}

						fill_calculate_fields();
						
						init_ui();
					break;

					case "form_submission_delete":
						$(el).parents(".ezfc-form-submission").remove();

						// update counter
						var $form_counter = $(".ezfc-forms-list .button-primary .ezfc-submission-counter");
						var counter = parseInt($form_counter.text());
						$form_counter.text(counter - 1);
					break;

					case "form_update_options":
						$(".ezfc-forms-list li[data-id='" + id + "'] .ezfc-form-name").text($("#opt-name").val());
						$(".ezfc-dialog").dialog("close");
					break;

					case "form_import_data":
						form_add(response_json);
						form_show(response_json);
						$(".ezfc-dialog").dialog("close");
					break;

					case "form_show_export":
						$("#form-export-data").val(JSON.stringify(response_json));
						$(".ezfc-export-dialog").dialog("open");
					break;
				}
			}
		});

		return false;
	}

	function ezfc_message(message) {
		$(".ezfc-message").text(message).slideDown();

		setTimeout(function() {
			$(".ezfc-message").slideUp();
		}, 7500);
	}

	function ezfc_form_has_changed(trigger_el) {
		form_changed = true;

		$(trigger_el).closest(".ezfc-form-element").find("> .ezfc-form-element-name").addClass("ezfc-changed");
	}

	function ezfc_stripslashes(str) {
		return (str + '')
		.replace(/\\(.?)/g, function (s, n1) {
		  switch (n1) {
		  case '\\':
		    return '\\';
		  case '0':
		    return '\u0000';
		  case '':
		    return '';
		  default:
		    return n1;
		  }
		});
	}

	// change form element columns
	function change_columns(el, inc) {
		var element_wrapper = $(el).closest(".ezfc-form-element");
		var columns = element_wrapper.data("columns");
		var columns_new = Math.min(6, Math.max(1, columns + inc));

		element_wrapper
			.removeClass("ezfc-col-" + columns)
			.addClass("ezfc-col-" + columns_new)
			.data("columns", columns_new)
			.find("[data-element-name='columns']")
				.val(columns_new);
	}

	function nl2br (str, is_xhtml) {
	    var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '<br />' : '<br>';
	    return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1' + breakTag + '$2');
	}

	String.prototype.capitalize = function() {
	    return this.charAt(0).toUpperCase() + this.slice(1);
	}

	function get_tip(text) {
		return "<span class='fa fa-question-circle' data-ot='" + text + "'></span>";
	}

	function clear_option_row(row) {
		$(row).find("input").val("");
		$(row).find("select").val("0");
	}

	// stick add elements div to top
	if ($("#ezfc-elements-add").length > 0) {
		var elements_add_div     = $("#ezfc-elements-add");
		var elements_add_div_top = elements_add_div.offset().top;

	    $(window).scroll(function(){
	        if( $(window).scrollTop() > elements_add_div_top + 30 ) {
	            $('#ezfc-elements-add').addClass("ezfc-sticky");
	        } else {
	            $('#ezfc-elements-add').removeClass("ezfc-sticky");
	        }
	    });
	}

	// rating dialog
	var rating_dialog = $("#ezfc-rating-dialog");
	if (rating_dialog.length > 0) {
		$("#ezfc-rating-dialog").dialog({
			height: 300,
			width: 700,
			modal: true
		});
	}

	// set form elements height
	function set_form_elements_height() {
		// set form element container height
		var container_height = parseInt($("#ezfc-form-elements-container").height()) + 50;
		$("#form-elements-list").height(container_height);
	}

	function ezfc_get_element_option_description(option) {
		if (ezfc_vars.element_option_description[option]) return ezfc_vars.element_option_description[option];
		return "";
	}

	function ezfc_parse_date(d) {
		// yyyy-mm-dd hh:mm:ss
		var tmp = d.split(" ");

		var tmp_date = tmp[0].split("-");
		var tmp_time = tmp[1].split(":");

		return new Date(tmp_date[0], parseInt(tmp_date[1]) - 1, tmp_date[2], tmp_time[0], tmp_time[1], tmp_time[2]);
	}

	function ezfc_sanitize_value(value) {
		if (typeof value === "string") {
			value = value.replace("'", "&apos;");
		}
		else if (typeof value === "object") {
			$.each(value, function(i, v) {
				value[i] = ezfc_sanitize_value(v);
			});
		}

		return value;
	}
});