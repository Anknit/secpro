<?php
error_reporting(0);
global $Module;
require_once __DIR__.'./../require.php';
require_once Common.'php/MailMgr.php';
	
if($Module['ProfileManagement'])	//If profile update is set to true for the logged in user
{
	if(isset($_SESSION) && $_SESSION['userID'] != "" )
	{
		if($cat == 'edit'){
			$data	=	json_decode($data,TRUE);
			$updateProfileTableQuery	=	"UPDATE profileinfo SET profileStatus=(CASE ";
			foreach($data as $key => $value){
				$updateProfileTableQuery .= "WHEN profileId='".$key."' THEN ".$data[$key]." ";
			}
			$updateProfileTableQuery .= "ELSE profileStatus END)";
			$updateProfileTableQuery .= ", updateState=(CASE WHEN channelId='".$chId."' AND updateState='2' THEN '1' WHEN channelId='".$chId."' AND updateState='3' THEN '4' ELSE updateState END)";
			DB_Query($updateProfileTableQuery);	
		}
	}
}
?>
