<?php
/**
 * Renders a bootstrap modal
 *
 * @package Omega
 * @subpackage Frontend
 * @since 1.14
 *
 * @copyright (c) 2014 Oxygenna.com
 * @license http://wiki.envato.com/support/legal-terms/licensing-terms/
 * @version 1.18.14
 */

?>
<div class="modal <?php echo $animation_class; ?>" id="<?php echo $post->ID; ?>" tabindex="-1" role="dialog">
	<div class="modal-dialog <?php echo $size_class; ?>" role="document">
    	<div class="modal-content">
      		<div class="modal-header">
        		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
        			<span aria-hidden="true">&times;</span>
        		</button>
        		<h4 class="modal-title"><?php the_title(); ?></h4>
      		</div>
      		<div class="modal-body">
        		<?php the_content(); ?>
      		</div>
    	</div>
  	</div>
</div>
