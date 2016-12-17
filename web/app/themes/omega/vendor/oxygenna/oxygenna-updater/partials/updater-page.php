<div class="wrap oxygenna-options-page">
    <h2><?php _e('Theme Updates', 'omega-admin-td'); ?></h2>
    <p><?php _e('Enter your ThemeForest username and API key here to recieve future updates to the theme.', 'omega-admin-td'); ?></p>

    <div id="ajax-errors-here"></div>

    <div class="white-box">

        <div class="left-part half">

            <form class="big-form" action="<?php echo $credentials_form_url; ?>" method="post">
                <div class="form-group">
                    <label for="envato-username-field">Username</label>
                    <input id="envato-username-field" name="username" placeholder="<?php _e('Enter your themeforest user', 'omega-admin-td'); ?>" type="text" value="<?php echo $options['username']; ?>">
                </div>

                <div class="form-group">
                    <label for="envato-apikey-field">API Key</label>
                    <input id="envato-apikey-field" placeholder="<?php _e('Enter your themeforest API key', 'omega-admin-td'); ?>" name="api" type="text" value="<?php echo $options['api']; ?>">
                </div>
                <button id="check-updates-button" name="save_credentials" class="button button-secondary"><?php _e('Save Credentials', 'omega-admin-td'); ?></button>
            </form>

        </div>

        <div class="right-part half text-center">
            <a class="youtube" href="https://www.youtube.com/watch?v=7LSB8myugeA" target="_blank">
                <span class="video-image"></span>
                <?php _e('Click to watch how to update your theme.', 'omega-admin-td'); ?>
            </a>

        </div>
    </div>

    <h3>Theme Status</h3>
    <div class="white-box updater-theme-status row">
            <div class="left-part half">
                <p class="update-message"><?php echo $message; ?></p>
                <?php if ($update_available): ?>
                    <form method="post" class="big-form" action="<?php echo esc_url( $form_action ); ?>" name="upgrade-themes" class="upgrade">
                        <?php wp_nonce_field('upgrade-core'); ?>
                        <input id="upgrade-themes" class="button button-secondary update-button" type="submit" value="<?php esc_attr_e('Update Theme', 'omega-admin-td'); ?>" name="upgrade" />
                        <input type="hidden" name="checked[]" value="<?php echo THEME_SHORT; ?>" />
                    </form>
                <?php endif ?>
            </div>
            <div class="right-part half text-center">
                <img src="<?php echo OXY_THEME_URI . 'screenshot.png' ?>" alt="<?php _e('Update Available', 'omega-admin-td'); ?>">
            </div>

    </div>
</div>
