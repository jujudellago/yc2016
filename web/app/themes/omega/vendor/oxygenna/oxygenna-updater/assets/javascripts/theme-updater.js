 /**
 * Oxygenna.com
 *
 * $Template:: *(TEMPLATE_NAME)*
 * $Copyright:: *(COPYRIGHT)*
 * $Licence:: *(LICENCE)*
 */

 /*global jQuery: false,  _: false, envatoUpdate: false*/

'use strict';
(function($) {

	$(document).ready(function($) {
	  	var $envatoUserNameField = $('#envato-username-field');
	  	var $envatoApiKeyField = $('#envato-apikey-field');
	  	var $container = $('.wrap');
	  	var $statusMessageContainer = $('#status-message-container');  		  	


	  	$('#check-updates-button').click( function() {
            var $checkUpdatesButton = $(this);

            $checkUpdatesButton.attr('disabled', true );
            
            $.post( envatoUpdate.ajaxurl, {
                action: 'check_for_updates',
                nonce: envatoUpdate.checkUpdateNonce,
                userName:$envatoUserNameField.val(),
                apiKey:$envatoApiKeyField.val()
            })
            .success( function( response ) {                
                $checkUpdatesButton.attr('disabled', false );
                
                switch(response.status){
                	case 'credentials-authenticated':
                        addMessage( 'updated', response.message , 5000 );
                        $statusMessageContainer.html('<span class="updater-success">Credentials stored.</span> You will be receiving all future automatic updates.');
                		break;
                	case 'credentials-invalid':
	                	addMessage( 'error', response.message , 5000 );
    	            	$statusMessageContainer.html('<span class="updater-warning">Your Envato User Name and/or API Key are invalid.</span> Please insert the correct Envato User Name and API Key in the above section in order to receive automatic updates.');
                		break;
                	case 'credentials-missing':
	                	addMessage( 'error', response.message , 5000 );
    	            	$statusMessageContainer.html('<span class="updater-warning">Your Envato User Name and/or API Key are missing.</span> Please insert the correct Envato User Name and API Key in the above section in order to receive automatic updates.');
                		break;                	
                }                        
            })
            .error( function( error ) {
                $checkUpdatesButton.attr('disabled', false );
                addMessage( 'error', error.message, 5000 );
            });

            return false;
        });


	});


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

})(jQuery);