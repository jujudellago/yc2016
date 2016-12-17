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
        var $slideshowType       = $('[name="accordion-content-Slideshow"]').find('#type');
        var $selectContainer     = $slideshowType.closest('.option');
        var $captionsContainer   = $('[name="accordion-header-Captions"]');
        var $revolutionContainer = $('[name="accordion-content-Slideshow"]').find('#revolution').closest('.option');

        $slideshowType.change(function(){
            // hide all controls after the select
            $selectContainer.nextAll().hide();
            $captionsContainer.hide();

            // // show selected options
            switch( $slideshowType.val() ) {
                case 'revolution':
                    $selectContainer.nextAll().hide();
                    $revolutionContainer.show();
                    $captionsContainer.hide();
                break;
                case 'flexslider':
                    $selectContainer.nextAll().show();
                    $revolutionContainer.hide();
                    $captionsContainer.show();
                break;
            }
        }).trigger('change');
    });
})( jQuery );