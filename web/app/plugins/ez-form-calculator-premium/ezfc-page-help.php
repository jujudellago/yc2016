<?php

defined( 'ABSPATH' ) OR exit;

require_once(EZFC_PATH . "class.ezfc_backend.php");
$ezfc = new Ezfc_backend();
$message = "";

// clear logs
if (isset($_REQUEST["clear_logs"]) && $_REQUEST["clear_logs"] == 1) {
	$ezfc->clear_debug_log();
	$message = "Logs cleared.";
}

// send test mail
if (isset($_REQUEST["send_test_mail"]) && $_REQUEST["send_test_mail"] == 1 &&
	isset($_REQUEST["send_test_mail_recipient"]) && !empty($_REQUEST["send_test_mail_recipient"])) {
	$message = $ezfc->send_test_mail($_REQUEST["send_test_mail_recipient"]);
}

// paypal test
if (!empty($_REQUEST["paypal_test"])) {
	$test_url_base = $_REQUEST["paypal_env"]=="live" ? "https://api-3t.paypal.com/nvp" : "https://api-3t.sandbox.paypal.com/nvp";

	$test_query = http_build_query(array(
		"USER"                           => get_option("ezfc_pp_api_username"),
		"PWD"                            => get_option("ezfc_pp_api_password"),
		"SIGNATURE"                      => get_option("ezfc_pp_api_signature"),
		"VERSION"                        => "104.0",
		"method"                         => "SetExpressCheckout",
		"PAYMENTREQUEST_0_AMT"           => "10.00",
		"PAYMENTREQUEST_0_CURRENCYCODE"  => "USD",
		"PAYMENTREQUEST_0_PAYMENTACTION" => "Sale",
		"returnUrl"    	                 => "http://www.paypal.com/test.php",
		"cancelUrl"    	                 => "http://www.paypal.com/test.php",
		"L_PAYMENTREQUEST_0_NAME0"       => "item",
 		"L_PAYMENTREQUEST_0_AMT0"        => "10.00",
 		"L_PAYMENTREQUEST_0_QTY0"        => "1"
	));

	$test_url = $test_url_base . "?" . $test_query;

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $test_url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);	
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
	curl_setopt($ch, CURLOPT_HEADER, false);
	$res = curl_exec($ch);
	curl_close($ch);

	parse_str($res, $test_result);
	if (!empty($test_result["ACK"]) && $test_result["ACK"] == "Success") {
		$message = sprintf(__("PayPal successfully verified your %s credentials.", "ezfc"), "<strong>{$_REQUEST["paypal_env"]}</strong>");
	}
	else {
		$message  = sprintf(__("Error while validating %s credentials:", "ezfc"), "<strong>{$_REQUEST["paypal_env"]}</strong>");
		$message .= $test_result["L_LONGMESSAGE0"] . "<br><br>";
		$message .= sprintf(__("Please note that Sandbox API credentials are different! See %s to read how to get your API credentials.", "ezfc"), "<a href='https://developer.paypal.com/docs/classic/api/apiCredentials/'>PayPal docs</a>");
	}
}

$debug_active = get_option("ezfc_debug_mode", 0)==1 ? true : false;
$debug_log    = $ezfc->get_debug_log();

$debug_vars = array(
	"php_version"  => phpversion(),
	"wp_version"   => get_bloginfo("version"),
	"magic_quotes" => get_magic_quotes_gpc()==0 ? "Off" : "On",
	"file_get_contents" => function_exists("file_get_contents") ? "On" : "Off"
);

?>

<div class="ezfc wrap">
	<div class="container-fluid">
		<div class="col-lg-12">
			<h2><?php echo __("Help / debug", "ezfc"); ?> - ez Form Calculator v<?php echo EZFC_VERSION; ?></h2> 
			<p>
				<a class="button button-primary" href="http://www.mials.de/mials/ezfc/documentation/" target="_blank">Open documentation site</a>
			</p>

			<p>
				If you have found any bugs, please report them to <a href="mailto:support@ezplugins.de">support@ezplugins.de</a>. Thank you!
			</p>
		</div>

		<?php if (!empty($message)) { ?>
			<div class="col-lg-12">
				<div id="message" class="updated"><?php echo $message; ?></div>
			</div>
		<?php } ?>

		<div class="col-lg-6">
			<h3>Debug log</h3>

			<p>
				Debug mode is <strong><?php echo $debug_active ? "active" : "inactive"; ?></strong>.
			</p>
			<textarea class="ezfc-settings-type-textarea" style="height: 400px;"><?php echo $debug_log; ?></textarea>

			<form action="" method="POST">
				<input type="hidden" value="1" name="clear_logs" />
				<input type="submit" value="Clear logs" class="button button-primary" />
			</form>
		</div>

		<div class="col-lg-3">
			<h3>Environment Vars</h3>
			<?php
			$out = array();
			$out[] = "<table>";
			foreach ($debug_vars as $key => $var) {
				$out[] = "<tr>";
				$out[] = "	<td>";
				$out[] = 		$key;
				$out[] = "	</td><td>";
				$out[] = 		$var;
				$out[] = "	</td>";
				$out[] = "</tr>";
			}
			$out[] = "</table>";

			echo implode("", $out);
			?>

			<h3>Tests</h3>

			<div>
				<strong>Emails</strong>
				<form action="" method="POST">
					<input type="hidden" value="1" name="send_test_mail" />
					<input type="text" value="" name="send_test_mail_recipient" placeholder="your@email.com" />
					<br />
					<input type="submit" value="<?php echo __("Send test mail", "ezfc"); ?>" class="button" />
				</form>
			</div>

			<hr />

			<div>
				<strong>PayPal</strong>
				<form action="" method="POST">
					<input type="hidden" value="1" name="paypal_test" />
					<select name="paypal_env">
						<option value="live">Live</option>
						<option value="sandbox">Sandbox</option>
					</select>
					<br />
					<input type="submit" value="<?php echo __("Test PayPal credentials", "ezfc"); ?>" class="button" />
				</form>
			</div>
		</div>

		<div class="col-lg-3">
			<a class="twitter-timeline" href="https://twitter.com/ezPlugins" data-widget-id="575319170478383104">Tweets by @ezPlugins</a>
			<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
		</div>
	</div>
</div>
