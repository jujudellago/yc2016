<div class="oxy-one-click oxy-one-click-checklist wrap">
    <h2><?php echo $current_package['name']; ?> - <?php _e('Pre Install Checklist', 'omega-admin-td'); ?></h2>
    <div id="ajax-errors-here"></div>

    <p><?php _e('Before we install the demo content onto your WordPress, we just have a few checks to run to make sure you are all set.', 'omega-admin-td'); ?></p>

    <table class="widefat importers preflight" style="width:100%;">
        <thead>
            <tr>
                <th scope="row"><?php _e('Result', 'omega-admin-td'); ?></th>
                <th scope="row"><?php _e('Check', 'omega-admin-td'); ?></th>
                <th scope="row"><?php _e('Value', 'omega-admin-td'); ?></th>
                <th scope="row"><?php _e('Information', 'omega-admin-td'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($checks as $check_item): ?>
                <tr>
                    <td class="result result-<?php echo $check_item->resultClass(); ?>">
                        <span class="dashicons-before dashicons-<?php echo $check_item->icon(); ?>"></span>
                    </td>
                    <td><?php $check_item->label(); ?></td>
                    <td><?php $check_item->value(); ?></td>
                    <td><?php $check_item->info(); ?></td>
                </tr>
            <?php endforeach ?>
    </table>
    <footer>
        <?php if ($check_list_warnings): ?>
            <div id="message" class="updated oneclick-message-warning below-h2">
                <p>
                    Looks like your WordPress / PHP have warnings, you can still install but some content may not install correctly.  Please check the list above.
                </p>
            </div>
        <?php endif; ?>
        <?php if ($check_list_ok): ?>
            <form id="install-form" method="post" action="admin.php?page=<?php echo THEME_SHORT; ?>-oneclick">
                <input type="hidden" name="one_click_status" value="install-page"/>
                <input type="hidden" name="one_click_package_id" value="<?php echo $_POST['one_click_package_id']; ?>"/>
                <button id="one-click-start-import" type="submit" class="button button-primary button-hero">Install the package</button>
            </form>
        <?php else: ?>
            <div id="message" class="error below-h2">
                <p>
                    Ooops, looks like your WordPress / PHP settings aren't quite ready for installing the demo content.
                </p>
                <p>Please review the list above and make the necassary changes to your system then refresh this page.</p>
            </div>
        <?php endif ?>
    </footer>
</div>
