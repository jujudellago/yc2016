<?php

defined( 'ABSPATH' ) OR exit;

require_once(EZFC_PATH . "class.ezfc_functions.php");

$message = "";

if (!empty($_POST)) {
	// register license
	if ($_POST["action"] == "register_license" && !empty($_POST["purchase_code"])) {
		$result = Ezfc_Functions::register_license($_POST["purchase_code"]);

		if (!empty($result["error"])) {
			$message = $result["error"];
		}
		else if (!empty($result["notification"])) {
			$message = $result["notification"];
		}
		else if (!empty($result["success"])) {
			update_option("ezfc_purchase_code", $_POST["purchase_code"]);
			update_option("ezfc_license_activated", 1);

			$message = $result["success"];
		}
		else {
			$message = sprintf(__("Unknown error: %s", "ezfc"), var_export($result, true));
		}
	}
	// revoke license
	else if ($_POST["action"] == "revoke_license") {
		$result = Ezfc_Functions::revoke_license(get_option("ezfc_purchase_code"));

		if (!empty($result["error"])) {
			$message = $result["error"];
		}
		else if (!empty($result["notification"])) {
			update_option("ezfc_purchase_code", "");
			update_option("ezfc_license_activated", 0);
			
			$message = $result["notification"];
		}
		else if (!empty($result["success"])) {
			update_option("ezfc_purchase_code", "");
			update_option("ezfc_license_activated", 0);

			$message = $result["success"];
		}
		else {
			$message = sprintf(__("Unknown error: %s", "ezfc"), var_export($result, true));
		}
	}
}

$license           = get_option("ezfc_license_activated", 0);
$license_activated = $license ? __("License registered.", "ezfc") : __("License not registered.", "ezfc");
$license_name      = get_bloginfo("name") . ", " . network_site_url( '/' );
$license_show_content = $license ? "license_active" : "license_inactive";

// check if localhost
if (substr($_SERVER['REMOTE_ADDR'], 0, 4) == '127.' || $_SERVER['REMOTE_ADDR'] == '::1') {
    $license_show_content = "disabled";
}

?>

<div class="ezfc wrap">
	<div class="container-fluid">
		<div class="col-lg-12">
			<h2><?php echo __("Licensing", "ezfc"); ?> - ez Form Calculator v<?php echo EZFC_VERSION; ?></h2> 
			<p><?php echo __("In order to receive automatic updates, please register your purchase code here.", "ezfc"); ?></p>
			<p><?php echo __("Only one license per site is allowed. If you uninstall the plugin from a site, the license will be automatically removed from the site so you can register it somewhere else.", "ezfc"); ?></p>
			<p><?php echo sprintf(__("Please report any licensing problems to %s.", "ezfc"), "<a href='mailto:support@ezplugins.de'>support@ezplugins.de</a>"); ?></p>
		</div>

		<?php if (!empty($message)) { ?>
			<div class="col-lg-12">
				<div id="message" class="updated"><?php echo $message; ?></div>
			</div>
		<?php } ?>

		<div class="col-lg-12">
			<form action="" method="POST">
				<?php if ($license_show_content == "license_inactive") { ?>
					<p><?php echo __("Current licensing status:", "ezfc"); ?> <strong><?php echo $license_activated; ?></strong></p>

					<p>
						<?php echo __("The plugin will be licensed for:", "ezfc"); ?> <strong><?php echo $license_name; ?></strong>
					</p>

					<p>
						<label for="purchase_code"><?php echo __("Purchase code", "ezfc"); ?>:</label>
						<input type="text" name="purchase_code" id="purchase_code" />
					</p>

					<input type="hidden" name="action" value="register_license" />
					<input type="submit" value="<?php echo __("Register license", "ezfc"); ?>" class="button button-primary" />
				<?php } else if ($license_show_content == "license_active") { ?>
					<p><?php echo __("Thank your for activating your copy of ez Form Calculator! :)", "ezfc"); ?></p>
					<p><?php echo __("Licensed for:", "ezfc"); ?> <strong><?php echo $license_name; ?></strong></p>
					
					<input type="hidden" name="action" value="revoke_license" />
					<input type="submit" value="<?php echo __("Revoke license", "ezfc"); ?>" class="button button-primary" />
				<?php } else if ($license_show_content == "disabled") { ?>
					<p><?php echo __("The plugin cannot be licensed on a local machine.", "ezfc"); ?></p>
				<?php } ?>
			</form>
		</div>
	</div>
</div>
