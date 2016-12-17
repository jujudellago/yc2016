<?php

/**
 * bbPress User Profile Edit Part
 *
 * @package bbPress
 * @subpackage Theme
 */

?>

<form id="bbp-your-profile" action="<?php bbp_user_profile_edit_url( bbp_get_displayed_user_id() ); ?>" method="post" enctype="multipart/form-data">

	<div class="panel panel-primary panel-bbpress">
		<div class="panel-heading">
			<?php _e( 'Edit User', 'omega-td' ) ?>
		</div>

		<?php do_action( 'bbp_user_edit_before' ); ?>

		<div class="panel-body">
			<fieldset class="bbp-form">
				<legend><?php _e( 'User Info', 'omega-td' ) ?></legend>

				<?php do_action( 'bbp_user_edit_before_name' ); ?>

				<div class="form-group">
					<label for="first_name"><?php _e( 'First Name', 'omega-td' ) ?></label>
					<input type="text" name="first_name" id="first_name" value="<?php bbp_displayed_user_field( 'first_name', 'edit' ); ?>" class="regular-text form-control" tabindex="<?php bbp_tab_index(); ?>" />
				</div>

				<div class="form-group">
					<label for="last_name"><?php _e( 'Last Name', 'omega-td' ) ?></label>
					<input type="text" name="last_name" id="last_name" value="<?php bbp_displayed_user_field( 'last_name', 'edit' ); ?>" class="regular-text form-control" tabindex="<?php bbp_tab_index(); ?>" />
				</div>

				<div class="form-group">
					<label for="nickname"><?php _e( 'Nickname', 'omega-td' ); ?></label>
					<input type="text" name="nickname" id="nickname" value="<?php bbp_displayed_user_field( 'nickname', 'edit' ); ?>" class="regular-text form-control" tabindex="<?php bbp_tab_index(); ?>" />
				</div>

				<div class="form-group">
					<label for="display_name"><?php _e( 'Display Name', 'omega-td' ) ?></label>

					<?php
						ob_start();
						bbp_edit_user_display_name();
    					$select = ob_get_contents();
    					ob_end_clean();
    					$select = str_replace('<select', '<select class="form-control"', $select);
    					echo $select;
					?>

				</div>

				<?php do_action( 'bbp_user_edit_after_name' ); ?>

			</fieldset>

			<fieldset class="bbp-form">
				<legend><?php _e( 'Contact Info', 'omega-td' ) ?></legend>

				<?php do_action( 'bbp_user_edit_before_contact' ); ?>

				<div class="form-group">
					<label for="url"><?php _e( 'Website', 'omega-td' ) ?></label>
					<input type="text" name="url" id="url" value="<?php bbp_displayed_user_field( 'user_url', 'edit' ); ?>" class="regular-text code form-control" tabindex="<?php bbp_tab_index(); ?>" />
				</div>

				<?php foreach ( bbp_edit_user_contact_methods() as $name => $desc ) : ?>

					<div class="form-group">
						<label for="<?php echo esc_attr( $name ); ?>"><?php echo apply_filters( 'user_' . $name . '_label', $desc ); ?></label>
						<input type="text" name="<?php echo esc_attr( $name ); ?>" id="<?php echo esc_attr( $name ); ?>" value="<?php bbp_displayed_user_field( $name, 'edit' ); ?>" class="regular-text form-control" tabindex="<?php bbp_tab_index(); ?>" />
					</div>

				<?php endforeach; ?>

				<?php do_action( 'bbp_user_edit_after_contact' ); ?>

			</fieldset>

			<fieldset class="bbp-form">
				<legend><?php bbp_is_user_home_edit() ? _e( 'About Yourself', 'omega-td' ) : _e( 'About the user', 'omega-td' ); ?></legend>

				<?php do_action( 'bbp_user_edit_before_about' ); ?>

				<div class="form-group">
					<label for="description"><?php _e( 'Biographical Info', 'omega-td' ); ?></label>
					<textarea name="description" class="form-control" id="description" rows="5" cols="30" tabindex="<?php bbp_tab_index(); ?>"><?php bbp_displayed_user_field( 'description', 'edit' ); ?></textarea>
				</div>

				<?php do_action( 'bbp_user_edit_after_about' ); ?>

			</fieldset>

			<fieldset class="bbp-form">
				<legend><?php _e( 'Account', 'omega-td' ) ?></legend>

				<?php do_action( 'bbp_user_edit_before_account' ); ?>

				<div class="form-group">
					<label for="user_login"><?php _e( 'Username', 'omega-td' ); ?></label>
					<input type="text" name="user_login" id="user_login" value="<?php bbp_displayed_user_field( 'user_login', 'edit' ); ?>" disabled="disabled" class="regular-text form-control" tabindex="<?php bbp_tab_index(); ?>" />
				</div>

				<div class="form-group">
					<label for="email"><?php _e( 'Email', 'omega-td' ); ?></label>

					<input type="text" name="email" id="email" value="<?php bbp_displayed_user_field( 'user_email', 'edit' ); ?>" class="regular-text form-control" tabindex="<?php bbp_tab_index(); ?>" />

					<?php

					// Handle address change requests
					$new_email = get_option( bbp_get_displayed_user_id() . '_new_email' );
					if ( !empty( $new_email ) && $new_email !== bbp_get_displayed_user_field( 'user_email', 'edit' ) ) : ?>

						<span class="updated inline">

							<?php printf( __( 'There is a pending email address change to <code>%1$s</code>. <a href="%2$s">Cancel</a>', 'omega-td' ), $new_email['newemail'], esc_url( self_admin_url( 'user.php?dismiss=' . bbp_get_current_user_id()  . '_new_email' ) ) ); ?>

						</span>

					<?php endif; ?>

				</div>

				<div id="password">
					<label for="pass1"><?php _e( 'New Password', 'omega-td' ); ?></label>
					<fieldset class="bbp-form password">
						<div class="form-group">
							<input class="form-control" type="password" name="pass1" id="pass1" size="16" value="" autocomplete="off" tabindex="<?php bbp_tab_index(); ?>" />
							<span class="help-block"><?php _e( 'If you would like to change the password type a new one. Otherwise leave this blank.', 'omega-td' ); ?></span>
						</div>

						<div class="form-group">
							<input class="form-control" type="password" name="pass2" id="pass2" size="16" value="" autocomplete="off" tabindex="<?php bbp_tab_index(); ?>" />
							<span class="help-block"><?php _e( 'Type your new password again.', 'omega-td' ); ?></span><br />
						</div>

						<div id="pass-strength-result"></div>
						<span class="help-block indicator-hint"><?php _e( 'Your password should be at least ten characters long. Use upper and lower case letters, numbers, and symbols to make it even stronger.', 'omega-td' ); ?></span>
					</fieldset>
				</div>

				<?php do_action( 'bbp_user_edit_after_account' ); ?>

			</fieldset>

			<?php if ( current_user_can( 'edit_users' ) && ! bbp_is_user_home_edit() ) : ?>

				<fieldset class="bbp-form">
					<legend><?php _e( 'User Role', 'omega-td' ); ?></legend>

					<?php do_action( 'bbp_user_edit_before_role' ); ?>

					<?php if ( is_multisite() && is_super_admin() && current_user_can( 'manage_network_options' ) ) : ?>

						<div class="checkbox">
							<label for="super_admin"><?php _e( 'Network Role', 'omega-td' ); ?></label>
							<label>
								<input class="checkbox" type="checkbox" id="super_admin" name="super_admin"<?php checked( is_super_admin( bbp_get_displayed_user_id() ) ); ?> tabindex="<?php bbp_tab_index(); ?>" />
								<?php _e( 'Grant this user super admin privileges for the Network.', 'omega-td' ); ?>
							</label>
						</div>

					<?php endif; ?>

					<?php bbp_get_template_part( 'form', 'user-roles' ); ?>

					<?php do_action( 'bbp_user_edit_after_role' ); ?>

				</fieldset>

			<?php endif; ?>

			<?php do_action( 'bbp_user_edit_after' ); ?>
		</div>

		<div class="panel-footer">
			<?php bbp_edit_user_form_fields(); ?>

			<button type="submit" tabindex="<?php bbp_tab_index(); ?>" id="bbp_user_edit_submit" name="bbp_user_edit_submit" class="button submit user-submit"><?php bbp_is_user_home_edit() ? _e( 'Update Profile', 'omega-td' ) : _e( 'Update User', 'omega-td' ); ?></button>
		</div>
	</div>
</form>