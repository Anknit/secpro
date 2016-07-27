<?php
if( isset($raciParam['requestAction'])) {
	$eventList	=	$raciParam['EventList'];
	if(!empty($eventList)) {
		/*
			1) Get the list of channel IDS for all the events.
			2) For all the channels get the name of channels and the accountIDS associated with these channels.
			3) Send reminder email to all the account managers
		*/
		$channelList	=	getInfoFrom('retreive_data', 'channelsForEventIDs', $eventList);
		if(empty($channelList) || !$channelList){
			SetErrorCodes(getErrorMessage(42), __LINE__,  __FILE__);
			$Output	=	'&STATUS=FAILURE&MESSAGE=NO_CHANNELS_FOUND';
		}
		else {
			$accMgrs_AssociatedChannels	=	getInfoFrom('retreive_data', 'accMgrs_AssociatedChannels', $channelList);
			if($accMgrs_AssociatedChannels != false && count($accMgrs_AssociatedChannels) > 0){
				foreach($accMgrs_AssociatedChannels as $emailID=>$channelDataArr){
	/*				$channelsNameArray	=	$channelDataArr['channelName'];
					$urlsArray	=	$channelDataArr['channelUrl'];
	*/				$getSubjectArguments	=	array('case'=> 'reminderForScheduledEvent');
					$mailSubject	=	getMailSubject($getSubjectArguments);
					$getMailBodyArguments	=	array(
						'case'=> 'reminderForScheduledEvent',
						'args'=> array($channelDataArr)
					);
					$mailBodyHtml	=	getMailBody($getMailBodyArguments);
					$Output	=	send_Email($emailID, $mailSubject, $mailBodyHtml);
					if(!is_bool($Output) && $Output != ''){
						SetErrorCodes($Output, __LINE__,  __FILE__);
					}else if(!$Output){
						ErrorLogging('Mail_sent_failed near line number '.__LINE__.' in '.__FILE__);
					}
					if($Output){
						$Output	=	'&STATUS=SUCCESS&MESSAGE=Mail_sent_successfully';
					}else{
						$Output	=	'&STATUS=FAILURE&MESSAGE=Mail_sent_failed';
					}
				}
			}
		}	
	}
	
}
?>