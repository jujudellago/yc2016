<?php

if (!function_exists("get_option")) die();

require_once(EZFC_PATH . "lib/paypal/paypalfunctions.php");

class Ezfc_paypal {
	public static function checkout() {
		$paymentAmount    = $_SESSION["Payment_Amount"];
		$paymentType      = "Sale";
		$currencyCodeType = get_option("ezfc_pp_currency_code");
		$returnURL        = get_option("ezfc_pp_return_url");
		$cancelURL        = get_option("ezfc_pp_cancel_url");
		$debug_mode       = get_option("ezfc_debug_mode");

		$resArray = CallShortcutExpressCheckout($paymentAmount, $currencyCodeType, $paymentType, $returnURL, $cancelURL);

		$ack = strtoupper($resArray["ACK"]);
		if ($ack=="SUCCESS" || $ack=="SUCCESSWITHWARNING") {
			return array(
				"token" => $resArray["TOKEN"],
				"url"   => RedirectToPayPal ( $resArray["TOKEN"] )
			);
		} 
		else {
			$ErrorCode = urldecode($resArray["L_ERRORCODE0"]);
			$ErrorShortMsg = urldecode($resArray["L_SHORTMESSAGE0"]);
			$ErrorLongMsg = urldecode($resArray["L_LONGMESSAGE0"]);
			$ErrorSeverityCode = urldecode($resArray["L_SEVERITYCODE0"]);

			if ($debug_mode == 1) {
				$return_msg = "{$ErrorSeverityCode}: {$ErrorLongMsg}";
			}
			else {
				$return_msg = $ErrorShortMsg;
			}

			return array(
				"error" => "SetExpressCheckout API call failed: {$return_msg}"
			);

			/*
			"Detailed Error Message: " . $ErrorLongMsg . "\n" .
			"Short Error Message: " . $ErrorShortMsg . "\n" .
			"Error Code: " . $ErrorCode . "\n" .
			"Error Severity Code: " . $ErrorSeverityCode;
			*/
		}
	}

	public static function confirm() {
		$finalPaymentAmount = $_SESSION["Payment_Amount"];
		
		/*
		'------------------------------------
		' Calls the DoExpressCheckoutPayment API call
		'
		' The ConfirmPayment function is defined in the file PayPalFunctions.jsp,
		' that is included at the top of this file.
		'-------------------------------------------------
		*/

		$resArray = ConfirmPayment ( $finalPaymentAmount );
		$ack = strtoupper($resArray["ACK"]);
		if( $ack == "SUCCESS" || $ack == "SUCCESSWITHWARNING" )
		{
			/*
			'********************************************************************************************************************
			'
			' THE PARTNER SHOULD SAVE THE KEY TRANSACTION RELATED INFORMATION LIKE 
			'                    transactionId & orderTime 
			'  IN THEIR OWN  DATABASE
			' AND THE REST OF THE INFORMATION CAN BE USED TO UNDERSTAND THE STATUS OF THE PAYMENT 
			'
			'********************************************************************************************************************
			*/

			$transactionId		= $resArray["PAYMENTINFO_0_TRANSACTIONID"]; // ' Unique transaction ID of the payment. Note:  If the PaymentAction of the request was Authorization or Order, this value is your AuthorizationID for use with the Authorization & Capture APIs. 
			$transactionType 	= $resArray["PAYMENTINFO_0_TRANSACTIONTYPE"]; //' The type of transaction Possible values: l  cart l  express-checkout 
			$paymentType		= $resArray["PAYMENTINFO_0_PAYMENTTYPE"];  //' Indicates whether the payment is instant or delayed. Possible values: l  none l  echeck l  instant 
			$orderTime 			= $resArray["PAYMENTINFO_0_ORDERTIME"];  //' Time/date stamp of payment
			$amt				= $resArray["PAYMENTINFO_0_AMT"];  //' The final amount charged, including any shipping and taxes from your Merchant Profile.
			$currencyCode		= $resArray["PAYMENTINFO_0_CURRENCYCODE"];  //' A three-character currency code for one of the currencies listed in PayPay-Supported Transactional Currencies. Default: USD. 

			// changed
			$feeAmt				= isset($resArray["PAYMENTINFO_0_FEEAMT"]) ? $resArray["PAYMENTINFO_0_FEEAMT"] : null;;  //' PayPal fee amount charged for the transaction
			$settleAmt			= isset($resArray["PAYMENTINFO_0_SETTLEAMT"]) ? $resArray["PAYMENTINFO_0_SETTLEAMT"] : null;;  //' Amount deposited in your PayPal account after a currency conversion.
			$taxAmt				= isset($resArray["PAYMENTINFO_0_TAXAMT"]) ? $resArray["PAYMENTINFO_0_TAXAMT"] : null;;  //' Tax charged on the transaction.
			$exchangeRate		= isset($resArray["PAYMENTINFO_0_EXCHANGERATE"]) ? $resArray["PAYMENTINFO_0_EXCHANGERATE"] : null;;  //' Exchange rate if a currency conversion occurred. Relevant only if your are billing in their non-primary currency. If the customer chooses to pay with a currency other than the non-primary currency, the conversion occurs in the customer's account.
			
			/*
			' Status of the payment: 
					'Completed: The payment has been completed, and the funds have been added successfully to your account balance.
					'Pending: The payment is pending. See the PendingReason element for more information. 
			*/
			
			$paymentStatus	= $resArray["PAYMENTINFO_0_PAYMENTSTATUS"]; 

			/*
			'The reason the payment is pending:
			'  none: No pending reason 
			'  address: The payment is pending because your customer did not include a confirmed shipping address and your Payment Receiving Preferences is set such that you want to manually accept or deny each of these payments. To change your preference, go to the Preferences section of your Profile. 
			'  echeck: The payment is pending because it was made by an eCheck that has not yet cleared. 
			'  intl: The payment is pending because you hold a non-U.S. account and do not have a withdrawal mechanism. You must manually accept or deny this payment from your Account Overview. 		
			'  multi-currency: You do not have a balance in the currency sent, and you do not have your Payment Receiving Preferences set to automatically convert and accept this payment. You must manually accept or deny this payment. 
			'  verify: The payment is pending because you are not yet verified. You must verify your account before you can accept this payment. 
			'  other: The payment is pending for a reason other than those listed above. For more information, contact PayPal customer service. 
			*/
			
			$pendingReason	= $resArray["PAYMENTINFO_0_PENDINGREASON"];  

			/*
			'The reason for a reversal if TransactionType is reversal:
			'  none: No reason code 
			'  chargeback: A reversal has occurred on this transaction due to a chargeback by your customer. 
			'  guarantee: A reversal has occurred on this transaction due to your customer triggering a money-back guarantee. 
			'  buyer-complaint: A reversal has occurred on this transaction due to a complaint about the transaction from your customer. 
			'  refund: A reversal has occurred on this transaction because you have given the customer a refund. 
			'  other: A reversal has occurred on this transaction due to a reason not listed above. 
			*/
			
			$reasonCode		= $resArray["PAYMENTINFO_0_REASONCODE"];

			return array(
				"success"        => true,
				"transaction_id" => $transactionId
			);
		}
		else  
		{
			//Display a user friendly Error on the page using any of the following error information returned by PayPal
			$ErrorCode = urldecode($resArray["L_ERRORCODE0"]);
			$ErrorShortMsg = urldecode($resArray["L_SHORTMESSAGE0"]);
			$ErrorLongMsg = urldecode($resArray["L_LONGMESSAGE0"]);
			$ErrorSeverityCode = urldecode($resArray["L_SEVERITYCODE0"]);

			$debug_mode = get_option("ezfc_debug_mode");

			if ($debug_mode == 1) {
				$return_msg = "{$ErrorSeverityCode}: {$ErrorLongMsg}";
			}
			else {
				$return_msg = $ErrorShortMsg;
			}

			return array("error" => $return_msg);
		}
	}
}

?>