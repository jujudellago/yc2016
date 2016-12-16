<?php
$pps_options = get_option('pps_options');
?>
<div class="wrap pps-admin-page">
	<h2 class="pps-title-settings"><?php _e( PPS_PLUGIN_NAME . ' Settings', 'PPS' );?></h2>

    <?php
		if ( ! isset( $_REQUEST['settings-updated'] ) )
			$_REQUEST['settings-updated'] = false;
		?>
		<?php if ( false !== $_REQUEST['settings-updated'] ) : ?>
		<div class="message updated" style="width:80%"><p><strong><?php _e( 'Options saved', 'PPS' ); ?></strong></p></div>
	<?php endif; ?>

<h2 id="pps-tabs" class="nav-tab-wrapper">
    <a class="nav-tab" href="#pps-tab1"><?php _e('Popup Configuration', 'PPS');?></a>
    <a class="nav-tab" href="#pps-tab2"><?php _e('Popup Button', 'PPS');?></a>

    <a class="nav-tab" href="#pps-tab3"><?php _e('Popup Slider', 'PPS');?></a>
    <a class="nav-tab" href="#pps-tab4"><?php _e('General', 'PPS');?></a>
</h2>
<form id="pps-form" action="<?php echo admin_url('options.php');?>" method="post" >
	<?php settings_fields('pps_group_options'); ?>
    <div class="pps-tab-container">
        <div id="pps-tab1" class="pps-tab-content">

        	<!-- Popup Style -->
            <fieldset class="pps-option-group pps-option-text">
                <div class="pps-option-name">
                    <label for="pps-bg-content"><?php _e( 'Background Color', 'PPS' ); ?></label>
                </div><!--.pps-option-name-->
                <div class="pps-option-content pps-clearfix">
                    <div class="pps-option-item pps-input-s">
                       <input class="pps-colorpicker" id="pps-bg-content" type="text" name="pps_options[bg_content]" value="<?php echo $pps_options['bg_content']; ?>" />
                       <p class="pps-option-info"><?php _e( '', 'PPS' ); ?></p>
                    </div><!--.pps-option-item-->

                </div><!--.pps-option-content-->
            </fieldset>

            <fieldset class="pps-option-group pps-option-text">
                <div class="pps-option-name">
                    <label for="pps-border-popup"><?php _e( 'Border Popup', 'PPS' ); ?></label>
                </div><!--.pps-option-name-->
                <div class="pps-option-content pps-clearfix">
                    <div class="pps-option-item pps-input-s">
                       <input id="pps-border-popup" type="text" name="pps_options[border_popup]" value="<?php echo $pps_options['border_popup']; ?>" />
                       <span class="pps-option-info"><?php _e( '(px). Border thickness for the popups. 00 = No border.', 'PPS' ); ?></span>
                    </div><!--.pps-option-item-->

                </div><!--.pps-option-content-->
            </fieldset>

            <!-- Border Radius -->
            <fieldset class="pps-option-group pps-option-text">
                <div class="pps-option-name">
                    <label for="pps-border-radius"><?php _e( 'Border Radius', 'PPS' ); ?></label>
                </div><!--.pps-option-name-->
                <div class="pps-option-content pps-clearfix">
                	<div class="pps-option-item pps-input-s">
                       <input id="pps-border-radius" type="text" name="pps_options[border_radius]" value="<?php echo $pps_options['border_radius']; ?>" />
                       <span class="pps-option-info"><?php _e( '(px). Add value rounded corners to popup. 00 = no rounded corners.', 'PPS' ); ?></span>
                    </div><!--.pps-option-item-->

                </div><!--.pps-option-content-->
            </fieldset>

            <!-- Popup Width -->
            <fieldset class="pps-option-group pps-option-text">
                <div class="pps-option-name">
                    <label for="pps-popup-width"><?php _e( 'Popup Width', 'PPS' ); ?></label>
                </div><!--.pps-option-name-->
                <div class="pps-option-content pps-clearfix">
                	<div class="pps-option-item pps-input-s">
                       <input id="pps-popup-width" type="text" name="pps_options[popup_width]" value="<?php echo $pps_options['popup_width']; ?>" />
                       <span class="pps-option-info"><?php _e( '(px). Add the width of the popup box', 'PPS' ); ?></span>
                    </div><!--.pps-option-item-->

                </div><!--.pps-option-content-->
            </fieldset>

            <!-- Popup Height -->
            <fieldset class="pps-option-group pps-option-text">
                <div class="pps-option-name">
                    <label for="pps-popup-width"><?php _e( 'Popup Height', 'PPS' ); ?></label>
                </div><!--.pps-option-name-->
                <div class="pps-option-content pps-clearfix">
                	<div class="pps-option-item pps-input-s">
                       <input id="pps-popup-height" type="text" name="pps_options[popup_height]" value="<?php echo $pps_options['popup_height']; ?>" />
                       <span class="pps-option-info"><?php _e( '(px). Add the height of the popup box', 'PPS' ); ?></span>
                    </div><!--.pps-option-item-->

                </div><!--.pps-option-content-->
            </fieldset>

            <!-- Auto Height -->
            <fieldset class="pps-option-group pps-option-radio">
                <div class="pps-option-name">
                    <label><?php _e( 'Auto Height', 'PPS' ); ?></label>
                </div><!--.pps-option-name-->
                <div class="pps-option-content pps-clearfix">
                	<div class="pps-option-item pps-boxs-6">
                        <input id="pps-auto-height-true" name="pps_options[auto_height]" type="radio" value="true" <?php checked('true', $pps_options['auto_height']); ?> />
						<label for="pps-auto-height-true"><?php _e( 'Yes', 'PPS' ); ?></label>
                    </div><!--.pps-option-item-->
                	<div class="pps-option-item pps-boxs-6">
                        <input id="pps-auto-height-false" name="pps_options[auto_height]" type="radio" value="false" <?php checked('false', $pps_options['auto_height']); ?> />
						<label for="pps-auto-height-false"><?php _e( 'Not', 'PPS' ); ?></label>
                    </div><!--.pps-option-item-->
                    <p class="pps-option-info"><?php _e( 'Adjust height automatically', 'PPS' ); ?></p>
                </div><!--.pps-option-content-->
            </fieldset>

            <!-- Show Title -->
            <fieldset class="pps-option-group pps-option-radio">
                <div class="pps-option-name">
                    <label><?php _e( 'Show Title', 'PPS' ); ?></label>
                </div><!--.pps-option-name-->
                <div class="pps-option-content pps-clearfix">
                	<div class="pps-option-item pps-boxs-6">
                        <input id="pps-show-title-true" name="pps_options[show_title]" type="radio" value="true" <?php checked('true', $pps_options['show_title']); ?> />
						<label for="pps-show-title-true"><?php _e( 'Yes', 'PPS' ); ?></label>
                    </div><!--.pps-option-item-->
                	<div class="pps-option-item pps-boxs-6">
                        <input id="pps-show-title-false" name="pps_options[show_title]" type="radio" value="false" <?php checked('false', $pps_options['show_title']); ?> />
						<label for="pps-show-title-false"><?php _e( 'Not', 'PPS' ); ?></label>
                    </div><!--.pps-option-item-->
                    <p class="pps-option-info"><?php _e( 'Displays the title of the popup', 'PPS' ); ?></p>
                </div><!--.pps-option-content-->
            </fieldset>

            <!-- Background Overlay -->
            <fieldset class="pps-option-group pps-option-text">
                <div class="pps-option-name">
                    <label for="pps-bg-overlay"><?php _e( 'Background Overlay', 'PPS' ); ?></label>
                </div><!--.pps-option-name-->
                <div class="pps-option-content pps-clearfix">
                	<div class="pps-option-item pps-input-s">
                       <input class="pps-colorpicker" id="pps-bg-overlay" type="text" name="pps_options[bg_overlay]" value="<?php echo $pps_options['bg_overlay']; ?>" />
                       <p class="pps-option-info"><?php _e( '', 'PPS' ); ?></p>
                    </div><!--.pps-option-item-->

                </div><!--.pps-option-content-->
            </fieldset>

            <!-- Opacity Overlay -->
            <fieldset class="pps-option-group pps-option-text">
                <div class="pps-option-name">
                    <label for="pps-opacity-overlay"><?php _e( 'Opacity Overlay', 'PPS' ); ?></label>
                </div><!--.pps-option-name-->
                <div class="pps-option-content pps-clearfix">
                	<div class="pps-option-item pps-input-s">
                       <input id="pps-opacity-overlay" type="text" name="pps_options[opacity_overlay]" value="<?php echo $pps_options['opacity_overlay']; ?>" />
                       <span class="pps-option-info"><?php _e( 'Transparency, from 0.1 to 1', 'PPS' ); ?></span>
                    </div><!--.pps-option-item-->

                </div><!--.pps-option-content-->
            </fieldset>

            <!-- Position Type -->
            <fieldset class="pps-option-group pps-option-select">
                <div class="pps-option-name">
                    <label><?php _e( 'Position Type', 'PPS' ); ?></label>
                </div><!--.pps-option-name-->
                <div class="pps-option-content pps-clearfix">

                	<div class="pps-option-item">
                        <select name="pps_options[position_type]">
                            <option value='absolute' <?php selected('absolute', $pps_options['position_type']); ?>><?php _e( 'Absolute', 'PPS' ); ?></option>
                            <option value='fixed' <?php selected('fixed', $pps_options['position_type']); ?>><?php _e( 'Fixed', 'PPS' ); ?></option>
						</select>
                    </div><!--.pps-option-item-->

                </div><!--.pps-option-content-->
            </fieldset>

            <!-- Position X -->
            <fieldset class="pps-option-group pps-option-text">
                <div class="pps-option-name">
                    <label for="pps-position-x"><?php _e( 'Position X', 'PPS' ); ?></label>
                </div><!--.pps-option-name-->
                <div class="pps-option-content pps-clearfix">
                	<div class="pps-option-item pps-input-s">
                       <input id="pps-position-x" type="text" name="pps_options[position_x]" value="<?php echo $pps_options['position_x']; ?>" />
                       <span class="pps-option-info"><?php _e( '(px). Position horizontal the popup. auto=center', 'PPS' ); ?></span>
                    </div><!--.pps-option-item-->

                </div><!--.pps-option-content-->
            </fieldset>

            <!-- Position Y -->
            <fieldset class="pps-option-group pps-option-text">
                <div class="pps-option-name">
                    <label for="pps-position-y"><?php _e( 'Position Y', 'PPS' ); ?></label>
                </div><!--.pps-option-name-->
                <div class="pps-option-content pps-clearfix">
                	<div class="pps-option-item pps-input-s">
                       <input id="pps-position-y" type="text" name="pps_options[position_y]" value="<?php echo $pps_options['position_y']; ?>" />
                       <span class="pps-option-info"><?php _e( '(px). Position vertical the popup. auto=center', 'PPS' ); ?></span>
                    </div><!--.pps-option-item-->

                </div><!--.pps-option-content-->
            </fieldset>

            <!-- Speed Open/Close -->
            <fieldset class="pps-option-group pps-option-text">
                <div class="pps-option-name">
                    <label for="pps-popup-speed"><?php _e( 'Speed Open/Close', 'PPS' ); ?></label>
                </div><!--.pps-option-name-->
                <div class="pps-option-content pps-clearfix">
                	<div class="pps-option-item pps-input-s">
                       <input id="pps-popup-speed" type="text" name="pps_options[popup_speed]" value="<?php echo $pps_options['popup_speed']; ?>" />
                       <span class="pps-option-info"><?php _e( 'Animation speed on open/close, in milliseconds', 'PPS' ); ?></span>
                    </div><!--.pps-option-item-->
                </div><!--.pps-option-content-->
			</fieldset>

            <!-- Popup z-index -->
            <fieldset class="pps-option-group pps-option-text">
                <div class="pps-option-name">
                    <label for="pps-popup-zindex"><?php _e( 'Popup z-index', 'PPS' ); ?></label>
                </div><!--.pps-option-name-->
                <div class="pps-option-content pps-clearfix">
                	<div class="pps-option-item pps-input-s">
                       <input id="pps-popup-zindex" type="text" name="pps_options[popup_zindex]" value="<?php echo $pps_options['popup_zindex']; ?>" />
                       <span class="pps-option-info"><?php _e( 'Set the z-index for Popup', 'PPS' ); ?></span>
                    </div><!--.pps-option-item-->
                </div><!--.pps-option-content-->
			</fieldset>

            <!-- Close Click Overlay -->
            <fieldset class="pps-option-group pps-option-radio">
                <div class="pps-option-name">
                    <label><?php _e( 'Close Click Overlay', 'PPS' ); ?></label>
                </div><!--.pps-option-name-->
                <div class="pps-option-content pps-clearfix">
                	<div class="pps-option-item pps-boxs-6">
                        <input id="pps-close-overlay-true" name="pps_options[close_overlay]" type="radio" value="true" <?php checked('true', $pps_options['close_overlay']); ?> />
						<label for="pps-close-overlay-true"><?php _e( 'Yes', 'PPS' ); ?></label>
                    </div><!--.pps-option-item-->
                	<div class="pps-option-item pps-boxs-6">
                        <input id="pps-close-overlay-false" name="pps_options[close_overlay]" type="radio" value="false" <?php checked('false', $pps_options['close_overlay']); ?> />
						<label for="pps-close-overlay-false"><?php _e( 'Not', 'PPS' ); ?></label>
                    </div><!--.pps-option-item-->
                    <p class="pps-option-info"><?php _e( 'Should the popup close on click on overlay?', 'PPS' ); ?></p>
                </div><!--.pps-option-content-->
            </fieldset>

            <fieldset class="pps-option-group pps-option-radio">
                <div class="pps-option-name">
                    <label><?php _e( 'Close ESC Key', 'PPS' ); ?></label>
                </div><!--.pps-option-name-->
                <div class="pps-option-content pps-clearfix">
                    <div class="pps-option-item pps-boxs-6">
                        <input id="pps-close-esc-key-true" name="pps_options[close_esc_key]" type="radio" value="true" <?php checked('true', $pps_options['close_esc_key']); ?> />
                        <label for="pps-close-esc-key-true"><?php _e( 'Yes', 'PPS' ); ?></label>
                    </div><!--.pps-option-item-->
                    <div class="pps-option-item pps-boxs-6">
                        <input id="pps-close-esc-key-false" name="pps_options[close_esc_key]" type="radio" value="false" <?php checked('false', $pps_options['close_esc_key']); ?> />
                        <label for="pps-close-esc-key-false"><?php _e( 'Not', 'PPS' ); ?></label>
                    </div><!--.pps-option-item-->
                    <p class="pps-option-info"><?php _e( 'Should the popup close on click on overlay?', 'PPS' ); ?></p>
                </div><!--.pps-option-content-->
            </fieldset>

            <!-- Popup Transition -->
            <fieldset class="pps-option-group pps-option-select">
                <div class="pps-option-name">
                    <label><?php _e( 'Transition Effect', 'PPS' ); ?></label>
                </div><!--.pps-option-name-->
                <div class="pps-option-content pps-clearfix">

                	<div class="pps-option-item">
                        <select name="pps_options[popup_transition]">
                            <option value='fadeIn' <?php selected('fadeIn', $pps_options['popup_transition']); ?>><?php _e( 'fadeIn', 'PPS' ); ?></option>
                            <option value='slideDown' <?php selected('slideDown', $pps_options['popup_transition']); ?>><?php _e( 'slideDown', 'PPS' ); ?></option>
                            <option value='slideIn' <?php selected('slideIn', $pps_options['popup_transition']); ?>><?php _e( 'slideIn', 'PPS' ); ?></option>
						</select>
                        <span class="pps-option-info"><?php _e( 'The transition of the popup when it opens.', 'PPS' ); ?></span>
                    </div><!--.pps-option-item-->

                </div><!--.pps-option-content-->
            </fieldset>


            <!-- Popup Easing -->
            <fieldset class="pps-option-group pps-option-text">
                <div class="pps-option-name">
                    <label for="pps-popup-easing"><?php _e( 'Easing Effect', 'PPS' ); ?></label>
                </div><!--.pps-option-name-->
                <div class="pps-option-content pps-clearfix">
                	<div class="pps-option-item pps-input-s">
                       <input id="pps-popup-easing" type="text" name="pps_options[popup_easing]" value="<?php echo $pps_options['popup_easing']; ?>" />
                       <span class="pps-option-info"><?php echo sprintf(__( 'The easing of the popup when it opens. "swing" and "linear". More in %sjQuery Easing%s', 'PPS' ), '<a href="http://jqueryui.com/resources/demos/effect/easing.html" target="_blank">','</a>'); ?></span>
                    </div><!--.pps-option-item-->
                </div><!--.pps-option-content-->
			</fieldset>

            <div style="margin-top:6px; border-bottom: 2px dashed #DDD;"></div>
            <fieldset class="pps-option-group pps-option-reset">
                <div class="pps-option-name">
                    <label for="pps-defaults"><?php _e( 'Reset options to default', 'PPS' ); ?></label>
                </div><!--.pps-option-name-->
                <div class="pps-option-content">
                    <input id="pps-defaults" name="pps_options[default_options]" type="checkbox" value="true" <?php if (isset($pps_options['default_options'])) { checked('true', $pps_options['default_options']); } ?> />
                    <label for="pps-defaults"><span style="color:#333333;margin-left:3px;"><?php _e( 'Restore to default values', 'PPS' ); ?></span></label>
                    <p class="pps-option-info"><?php _e( 'Mark this option only if you want to return to the original settings of the plugin.', 'PPS' ); ?></p>
                </div><!--.pps-option-content-->
            </fieldset>
        </div><!--.pps-tab1-->

        <div id="pps-tab2" class="pps-tab-content">
        	<!-- Button Text -->
            <fieldset class="pps-option-group pps-option-text">
                <div class="pps-option-name">
                    <label for="pps-button-text"><?php _e( 'Button Text', 'PPS' ); ?></label>
                </div><!--.pps-option-name-->
                <div class="pps-option-content pps-clearfix">
                	<div class="pps-option-item pps-input-m">
                       <input id="pps-button-text" type="text" name="pps_options[button_text]" value="<?php echo $pps_options['button_text']; ?>" />
                       <span class="pps-option-info"><?php _e( 'Text for the button that opens the popup', 'PPS' ); ?></span>
                    </div><!--.pps-option-item-->
                </div><!--.pps-option-content-->
			</fieldset>

            <!-- Button Title -->
            <fieldset class="pps-option-group pps-option-text">
                <div class="pps-option-name">
                    <label for="pps-button-title"><?php _e( 'Button Title', 'PPS' ); ?></label>
                </div><!--.pps-option-name-->
                <div class="pps-option-content pps-clearfix">
                	<div class="pps-option-item pps-input-m">
                       <input id="pps-button-title" type="text" name="pps_options[button_title]" value="<?php echo $pps_options['button_title']; ?>" />
                       <span class="pps-option-info"><?php _e( 'Button text on hover', 'PPS' ); ?></span>
                    </div><!--.pps-option-item-->
                </div><!--.pps-option-content-->
			</fieldset>

            <!-- Button Class -->
            <fieldset class="pps-option-group pps-option-text">
                <div class="pps-option-name">
                    <label for="pps-button-class"><?php _e( 'Button Style Class', 'PPS' ); ?></label>
                </div><!--.pps-option-name-->
                <div class="pps-option-content pps-clearfix">
                	<div class="pps-option-item pps-input-m">
                       <input id="pps-button-class" type="text" name="pps_options[button_class]" value="<?php echo $pps_options['button_class']; ?>" />
                       <span class="pps-option-info"><?php _e( 'Add a Class to customize your button using CSS Styles. Use "pps-plain-text" to leave the button without format.', 'PPS' ); ?></span>
                    </div><!--.pps-option-item-->
                </div><!--.pps-option-content-->
			</fieldset>

            <!-- Image Width Button -->
            <fieldset class="pps-option-group pps-option-text">
                <div class="pps-option-name">
                    <label for="pps-img-width-button"><?php _e( 'Image Width Button', 'PPS' ); ?></label>
                </div><!--.pps-option-name-->
                <div class="pps-option-content pps-clearfix">
                	<div class="pps-option-item pps-input-s">
                       <input id="pps-img-width-button" type="text" name="pps_options[img_width_button]" value="<?php echo $pps_options['img_width_button']; ?>" />
                       <span class="pps-option-info"><?php _e( 'Specifies the width in pixels of the image for the popup button', 'PPS' ); ?></span>
                    </div><!--.pps-option-item-->
                </div><!--.pps-option-content-->
			</fieldset>
            <div style="margin-top:6px; border-bottom: 2px dashed #DDD;"></div>

        </div><!--.pps-tab2-->

        <div id="pps-tab3" class="pps-tab-content">
            <!-- Animate automatically -->
            <fieldset class="pps-option-group pps-option-radio">
                <div class="pps-option-name">
                    <label><?php _e( 'Automatically animate', 'PPS' ); ?></label>
                </div><!--.pps-option-name-->
                <div class="pps-option-content pps-clearfix">
                	<div class="pps-option-item pps-boxs-6">
                        <input id="pps-slider-auto-true" name="pps_options[slider_auto]" type="radio" value="true" <?php checked('true', $pps_options['slider_auto']); ?> />
						<label for="pps-slider-auto-true"><?php _e( 'Yes', 'PPS' ); ?></label>
                    </div><!--.pps-option-item-->
                	<div class="pps-option-item pps-boxs-6">
                        <input id="pps-slider-auto-false" name="pps_options[slider_auto]" type="radio" value="false" <?php checked('false', $pps_options['slider_auto']); ?> />
						<label for="pps-slider-auto-false"><?php _e( 'Not', 'PPS' ); ?></label>
                    </div><!--.pps-option-item-->
                    <p class="pps-option-info"><?php _e( '', 'PPS' ); ?></p>
                </div><!--.pps-option-content-->
            </fieldset>

            <!-- Transition Speed -->
            <fieldset class="pps-option-group pps-option-text">
                <div class="pps-option-name">
                    <label for="pps-slider-speed"><?php _e( 'Transition speed', 'PPS' ); ?></label>
                </div><!--.pps-option-name-->
                <div class="pps-option-content pps-clearfix">
                	<div class="pps-option-item pps-input-s">
                       <input id="pps-slider-speed" type="text" name="pps_options[slider_animation_speed]" value="<?php echo $pps_options['slider_animation_speed']; ?>" />
                       <span class="pps-option-info"><?php _e( 'Speed of the transition, in milliseconds', 'PPS' ); ?></span>
                    </div><!--.pps-option-item-->
                </div><!--.pps-option-content-->
			</fieldset>

            <!-- TimeOut -->
            <fieldset class="pps-option-group pps-option-text">
                <div class="pps-option-name">
                    <label for="pps-slider-timeout"><?php _e( 'Timeout', 'PPS' ); ?></label>
                </div><!--.pps-option-name-->
                <div class="pps-option-content pps-clearfix">
                	<div class="pps-option-item pps-input-s">
                       <input id="pps-slider-timeout" type="text" name="pps_options[slider_timeout]" value="<?php echo $pps_options['slider_timeout']; ?>" />
                       <span class="pps-option-info"><?php _e( 'Time between slide transitions, in milliseconds', 'PPS' ); ?></span>
                    </div><!--.pps-option-item-->
                </div><!--.pps-option-content-->
			</fieldset>

            <!-- Pager -->
            <fieldset class="pps-option-group pps-option-radio">
                <div class="pps-option-name">
                    <label><?php _e( 'Show pagination', 'PPS' ); ?></label>
                </div><!--.pps-option-name-->
                <div class="pps-option-content pps-clearfix">
                	<div class="pps-option-item pps-boxs-6">
                        <input id="pps-slider-pager-true" name="pps_options[slider_pagination]" type="radio" value="true" <?php checked('true', $pps_options['slider_pagination']); ?> />
						<label for="pps-slider-pager-true"><?php _e( 'Yes', 'PPS' ); ?></label>
                    </div><!--.pps-option-item-->
                	<div class="pps-option-item pps-boxs-6">
                        <input id="pps-slider-pager-false" name="pps_options[slider_pagination]" type="radio" value="false" <?php checked('false', $pps_options['slider_pagination']); ?> />
						<label for="pps-slider-pager-false"><?php _e( 'Not', 'PPS' ); ?></label>
                    </div><!--.pps-option-item-->
                    <p class="pps-option-info"><?php _e( 'Displays small buttons to scroll between slider items', 'PPS' ); ?></p>
                </div><!--.pps-option-content-->
            </fieldset>

            <!-- Arrows -->
            <fieldset class="pps-option-group pps-option-radio">
                <div class="pps-option-name">
                    <label><?php _e( 'Show arrows', 'PPS' ); ?></label>
                </div><!--.pps-option-name-->
                <div class="pps-option-content pps-clearfix">
                	<div class="pps-option-item pps-boxs-6">
                        <input id="pps-slider-arrows-true" name="pps_options[slider_arrows]" type="radio" value="true" <?php checked('true', $pps_options['slider_arrows']); ?> />
						<label for="pps-slider-arrows-true"><?php _e( 'Yes', 'PPS' ); ?></label>
                    </div><!--.pps-option-item-->
                	<div class="pps-option-item pps-boxs-6">
                        <input id="pps-slider-arrows-false" name="pps_options[slider_arrows]" type="radio" value="false" <?php checked('false', $pps_options['slider_arrows']); ?> />
						<label for="pps-slider-arrows-false"><?php _e( 'Not', 'PPS' ); ?></label>
                    </div><!--.pps-option-item-->
                    <p class="pps-option-info"><?php _e( 'Displays arrows to scroll between slider items', 'PPS' ); ?></p>
                </div><!--.pps-option-content-->
            </fieldset>

            <!-- Pause -->
            <fieldset class="pps-option-group pps-option-radio">
                <div class="pps-option-name">
                    <label><?php _e( 'Pause on hover', 'PPS' ); ?></label>
                </div><!--.pps-option-name-->
                <div class="pps-option-content pps-clearfix">
                	<div class="pps-option-item pps-boxs-6">
                        <input id="pps-slider-pause-true" name="pps_options[slider_pause]" type="radio" value="true" <?php checked('true', $pps_options['slider_pause']); ?> />
						<label for="pps-slider-pause-true"><?php _e( 'Yes', 'PPS' ); ?></label>
                    </div><!--.pps-option-item-->
                	<div class="pps-option-item pps-boxs-6">
                        <input id="pps-slider-pause-false" name="pps_options[slider_pause]" type="radio" value="false" <?php checked('false', $pps_options['slider_pause']); ?> />
						<label for="pps-slider-pause-false"><?php _e( 'Not', 'PPS' ); ?></label>
                    </div><!--.pps-option-item-->
                    <p class="pps-option-info"><?php _e( 'Pause animation when the cursor is over the slider', 'PPS' ); ?></p>
                </div><!--.pps-option-content-->
            </fieldset>

            <!-- Open Link Slider Images -->
        	<fieldset class="pps-option-group pps-option-radio">
                <div class="pps-option-name">
                    <label><?php _e( 'Where to open links from slider images?', 'PPS' ); ?></label>
                </div><!--.pps-option-name-->
                <div class="pps-option-content pps-clearfix">
                	<div class="pps-option-item pps-boxs-3">
                        <input id="pps-where-open-link-true" name="pps_options[where_open_link]" type="radio" value="_blank" <?php checked('_blank', $pps_options['where_open_link']); ?> />
						<label for="pps-where-open-link-true"><?php _e( 'New Tab', 'PPS' ); ?></label>
                    </div><!--.pps-option-item-->
                	<div class="pps-option-item pps-boxs-3">
                        <input id="pps-where-open-link-false" name="pps_options[where_open_link]" type="radio" value="_self" <?php checked('_self', $pps_options['where_open_link']); ?> />
						<label for="pps-where-open-link-false"><?php _e( 'Current tab', 'PPS' ); ?></label>
                    </div><!--.pps-option-item-->
                    <spam class="pps-option-info"><?php _e( '', 'PPS' ); ?></spam>
                </div><!--.pps-option-content-->
            </fieldset>
            <div style="margin-top:6px; border-bottom: 2px dashed #DDD;"></div>
        </div><!--.pps-tab3-->

        <div id="pps-tab4" class="pps-tab-content">

        	<!-- Prevent on mobile -->
        	<fieldset class="pps-option-group pps-option-radio">
                <div class="pps-option-name">
                    <label><?php _e( 'Disable for logged users', 'PPS' ); ?></label>
                </div><!--.pps-option-name-->
                <div class="pps-option-content pps-clearfix">
                	<div class="pps-option-item pps-boxs-6">
                        <input id="pps-disable-logged-user-true" name="pps_options[disable_logged_user]" type="radio" value="true" <?php checked('true', $pps_options['disable_logged_user']); ?> />
						<label for="pps-disable-logged-user-true"><?php _e( 'Yes', 'PPS' ); ?></label>
                    </div><!--.pps-option-item-->
                	<div class="pps-option-item pps-boxs-6">
                        <input id="pps-disable-logged-user-false" name="pps_options[disable_logged_user]" type="radio" value="false" <?php checked('false', $pps_options['disable_logged_user']); ?> />
						<label for="pps-disable-logged-user-false"><?php _e( 'Not', 'PPS' ); ?></label>
                    </div><!--.pps-option-item-->
                    <spam class="pps-option-info"><?php _e( 'The popups will be deactivated for the logged users', 'PPS' ); ?></spam>
                </div><!--.pps-option-content-->
            </fieldset>

            <!-- Prevent on mobile -->
        	<fieldset class="pps-option-group pps-option-radio">
                <div class="pps-option-name">
                    <label><?php _e( 'Disable on mobile', 'PPS' ); ?></label>
                </div><!--.pps-option-name-->
                <div class="pps-option-content pps-clearfix">
                	<div class="pps-option-item pps-boxs-6">
                        <input id="pps-prevent-mobile-true" name="pps_options[prevent_mobile]" type="radio" value="true" <?php checked('true', $pps_options['prevent_mobile']); ?> />
						<label for="pps-prevent-mobile-true"><?php _e( 'Yes', 'PPS' ); ?></label>
                    </div><!--.pps-option-item-->
                	<div class="pps-option-item pps-boxs-6">
                        <input id="pps-prevent-mobile-false" name="pps_options[prevent_mobile]" type="radio" value="false" <?php checked('false', $pps_options['prevent_mobile']); ?> />
						<label for="pps-prevent-mobile-false"><?php _e( 'Not', 'PPS' ); ?></label>
                    </div><!--.pps-option-item-->
                    <spam class="pps-option-info"><?php _e( 'Disable popups on mobile devices.', 'PPS' ); ?></spam>
                </div><!--.pps-option-content-->
            </fieldset>

        	<!-- Embeds Width -->
            <fieldset class="pps-option-group pps-option-text">
                <div class="pps-option-name">
                    <label for="pps-embed-width"><?php _e( 'Embeds Width', 'PPS' ); ?></label>
                </div><!--.pps-option-name-->
                <div class="pps-option-content pps-clearfix">
                	<div class="pps-option-item pps-input-s">
                       <input id="pps-embed-width" type="text" name="pps_options[embed_width]" value="<?php echo $pps_options['embed_width']; ?>" />

                       <div class="pps-suboption-item">
                           <input id="pps-embed-width-unit-%" name="pps_options[emded_width_unit]" type="radio" value="%" <?php checked('%', $pps_options['emded_width_unit']); ?> />
                            <label for="pps-embed-width-unit-%"><?php _e( '%', 'PPS' ); ?></label>
                            <input id="pps-embed-width-unit-px" name="pps_options[emded_width_unit]" type="radio" value="px" <?php checked('px', $pps_options['emded_width_unit']); ?> />
                            <label for="pps-embed-width-unit-px"><?php _e( 'px', 'PPS' ); ?></label>
                       </div>

                       <span class="pps-option-info"><?php _e( 'The videos will be adapted to the width of the popup (100 %) but you can change them if you wish.', 'PPS' ); ?></span>
                    </div><!--.pps-option-item-->

                </div><!--.pps-option-content-->
            </fieldset>

            <!-- Embeds Height -->
            <fieldset class="pps-option-group pps-option-text">
                <div class="pps-option-name">
                    <label for="pps-embed-width"><?php _e( 'Embeds Height', 'PPS' ); ?></label>
                </div><!--.pps-option-name-->
                <div class="pps-option-content pps-clearfix">
                	<div class="pps-option-item pps-input-s">
                       <input id="pps-embed-height" type="text" name="pps_options[embed_height]" value="<?php echo $pps_options['embed_height']; ?>" />
                       <span class="pps-option-info"><?php _e( '(px). Add the height for the embeds', 'PPS' ); ?></span>
                    </div><!--.pps-option-item-->

                </div><!--.pps-option-content-->
            </fieldset>
<?php
/*
            <fieldset class="pps-option-group pps-option-radio">
                <div class="pps-option-name">
                    <label><?php _e( 'Use WP Editor', 'PPS' ); ?></label>
                </div><!--.pps-option-name-->
                <div class="pps-option-content pps-clearfix">
                	<div class="pps-option-item pps-boxs-6">
                        <input id="pps-use-wp-editor-true" name="pps_options[use_wp_editor]" type="radio" value="true" <?php checked('true', $pps_options['use_wp_editor']); ?> />
						<label for="pps-use-wp-editor-true"><?php _e( 'Yes', 'PPS' ); ?></label>
                    </div><!--.pps-option-item-->
                	<div class="pps-option-item pps-boxs-6">
                        <input id="pps-use-wp-editor-false" name="pps_options[use_wp_editor]" type="radio" value="false" <?php checked('false', $pps_options['use_wp_editor']); ?> />
						<label for="pps-use-wp-editor-false"><?php _e( 'Not', 'PPS' ); ?></label>
                    </div><!--.pps-option-item-->
                    <spam class="pps-option-info"><?php _e( 'Disable wordpress editor on all Popups.', 'PPS' ); ?></spam>
                </div><!--.pps-option-content-->
            </fieldset>
*/
?>
            <fieldset class="pps-option-group">
                <div class="pps-option-name">
                    <label for="pps-fix-jquery"><?php _e( 'Fix jQuery problem', 'PPS' ); ?></label>
                </div><!--.pps-option-name-->
                <div class="pps-option-content">
                    <input id="pps-fix-jquery" name="pps_options[fix_jquery]" type="checkbox" value="true" <?php if (isset($pps_options['fix_jquery'])) { checked('true', $pps_options['fix_jquery']); } ?> />
                    <label for="pps-fix-jquery"><span style="color:#333333;margin-left:3px;"><?php _e( 'Fix', 'PPS' ); ?></span></label>
                    <p class="pps-option-info"><?php _e( 'Some wordpress themes uploaded incorrectly the jQuery library and that causes incompatibility with this plugin. Check this option only if you are having these problems.', 'PPS' ); ?></p>
                </div><!--.pps-option-content-->
            </fieldset>

        </div><!--.pps-tab4-->

    </div><!--.pps-tab-container-->

    <fieldset id="pps-item-submit" class="pps-option-group" style="padding:0">
        <div class="pps-option-name">
            <p class="submit">
                <input type="submit" name="Submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
            </p>
        </div><!--.pps-option-name-->
        <div class="pps-option-content">
        </div><!--.pps-option-content-->
    </fieldset>

	</form>

</div><!--.wrap-->
<?php
?>