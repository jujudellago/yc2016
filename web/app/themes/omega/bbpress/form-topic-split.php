<?php

/**
 * Split Topic
 *
 * @package bbPress
 * @subpackage Theme
 */

?>

<?php do_action( 'oxy-bbpress-global-top' ); ?>

<div id="bbpress-forums">

	<?php bbp_breadcrumb(); ?>

	<?php if ( is_user_logged_in() && current_user_can( 'edit_topic', bbp_get_topic_id() ) ) : ?>

		<div id="split-topic-<?php bbp_topic_id(); ?>" class="panel panel-primary panel-bbpress bbp-topic-split">

			<form id="split_topic" name="split_topic" method="post" action="<?php the_permalink(); ?>">

				<fieldset class="bbp-form">

					<div class="panel-heading">
						<h3><?php printf( __( 'Split topic "%s"', 'omega-td' ), bbp_get_topic_title() ); ?></h3>
					</div>

					<div class="panel-body">

						<div class="alert /Users/X/Projects/Wordpress/Site/wp-content/themes/omega/bbpress
alert-warning clear info">
							<p><?php _e( 'When you split a topic, you are slicing it in half starting with the reply you just selected. Choose to use that reply as a new topic with a new title, or merge those replies into an existing topic.', 'omega-td' ); ?></p>
						</div>

						<div class="alert /Users/X/Projects/Wordpress/Site/wp-content/themes/omega/bbpress
alert-warning clear">
							<p><?php _e( 'If you use the existing topic option, replies within both topics will be merged chronologically. The order of the merged replies is based on the time and date they were posted.', 'omega-td' ); ?></p>
						</div>

						<fieldset class="bbp-form">
							<legend><?php _e( 'Split Method', 'omega-td' ); ?></legend>

							<div class="radio">
								<label for="bbp_topic_split_option_reply">
									<input name="bbp_topic_split_option" id="bbp_topic_split_option_reply" type="radio" checked="checked" value="reply" tabindex="<?php bbp_tab_index(); ?>" />
									<?php printf( __( 'New topic in <strong>%s</strong> titled:', 'omega-td' ), bbp_get_forum_title( bbp_get_topic_forum_id( bbp_get_topic_id() ) ) ); ?>
								</label>
							</div>
							<div class="form-group">
								<input class="form-control" type="text" id="bbp_topic_split_destination_title" value="<?php printf( __( 'Split: %s', 'omega-td' ), bbp_get_topic_title() ); ?>" tabindex="<?php bbp_tab_index(); ?>" size="35" name="bbp_topic_split_destination_title" />
							</div>

							<?php if ( bbp_has_topics( array( 'show_stickies' => false, 'post_parent' => bbp_get_topic_forum_id( bbp_get_topic_id() ), 'post__not_in' => array( bbp_get_topic_id() ) ) ) ) : ?>

								<div class="radio">
									<label for="bbp_topic_split_option_existing">
										<input name="bbp_topic_split_option" id="bbp_topic_split_option_existing" type="radio" value="existing" tabindex="<?php bbp_tab_index(); ?>" />
										<?php _e( 'Use an existing topic in this forum:', 'omega-td' ); ?>
									</label>
								</div>

								<div class="form-group">

									<?php
										bbp_dropdown( array(
											'post_type'   => bbp_get_topic_post_type(),
											'post_parent' => bbp_get_topic_forum_id( bbp_get_topic_id() ),
											'selected'    => -1,
											'exclude'     => bbp_get_topic_id(),
											'select_id'   => 'bbp_destination_topic'
										) );
									?>

								</div>

							<?php endif; ?>

						</fieldset>

						<fieldset class="bbp-form">
							<legend><?php _e( 'Topic Extras', 'omega-td' ); ?></legend>

							<?php if ( bbp_is_subscriptions_active() ) : ?>
								<div class="checkbox">
									<label for="bbp_topic_subscribers">
										<input name="bbp_topic_subscribers" id="bbp_topic_subscribers" type="checkbox" value="1" checked="checked" tabindex="<?php bbp_tab_index(); ?>" />
										<?php _e( 'Copy subscribers to the new topic', 'omega-td' ); ?>
									</label>
								</div>
							<?php endif; ?>

							<div class="checkbox">
								<label for="bbp_topic_favoriters">
									<input name="bbp_topic_favoriters" id="bbp_topic_favoriters" type="checkbox" value="1" checked="checked" tabindex="<?php bbp_tab_index(); ?>" />
									<?php _e( 'Copy favoriters to the new topic', 'omega-td' ); ?>
								</label>
							</div>

							<?php if ( bbp_allow_topic_tags() ) : ?>

								<div class="checkbox">
									<label for="bbp_topic_tags">
										<input name="bbp_topic_tags" id="bbp_topic_tags" type="checkbox" value="1" checked="checked" tabindex="<?php bbp_tab_index(); ?>" />
										<?php _e( 'Copy topic tags to the new topic', 'omega-td' ); ?>
									</label>
								</div>

							<?php endif; ?>

						</fieldset>

						<div class="alert /Users/X/Projects/Wordpress/Site/wp-content/themes/omega/bbpress
alert-warning clear error">
							<p><?php _e( '<strong>WARNING:</strong> This process cannot be undone.', 'omega-td' ); ?></p>
						</div>

					</div>

					<div class="panel-footer">
						<div class="bbp-submit-wrapper">
							<button type="submit" tabindex="<?php bbp_tab_index(); ?>" id="bbp_merge_topic_submit" name="bbp_merge_topic_submit" class="button submit"><?php _e( 'Submit', 'omega-td' ); ?></button>
						</div>
					</div>

					<?php bbp_split_topic_form_fields(); ?>

				</fieldset>
			</form>
		</div>

	<?php else : ?>

		<div id="no-topic-<?php bbp_topic_id(); ?>" class="bbp-no-topic">
			<div class="entry-content"><?php is_user_logged_in() ? _e( 'You do not have the permissions to edit this topic!', 'omega-td' ) : _e( 'You cannot edit this topic.', 'omega-td' ); ?></div>
		</div>

	<?php endif; ?>

</div>

<?php do_action( 'oxy-bbpress-global-bottom' ); ?>