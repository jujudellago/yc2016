<?php

/**
 * Forums Loop
 *
 * @package bbPress
 * @subpackage Theme
 */

?>

<?php do_action( 'bbp_template_before_forums_loop' ); ?>

<table id="forums-list-<?php bbp_forum_id(); ?>" class="table bbp-forums">

	<thead class="bbp-header">

		<tr class="forum-titles">
			<th class="bbp-forum-info"><?php _e( 'Forum', 'omega-td' ); ?></th>
			<th class="bbp-forum-topic-count"><?php _e( 'Topics', 'omega-td' ); ?></th>
			<th class="bbp-forum-reply-count"><?php bbp_show_lead_topic() ? _e( 'Repthes', 'omega-td' ) : _e( 'Posts', 'omega-td' ); ?></th>
			<th class="bbp-forum-freshness"><?php _e( 'Freshness', 'omega-td' ); ?></th>
		</tr>

	</thead><!-- .bbp-header -->

	<tbody class="bbp-body">

		<?php while ( bbp_forums() ) : bbp_the_forum(); ?>

			<?php bbp_get_template_part( 'loop', 'single-forum' ); ?>

		<?php endwhile; ?>

	</tbody><!-- .bbp-body -->

	<tfoot class="bbp-footer">

		<tr>
			<td colspan="4">&nbsp;</td>
		</tr><!-- .tr -->

	</tfoot><!-- .bbp-footer -->

</table><!-- .forums-directory -->

<?php do_action( 'bbp_template_after_forums_loop' ); ?>
