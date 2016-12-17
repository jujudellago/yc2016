<!-- Tab panes -->
<?php for ($i=0; $i<$count; $i++) { ?>
  	<?php $tab_atts = shortcode_parse_atts( $matches[3][$i] ); 
  	$content = do_shortcode( $matches[5][$i] ); ?> 
  	<?php if ($i==0) { ?>      		
  		<div class="tab-pane fade in active" id="<?php echo $tab_atts['tab_id']; ?>">
  			<?php echo $content; ?>
    	</div>  
    <?php } else { ?>
    	<div class="tab-pane fade" id="<?php echo $tab_atts['tab_id']; ?>">
    		<?php echo $content; ?>
		</div>     		
	<?php }?> 
<?php } ?>

