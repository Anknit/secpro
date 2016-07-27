<?php
/*
 * Author: Ankit
* date: 08-Aug-2014
* Description:	This page update the SMTP settings for mail sending .only applicable for Super User
*/
	require_once("../../../Common/php/OperateDB/DbMgrInterface.php");
	$SMTP_Host		= $_GET['smtpHostName'];
	$Port_Number	= $_GET['SmtpPortNumber'];
	$From 			= $_GET['SmtpSenderName'];
	$Username 		= $_GET['smtpUserName'];
	$Password 		= $_GET['smtpPassword'];
	
	$readInput 	= array(
							'Table'=> 'systemsettings',					
							'Fields'=> '*'
						);
	$result = DB_Read($readInput, 'NUM_ROWS', '');
	$smtpDetails 	= array(
							'Table'=> 'systemsettings',					
							'Fields'=> array (							
								'smtpHostName'	=>$SMTP_Host,
								'smtpUsername'	=>$Username,
								'smtpPassword'	=>$Password,
								'smtpPort'	=>$Port_Number,
								'sender'	=>$From
							)
						);
	
	if($result > 0)	//Update because entry is present
	{
		$result = DB_Update($smtpDetails);
	}
	else
	{
		$result = DB_Insert($smtpDetails);
	}

	if($result){
		echo 'success' ;
	}
	else{
		echo 'error' ;
	}
?>
