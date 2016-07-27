<?php
error_reporting(0);
global $Module;
require_once __DIR__.'./../require.php';
require_once Common.'php/MailMgr.php';
	
if($Module['ReportManagement'])	//If report management is set to true for the logged in user
{
	if(isset($_SESSION) && $_SESSION['userID'] != "" )
	{
		$Output	=	0;
		if(isset($frequency)){
			$updateReportSettingsQuery	=	"UPDATE reportsettings SET `interval` = ".$frequency." Where accountId = ".$_SESSION['accountID'];
			$updateReult	=	 DB_Query($updateReportSettingsQuery);	
			if($updateReult == 0){
				$usersList = DB_Read ( array (
						'Table' => 'reportsettings',
						'Fields' => 'userId',
						'clause' => 'accountId = "' . $_SESSION['accountID'] . '" '
				), 'ASSOC', '' );
				$commaSeparatedListUserID = '';
				foreach($usersList as $key => $value){
					if($commaSeparatedListUserID	!= ''){
						$commaSeparatedListUserID	.= ',';
					}
					$commaSeparatedListUserID .= $value['userId'];
				}
				$controllerResponse	=	NOVA_COMMUNICATION('notify',array('type'=>'modify-reportSetting','id'=>$commaSeparatedListUserID));
				if($controllerResponse !== 0 && $controllerResponse !== '0'){
					$Output	=	$controllerResponse;
					SetErrorCodes($controllerResponse, __LINE__,  __FILE__);
				}
			}
			else{
				$Output	=	1;
			}
		}
		elseif(isset($timezone)){
			$updateTimezoneQuery	=	"UPDATE accountinfo SET timezoneId = ".$timezone." Where accountId = ".$_SESSION['accountID'];
			$updateReult	=	 DB_Query($updateTimezoneQuery);	
			if($updateReult == 0){
/*				$usersList = DB_Read ( array (
						'Table' => 'reportsettings',
						'Fields' => 'userId',
						'clause' => 'accountId = "' . $_SESSION['accountID'] . '" '
				), 'ASSOC', '' );
				$commaSeparatedListUserID = '';
				foreach($usersList as $key => $value){
					if($commaSeparatedListUserID	!= ''){
						$commaSeparatedListUserID	.= ',';
					}
					$commaSeparatedListUserID .= $value['userId'];
				}
*/
/*				$controllerResponse	=	NOVA_COMMUNICATION('notify',array('type'=>'modify-timezone','id'=>$_SESSION['accountID']));
				if($controllerResponse !== 0 && $controllerResponse !== '0'){
					$Output	=	$controllerResponse;
					SetErrorCodes($controllerResponse, __LINE__,  __FILE__);
				}
*/			}
			else{
				$Output	=	1;
			}
		}
	}
}
?>