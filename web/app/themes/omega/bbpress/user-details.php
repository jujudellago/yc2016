<?php

/**
 * User Details
 *
 * @package bbPress
 * @subpackage Theme
 */

?>

	<?php do_action( 'bbp_template_before_user_details' ); ?>

	<nav class="navbar navbar-default" role="navigation">
  		<div class="container-fluid">
    		<div class="navbar-header">
      			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        			<span class="sr-only">Toggle navigation</span>
        			<span class="icon-bar"></span>
        			<span class="icon-bar"></span>
        			<span class="icon-bar"></span>
      			</button>

				<a class="navbar-brand url fn n" href="<?php bbp_user_profile_url(); ?>" title="<?php bbp_displayed_user_field( 'display_name' ); ?>" rel="me">
					<?php echo get_avatar( bbp_get_displayed_user_field( 'user_email', 'raw' ), apply_filters( 'bbp_single_user_details_avatar_size', 28 ) ); ?>
					<?php echo bbp_get_displayed_user_field( 'display_name' ); ?>
				</a>
    		</div>


    		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav">
					<li class="<?php if ( bbp_is_single_user_profile() ) :?>active<?php endif; ?>">
						<a class="url fn n" href="<?php bbp_user_profile_url(); ?>" title="<?php printf( esc_attr__( "%s's Profile", 'omega-td' ), bbp_get_displayed_user_field( 'display_name' ) ); ?>" rel="me"><?php _e( 'Profile', 'omega-td' ); ?></a>
					</li>

					<li class="<?php if ( bbp_is_single_user_topics() ) :?>active<?php endif; ?>">
						<a href="<?php bbp_user_topics_created_url(); ?>" title="<?php printf( esc_attr__( "%s's Topics Started", 'omega-td' ), bbp_get_displayed_user_field( 'display_name' ) ); ?>"><?php _e( 'Topics Started', 'omega-td' ); ?></a>
					</li>

					<li class="<?php if ( bbp_is_single_user_replies() ) :?>active<?php endif; ?>">
						<a href="<?php bbp_user_replies_created_url(); ?>" title="<?php printf( esc_attr__( "%s's Replies Created", 'omega-td' ), bbp_get_displayed_user_field( 'display_name' ) ); ?>"><?php _e( 'Replies Created', 'omega-td' ); ?></a>
					</li>

					<?php if ( bbp_is_favorites_active() ) : ?>
						<li class="<?php if ( bbp_is_favorites() ) :?>active<?php endif; ?>">
							<a href="<?php bbp_favorites_permalink(); ?>" title="<?php printf( esc_attr__( "%s's Favorites", 'omega-td' ), bbp_get_displayed_user_field( 'display_name' ) ); ?>"><?php _e( 'Favorites', 'omega-td' ); ?></a>
						</li>
					<?php endif; ?>

					<?php if ( bbp_is_user_home() || current_user_can( 'edit_users' ) ) : ?>

						<?php if ( bbp_is_subscriptions_active() ) : ?>
							<li class="<?php if ( bbp_is_subscriptions() ) :?>active<?php endif; ?>">
								<a href="<?php bbp_subscriptions_permalink(); ?>" title="<?php printf( esc_attr__( "%s's Subscriptions", 'omega-td' ), bbp_get_displayed_user_field( 'display_name' ) ); ?>"><?php _e( 'Subscriptions', 'omega-td' ); ?></a>
							</li>
						<?php endif; ?>

						<li class="<?php if ( bbp_is_single_user_edit() ) :?>active<?php endif; ?>">
							<a href="<?php bbp_user_profile_edit_url(); ?>" title="<?php printf( esc_attr__( "Edit %s's Profile", 'omega-td' ), bbp_get_displayed_user_field( 'display_name' ) ); ?>"><?php _e( 'Edit', 'omega-td' ); ?></a>
						</li>

					<?php endif; ?>

				</ul>

    		</div>
  		</div>
	</nav>

	<?php do_action( 'bbp_template_after_user_details' ); ?>
