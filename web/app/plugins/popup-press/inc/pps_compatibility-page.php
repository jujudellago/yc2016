
<div class="wrap pps-admin-page">
	<!-- Display Plugin Icon and Header -->
	<h2 class="pps-title-compatibility"><?php _e( PPS_PLUGIN_NAME . ' Compatibility', 'PPS' );?></h2>
    <?php
    $count_popups = wp_count_posts('popuppress');
    echo "<p><strong>Published popups: </strong>$count_popups->publish</p>";
    if($count_popups->publish > 0){
        if(get_option('pps_compatibility_option') == true){
            echo "<div class='update'>Compatibility already done previously. If you want you can do it again.</div>";
        } else {
            echo "<div class='update'>You must perform a compatibility update.</div>";
        }
        echo "<p><input type='button' id='pps-btn-compatibility' class='button-primary' value='Perform compatibility'></p>";
        wp_nonce_field('pps_nonce_compatibility', 'compatibility_popups');
    } else {
       echo "<div class='update'>No need for compatibility.</div>";
    }
    ?>
    <span class='spinner'></span>
    <h4 id="title-updated-popups" style="display: none">Updated popups:</h4>
    <ol></ol>

</div><!--.wrap-->