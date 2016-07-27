<?php
/*
* Author: Ankit
* date: 22-July-2015
* Description: This defines cron tasks that are required to be automated
*
*/
require_once __DIR__.'/../../Common/php/OperateDB/DbMgrInterface.php';
require_once __DIR__.'/../../Common/php/ErrorHandling.php';
require_once __DIR__.'/../../Common/php/commonfunctions.php';
require_once __DIR__.'/../definePaths.php';
require_once __DIR__.'/../ErrorMessages.php';
require_once __DIR__.'/../adminMethods.php';
require_once __DIR__.'/../ControllerNotification/requestMethods.php';

//Database backup
$backupCreatedFileInTempDir	=	DB_Backup('');
$dbbackupFilePath	=	__DIR__.'/../../temp/'.$backupCreatedFileInTempDir;

if(!file_exists($dbbackupFilePath)){
	ErrorLogging('Cron error: Failed to create db backup. Error on line number- '.__LINE__.', in file '.__FILE__);
}

//Update account validities. This isn't required because account validities are automatically updated by 6 months when user purchases credits in account
/*
	Scenario: For all types of credit purchases in account, the accountvalidity is updated by 180 days., For all types of debits, the account updatedon field is updated
	So as per this, if accountvalidity expiry date is met, and updated on field has datethat lies in last 180 days, then update account validity by 6 months
*/

//Auto renewal
/*
	Scenario: For all pulsar users in unlimited mode, whose validity end date has expired, check their auto renewal field. If it is on, then perform all the operations done while shifting a user from hourly to unlimited mode. Keep this logic at sync.
*/
//require_once 'autoRenewUnlimitedUsersSubscription.php';
//Calculate Package Price for selected package.


//Deactivate account on account expiry
/*
	Scenario: For all accounts whose expiry date has passed, set status to Inactive (2)
*/

$deactivateAccountOP	=	deactivateAccount();
if($deactivateAccountOP != 0){
	for($da=0;$da<count($deactivateAccountOP);$da++){
		$controllerResponse	=	NOVA_COMMUNICATION('notify',array('type'=>'inactive-account','id'=>$deactivateAccountOP[$da]));
		if($controllerResponse !== 0 && $controllerResponse !== '0'){
			SetErrorCodes($controllerResponse, __LINE__,  __FILE__);
			$Output	=	1;
		}
	}
}
/*function MoveUsersToHourlyModeWhenSubscriptionExpires(){
/*
	Get the list of users which are in unlimited subscription mode. Check if the subscription has expired.
	If it has expired then shift the users to hourly mode. To shift them to hourly mode, set their subscription plan value to that of hourly
	To shift a user to houly plan set its licenseinfo string and subscription_Type, package 0
*/
	// read all users from database whose subscription has expired and auto renew is off
/*	$users_UnlimitedSubscription_Expired_AutoRenewOFF	=	DB_Read(array(
		'Table'=> 'usersubscriptioninfo',
		'Fields'=> 'UserID',
		'clause'=>	'Subscription_Type = '.Subscription_PayPerMonth.' AND Auto_Renewal = '.RENEWAL_OFF.' AND Validity_End_Date < CURDATE()',
	), 'ASSOC', '');
	
	if($users_UnlimitedSubscription_Expired_AutoRenewOFF != 0) {
		for($i =0; $i< count($users_UnlimitedSubscription_Expired_AutoRenewOFF); $i++){
			// get existing features of the user
			DB_Update(array(
				'Table'=> 'usersubscriptioninfo',
				'Fields'=> array('Subscription_Type' => Subscription_PayPerUse, 'Package' => 0),
				'clause'=> 'UserID = '.$users_UnlimitedSubscription_Expired_AutoRenewOFF[$i]['UserID'],
			),'ASSOC','');
			
			DB_Update(array(
				'Table'=> 'licenseinfo',
				'Fields'=> array('Features' => DefaultFeaturesForPPU),
				'clause'=> 'UserID = '.$users_UnlimitedSubscription_Expired_AutoRenewOFF[$i]['UserID'],
			),'ASSOC','');
		}
	}
}

MoveUsersToHourlyModeWhenSubscriptionExpires();


//Flush demo credits on account expiry
/*
	Scenario: For users who have not made a payment into their portal account, then reset their credits to zero if account validity has expired.
*/

/*function ResetDemoCreditsAfterExpiry(){
	$queryFindUsers	=	"Select accountcredit_info.AccountID, CreditAmount, accountValidity, UserID, UserType from accountcredit_info INNER JOIN userinfo on  accountcredit_info.AccountID = userinfo.AccountID WHERE UserType = 3 AND accountValidity < CURDATE() AND CreditAmount > 0";
	$resultUsers	=	DB_Query($queryFindUsers, 'ASSOC');
	if($resultUsers){
		$totalSuchUsers	=	count($resultUsers);
		if($totalSuchUsers > 0){
			for($i = 0; $i < $totalSuchUsers; $i++){
				$CustomerID	=	$resultUsers[$i]['UserID'];
				$AccountID	=	$resultUsers[$i]['AccountID'];
				$queryCheckIfPaymentHasBeenMade	=	"Select AmountPaid from payment_info WHERE CustomerID = ".$CustomerID." AND Pay_Mode != ".Voucher_Demo;
				$resultPayments	=	DB_Query($queryCheckIfPaymentHasBeenMade, 'ASSOC');
				$paymentMade	=	false;
				if($resultPayments){
					$totalPaymentEntries	=	count($resultPayments);
					if($totalPaymentEntries > 0){
						$paymentMade	=	true;
					}
				}
				
				if(!$paymentMade){	//no payment has been made
					$resetDemoCredits	=	array(
						"Table" => "accountcredit_info",
						"Fields" => array("CreditAmount" => "0"),
						"clause" => "AccountID = ".$AccountID,
					);	
					$resetAmount	=	DB_Update($resetDemoCredits);
				}
			}
		}
	}
}

ResetDemoCreditsAfterExpiry();
*/
//Clear session info table. This has growing data, and is not of much use, except that for monitoring in rarest issues cases. So delete the sessions which have been closed successfully and are older than a week.
function clearSessionInfoTable(){
	$deleteQuery	=	DB_Query("DELETE FROM sessioninfo WHERE endTime != '' && endTime < NOW() - INTERVAL 1 MONTH");
}
clearSessionInfoTable();

?>
