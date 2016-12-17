<?php

/**
 * User Profile
 *
 * @package bbPress
 * @subpackage Theme
 */

?>

	<?php do_action( 'bbp_template_before_user_profile' ); ?>

	<div id="bbp-user-profile" class="bbp-user-profile panel panel-primary panel-bbpress">

		<div class="panel-heading">
			<?php _e( 'Profile', 'omega-td' ); ?>
		</div>

		<div class="panel-body">

			<?php if ( bbp_get_displayed_user_field( 'description' ) ) : ?>

				<p class="bbp-user-description"><?php bbp_displayed_user_field( 'description' ); ?></p>

			<?php endif; ?>

			<dl>
				<dt><?php _e( 'Forum Role', 'omega-td' ); ?></dt>
				<dd><?php echo bbp_get_user_display_role(); ?></dd>
				<dt><?php _e( 'Topics Started', 'omega-td' ); ?></dt>
				<dd><?php echo bbp_get_user_topic_count_raw(); ?></dd>
				<dt><?php _e( 'Replies Created', 'omega-td' ); ?></dt>
				<dd><?php echo bbp_get_user_reply_count_raw(); ?></dd>
			</dl>

		</div>

	</div><!-- #bbp-author-topics-started -->

	<?php do_action( 'bbp_template_after_user_profile' ); ?>
