/**
 * Oxygenna.com
 *
 * $Template:: *(TEMPLATE_NAME)*
 * $Copyright:: *(COPYRIGHT)*
 * $Licence:: *(LICENCE)*
 */
(function( $ ){
    $(document).ready(function($){
        // initialise each select
        $('.vc_oxygenna_select').each( function() {
            var $select = $(this);
            var value = $select.next().val();

            if( value != '' ) {
                if( $select.is('[multiple]') ) {
                    $.each( value.split(','), function( index, val ) {
                        $select.find('option[value=' + val + ']').attr('selected', 'selected');
                    });
                }
                else {
                    $select.val( value );
                }
            }
        });

        $('.vc_oxygenna_select').change( function() {
            $(this).next().val( $(this).val() );
        });
    });
})( jQuery );