<div class="oxy-one-click oxy-one-click-install wrap" data-install-id="<?php echo $current_package['id']; ?>">
    <h2>Installing Demo Content Package</h2>

    <div class="package-panel">
        <div class="screenshot">
            <img src="<?php echo $current_package['thumbnail']; ?>" alt="<?php echo $current_package['name'] ?>" onmouseover="rollImage(this, true)" onmouseleave="rollImage(this, false)">
        </div>
        <div class="package-info">
            <h4 class="package-name">
                <?php echo $current_package['name'] ?>
            </h4>
            <p class="package-description"><?php echo $current_package['description']; ?></p>
            <!-- <h4><img src="images/wpspin_light.gif"/> Installing the demo content</h4> -->
            <h4>Current Task : <span id="current-task-label"></span></h4>
            <div id="current-progress" class="ui-progressbar">
                <div id="current-progress-label" class="progress-label"></div>
            </div>

            <h4>Total Progress</h4>
            <div id="total-progress" class="ui-progressbar">
                <div id="total-progress-label" class="progress-label"></div>
            </div>
        </div>
        <div id="messages"></div>
    </div>
</div>
<form id="import-finished-form" method="post" action="admin.php?page=<?php echo THEME_SHORT; ?>-oneclick">
    <input id="FinishedFormJobID" type="hidden" name="installPackageId">
    <input type="hidden" name="one_click_status" value="finished-page">
</form>

