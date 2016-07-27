<?php

/*
 * This function will moderate and distribute the paramters to appropriate 
 * functions. 
 */
include_once "../Common/php/SessionManager.php";
include_once "RPCDefinition.php";
include_once "definitions.php";
include_once "./../Common/php/ErrorHandling.php";
include_once "./ErrorMessages.php";

$clientAppType = ''; 


Message_Handler(); 

function Message_Handler()
{
	$sessionID = $_REQUEST['PHPSESSIONID'];
	$oprtnType = $_REQUEST['OPERATION_TYPE'];
	$oprtnName = $_REQUEST['OPERATION_NAME'];	
	$paramStr = $GLOBALS['HTTP_RAW_POST_DATA'] ;	
	
	global $clientAppType; 
	$clientAppType = DetermineApplicationType(); 
	
	$sessionID = SM_StartSession($sessionID); 
	if( ($sessionID) && ($oprtnName != 'RPC_SessionInitialize') )
	{
		$retval = SM_IS_SessionValid($sessionID);
		if($retval != true)
		{
			$paramStr = 'Invalid Session ID';
			goto E;
		}
	}		
	if($oprtnType == 'RPC')
	{
		switch($oprtnName)
		{
			case 'RPC_SessionInitialize':
				RPC_SessionInitialize($paramStr);
				break; 
			case 'RPC_GetUserID':
				RPC_GetUserID($paramStr);
				break;
			case 'RPC_GetLicenseInfo':
				RPC_GetLicenseInfo($paramStr); 
				break; 
			case 'RPC_ValidateUsage':
				RPC_ValidateUsage($paramStr); 
				break; 
			case 'RPC_ConfirmDebit':
				RPC_ConfirmDebit($paramStr); 
				break;		
			case 'RPC_CloseSession':
				$paramStr = '&STATUS=SUCCESS'; 
				RPC_CloseSession($sessionID); 
				break; 	
			default:
				break; 
		}		
	}	
	else if($oprtnType == 'RFT')
	{
		//get the message 
		$retval = SM_IS_SessionValid($sessionID);
		if($retval != true)
		{
			$paramStr = '&STATUS=FAILURE&MESSAGE=Invalid Session ID';			
		}
		else
			$paramStr = '&STATUS=SUCCESS&MESSAGE='; 
		//check if the session is a valid one 
	}
E: 		 
	//send response here 
	http_myresponse_code('200');
	print($paramStr);
	
}

function closeSession($sessionID){
	$status = session_status(); 
	if($status == PHP_SESSION_ACTIVE)
	{
		//NOW UPDATE THE SESSION ID INFO TABLE
		$WriteTestArray	=	array(
				'Table'=> 'session_info',
				'Fields'=> array('EndTime'=>'now()'),
				'clause'=>'sessionID="'.$sessionID.'"'
		);
		$Result	=	DB_Update($WriteTestArray);
		if(!$Result)
		{
			SetErrorCodes(getErrorMessage(37).'. Session ID: '.$sessionID, __LINE__,  __FILE__);
		}			
		
		SM_CloseSession();	
	}
}

function DetermineApplicationType()
{
	$browserAgent = $_SERVER['HTTP_USER_AGENT'];	
	if($browserAgent == 'Pulsar')
		return 'NATIVE';
	else //FOR TESTINGN PURPOSE
		return 'NATIVE'; //'BROWSER'; 
}

function SessionInitialize(&$respParam)
{
	$sessionID = '';
	$status = 'SUCCESS';
	parse_str($respParam);
	if(!isset($USERID))
	{
		$status = 'FAIL';
		$errMsg = "User ID not set properly";
		SetErrorCodes(getErrorMessage(29), __LINE__,  __FILE__);
		goto E;
	}
	global $clientAppType;
	$userName = strtoupper($USERID);
	$password   = $PASSWORD;
	if($clientAppType == 'NATIVE')
		$password =  $PASSWORD; 
	$suid = strtoupper($SUID);
	$serv_family = strtoupper($SERVICE_FAMILY);
	$errMsg = '';
	$accountID; 
	$userID; 
	//NOW VALIDATE THE username and password from the database
	$ReadTestArray	=	array(
			'Fields'=> 'UserID, Username, Password,AccountID,userStatus',
			'Table'=> 'userinfo',
			'clause'=> 'Username="'.$userName.'"',
			'order'=>""
	);
	$Result	=	DB_Read($ReadTestArray, 'ASSOC', '');
	if(!$Result)
	{
		$errMsg = 'Error: Login Credentials not found';
		SetErrorCodes(getErrorMessage(28), __LINE__,  __FILE__);
		$status = 'FAIL';
		goto E;
	}
	//validate username 
	if($userName != strtoupper($Result[0]['Username']) )
	{
		$errMsg = 'Error:User name mismatch';
		$status = 'FAIL'; 
		goto E;	
	}
	//validate the password
	if($password != $Result[0]['Password'])
	{
		$errMsg = 'Error:Password Does not match.';
		$status = 'FAIL';
		goto E;
	}
	//check account status 
	if($Result[0]['userStatus'] != ACTIVE )
	{
		$errMsg = 'Error:Account Status is not active';
		$status = 'FAIL';
		goto E;
	}
	$accountID = $Result[0]['AccountID']; 
	$userID =  $Result[0]['UserID']; 
	
	//RETRIEVE THE SUBSCRIPTION INFO AS WELL
	$retval = LM_CheckSubscriptionValidity($userID,$accountID, $daysLeft, $subscriptionType);	
	if($retval != true)
	{
		$status = 'FAIL';
		$errMsg = "Error: Subscription no longer valid";
		goto E;	
	}
	
	if($subscriptionType == Subscription_PayPerUse)
	{
		$retval  = BRM_CheckCreditBalance($accountID);
		$errMsg = 'Credit Balance: <b>$' . $retval . '</b> ';
		if($retval <= 0)
		{
			$status = 'FAIL';
			$errMsg = $errMsg . "Insufficient Credit Balance. Please recharge immediately";
			goto E;
		}
		if($retval < THRESHOLD)
		{
			$errMsg = $errMsg . 'Low Credit Balance, Please recharge immediately';
		}		
	}	
	
	//retrieve the License info from the database LicenInfo
	//if SUID is NULL   then fill this SUID in the database
	// if SUID is different from the existing entry then throw up an error
	
	if($suid)
	{
		//GET THE SUID FROM DATABASE 
		$ReadTestArray	=	array(
				'Fields'=> 'FirstTimeRegistration,SUID,ServiceID',
				'Table'=> 'licenseinfo',
				'clause'=> 'UserID='.$userID,
				'order'=>""
		);
		$Result	=	DB_Read($ReadTestArray, 'ASSOC', '');
		if(!$Result)
		{
			$errMsg = 'Error: License Registration Not Found';
			SetErrorCodes(getErrorMessage(25), __LINE__,  __FILE__);
			$status = 'FAIL';
			goto E;
		}
		
		//IF FIRSTTIME REGISTRATION NOT DONE THEN REGSITER THIS 
		if($Result[0]['FirstTimeRegistration'] == false)
		//if ($Result[0]['SUID'] ==  NULL) 
		{
			if($clientAppType == 'NATIVE')			
			{
				//THEN WRITE INTO THE DATABASE 
				$WriteTestArray	=	array(
						'Table'=> 'licenseinfo',
						'Fields'=> array('SUID'=> $suid,
								'FirstTimeRegistration'=>'1'),
						'clause'=> 'UserID='.$userID
				);

				$Result	=	DB_Update($WriteTestArray);
				if(!$Result)
				{
					$errMsg = 'Error: Unable to Update SUID field';
					SetErrorCodes(getErrorMessage(30), __LINE__,  __FILE__);
					$status = 'FAIL';
					goto E;
				}
			}
			else
			{
				//suid RELATED CHECKS 
				if($clientAppType == 'NATIVE')
				{
					if($subscriptionType == Subscription_PayPerMonth && $Result[0]['SUID'] != $suid)
					{
						$status = 'FAIL'; 
						$errMsg = "Error: The registered system does not match with the current system. Please Contact the support"; 
						SetErrorCodes(getErrorMessage(31), __LINE__,  __FILE__);
						goto E;
					}
				}
			}
		}//$suid
		//IF NULL THEN 
	}
	
	
	//ONLY AFTER SUCCESSFUL VALIDATION START THE SESSION
	//now start the session
	//get the session id
	//store all the retrieved values in session variable

	$sessionID = session_id();
	closeSession($sessionID);
	//starting a new session
	$sessionID = SM_StartSession($sessionID);

		
	//POPULATE ALL THE  RELEVANT SESSION VARIABLES HERE
	$_SESSION['sessionID']=$sessionID;
	$_SESSION['userName']=$userName;
	$_SESSION['userID']=$userID;
	$_SESSION['password']=$password;
	$_SESSION['suid'] = $suid;
	$_SESSION['serv_family'] = $serv_family;
	$_SESSION['accountID'] = $accountID;
	$_SESSION['subscriptionType']=$subscriptionType; 
	$_SESSION['daysRemaining']=$daysLeft;
	
	//NOW UPDATE THE SESSION ID INFO TABLE 
	$WriteTestArray	=	array(
			'Table'=> 'session_info',
			'Fields'=> array('sessionID'=> $sessionID,
					'UserID'=> $userID,
					'StartTime'=>'now()')
			);
	$Result	=	DB_Insert($WriteTestArray);
	if(!$Result)
	{
		$errMsg = 'Error: Unable to Update Session Info field';
		SetErrorCodes(getErrorMessage(32), __LINE__,  __FILE__);
		$status = 'FAIL';
		goto E;
	}
	
	//$_SESSION['serv_ID'] = $serv_ID; retrieve this value from the database
	//poupulate the account ID as well

	E:
	if($status == 'FAIL')
		$sessionID = '';
	$errMsg = $errMsg; 
	$respParam = '&STATUS=' . $status. '&SESSIONID='.$sessionID . '&MESSAGE='.$errMsg;
	return true;
}


function RPC_GetUserID(&$respParam)
{
	if($_SESSION['username'])
	{
		$respParam = $_SESSION['username'] . ' SUID=' . $_SESSION['suid'] . ' FAMILY=' .$_SESSION['serv_family'];
		return true; 
	}
	else
	{
		$respParam = "ERROR:Unable to Retrieve Session Variable"; 
		return  false;
	}	
}


function RPC_ProcessArray(&$respParam)
{
	parse_str($respParam);
	$myArr1Length = $MYARR1_LENGTH;
	//$myArr2Length = $MYARR2_LENGTH; 
	
	$ArrInputs = array($MYARR1[0]);

	for($k=1; $k < $myArr1Length; $k++)
	{
		$value = $MYARR1[$k];
		array_push($ArrInputs, $value);		
	}
	$respParam = 'Inputs Received= ' . $ArrInputs[0] . '-'. $ArrInputs[1] .'-'. $ArrInputs[2]; 
}

function http_myresponse_code($code = NULL) {

	if ($code !== NULL) {

		switch ($code) {
			case 100: $text = 'Continue'; break;
			case 101: $text = 'Switching Protocols'; break;
			case 200: $text = 'OK'; break;
			case 201: $text = 'Created'; break;
			case 202: $text = 'Accepted'; break;
			case 203: $text = 'Non-Authoritative Information'; break;
			case 204: $text = 'No Content'; break;
			case 205: $text = 'Reset Content'; break;
			case 206: $text = 'Partial Content'; break;
			case 300: $text = 'Multiple Choices'; break;
			case 301: $text = 'Moved Permanently'; break;
			case 302: $text = 'Moved Temporarily'; break;
			case 303: $text = 'See Other'; break;
			case 304: $text = 'Not Modified'; break;
			case 305: $text = 'Use Proxy'; break;
			case 400: $text = 'Bad Request'; break;
			case 401: $text = 'Unauthorized'; break;
			case 402: $text = 'Payment Required'; break;
			case 403: $text = 'Forbidden'; break;
			case 404: $text = 'Not Found'; break;
			case 405: $text = 'Method Not Allowed'; break;
			case 406: $text = 'Not Acceptable'; break;
			case 407: $text = 'Proxy Authentication Required'; break;
			case 408: $text = 'Request Time-out'; break;
			case 409: $text = 'Conflict'; break;
			case 410: $text = 'Gone'; break;
			case 411: $text = 'Length Required'; break;
			case 412: $text = 'Precondition Failed'; break;
			case 413: $text = 'Request Entity Too Large'; break;
			case 414: $text = 'Request-URI Too Large'; break;
			case 415: $text = 'Unsupported Media Type'; break;
			case 500: $text = 'Internal Server Error'; break;
			case 501: $text = 'Not Implemented'; break;
			case 502: $text = 'Bad Gateway'; break;
			case 503: $text = 'Service Unavailable'; break;
			case 504: $text = 'Gateway Time-out'; break;
			case 505: $text = 'HTTP Version not supported'; break;
			default:
				exit('Unknown http status code "' . htmlentities($code) . '"');
			break;
		}

		$protocol = (isset($_SERVER['SERVER_PROTOCOL']) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0');

		header($protocol . ' ' . $code . ' ' . $text);

		$GLOBALS['http_response_code'] = $code;

	} else {

		$code = (isset($GLOBALS['http_response_code']) ? $GLOBALS['http_response_code'] : 200);

	}

	return $code;
}


?>
