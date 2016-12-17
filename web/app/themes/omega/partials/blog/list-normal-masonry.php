<?php if( oxy_get_option('blog_masonry_section_background') !== '' ) : ?>
	<div class="background-media" style="background-image: url('<?php echo oxy_get_option('blog_masonry_section_background') ?>'); background-repeat:no-repeat; background-size:cover; background-attachment:fixed;"></div>
<?php endif; ?>
<div class="container">
    <div class="row element-normal-top element-normal-bottom">
        <div class="col-md-12">
            <div class="masonry blog-masonry use-masonry isotope no-transition" data-padding="<?php echo oxy_get_option('blog_masonry_item_padding'); ?>" data-col-xs="1" data-col-sm="2" data-col-md="4" data-col-lg="4">
                <?php get_template_part( 'partials/blog/loop', 'masonry' ); ?>
            </div>
        </div>
    </div>
</div>