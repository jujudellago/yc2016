<figure>	
	<img src="<?php echo $item->guid; ?>">	
<?php if ($captions == 'show') : ?>
	<figcaption>
		<h3><?php echo $item->post_title; ?></h3>
		<p><?php echo $item->post_excerpt; ?></p>
	</figcaption>
</figure>
<?php endif; ?>	