  /**
 * Oxygenna.com
 *
 * $Template:: *(TEMPLATE_NAME)*
 * $Copyright:: *(COPYRIGHT)*
 * $Licence:: *(LICENCE)*
 */

 /*global jQuery: false, typekitUpdate: false */
 'use strict';
 (function($) {
    function addMessage( type, message, duration ) {
        // create message
        var messageHTML = $( '<div id="setting-error-settings_updated" class="' + type + ' settings-error below-h2"><p><strong>' + message + '</strong></p></div>' );
        messageHTML.hide();
        // add message to the page and fade in
        $( '#ajax-errors-here').append( messageHTML );
        messageHTML.fadeIn();

        if( duration !== undefined ) {
            setTimeout(function() {
                messageHTML.fadeOut();
            }, duration);  // will work with every browser
        }
    }

    $(document).ready(function($) {
        $('#typekit-kits-button').click( function() {
            // get a handle on the button and the list
            var $updateListButton = $(this);
            // add loading spinner next to the list select
            $updateListButton.after( '<span id="updateListMessage"><img src="images/wpspin_light.gif" style="vertical-align:middle;padding: 0px 5px;" /><span>Fetching...</span></div>' );
            // disable the fetch list button
            $updateListButton.attr( 'disabled', true );

            $.post( typekitUpdate.ajaxurl, {
                    action: 'typekit_update_kits',
                    nonce: typekitUpdate.nonce,
                    api_key: $('#typekit-api-key').val()
                },
                function( response ) {
                    if( response.status ) {
                        addMessage( 'updated' , 'TypeKit Fonts fetched successfully.' , 5000 );
                    }
                    else {
                        addMessage( 'error' , 'Error fetching kits' , 10000 );
                    }
                    // re enable the fetch list button
                    $updateListButton.removeAttr( 'disabled' );
                    // remove the text & spinner next to the select list box
                    $( '#updateListMessage' ).remove();
                },
                'json'
            );

            // return false so the form is not sent
            return false;
        });

    });
})(jQuery);
