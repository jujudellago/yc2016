<div class="wrap oxygenna-options-page">
    <h2><?php echo get_admin_page_title(); ?></h2>
    <?php $this->display_messages(); ?>
    <p>From this page you can install all the themes recommended and premium plugins.  In order for you to be able to install & keep updated the premium plugins please enter your purchase code in the box below.</p>

    <div class="white-box">

        <div class="left-part half">

            <form class="big-form" action="<?php echo $form_url ?>" method="post">
                <div class="form-group">
                    <label for="purchase-code">purchase code</label>
                    <input type="text" id="purchase-code" name="purchase-code" placeholder="<?php _e('Enter the themes purchase code', 'omega-admin-td'); ?>" value="<?php echo isset($plugin_options['purchase-code']) ? $plugin_options['purchase-code'] : ''; ?>">
                </div>
                <button class="button button-secondary" name="save-purchase-code">Save Purchase Code</button>
            </form>
        </div>

        <div class="right-part half text-center">
            <a class="youtube" href="http://youtu.be/G6CX5TycBpg" target="_blank">
                <span class="video-image"></span>
                <?php _e('Click to watch how to install plugins.', 'omega-admin-td'); ?>
            </a>

        </div>
    </div>
    <h3><?php _e('Plugins Installer', 'omega-admin-td') ?></h3>
    <div class="plugin-installer-table">
        <?php $plugins_table->display(); ?>
    </div>
</div>
