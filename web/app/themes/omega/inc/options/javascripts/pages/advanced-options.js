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
        $('#install-default-vc-templates').click( function() {
            var $button = $(this);

            // add loading spinner next to the list select
            $button.after( '<span id="updateListMessage"><img src="images/wpspin_light.gif" style="vertical-align:middle;padding: 0px 5px;" /><span>Installing...</span></div>' );
            // disable the fetch list button
            $button.attr( 'disabled', true );

            $.post( localData.ajaxurl,
                {
                    action: 'install_default_vc_templates',
                    nonce: localData.installDefaultsNonce,
                },
                function( data ) {
                    console.log(data);
                    switch( data.status ) {
                        case 'ok':
                            addMessage( 'updated' , 'Default Templates installed.' , 5000 );
                        break;
                        case 'failed':
                            addMessage( 'error' , data.message , 10000 );
                        break;
                    }
                    // re enable the fetch list button
                    $button.removeAttr( 'disabled' );
                    // remove the text & spinner next to the select list box
                    $( '#updateListMessage' ).remove();
                },
                'json'
            );

            return false;
        });
    });
})(jQuery);