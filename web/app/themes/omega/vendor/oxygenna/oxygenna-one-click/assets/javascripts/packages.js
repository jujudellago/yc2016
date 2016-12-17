/**
 * Oxygenna.com
 *
 * $Template:: *(TEMPLATE_NAME)*
 * $Copyright:: *(COPYRIGHT)*
 * $Licence:: *(LICENCE)*
 */

 /*global jQuery: false*/

'use strict';

var imageScrollDirection;
function rollImage(image, down) {
    var $container = jQuery(image).parent();
    if(down !== imageScrollDirection) {
        $container.stop();
    }
    imageScrollDirection = down;
    $container.animate({
        scrollTop: down ? $container[0].scrollHeight : 0
    }, 4000);
}

(function( $ ){
    $(document).ready(function($){
        // handle modal popup on start page
        $('.package-details').click(function(e) {
            var $button = $(this);
            tb_show('Demo Package Details', 'admin-ajax.php?action=oxy_import_package_details&width=900&height=550&id=' + $button.attr('data-id') );
        });
    });
})( jQuery );