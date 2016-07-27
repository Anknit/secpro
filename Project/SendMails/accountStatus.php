<?php
/*
 * Author: Nitin Aloria
 * Date: 21-July-2015
 * Description: This file is used for sending mail to account manager when their account is deactivated.
 */
?>
<?php

if (isset ( $raciParam ['requestAction'] )) {
	
	$eventId	=	$raciParam ['EventId'][0];
	$dbQuery	=	'Select channelinfo.channelName, userinfo.mailId from eventinfo JOIN channelinfo ON channelinfo.channelId = eventinfo.channelId JOIN userinfo ON userinfo.accountId = channelinfo.accountId where eventinfo.eventId = '.$eventId.' and userinfo.userType= '.ADMIN;
		
	$dbResult = DB_Query($dbQuery, "ASSOC","");
	if($dbResult == 0){
		$Output	=	'&STATUS=FAILURE&MESSAGE=Event_not_found';
		return $Output;
	}
	
	$channelName	=	$dbResult[0]['channelName'];
	$emailID		=	$dbResult[0]['mailId'];	
	
	$getSubjectArguments = array (
			'case' => 'accountStatusDeactivated'
	);
	$mailSubject = getMailSubject ( $getSubjectArguments );
	
	$getMailBodyArguments = array (
			'case' => 'accountStatusDeactivated',
			'args' => array(
						'channelName' 	=>	$channelName
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