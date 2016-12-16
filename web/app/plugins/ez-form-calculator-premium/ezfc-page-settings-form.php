<?php

defined( 'ABSPATH' ) OR exit;

if (isset($_POST["ezfc-reset"])) {
	$keep_data_option = get_option("ezfc_uninstall_keep_data", 0);
	update_option("ezfc_uninstall_keep_data", 0);

	ezfc_uninstall();
	ezfc_register();

	update_option("ezfc_uninstall_keep_data", $keep_data_option);
	$_POST = array();
}

require_once(EZFC_PATH . "class.ezfc_backend.php");
$ezfc = new Ezfc_backend();

if (isset($_POST["submit"])) {
	$_POST["opt"] = isset($_POST["opt"]) ? $_POST["opt"] : null;
	$_POST["ezfc-overwrite"] = isset($_POST["ezfc-overwrite"]) ? $_POST["ezfc-overwrite"] : null;
	$_POST["ezfc-manual-update"] = isset($_POST["ezfc-manual-update"]) ? $_POST["ezfc-manual-update"] : null;

	$ezfc->update_options($_POST["opt"], $_POST["ezfc-overwrite"], $_POST["ezfc-manual-update"]);

	$updated = 1;
}

// get form options
$settings = $ezfc->get_options();
// categorize settings
$settings_cat = array();
foreach ($settings as $cat => $s) {
	$settings_cat[$cat] = $s;
}

?>

<div class="ezfc wrap">
	<h2><?php echo __("Form settings", "ezfc"); ?> - ez Form Calculator v<?php echo EZFC_VERSION; ?></h2> 
	<p>These options can be changed individually in each form. Saving these options will be applied to new forms only (when you did not check to overwrite settings).</p>

	<?php
	if (isset($updated)) {
		?>

		<div id="message" class="updated"><?php echo __("Settings saved.", "ezfc"); ?></div>

		<?php
	}
	?>

	<form method="POST" name="ezfc-form" class="ezfc-form" action="<?php echo $_SERVER['REQUEST_URI']; ?>" novalidate>
		<div id="tabs">
			<ul>
				<?php
				$tabs = array_keys($settings_cat);

				foreach ($tabs as $i => $cat) {
					echo "<li><a href='#tab-{$i}'>{$cat}</a></li>";
				}
				?>
			</ul>

		    <?php

		    $tab_i = 0;
		    foreach ($settings_cat as $cat_name => $cat) {
		    	?>

				<div id="tab-<?php echo $tab_i; ?>">
					<?php
					echo Ezfc_Functions::get_settings_table($cat, "opt", "opt", true);
					?>
				</div>

				<?php

				$tab_i++;
			}

			?>

		</div> <!-- tabs -->

		<table class="form-table" style="margin-top: 1em;">
			<!-- overwrite settings -->
			<tr>
				<th scope='row'>
					<label for="ezfc-overwrite">Overwrite settings</label>
		    	</th>
		    	<td>
		    		<input type="checkbox" name="ezfc-overwrite" id="ezfc-overwrite" value="1" /><br>
		    		<p class="description">Checking this option will overwrite <b>ALL</b> existing form settings!</p>
		    	</td>
		    </tr>
		</table>

		<!-- save -->
		<p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="<?php echo __("Save", "ezfc"); ?>" /></p>
	</form>
</div>

<script>
jQuery(function($) {
	$("#tabs").tabs();

	var reset_confirmation = true;

	// reset confirmation
	$(".ezfc-form").on("submit", function() {
		if (($("#ezfc-overwrite").prop("checked") || $("#ezfc-reset").prop("checked")) && reset_confirmation) {
			if (!confirm("Really overwrite all settings?")) return false;
		}
	});

	$(".ezfc-single-overwrite-button").click(function() {
		if (!confirm("Really overwrite this option for all forms?")) return false;

		// do not ask to overwrite twice
		reset_confirmation = false;

		var $form = $(this).parents(".ezfc-form");

		// get this option
		var $option_field = $(this).parents("tr").find("input, select, textarea");

		// disable all options
		$form.find("input, select, textarea").attr("disabled", "disabled");

		// reenable necessary options
		$option_field.removeAttr("disabled");
		$("#ezfc-overwrite").removeAttr("disabled").prop("checked", true);

		$form.submit();
	});
});
</script>