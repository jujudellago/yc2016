<div class="oxy-one-click oxy-one-click-remove wrap">
    <h2>Remove Package <?php echo $remove_package['name']; ?></h2>

    <div id="ajax-errors-here"></div>

    <div class="hero-panel">
        <div class="warning-text">
            <p><span class="warning">Warning</span> This will <span class="warning">permanently delete</span> all the content that was installed by the <?php echo $remove_package['name']; ?> demo content install.</p>
            <p>It will even <span class="warning">remove content that you may have modified.</span></p>
            <p>In short if the one click installer added it, it will be <span class="warning">removed.</span></p>
        </div>
    </div>

    <form id="remove-content-form" method="post" action="admin.php?page=<?php echo THEME_SHORT; ?>-oneclick">
        <input type="hidden" name="removePackageId" value="<?php echo $remove_package['id']; ?>">
        <input type="hidden" name="one_click_status" value="remove-content-page">
        <button class="button button-hero button-danger">I'm sure I want to remove all content previously installed</button>
        <a href="<?php echo admin_url('index.php'); ?>" class="button button-primary button-hero">I'm not sure get me out of here</a>
    </form>
</div>