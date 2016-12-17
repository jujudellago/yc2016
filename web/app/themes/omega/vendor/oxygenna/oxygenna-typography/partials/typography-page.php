<div class="wrap">
    <h2><?php echo THEME_NAME; ?> - <?php _e('Typography Page', 'omega-admin-td'); ?></h2>
    <h4>This page allows you to choose which fonts your site will load and where they will be used.</h4>

    <div id="ajax-errors-here"></div>

    <table id="fontstack-list" class="widefat">
        <thead>
            <tr>
                <tr>
                    <th>Font</th>
                    <th>Provider</th>
                    <th>Variants</th>
                    <th>Elements</th>
                    <th>Subsets</th>
                    <th></th>
                </tr>
            </tr>
        </thead>
        <tbody>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="6" align="center">
                    <?php $this->create_font_select(); ?>
                    <button id="add-font-to-stack" class="button button-primary">Add font</button>
                </td>
            </tr>
        </tfoot>
    </table>

    <div id="options-footer">
        <input type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes">
        <button id="default-font-stack" class="button button-secondary">Install default theme fonts</button>
    </div>

    <div id="dialog-confirm" class="hidden" title="Install the default fonts?">
        <p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>
            This will replace your current fonts with the default theme fonts used on the demo site.  Are you sure?
        </p>
    </div>

</div>
