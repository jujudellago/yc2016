<?php

/**
 * Topics Loop
 *
 * @package bbPress
 * @subpackage Theme
 */

?>

<?php do_action( 'bbp_template_before_topics_loop' ); ?>

<table id="bbp-forum-<?php bbp_forum_id(); ?>" class="bbp-topics table">

	<thead class="bbp-header">

		<tr class="forum-titles">
			<th class="bbp-topic-title"><?php _e( 'Topic', 'omega-td' ); ?></th>
			<th class="bbp-topic-voice-count"><?php _e( 'Voices', 'omega-td' ); ?></th>
			<th class="bbp-topic-reply-count"><?php bbp_show_lead_topic() ? _e( 'Replies', 'omega-td' ) : _e( 'Posts', 'omega-td' ); ?></th>
			<th class="bbp-topic-freshness"><?php _e( 'Freshness', 'omega-td' ); ?></th>
		</tr>

	</thead>

	<tbody class="bbp-body">

		<?php while ( bbp_topics() ) : bbp_the_topic(); ?>

			<?php bbp_get_template_part( 'loop', 'single-topic' ); ?>

		<?php endwhile; ?>

	</tbody>

	<tfoot class="bbp-footer">

		<tr>
			<td colspan="<?php echo ( bbp_is_user_home() && ( bbp_is_favorites() || bbp_is_subscriptions() ) ) ? '5' : '4'; ?>">
				<?php bbp_get_template_part( 'pagination', 'topics'    ); ?>
			</td>
		</tr><!-- .tr -->

	</tfoot>

</table><!-- #bbp-forum-<?php bbp_forum_id(); ?> -->

<?php do_action( 'bbp_template_after_topics_loop' ); ?>
