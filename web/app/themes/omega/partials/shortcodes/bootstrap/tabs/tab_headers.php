<!-- Nav tabs -->
<?php for ($i=0; $i<$count; $i++) { ?>
  	<?php $tab_atts = shortcode_parse_atts( $matches[3][$i] );
  		if ($i==0) { ?>  
			<li class="active"><a href="#<?php echo $tab_atts['tab_id']; ?>" data-toggle="tab"><?php echo $tab_atts['title']; ?></a></li>	      
  	<?php } 
  		else { ?>
  			<li><a href="#<?php echo $tab_atts['tab_id']; ?>" data-toggle="tab"><?php echo $tab_atts['title']; ?></a></li>	      
  	<?php } ?>
<?php } ?>	      