<?php

defined( 'ABSPATH' ) OR exit;

require_once(EZFC_PATH . "class.ezfc_backend.php");
$ezfc = new Ezfc_backend();

// global settings
$settings = Ezfc_settings::get_global_settings();
$settings_raw = Ezfc_settings::get_global_settings(true);

if (isset($_POST["submit"])) {
	// manual update
	if (!empty($_POST["ezfc-manual-update"])) {
		$ezfc->update_options(false, false, true);
	}

	// update global options
	Ezfc_settings::update_global_settings($_POST["opt"]);
	// get global settings again
	$settings = Ezfc_settings::get_global_settings();
	$settings_raw = Ezfc_settings::get_global_settings(true);

	$updated = 1;
}

if (isset($_POST["ezfc-reset"])) {
	$keep_data_option = get_option("ezfc_uninstall_keep_data", 0);
	update_option("ezfc_uninstall_keep_data", 0);

	ezfc_uninstall();
	ezfc_register();

	update_option("ezfc_uninstall_keep_data", $keep_data_option);
	$_POST = array();
}

// categorize settings
$settings_cat = array();
foreach ($settings as $cat => $s) {
	$settings_cat[$cat] = $s;
}

?>

<div class="ezfc wrap">
	<h2><?php echo __("Global settings", "ezfc"); ?> - ez Form Calculator v<?php echo EZFC_VERSION; ?></h2> 

	<?php
	if (isset($updated)) {
		?>

		<div id="message" class="updated"><?php echo __("Settings saved.", "ezfc"); ?></div>

		<?php
	}
	?>

	<form method="POST" name="ezfc-form" class="ezfc-form" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
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
					echo Ezfc_Functions::get_settings_table($cat, "opt", "opt");
					?>
				</div>

				<?php

				$tab_i++;
			}
			?>
		</div>

		<table class="form-table" style="margin-top: 1em;">
		    <!-- manual update -->
			<tr>
				<th scope='row'>
					<label for="ezfc-manual-update">Manual update</label>
		    	</th>
		    	<td>
		    		<input type="checkbox" name="ezfc-manual-update" id="ezfc-manual-update" value="1" /><br>
		    		<p class="description">Checking this option will perform certain database changes. Check this if you recently updated the script as this will perform necessary changes. <strong>Please make sure to backup your form data before!</strong></p>
		    		<p class="description">This will overwrite all default settings but not form options.</p>
		    	</td>
		    </tr>

		    <!-- reset -->
			<tr>
				<th scope='row'>
					<label for="ezfc-manual-update">Reset</label>
		    	</th>
		    	<td>
		    		<input type="checkbox" name="ezfc-reset" id="ezfc-reset" value="1" /><br>
		    		<p class="description">Complete reset of this plugin. <strong>This will reset all existing data. Use with caution.</strong></p>
		    	</td>
		    </tr>	
		</table>

		<!-- save -->
		<p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="<?php echo __("Save", "ezfc"); ?>" /></p>
	</form>
</div>

<div id="price-preview-wrapper">
	<strong><?php echo __("Price preview (currency does not apply here)", "ezfc"); ?></strong>
	<p>$ <span id="price-preview-text">1337.99</span></p>
</div>

<script>
jQuery(function($) {
	$("#tabs").tabs();

	$(".ezfc-form").on("submit", function() {
		// confirmation
		if ($("#ezfc-overwrite").prop("checked") || $("#ezfc-reset").prop("checked")) {
			if (!confirm("Really overwrite all settings?")) return false;
		}
	});

	$("#price-preview-wrapper").insertBefore("#tab-1 .form-table");

	$("#opt-price_format, #opt-email_price_format_dec_point, #opt-email_price_format_thousand").on("keyup change", function() {
		numeral.language("ezfc", {
			delimiters: {
				decimal:   $("#opt-email_price_format_dec_point").val(),
				thousands: $("#opt-email_price_format_thousand").val()
			},
			abbreviations: {
	            thousand: 'k',
	            million: 'm',
	            billion: 'b',
	            trillion: 't'
	        },
	        ordinal: function (number) {
	            var b = number % 10;
	            return (~~ (number % 100 / 10) === 1) ? 'th' :
	                (b === 1) ? 'st' :
	                (b === 2) ? 'nd' :
	                (b === 3) ? 'rd' : 'th';
	        },
	        currency: {
	            symbol: '$'
	        }
		});
		numeral.language("ezfc");

		var price_formatted = numeral("1337.99").format($("#opt-price_format").val());
		$("#price-preview-text").text(price_formatted);
	});

	$("#opt-price_format").trigger("change");
});
</script>