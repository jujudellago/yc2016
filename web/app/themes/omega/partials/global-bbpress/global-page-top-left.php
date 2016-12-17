<section class="section <?php echo oxy_get_option('bbpress_swatch') ?>">
    <div class="container">
        <div class="row element-normal-top">
            <div class="col-md-3 sidebar">
                <?php
                if( is_active_sidebar( 'bbpress-sidebar' ) ) {
                    dynamic_sidebar( 'bbpress-sidebar' );
                }
                ?>
            </div>
            <div class="col-md-9">
