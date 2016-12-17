<h1 class="countdown <?php echo implode(' ', $classes); ?>" data-date="<?php echo $date; ?>" data-os-animation="<?php echo $scroll_animation; ?>" data-os-animation-delay="<?php echo $scroll_animation_delay; ?>s">
    <div class="counter-element">
        <span class="counter-days odometer text-center <?php echo $number_underline;?>">
            0
        </span>
        <b>
            <?php _e('days', 'omega-td'); ?>
        </b>
    </div>
    <div class="counter-element">
        <span class="counter-hours odometer text-center <?php echo $number_underline;?>">
            0
        </span>
        <b>
            <?php _e('hours', 'omega-td'); ?>
        </b>
    </div>
    <div class="counter-element">
        <span class="counter-minutes odometer text-center <?php echo $number_underline;?>">
            0
        </span>
        <b>
            <?php _e('minutes', 'omega-td'); ?>
        </b>
    </div>
    <div class="counter-element">
        <span class="counter-seconds odometer text-center <?php echo $number_underline;?>">
            0
        </span>
        <b>
            <?php _e('seconds', 'omega-td'); ?>
        </b>
    </div>
</h1>