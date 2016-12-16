<?php
/**
 * Include and setup custom metaboxes and fields.
 *
 * @category YourThemeOrPlugin
 * @package  Metaboxes
 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link     https://github.com/webdevstudios/Custom-Metaboxes-and-Fields-for-WordPress
 */

add_filter( 'cmb_meta_boxes_pps', 'cmb_metaboxes_popuppress' );
/**
 * Define the metabox and field configurations.
 *
 * @param  array $meta_boxes
 * @return array
 */
function cmb_metaboxes_popuppress( array $meta_boxes ) {

	// Start with an underscore to hide fields from custom fields list
	$prefix = 'pps_';

	// Get the current ID
	$post_id = 0;
	if( isset( $_GET['post'] ) ){
		$post_id = $_GET['post'];
	}

	//Evitamos agregar metaboxes a otros post/paginas
	// if($post_id == 0 && isset($_GET['post_type'])){
	// 	$post_type = $_GET['post_type'];
	// }
	// else {
	// 	$post_type = get_post_type($post_id);
	// }
	// if($post_type != 'popuppress'){
	// 	return array();
	// }

	// Default Options
	$pps_options = get_option('pps_options');
	$pps_data = get_post_custom($post_id);

	/**
	 * Sample metabox to demonstrate each field type included
	 */

	$meta_boxes[] = array(
		'id'         => 'file_uploader_mbox_cmb',
		'title'      => __( 'Image/Slider', 'cmb' ),
		'pages'      => array( 'popuppress', ), // Post type
		'context'    => 'normal',
		'priority'   => 'high',
		'show_names' => true, // Show field names on the left
		'fields'     => array(
			array(
				'name' => __('Image start', 'cmb'),
				'id' => $prefix. 'slider_start_at',
				'type' => 'text_small',
				'default' => 1,
				'desc' => __('The slide that the slider should start on. (1 = first slide)', 'cmb'),
			),
			array(
				'id'          => $prefix . 'rg_img',
				'type'        => 'group',
				'description' => __( 'Image or Image Slider', 'cmb2' ),
				'options'     => array(
					'group_title'   => __( '', 'cmb' ), // since version 1.1.4, {#} gets replaced by row number
					'add_button'    => __( 'Add New', 'cmb' ),
					'remove_button' => __( 'Remove', 'cmb' ),
					'sortable'      => true, // beta
				),
				'fields' => array(
					array(
						'name' => 'Image',
						'id'   => 'image',
						'type' => 'file',
					),
					array(
						'name' => 'Image Link',
						'id'   => 'image_link',
						'type' => 'text_url',
					),
					array(
						'name' => 'Image Caption',
						'id'   => 'image_caption',
						'type' => 'text',
					),
				),
			),
		),
	);
	$meta_boxes[] = array(
		'id' => 'media_mbox_cmb',
		'title' => __('Media Links', 'cmb'),
		'pages' => array('popuppress'),
		'context' => 'normal',
		'priority' => 'high',
		'show_names' => true, // Show field names on the left
		'fields' => array(
			array(
				'name' => __('Autoplay', 'cmb'),
				'id' => $prefix. 'autoplay_embed',
				'type' => 'radio_inline',
				'default' => 'false',
				'options' => array(
					array('name' => __('Yes','cmb'), 'value' => 'true'),
					array('name' => __('Not','cmb'), 'value' => 'false'),
				),
				'desc' => __('Check "Yes" to play automatically if you have a video of youtube or vimeo.', 'cmb'),
			),
			array(
				'name' => __('Embed Height', 'cmb'),
				'id' => $prefix. 'embed_height',
				'type' => 'text_small',
				'default' => $pps_options['embed_height'],
				'desc' => __('*Enter 100 to use the 100 percent of the width of the popup.', 'cmb'),
			),
			array(
				'id'          => $prefix . 'rg_oEmbed',
				'type'        => 'group',
				'description' => __( 'Media links', 'cmb' ),
				'options'     => array(
				  'group_title'   => __( '', 'cmb' ), // since version 1.1.4, {#} gets replaced by row number
				  'add_button'    => __( 'Add New', 'cmb' ),
				  'remove_button' => __( 'Remove', 'cmb' ),
				  'sortable'      => true, // beta
				),
				'fields' => array(
					array(
						'name' => 'embed',
						'desc' => 'Enter a youtube, twitter, or instagram URL. Supports services listed at <a href="http://codex.wordpress.org/Embeds">http://codex.wordpress.org/Embeds</a>.',
						'id' => 'embed',
						'type' => 'oembed',
					),
				),
			),
		)
	);

	$meta_boxes[] = array(
		'id'         => 'iframe_mbox_cmb',
		'title'      => __('Iframe', 'cmb'),
		'pages'      => array( 'popuppress', ), // Post type
		'context'    => 'normal',
		'priority'   => 'high',
		'show_names' => true, // Show field names on the left
		'fields' => array(
			array(
				'name' => __( 'Iframe URL', 'cmb' ),
				'id' => $prefix. 'iframe',
				'type' => 'text_url',
				'desc' => __( 'Add a url to load the content using Iframe', 'cmb' ),
			),
			array(
				'name' => __( 'Iframe Height', 'cmb' ),
				'id' => $prefix. 'iframe_height',
				'type' => 'text_small',
				'default' => $pps_options['embed_height'],
				'desc' => __( '', 'cmb' ),
			),
		)
	);

	$meta_boxes[] = array(
		'id'         => 'pdf_mbox_cmb',
		'title'      => __('Pdf', 'cmb'),
		'pages'      => array( 'popuppress', ), // Post type
		'context'    => 'normal',
		'priority'   => 'high',
		'show_names' => true, // Show field names on the left
		'fields' => array(
			array(
				'name' => __('PDF URL', 'cmb'),
				'id' => $prefix. 'pdf',
				'type' => 'text',
				'desc' => '',
			),
			array(
				'name' => __('PDF Height', 'cmb'),
				'id' => $prefix. 'pdf_height',
				'type' => 'text_small',
				'default' => $pps_options['embed_height'],
				'desc' => __( '', 'cmb' ),
			),
		)
	);

	$meta_boxes[] = array(
		'id'         => 'disclaimer_mbox_cmb',
		'title'      => __( 'Popup Disclaimer Settings', 'cmb' ),
		'pages'      => array( 'popuppress', ), // Post type
		'context'    => 'normal',
		'priority'   => 'high',
		'show_names' => true, // Show field names on the left
		'fields'     => array(

			array(
				'name' => __('Use Popup as disclaimer', 'cmb'),
				'id' => $prefix. 'disclaimer_activate',
				'type' => 'radio_inline',
				'default' => 'false',
				'options' => array(
					array('name' => __('Yes','cmb'), 'value' => 'true'),
					array('name' => __('Not','cmb'), 'value' => 'false'),
				),
				'desc' => __('', 'cmb'),
			),
			array(
				'name' => 'I Agree options:',
				'id' => $prefix. 'agree_options',
				'type' => 'title',
				'desc' => __('', 'cmb'),
			),
			array(
				'name' => __('Button text', 'cmb'),
				'id' => $prefix. 'disclaimer_agree_button_text',
				'type' => 'text',
				'default' => 'I Agree',
				'desc' => __('', 'cmb'),
			),
			array(
				'name' => __('CSS class button', 'cmb'),
				'id' => $prefix. 'disclaimer_agree_button_css',
				'type' => 'text',
				'default' => 'pps-disclaimer-agree',
				'desc' => __('', 'cmb'),
			),
			array(
				'name' => __('Redirect to', 'cmb'),
				'id' => $prefix. 'disclaimer_agree_redirect',
				'type' => 'radio_inline',
				'default' => 'same_page',
				'options' => array(
					array('name' => __('Same page','cmb'), 'value' => 'same_page'),
					array('name' => __('Another page','cmb'), 'value' => 'another_page'),
				),
				'desc' => __('', 'cmb'),
			),
			array(
				'name' => __('Redirect to page', 'cmb'),
				'id' => $prefix. 'disclaimer_agree_redirect_to',
				'type' => 'text',
				'default' => 'http://',
				'desc' => __('', 'cmb'),
			),

			array(
				'name' => 'I Disagree options:',
				'id' => $prefix. 'disagree_options',
				'type' => 'title',
				'desc' => __('', 'cmb'),
			),
			array(
				'name' => __('Button text', 'cmb'),
				'id' => $prefix. 'disclaimer_disagree_button_text',
				'type' => 'text',
				'default' => 'I Disagree',
				'desc' => __('', 'cmb'),
			),
			array(
				'name' => __('CSS class button', 'cmb'),
				'id' => $prefix. 'disclaimer_disagree_button_css',
				'type' => 'text',
				'default' => 'pps-disclaimer-disagree',
				'desc' => __('', 'cmb'),
			),
			array(
				'name' => __('Upon Restriction', 'cmb'),
				'id' => $prefix. 'disclaimer_disagree_restriction',
				'type' => 'radio_inline',
				'default' => 'close_page',
				'options' => array(
					array('name' => __('Close page','cmb'), 'value' => 'close_page'),
					array('name' => __('Redirect to','cmb'), 'value' => 'redirect_to'),
				),
				'desc' => __('', 'cmb'),
			),
			array(
				'name' => __('Redirect to page', 'cmb'),
				'id' => $prefix. 'disclaimer_disagree_redirect_to',
				'type' => 'text',
				'default' => 'http://',
				'desc' => __('', 'cmb'),
			),
		),
	);
$default_styles = '
/* Customize the button of the popup */
a.pps-btn.pps-button-popup {
 color: #FFF;
 font-size: 12px;
 line-height: 1.6;
 font-weight: bold;
 padding:5px 14px 4px;
 font-family: Arial, Helvetica, sans-serif;
 background-color: #348ECC;
 border-bottom: 2px solid #1B80C5;
 border-radius: 3px;
}
a.pps-btn.pps-button-popup:hover {
 background-color: #3C9CDD;
 border-color: #1B80C5;
}
/* Add additional styles */
';
	$meta_boxes[] = array(
		'id'         => 'css_mbox_cmb',
		'title'      => __('Custom CSS Styles', 'cmb'),
		'pages'      => array( 'popuppress', ), // Post type
		'context'    => 'normal',
		'priority'   => 'high',
		'show_names' => false, // Show field names on the left
		'fields' => array(
			array(
				'name' => __('Custom CSS', 'cmb'),
				'id' => $prefix. 'custom_css_popup',
				'type' => 'textarea_code',
				'default' => $default_styles,
				'desc' => __( 'Enter your custom css styles for this popup', 'cmb' ),
			),
		)
	);
	$meta_boxes[] = array(
		'id' => 'slider_mbox_cmb',
		'title' => __('Slider Settings', 'cmb'),
		'pages' => array('popuppress'),
		'context' => 'normal',
		'priority' =>'high',
		'show_names' => true, // Show field names on the left
		'fields' => array(

			array(
				'name' => __('Automatically animate', 'cmb'),
				'id' => $prefix. 'slider_auto',
				'type' => 'radio_inline',
				'default' => $pps_options['slider_auto'],
				'options' => array(
					array('name' => __('Yes','cmb'), 'value' => 'true'),
					array('name' => __('Not','cmb'), 'value' => 'false'),
				),
				'desc' => __('Automatically animate the slider', 'cmb'),
			),
			array(
				'name' => __('Transition Speed (ms)', 'cmb'),
				'id' => $prefix. 'slider_animation_speed',
				'type' => 'text',
				'default' => $pps_options['slider_animation_speed'],
				'desc' => __('Speed of the transition, in milliseconds', 'cmb'),
			),

			array(
				'name' => __('Timeout (ms)', 'cmb'),
				'id' => $prefix. 'slider_timeout',
				'type' => 'text',
				'default' => $pps_options['slider_timeout'],
				'desc' => __('Time between slide transitions, in milliseconds', 'cmb'),
			),
			array(
				'name' => __('Show pagination', 'cmb'),
				'id' => $prefix. 'slider_pagination',
				'type' => 'radio_inline',
				'default' => $pps_options['slider_pagination'],
				'options' => array(
					array('name' => __('Yes','cmb'), 'value' => 'true'),
					array('name' => __('Not','cmb'), 'value' => 'false'),
				),
				'desc' => __('Displays small buttons to scroll between slider items', 'cmb'),
			),
			array(
				'name' => __('Show arrows', 'cmb'),
				'id' => $prefix. 'slider_arrows',
				'type' => 'radio_inline',
				'default' => $pps_options['slider_arrows'],
				'options' => array(
					array('name' => __('Yes','cmb'), 'value' => 'true'),
					array('name' => __('Not','cmb'), 'value' => 'false'),
				),
				'desc' => __('Displays arrows to scroll between slider items', 'cmb'),
			),
			array(
				'name' => __('Pause on hover', 'cmb'),
				'id' => $prefix. 'slider_pause',
				'type' => 'radio_inline',
				'default' => $pps_options['slider_pause'],
				'options' => array(
					array('name' => __('Yes','cmb'), 'value' => 'true'),
					array('name' => __('Not','cmb'), 'value' => 'false'),
				),
				'desc' => __('Pause animation when the cursor is over the slider', 'cmb'),
			),
		)
	);


	$meta_boxes[] = array(
		'id' => 'sort_mbox_cmb',
		'title' => __('Sort content fields', 'cmb'),
		'pages' => array('popuppress'),
		'context' => 'normal',
		'priority' => 'high',
		'show_names' => true, // Show field names on the left
		'fields' => array(
			array(
				'name' => '',
				'id' => $prefix. 'agree_options',
				'type' => 'title',
				'desc' => __('Use these options to sort the content you have added to your popup.', 'cmb'),
			),
			array(
				'name' => __('Wordpress Editor', 'cmb'),
				'id' => $prefix. 'mbox_editor_order',
				'type' => 'select',
				'default' => 1,
				'options' => array(
					array('name' => __(1, 'cmb'), 'value' => 1),
					array('name' => __(2, 'cmb'), 'value' => 2),
					array('name' => __(3, 'cmb'), 'value' => 3),
					array('name' => __(4, 'cmb'), 'value' => 4),
					array('name' => __(5, 'cmb'), 'value' => 5),
				),
			),
			array(
				'name' => __('Image/Slider', 'cmb'),
				'id' => $prefix. 'mbox_file_order',
				'type' => 'select',
				'default' => 2,
				'options' => array(
					array('name' => __(1, 'cmb'), 'value' => 1),
					array('name' => __(2, 'cmb'), 'value' => 2),
					array('name' => __(3, 'cmb'), 'value' => 3),
					array('name' => __(4, 'cmb'), 'value' => 4),
					array('name' => __(5, 'cmb'), 'value' => 5),
				),
			),
			array(
				'name' => __('Media Links', 'cmb'),
				'id' => $prefix. 'mbox_oembed_order',
				'type' => 'select',
				'default' => 3,
				'options' => array(
					array('name' => __(1, 'cmb'), 'value' => 1),
					array('name' => __(2, 'cmb'), 'value' => 2),
					array('name' => __(3, 'cmb'), 'value' => 3),
					array('name' => __(4, 'cmb'), 'value' => 4),
					array('name' => __(5, 'cmb'), 'value' => 5),
				),
			),
			array(
				'name' => __('Iframe', 'cmb'),
				'id' => $prefix. 'mbox_iframe_order',
				'type' => 'select',
				'default' => 4,
				'options' => array(
					array('name' => __(1, 'cmb'), 'value' => 1),
					array('name' => __(2, 'cmb'), 'value' => 2),
					array('name' => __(3, 'cmb'), 'value' => 3),
					array('name' => __(4, 'cmb'), 'value' => 4),
					array('name' => __(5, 'cmb'), 'value' => 5),
				),
			),
			array(
				'name' => __('Pdf', 'cmb'),
				'id' => $prefix. 'mbox_pdf_order',
				'type' => 'select',
				'default' => 5,
				'options' => array(
					array('name' => __(1, 'cmb'), 'value' => 1),
					array('name' => __(2, 'cmb'), 'value' => 2),
					array('name' => __(3, 'cmb'), 'value' => 3),
					array('name' => __(4, 'cmb'), 'value' => 4),
					array('name' => __(5, 'cmb'), 'value' => 5),
				),
			),
		)
	);

	$meta_boxes[] = array(
		'id' => 'preview_mbox_cmb',
		'title' => __('Popup Preview', 'cmb'),
		'pages' => array('popuppress'),
		'context' => 'side',
		'priority' => 'default',
		'show_names' => true, // Show field names on the left
		'fields' => array(

			array(
				'name' => __('Preview', 'cmb'),
				'id' => $prefix. 'popup_preview',
				'type' => 'popup_preview',
				'desc' => __('Publish to view preview', 'cmb'),
				'default' => __('<p>Publish your popup</p>', 'cmb')
			),
			array(
				'name' => __('Shortcode', 'cmb'),
				'id' => $prefix. 'shortcode',
				'type' => 'plain_text',
				'desc' => __('Add this short code in the page where you want to display your popup.', 'cmb'),
				'default' => __('<p style="font-size:13px;">[popuppress id="'.$post_id.'"]</p>', 'cmb')
			),
		)
	);


	$meta_boxes[] = array(
		'id'         => 'button_mbox_cmb',
		'title'      => __( 'Popup Button', 'cmb' ),
		'pages'      => array( 'popuppress', ), // Post type
		'context'    => 'side',
		'priority'   => 'default',
		'show_names' => true, // Show field names on the left
		'fields'     => array(
			array(
				'name' => __('Button Type', 'cmb'),
				'id' => $prefix. 'button_type',
				'type' => 'radio',
				'default' => 'button',
				'options' => array(
					array('name' => __('Button <dfn>Opens the popup by clicking in a button</dfn>','cmb'), 'value' => 'button'),
					array('name' => __('Image','cmb'), 'value' => 'image'),
					array('name' => __('Plain Text <dfn>Opens the popup by clicking in a button</dfn>','cmb'), 'value' => 'plain-text'),
					array('name' => __('Thumbnails','cmb'), 'value' => 'thumbnails'),
					array('name' => __('No Button','cmb'), 'value' => 'no-button'),
				),
				'desc' => __('<sub>Select the type of button that runs the popup. Choose "Thumbnails" If you want to show thumbnails as buttons for each image of your slider. </sub>', 'cmb'),
			),

			array(
				'name' => 'Button Image',
				'id' => $prefix . 'button_image',
				'type' => 'file',
				'save_id' => false, // save ID using true
				'desc' => __('<sub>Upload an image or enter an URL.</sub>', 'cmb'),
			),
			array(
				'name' => 'Button Image Hover',
				'id' => $prefix . 'button_image_hover',
				'type' => 'file',
				'save_id' => false, // save ID using true
				'desc' => __('<sub>Upload an image or enter an URL.</sub>', 'cmb'),
			),
			array(
				'name' => __('Image Width', 'cmb'),
				'id' => $prefix. 'img_width_button',
				'type' => 'text_small',
				'default' => $pps_options['img_width_button'],
				'desc' => __('', 'cmb'),
			),

			array(
				'name' => __('Button Text', 'cmb'),
				'id' => $prefix. 'button_text',
				'type' => 'text',
				'default' => $pps_options['button_text'],
				'desc' => __('<sub>Text for the button that opens the popup</sub>', 'cmb'),
			),

			array(
				'name' => __('Button Title', 'cmb'),
				'id' => $prefix. 'button_title',
				'type' => 'text',
				'default' => $pps_options['button_title'],
				'desc' => __('<sub>Button text on hover</sub>', 'cmb'),
			),
			array(
				'name' => __('Button Style Class', 'cmb'),
				'id' => $prefix. 'button_class',
				'type' => 'text',
				'default' => $pps_options['button_class'],
				'desc' => __('<sub>Add a Class to customize your button using CSS Styles.</sub>', 'cmb'),
			),
			array(
				'name' => __('Class to Execute Popup', 'cmb'),
				'id' => $prefix. 'button_class_run',
				'type' => 'text',
				'default' => '',
				'desc' => __('<sub>This class will be used to run the popup when you click on it. E.g: run-popup. The default is "pps-button-popup-45", where 45 is the id of the popup. Without point.</sub>', 'cmb'),
			),

			array(
				'name' => __('Css Class for Thumbnails', 'cmb'),
				'id' => $prefix. 'class_thumbnail',
				'type' => 'text',
				'default' => 'pps-thumb-slider',
				'desc' => __('<sub>Add a Class to customize your thumbnails using CSS Styles.</sub>', 'cmb'),
			),

			array(
				'name' => __('N° Columns', 'cmb'),
				'id' => $prefix. 'n_columns',
				'type' => 'text',
				'default' => 'auto',
				'desc' => __('<sub>This value is used to make responsive the thumbnails. Example: if you put 4, then each thumbnail will have a maximum width of 25%.</sub>', 'cmb'),
			),
		),
	);

	/*
	Soluciona incompatibilidad con la opción
	"Open on Hover" de la versión anterior
	*/
	$run_method = 'click';
	if(isset($pps_data[$prefix.'run_on_hover'][0])) {
		if($pps_data[$prefix.'run_on_hover'][0] == 'yes') {
			$run_method = 'mouseover';
		}
	}


	$meta_boxes[] = array(
		'id' => 'open_mbox_cmb',
		'title' => __('Settings to Open and Close Popup', 'cmb'),
		'pages' => array('popuppress'),
		'context' => 'side',
		'priority' => 'default',
		'show_names' => true, // Show field names on the left
		'fields' => array(

			array(
				'name' => __('Action to open', 'cmb'),
				'id' => $prefix. 'open_hook',
				'type' => 'radio',
				'default' => $run_method,
				'options' => array(
					array(
						'name' => __('Click <dfn>Opens the popup by clicking in a button</dfn>','cmb'),
						'value' => 'click'
					),
					array(
						'name' => __('Automatically <dfn>Opens the popup automatically on page load</dfn>','cmb'),
						'value' => 'auto_open'
					),
					array(
						'name' => __('Leaving the page <dfn>Opens the popup when user tries leave the page</dfn>','cmb'),
						'value' => 'leave_page'
					),
					array(
						'name' => __('Hover <dfn>opens the popup when the cursor hovering over on the button</dfn>','cmb'),
						'value' => 'mouseover'
					),
				),
				'desc' => __('<sub>Action that will trigger the popup</sub>', 'cmb'),
			),
			array(
				'name' => __('Close on mouseleave', 'cmb'),
				'id' => $prefix. 'close_mouselave',
				'type' => 'radio_inline',
				'default' => 'false',
				'options' => array(
					array('name' => __('Yes','cmb'), 'value' => 'true'),
					array('name' => __('Not','cmb'), 'value' => 'false'),
				),
				'desc' => __('<sub>Close the popup when the mouse moves off the popup</sub>', 'cmb'),
			),
			array(
				'name' => __('Appears a maximum X times', 'cmb'),
				'id' => $prefix. 'leave_page_max_times',
				'type' => 'text',
				'default' => '1',
				'desc' => __('<sub>Maximum number of times the popup appears when trying to leave the current page. If you use cookies then appears only once.</sub>', 'cmb'),
			),
			array(
				'name' => __('Use Cookie', 'cmb'),
				'id' => $prefix. 'first_time',
				'type' => 'radio_inline',
				'default' => 'false',
				'options' => array(
					array('name' => __('Yes','cmb'), 'value' => 'true'),
					array('name' => __('Not','cmb'), 'value' => 'false'),
				),
				'desc' => __('<sub>Opens only on the first load (Uses Cookies)</sub>', 'cmb'),
			),
			array(
				'name' => __('Lifetime of the Cookie', 'cmb'),
				'id' => $prefix. 'cookie_expire',
				'type' => 'radio',
				'default' => 'current_session',
				'options' => array(
					array('name' => __('Current session','cmb'), 'value' => 'current_session'),
					array('name' => __('Define lifetime','cmb'), 'value' => 'number_days'),
				),
				'desc' => __('<sub>Define lifetime of the cookie.</sub>', 'cmb'),
			),

			array(
				'name' => __('Lifetime (days)', 'cmb'),
				'id' => $prefix. 'cookie_days',
				'type' => 'text',
				'default' => '1',
				'desc' => __('<sub>Number which will be interpreted as days from lifetime of the cookie.</sub>', 'cmb'),
			),

			array(
				'name' => __('Remove cookie', 'cmb'),
				'id' => $prefix. 'remove-cookie',
				'type' => 'boton',
				'default' => 'Remmove cookie',
				'desc' => __('', 'cmb'),
			),

			array(
				'name' => __('Open in', 'cmb'),
				'id' => $prefix. 'open_in',
				'type' => 'radio',
				'default' => 'pages',
				'options' => array(
					array('name' => __('Specific pages','cmb'), 'value' => 'pages'),
					array('name' => __('Home','cmb'), 'value' => 'home'),
					array('name' => __('All site','cmb'), 'value' => 'all-site'),
					array('name' => __('Specific URL\'s','cmb'), 'value' => 'urls'),
				),
				'desc' => __('<sub>Choose where to run the popup.</sub>', 'cmb'),
			),
			array(
				'name' => __('URL\'s', 'cmb'),
				'id' => $prefix. 'open_in_url',
				'type' => 'textarea_small',
				'default' => '',
				'desc' => __('<sub>Add the Url\'s separated by commas. Use (*) at the end of the url to insert the popup at all daughters pages. E.g. (http://www.example.com/store/*)</sub>', 'cmb'),
			),

			array(
				'name' => __('Exclude pages', 'cmb'),
				'id' => $prefix. 'exclude_pages',
				'type' => 'text',
				'default' => '',
				'desc' => __('<sub>Add page or post IDs separated by commas. e.g: 25,37. The popup will not appear on these pages</sub>', 'cmb'),
			),
			array(
				'name' => __('Open Delay (ms)', 'cmb'),
				'id' => $prefix. 'open_delay',
				'type' => 'text',
				'default' => '0',
				'desc' => __('<sub>Delay time to run the popup</sub>', 'cmb'),
			),
			array(
				'name' => __('Auto close', 'cmb'),
				'id' => $prefix. 'auto_close',
				'type' => 'radio_inline',
				'default' => 'false',
				'options' => array(
					array('name' => __('Yes','cmb'), 'value' => 'true'),
					array('name' => __('Not','cmb'), 'value' => 'false'),
				),
				'desc' => __('<sub>Automatically close the popup</sub>', 'cmb'),
			),
			array(
				'name' => __('Close Delay (ms)', 'cmb'),
				'id' => $prefix. 'delay_close',
				'type' => 'text',
				'default' => '10000',
				'desc' => __('<sub>Delay time to close the popup</sub>', 'cmb'),
			),

			array(
				'name' => __('Close Click Overlay', 'cmb'),
				'id' => $prefix. 'close_overlay',
				'type' => 'radio_inline',
				'default' => $pps_options['close_overlay'],
				'options' => array(
					array('name' => __('Yes','cmb'), 'value' => 'true'),
					array('name' => __('Not','cmb'), 'value' => 'false'),
				),
				'desc' => __('<sub>Should the popup close on click on overlay?</sub>', 'cmb'),
			),

			array(
				'name' => __('Close Esc Key', 'cmb'),
				'id' => $prefix. 'close_esc_key',
				'type' => 'radio_inline',
				'default' => isset($pps_options['close_esc_key']) ? $pps_options['close_esc_key'] : 'true',
				'options' => array(
					array('name' => __('Yes','cmb'), 'value' => 'true'),
					array('name' => __('Not','cmb'), 'value' => 'false'),
				),
				'desc' => __('<sub>Should popup close when press on escape?</sub>', 'cmb'),
			),
			array(
				'name' => __('Transition Effect', 'cmb'),
				'id' => $prefix. 'popup_transition',
				'type' => 'select',
				'default' => $pps_options['popup_transition'],
				'options' => array(
					array('name' => __('fadeIn', 'cmb'), 'value' => 'fadeIn'),
					array('name' => __('slideDown', 'cmb'), 'value' => 'slideDown'),
					array('name' => __('slideIn', 'cmb'), 'value' => 'slideIn'),
				),
				'desc' => __('<sub>The transition of the popup when it opens.</sub>', 'cmb'),
			),
			array(
				'name' => __('Transition Delay (ms)', 'cmb'),
				'id' => $prefix. 'speed',
				'type' => 'text',
				'default' => $pps_options['popup_speed'],
				'desc' => __('<sub>Animation speed on open/close, in milliseconds</sub>', 'cmb'),
			),
			array(
				'name' => __('Easing Effect', 'cmb'),
				'id' => $prefix. 'popup_easing',
				'type' => 'text',
				'default' => $pps_options['popup_easing'],
				'desc' => sprintf(__( '<sub>The easing of the popup when it opens. "swing" and "linear". More in %sjQuery Easing%s </sub>', 'cmb' ), '<a href="http://jqueryui.com/resources/demos/effect/easing.html" target="_blank">','</a>'),
			),
			array(
				'name' => __('Disable for logged users', 'cmb'),
				'id' => $prefix. 'disable_logged_user',
				'type' => 'radio_inline',
				'default' => $pps_options['disable_logged_user'],
				'options' => array(
					array('name' => __('Yes','cmb'), 'value' => 'true'),
					array('name' => __('Not','cmb'), 'value' => 'false'),
				),
				'desc' => __('<sub>The popups will be deactivated for the logged users</sub>', 'cmb'),
			),
		)
	);

	$meta_boxes[] = array(
		'id' => 'settings_mbox_cmb',
		'title' => __('Popup Configuration', 'cmb'),
		'pages' => array('popuppress'),
		'context' => 'side',
		'priority' => 'default',
		'show_names' => true, // Show field names on the left
		'fields' => array(
			array(
				'name' => __('Background for popup', 'cmb'),
				'id' => $prefix. 'bg_content',
				'type' => 'colorpicker',
				'default' => $pps_options['bg_content'],
			),
			array(
				'name' => __('Popup Width', 'cmb'),
				'id' => $prefix. 'width',
				'type' => 'text_small',
				'default' => $pps_options['popup_width'],
				'desc' => __('', 'cmb'),
			),
			array(
				'name' => __('Width units', 'cmb'),
				'id' => $prefix. 'width_units',
				'type' => 'radio_inline',
				'default' => 'px',
				'options' => array(
					array('name' => __('px','cmb'), 'value' => 'px'),
					array('name' => __('%','cmb'), 'value' => '%'),
				),
				'desc' => __('', 'cmb'),
			),
			array(
				'name' => __('Popup Height', 'cmb'),
				'id' => $prefix. 'auto_height',
				'type' => 'radio',
				'default' => $pps_options['auto_height'],
				'options' => array(
					array('name' => __('Auto Height <dfn>The height is automatically adjust to content</dfn>','cmb'), 'value' => 'true'),
					array('name' => __('Custom Height','cmb'), 'value' => 'false'),
				),
			),
			array(
				'name' => __('Define Height', 'cmb'),
				'id' => $prefix. 'height',
				'type' => 'text_small',
				'default' => $pps_options['popup_height'],
			),
			array(
				'name' => __('Height units', 'cmb'),
				'id' => $prefix. 'height_units',
				'type' => 'radio_inline',
				'default' => 'px',
				'options' => array(
					array('name' => __('px','cmb'), 'value' => 'px'),
					array('name' => __('%','cmb'), 'value' => '%'),
				),
				'desc' => __('', 'cmb'),
			),
			array(
				'name' => __('Padding', 'cmb'),
				'id' => $prefix. 'pad_top',
				'type' => 'text_small',
				'default' => 15,
				'desc' => __('<sub>Top. Add 00 if you don\'t want padding top.</sub>', 'cmb'),
			),
			array(
				'name' => __('Padding right', 'cmb'),
				'id' => $prefix. 'pad_right',
				'type' => 'text_small',
				'default' => 20,
				'desc' => __('<sub>Right. Add 00 if you don\'t want padding right.</sub>', 'cmb'),
			),
			array(
				'name' => __('Padding bottom', 'cmb'),
				'id' => $prefix. 'pad_bottom',
				'type' => 'text_small',
				'default' => 15,
				'desc' => __('<sub>Bottom. Add 00 if you don\'t want padding bottom.</sub>', 'cmb'),
			),
			array(
				'name' => __('Padding left', 'cmb'),
				'id' => $prefix. 'pad_left',
				'type' => 'text_small',
				'default' => 20,
				'desc' => __('<sub>Left. Add 00 if you don\'t want padding left.</sub>', 'cmb'),
			),
			array(
				'name' => __('Spacing of content', 'cmb'),
				'id' => $prefix. 'spacing_content',
				'type' => 'text',
				'default' => '00',
				'desc' => __('<sub>Inner spacing of the content. Add 00 if you don\'t want spacing.</sub>', 'cmb'),
			),
			array(
				'name' => __('Border', 'cmb'),
				'id' => $prefix. 'border_popup',
				'type' => 'text',
				'default' => $pps_options['border_popup'],
				'desc' => __('<sub>Add 00 if you do not want transparent border.</sub>', 'cmb'),
			),
			array(
				'name' => __('Border Color', 'cmb'),
				'id' => $prefix. 'border_color',
				'type' => 'colorpicker',
				'default' => '#000000',
			),
			array(
				'name' => __('Border Opacity', 'cmb'),
				'id' => $prefix. 'border_opacity',
				'type' => 'text',
				'default' => 0.4,
				'desc' => __('<sub>Transparency, from 0.1 to 1</sub>', 'cmb'),
			),
			array(
				'name' => __('Border Radius', 'cmb'),
				'id' => $prefix. 'border_radius',
				'type' => 'text',
				'default' => $pps_options['border_radius'],
				'desc' => __('<sub>Add value rounded corners to popup. Add 00 if you do not want rounded edges.</sub>', 'cmb'),
			),
			array(
				'name' => __('Font Size', 'cmb'),
				'id' => $prefix. 'size_text_content',
				'type' => 'text',
				'default' => 16,
				'desc' => __('', 'cmb'),
			),
			array(
				'name' => 'No use font sizes',
				'desc' => __('No use font sizes', 'cmb'),
				'id' => $prefix . 'no_font_sizes',
				'type' => 'checkbox'
			),
			array(
				'name' => __('Position Type', 'cmb'),
				'id' => $prefix. 'position_type',
				'type' => 'select',
				'default' => $pps_options['position_type'],
				'options' => array(
					array('name' => __('Absolute', 'cmb'), 'value' => 'absolute'),
					array('name' => __('Fixed', 'cmb'), 'value' => 'fixed'),
				),
				'desc' => '',
			),
			array(
				'name' => __('Position X', 'cmb'),
				'id' => $prefix. 'position_x',
				'type' => 'text',
				'default' => $pps_options['position_x'],
				'desc' => __('<sub>Position horizontal the popup. auto=center</sub>', 'cmb'),
			),
			array(
				'name' => __('Position Y', 'cmb'),
				'id' => $prefix. 'position_y',
				'type' => 'text',
				'default' => $pps_options['position_y'],
				'desc' => __('<sub>Position vertical the popup. auto=center</sub>', 'cmb'),
			),

			array(
				'name' => 'Title Popup',
				'desc' => __('', 'cmb'),
				'type' => 'title',
				'id' => $prefix . 'title_popup'
			),
			array(
				'name' => __('Show Title', 'cmb'),
				'id' => $prefix. 'show_title',
				'type' => 'radio_inline',
				'default' => $pps_options['show_title'],
				'options' => array(
					array('name' => __('Yes','cmb'), 'value' => 'true'),
					array('name' => __('Not','cmb'), 'value' => 'false'),
				),
				'desc' => __('<sub>Displays the title of the popup</sub>', 'cmb'),
			),
			array(
				'name' => __('Color text title', 'cmb'),
				'id' => $prefix. 'color_text_title',
				'type' => 'colorpicker',
				'default' => '#444444',
			),
			array(
				'name' => __('Background for title', 'cmb'),
				'id' => $prefix. 'bg_title',
				'type' => 'colorpicker',
				'default' => '#FFFFFF',
			),
			array(
				'name' => __('Font size of title', 'cmb'),
				'id' => $prefix. 'size_text_title',
				'type' => 'text',
				'default' => 20,
				'desc' => __('', 'cmb'),
			),
			array(
				'name'    => __('Align of title', 'cmb'),
				'desc'    => __('', 'cmb'),
				'id'      => $prefix . 'align_title',
				'type'    => 'select',
				'options' => array(
					'left' 	=> __( 'Left', 'cmb' ),
					'center'	=> __( 'Center', 'cmb' ),
					'right'  => __( 'Right', 'cmb' ),
				),
				'default' => 'left',
			),
			array(
				'name' => __('Border bottom of title', 'cmb'),
				'id' => $prefix. 'color_border_title',
				'type' => 'colorpicker',
				'default' => '#EEEEEE',
			),

			array(
				'name' => __('Padding title', 'cmb'),
				'id' => $prefix. 'pad_top_title',
				'type' => 'text_small',
				'default' => '00',
				'desc' => __('<sub>Margin top to the title. Add 00 if you don\'t want add margin top</sub>', 'cmb'),
			),
			array(
				'name' => __('Padding right title', 'cmb'),
				'id' => $prefix. 'pad_right_title',
				'type' => 'text_small',
				'default' => '00',
				'desc' => __('<sub>Margin right to the title. Add 00 if you don\'t want add margin right</sub>', 'cmb'),
			),
			array(
				'name' => __('Padding bottom title', 'cmb'),
				'id' => $prefix. 'pad_bottom_title',
				'type' => 'text_small',
				'default' => 10,
				'desc' => __('<sub>Margin bottom to the title. Add 00 if you don\'t want add margin bottom</sub>', 'cmb'),
			),
			array(
				'name' => __('Padding left title', 'cmb'),
				'id' => $prefix. 'pad_left_title',
				'type' => 'text_small',
				'default' => '00',
				'desc' => __('<sub>Margin left to the title. Add 00 if you don\'t want add margin left</sub>', 'cmb'),
			),

			array(
				'name' => 'Overlay windows',
				'desc' => __('', 'cmb'),
				'type' => 'title',
				'id' => $prefix . 'title_popup'
			),
			array(
				'name' => __('Color of Overlay', 'cmb'),
				'id' => $prefix. 'bg_overlay',
				'type' => 'colorpicker',
				'default' => $pps_options['bg_overlay'],
			),
			array(
				'name' => __('Opacity Overlay', 'cmb'),
				'id' => $prefix. 'opacity',
				'type' => 'text',
				'default' => $pps_options['opacity_overlay'],
				'desc' => __('<sub>Transparency, from 0.1 to 1</sub>', 'cmb'),
			),
			array(
				'name' => 'Image of Overlay',
				'id' => $prefix . 'img_overlay',
				'type' => 'file',
				'save_id' => false, // save ID using true
				'desc' => __('<sub></sub>', 'cmb'),
			),
		)
	);

	$meta_boxes[] = array(
		'id' => 'close_btn_mbox_cmb',
		'title' => __('Settings to Close Button', 'cmb'),
		'pages' => array('popuppress'),
		'context' => 'side',
		'priority' => 'default',
		'show_names' => true, // Show field names on the left
		'fields' => array(
			array(
				'name' => __('Show Close Button', 'cmb'),
				'id' => $prefix. 'show_close',
				'type' => 'radio_inline',
				'default' => 'true',
				'options' => array(
					array('name' => __('Yes','cmb'), 'value' => 'true'),
					array('name' => __('Not','cmb'), 'value' => 'false'),
				),
				'desc' => __('<sub>Displays the X icon close of the popup</sub>', 'cmb'),
			),
			array(
				'name'    => __('Select Icon', 'cmb'),
				'desc'    => __('', 'cmb'),
				'id'      => $prefix . 'icon_close_btn',
				'type'    => 'select',
				'options' => array(
					'pps-icon-close' 					=> __( 'Default', 'cmb' ),
					'pps-icon-close-circle'   		=> __( 'Circle', 'cmb' ),
					'pps-icon-close-circle-outline'=> __( 'Circle outline', 'cmb' ),
					'pps-icon-close-clear'     		=> __( 'Clear', 'cmb' ),
					'pps-icon-close-circle-cross'  => __( 'Circle cross', 'cmb' ),
					'pps-icon-close-square-radius' => __( 'Square radius', 'cmb' ),
					'pps-icon-close-file-broken'  	=> __( 'File broken', 'cmb' ),
					'pps-icon-close-error'  			=> __( 'Error', 'cmb' ),
					'pps-icon-close-outline'  		=> __( 'Outline', 'cmb' ),
				),
				'default' => 'pps-icon-close',
			),
			array(
				'name' => __('X Icon size', 'cmb'),
				'id' => $prefix. 'size_close_btn',
				'type' => 'text',
				'default' => 18,
				'desc' => __('<sub>Set a size for the X icon</sub>', 'cmb'),
			),
			array(
				'name' => __('X Icon Color', 'cmb'),
				'id' => $prefix. 'color_close_btn',
				'type' => 'colorpicker',
				'default' => '#999999',
			),
			array(
				'name' => __('X Icon Hover-Color ', 'cmb'),
				'id' => $prefix. 'color_close_btn_hover',
				'type' => 'colorpicker',
				'default' => '#222222',
			),
			array(
				'name' => __('Background', 'cmb'),
				'id' => $prefix. 'bg_close_btn',
				'type' => 'colorpicker',
				'default' => '#FFFFFF',
			),
			array(
				'name' => 'Without background',
				'desc' => __('Without background', 'cmb'),
				'id' => $prefix . 'no_bg_close_btn',
				'type' => 'checkbox'
			),

			array(
				'name' => __('Border Radius', 'cmb'),
				'id' => $prefix. 'close_btn_border_radius',
				'type' => 'text',
				'default' => 18,
				'desc' => __('<sub>This option rounds the contour of close button. Add 00 if you do not want rounded edges</sub>', 'cmb'),
			),

			array(
				'name' => __('Reference position', 'cmb'),
				'id' => $prefix. 'ref_pos_close_btn',
				'type' => 'radio',
				'default' => 'popup',
				'options' => array(
					array('name' => __('Popup','cmb'), 'value' => 'popup'),
					array('name' => __('Page','cmb'), 'value' => 'page'),
				),
			),
			array(
				'name' => __('Position', 'cmb'),
				'id' => $prefix. 'margin_top_close_btn',
				'type' => 'text_small',
				'default' => -14,
				'desc' => __('<sub>Position Y</sub>', 'cmb'),
			),
			array(
				'name' => __('Margin right', 'cmb'),
				'id' => $prefix. 'margin_right_close_btn',
				'type' => 'text_small',
				'default' => -14,
				'desc' => __('<sub>Position X</sub>', 'cmb'),
			),
			array(
				'name' => __('Transparent container', 'cmb'),
				'id' => $prefix. 'show_wrap_close_btn',
				'type' => 'radio_inline',
				'default' => 'true',
				'options' => array(
					array('name' => __('Yes','cmb'), 'value' => 'true'),
					array('name' => __('Not','cmb'), 'value' => 'false'),
				),
				'desc' => __('', 'cmb'),
			),
		),
	);

	return $meta_boxes;
}

add_action( 'init', 'cmb_initialize_metaboxes_popuppress', 9999 );
/**
 * Initialize the metabox class.
 */
function cmb_initialize_metaboxes_popuppress() {

	if ( ! class_exists( 'cmb_Meta_Box_PPS' ) ){
		require_once 'init.php';
	}
}

include_once('custom_field_types.php');
