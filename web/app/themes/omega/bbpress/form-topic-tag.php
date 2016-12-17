<?php

/**
 * Edit Topic Tag
 *
 * @package bbPress
 * @subpackage Theme
 */

?>

<?php if ( current_user_can( 'edit_topic_tags' ) ) : ?>

	<div id="edit-topic-tag-<?php bbp_topic_tag_id(); ?>" class="bbp-topic-tag-form">

		<fieldset class="bbp-form" id="bbp-edit-topic-tag">

			<legend><?php printf( __( 'Manage Tag: "%s"', 'omega-td' ), bbp_get_topic_tag_name() ); ?></legend>

			<fieldset class="bbp-form" id="tag-rename">

				<legend><?php _e( 'Rename', 'omega-td' ); ?></legend>

				<div class="alert /Users/X/Projects/Wordpress/Site/wp-content/themes/omega/bbpress
alert-warning clear info">
					<p><?php _e( 'Leave the slug empty to have one automatically generated.', 'omega-td' ); ?></p>
				</div>

				<div class="alert /Users/X/Projects/Wordpress/Site/wp-content/themes/omega/bbpress
alert-warning clear">
					<p><?php _e( 'Changing the slug affects its permalink. Any links to the old slug will stop working.', 'omega-td' ); ?></p>
				</div>

				<form id="rename_tag" name="rename_tag" method="post" action="<?php the_permalink(); ?>">

					<div>
						<label for="tag-name"><?php _e( 'Name:', 'omega-td' ); ?></label>
						<input type="text" id="tag-name" name="tag-name" size="20" maxlength="40" tabindex="<?php bbp_tab_index(); ?>" value="<?php echo esc_attr( bbp_get_topic_tag_name() ); ?>" />
					</div>

					<div>
						<label for="tag-slug"><?php _e( 'Slug:', 'omega-td' ); ?></label>
						<input type="text" id="tag-slug" name="tag-slug" size="20" maxlength="40" tabindex="<?php bbp_tab_index(); ?>" value="<?php echo esc_attr( apply_filters( 'editable_slug', bbp_get_topic_tag_slug() ) ); ?>" />
					</div>

					<div class="bbp-submit-wrapper">
						<button type="submit" tabindex="<?php bbp_tab_index(); ?>" class="button submit"><?php esc_attr_e( 'Update', 'omega-td' ); ?></button>

						<input type="hidden" name="tag-id" value="<?php bbp_topic_tag_id(); ?>" />
						<input type="hidden" name="action" value="bbp-update-topic-tag" />

						<?php wp_nonce_field( 'update-tag_' . bbp_get_topic_tag_id() ); ?>

					</div>
				</form>

			</fieldset>

			<fieldset class="bbp-form" id="tag-merge">

				<legend><?php _e( 'Merge', 'omega-td' ); ?></legend>

				<div class="alert /Users/X/Projects/Wordpress/Site/wp-content/themes/omega/bbpress
alert-warning clear">
					<p><?php _e( 'Merging tags together cannot be undone.', 'omega-td' ); ?></p>
				</div>

				<form id="merge_tag" name="merge_tag" method="post" action="<?php the_permalink(); ?>">

					<div>
						<label for="tag-existing-name"><?php _e( 'Existing tag:', 'omega-td' ); ?></label>
						<input type="text" id="tag-existing-name" name="tag-existing-name" size="22" tabindex="<?php bbp_tab_index(); ?>" maxlength="40" />
					</div>

					<div class="bbp-submit-wrapper">
						<button type="submit" tabindex="<?php bbp_tab_index(); ?>" class="button submit" onclick="return confirm('<?php echo esc_js( sprintf( __( 'Are you sure you want to merge the "%s" tag into the tag you specified?', 'omega-td' ), bbp_get_topic_tag_name() ) ); ?>');"><?php esc_attr_e( 'Merge', 'omega-td' ); ?></button>

						<input type="hidden" name="tag-id" value="<?php bbp_topic_tag_id(); ?>" />
						<input type="hidden" name="action" value="bbp-merge-topic-tag" />

						<?php wp_nonce_field( 'merge-tag_' . bbp_get_topic_tag_id() ); ?>
					</div>
				</form>

			</fieldset>

			<?php if ( current_user_can( 'delete_topic_tags' ) ) : ?>

				<fieldset class="bbp-form" id="delete-tag">

					<legend><?php _e( 'Delete', 'omega-td' ); ?></legend>

					<div class="alert /Users/X/Projects/Wordpress/Site/wp-content/themes/omega/bbpress
alert-warning clear info">
						<p><?php _e( 'This does not delete your topics. Only the tag itself is deleted.', 'omega-td' ); ?></p>
					</div>
					<div class="alert /Users/X/Projects/Wordpress/Site/wp-content/themes/omega/bbpress
alert-warning clear">
						<p><?php _e( 'Deleting a tag cannot be undone.', 'omega-td' ); ?></p>
						<p><?php _e( 'Any links to this tag will no longer function.', 'omega-td' ); ?></p>
					</div>

					<form id="delete_tag" name="delete_tag" method="post" action="<?php the_permalink(); ?>">

						<div class="bbp-submit-wrapper">
							<button type="submit" tabindex="<?php bbp_tab_index(); ?>" class="button submit" onclick="return confirm('<?php echo esc_js( sprintf( __( 'Are you sure you want to delete the "%s" tag? This is permanent and cannot be undone.', 'omega-td' ), bbp_get_topic_tag_name() ) ); ?>');"><?php esc_attr_e( 'Delete', 'omega-td' ); ?></button>

							<input type="hidden" name="tag-id" value="<?php bbp_topic_tag_id(); ?>" />
							<input type="hidden" name="action" value="bbp-delete-topic-tag" />

							<?php wp_nonce_field( 'delete-tag_' . bbp_get_topic_tag_id() ); ?>
						</div>
					</form>

				</fieldset>

			<?php endif; ?>

		</fieldset>
	</div>

<?php endif; ?>
