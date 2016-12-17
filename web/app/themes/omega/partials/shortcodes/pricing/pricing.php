<div class="<?php echo implode( ' ', $classes ); ?>" data-os-animation="<?php echo $scroll_animation; ?>" data-os-animation-delay="<?php echo $scroll_animation_delay; ?>s">
    <?php
    if( $heading !== "" ) : ?>
    <h2 class="pricing-head" style="background: <?php echo $pricing_background_colour; ?>; color:<?php echo $pricing_foreground_colour; ?>"><?php echo $heading; ?></h2>
    <?php
    endif; ?>
    <div class="pricing-body" style="background: <?php echo $pricing_background_colour; ?>; color:<?php echo $pricing_foreground_colour; ?>">
        <?php
        if( $show_price === 'true' ) : ?>
        <div class="pricing-price" >
            <h4 style="background: <?php echo $pricing_background; ?>; color: <?php echo $pricing_colour; ?>;">
                <?php
                if( $currency === 'custom' ) : ?>
                <small style="color: <?php echo $pricing_colour; ?>;"><?php echo $custom_currency; ?></small>
                <?php
                else : ?>
                <small style="color: <?php echo $pricing_colour; ?>;"><?php echo $currency; ?></small>
                <?php
                endif; ?>
                <?php echo $price; ?>
                <small style="color: <?php echo $pricing_colour; ?>;"><?php echo $per; ?></small>
            </h4>
        </div>
        <?php
        endif; ?>
        <ul class="pricing-list">
        <?php
        foreach( $list as $item ) : ?>
            <li style="border-color: <?php echo oxy_hex2rgba($pricing_foreground_colour, .10); ?>"><?php echo $item; ?></li>
        <?php
        endforeach; ?>
        </ul>
        <?php
        if( $show_button === 'true' ) : ?>
        <a href="<?php echo $button_link; ?>" class="btn btn-lg" style="background: <?php echo $button_background_colour; ?>; color: <?php echo $button_foreground_colour; ?>;"><?php echo $button_text; ?></a>
        <?php
        endif; ?>
    </div>
</div>