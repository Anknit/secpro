<?php
	require __DIR__."/PaypalConfig.php"; 
	require_once __DIR__ ."./../OperateDB/DbMgrInterface.php";
	require_once __DIR__ ."./../../../PulsarPPU/CommonMethods.php";
	/*if (session_id() == "") 
		session_start();
		*/
	

	/* An express checkout transaction starts with a token, that
	   identifies to PayPal your transaction
	   In this example, when the script sees a token, the script
	   knows that the buyer has already authorized payment through
	   paypal.  If no token was found, the action is to send the buyer
	   to PayPal to first authorize payment
	   */

	/*   
	'-------------------------------------------------------------------------------------------------------------------------------------------
	' Purpose: 	Prepares the parameters for the SetExpressCheckout API Call.
	' Inputs:  
	'		paymentAmount:  	Total value of the shopping cart
	'		currencyCodeType: 	Currency code value the PayPal API
	'		paymentType: 		paymentType has to be one of the following values: Sale or Order or Authorization
	'		returnURL:			the page where buyers return to after they are done with the payment review on PayPal
	'		cancelURL:			the page where buyers return to when they cancel the payment review on PayPal
	'--------------------------------------------------------------------------------------------------------------------------------------------	
	*/
	function InitiateExpressCheckout( $paymentAmount, $currencyCodeType, $paymentType, $returnURL, $cancelURL) 
	{
		global $purchaseDescription, $brandName; 
		//------------------------------------------------------------------------------------------------------------------------------------
		// Construct the parameter string that describes the SetExpressCheckout API call in the shortcut implementation
		$_SESSION["Payment_Amount"] = $paymentAmount;
		$nvpstr="&PAYMENTREQUEST_0_AMT=". $paymentAmount;		
		$nvpstr = $nvpstr . "&PAYMENTREQUEST_0_PAYMENTACTION=" . $paymentType;
		$nvpstr = $nvpstr . "&RETURNURL=" . $returnURL;
		$nvpstr = $nvpstr . "&CANCELURL=" . $cancelURL;
		$nvpstr = $nvpstr . "&PAYMENTREQUEST_0_CURRENCYCODE=" . $currencyCodeType;		
		//my code 
		$nvpstr = $nvpstr . "&NOSHIPPING=" . '1';
		$nvpstr = $nvpstr . "&SOLUTIONTYPE=" . 'Sole';
		$nvpstr = $nvpstr . "&LANDINGPAGE=" . 'Billing';
		$nvpstr = $nvpstr . "&TOTALTYPE=" . 'Total';
		$nvpstr = $nvpstr . "&BRANDNAME=" . $brandName;
		$_SESSION['invoicenum'] = GetUniqueInvoiceNumber();
		$nvpstr = $nvpstr . "&PAYMENTREQUEST_0_INVNUM=" . $_SESSION['invoicenum'];
		
		$nvpstr = $nvpstr . "&PAYMENTREQUEST_0_DESC=" . $purchaseDescription;
		//$nvpstr = $nvpstr . "&PAYMENTREQUEST_0_CUSTOM=" . 'My custom field';
		$_SESSION["purchase_descr"] =  $purchaseDescription; 		
		$nvpstr = $nvpstr . "&L_PAYMENTREQUEST_0_NAME0=" . $purchaseDescription;		
		$nvpstr = $nvpstr . "&L_PAYMENTREQUEST_0_AMT0=" . $paymentAmount;
		$nvpstr = $nvpstr . "&L_PAYMENTREQUEST_0_QTY0=" . '1';
		
		
		$nvpstr = $nvpstr . "&PAGESTYLE=" . 'VeneraCustomPage';		
		//$nvpstr = $nvpstr . "&HDRIMG=" . $companyLogoURL;
		//$nvpstr = $nvpstr . "&LOGOIMG=" . $companyLogoURL;		
		$nvpstr = $nvpstr . "&HDRIMG=" . 'http://www.veneratech.com/content/veneralogo.png';
		//$nvpstr = $nvpstr . "&LOGOIMG=" . 'http://www.ufomoviez.com/Images/logo.jpg';
		$nvpstr = $nvpstr . "&LOGOIMG=" .  'http://www.veneratech.com/content/veneralogo.png'; 
		
		
		$nvpstr = $nvpstr . "&LANDINGPAGE=" . 'Billing';		
		$_SESSION["currencyCodeType"] = $currencyCodeType;	  
		$_SESSION["PaymentType"] = $paymentType;

		//'--------------------------------------------------------------------------------------------------------------- 
		//' Make the API call to PayPal
		//' If the API call succeded, then redirect the buyer to PayPal to begin to authorize payment.  
		//' If an error occured, show the resulting errors
		//'---------------------------------------------------------------------------------------------------------------
	    $resArray=hash_call("SetExpressCheckout", $nvpstr);
		$ack = strtoupper($resArray["ACK"]);
		if($ack=="SUCCESS" || $ack=="SUCCESSWITHWARNING")
		{
			$token = urldecode($resArray["TOKEN"]);
			$_SESSION['TOKEN']=$token;
			RedirectToPayPal ( $resArray["TOKEN"] );
		}		
		else
		{
			//Display a user friendly Error on the page using any of the following error information returned by PayPal
			//$ErrorCode = urldecode($resArray["L_ERRORCODE0"]);
			//$ErrorShortMsg = urldecode($resArray["L_SHORTMESSAGE0"]);
			///$ErrorLongMsg = urldecode($resArray["L_LONGMESSAGE0"]);
			//$ErrorSeverityCode = urldecode($resArray["L_SEVERITYCODE0"]);
			return $resArray;
		}
	   
	}

	/*   
	'-------------------------------------------------------------------------------------------------------------------------------------------
	' Purpose: 	Prepares the parameters for the SetExpressCheckout API Call.
	' Inputs:  
	'		paymentAmount:  	Total value of the shopping cart
	'		currencyCodeType: 	Currency code value the PayPal API
	'		paymentType: 		paymentType has to be one of the following values: Sale or Order or Authorization
	'		returnURL:			the page where buyers return to after they are done with the payment review on PayPal
	'		cancelURL:			the page where buyers return to when they cancel the payment review on PayPal
	'		shipToName:		the Ship to name entered on the merchant's site
	'		shipToStreet:		the Ship to Street entered on the merchant's site
	'		shipToCity:			the Ship to City entered on the merchant's site
	'		shipToState:		the Ship to State entered on the merchant's site
	'		shipToCountryCode:	the Code for Ship to Country entered on the merchant's site
	'		shipToZip:			the Ship to ZipCode entered on the merchant's site
	'		shipToStreet2:		the Ship to Street2 entered on the merchant's site
	'		phoneNum:			the phoneNum  entered on the merchant's site
	'--------------------------------------------------------------------------------------------------------------------------------------------	
	*/
/*
	'-------------------------------------------------------------------------------------------
	' Purpose: 	Prepares the parameters for the GetExpressCheckoutDetails API Call.
	'
	' Inputs:  
	'		None
	' Returns: 
	'		The NVP Collection object of the GetExpressCheckoutDetails Call Response.
	'-------------------------------------------------------------------------------------------
	*/
	function GetExpressCheckoutDetails( $token )
	{
		//'--------------------------------------------------------------
		//' At this point, the buyer has completed authorizing the payment
		//' at PayPal.  The function will call PayPal to obtain the details
		//' of the authorization, incuding any shipping information of the
		//' buyer.  Remember, the authorization is not a completed transaction
		//' at this state - the buyer still needs an additional step to finalize
		//' the transaction
		//'--------------------------------------------------------------
	   
	    //'---------------------------------------------------------------------------
		//' Build a second API request to PayPal, using the token as the
		//'  ID to get the details on the payment authorization
		//'---------------------------------------------------------------------------
	    $nvpstr="&TOKEN=" . $token;

		//'---------------------------------------------------------------------------
		//' Make the API call and store the results in an array.  
		//'	If the call was a success, show the authorization details, and provide
		//' 	an action to complete the payment.  
		//'	If failed, show the error
		//'---------------------------------------------------------------------------
	    $resArray=hash_call("GetExpressCheckoutDetails",$nvpstr);
	    $ack = strtoupper($resArray["ACK"]);
		if($ack == "SUCCESS" || $ack=="SUCCESSWITHWARNING")
		{	
			$_SESSION['payer_id'] =	$resArray['PAYERID'];
		} 
		return $resArray;
	}
	
	/*
	'-------------------------------------------------------------------------------------------------------------------------------------------
	' Purpose: 	Prepares the parameters for the GetExpressCheckoutDetails API Call.
	'
	' Inputs:  
	'		sBNCode:	The BN code used by PayPal to track the transactions from a given shopping cart.
	' Returns: 
	'		The NVP Collection object of the GetExpressCheckoutDetails Call Response.
	'--------------------------------------------------------------------------------------------------------------------------------------------	
	*/
	function ConfirmPayment( $FinalPaymentAmt , &$resArray)
	{
		/* Gather the information to make the final call to
		   finalize the PayPal payment.  The variable nvpstr
		   holds the name value pairs
		   */
		

		//Format the other parameters that were stored in the session from the previous calls	
		$token 				= urlencode($_SESSION['TOKEN']);
		$paymentType 		= urlencode($_SESSION['PaymentType']);
		$currencyCodeType 	= urlencode($_SESSION['currencyCodeType']);
		$payerID 			= urlencode($_SESSION['payer_id']);

		$serverName 		= urlencode($_SERVER['SERVER_NAME']);

		$nvpstr  = '&TOKEN=' . $token . '&PAYERID=' . $payerID . '&PAYMENTREQUEST_0_PAYMENTACTION=' . $paymentType . '&PAYMENTREQUEST_0_AMT=' . $FinalPaymentAmt;
		$nvpstr .= '&PAYMENTREQUEST_0_CURRENCYCODE=' . $currencyCodeType . '&IPADDRESS=' . $serverName; 
		
		

		 /* Make the call to PayPal to finalize payment
		    If an error occured, show the resulting errors
		    */
		$resArray=hash_call("DoExpressCheckoutPayment",$nvpstr);

		/* Display the API response back to the browser.
		   If the response from PayPal was a success, display the response parameters'
		   If the response was an error, display the errors received using APIError.php.
		   */
		$ack = strtoupper($resArray["ACK"]);

		return $ack;
	}
	
	/*
	'-------------------------------------------------------------------------------------------------------------------------------------------
	' Purpose: 	This function makes a DoDirectPayment API call
	'
	' Inputs:  
	'		paymentType:		paymentType has to be one of the following values: Sale or Order or Authorization
	'		paymentAmount:  	total value of the shopping cart
	'		currencyCode:	 	currency code value the PayPal API
	'		firstName:			first name as it appears on credit card
	'		lastName:			last name as it appears on credit card
	'		street:				buyer's street address line as it appears on credit card
	'		city:				buyer's city
	'		state:				buyer's state
	'		countryCode:		buyer's country code
	'		zip:				buyer's zip
	'		creditCardType:		buyer's credit card type (i.e. Visa, MasterCard ... )
	'		creditCardNumber:	buyers credit card number without any spaces, dashes or any other characters
	'		expDate:			credit card expiration date
	'		cvv2:				Card Verification Value 
	'		
	'-------------------------------------------------------------------------------------------
	'		
	' Returns: 
	'		The NVP Collection object of the DoDirectPayment Call Response.
	'--------------------------------------------------------------------------------------------------------------------------------------------	
	*/



	/**
	  '-------------------------------------------------------------------------------------------------------------------------------------------
	  * hash_call: Function to perform the API call to PayPal using API signature
	  * @methodName is name of API  method.
	  * @nvpStr is nvp string.
	  * returns an associtive array containing the response from the server.
	  '-------------------------------------------------------------------------------------------------------------------------------------------
	*/
	function hash_call($methodName,$nvpStr)
	{
		//declaring of global variables
		global $API_Endpoint, $version, $API_UserName, $API_Password, $API_Signature;
		global $USE_PROXY, $PROXY_HOST, $PROXY_PORT;
		global $gv_ApiErrorURL;
		global $sBNCode;

		//setting the curl parameters.
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$API_Endpoint);
		curl_setopt($ch, CURLOPT_VERBOSE, 1);
		curl_setopt($ch, CURLOPT_SSLVERSION, 'CURL_SSLVERSION_TLSv1');
		curl_setopt($ch, CURLOPT_SSL_CIPHER_LIST, 'SSLv3');

		//turning off the server and peer verification(TrustManager Concept).
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);

		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_POST, 1);
		
	    //if USE_PROXY constant set to TRUE in Constants.php, then only proxy will be enabled.
	   //Set proxy name to PROXY_HOST and port number to PROXY_PORT in constants.php 
		if($USE_PROXY)
			curl_setopt ($ch, CURLOPT_PROXY, $PROXY_HOST. ":" . $PROXY_PORT); 

		//NVPRequest for submitting to server
		//$nvpreq="METHOD=" . urlencode($methodName) . "&VERSION=" . urlencode($version) . "&PWD=" . urlencode($API_Password) . "&USER=" . urlencode($API_UserName) . "&SIGNATURE=" . urlencode($API_Signature) . $nvpStr . "&BUTTONSOURCE=" . urlencode($sBNCode);
		$nvpreq="METHOD=" . urlencode($methodName) . "&VERSION=" . urlencode($version) . "&PWD=" . urlencode($API_Password) . "&USER=" . urlencode($API_UserName) . "&SIGNATURE=" . urlencode($API_Signature) . $nvpStr  ; //. "&BUTTONSOURCE=" . urlencode($sBNCode);

		//setting the nvpreq as POST FIELD to curl
		curl_setopt($ch, CURLOPT_POSTFIELDS, $nvpreq);
		//getting response from server
		$response = curl_exec($ch);

		//convrting NVPResponse to an Associative Array
		$nvpResArray=deformatNVP($response);
		$nvpReqArray=deformatNVP($nvpreq);
		$_SESSION['nvpReqArray']=$nvpReqArray;

		if (curl_errno($ch)) 
		{
			// moving to display page to display curl errors
			  $_SESSION['curl_error_no']=curl_errno($ch) ;
			  $_SESSION['curl_error_msg']=curl_error($ch);

			  //Execute the Error handling module to display errors. 
		} 
		else 
		{
			 //closing the curl
		  	curl_close($ch);
		}

		return $nvpResArray;
	}

	/*'----------------------------------------------------------------------------------
	 Purpose: Redirects to PayPal.com site.
	 Inputs:  NVP string.
	 Returns: 
	----------------------------------------------------------------------------------
	*/
	function RedirectToPayPal ( $token )
	{
		global $PAYPAL_URL;
		
		// Redirect to paypal.com here
		$payPalURL = $PAYPAL_URL . $token;
		header('Location: '.$payPalURL);
		exit;
	}

	
	/*'----------------------------------------------------------------------------------
	 * This function will take NVPString and convert it to an Associative Array and it will decode the response.
	  * It is usefull to search for a particular key and displaying arrays.
	  * @nvpstr is NVPString.
	  * @nvpArray is Associative Array.
	   ----------------------------------------------------------------------------------
	  */
	function deformatNVP($nvpstr)
	{
		$intial=0;
	 	$nvpArray = array();

		while(strlen($nvpstr))
		{
			//postion of Key
			$keypos= strpos($nvpstr,'=');
			//position of value
			$valuepos = strpos($nvpstr,'&') ? strpos($nvpstr,'&'): strlen($nvpstr);

			/*getting the Key and Value values and storing in a Associative Array*/
			$keyval=substr($nvpstr,$intial,$keypos);
			$valval=substr($nvpstr,$keypos+1,$valuepos-$keypos-1);
			//decoding the respose
			$nvpArray[urldecode($keyval)] =urldecode( $valval);
			$nvpstr=substr($nvpstr,$valuepos+1,strlen($nvpstr));
	     }
		return $nvpArray;
	}

	
	function MakePayment(&$resArray)
	{
		if(!isset($_SESSION) || !isset($_SESSION["TOKEN"]) )
			return 0; 
		$resArray = GetExpressCheckoutDetails($_SESSION["TOKEN"]);
		$_SESSION['payer_id'] = $resArray['PAYERID'];		
		$ack = ConfirmPayment($_SESSION["Payment_Amount"], $resArray);
		if($ack == 'SUCCESS')
			UpdatePaymentInfoForPaypal($resArray); 
		return $ack; 
	}
	function GetUniqueInvoiceNumber()
	{
		//scout the database
		//generate a random number
		$bExit = false;
		do {
			$invoicenum = rand (0 , 999999);
			$invoicenum = str_pad($invoicenum, 6, '0', STR_PAD_LEFT);
			$invoicenum = 'PPUS' . $invoicenum;
			//check with database if it is unique and then only return the value
			$ReadTestArray	=	array(
					'Fields'=> 'AmountPaid',
					'Table'=> 'payment_info',
					'clause'=> 'Invoicenum="'. $invoicenum . '"',
					'order'=>""
			);
			$Result	=	DB_Read($ReadTestArray, 'ASSOC', '');
			if(!$Result)
				$bExit = true;
		}while ($bExit == false)	;
		return $invoicenum;
	}
	
	function UpdatePaymentInfoForPaypal($resArray)
	{
		//get the AccountId for the user ID
		global $purchaseDescription; 
		if(!isset($_SESSION['accountID']))
			return false;
		$accountID = $_SESSION['accountID'];
		$userID = $_SESSION['userID'];
	
		$ReadTestArray	=	array(
				'Fields'=> 'CreditAmount',
				'Table'=> 'accountcredit_info',
				'clause'=> 'AccountId='.$accountID,
				'order'=>""
		);
		$Result	=	DB_Read($ReadTestArray, 'ASSOC', '');
		if(!$Result)
			return false;
	
		$amount = $Result[0]['CreditAmount'];
		$amount = $amount + $resArray['PAYMENTINFO_0_AMT'];
		//then go to the accountcredit_info table
		$WriteTestArray	=	array(
				'Table'=> 'accountcredit_info',
				'Fields'=> array('CreditAmount'=> $amount,
						'UpdatedOn'=> 'now()',
						'accountValidity'=> defaultPPUDates(1),
						),
				'clause'=> 'AccountId='.$accountID
		);
	
		$Result	=	DB_Update($WriteTestArray);
		if(!$Result)
		{
			$errMsg = 'Error: Unable to Update SUID field';
			$status = 'FAIL';
			return false;
		}
		
		//then go to payment_info table and update records
		$WriteTestArray	=	array(
				'Table'=> 'payment_info',
				'Fields'=> array('CustomerID'=> $userID,
						'InvoiceNum'=>$_SESSION['invoicenum'],
						'TransactionID'=>$resArray['PAYMENTINFO_0_TRANSACTIONID'],
						'ReceiptNo'=>$resArray['PAYMENTINFO_0_RECEIPTID'],
						'AmountPaid'=>$resArray['PAYMENTINFO_0_AMT'],
						'Paydate'=>str_replace("Z","",str_replace("T"," ",$resArray['PAYMENTINFO_0_ORDERTIME'])),
						'Pay_Mode'=>PayPal,
						'PurchaseDescription'=>$_SESSION["purchase_descr"],
						'CurrencyCode'=>$resArray['PAYMENTINFO_0_CURRENCYCODE']
				)
		);
		$Result	=	DB_Insert($WriteTestArray);
		$paymentInfoID	=	$Result;
		if(!$Result)
		{
			$errMsg = 'Error: Unable to Update Usage Info Table';
			$status = 'FAIL';
			return false;
		}
									
		//Send invoice mail to the customer
		if($paymentInfoID) {
			$Paymentinfo	=	isPresentInDatabse('payment_info','PaymentIndex',$paymentInfoID);
			generateAndMailInvoice($Paymentinfo);
		}

		return true;
	}
?>
