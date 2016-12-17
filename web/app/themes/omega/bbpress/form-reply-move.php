<?php

/**
 * Move Reply
 *
 * @package bbPress
 * @subpackage Theme
 */

?>

<?php do_action( 'oxy-bbpress-global-top' ); ?>

<div id="bbpress-forums">

	<?php bbp_breadcrumb(); ?>

	<?php if ( is_user_logged_in() && current_user_can( 'edit_topic', bbp_get_topic_id() ) ) : ?>

		<div id="move-reply-<?php bbp_topic_id(); ?>" class="panel panel-primary panel-bbpress bbp-reply-move">

			<form id="move_reply" name="move_reply" method="post" action="<?php the_permalink(); ?>">

				<div class="panel-heading">
					<h3><?php printf( __( 'Move reply "%s"', 'omega-td' ), bbp_get_reply_title() ); ?></h3>
				</div>

				<fieldset class="bbp-form">

					<div class="panel-body">

						<div class="alert /Users/X/Projects/Wordpress/Site/wp-content/themes/omega/bbpress
alert-warning clear info">
							<p><?php _e( 'You can either make this reply a new topic with a new title, or merge it into an existing topic.', 'omega-td' ); ?></p>
						</div>

						<div class="alert /Users/X/Projects/Wordpress/Site/wp-content/themes/omega/bbpress
alert-warning clear">
							<p><?php _e( 'If you choose an existing topic, replies will be ordered by the time and date they were created.', 'omega-td' ); ?></p>
						</div>

						<fieldset class="bbp-form">
							<legend><?php _e( 'Move Method', 'omega-td' ); ?></legend>

							<div class="radio">
								<label for="bbp_reply_move_option_reply">
									<input name="bbp_reply_move_option" id="bbp_reply_move_option_reply" type="radio" checked="checked" value="topic" tabindex="<?php bbp_tab_index(); ?>" />
									<?php printf( __( 'New topic in <strong>%s</strong> titled:', 'omega-td' ), bbp_get_forum_title( bbp_get_reply_forum_id( bbp_get_reply_id() ) ) ); ?>
								</label>
							</div>
							<div class="form-group">
								<input class="form-control" type="text" id="bbp_reply_move_destination_title" value="<?php printf( __( 'Moved: %s', 'omega-td' ), bbp_get_reply_title() ); ?>" tabindex="<?php bbp_tab_index(); ?>" size="35" name="bbp_reply_move_destination_title" />
							</div>

							<?php if ( bbp_has_topics( array( 'show_stickies' => false, 'post_parent' => bbp_get_reply_forum_id( bbp_get_reply_id() ), 'post__not_in' => array( bbp_get_reply_topic_id( bbp_get_reply_id() ) ) ) ) ) : ?>

								<div class="radio">
									<label for="bbp_reply_move_option_existing">
										<input name="bbp_reply_move_option" id="bbp_reply_move_option_existing" type="radio" value="existing" tabindex="<?php bbp_tab_index(); ?>" />
										<?php _e( 'Use an existing topic in this forum:', 'omega-td' ); ?>
									</label>
								</div>

								<div class="form-group">
									<?php
										bbp_dropdown( array(
											'post_type'   => bbp_get_topic_post_type(),
											'post_parent' => bbp_get_reply_forum_id( bbp_get_reply_id() ),
											'selected'    => -1,
											'exclude'     => bbp_get_reply_topic_id( bbp_get_reply_id() ),
											'select_id'   => 'bbp_destination_topic'
										) );
									?>

								</div>

							<?php endif; ?>

						</fieldset>

						<div class="alert /Users/X/Projects/Wordpress/Site/wp-content/themes/omega/bbpress
alert-warning clear error">
							<p><?php _e( '<strong>WARNING:</strong> This process cannot be undone.', 'omega-td' ); ?></p>
						</div>

					</div>

					<?php bbp_move_reply_form_fields(); ?>

					<div class="panel-footer">
						<div class="bbp-submit-wrapper">
							<button type="submit" tabindex="<?php bbp_tab_index(); ?>" id="bbp_move_reply_submit" name="bbp_move_reply_submit" class="button submit"><?php _e( 'Submit', 'omega-td' ); ?></button>
						</div>
					</div>

				</fieldset>
			</form>
		</div>

	<?php else : ?>

		<div id="no-reply-<?php bbp_reply_id(); ?>" class="bbp-no-reply">
			<div class="entry-content"><?php is_user_logged_in() ? _e( 'You do not have the permissions to edit this reply!', 'omega-td' ) : _e( 'You cannot edit this reply.', 'omega-td' ); ?></div>
		</div>

	<?php endif; ?>

</div>


<?php do_action( 'oxy-bbpress-global-bottom' ); ?>