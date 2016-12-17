<div class="oxy-one-click oxy-one-click-packages wrap">
    <h2>Demo Packages <span class="package-count theme-count"><?php echo $packages_count; ?></span></h2>

    <div id="ajax-errors-here"></div>
    <div class="package-browser rendered">
        <div class="packages">
            <?php foreach ($packages as $package): ?>
                <?php $package_class = $package['id'] === $already_installed_package ? ' active' : ''; ?>
                <div class="package<?php echo $package_class; ?>">
                    <div class="package-screenshot">
                        <img src="<?php echo $package['thumbnail']; ?>" alt="<?php echo $package['name']; ?>">
                    </div>

                    <h4 class="package-name" id="lambda-name">
                        <?php if ($package['id'] === $already_installed_package): ?>
                            Installed :
                        <?php endif ?>
                        <?php echo $package['name']; ?>
                    </h4>
                    <div class="package-actions">
                        <a class="button button-primary package-details" href="#" data-id="<?php echo $package['id']; ?>">View Details</a>
                    </div>
                </div>
            <?php endforeach ?>
            <div class="package">
                <div class="package-screenshot">
                    <img src="<?php echo OXY_ONECLICK_URI; ?>assets/images/suggest.jpg" alt="Suggest a site">
                </div>
                <h4 class="package-name" id="lambda-name">
                    Your idea here?
                </h4>
                <div class="package-actions">
                    <a class="button button-primary" href="mailto:info@oxygenna.com?subject=<?php echo THEME_SHORT; ?> - Suggest a Site">Suggest a site</a>
                </div>
            </div>
        </div>
    </div>
</div>