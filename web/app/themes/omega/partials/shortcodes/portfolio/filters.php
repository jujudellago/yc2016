<?php
/**
 * Portfolio shortcode
 *
 * @package Omega
 * @subpackage Admin
 * @since 0.1
 *
 * @copyright (c) 2014 Oxygenna.com
 * @license **LICENSE**
 * @version 1.18.12
 */
?>
<?php if( !empty( $show_filters ) ) : ?>
<div class="row">
    <div class="col-md-12">
        <div class="portfolio-header clearfix">
            <?php if( in_array( 'categories', $show_filters ) ) : ?>

            <h3 class="portfolio-title pull-left">
                <strong>
                    <?php _e( 'View /', 'omega-td' ); ?>
                </strong>
                <span>
                    <?php _e( 'All', 'omega-td' ); ?>
                </span>
            </h3>

            <?php endif; ?>
            <div class="portfolio-filters pull-right">
                <?php if( in_array( 'sort', $show_filters ) ) : ?>
                    <div class="btn-group">
                        <button type="button" class="btn btn-primary dropdown-toggle btn-icon-right btn-sm" data-toggle="dropdown">
                            <b><?php _e( 'Sort', 'omega-td' ); ?></b>
                            <span>
                                <i class="fa fa-angle-down"></i>
                            </span>
                        </button>
                        <ul class="dropdown-menu pull-right" role="menu">
                            <li><a class="portfolio-sort" data-sort="default"><?php _e( 'Default', 'omega-td' ); ?></a></li>
                            <li><a class="portfolio-sort" data-sort="title"><?php _e( 'Title', 'omega-td' ); ?></a></li>
                            <li><a class="portfolio-sort" data-sort="date"><?php _e( 'Date', 'omega-td' ); ?></a></li>
                            <li><a class="portfolio-sort" data-sort="comments"><?php _e( 'Comments', 'omega-td' ); ?></a></li>
                        </ul>
                    </div>
                <?php endif; ?>
                <?php if( in_array( 'order', $show_filters ) ) : ?>
                    <div class="btn-group">
                        <button type="button" class="btn btn-primary dropdown-toggle btn-icon-right btn-sm" data-toggle="dropdown">
                            <b><?php _e( 'Order', 'omega-td' ); ?></b>
                            <span>
                                <i class="fa fa-angle-down"></i>
                            </span>
                            <span>
                                <i class="fa fa-angle-down"></i>
                            </span>
                        </button>
                        <ul class="dropdown-menu pull-right" role="menu">
                            <li><a class="portfolio-order" data-value="true"><?php _e( 'Ascending', 'omega-td' ); ?></a></li>
                            <li><a class="portfolio-order" data-value="false"><?php _e( 'Descending', 'omega-td' ); ?></a></li>
                        </ul>
                    </div>
                <?php endif; ?>
                <?php if( in_array( 'categories', $show_filters ) ) : ?>
                    <div class="btn-group">
                        <button type="button" class="btn btn-primary dropdown-toggle btn-icon-right btn-sm" data-toggle="dropdown">
                            <b><?php _e( 'Category', 'omega-td' ); ?></b>
                            <span>
                                <i class="fa fa-angle-down"></i>
                            </span>
                        </button>
                        <ul class="dropdown-menu pull-right" role="menu">
                            <li><a class="portfolio-filter" data-filter="*"><?php _e( 'All', 'omega-td' ); ?></a></li>
                            <?php foreach( $filters as $filter ) : ?>
                                <li><a class="portfolio-filter" data-filter=".filter-<?php echo $filter->slug; ?>"><?php echo $filter->name; ?></a></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>