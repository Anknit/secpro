<?php

if (session_id() == "")
	session_start();
$PROXY_HOST = '127.0.0.1';
$PROXY_PORT = '808';
$SandboxFlag = true; //false ;//true;
$baseURL = 'http://localhost/Web_Project_Workspace/Web_Projects'; 

//' PayPal API Credentials
//' Replace <API_USERNAME> with your API Username
//' Replace <API_PASSWORD> with your API Password
//' Replace <API_SIGNATURE> with your Signature
//'------------------------------------

if($SandboxFlag == false)
{
	$API_UserName="fereidoon_api1.veneratech.com";
	$API_Password="PL4LBNF6U7R9Y72C";
	$API_Signature="AFcWxV21C7fd0v3bYYYRCpSSRl31A.xHb9BM17-HPFZCinABSZWcij9s";
}
else
{
	$API_UserName="fereidoon-facilitator_api1.veneratech.com";
	$API_Password="W4YC27G98WHV9FN8";
	$API_Signature="AFcWxV21C7fd0v3bYYYRCpSSRl31AO8Yrl-2KofC2uLKjK.Gaa07dTEr";
}

/* for nbox testung 

*/
if (session_id() == "")
	session_start();

// BN Code 	is only applicable for partners
//$sBNCode = "PP-ECWizard";


/*
 ' Define the PayPal Redirect URLs.
' 	This is the URL that the buyer is first sent to do authorize payment with their paypal account
' 	change the URL depending if you are testing on the sandbox or the live PayPal site
'
' For the sandbox, the URL is       https://www.sandbox.paypal.com/webscr&cmd=_express-checkout&token=
' For the live site, the URL is        https://www.paypal.com/webscr&cmd=_express-checkout&token=
*/

if ($SandboxFlag == true)
{
	$API_Endpoint = "https://api-3t.sandbox.paypal.com/nvp";
	$PAYPAL_URL = "https://www.sandbox.paypal.com/webscr?cmd=_express-checkout&token=";
}
else
{
	$API_Endpoint = "https://api-3t.paypal.com/nvp";
	$PAYPAL_URL = "https://www.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token=";
}
$USE_PROXY = false;
$version="93";
$returnURL = $_SESSION['HTTP_ROOT'].'PulsarPPU/User%20Interface/confirmTransaction.php';
$cancelURL = $_SESSION['HTTP_ROOT'].'PulsarPPU/User%20Interface/UserPage.php';
//Web_Project_Workspace\Web_Projects\TestPaypal
$currencyCodeType = "USD";
$paymentType = "Sale";
$purchaseDescription = "Pulsar Pay-Per-Use credit purchase"; 
$brandName = 'Venera Technologies Inc.';
//$companyLogoURL = 'http://www.ufomoviez.com/Images/logo.jpg';
$companyLogoURL = 'http://www.veneratech.com/content/veneralogo.png'; 
?>
