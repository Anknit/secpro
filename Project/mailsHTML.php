<?php
/*
* Author: Aditya
* date: 08-Aug-2014
* CSS Document 
*
*/
?>
<?php
function emailHeader(){
	return '<html>
				<head>
					<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
						<style type="text/css"> 
							.internalTextNormal{
								font-family: Arial, Helvetica, sans-serif;
								font-size: 11px;
								color: #000000;
								font-weight: normal;	 
							}
							table.reportTable{
								margin:25px 0px;
							} 
							table.reportTable td{
								border:1px solid black;
								padding:5px;
				    			vertical-align: top;
								word-break: break-all;
							}
							.reportTableSourceName, .reportTableError{
								width:150px;
							}
							 .reportTableProfileBitrate{
								width:102px;
							}
							.reportTableStartTime{
								width:140px;
							}
							.reportTableDuration{
								width:50px;
							}
							.reportTableErrorMsg{
								width:500px;
							}
						</style>
					<title>Nova</title>
				</head>
				<body>';
}

function emailFooter(){
	return '</body></html>';
}
	
function generateReportSubject($mailId){
	$mailSubStr	=	'Nova Monitoring Report - '.$mailId.' - '.date("Y-m-d h:i:sa");
	return $mailSubStr;
}

function getReportMailString($reportUserName){
	$mailStr	=	'Dear User, <br />';
	$mailStr	.= 	'Monitoring report for sources assigned to user <b>'.$reportUserName.'</b>. <br />';
	return $mailStr;
	
}

function generateReportMailBody($reportFileName, $reportUserName, $channelListObj, $profileListObj){
	$file			= $_SESSION['SERVER_ROOT']."/Repdir/auto/".$reportFileName.".txt";  
	$iterator	=	0;
	if($fileHandler	= fopen($file , "rb")){
		$fileContent	= file_get_contents($file);
		$channelErrArray = explode("\n", $fileContent);
		$reportBodystr	=	'<table cellpadding="2" class="reportTable"><caption style="text-align:center; font-size:16px; margin-bottom:5px">Monitoring Report</caption><tr><td class="reportTableSourceName">Source Name</td><td class="reportTableProfileBitrate">Profile Bitrate (Kbps)</td><td class="reportTableError">Error</td><td class="reportTableStartTime">Start Time (UTC)</td><td class="reportTableDuration">Duration</td><td class="reportTableErrorMsg">Error message</td></tr>';
		if(count($channelErrArray) == 0){
			$reportBodystr	.=	'<tr><td colspan="6" align="center">There is no error during this period</td></tr>';
		}
		else{
			while(count($channelErrArray)){
				foreach($channelErrArray AS $whatEver){  
					$currentChannel 		= 	array_shift($channelErrArray);
					$currentChannel			=	explode("?@", $currentChannel);
					$currentChannelId		=	array_shift($currentChannel);
					$currentChannelProfiles	=	$currentChannel;
					foreach($currentChannelProfiles as $somewhat){
						$currentprofile	=	array_shift($currentChannelProfiles);
						$currentprofile	=	explode("||", $currentprofile);
						$currentProfileId	=	array_shift($currentprofile);
						$currentProfileError	=	$currentprofile;
						for($i=0; $i<count($currentProfileError); $i++){
							$reportBodystr	.=	'<tr>';
							$errorProp		=	explode('|',$currentProfileError[$i]);
							$reportBodystr	.=	'<td>'.$channelListObj[trim($currentChannelId)].'</td>';
							$reportBodystr	.=	'<td>'.(floor(floatval($profileListObj[trim($currentProfileId)])/1000)).'</td>';
							$reportBodystr	.=	'<td>'.array_shift($errorProp).'</td>';
							$reportBodystr	.=	'<td>'.array_shift($errorProp).'</td>';
							$reportBodystr	.=	'<td>'.array_shift($errorProp).'</td>';
							$reportBodystr	.=	'<td>'.array_shift($errorProp).'</td>';
							$reportBodystr	.=	'</tr>';
							
	//                            $myArray[$iterator]	=	array( 'Channel'=>$currentChannelId, 'Profile'=>$currentProfileId, 'type' => array_shift($errorProp) ,'start'=>array_shift($errorProp),'end'=>array_shift($errorProp),'msg'=>array_shift($errorProp));
							$iterator++;
						}
						$i=0;
					}
				}
			}
		}
		$reportBodystr	.=	'</table>';
		
		
		fclose($fileHandler);	
		$EmailBody	=	'<table class="internalTextNormal" border="0" cellpadding="2" cellspacing="2" width="100%" style="background-color:#FFFFFF">
							<tr><td align="left">'.getReportMailString($reportUserName).'</td></tr>
							<tr><td align="center">'.$reportBodystr.'</td></tr>
							<tr>
								<td style="height: 20px;" align="left">
									Thanks,<br />
									NOVA Administrator
								</td>
							</tr> 			 		 
						</table>';
		$EmailBody	=	emailHeader().$EmailBody.emailFooter();	
		return $EmailBody;
	}
}

/*
	Input: $subjectArgumentStructure. Since this function will output subject for various kind of emails, and subject may or may not include variable data
			hence this data can be provided in a structure, specifically an array with some mandatory arguments
			
			$subjectArgumentStructure['case']	=>	''		This is a string and will be required to distinguish what email subject has to be generated.
			$subjectArgumentStructure['args']	=>	array()	This is an array and will be required for manipulating subjects.
			
*/
function getMailSubject($subjectArgumentStructure){
	$output	=	'';

	switch($subjectArgumentStructure['case']){
		case 'channelUpdateActionRequired':
		
			$output	=	'NOVA Administrator: Urgent action required.';
			
		break;
		
		case 'reminderForScheduledEvent':
			$output	=	'NOVA reminder service: Event scheduled.';
			
		break;
		
		case 'mailForNodeLicenseKey':
			$output	=	'Agent License For "' . $subjectArgumentStructure['args'].'"';
		
		break;

		case 'mailForAgentLicenseFailure':
			$output	=	'Agent License Registration Failed For "' . $subjectArgumentStructure['args'].'"';
		
		break;
			
		case 'accountStatusDeactivated':
			$output	=	'NOVA Critical Alert.';
		
		break;
		
		case 'zeroCreditMinute':
			$output	=	'Account Credit Limit Reached';
			
		break;

		case 'creditMinuteWarning':
			$output	=	'Insufficient Account Credit Minutes';
				
		break;
		
		case 'agentDeletionFailed':
			$output	=	'Agent Deletion Failed';
		
		break;
		
		case 'channelAlertMail':
			$output	=	'Error Threshold Reached';
		
		break;
			
		default:
		break;
	}
	
	return $output;
}

/*
	Input: $bodyArgumentStructure. Since this function will output email body for various kind of emails, which may or may not include variable data
			hence this data can be provided in a structure, specifically an array with some mandatory arguments
			
			$bodyArgumentStructure['case']	=>	''		This is a string and will be required to distinguish what email body has to be generated.
			$bodyArgumentStructure['args']	=>	array()	This is an array and will be required for manipulating body.
			
*/
function getMailBody($bodyArgumentStructure){
	$output	=	'';

	switch($bodyArgumentStructure['case']){
		case 'channelUpdateActionRequired':
			$channelsName	=	implode(', ', $bodyArgumentStructure['args'][0]['channelName']);
			$output	.=	'Dear Customer,<br /><br />';
			$output	.=	'<div style="margin-left:5%">';
			$output	.=	'This is to inform that some issue has been found in extracting information for some sources that you have scheduled for monitoring in NOVA system.<br />';
			$output	.=	'You are requested to take immediate action for the following sources:-<br /><b>'.$channelsName.'</b><br />';
			$output	.=	'Please update the sources manually from NOVA source screen.';
			$output	.=	'</div>';
			$output	.=	'<br /><br />Thanks<br />NOVA System Administrator';
			
		break;
		
		case 'reminderForScheduledEvent':
			$channelsName	=	implode(', ', $bodyArgumentStructure['args'][0]['channelName']);
			$output	.=	'Dear Customer,<br /><br />';
			$output	.=	'<div style="margin-left:5%">';
			$output	.=	'This is a reminder for an event scheduled which is about to start. Below you can find the source(s) scheduled for monitoring:- <br />';
			$output	.=	'<b>'.$channelsName.'</b><br />';
			$output	.=	'</div>';
			$output	.=	'<br /><br />Thanks<br />NOVA System Administrator';
			
		break;
		
		case 'mailForNodeLicenseKey':
			$nodename = $bodyArgumentStructure['args']['nodeName'];
			$output	.=	'Dear Customer,<br /><br />';
			$output	.=	'<div style="margin-left:5%">';
			$output	.=	'Please find attached agent license file for node <b>'.$nodename.'</b>.<br />';
			$output	.=	'<span style="text-decoration: underline;">Steps for deployment:</span><br />';
			$output	.=	'1) Copy license file to ProgramData/Nova/Agent directory in the drive where OS is installed.<br />';
			$output	.=	'2) Start the NovaAgent service.<br />';
			$output	.=	'Note: License file can be provided to running agent service if no license file is there. For modifying already present license file in a running agent, agent must be restarted.<br />';
			$output	.=	'</div>';
			$output	.=	'<br /><br />Thanks<br />NOVA System Administrator';
			
		break;
		
		case 'mailForAgentLicenseFailure':
			$agentName	=	$bodyArgumentStructure['args']['agentName'];
			$nodeName	=	$bodyArgumentStructure['args']['nodeName'];
			$output	.=	'Dear Customer,<br /><br />';
			$output	.=	'<div style="margin-left:5%">';
			$output	.=	'This is to inform you that license registration for your agent <b>'.$agentName.'</b> which you tried to assign to node <b>'.$nodeName.'</b> has failed.<br />';
			$output	.=	'Please regenerate your license file and if the problem still persists, please contact NOVA Support.';
			$output	.=	'</div>';
			$output	.=	'<br /><br />Thanks<br />NOVA System Administrator';
				
		break;
		
		case 'accountStatusDeactivated':
			$channelName	=	$bodyArgumentStructure['args']['channelName'];
			$output	.=	'Dear Customer,<br /><br />';
			$output	.=	'<div style="margin-left:5%">';
			$output	.=	'This is to inform you that your account has been deactivated and therefore event associated with channel <b>'.$channelName.'</b> has been stopped.<br />';
			$output	.=	'Please contact your registering authority to re-activate your account.';
			$output	.=	'</div>';
			$output	.=	'<br /><br />Thanks<br />NOVA System Administrator';
		
		break;
			
		case 'zeroCreditMinute':
			$channelName	=	$bodyArgumentStructure['args']['channelName'];
			$output	.=	'Dear Customer,<br /><br />';
			$output	.=	'<div style="margin-left:5%">';
			$output	.=	'This is to inform you that your account has reached its credit limit and therefore event associated with channel <b>'.$channelName.'</b> will not be monitored now.<br />';
			$output	.=	'Please recharge your account balance to continue using NOVA services.';
			$output	.=	'</div>';
			$output	.=	'<br /><br />Thanks<br />NOVA System Administrator';
		
		break;

		case 'creditMinuteWarning':
			$eventDuration	=	$bodyArgumentStructure['args']['eventDuration'];
			$channelName	=	$bodyArgumentStructure['args']['channelName'];
			$creditAmount	=	$bodyArgumentStructure['args']['creditAmount'];
			$output	.=	'Dear Customer,<br /><br />';
			$output	.=	'<div style="margin-left:5%">';
			$output	.=	'This is to inform you that your current credit: <b>'.$creditAmount.'</b> minute(s) would not be sufficient to complete the event associated with <b>'.$channelName.'</b> with remaining duration: <b>'.$eventDuration.'</b> minute(s) and therefore it will be stopped after credit expiry.<br />';
			$output	.=	'Please recharge your account balance to monitor the scheduled event completely.';
			$output	.=	'</div>';
			$output	.=	'<br /><br />Thanks<br />NOVA System Administrator';
		
		break;
		
		case 'agentDeletionFailed':
			$ServerName	=	$bodyArgumentStructure['args']['serverName'];
			$ServerId	=	$bodyArgumentStructure['args']['serverId'];
			$ServerAddress	=	$bodyArgumentStructure['args']['serverIpAddress'];
			$ServerPassword	=	$bodyArgumentStructure['args']['serverPassword'];
			$output	.=	'Dear Customer,<br /><br />';
			$output	.=	'<div style="margin-left:5%">';
			$output	.=	'This is to inform you that your request for Agent Deletion has failed. Below are its details: <br />';
			$output .= 	'<b>Server Name: </b>'.$ServerName.'<br />';
			$output .= 	'<b>Server ID: </b>'.$ServerId.'<br />';
			$output .= 	'<b>Server IPv4: </b>'.$ServerAddress.'<br />';
			$output .= 	'<b>Server Passowrd: </b>'.$ServerPassword.'<br />';
			$output	.=	'Please delete the agent manually.<br />';
			$output	.=	'</div>';
			$output	.=	'<br /><br />Thanks<br />NOVA System Administrator';
			
		break;
		
		case 'channelAlertMail':
			$channelName	=	$bodyArgumentStructure['args']['channelName'];
			$output	.=	'Dear Customer,<br /><br />';
			$output	.=	'<div style="margin-left:5%">';
			$output	.=	'This is an alert mail for channel: <b>'.$channelName.'</b> which has reached its Error Threshold Count. <br />';
			$output	.=	'</div>';
			$output	.=	'<br /><br />Thanks<br />NOVA System Administrator';
				
		break;
		
		default:
		break;
	}
	
	return $output;
}
?>