
<div id="<?php echo $id; ?>" class="panel-group <?php echo implode( ' ', $classes ); ?>" data-os-animation="<?php echo $scroll_animation; ?>" data-os-animation-delay="<?php echo $scroll_animation_delay; ?>s">
	<?php for( $i = 0; $i < $count; $i++ ) { ?>
		<?php $group_id = 'group_'.rand(100,999); ?>
		<?php if( 'vc_accordion_tab' == $matches[2][$i] ) {
			$accordion_atts = shortcode_parse_atts( $matches[3][$i] );
			$open_close_class = '';

            if ( isset( $accordion_atts['state'] ) ) {
                if ($accordion_atts['state'] == 'open') {
                    $open_close_class = ' in';
                }
            }
		    $content = do_shortcode( $matches[5][$i] ); ?>
		    <div class="panel panel-<?php echo $type; ?>">
		        <div class="panel-heading">
		            <a href="#<?php echo $group_id; ?>" class="accordion-toggle collapsed" data-parent = "#<?php echo $id; ?>" data-toggle="collapse" ><?php echo $accordion_atts['title']; ?></a>
		        </div>
		        <div id="<?php echo $group_id; ?>" class="panel-collapse collapse <?php echo $open_close_class ?>">
		            <div class="panel-body">
		                <p> <?php echo $content;?> </p>
		            </div>
		        </div>
		    </div>
	   	<?php } ?>
	<?php } ?>
</div>
