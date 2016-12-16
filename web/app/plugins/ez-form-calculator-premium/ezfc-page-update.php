<?php

defined( 'ABSPATH' ) OR exit;

require_once(EZFC_PATH . "class.ezfc_functions.php");
require_once(EZFC_PATH . "class.ezfc_backend.php");
$ezfc_backend = new Ezfc_backend();

$message = "";
// update
if (isset($_REQUEST["submit"])) {
	$result = EZFC_Functions::plugin_update();

	if (isset($result["success"])) {
		$ezfc_backend->upgrade();
		$ezfc_backend->update_options(false, false, true);

		$message = $result["success"];
	}
	else if (isset($result["error"])) {
		$message = $result["error"];
	}
	else if (isset($result["notification"])) {
		$message = $result["notification"];
	}
	else {
		$message = __("Unknown error.", "ezfc");
	}
}

?>

<div class="ezfc wrap">
	<div class="container-fluid">
		<div class="col-lg-12">
			<h2><?php echo __("Update", "ezfc"); ?> - ez Form Calculator v<?php echo EZFC_VERSION; ?></h2> 
			<p>
				<?php _e("You can manually update plugin here.", "ezfc"); ?>
			</p>

			<hr>
		</div>

		<?php if (!empty($message)) { ?>
			<div class="col-lg-12">
				<div id="message" class="updated"><?php echo $message; ?></div>
			</div>
		<?php } ?>

		<div class="col-lg-12">
			<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post" enctype="multipart/form-data" novalidate>
				<h3><?php _e("Choose the update file", "ezfc"); ?></h3>

				<p><strong><?php _e("Please backup your data before updating! You can export all data on the 'Import / Export' page.", "ezfc"); ?></strong></p>

				<p><?php _e("The update file should be named 'codecanyon-7595334-ez-form-calculator-wordpress-plugin.zip'.", "ezfc"); ?></p>

				<p><input type="file" name="ezfc-update" /></p>

				<hr>

				<p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="<?php _e("Upload and update", "ezfc"); ?>" /></p>
			</form>
		</div>
	</div>
</div>
