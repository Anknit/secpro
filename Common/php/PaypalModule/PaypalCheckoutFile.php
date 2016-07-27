<?php

require_once 'PaypalAPI.php';
if(isset($_POST['Payment_Amount']))
{
	$paymentAmount = $_POST['Payment_Amount'];
	global $returnURL , $cancelURL, $currencyCodeType, $paymentType;
	$resArray = InitiateExpressCheckout($paymentAmount, $currencyCodeType, $paymentType, $returnURL, $cancelURL);
}

?>