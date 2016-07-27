<?php
/*
 * Author: Nitin Aloria
 * Date: 08-October-2015
 * Description: This file is used for sending mail to account manager when error threshold is reached after a certain amount of time.
 */
?>
<?php

if (isset ( $raciParam ['requestAction'] )) {
	
	$channelId	=	$raciParam ['ChannelId'];
	$dbQuery	=	'SELECT channelinfo.channelName, userinfo.mailId, emailalertsettings.recipentEmailIds FROM channelinfo JOIN userinfo ON channelinfo.accountId = userinfo.accountId JOIN emailalertsettings ON  channelinfo.accountId = emailalertsettings.accountId WHERE channelinfo.channelId = '.$channelId.' AND userinfo.userType='.ADMIN;
		
	$dbResult = DB_Query($dbQuery, "ASSOC","");
	if($dbResult == 0){
		$Output	=	'&STATUS=FAILURE&MESSAGE=Channel_not_found';
		return $Output;
	}
	
	$channelName	=	$dbResult[0]['channelName'];
	$mailId			=	$dbResult[0]['mailId'];	
	$recipentEmailIds		=	$dbResult[0]['recipentEmailIds'];
	
	$getSubjectArguments = array (
			'case' => 'channelAlertMail'
	);
	$mailSubject = getMailSubject ( $getSubjectArguments );
	
	$getMailBodyArguments = array (
			'case' => 'channelAlertMail',
			'args' => array(
						'channelName' 	=>	$channelName
						)
	);
	$mailBodyHtml = getMailBody ( $getMailBodyArguments );
	if($recipentEmailIds != ""){
		$mailId = $mailId.','.$recipentEmailIds;
	}
	
	$Output = send_Email ( $mailId, $mailSubject, $mailBodyHtml);
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