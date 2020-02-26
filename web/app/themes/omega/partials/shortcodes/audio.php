<?php
/**
 * Audop Shortcode
 *
 * @package Omega
 * @subpackage Admin
 * @since 0.1
 *
 * @copyright (c) 2014 Oxygenna.com
 * @license **LICENSE**
 * @version 1.18.14
 */
?>
<div class="<?php echo implode( ' ', $classes ); ?>" data-os-animation="<?php echo $atts['scroll_animation']; ?>" data-os-animation-delay="<?php echo $atts['scroll_animation_delay']; ?>s">
    <?php echo wp_audio_shortcode( $atts, $content ); ?>
</div>