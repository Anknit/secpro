<?php
error_reporting(0);
global $Module;
require_once __DIR__.'./../require.php';
require_once Common.'php/MailMgr.php';
	
if($Module['LayoutManagement'])	//If profile update is set to true for the logged in user
{
	if(isset($_SESSION) && $_SESSION['userID'] != "" )
	{
		$Output	=	0;
		if(isset($settingObj)){
			$settingObj		=	json_decode($settingObj,true);
			$updateOperatorSettingTableQuery	=	"UPDATE operatorsettings SET monitorView=(CASE ";
			foreach($settingObj as $key => $value){
				$updateOperatorSettingTableQuery .= "WHEN userId='".$key."' THEN ".$settingObj[$key]." ";
			}
			$updateOperatorSettingTableQuery .= "ELSE monitorView END)";
			$updateResult	=	DB_Query($updateOperatorSettingTableQuery);
			if($updateReult != 0){
				$Output	=	1;
			}
		}
	}
}
?>