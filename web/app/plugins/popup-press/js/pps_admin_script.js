jQuery(document).ready(function($){

	// Tabs del Panel de Opciones
	$(".pps-tab-content").hide(); //Hide all content
	$("#pps-tabs a:first").addClass("nav-tab-active").show(); //Activate first tab
	$(".pps-tab-content:first").show(); //Show first tab content

	$("#pps-tabs a").click(function() {
		$("#pps-tabs a").removeClass("nav-tab-active"); //Remove any "active" class
		$(this).addClass("nav-tab-active"); //Add "active" class to selected tab
		$(".pps-tab-content").removeClass("active").hide(); //Remove any "active" class and Hide all tab content
		var activeTab = $(this).attr("href"); //Find the rel attribute value to identify the active tab + content
		$(activeTab).fadeIn().addClass("active"); //Fade in the active content
		return false;
	});

	//Acción para realizar la compatibilidad
	$('#pps-btn-compatibility').click(function(){
		var datos = {
			action: 'check_compatibility_popups',
			pps_nonce: $('input#compatibility_popups').val()
		};
		var btn = $(this);
		$('#title-updated-popups').hide();
		$('#title-updated-popups').next('ol').html('');
		$('.spinner').css({
			'visibility': 'visible',
			'float': 'none',
			'display' : 'inline-block',
			'margin-top': 0,
		});
		jQuery.ajax({
			type: "POST",
			url: PPS.ajaxurlPps,
			data: datos,
			success: function(result){
				$('.spinner').css({
					'visibility': 'hidden',
					'display' : 'none'
				});
				var data = jQuery.parseJSON(result);
				if(data.success === true){
					$('.update').html('Compatibility completed successfully.');
					btn.hide();
					$('#title-updated-popups').show();
					$('#title-updated-popups').next('ol').html(data.popups);
				} else {
					alert("Occurred internal problems, try again later.");
				}
			}
		});
	});

	$('.pps-remove-cookie').click(function(event) {
		idPopup = $(this).attr('id').replace(/[^0-9\.]/g,'');
		removedCookie = false;
		if(jQuery.cookie('pps_cookie_'+idPopup)){
			$.removeCookie('pps_cookie_'+idPopup, { path: '/' });
			removedCookie = true;
		}
		if(jQuery.cookie('pps_disclaimer_'+idPopup)){
			$.removeCookie('pps_disclaimer_'+idPopup, { path: '/' });
			removedCookie = true;
		}
		if(removedCookie){
			alert('Cookie removed');
		} else {
			alert('There are no cookies');
		}
	});



	// Elimina elementos no deseados
	if($('.wp-list-table tr.type-popuppress').length){
		$('tr.type-popuppress').find('td .row-actions span.view').remove();
	}
	if($('.pps_metabox').length) {
		$('#edit-slug-box, #preview-action').remove();
	}

	// OCULTA/MUESTRA CAMPOS SEGÚN BUTTON TYPE
	hideFieldBox_pps('input#pps_button_type1, input#pps_button_type3, input#pps_button_type4, input#pps_button_type5', '.cmb_id_pps_button_image');
	hideFieldBox_pps('input#pps_button_type1, input#pps_button_type3, input#pps_button_type4, input#pps_button_type5', '.cmb_id_pps_button_image_hover');
	hideFieldBox_pps('input#pps_button_type1, input#pps_button_type3, input#pps_button_type4, input#pps_button_type5', '.cmb_id_pps_img_width_button');

	hideFieldBox_pps('input#pps_button_type1, input#pps_button_type3', '.cmb_id_pps_n_columns');
	hideFieldBox_pps('input#pps_button_type1, input#pps_button_type2, input#pps_button_type3, input#pps_button_type5, input#pps_button_type6', '.cmb_id_pps_class_thumbnail');
	hideFieldBox_pps('input#pps_button_type2, input#pps_button_type4, input#pps_button_type5', '.cmb_id_pps_button_text');
	hideFieldBox_pps('input#pps_button_type2, input#pps_button_type4, input#pps_button_type5', '.cmb_id_pps_button_class');
	hideFieldBox_pps('input#pps_button_type2, input#pps_button_type5', '.cmb_id_pps_n_columns');

	hideFieldBox_pps('input#pps_button_type4, input#pps_button_type5', '.cmb_id_pps_button_title');
	hideFieldBox_pps('input#pps_button_type4', '.cmb_id_pps_button_class_run');


	$('input#pps_button_type1, input#pps_button_type3').click(function() {
		$(this).closest('tr[class^="cmb-type-"]').siblings().hide();
		$('.cmb_id_pps_button_text, .cmb_id_pps_button_title, .cmb_id_pps_button_class, .cmb_id_pps_button_class_run').fadeIn('slow');
	});
	$('input#pps_button_type2').click(function() {
		$(this).closest('tr[class^="cmb-type-"]').siblings().hide();
		$('.cmb_id_pps_button_title, .cmb_id_pps_button_class_run, .cmb_id_pps_button_image, .cmb_id_pps_button_image_hover, .cmb_id_pps_img_width_button').fadeIn('slow');
	});
	$('input#pps_button_type4').click(function() {
		$(this).closest('tr[class^="cmb-type-"]').siblings().hide();
		$('.cmb_id_pps_class_thumbnail, .cmb_id_pps_n_columns').fadeIn('slow');
	});
	$('input#pps_button_type5').click(function() {
		$(this).closest('tr[class^="cmb-type-"]').siblings().hide();
		$('.cmb_id_pps_button_class_run').fadeIn('slow');
	});


	// OCULTA/MUESTRA todos los campos de Open hook según sea el caso
	showHideFieldBox_pps('input#pps_open_hook2, input#pps_open_hook3', '.cmb_id_pps_first_time');
	showHideFieldBox_pps('input#pps_open_hook2, input#pps_open_hook3', '.cmb_id_pps_cookie_expire');
	showHideFieldBox_pps('input#pps_open_hook3', '.cmb_id_pps_leave_page_max_times');

	// OCULTA/MUESTRA CAMPO "Use Cookie y Lifetime of the Cookie"
	showHideIsParentChecked_pps('input#pps_open_hook2, input#pps_open_hook3', 'input#pps_first_time1', '.cmb_id_pps_cookie_expire');
	showHideIsParentChecked_pps('input#pps_open_hook2, input#pps_open_hook3', 'input#pps_first_time1', '.cmb_id_pps_remove-cookie');

	if($('input#pps_open_hook2, input#pps_open_hook3').is(':checked')){
		showHideIsParentChecked_pps('input#pps_first_time1', 'input#pps_cookie_expire2', '.cmb_id_pps_cookie_days');
	} else {
		hideFieldBox_pps('input#pps_open_hook1, input#pps_open_hook4', '.cmb_id_pps_cookie_days');
	}


	// OCULTA/MUESTRA CAMPO "Close on mouseleave"
	showHideFieldBox_pps('input#pps_open_hook4', '.cmb_id_pps_close_mouselave');

	$('input[name="pps_open_hook"]').click(function() {
		showHideFieldBox_pps('input#pps_open_hook2, input#pps_open_hook3', '.cmb_id_pps_first_time');

		showHideIsParentChecked_pps('input#pps_open_hook2, input#pps_open_hook3', 'input#pps_first_time1', '.cmb_id_pps_cookie_expire');
		if($('input#pps_open_hook2, input#pps_open_hook3').is(':checked')){
			showHideIsParentChecked_pps('input#pps_first_time1', 'input#pps_cookie_expire2', '.cmb_id_pps_cookie_days');
		}
		else {
			hideFieldBox_pps('input#pps_open_hook1, input#pps_open_hook4', '.cmb_id_pps_cookie_days');
		}
		showHideIsParentChecked_pps('input#pps_open_hook2, input#pps_open_hook3', 'input#pps_first_time1', '.cmb_id_pps_remove-cookie');

		showHideFieldBox_pps('input#pps_open_hook3', '.cmb_id_pps_leave_page_max_times');
		showHideFieldBox_pps('input#pps_open_hook4', '.cmb_id_pps_close_mouselave');
	});

	// OCULTA/MUESTRA CAMPOS "Lifetime of the Cookie y Lifetime (days)"
	$('input[name="pps_first_time"]').click(function() {
		showHideFieldBox_pps('input#pps_first_time1', '.cmb_id_pps_cookie_expire');
		showHideFieldBox_pps('input#pps_cookie_expire2', '.cmb_id_pps_cookie_days');
		hideFieldBox_pps('input#pps_first_time2', '.cmb_id_pps_cookie_days');
		showHideFieldBox_pps('input#pps_first_time1', '.cmb_id_pps_remove-cookie');
	});

	// OCULTA/MUESTRA CAMPO "Lifetime (days)"
	$('input[name="pps_cookie_expire"]').click(function() {
		showHideFieldBox_pps('input#pps_cookie_expire2', '.cmb_id_pps_cookie_days');
	});

	// OCULTA/MUESTRA CAMPO "Close Delay"
	showHideFieldBox_pps('input#pps_auto_close1', '.cmb_id_pps_delay_close');

	$('input[name="pps_auto_close"]').click(function() {
		showHideFieldBox_pps('input#pps_auto_close1', '.cmb_id_pps_delay_close');
	});

	// OCULTA/MUESTRA CAMPO "Exclude Pages"
	showHideFieldBox_pps('input#pps_open_in3', '.cmb_id_pps_exclude_pages');

	$('input[name="pps_open_in"]').click(function() {
		showHideFieldBox_pps('input#pps_open_in3', '.cmb_id_pps_exclude_pages');
	});

	// OCULTA/MUESTRA CAMPO "OPEN IN URL'S"
	showHideFieldBox_pps('input#pps_open_in4', '.cmb_id_pps_open_in_url');

	$('input[name="pps_open_in"]').click(function() {
		showHideFieldBox_pps('input#pps_open_in4', '.cmb_id_pps_open_in_url');
	});


	// OCULTA/MUESTRA CAMPO "POPUP HEIGHT"
	showHideFieldBox_pps('input#pps_auto_height2', '.cmb_id_pps_height');
	showHideFieldBox_pps('input#pps_auto_height2', '.cmb_id_pps_height_units');
	$('input[name="pps_auto_height"]').click(function() {
		showHideFieldBox_pps('input#pps_auto_height2', '.cmb_id_pps_height');
	showHideFieldBox_pps('input#pps_auto_height2', '.cmb_id_pps_height_units');
	});

	//Oculta los Metaboxes
	//$('#side-sortables > div[id*=_cmb]').addClass('closed');

	// Activa ColorPicker en la Página de Opciones
	if(typeof jQuery.fn.wpColorPicker == 'function') {
		$('.pps-colorpicker').wpColorPicker();
	}

	// TOOLTIP
	$('.cmb_metabox_description sub, #side-sortables td ul li dfn').hover(
		function(){
			var title = $(this).text();

			$(this).data('tipText', title);
			$('<div class="cmb-tip-wrap"><div class="cmb-tip-arrow"></div><div class="cmb-tip-text"></div></div>').appendTo('body');
			$('.cmb-tip-text').text(title).parent().fadeIn(500);
		},
		function() {
			$('.cmb-tip-wrap').remove();
		}
	).mousemove(function(w) {
		var widthTip = $('.cmb-tip-wrap').innerWidth();
        var mousex = w.pageX - widthTip - 15;
        var mousey = w.pageY - 3;
        $('.cmb-tip-wrap').css({
			top: mousey,
			left: mousex
		});
	});

	function showHideFieldBox_pps(radioItem, box ){
		if( $(radioItem).is(':checked') )
			$(box).fadeIn();
		else
			$(box).fadeOut();
	}
	function hideFieldBox_pps(radioItem, box ){
		if( $(radioItem).is(':checked'))
			$(box).fadeOut();
		//else
			//$(box).fadeIn();
	}
	function showHideIsParentChecked_pps(parentItem, radioItem, box ){
		if( $(parentItem).is(':checked')){
			if( $(radioItem).is(':checked'))
				$(box).fadeIn();
			else
				$(box).fadeOut();
		}
		else
				$(box).fadeOut();
		//else
			//$(box).fadeIn();
	}
	//Soluciona problema al tratar de eliminar un elemento repetible que ha sido ordenado
	$('body.post-type-popuppress .repeatable-group').on('click', 'a.shift-rows', function(){
		var $self     = $(this);
		setTimeout(function(){
		$self.closest('.repeatable-group').find( '.cmb_remove_file_button').each( function(index, element) {
			var $rel = $(element).attr('rel');
			$rel = $rel.replace(/(\d+)/, index);
			$(element).attr('rel', $rel);
		});
		}, 300);
	});

});

