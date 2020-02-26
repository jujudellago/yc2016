<?php
/**
 * Adds navigation for single testimonial post of the same group
 *
 * @package Omega
 * @subpackage Admin
 * @since 0.1
 *
 * @copyright (c) 2014 Oxygenna.com
 * @license **LICENSE**
 * @version 1.18.14
 */
$extra_post_class  = oxy_get_option('blog_post_icons') == 'on' ? 'post-showinfo' : '';
$prev_post = get_adjacent_post(true, '', true, 'oxy_testimonial_group');
$next_post = get_adjacent_post(true, '', false, 'oxy_testimonial_group');
?>
<nav id="nav-below" class="post-navigation <?php echo $extra_post_class; ?>">
    <ul class="pager">
        <?php if( !empty($prev_post) ) : ?>
            <li class="previous">
                <a class="btn btn-primary btn-icon btn-icon-left" rel="prev" href="<?php echo get_permalink($prev_post); ?>">
                    <i class="fa fa-angle-left"></i>
                    <?php _e( 'Previous', 'omega-td' ); ?>
                </a>
            </li>
        <?php endif; ?>

        <?php if( !empty($next_post) ) : ?>
            <li class="next">
                <a class="btn btn-primary btn-icon btn-icon-right" rel="next" href="<?php echo get_permalink($next_post); ?>">
                    <?php _e( 'Next', 'omega-td' ); ?>
                    <i class="fa fa-angle-right"></i>
                </a>
            </li>
        <?php endif; ?>
    </ul>
</nav><!-- nav-below -->
