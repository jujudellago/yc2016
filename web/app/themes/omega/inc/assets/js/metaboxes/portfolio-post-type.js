/**
 * Oxygenna.com
 *
 * $Template:: *(TEMPLATE_NAME)*
 * $Copyright:: *(COPYRIGHT)*
 * $Licence:: *(LICENCE)*
 */

(function( $ ){
    $(document).ready(function($){
        // get the select box we need to toggle options with
        var $selectContainer = $( '#' + theme + '_post_type' );
        var $linkType = $selectContainer.find('[name="' + theme + '-options[' + theme + '_post_type]"]');
        var $toggleOptions = $selectContainer.siblings( '.form-table' ).not('#' + theme + '_target');

        $linkType.change(function(){
            // hide all controls after the select
            $toggleOptions.hide();
            // show selected options
            switch( $(this).val() ) {
                case 'video':
                    $( $toggleOptions[0] ).show();
                break;
                case 'gallery':
                    $( $toggleOptions[1] ).show();
                break;
            }
        }).trigger('change');
    });
})( jQuery );