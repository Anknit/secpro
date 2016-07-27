<?php
/*
* Author: Aditya
* date: 08-Aug-2014
* CSS Document 
*
*/
?>
<?php
error_reporting(0);
require_once __DIR__.'/require.php';
require_once __DIR__.'/mailsHTML.php';

if(!isset($raciParam['requestAction']) && isset($_GET)){
	$raciParam	=	$_GET;
}

$action['ReportNotification']	=	'SendMails/reportMailing.php';
$action['ChannelError']			=	'SendMails/channelUpdateMail.php';
//$action['ScheduleErrorMail']	=	'SendMails/scheduleErrorMail.php';
$action['MonitorReminder']		=	'SendMails/reminderForEventScheduled.php';
$action['LicenseKey']			=	'SendMails/licenseKey.php';
$action['AgentLicenseFailure']	=	'SendMails/agentLicenseFailure.php';
$action['AccountStatusInactive']=	'SendMails/accountStatus.php';
$action['AccountZeroCredit']	=	'SendMails/zeroCreditMinute.php';
$action['EventInSufficientCredit']	=	'SendMails/creditMinuteWarning.php';
$action['EmailAlert']			=	'SendMails/channelAlertMail.php';

if(isset($raciParam['requestAction']))	{
	require_once	$action[$raciParam['requestAction']];	//Run the logic of corresponding file
}

?>