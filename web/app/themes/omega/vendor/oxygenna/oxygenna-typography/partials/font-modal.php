<?php
/**
 * Adds a font to the fontstack
 *
 * @package OxygennaTypography
 *
 * @copyright (c) 2014 Oxygenna.com
 * @license **LICENSE**
 * @version 1.18.14
 * @author Oxygenna.com
 */
?>
<html>
    <head>
        <?php
        // do_action('admin_enqueue_scripts', $hook_suffix);
        do_action('admin_print_styles-' . $hook_suffix);
        do_action('admin_print_styles');
        do_action('admin_print_scripts-' . $hook_suffix);
        do_action('admin_print_scripts');
        do_action('admin_head');
        ?>
    </head>

    <body class="wp-admin wp-core-ui js iframe add-font-page">
        <div id="add-font-content">
            <h2 class="long-header"><?php echo $font_info['family']; ?></h2>
            <form id="add-font-form">
                <div class="row">
                    <div id="elements" class="third">
                        <h3>Elements</h3>
                        <p class="description">Select which HTML tags will use this font.</p>
                        <?php foreach( $elements as $tag => $element ) : ?>
                            <p>
                                <input class="elements" name="elements[<?php echo $tag; ?>]" type="checkbox" id="<?php echo $tag; ?>" value="<?php echo $tag; ?>" <?php $this->checkbox_status($tag, $font['elements']); ?>>
                                <label for="<?php echo $tag; ?>"><?php echo $element; ?></label>
                            </p>
                        <?php endforeach; ?>
                    </div>
                    <?php if( !isset( $font_info['css_stack'] ) && !isset( $font_info['provider'] ) ): ?>
                        <div id="variants" class="third">
                            <h3>Variants</h3>
                            <p class="description">Choose the weights of fonts you would like to load</p>
                            <?php foreach( $font_info['variants'] as $variant ) : ?>
                                <p>
                                    <input class="variants" type="checkbox" id="<?php echo $variant; ?>" value="<?php echo $variant; ?>" <?php $this->checkbox_status($variant, $font['variants']); ?>/>
                                    <label for="<?php echo $variant; ?>">
                                        <?php echo $this->oxy_get_font_weight_style( $variant, $_GET['provider'] ); ?>
                                    </label>
                                </p>
                            <?php endforeach; ?>
                        </div>
                        <?php if( $_GET['provider'] === 'google_fonts' ) : ?>
                        <div id="subsets" class="third">
                            <h3>Charsets</h3>
                            <p class="description">Select language character sets to load.</p>
                            <?php foreach( $font_info['subsets'] as $subset ) : ?>
                                <p>
                                    <input class="subsets" name="subsets[<?php echo $subset; ?>]" type="checkbox" id="<?php echo $subset; ?>" value="<?php echo $subset; ?>" <?php $this->checkbox_status($subset, $font['subsets']); ?>>
                                    <label for="<?php echo $subset; ?>"><?php echo $subset; ?></label>
                                </p>
                            <?php endforeach; ?>
                        </div>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>

                <div class="row">
                    <h3>Extra CSS</h3>
                    <p class="description">Add any extra CSS rules you would like to use for this font here.  You can click the button below to add the default theme weight css and then adjust the font weights to match those availble for this font.</p>
                    <button id="default-css" class="button button-secondary">Insert theme font weight CSS</button>
                    <textarea name="extracss" id="extracss" cols="30" rows="10"><?php echo stripslashes($font['extracss']); ?></textarea>
                </div>
                <input type="hidden" name="default-font-css" value="<?php echo $default_font_css ?>" />
                <input type="hidden" name="action" value="fontstack_add" />
                <input type="hidden" name="nonce" value="<?php echo wp_create_nonce( 'oxygenna-add-fontstack' ); ?>" />
                <input type="hidden" name="family" value="<?php echo $_GET['family']; ?>" />
                <input type="hidden" name="provider" value="<?php echo $_GET['provider']; ?>" />
                <input type="hidden" name="position" value="<?php echo $_GET['position']; ?>" />
            </form>
        </div>
        <div id="add-font-footer">
            <button id="save-font" class="button button-primary"><?php echo $save_button_text; ?></button>
            <button id="cancel" class="button button-secondary">Cancel</button>
        </div>
    </body>
</html>