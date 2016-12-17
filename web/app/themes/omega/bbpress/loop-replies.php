<?php

/**
 * Replies Loop
 *
 * @package bbPress
 * @subpackage Theme
 */

?>

<?php do_action( 'bbp_template_before_replies_loop' ); ?>

<div id="topic-<?php bbp_topic_id(); ?>-replies" class="forums bbp-replies">

    <div class="clearfix">
        <?php bbp_topic_tag_list(); ?>

        <div class="bbp-replies-actions">
            <?php bbp_topic_subscription_link( array('before' => '')); ?>
            <?php bbp_user_favorites_link(); ?>
        </div>

    </div>


	<ul class="media-list bbp-body">

		<?php if ( bbp_thread_replies() ) : ?>

			<?php bbp_list_replies(); ?>

		<?php else : ?>

			<?php while ( bbp_replies() ) : bbp_the_reply(); ?>

				<?php bbp_get_template_part( 'loop', 'single-reply' ); ?>

			<?php endwhile; ?>

		<?php endif; ?>

	</ul><!-- .bbp-body -->

</div><!-- #topic-<?php bbp_topic_id(); ?>-replies -->

<?php do_action( 'bbp_template_after_replies_loop' ); ?>
