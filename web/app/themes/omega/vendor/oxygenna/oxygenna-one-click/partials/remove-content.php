<div class="oxy-one-click oxy-one-click-remove-content wrap">
    <h2>Removing Package <?php echo $remove_package['name']; ?></h2>

    <div id="ajax-errors-here"></div>

    <?php if (count($installed_items) > 0) : ?>
        <table class="widefat">
            <thead>
                <tr>
                    <th>Result</th>
                    <th>ID</th>
                    <th>Type</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($installed_items as $item): ?>
                <?php $remove_success = $this->install_package->remove_item($item); ?>
                <tr>
                    <td class="result result-<?php echo $remove_success ? 'ok' : 'fail'; ?>" width="20%">
                        <span class="dashicons-before dashicons-<?php echo $remove_success ? 'yes' : 'no'; ?>"></span>
                    </td>
                    <td>
                        <?php if (is_array($item->id)): ?>
                            <?php echo $item->id['widget_id']; ?>
                        <?php else: ?>
                            <?php echo $item->id; ?>
                        <?php endif ?>
                    </td>
                    <td><?php echo $item->type; ?></td>
                </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    <?php endif ?>
    <p>All done!  You can go ahead and <a href="admin.php?page=<?php echo THEME_SHORT; ?>-oneclick">install another demo content now!</a></p>
</div>