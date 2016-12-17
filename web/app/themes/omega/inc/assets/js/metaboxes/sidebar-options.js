/**
 * Oxygenna.com
 *
 * $Template:: *(TEMPLATE_NAME)*
 * $Copyright:: *(COPYRIGHT)*
 * $Licence:: *(LICENCE)*
 */
(function( $ ){
    $(document).ready(function($){
        $('select[name="page_template"]').change(function(){
            switch( $(this).val() ) {
                case 'template-rightsidebar.php':
                case 'template-leftsidebar.php':
                    $('#page_sidebar_swatch').show();
                break;
                default:
                    $('#page_sidebar_swatch').hide();
                break;
            }
        }).trigger('change');
    });
})( jQuery );