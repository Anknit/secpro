<?php
/*
 * Author: Nitin Aloria
 * Date: 22-July-2015
 * Description: This file is used for sending mail to account manager when the current credit minutes remains insufficient for scheduled or ongoing monitoring events.
 */
?>
<?php

if (isset ( $raciParam ['requestAction'] )) {
	
	$eventId	=	$raciParam ['EventId'];
	$eventDuration	=	$raciParam ['RemainingDuration'];
	
	$dbQuery	=	'Select channelinfo.channelName, accountinfo.creditMinutes, userinfo.mailId from eventinfo JOIN channelinfo On channelinfo.channelId = eventinfo.channelId JOIN accountinfo ON accountinfo.accountId = channelinfo.accountId JOIN userinfo ON userinfo.accountId = accountinfo.accountId where eventinfo.eventId = '.$eventId.' and userinfo.userType= '.ADMIN;
	 
	$dbResult = DB_Query($dbQuery, "ASSOC","");
	if($dbResult == 0){
		$Output	=	'&STATUS=FAILURE&MESSAGE=Event_not_found';
		return $Output;
	}
	
	$channelName	=	$dbResult[0]['channelName'];
	$creditAmount	=	$dbResult[0]['creditMinutes'];
	$emailID		=	$dbResult[0]['mailId'];
	
	$getSubjectArguments = array (
			'case' => 'creditMinuteWarning'
	);
	$mailSubject = getMailSubject ( $getSubjectArguments );
	
	$getMailBodyArguments = array (
			'case' => 'creditMinuteWarning',
			'args' => array(
						'eventDuration'	=>	$eventDuration,
						'channelName' 	=>	$channelName,
						'creditAmount' 	=>	$creditAmount,
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