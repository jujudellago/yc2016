<?php

defined( 'ABSPATH' ) OR exit;

require_once(EZFC_PATH . "class.ezfc_functions.php");
require_once(EZFC_PATH . "class.ezfc_backend.php");
$ezfc = new Ezfc_backend();

$message = "";

// import form
if (isset($_POST["submit-import-text"])) {
	$ezfc->import_data($_POST["import_data"]);
	$message = __("Data imported.", "ezfc");
}

// import form by file
if (isset($_POST["submit-import-file"]) && isset($_FILES["ezfc-import-file"])) {
	$file = $_FILES["ezfc-import-file"]["tmp_name"];
	$file_data = EZFC_Functions::zip_read($file, "ezfc_export_data.json");

	if (empty($file_data)) {
		$message = __("Unable to import form data from file.", "ezfc");
	}
	else {
		// import data without stripslashes
		$result = $ezfc->import_data($file_data, false);
		
		$message = isset($result["error"]) ? $result["error"] : $result["success"];
	}
}

// get export data
$download = 0;
$export_data = $ezfc->get_export_data();
$export_data_json = json_encode($export_data);

// download form data
if (isset($_POST["submit-export-download"])) {
	$file = EZFC_Functions::zip_write($export_data_json, "ezfc_export_data.json");

	// unknown error
	if (!is_array($file)) {
		$message = __("Unable to download export data.", "ezfc");
	}
	else {
		// error message
		if (isset($file["error"])) {
			$message = $file["error"];
		}
		// download file
		else {
			$download = 1;
		}
	}
}

// clear temporary export files
if (isset($_POST["submit-clear-export-files"])) {
	$result = EZFC_Functions::delete_tmp_files();

	// error
	if (isset($result["error"])) $message = $result["error"];
	else $message = $result["success"];
}

?>

<div class="ezfc wrap">
	<h2><?php echo __("Import / Export data", "ezfc"); ?></h2> 

	<?php
	if (!empty($message)) {
		?>

		<div id="message" class="updated"><?php echo $message; ?></div>

		<?php
	}
	?>

	<h3><?php echo __("Export data", "ezfc"); ?></h3>
	<textarea class="ezfc-settings-type-textarea"><?php echo htmlentities($export_data_json); ?></textarea>

	<form method="POST" name="ezfc-form-export-download" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
		<p>
			<input type="submit" name="submit-export-download" class="button button-primary" value="<?php echo __("Download export data", "ezfc"); ?>" /> &nbsp; 
			<input type="submit" name="submit-clear-export-files" class="button" value="<?php echo __("Clear temporary export files", "ezfc"); ?> " />
		</p>
	</form>

	<hr>

	<h3><?php echo __("Import text data", "ezfc"); ?></h3>
	<form method="POST" name="ezfc-form-import-text" class="ezfc-form" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
		<!-- import text -->
		<p><?php echo __("Paste form data here:", "ezfc"); ?></p>
		<textarea class="ezfc-settings-type-textarea" name="import_data"></textarea>
		<p class="submit"><input type="submit" name="submit-import-text" id="submit-import-text" class="button button-primary" value="<?php echo __("Import text data", "ezfc"); ?>" /></p>
	</form>

	<hr>

	<h3><?php echo __("Import file", "ezfc"); ?></h3>	
	<form method="POST" name="ezfc-form-import-file" class="ezfc-form" action="<?php echo $_SERVER['REQUEST_URI']; ?>" enctype="multipart/form-data">
		<!-- import file -->
		<p><?php echo __("Import exported file here:", "ezfc"); ?></p>
		<p><input type="file" name="ezfc-import-file" /></p>

		<p class="submit"><input type="submit" name="submit-import-file" id="submit-import-file" class="button button-primary" value="<?php echo __("Upload and import file", "ezfc"); ?>" /></p>
	</form>	
</div>

<script>
jQuery(document).ready(function($) {
	$(".ezfc-form").on("submit", function() {
		// confirmation
		if (!confirm("Importing will overwrite all existing data. Continue?")) return false;
	});

	<?php if ($download == 1) { ?>
	document.location.href = "<?php echo $file["file_url"]; ?>";
	<?php } ?>
});
</script>