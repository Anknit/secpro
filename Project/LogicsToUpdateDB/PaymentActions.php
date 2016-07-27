<?php
error_reporting(0);
global $Module;
require_once __DIR__.'./../require.php';
require_once Common.'php/MailMgr.php';

if($Module['PaymentManagement'])	//If subscription update is set to true for the logged in user
{
	if(isset($_SESSION) && $_SESSION['userID'] != "" )
	{
		if($cat == 'add'){
			$payObj	=	json_decode($payObj,true);
			date_default_timezone_set('UTC');
			$paymentAct	=	DB_Insert(array(
				'Table' => 'paymentinfo',
				'Fields'=>	array(							
							'transactionId' 	=>	getPaymentTransactionid(),
							'accountId' 		=>	$payObj['custNam'],
							'amountPaid'		=> 	$payObj['amountP'],
							'creditAmount'		=>	$payObj['amountC'],
							'serviceRate' 		=>	$payObj['rate'],
							'creditMinutes' 	=>	$payObj['creditMin'],
							'paymentDate'		=> 	date("Y-m-d H:i:s"),
							'validityPeriod'	=> 	strtotime($payObj['validity']),
							'paymentMode'		=> 	'1', 		// For Manual Payment
							'paymentStatus'		=> 	'1'		// For success status (2 for pending ; 3 for failure)
							)
			));
			if($paymentAct){
				$updateAccount	=	DB_Query("Update accountinfo SET accountValidity = '".strtotime($payObj['validity'])."', creditMinutes = creditMinutes+".$payObj['creditMin']." , updationDate = '".date("Y-m-d")."' where accountId = '".$payObj['custNam']."'");
				if($updateAccount == 0){
					$Output	=	0;
					$controllerResponse	=	NOVA_COMMUNICATION('notify',array('type'=>'credit-account','id'=>$payObj['custNam']));
					if($controllerResponse !== 0 && $controllerResponse !== '0'){
						SetErrorCodes($controllerResponse, __LINE__,  __FILE__);
						$Output	=	1;
					}
				}
				else{
					DB_Query("Update paymentinfo Set paymentStatus = 3 where paymentId = ".$paymentAct);
					$Output	=	'Failure';
				}
			}
			else{
				$Output	=	'Failure';
			}
		}
	}
}
function getPaymentTransactionid(){
	$tranStr	=	'PN'.date("dmYhis");
	return $tranStr;
}

?>