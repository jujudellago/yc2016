<?php

/**
 * User Replies Created
 *
 * @package bbPress
 * @subpackage Theme
 */

?>

	<?php do_action( 'bbp_template_before_user_replies' ); ?>

	<div id="bbp-user-replies-created" class="bbp-user-replies-created panel panel-primary panel-bbpress">
		<div class="panel-heading">
			<?php _e( 'Forum Replies Created', 'omega-td' ); ?></h2>
		</div>

		<div class="bbp-user-section panel-body">

			<?php if ( bbp_get_user_replies_created() ) : ?>

				<?php bbp_get_template_part( 'loop',       'replies' ); ?>

			<?php else : ?>

				<p><?php bbp_is_user_home() ? _e( 'You have not replied to any topics.', 'omega-td' ) : _e( 'This user has not replied to any topics.', 'omega-td' ); ?></p>

			<?php endif; ?>

		</div>

		<div class="panel-footer">
			<?php bbp_get_template_part( 'pagination', 'replies' ); ?>
		</div>
	</div><!-- #bbp-user-replies-created -->

	<?php do_action( 'bbp_template_after_user_replies' ); ?>
