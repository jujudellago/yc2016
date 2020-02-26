<?php
/**
 * Adds a font to the fontstack
 *
 * @package OxygennaTypography
 *
 * @copyright (c) 2014 Oxygenna.com
 * @license **LICENSE**
 * @version 1.18.14
 * @author Oxygenna.com
 */
?>
<div class="oxy-one-click-package-popup">
    <?php if ($current_package !== null): ?>
        <div class="package-about">
            <div class="package-screenshots">
                <div class="screenshot">
                    <img src="<?php echo $current_package['screenshot']; ?>" alt="<?php echo $current_package['name'] ?>" onmouseover="rollImage(this, true)" onmouseleave="rollImage(this, false)">
                </div>
            </div>
            <div class="package-info">
                <h2 class="package-name">
                    <?php echo $current_package['name'] ?>
                </h2>
                <p class="package-description"><?php echo $current_package['description']; ?></p>
                <div class="package-plugins">
                    <h4>Required Plugins</h4>
                    <table class="widefat">
                        <tbody>
                            <?php if (count($current_package['requirements']) > 0) : ?>
                                <?php foreach ($current_package['requirements'] as $plugin): ?>
                                    <?php $plugin_ok = is_plugin_active($plugin['path']); ?>
                                    <tr>
                                        <td>
                                            <?php echo $plugin['name']; ?>
                                        </td>
                                        <td class="result result-<?php echo $plugin_ok ? 'ok' : 'fail'; ?>">
                                            <span class="dashicons-before dashicons-<?php echo $plugin_ok ? 'yes' : 'no'; ?>"></span>
                                        </td>
                                    </tr>
                                <?php endforeach ?>
                            <?php else : ?>
                                <p>No plugins requried for this demo package</p>
                            <?php endif ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="package-actions">
                <?php if ($package_install_ok): ?>
                    <form method="post" action="admin.php?page=<?php echo THEME_SHORT; ?>-oneclick">
                        <input type="hidden" name="one_click_status" value="checklist-page"/>
                        <input type="hidden" name="one_click_package_id" value="<?php echo $current_package['id']; ?>"/>
                        <button type="submit" class="button button-primary">Install</button>
                    </form>
                <?php else: ?>
                    <button class="button button-primary" disabled="disabled">Can't install - plugins required</button>
                <?php endif ?>
                <form method="post" action="admin.php?page=<?php echo THEME_SHORT; ?>-oneclick">
                    <input type="hidden" name="one_click_status" value="remove-page"/>
                    <input type="hidden" name="one_click_package_id" value="<?php echo $current_package['id']; ?>"/>
                    <?php if ($is_installed): ?>
                        <button class="button button-secondary delete-package">Remove</button>
                    <?php endif ?>
                </form>
                <a class="button button-secondary" href="<?php echo $current_package['demo_url']; ?>" target="_blank">View Demo</a>
                <a class="button button-secondary" href="<?php echo $installer_details['install_plugins_url']; ?>">Install Plugins</a>
            </div>
        </div>
    <?php else: ?>
        <h2>Package not found</h2>
    <?php endif ?>
</div>
