<div class="wrap">
    <h2><?php _e('System Status Checker', 'omega-admin-td'); ?></h2>
    <p>
        This page will check if your server is set up to run the theme properly.
    </p>
    <div id="ajax-errors-here"></div>

    <?php if ($status->swatch_writable === false) : ?>
        <div class="error">
            <p><?php echo THEME_NAME . __(' cannot write to the <code>assets/css</code> folder.  Please <a href="http://codex.wordpress.org/Changing_File_Permissions">modify your file permissions</a> to make sure PHP can write to this folder. ', 'omega-admin-td'); ?>
            <p><?php echo __('After that re-install the default swatches in ', 'omega-admin-td') . THEME_NAME . __(' -> Advanced -> Install Default Swatches', 'omega-admin-td'); ?>
        </div>
    <?php endif ?>



    <table class="widefat importers preflight" style="width:100%;">
        <thead>
            <tr>
                <th scope="row" colspan="2"><?php _e('Theme Swatches', 'omega-admin-td'); ?></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><?php _e('Number of active swatches', 'omega-admin-td'); ?>:</td>
                <td>
                    <?php echo count($status->installed_swatches); ?>
                </td>
            </tr>
            <tr>
                <td><?php _e('Swatches are added using', 'omega-admin-td'); ?>:</td>
                <td>
                    <?php echo $status->swatch_css_save === 'file' ? __('CSS files', 'omega-admin-td') : __('CSS in the head tag', 'omega-admin-td'); ?>
                </td>
            </tr>
            <tr>
                <td><?php _e('Swatch CSS files', 'omega-admin-td'); ?>:</td>
                <td>
                    <?php _e('Below are the swatch files installed by the theme.', 'omega-admin-td'); ?>
                </td>
            </tr>
            <?php foreach ($status->swatches_files as $swatch_file) : ?>
            <?php $swatch_file_exists = file_exists(OXY_THEME_DIR . '/assets/css/' . $swatch_file); ?>
            <tr>
                <td></td>
                <td>
                    <code><?php echo $swatch_file; ?></code>
                    <span class="<?php echo $swatch_file_exists ? 'status-ok' : 'status-error'; ?>">
                        (<?php echo $swatch_file_exists ? __('CSS file exists', 'omega-admin-td') : __('CSS does not exist, try re-saving this swatch.', 'omega-admin-td'); ?>)
                    </span>
                </td>
            </tr>
            <?php endforeach; ?>
            <tr>
                <td><?php _e('Is CSS folder writable?', 'omega-admin-td'); ?>:</td>
                <td>
                    <span class="<?php echo $status->swatch_writable === true ? 'status-ok' : 'status-error'; ?>">
                        <?php echo $status->swatch_writable === true ? __('CSS folder is writable', 'omega-admin-td') : __('CSS folder is not writable', 'omega-admin-td'); ?>
                    </span>
                </td>
            </tr>
        </tbody>
    </table>
</div>
