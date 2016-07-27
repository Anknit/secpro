<?php
/*
* Author: Aditya
* date: 08-Aug-2014
* CSS Document 
*
*/
?>
<?php
if(isset($raciParam['requestAction'])) {
	$channelList		=	$raciParam['ChannelList'];//Get the channel list in this variable
	if(!empty($channelList)) {
		$accMgrs_AssociatedChannels	=	getInfoFrom('retreive_data', 'accMgrs_AssociatedChannels', $channelList);
		if($accMgrs_AssociatedChannels != false && count($accMgrs_AssociatedChannels) > 0){
			foreach($accMgrs_AssociatedChannels as $emailID=>$channelDataArr){
/*				$channelsNameArray	=	$channelDataArr['channelName'];
				$urlsArray	=	$channelDataArr['channelUrl'];
*/				$getSubjectArguments	=	array('case'=> 'channelUpdateActionRequired');
				$mailSubject	=	getMailSubject($getSubjectArguments);
				$getMailBodyArguments	=	array(
					'case'=> 'channelUpdateActionRequired',
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
		else{
			$Output	=	'&STATUS=FAILURE&MESSAGE=NO_USERS_FOUND_ASSOCIATED_WITH_CHANNELS';
		}
	}
	
}
?>