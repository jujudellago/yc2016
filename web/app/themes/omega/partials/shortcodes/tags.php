 <?php
/**
 * Tags shortcode
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
<ul class="<?php echo implode(' ', $classes); ?>" data-os-animation="<?php echo $scroll_animation; ?>" data-os-animation-delay="<?php echo $scroll_animation_delay; ?>s">
<?php
	foreach( $tags as $tag ) : ?>
		<li>
            <span>
                <?php echo $tag; ?>
            </span>
		</li><?php
	endforeach; ?>
</ul>