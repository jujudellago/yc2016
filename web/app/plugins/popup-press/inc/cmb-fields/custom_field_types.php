<?php

/* --------------------------------------------------------------------
   Campo Personalizado: Vista Previa
-------------------------------------------------------------------- */

add_action( 'cmb_render_popup_preview', 'popup_preview_field_PPS', 10, 5 );
function popup_preview_field_PPS($field_args, $escaped_value, $object_id, $object_type, $field_type_object) {
	// Get the current ID
	$popup_id = isset($_GET['post']) ? $_GET['post']: 0;
	$pps_data = get_post_custom($popup_id);
	$button_type = isset($pps_data['pps_button_type'][0]) ? $pps_data['pps_button_type'][0] : 'button';
	if($popup_id > 0 && get_post_status($popup_id) == 'publish') {
		if($button_type == 'no-button'){
			echo '<p>Without button</p>';
		} else {
			echo get_button_popup_PPS($popup_id);
		}
		/**
		 * El script y el cuerpo del popup se cargan con la siguiente función
		 * add_popup_admin_footer_PPS() en el archivo pps_functions.php
		 */
	}
	else {
		echo $field_args['default'];
	}
}

/* --------------------------------------------------------------------
   Campo Personalizado: Texto Plano
-------------------------------------------------------------------- */
add_action( 'cmb_render_plain_text', 'plain_text_field_PPS', 10, 5 );
function plain_text_field_PPS($field_args, $escaped_value, $object_id, $object_type, $field_type_object) {
	echo $field_args['default'];
	echo '<p class="cmb_metabox_description"><sub>'.$field_args['desc'].'</sub></p>';
}

/* --------------------------------------------------------------------
   Campo Personalizado: Botón
-------------------------------------------------------------------- */
add_action( 'cmb_render_boton', 'boton_field_PPS', 10, 5 );
function boton_field_PPS($field_args, $escaped_value, $object_id, $object_type, $field_type_object) {
	// Get the current ID
	$popup_id = isset($_GET['post']) ? $_GET['post']: 0;
	echo '<input type="button" value="'.$field_args['default'].'" class="pps-remove-cookie button" id="pps-remove-cookie-'.$popup_id.'">';
}

?>