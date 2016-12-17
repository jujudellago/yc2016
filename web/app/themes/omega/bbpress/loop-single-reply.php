<?php

/**
 * Replies Loop - Single Reply
 *
 * @package bbPress
 * @subpackage Theme
 */


$reply_id = bbp_get_reply_id();
$user_id = bbp_get_reply_author_id( $reply_id ) ;
$topic_count  = bbp_get_user_topic_count_raw( $user_id);
$reply_count = bbp_get_user_reply_count_raw( $user_id);
$post_count   = (int) $topic_count + $reply_count;
?>


<li id="post-<?php bbp_reply_id(); ?>" <?php bbp_reply_class(0, array('media')); ?>>

	<?php do_action( 'bbp_theme_before_reply_author_details' ); ?>

	<div class="bbp_author_details">
        <?php bbp_reply_author_link( array( 'sep' => '', 'size' => 92 ) ); ?>

        <?php bbp_reply_author_role(); ?>

		<span class="post-count">
			<?php echo $post_count; ?>
		</span>

		<?php if ( bbp_is_user_keymaster() ) : ?>

			<?php do_action( 'bbp_theme_before_reply_author_admin_details' ); ?>

			<span class="label label-bbpress" class="bbp-reply-ip"><?php bbp_author_ip( bbp_get_reply_id() ); ?></span>

			<?php do_action( 'bbp_theme_after_reply_author_admin_details' ); ?>

		<?php endif; ?>
    </div>

	<?php do_action( 'bbp_theme_after_reply_author_details' ); ?>

	<div class="media-body bbp-reply-content">
		<h3 class="media-heading">
			<span class="bbp-reply-post-date"><?php bbp_reply_post_date(); ?></span>
			<span class="label label-primary pull-right">
				<a href="<?php bbp_reply_url(); ?>" class="bbp-reply-permalink">#<?php bbp_reply_id(); ?></a>
			</span>

		</h3>

		<?php do_action( 'bbp_theme_before_reply_content' ); ?>

		<?php bbp_reply_content(); ?>

		<?php do_action( 'bbp_theme_after_reply_content' ); ?>

	    <div class="media-footer bbp-meta">

	        <?php if ( bbp_is_single_user_replies() ) : ?>

	            <span class="bbp-header">
	                <?php _e( 'in reply to: ', 'omega-td' ); ?>
	                <a class="bbp-topic-permalink" href="<?php bbp_topic_permalink( bbp_get_reply_topic_id() ); ?>"><?php bbp_topic_title( bbp_get_reply_topic_id() ); ?></a>
	            </span>

	        <?php endif; ?>

			<?php if (!bbp_is_search()): ?>

		        <?php do_action( 'bbp_theme_before_reply_admin_links' ); ?>

		        <?php bbp_reply_admin_links(array('sep' => '&nbsp;')); ?>

		        <?php do_action( 'bbp_theme_after_reply_admin_links' ); ?>

	        <?php endif ?>

	    </div><!-- .bbp-meta -->

	</div>

</li><!-- .reply -->
