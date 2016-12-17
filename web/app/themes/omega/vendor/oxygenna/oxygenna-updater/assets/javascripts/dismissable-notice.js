 /**
 * Oxygenna.com
 *
 * $Template:: *(TEMPLATE_NAME)*
 * $Copyright:: *(COPYRIGHT)*
 * $Licence:: *(LICENCE)*
 */

 /*global jQuery: false,  _: false, oxyUpdateNotice: false*/

'use strict';
(function($) {
	$(document).ready(function($) { 
    	$('#ajax-update-notice .notice-close').click( function() {
            var $noticeButton = $(this);
            var $notice = $('#ajax-update-notice');            
            
            $.post( oxyUpdateNotice.ajaxURL, {
                action:'hide_update_notice',
                nonce: oxyUpdateNotice.updateNoticeNonce                           
            })
            .success( function( response ) {console.log(response);
                $notice.slideUp('slow');
            });

            return false;
        });
	});
})(jQuery);