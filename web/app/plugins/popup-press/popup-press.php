<?php
/*
Plugin Name: PopupPress
Description: Easily create elegant popups and pop-over. PopupPress is responsive and have many options to customize your popups.
Version: 2.1.8
Author: Max A. López
*/
//Copyright 2013 Max A. López


/* --------------------------------------------------------------------
   Definimos Constantes
-------------------------------------------------------------------- */
define( 'PPS_PLUGIN_NAME', 'PopupPress' );
define( 'PPS_VERSION', '2.1.8' );
define( 'PPS_PATH', dirname( __FILE__ ) );
define( 'PPS_FOLDER', basename( PPS_PATH ) );
define( 'PPS_URL', plugins_url() . '/' . PPS_FOLDER );

/* --------------------------------------------------------------------
   Configuración de Acciones y Ganchos
-------------------------------------------------------------------- */
register_activation_hook(__FILE__, 'install_options_PPS');
//register_uninstall_hook
register_deactivation_hook(__FILE__, 'delete_options_PPS');

add_action('admin_init', 'requires_wordpress_version_PPS' );
add_action('admin_init', 'register_options_PPS' );
add_action('admin_menu', 'add_options_page_PPS');
add_action('admin_notices', 'admin_notices_PPS');
add_filter('plugin_action_links', 'plugin_action_links_PPS', 10, 2 );
add_action('wp_enqueue_scripts', 'add_styles_PPS' );
add_action('wp_enqueue_scripts', 'add_scripts_PPS', 121 );
add_action('admin_enqueue_scripts', 'add_admin_styles_PPS');
add_action('admin_enqueue_scripts', 'add_admin_scripts_PPS');
add_action('wp_enqueue_scripts', 'fix_jquery_problem_PPS', 21 );


/* --------------------------------------------------------------------
   Comprobamos si la version actual de WordPress es Compatible con el Plugin
-------------------------------------------------------------------- */
function requires_wordpress_version_PPS() {
	global $wp_version;
	$plugin = plugin_basename( __FILE__ );
	$plugin_data = get_plugin_data( __FILE__, false );

	if ( version_compare($wp_version, "3.5", "<" ) ) {
		if( is_plugin_active($plugin) ) {
			deactivate_plugins( $plugin );
			wp_die( "'".$plugin_data['Name']."' requires Wordpress 3.5 or higher, and is disabled, you must update Wordpress.<br /><br />Return to the <a href='".admin_url()."'>desktop WordPress</a>." );
		}
	}
}

/* --------------------------------------------------------------------
   Registramos las Opciones del Plugin
-------------------------------------------------------------------- */
function register_options_PPS(){
	//Thumbnails size
	add_image_size('pps_thumbnails', 400, 300, true);

	register_setting('pps_group_options','pps_options');
	$pps_options = get_option('pps_options');
	$restore_options = isset($pps_options['default_options']) ? $pps_options['default_options'] : 'false';

	//Si está marcada la opción de restaurar a los valores por defecto
	if($restore_options == 'true'){
		$default_options = default_options_PPS();
		update_option('pps_options', $default_options);
	}
}

/* --------------------------------------------------------------------
   Valores por Defecto de las Opciones del Plugin
-------------------------------------------------------------------- */
function default_options_PPS(){
	return array(
		'popup_style' => 'light',
		'bg_content' => '#FFFFFF',
		'border_popup' => 8,
		'border_radius' => 5,
		'popup_width' => 640,
		'popup_height' => '',
		'auto_height' => 'true',
		'show_title' => 'false',
		'bg_overlay' => '#000000',
		'opacity_overlay' => 0.75,
		'position_type' => 'absolute',
		'position_x' => 'auto',
		'position_y' => 'auto',
		'popup_speed' => 300,
		'popup_zindex' => 99999,
		'close_overlay' => 'true',
		'close_esc_key' => 'true',
		'popup_transition' => 'fadeIn',
		'popup_easing' => 'swing',

		'button_text' => 'Open Popup',
		'button_title' => 'Click here to open Popup',
		'button_class' => 'pps-button-popup',
		'img_width_button' => 160,

		'slider_auto' => 'false',
		'slider_animation_speed' => 600,
		'slider_timeout' => 6000,
		'slider_pagination' => 'true',
		'slider_arrows' => 'true',
		'slider_pause' => 'true',
		'where_open_link' => '_blank',

		'disable_logged_user' => 'false',
		'prevent_mobile' => 'false',
		'embed_width' => 100,
		'emded_width_unit' => '%',
		'embed_height' => 460,
		'use_wp_editor' => 'true',
		'fix_jquery' => 'false',

		'default_options' => 'false'
	);
}
/* --------------------------------------------------------------------
   Establecemos Opciones del Plugin
-------------------------------------------------------------------- */
function install_options_PPS() {
	$pps_options = get_option('pps_options');
	$default_options = default_options_PPS();
	if(is_array($pps_options) && !empty($pps_options)){
		$set_options = array_merge($default_options, $pps_options);
	} else {
		$set_options = $default_options;
	}
	update_option('pps_options', $set_options);

	//Opción de compatibilidad
	$compatibility_option = get_option('pps_compatibility_option');
	if($compatibility_option !== false){
		update_option('pps_compatibility_option', $compatibility_option );
	} else {
		add_option('pps_compatibility_option', false);
	}
}

function admin_notices_PPS() {
	$compatibility_option = get_option('pps_compatibility_option');
	$count_popups = wp_count_posts('popuppress');
	$page_edit = isset($_GET['page'] ) ? $_GET['page'] : '';

	if($count_popups->publish > 0 && $compatibility_option == false && $page_edit != 'popuppress-compatibility.php'){
		$notice= 'We have improved and added features to <strong>'.PPS_PLUGIN_NAME. '</strong>, therefore it is necessary to make a compatibility update. <strong><a href="'.get_admin_url().'edit.php?post_type=popuppress&page=popuppress-compatibility.php">Begin compatibility.</a></strong>';
		echo "<div class='update-nag'>$notice</div>";
	}
}

/* --------------------------------------------------------------------
   Eliminamos las Opciones del Plugin cuando este se Desactiva
-------------------------------------------------------------------- */
function delete_options_PPS() {
	//No eliminar porque también se borran los valores establecidos por los usuarios
	//delete_option('pps_options');
}

/* --------------------------------------------------------------------
   Carga de Scripts jQuery y Estilos CSS
-------------------------------------------------------------------- */

function add_admin_scripts_PPS(){
	global $post, $wp_version;

	$post_type = isset($post->post_type) ? $post->post_type : '';
	$page_edit = isset($_GET['page'] ) ? $_GET['page'] : '';

	if($post_type == 'popuppress' || strpos($page_edit, 'popuppress-') !== false){

		//If the WordPress version is greater than or equal to 3.5, then load the new WordPress color picker.

		if ( 3.5 <= $wp_version ){
			//Both the necessary css and javascript have been registered already by WordPress, so all we have to do is load them with their handle.

			wp_enqueue_style( 'wp-color-picker' );
			wp_enqueue_script( 'wp-color-picker' );
		}
		//If the WordPress version is less than 3.5 load the older farbtasic color picker.
		else {

			//As with wp-color-picker the necessary css and javascript have been registered already by WordPress, so all we have to do is load them with their handle.

			wp_enqueue_style( 'farbtastic' );
			wp_enqueue_script( 'farbtastic' );

		}
		// Loading JS using wp_enqueue
		wp_register_script( 'pps_admin_script', PPS_URL.'/js/pps_admin_script.js', false, PPS_VERSION , false );
		wp_enqueue_script( 'pps_admin_script' );

		add_scripts_PPS();
	}
}

function fix_jquery_problem_PPS(){
	$pps_options = get_option('pps_options');
	//If the user wants to load jquery
	if(isset($pps_options['fix_jquery']) and $pps_options['fix_jquery'] == 'true' && !is_admin() ){
		wp_deregister_script('jquery');
		wp_register_script('jquery', "https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js", false, '1.11.3', false);
		wp_enqueue_script('jquery');
	}
}

function add_scripts_PPS() {
	global $wp_version;
	echo "\t<!-- PopupPress Plugin v.".PPS_VERSION." - ".str_replace('3.','',$wp_version)." -->\n";
	// Loading JS using wp_enqueue

	// Plugin jQuery - bPopup
	wp_register_script( 'pps_bPopup', PPS_URL.'/js/libs/bpopup.js', false, '0.10', false );
	wp_enqueue_script( 'pps_bPopup' );

	// Plugin jQuery - flexSlider(Cambié el nombre por incompatibilidad con algunas versiones antiguas)
	wp_register_script( 'pps_popupslider', PPS_URL.'/js/libs/jquery.popupslider.js', false, '2.5.0', false );
	wp_enqueue_script( 'pps_popupslider' );

	// Plugin jQuery - jQuery Cookies
	wp_register_script( 'pps_jCookie', PPS_URL.'/js/libs/jquery.cookie.js', false, '1.4.1', false );
	wp_enqueue_script( 'pps_jCookie' );

	// Plugin jQuery - Easing
	wp_register_script( 'pps_easing', PPS_URL.'/js/libs/jquery.easing.1.3.js', false, '1.3', false );
	wp_enqueue_script( 'pps_easing' );

	// Añadimos el Script JS Principal
	wp_register_script( 'pps_js_script', PPS_URL.'/js/pps_script.js', false, PPS_VERSION, false );
	wp_enqueue_script( 'pps_js_script' );

	wp_localize_script('pps_js_script','PPS',
		array(
			'ajaxurlPps' => admin_url('admin-ajax.php'),
		)
	);
}


function add_admin_styles_PPS() {
	global $post;
	$post_type = isset($post->post_type) ? $post->post_type : '';
	$page_edit = isset($_GET['page'] ) ? $_GET['page'] : '';

	if($post_type == 'popuppress' || strpos($page_edit, 'popuppress-') !== false){
		wp_register_style( 'pps_admin_style', PPS_URL.'/css/pps_admin_style.css', array(), PPS_VERSION, 'screen' );
		wp_enqueue_style( 'pps_admin_style' );

		add_styles_PPS();
	}
}

function add_styles_PPS() {
	// Loading CSS using wp_enqueue
	wp_register_style( 'pps_style', PPS_URL.'/css/pps_style.css', array(), PPS_VERSION, 'screen' );
	wp_enqueue_style( 'pps_style' );
}

/* --------------------------------------------------------------------
   Añadimos La Página de Opciones al Ménu
-------------------------------------------------------------------- */
function add_options_page_PPS() {
	add_submenu_page('edit.php?post_type=popuppress', PPS_PLUGIN_NAME. ' Settings' , 'Settings' , 'manage_options', 'popuppress-settings.php', 'add_options_form_PPS');

	add_submenu_page('edit.php?post_type=popuppress', PPS_PLUGIN_NAME. ' Compatibility' , 'Compatibility' , 'manage_options', 'popuppress-compatibility.php', 'add_compatibility_page_PPS');

	//Link Scripts Only on a Plugin Administration Screen
	//add_action('admin_print_scripts-' . $page_pps, 'add_admin_scripts_PPS');
}
/* --------------------------------------------------------------------
   Añadimos el Formulario de Opciones a la Página
-------------------------------------------------------------------- */
function add_options_form_PPS() {
	include_once( 'inc/pps_options-page.php' );
}

function add_compatibility_page_PPS() {
	include_once( 'inc/pps_compatibility-page.php' );
}

/* --------------------------------------------------------------------
    Mostramos el Link de Ajustes al Plugin
-------------------------------------------------------------------- */
function plugin_action_links_PPS( $links, $file ) {
	if ( $file == plugin_basename( __FILE__ ) ) {
		$pps_links = '<a href="'.get_admin_url().'edit.php?post_type=popuppress&page=popuppress-settings.php">'.__('Settings').'</a>';
		// make the 'Settings' link appear first
		array_unshift( $links, $pps_links );
	}
	return $links;
}

/* --------------------------------------------------------------------
   Añadimos las Fuciones Principales del Plugin
-------------------------------------------------------------------- */
include_once( 'inc/pps_functions.php' );

/* --------------------------------------------------------------------
   Carga Meta Boxes solo en las páginas del Plugin
-------------------------------------------------------------------- */
include_once('inc/cmb-fields/metaboxes.php');

?>