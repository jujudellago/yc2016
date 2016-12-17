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
        var $selectContainer = $( '#' + theme + '_override_header' );
        var toggleElementsSelector = '#page_header_show, #page_header_heading, #page_header_section';
        $selectContainer.change(function(){
            // show selected options
            var selectVal = $selectContainer.find( '[name="' + theme + '-options[' + theme + '_override_header]"]' ).val();
            if( selectVal,selectVal === 'override') {
                $( toggleElementsSelector ).fadeIn();
            }
            else {
                $( toggleElementsSelector ).fadeOut();
            }
        }).trigger('change');
    });
})( jQuery );