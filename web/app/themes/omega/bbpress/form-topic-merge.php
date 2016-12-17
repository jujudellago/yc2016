<?php

/**
 * Merge Topic
 *
 * @package bbPress
 * @subpackage Theme
 */

?>

<?php do_action( 'oxy-bbpress-global-top' ); ?>

<div id="bbpress-forums">

	<?php bbp_breadcrumb(); ?>

	<?php if ( is_user_logged_in() && current_user_can( 'edit_topic', bbp_get_topic_id() ) ) : ?>

		<div id="merge-topic-<?php bbp_topic_id(); ?>" class="panel panel-primary panel-bbpress bbp-topic-merge">

			<form id="merge_topic" name="merge_topic" method="post" action="<?php the_permalink(); ?>">

				<div class="panel-heading">
					<h3><?php printf( __( 'Merge topic "%s"', 'omega-td' ), bbp_get_topic_title() ); ?></h3>
				</div>

				<fieldset class="bbp-form">

					<div class="panel-body">

						<div class="alert /Users/X/Projects/Wordpress/Site/wp-content/themes/omega/bbpress
alert-warning clear info">
							<p><?php _e( 'Select the topic to merge this one into. The destination topic will remain the lead topic, and this one will change into a reply.', 'omega-td' ); ?></p>
							<p><?php _e( 'To keep this topic as the lead, go to the other topic and use the merge tool from there instead.', 'omega-td' ); ?></p>
						</div>

						<div class="alert /Users/X/Projects/Wordpress/Site/wp-content/themes/omega/bbpress
alert-warning clear">
							<p><?php _e( 'All replies within both topics will be merged chronologically. The order of the merged replies is based on the time and date they were posted. If the destination topic was created after this one, it\'s post date will be updated to second earlier than this one.', 'omega-td' ); ?></p>
						</div>

						<fieldset class="bbp-form">
							<legend><?php _e( 'Destination', 'omega-td' ); ?></legend>
							<div class="form-group">
								<?php if ( bbp_has_topics( array( 'show_stickies' => false, 'post_parent' => bbp_get_topic_forum_id( bbp_get_topic_id() ), 'post__not_in' => array( bbp_get_topic_id() ) ) ) ) : ?>

									<label for="bbp_destination_topic"><?php _e( 'Merge with this topic:', 'omega-td' ); ?></label>

									<?php
										bbp_dropdown( array(
											'post_type'   => bbp_get_topic_post_type(),
											'post_parent' => bbp_get_topic_forum_id( bbp_get_topic_id() ),
											'selected'    => -1,
											'exclude'     => bbp_get_topic_id(),
											'select_id'   => 'bbp_destination_topic'
										) );
									?>

								<?php else : ?>

									<label><?php _e( 'There are no other topics in this forum to merge with.', 'omega-td' ); ?></label>

								<?php endif; ?>

							</div>
						</fieldset>

						<fieldset class="bbp-form">
							<legend><?php _e( 'Topic Extras', 'omega-td' ); ?></legend>

							<?php if ( bbp_is_subscriptions_active() ) : ?>
								<div class="checkbox">
									<label for="bbp_topic_subscribers">
										<input name="bbp_topic_subscribers" id="bbp_topic_subscribers" type="checkbox" value="1" checked="checked" tabindex="<?php bbp_tab_index(); ?>" />
										<?php _e( 'Merge topic subscribers', 'omega-td' ); ?>
									</label>
								</div>
							<?php endif; ?>
								<div class="checkbox">
									<label for="bbp_topic_favoriters">
										<input name="bbp_topic_favoriters" id="bbp_topic_favoriters" type="checkbox" value="1" checked="checked" tabindex="<?php bbp_tab_index(); ?>" />
										<?php _e( 'Merge topic favoriters', 'omega-td' ); ?>
									</label>
								</div>
							<?php if ( bbp_allow_topic_tags() ) : ?>
								<div class="checkbox">
									<label for="bbp_topic_tags">
										<input name="bbp_topic_tags" id="bbp_topic_tags" type="checkbox" value="1" checked="checked" tabindex="<?php bbp_tab_index(); ?>" />
										<?php _e( 'Merge topic tags', 'omega-td' ); ?>
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

					<?php bbp_merge_topic_form_fields(); ?>

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