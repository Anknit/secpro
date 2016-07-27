<?php
/*
 * 	Author: Nitin Aloria
 * 	Date: 10-July-2015
 *	Description: This file is used for sending mail when agent license registration fails
 */
?>
<?php

if (isset ( $raciParam ['requestAction'] )) {
	
	$nodeId = $raciParam ['AgentInformation'][0];
	$accountId = $raciParam ['AgentInformation'][1];
	$agentName = $raciParam ['AgentInformation'][2];
	
	function getNodeName($nodeid) { // To get nodename using node ID
	
		$nodename = DB_Read ( array (
				'Table' => 'nodeinfo',
				'Fields' => 'nodeName',
				'clause' => 'nodeId = "' . $nodeid . '" '
		), 'ASSOC', '' );
	
		return $nodename [0] ['nodeName'];
	}
	
	function getEmailID($accountid) { // To get email ID using account ID
	
		$emailid = DB_Read ( array (
				'Table' => 'userinfo',
				'Fields' => 'mailId',
				'clause' => 'accountId = "' . $accountid . '" AND userType = "'.ADMIN.'"'
		), 'ASSOC', '' );
	
		return $emailid [0] ['mailId'];
	}
	
	$nodeName = getNodeName ( $nodeId ); 
	$emailID = getEmailID ( $accountId );
	
	$getSubjectArguments = array (
			'case' => 'mailForAgentLicenseFailure',
			'args' => $agentName
	);
	
	$mailSubject = getMailSubject ( $getSubjectArguments );
	
	$getMailBodyArguments = array (
			'case' => 'mailForAgentLicenseFailure',
			'args' => array(
					'agentName'=> $agentName,
					'nodeName' => $nodeName
			)
	);
	
	$mailBodyHtml = getMailBody ( $getMailBodyArguments );
	
	$Output = send_Email ( $emailID, $mailSubject, $mailBodyHtml);
	if(!is_bool($Output) && $Output != ''){
		SetErrorCodes($Output, __LINE__,  __FILE__);
	}else if(!$Output){
		ErrorLogging('Mail_sent_failed near line number '.__LINE__.' in '.__FILE__);
	}
	if ($Output) {
			$Output = '&STATUS=SUCCESS&MESSAGE=Mail_sent_successfully';
		} else {
			$Output = '&STATUS=FAILURE&MESSAGE=Mail_sent_failed';
		}
}
?>