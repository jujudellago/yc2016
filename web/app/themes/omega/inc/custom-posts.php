<?php
/**
 * Oxygenna.com
 *
 * :: *(TEMPLATE_NAME)*
 * :: *(COPYRIGHT)*
 * :: *(LICENCE)*
 */

function oxy_fetch_custom_columns($column) {
    global $post;
    switch( $column ) {
        case 'menu_order':
            echo $post->menu_order;
            echo '<input id="qe_slide_order_"' . $post->ID . '" type="hidden" value="' . $post->menu_order . '" />';
        break;

        case 'featured-image':
            $editlink = get_edit_post_link( $post->ID );
            echo '<a href="' . $editlink . '">' . get_the_post_thumbnail( $post->ID, 'thumbnail' ) . '</a>';
        break;

        case 'slideshows-category':
            echo get_the_term_list( $post->ID, 'oxy_slideshow_categories', '', ', ' );
        break;

        case 'service-category':
            echo get_the_term_list( $post->ID, 'oxy_service_category', '', ', ' );
        break;

        case 'departments-category':
            echo get_the_term_list( $post->ID, 'oxy_staff_department', '', ', ' );
        break;

        case 'job-title':
            echo get_post_meta( $post->ID, THEME_SHORT . '_position', true );
        break;

        case 'portfolio-category':
            echo get_the_term_list( $post->ID, 'oxy_portfolio_categories', '', ', ' );
        break;

        case 'swatch-status':
            $status = get_post_meta( $post->ID, THEME_SHORT . '_status', true );
            if( $status === 'enabled' ) {
                echo '<h4 class="swatch-status enabled">Swatch Enabled</h4>';
            }
            else {
                echo '<h4 class="swatch-status disabled">Swatch Disabled</h4>';
            }
        break;
        case 'testimonial-group':
            echo get_the_term_list( $post->ID, 'oxy_testimonial_group', '', ', ' );
        break;
        case 'testimonial-citation':
            echo get_post_meta( $post->ID, THEME_SHORT . '_citation', true );
        break;

        case 'swatch-preview':
            $header                 = get_post_meta( $post->ID, THEME_SHORT . '_header', true );
            $background             = get_post_meta( $post->ID, THEME_SHORT . '_background', true );
            $text                   = get_post_meta( $post->ID, THEME_SHORT . '_text', true );
            $icon                   = get_post_meta( $post->ID, THEME_SHORT . '_icon', true );
            $link                   = get_post_meta( $post->ID, THEME_SHORT . '_link', true );
            $link_hover             = get_post_meta( $post->ID, THEME_SHORT . '_link_hover', true );
            $foreground             = get_post_meta( $post->ID, THEME_SHORT . '_foreground', true );
            $overlay                = get_post_meta( $post->ID, THEME_SHORT . '_overlay', true );
            $form_background        = get_post_meta( $post->ID, THEME_SHORT . '_form_background', true );
            $form_text              = get_post_meta( $post->ID, THEME_SHORT . '_form_text', true );
            $form_active            = get_post_meta( $post->ID, THEME_SHORT . '_form_active', true );
            $form_button_background = get_post_meta( $post->ID, THEME_SHORT . '_primary_button_background', true );
            $form_button_text       = get_post_meta( $post->ID, THEME_SHORT . '_primary_button_text', true );
            ?>

            <div class="swatch-preview" style="background:<?php echo $background; ?>; padding: 24px; border: 1px solid #dfdfdf;">
                <h2 style="color:<?php echo $header; ?>; text-align:center;">This is how a title will look</h2>
                <p style="color:<?php echo $text; ?>; line-height: 1.5em;">
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                    Perspiciatis, <a href="#" style="color:<?php echo $link; ?>;" onmouseover="this.style.color='<?php echo $link_hover; ?>'" onmouseout="this.style.color='<?php echo $link; ?>'">Links will look like this neque quis cumque nobis</a> dolore provident unde hic aspernatur porro accusantium.
                    Ratione odit iste ducimus excepturi cupiditate amet similique laborum molestiae!
                </p>
            </div>
        <?php
        break;

        default:
            // do nothing
        break;
    }
}
add_action( 'manage_posts_custom_column', 'oxy_fetch_custom_columns' );

/**
 * Slideshow Custom Post
 */

$labels = array(
    'name'               => __( 'Slideshow Images', 'omega-admin-td' ),
    'singular_name'      => __( 'Slideshow Image', 'omega-admin-td' ),
    'add_new'            => __( 'Add New', 'omega-admin-td' ),
    'add_new_item'       => __( 'Add New Image', 'omega-admin-td' ),
    'edit_item'          => __( 'Edit Image', 'omega-admin-td' ),
    'new_item'           => __( 'New Image', 'omega-admin-td' ),
    'view_item'          => __( 'View Image', 'omega-admin-td' ),
    'search_items'       => __( 'Search Images', 'omega-admin-td' ),
    'not_found'          => __( 'No images found', 'omega-admin-td' ),
    'not_found_in_trash' => __( 'No images found in Trash', 'omega-admin-td' ),
    'menu_name'          => __( 'Slider Images', 'omega-admin-td' )
);

$args = array(
    'labels'    => $labels,
    'public'    => false,
    'show_ui'   => true,
    'query_var' => false,
    'rewrite'   => false,
    'menu_icon' => 'dashicons-slides',
    'supports'  => array( 'title', 'editor', 'thumbnail', 'page-attributes' )
);

// create custom post
register_post_type( 'oxy_slideshow_image', $args );

// move featured image box on slideshow
function oxy_move_slideshow_meta_box() {
    remove_meta_box( 'postimagediv', 'oxy_slideshow_image', 'side' );
    add_meta_box('postimagediv', __('Slideshow Image', 'omega-admin-td'), 'post_thumbnail_meta_box', 'oxy_slideshow_image', 'advanced', 'low');
}
add_action('do_meta_boxes', 'oxy_move_slideshow_meta_box');

function oxy_edit_columns_slideshow($columns) {
    $columns = array(
        'cb'                  => '<input type="checkbox" />',
        'title'               => __('Image Title', 'omega-admin-td'),
        'featured-image'      => __('Image', 'omega-admin-td'),
        'menu_order'          => __('Order', 'omega-admin-td'),
        'slideshows-category' => __('Slideshows', 'omega-admin-td'),
    );
    return $columns;
}
add_filter( 'manage_edit-oxy_slideshow_image_columns', 'oxy_edit_columns_slideshow' );


/* --------------------- SERVICES ------------------------*/

$labels = array(
    'name'               => __('Services', 'omega-admin-td'),
    'singular_name'      => __('Service', 'omega-admin-td'),
    'add_new'            => __('Add New', 'omega-admin-td'),
    'add_new_item'       => __('Add New Service', 'omega-admin-td'),
    'edit_item'          => __('Edit Service', 'omega-admin-td'),
    'new_item'           => __('New Service', 'omega-admin-td'),
    'all_items'          => __('All Services', 'omega-admin-td'),
    'view_item'          => __('View Service', 'omega-admin-td'),
    'search_items'       => __('Search Services', 'omega-admin-td'),
    'not_found'          => __('No Service found', 'omega-admin-td'),
    'not_found_in_trash' => __('No Service found in Trash', 'omega-admin-td'),
    'menu_name'          => __('Services', 'omega-admin-td')
);

// fetch service slug
$service_slug = trim( _x(oxy_get_option( 'services_slug' ), 'URL slug', 'omega-admin-td' ));
if( empty($service_slug) ) {
    $service_slug = _x('our-services', 'URL slug', 'omega-admin-td');
}

$args = array(
    'labels'             => $labels,
    'public'             => true,
    'publicly_queryable' => true,
    'show_ui'            => true,
    'show_in_menu'       => true,
    'query_var'          => true,
    'capability_type'    => 'post',
    'has_archive'        => true,
    'hierarchical'       => false,
    'menu_position'      => null,
    'menu_icon'          => 'dashicons-flag',
    'supports'           => array( 'title', 'excerpt', 'editor', 'thumbnail', 'page-attributes', 'revisions' ),
    'rewrite'            => array( 'slug' => $service_slug, 'with_front' => true, 'pages' => true, 'feeds'=>false ),
);
register_post_type( 'oxy_service', $args );

function oxy_edit_columns_services($columns) {
   // $columns['featured_image']= 'Featured Image';
    $columns = array(
        'cb'             => '<input type="checkbox" />',
        'title'          => __('Service', 'omega-admin-td'),
        'featured-image' => __('Image', 'omega-admin-td'),
        'service-category'     => __('Category', 'omega-admin-td')
    );
    return $columns;
}
add_filter( 'manage_edit-oxy_service_columns', 'oxy_edit_columns_services' );

/* ------------------ TESTIMONIALS -----------------------*/

$labels = array(
    'name'               => __('Testimonial', 'omega-admin-td'),
    'singular_name'      => __('Testimonial', 'omega-admin-td'),
    'add_new'            => __('Add New', 'omega-admin-td'),
    'add_new_item'       => __('Add New Testimonial', 'omega-admin-td'),
    'edit_item'          => __('Edit Testimonial', 'omega-admin-td'),
    'new_item'           => __('New Testimonial', 'omega-admin-td'),
    'all_items'          => __('All Testimonial', 'omega-admin-td'),
    'view_item'          => __('View Testimonial', 'omega-admin-td'),
    'search_items'       => __('Search Testimonial', 'omega-admin-td'),
    'not_found'          => __('No Testimonial found', 'omega-admin-td'),
    'not_found_in_trash' => __('No Testimonial found in Trash', 'omega-admin-td'),
    'menu_name'          => __('Testimonials', 'omega-admin-td')
);

$args = array(
    'labels'             => $labels,
    'public'             => true,
    'publicly_queryable' => true,
    'show_ui'            => true,
    'show_in_menu'       => true,
    'query_var'          => true,
    'capability_type'    => 'post',
    'has_archive'        => true,
    'hierarchical'       => false,
    'menu_position'      => null,
    'menu_icon'          => 'dashicons-format-quote',
    'supports'           => array( 'title', 'editor', 'thumbnail', 'page-attributes', 'revisions' )
);
register_post_type('oxy_testimonial', $args);

$labels = array(
    'name'          => __( 'Groups', 'omega-admin-td' ),
    'singular_name' => __( 'Group', 'omega-admin-td' ),
    'search_items'  => __( 'Search Groups', 'omega-admin-td' ),
    'all_items'     => __( 'All Groups', 'omega-admin-td' ),
    'edit_item'     => __( 'Edit Group', 'omega-admin-td'),
    'update_item'   => __( 'Update Group', 'omega-admin-td'),
    'add_new_item'  => __( 'Add New Group', 'omega-admin-td'),
    'new_item_name' => __( 'New Group Name', 'omega-admin-td')
);

register_taxonomy(
    'oxy_testimonial_group',
    'oxy_testimonial',
    array(
        'hierarchical' => true,
        'labels'       => $labels,
        'show_ui'      => true,
        'query_var'    => true,
    )
);

function oxy_edit_columns_testimonial($columns) {
   // $columns['featured_image']= 'Featured Image';
    $columns = array(
        'cb'                   => '<input type="checkbox" />',
        'title'                => __('Author', 'omega-admin-td'),
        'featured-image'       => __('Image', 'omega-admin-td'),
        'testimonial-citation' => __('Citation', 'omega-admin-td'),
        'testimonial-group'    => __('Group', 'omega-admin-td')
    );
    return $columns;
}
add_filter( 'manage_edit-oxy_testimonial_columns', 'oxy_edit_columns_testimonial' );


/* --------------------- STAFF ------------------------*/

$labels = array(
    'name'               => __('Staff', 'omega-admin-td'),
    'singular_name'      => __('Staff', 'omega-admin-td'),
    'add_new'            => __('Add New', 'omega-admin-td'),
    'add_new_item'       => __('Add New Staff', 'omega-admin-td'),
    'edit_item'          => __('Edit Staff', 'omega-admin-td'),
    'new_item'           => __('New Staff', 'omega-admin-td'),
    'all_items'          => __('All Staff', 'omega-admin-td'),
    'view_item'          => __('View Staff', 'omega-admin-td'),
    'search_items'       => __('Search Staff', 'omega-admin-td'),
    'not_found'          => __('No Staff found', 'omega-admin-td'),
    'not_found_in_trash' => __('No Staff found in Trash', 'omega-admin-td'),
    'menu_name'          => __('Staff', 'omega-admin-td')
);

// fetch portfolio slug
$staff_slug = trim( _x( oxy_get_option( 'staff_slug' ), 'URL slug', 'omega-admin-td' )  );
if( empty($staff_slug) ) {
    $staff_slug = _x('staff', 'URL slug', 'omega-admin-td');
}

$args = array(
    'labels'             => $labels,
    'public'             => true,
    'publicly_queryable' => true,
    'show_ui'            => true,
    'show_in_menu'       => true,
    'query_var'          => true,
    'capability_type'    => 'post',
    'has_archive'        => true,
    'hierarchical'       => false,
    'menu_position'      => null,
    'menu_icon'          => 'dashicons-businessman',
    'supports'           => array( 'title', 'excerpt', 'editor', 'thumbnail', 'page-attributes', 'revisions' ),
    'rewrite' => array( 'slug' => $staff_slug, 'with_front' => true, 'pages' => true, 'feeds'=>false ),
);
register_post_type('oxy_staff', $args);

$labels = array(
    'name'          => __( 'Departments', 'omega-admin-td' ),
    'singular_name' => __( 'Department', 'omega-admin-td' ),
    'search_items'  =>  __( 'Search Departments', 'omega-admin-td' ),
    'all_items'     => __( 'All Departments', 'omega-admin-td' ),
    'edit_item'     => __( 'Edit Department', 'omega-admin-td'),
    'update_item'   => __( 'Update Department', 'omega-admin-td'),
    'add_new_item'  => __( 'Add New Department', 'omega-admin-td'),
    'new_item_name' => __( 'New Department Name', 'omega-admin-td')
);

register_taxonomy(
    'oxy_staff_department',
    'oxy_staff',
    array(
        'hierarchical' => true,
        'labels'       => $labels,
        'show_ui'      => true,
    )
);

function oxy_edit_columns_staff($columns) {
   // $columns['featured_image']= 'Featured Image';
    $columns = array(
        'cb'                   => '<input type="checkbox" />',
        'title'                => __('Name', 'omega-admin-td'),
        'featured-image'       => __('Image', 'omega-admin-td'),
        'job-title'            => __('Job Title', 'omega-admin-td'),
        'departments-category' => __('Department', 'omega-admin-td')
    );
    return $columns;
}
add_filter( 'manage_edit-oxy_staff_columns', 'oxy_edit_columns_staff' );


/***************** PORTFOLIO *******************/

$labels = array(
    'name'               => __('Portfolio Items', 'omega-admin-td'),
    'singular_name'      => __('Portfolio Item', 'omega-admin-td'),
    'add_new'            => __('Add New', 'omega-admin-td'),
    'add_new_item'       => __('Add New Portfolio Item', 'omega-admin-td'),
    'edit_item'          => __('Edit Portfolio Item', 'omega-admin-td'),
    'new_item'           => __('New Portfolio Item', 'omega-admin-td'),
    'view_item'          => __('View Portfolio Item', 'omega-admin-td'),
    'search_items'       => __('Search Portfolio Items', 'omega-admin-td'),
    'not_found'          =>  __('No images found', 'omega-admin-td'),
    'not_found_in_trash' => __('No images found in Trash', 'omega-admin-td'),
    'parent_item_colon'  => '',
    'menu_name'          => __('Portfolio Items', 'omega-admin-td')
);

// fetch portfolio slug
$permalink_slug = trim( _x( oxy_get_option( 'portfolio_slug' ), 'URL slug', 'omega-admin-td' ) );
if( empty($permalink_slug) ) {
    $permalink_slug = _x('portfolio', 'URL slug', 'omega-admin-td' );
}

$args = array(
    'labels'             => $labels,
    'public'             => true,
    'publicly_queryable' => true,
    'show_ui'            => true,
    'query_var'          => true,
    'has_archive'        => true,
    'capability_type'    => 'post',
    'hierarchical'       => false,
    'menu_position'      => null,
    'menu_icon'          => 'dashicons-portfolio',
    'supports'           => array('title', 'excerpt', 'editor', 'thumbnail', 'page-attributes', 'revisions', 'comments' ),
    'rewrite' => array( 'slug' => $permalink_slug, 'with_front' => true, 'pages' => true, 'feeds'=>false ),
);

// create custom post
register_post_type( 'oxy_portfolio_image', $args );

// Register portfolio taxonomy
$labels = array(
    'name'          => __( 'Categories', 'omega-admin-td' ),
    'singular_name' => __( 'Category', 'omega-admin-td' ),
    'search_items'  =>  __( 'Search Categories', 'omega-admin-td' ),
    'all_items'     => __( 'All Categories', 'omega-admin-td' ),
    'edit_item'     => __( 'Edit Category', 'omega-admin-td'),
    'update_item'   => __( 'Update Category', 'omega-admin-td'),
    'add_new_item'  => __( 'Add New Category', 'omega-admin-td'),
    'new_item_name' => __( 'New Category Name', 'omega-admin-td')
);

register_taxonomy(
    'oxy_portfolio_categories',
    'oxy_portfolio_image',
    array(
        'hierarchical' => true,
        'labels'       => $labels,
        'show_ui'      => true,
        'query_var'    => true,
    )
);

function oxy_edit_columns_portfolio($columns) {
   // $columns['featured_image']= 'Featured Image';
    $columns = array(
        'cb'                 => '<input type="checkbox" />',
        'title'              => __('Item', 'omega-admin-td'),
        'featured-image'     => __('Image', 'omega-admin-td'),
        'menu_order'         => __('Order', 'omega-admin-td'),
        'portfolio-category' => __('Categories', 'omega-admin-td')
    );
    return $columns;
}
add_filter( 'manage_edit-oxy_portfolio_image_columns', 'oxy_edit_columns_portfolio' );

/* --------------------- SWATCHES ------------------------*/

$labels = array(
    'name'               => __('Swatches', 'omega-admin-td'),
    'singular_name'      => __('Swatch', 'omega-admin-td'),
    'add_new'            => __('Add New', 'omega-admin-td'),
    'add_new_item'       => __('Add New Swatch', 'omega-admin-td'),
    'edit_item'          => __('Edit Swatch', 'omega-admin-td'),
    'new_item'           => __('New Swatch', 'omega-admin-td'),
    'all_items'          => __('All Swatches', 'omega-admin-td'),
    'view_item'          => __('View Swatch', 'omega-admin-td'),
    'search_items'       => __('Search Swatch', 'omega-admin-td'),
    'not_found'          => __('No Swatch found', 'omega-admin-td'),
    'not_found_in_trash' => __('No Swatch found in Trash', 'omega-admin-td'),
    'menu_name'          => __('Swatches', 'omega-admin-td')
);

$args = array(
    'labels'             => $labels,
    'public'             => true,
    'publicly_queryable' => true,
    'show_ui'            => true,
    'show_in_menu'       => true,
    'query_var'          => true,
    'capability_type'    => 'post',
    'has_archive'        => true,
    'hierarchical'       => false,
    'menu_position'      => null,
    'exclude_from_search'=> true,
    'menu_icon'          => 'dashicons-art',
    'supports'           => array( 'title' )
);
register_post_type('oxy_swatch', $args);

/* --------------------- Color Bundles------------------------*/

$labels = array(
    'name'               => __('Color Bundles', 'omega-admin-td'),
    'singular_name'      => __('Color Bundle', 'omega-admin-td'),
    'add_new'            => __('Add New', 'omega-admin-td'),
    'add_new_item'       => __('Add New Color Bundle', 'omega-admin-td'),
    'edit_item'          => __('Edit Color Bundle', 'omega-admin-td'),
    'new_item'           => __('New Color Bundle', 'omega-admin-td'),
    'all_items'          => __('All Color Bundles', 'omega-admin-td'),
    'view_item'          => __('View Color Bundle', 'omega-admin-td'),
    'search_items'       => __('Search Color Bundle', 'omega-admin-td'),
    'not_found'          => __('No Color Bundle found', 'omega-admin-td'),
    'not_found_in_trash' => __('No Color Bundle found in Trash', 'omega-admin-td'),
    'menu_name'          => __('Color Bundles', 'omega-admin-td')
);

$args = array(
    'labels'             => $labels,
    'public'             => true,
    'publicly_queryable' => true,
    'show_ui'            => true,
    'show_in_menu'       => true,
    'query_var'          => true,
    'capability_type'    => 'post',
    'has_archive'        => true,
    'hierarchical'       => false,
    'menu_position'      => null,
    'menu_icon'          => 'dashicons-screenoptions',
    'supports'           => array( 'title' )
);
register_post_type('oxy_color_bundle', $args);

function oxy_edit_columns_swatch($columns) {
    $columns = array(
        'cb'             => '<input type="checkbox" />',
        'title'          => __('Swatch', 'omega-admin-td'),
        'swatch-preview' => __('Preview', 'omega-admin-td'),
        'swatch-status'  => __('Status', 'omega-admin-td'),
    );
    return $columns;
}
add_filter( 'manage_edit-oxy_swatch_columns', 'oxy_edit_columns_swatch' );


$labels = array(
    'name'               => __('Mega Menu', 'omega-admin-td'),
    'singular_name'      => __('Mega Menu', 'omega-admin-td'),
);

$args = array(
    'labels'             => $labels,
    'public'             => false,
    'publicly_queryable' => false,
    'show_ui'            => false,
    'show_in_menu'       => true,
    'query_var'          => false,
    'show_in_nav_menus'  => true,
    'capability_type'    => 'post',
    'has_archive'        => false,
    'hierarchical'       => false,
    'menu_position'      => null,
);
register_post_type( 'oxy_mega_menu', $args );

$labels = array(
    'name'               => __('Mega Menu Columns', 'omega-admin-td'),
    'singular_name'      => __('Mega Menu Columns', 'omega-admin-td'),
);

$args = array(
    'labels'             => $labels,
    'public'             => false,
    'publicly_queryable' => false,
    'show_ui'            => false,
    'show_in_menu'       => false,
    'query_var'          => false,
    'show_in_nav_menus'  => true,
    'capability_type'    => 'post',
    'has_archive'        => false,
    'hierarchical'       => false,
    'menu_position'      => null,
);
register_post_type( 'oxy_mega_columns', $args );

function oxy_register_taxonomies() {
    // Register slideshow taxonomy
    $labels = array(
        'name'          => __( 'Slideshows', 'omega-admin-td' ),
        'singular_name' => __( 'Slideshow', 'omega-admin-td' ),
        'search_items'  => __( 'Search Slideshows', 'omega-admin-td' ),
        'all_items'     => __( 'All Slideshows', 'omega-admin-td' ),
        'edit_item'     => __( 'Edit Slideshow', 'omega-admin-td'),
        'update_item'   => __( 'Update Slideshow', 'omega-admin-td'),
        'add_new_item'  => __( 'Add New Slideshow', 'omega-admin-td'),
        'new_item_name' => __( 'New Slideshow Name', 'omega-admin-td')
    );

    register_taxonomy(
        'oxy_slideshow_categories',
        'oxy_slideshow_image',
        array(
            'hierarchical' => true,
            'labels'       => $labels,
            'show_ui'      => true,
            'query_var'    => false,
            'rewrite'      => false
        )
    );

    $labels = array(
        'name'          => __( 'Categories', 'omega-admin-td' ),
        'singular_name' => __( 'Category', 'omega-admin-td' ),
        'search_items'  => __( 'Search Categories', 'omega-admin-td' ),
        'all_items'     => __( 'All Categories', 'omega-admin-td' ),
        'edit_item'     => __( 'Edit Category', 'omega-admin-td'),
        'update_item'   => __( 'Update Category', 'omega-admin-td'),
        'add_new_item'  => __( 'Add New Category', 'omega-admin-td'),
        'new_item_name' => __( 'New Category Name', 'omega-admin-td')
    );

    register_taxonomy(
        'oxy_service_category',
        'oxy_service',
        array(
            'hierarchical' => true,
            'labels'       => $labels,
            'show_ui'      => true,
        )
    );
}
add_action( 'init', 'oxy_register_taxonomies' );

/* --------------------- MODALS -----------------------*/

$labels = array(
    'name'               => __('Modal', 'omega-admin-td'),
    'singular_name'      => __('Modal', 'omega-admin-td'),
    'add_new'            => __('Add New', 'omega-admin-td'),
    'add_new_item'       => __('Add New Modal', 'omega-admin-td'),
    'edit_item'          => __('Edit Modal', 'omega-admin-td'),
    'new_item'           => __('New Modal', 'omega-admin-td'),
    'all_items'          => __('All Modals', 'omega-admin-td'),
    'view_item'          => __('View Modal', 'omega-admin-td'),
    'search_items'       => __('Search Modal', 'omega-admin-td'),
    'not_found'          => __('No Modals found', 'omega-admin-td'),
    'not_found_in_trash' => __('No Modals found in Trash', 'omega-admin-td'),
    'menu_name'          => __('Modals', 'omega-admin-td')
);

$args = array(
    'labels'             => $labels,
    'public'             => true,
    'publicly_queryable' => true,
    'exclude_from_search'=> true,
    'show_ui'            => true,
    'show_in_menu'       => true,
    'query_var'          => true,
    'capability_type'    => 'post',
    'has_archive'        => true,
    'hierarchical'       => false,
    'menu_position'      => null,
    'menu_icon'          => 'dashicons-lightbulb',
    'supports'           => array('title', 'editor', 'thumbnail', 'page-attributes', 'revisions')
);
register_post_type('oxy_modal', $args);
