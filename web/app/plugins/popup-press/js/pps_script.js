ppsEmbedObject = {};

jQuery(document).ready(function($){
	var formClass = {
		jetPack: '.contact-form-submission',
		gravityForms: '.gform_wrapper .validation_error, .gform_confirmation_message'
	};
	jQuery('.pps-popup').each(function(index, element){
		// Remove Duplicate Popups IDs
		var ids = jQuery('[id=\''+this.id+'\']');
		if(ids.length > 1){
			ids.slice(1).remove();
		}

		var idPopup = jQuery(this).attr('id').replace('popuppress-','');

		//Establecer anchos en pixeles a cada popup
		manageWidthsPopupPress(idPopup);

		//Solución a los mensajes al enviar formularios
		if(jQuery(this).find(formClass.jetPack + ',' + formClass.gravityForms).length){
			jQuery(document).ready(function(){
				if(jQuery('.pps-button-popup-'+idPopup).length){
					jQuery('.pps-button-popup-'+idPopup).trigger('click');
				}
			});
		}
	});

	//Fix Close Multiple Popups
	jQuery('.pps-popup .pps-btn').on('click',function(e){
		e.preventDefault();
		//idPopup = jQuery(this).attr('class').replace(/[^0-9\.]/g,'');
		idPopupParent = jQuery(this).closest('.pps-popup').attr('id').replace(/[^0-9\.]/g,'');
		//jQuery('.pps-close-link-'+idParent).click();
		jQuery('#popuppress-'+idPopupParent).bPopup().close();
	});

	//Restore views Popups
	jQuery('a.restore-views').on('click',function(e){
		e.preventDefault();
		idPopup = jQuery(this).attr('href').replace('?popup_id=','');
		if(confirm("Really you want restore values?"))
			updateViewsPopupPress(idPopup,"restore");
	});

	$(window).on("resize", function( event ) {
		var popup = jQuery('.pps-popup').last();
		if(popup.css('display') == 'block'){
			var id = popup.attr('id').replace('popuppress-','');
			manageWidthsPopupPress(id);
			//Para redimensionar contenidos cuando se redimensiona la pantalla
			manageHeightsPopupPress(id, '.pps-embed', 100);
			manageHeightsPopupPress(id, '.pps-iframe', 100);
			manageHeightsPopupPress(id, '.pps-pdf', 100);
		}
	});
});


function beforeSliderPopupPress(id){
	var popup = jQuery("#popuppress-"+id);
	if(ppsEmbedObject[id].autoplay !== ''){
		popup.find('.pps-embed').first().html(ppsEmbedObject[id].normal);
	}
	pauseEmbedsPopupPress(id);
}
function afterSliderPopupPress(id, pps_popup){
	pps_popup.reposition(200);
}

function openedPopupPress(id){
	var popup = jQuery("#popuppress-"+id);

	//Reposicionamos el mensaje Ok para los formularios
	var formClass = {
		jetPack: '.contact-form-submission',
		gravityForms: '.gform_wrapper .validation_error, .gform_confirmation_message'
	};
	//Solución a los mensajes al enviar formularios
	if(popup.find(formClass.jetPack + ',' + formClass.gravityForms).length){
		repositionPopupPress(id);
	}
}

function onOpenPopupPress(id, close_mouseleave, img_overlay, pps_popup){
	setImageOverlayPopupPress(id, img_overlay);
	var popup = jQuery("#popuppress-"+id);
	setTimeout(function(){
		updateOverflowPopupPress(id, 0);
		//manageWidthsPopupPress(id); //No encerrar en setTimeout porque afecta al la posición left, sale un tanto a la derecha
	},50);

	//Agregamos clase pps-mobile cuando estamos en un dispositivo movil
	if(isMobile.any){
		popup.addClass('pps-mobile');
	}

	if(ppsEmbedObject[id].autoplay !== ''){
		popup.find('.pps-embed').first().html(ppsEmbedObject[id].autoplay);
	}

	if(popup.find('.pps-single-popup').length ){
		if(popup.find('.pps-iframe').length){
			popup.find('.pps-iframe').append('<span class="pps-loading"></span>');
			setTimeout(function(){
				popup.find('.pps-iframe .pps-loading').remove();
			}, 1500);
		}
		if(popup.find('.pps-pdf').length){
			popup.find('.pps-pdf').append('<span class="pps-loading"></span>');
			setTimeout(function(){
				popup.find('.pps-pdf .pps-loading').remove();
			}, 1500);
		}
	}

	if(close_mouseleave == 'true') {
		popup.mouseleave(function() {
			jQuery(this).bPopup().close();
			jQuery('.b-modal').remove();
		});
	}

	//Movemos las flechas fuera de .pps-content porque el overflow=auto las oculta
	if(popup.find('.pps-direction-nav').length){
		popup.find('.pps-wrap').append(popup.find('.pps-direction-nav'));
	}
	if(popup.find('.pps-control-nav').length){
		popup.find('.pps-wrap').append(popup.find('.pps-control-nav'));
	}

	//Actualizar vistas
	updateViewsPopupPress(id);
}

function manageWidthsPopupPress(id){
	var popup = jQuery("#popuppress-"+id);
	var popupHeight = popup.height();
	var contentHeight = popup.find('.pps-wrap').height();
	var originalSizePopup = getOriginalSizePopupPress(id);

	var deviceWidth = jQuery(window).width();
	var deviceHeight = jQuery(window).height();

	//Resize Width
	if(originalSizePopup.widthUnit == 'px'){
		if(originalSizePopup.width >= (deviceWidth - 40)){
			popup.css({
				'width'	: 88+'%',
				'left'	: 6+'%',
			});
		} else {
			popup.css({
				'width'	: originalSizePopup.width+'px',
				'left'	: (((deviceWidth - originalSizePopup.width)/2) - 8) + 'px',
			});
		}
	} else {
		var newWidth = (deviceWidth*(originalSizePopup.width)/100);
		if(deviceWidth > 600){
			popup.css({
				'width'	: newWidth +'px',
				'left'	: (((deviceWidth - newWidth)/2) - 8) +'px',
			});
		} else {
			popup.css({
				'width'	: 88+'%',
				'left'	: 6+'%',
			});
		}
	}
	//updateOverflowPopupPress(id, 10);
}
function updateOverflowPopupPress(id, time){
	setTimeout(function(){
		var popup = jQuery("#popuppress-"+id);
		var popupHeight = popup.height();
		var contentHeight = popup.find('.pps-wrap').height();

		if(popup.find('li.pps-active-slide img.pps-img-slider').length){
			return;
		}
		if(popup.find('li.pps-active-slide .pps-embed iframe').length){
			return;
		}
		if(popup.find('.pps-header').length){
			popup.find('.pps-content').css({
				'height' : contentHeight - popup.find('.pps-header h3').outerHeight(true),
			});
		} else {
			popup.find('.pps-content').css({
				'height' : '100%',
			});
		}
		popup.find('.pps-content').css('overflow', 'auto');
	}, time);
}

function manageHeightsPopupPress(id, medio, height){
	var popup = jQuery("#popuppress-"+id);

	setTimeout(function(){
		var popupHeight = popup.height();
		var contentHeight = popup.find('.pps-wrap').height();
		var deviceHeight = jQuery(window).height();

		if(popup.find(medio).find('iframe').length){
			var newContentHeight = contentHeight;
			if(height == 100){
				popup.find(medio).find('iframe').css({
					'height': newContentHeight  + 'px',
				});
			}
			var headerHeight = 0;
			if(popup.find('.pps-header').length){
				headerHeight = popup.find('.pps-header h3').outerHeight(true);
			}
			if(medio == '.pps-embed'){
				if(contentHeight > deviceHeight - 60 ){
					var newPopupHeight = deviceHeight - 80;
					popup.css({
						'height': newPopupHeight  + 'px',
					});
					newContentHeight = popup.find('.pps-wrap').height();
				}
			}
			newContentHeight = newContentHeight - headerHeight;
			popup.find(medio).find('iframe').attr('height', newContentHeight + 'px');
			popup.find(medio).find('iframe').css({
				'height': newContentHeight  + 'px',
			});

		}
	},20);
}

function manageSizeEmbedPopupPress(id, height){
	manageHeightsPopupPress(id, '.pps-embed', height);
}
function manageSizeIframePopupPress(id, height){
	manageHeightsPopupPress(id, '.pps-iframe', height);
}
function manageSizePdfPopupPress(id, height){
	manageHeightsPopupPress(id, '.pps-pdf', height);
}

function getOriginalSizePopupPress(id){
	var popup = jQuery("#popuppress-"+id);
	var classWidthPopup = jQuery.grep(popup.attr('class').split(" "), function(element){
       return element.indexOf('pps-w-') === 0;
   }).join();
   var classHeightPopup = jQuery.grep(popup.attr('class').split(" "), function(element){
       return element.indexOf('pps-h-') === 0;
   }).join();

   if(classHeightPopup.split("-")[2] == 'auto'){
   	heightPopup = 'auto';
   } else {
   	heightPopup = parseInt(classHeightPopup.split("-")[2]);
   }

	var originalSizePopup = {
		width: parseInt(classWidthPopup.split("-")[2]),
		widthUnit: classWidthPopup.split("-")[3],
		height: heightPopup,
		heightUnit: classHeightPopup.split("-")[3]
	};
	return originalSizePopup;
}

function pauseEmbedsPopupPress(id) {
	var popup = jQuery("#popuppress-"+id);
	var embed;
	if(popup.find('.pps-embed').length){
		if(popup.find('ul.pps-slides').length){
			var index = popup.find('ul.pps-slides > li').index(popup.find('li.pps-active-slide'));
			embed = popup.find('ul.pps-slides > li').eq(index).find('.pps-embed');
		} else {
			embed = popup.find('.pps-embed');
		}
		var iframe = embed.html();
		setTimeout(function(){
			embed.find('iframe').remove();
			embed.html(iframe);
		}, 100); /*  Opcional, Delay tiene q ser menor al establecido en onClosePopupPress */
	}
}
function setImageOverlayPopupPress(id, img_overlay){
	if(jQuery.trim(img_overlay) !== ""){
		setTimeout(function(){
			jQuery('.b-modal').last().css({
				'background-image': ' url(' + img_overlay + ')',
				'background-position': '0px 0px',
				'background-repeat': 'repeat',
			});
		},60);
	}
}

function onClosePopupPress(id){
	removeMessageFormsPopupPress();

	var popup = jQuery("#popuppress-"+id);
	if(ppsEmbedObject[id].autoplay !== ''){
		popup.find('.pps-embed').first().html(ppsEmbedObject[id].normal);
	}
	pauseEmbedsPopupPress(id);
	setTimeout(function(){
		var popup = jQuery("#popuppress-"+id);
		if(popup.find('#pps-slider-'+id).length ){
			jQuery("#pps-slider-"+id).popupslider("destroy");
		}
	}, 150);/*  Opcional, Delay tiene q ser mayor al establecido en pauseEmbedsPopupPress */
}


function repositionPopupPress(id) {
	var popup = jQuery("#popuppress-"+id);
	var wHeight = jQuery(window).height();
	var popupHeight = jQuery("#popuppress-"+id).outerHeight();
	var topPosition = 20;
	if( wHeight > popupHeight ){
		topPosition = jQuery(window).scrollTop() + (wHeight-popupHeight)/2;
		popup.animate({top: topPosition}, 500 );
	}
}

function loadPopups_PPS(id, pps_nonce){
	/*var datos = {
		action: 'load_popup',
		id: id,
		plugin: 'popuppress',
		pps_nonce: pps_nonce
	};
	jQuery.ajax({
		type: "POST",
		url: PPS.ajaxurlPps,
		data: datos,
		success: function(result){
			var data = jQuery.parseJSON(result);
			if(data.success == true){
				var popup = jQuery("#popuppress-"+id);
				if(!jQuery("#popuppress-"+id).length){
					jQuery('body').append(data.popup);
				}
			}
		}
	});*/
}

function removeMessageFormsPopupPress(){
	//Solución a los mensajes al enviar formularios
	var formClass = {
		jetPack: '.contact-form-submission',
		gravityForms: '.gform_wrapper .validation_error, .gform_confirmation_message'
	};
	var reload = false;
	jQuery('.pps-popup').each(function(index, element){
		if(jQuery(this).find(formClass.jetPack).length){
			reload = true;
		}
	});
	if(reload){
		window.location = window.location.href.split("?")[0];
	}
}

function updateViewsPopupPress(id,restore){
	restore = restore || 'false';
	var datos = {
		action: 'update_views_popups',
		id: id,
		plugin: 'popuppress',
		restore: restore
	};
	jQuery.ajax({
		type: "POST",
		url: PPS.ajaxurlPps,
		data: datos,
		success: function(result){
			var data = jQuery.parseJSON(result);
			if(data.success === true){
				if(jQuery('table.wp-list-table').length){
					jQuery('tr#post-'+id+' td.column-views > p > span:eq(0)').html(data.views);
				}
			}
		}
	});
}

function disclaimerPopupPress(id, activated, agreeRedirect, disagreeRestriction, useCookie, $cookie_expire, $cookie_days){
	if(activated == 'true'){
		jQuery('#pps-btn-agree').on('click', function(event) {
			if(agreeRedirect == 'same_page'){
				event.preventDefault();
				jQuery('#popuppress-'+id).bPopup().close();
			}
			//Solo registramos cookies fuera de la administración de wordpress
			if(useCookie == 'true' && jQuery(location).attr("href").indexOf("/wp-admin/") < 0){
				if($cookie_expire == 'number_days'){
					jQuery.cookie("pps_disclaimer_" + id, $cookie_days + "_days", { expires: $cookie_days, path: "/" });
				}
				else {
					jQuery.cookie("pps_disclaimer_" + id, "Current_Session", { path: "/" });
				}
			}
		});
		jQuery('#pps-btn-disagree').on('click', function(event) {
			if(disagreeRestriction == 'close_page'){
				window.close();
			}
		});
	}
}

/**
 * isMobile.js v0.3.9
 *
 * A simple library to detect Apple phones and tablets,
 * Android phones and tablets, other mobile devices (like blackberry, mini-opera and windows phone),
 * and any kind of seven inch device, via user agent sniffing.
 *
 * @author: Kai Mallea (kmallea@gmail.com)
 *
 * @license: http://creativecommons.org/publicdomain/zero/1.0/
 */
 !function(a){var b=/iPhone/i,c=/iPod/i,d=/iPad/i,e=/(?=.*\bAndroid\b)(?=.*\bMobile\b)/i,f=/Android/i,g=/(?=.*\bAndroid\b)(?=.*\bSD4930UR\b)/i,h=/(?=.*\bAndroid\b)(?=.*\b(?:KFOT|KFTT|KFJWI|KFJWA|KFSOWI|KFTHWI|KFTHWA|KFAPWI|KFAPWA|KFARWI|KFASWI|KFSAWI|KFSAWA)\b)/i,i=/IEMobile/i,j=/(?=.*\bWindows\b)(?=.*\bARM\b)/i,k=/BlackBerry/i,l=/BB10/i,m=/Opera Mini/i,n=/(CriOS|Chrome)(?=.*\bMobile\b)/i,o=/(?=.*\bFirefox\b)(?=.*\bMobile\b)/i,p=new RegExp("(?:Nexus 7|BNTV250|Kindle Fire|Silk|GT-P1000)","i"),q=function(a,b){return a.test(b)},r=function(a){var r=a||navigator.userAgent,s=r.split("[FBAN");return"undefined"!=typeof s[1]&&(r=s[0]),this.apple={phone:q(b,r),ipod:q(c,r),tablet:!q(b,r)&&q(d,r),device:q(b,r)||q(c,r)||q(d,r)},this.amazon={phone:q(g,r),tablet:!q(g,r)&&q(h,r),device:q(g,r)||q(h,r)},this.android={phone:q(g,r)||q(e,r),tablet:!q(g,r)&&!q(e,r)&&(q(h,r)||q(f,r)),device:q(g,r)||q(h,r)||q(e,r)||q(f,r)},this.windows={phone:q(i,r),tablet:q(j,r),device:q(i,r)||q(j,r)},this.other={blackberry:q(k,r),blackberry10:q(l,r),opera:q(m,r),firefox:q(o,r),chrome:q(n,r),device:q(k,r)||q(l,r)||q(m,r)||q(o,r)||q(n,r)},this.seven_inch=q(p,r),this.any=this.apple.device||this.android.device||this.windows.device||this.other.device||this.seven_inch,this.phone=this.apple.phone||this.android.phone||this.windows.phone,this.tablet=this.apple.tablet||this.android.tablet||this.windows.tablet,"undefined"==typeof window?this:void 0},s=function(){var a=new r;return a.Class=r,a};"undefined"!=typeof module&&module.exports&&"undefined"==typeof window?module.exports=r:"undefined"!=typeof module&&module.exports&&"undefined"!=typeof window?module.exports=s():"function"==typeof define&&define.amd?define("isMobile",[],a.isMobile=s()):a.isMobile=s()}(this);