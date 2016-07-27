<?php  /*
* Author: Nitin Aloria
* date: 06-August-2015
* Description: This defines methods required for automated email alerts settings
*/
error_reporting(0);
global $Module;
require_once __DIR__.'./../require.php';

if($Module['ReportManagement']){//If report management is set to true for the logged in user
	if(isset($_SESSION) && $_SESSION['userID'] != "" ){
		
		if(isset($alertFrequency) && isset($errorThreshold)){
			if(!isset($errorAlertEmail)){
				$errorAlertEmail = '';
			}else{
				$errorAlertEmail = ', recipentEmailIds= "'.$errorAlertEmail.'"';
			}
			$updateQuery = 'UPDATE emailalertsettings SET `interval`='.$alertFrequency.', errorLimit='.$errorThreshold.$errorAlertEmail.' WHERE accountId = '.$_SESSION["accountID"];
			$updateResult	=	 DB_Query($updateQuery);
			if($updateResult || ($updateResult == 0)){
				$controllerResponse	=	NOVA_COMMUNICATION('notify',array('type'=>'modify-alertSetting','id'=>$_SESSION["accountID"]));
				if($controllerResponse !== 0 && $controllerResponse !== '0'){
					SetErrorCodes($controllerResponse, __LINE__,  __FILE__);
					$updateQuery = 'UPDATE emailalertsettings SET `interval`='.ErrorAlertFrequency.', errorLimit='.ErrorAlertThreshold.' WHERE accountId = '.$_SESSION["accountID"];
					$updateResult	=	 DB_Query($updateQuery);
				}else{
					$Output	=	0;
				}
			}
		
		}
	}
}

?>