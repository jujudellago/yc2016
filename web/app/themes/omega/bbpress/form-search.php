<?php

/**
 * Search
 *
 * @package bbPress
 * @subpackage Theme
 */

?>

<form role="search" method="get" id="bbp-search-form" action="<?php bbp_search_url(); ?>" class=>
	<div class="input-group">
		<label class="screen-reader-text hidden" for="bbp_search"><?php _e( 'Search for:', 'omega-td' ); ?></label>
		<input type="hidden" name="action" value="bbp-search-request" />
		<input class="form-control" tabindex="<?php bbp_tab_index(); ?>" type="text" value="<?php echo esc_attr( bbp_get_search_terms() ); ?>" name="bbp_search" id="bbp_search" />
        <span class="input-group-btn">
            <input tabindex="<?php bbp_tab_index(); ?>" class="btn btn-primary" type="submit" id="bbp_search_submit" value="<?php esc_attr_e( 'Search', 'omega-td' ); ?>" />
        </span>
	</div>
</form>