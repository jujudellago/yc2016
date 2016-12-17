<div class="oxy-one-click oxy-one-click-complete wrap">
    <h1>Demo Content Installed</h1>
    <div class="hero-panel">
        <div class="about-text">
            <p>That's it! The demo content has been installed.</p>
            <p>On behalf of all the team at Oxygenna, thanks for purchasing our <?php echo THEME_NAME; ?> Theme.</p>
        </div>

        <div class="theme-image">
            <img src="<?php echo OXY_THEME_URI . 'screenshot.png' ?>" alt="Oxygenna">
        </div>

        <div class="button-bar">
            <a class="button button-primary button-hero" href="<?php echo get_home_url(); ?>">Check out your new site!</a>
            <a class="button button-secondary button-hero" href="<?php echo $package_details['docs_url']; ?>" target="blank">Read the theme Documentation</a>
            <a class="button button-secondary button-hero" href="http://oxygenna.ticksy.com" target="blank">Support Forum</a>
        </div>
    </div>

    <div class="hero-panel">
        <h3>Install Log</h3>
        <table class="final-results widefat">
            <thead>
                <tr>
                    <th>Items Installed</th>
                    <th>Items Already Exist</th>
                    <th>Items Failed</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="result-ok"><?php echo $results->counts[OXY_IMPORT_OK]; ?></td>
                    <td class="result-warning"><?php echo $results->counts[OXY_IMPORT_EXISTS]; ?></td>
                    <td class="result-fail"><?php echo $results->counts[OXY_IMPORT_FAIL]; ?></td>
                </tr>
            </tbody>
        </table>

        <div class="button-bar">
            <a class="button button-secondary button-hero toggle-details">Click to view details</a>
        </div>

        <table id="install-log" class="widefat install-list" style="display: none;">
            <thead>
                <tr>
                    <th>Status</th>
                    <th>Post</th>
                    <th>Type</th>
                    <th>Log</th>
                    <th>Time</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($results->list as $result): ?>
                    <tr>
                        <td class="result result-<?php echo $result->class; ?>">
                            <span class="dashicons-before dashicons-<?php echo $result->icon; ?>"></span>
                        </td>
                        <td><?php echo $result->title; ?></td>
                        <td><?php echo $result->type; ?></td>
                        <td>
                            <ul>
                                <?php foreach ($result->messages as $message): ?>
                                    <li><?php echo $message->message; ?></li>
                                <?php endforeach ?>
                            </ul>
                        </td>
                        <td><?php echo date('Y-m-d H:i:s', $result->timestamp); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>