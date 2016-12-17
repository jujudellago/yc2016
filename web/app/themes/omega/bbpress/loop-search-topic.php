<?php

/**
 * Search Loop - Single Topic
 *
 * @package bbPress
 * @subpackage Theme
 */

?>
<table class="table">
	<?php bbp_get_template_part( 'loop', 'single-' . get_post_type() ); ?>
</table>