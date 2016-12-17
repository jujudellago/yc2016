jQuery(document).ready(function($) {
    function setInputColor($input, color) {
        if(null !== color) {
            if(color.getAlpha() !== 1) {
                $input.attr('value', color.toRgbString());
            }
            else {
                $input.attr('value', color.toHexString());
            }
        }
        else {
            $input.attr('value', '');
        }
        $input.trigger('change');
    }

    // set color picker input
    $('.colour-option').each(function(){
        var $input = $(this);
        $input.spectrum({
            clickoutFiresChange: true,
            showButtons: false,
            showInput: true,
            showAlpha: $input.hasClass('format-rgba'),
            allowEmpty: $input.hasClass('allow-empty'),
            preferredFormat: 'hex',
            move: function(color) {
                setInputColor($input, color);
            },
            change: function(color) {
                setInputColor($input, color);
            }
        });
    });
});