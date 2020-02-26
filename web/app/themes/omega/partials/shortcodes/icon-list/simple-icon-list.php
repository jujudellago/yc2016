<?php
/**
 * Simple Icon List shortcode partial
 *
 * @package Omega
 * @subpackage Frontend
 * @since 1.01
 *
 * @copyright (c) 2014 Oxygenna.com
 * @license **LICENSE**
 * @version 1.18.14
 */
?>
<ul class="fa-ul <?php echo implode( ' ', $classes ); ?>" data-os-animation="<?php echo $scroll_animation; ?>" data-os-animation-delay="<?php echo $scroll_animation_delay; ?>s">
    <?php echo do_shortcode( $content ); ?>
</ul>