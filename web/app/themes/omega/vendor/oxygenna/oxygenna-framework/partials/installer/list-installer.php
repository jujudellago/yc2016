<div id="list-installer">
    <header>
        <h1><?php _e('Thanks for purchasing', 'omega-admin-td'); ?> <?php echo THEME_NAME; ?></h1>
        <p><?php _e('Please wait theme a few moments for the theme to set itself up.', 'omega-admin-td'); ?></p>
    </header>
    <table class="widefat install-checklist">
        <tbody>
            <?php foreach ($data['list'] as $list_item): ?>
            <tr id="<?php echo $list_item['id']; ?>">
                <th><?php echo $list_item['title'] ?></th>
                <td><span class="dashicons-before dashicons-minus"></span></td>
            </tr>
            <?php endforeach ?>
            <tr>
                <td class="button-row" colspan="2">
                    <a id="list-installer-button" disabled class="button button-secondary button-hero" href=""><?php _e('Installing', 'omega-admin-td') ?></a>
                </td>
            </tr>
        </tbody>
    </table>
</div>