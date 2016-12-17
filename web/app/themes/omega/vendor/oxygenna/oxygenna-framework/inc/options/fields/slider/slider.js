jQuery(document).ready(function($) {
    window.setTimeout(function() {
        $('.slider-option').each(function() {
            var $input = $(this);
            var $slider = $input.prev();
            // create slider
            $slider.slider({
                'min' : parseFloat($input.attr('min')),
                'max' : parseFloat($input.attr('max')),
                'step' : parseFloat($input.attr('step')),
                'value' : parseFloat($input.val())
            });
            // // hide the inputs after the default value on start
            // $slider.parent().nextAll().has("[id^='accordion_']").slice(0,20).show();
            // $slider.parent().nextAll().has("[id^='accordion_']").slice($input.val()*2,20).hide();

            // $slider.parent().nextAll().has("[id^='social_icon_']").slice(0,20).show();
            // $slider.parent().nextAll().has("[id^='social_icon_']").slice($input.val()*2,20).hide();
            // change input when slider slides
            $slider.bind('slide',function(e, ui) {
                $input.val(ui.value).trigger('change');
                // hide elements above the selected values.
                // $slider.parent().nextAll().has("[id^='accordion_']").slice(0,20).show();
                // $slider.parent().nextAll().has("[id^='accordion_']").slice(ui.value*2,20).hide();

                // $slider.parent().nextAll().has("[id^='social_icon_']").slice(0,20).show();
                // $slider.parent().nextAll().has("[id^='social_icon_']").slice(ui.value*2,20).hide();
            });
            // move slider with input & check input does not go beyond bounries
            $input.blur(function() {
                // check within limits
                var val = $input.val();
                if(val > $slider.slider('option', 'max')) {
                    val = $slider.slider('option', 'max');
                }
                if(val < $slider.slider('option', 'min')) {
                    val = $slider.slider('option', 'min');
                }
                // set slider to new value
                $slider.slider('value', val);
                // set input to new value (if not in limits)
                $input.val(val);
            });
        });
    }, 100);
});