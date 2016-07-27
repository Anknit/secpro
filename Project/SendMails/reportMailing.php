<?php
if( isset($raciParam['requestAction'])) {
	/*
		Using the list of userid's(currently interpreted in FileList), find the unique accountID's, and corresponding to them find the channels.
	*/
	function getListOfUniqueAccountIDSForUsers($usersList){
		global $listUserID;
		$accountIDArray	=	array();
		$listUserID	=	createCommaSeparatedListForMysqlIN($usersList);
		$UniqueAccountID	=	DB_Query('Select DISTINCT accountId from userinfo WHERE userId IN('.$listUserID.')', 'ASSOC', '');
		if($UniqueAccountID != false && $UniqueAccountID != 0){
			for($i = 0; $i < count($UniqueAccountID); $i++) {
				$DataRow	=	$UniqueAccountID[$i];
				$accountID	=	$DataRow['accountId'];
				$accountIDArray[]	=	$accountID;
			}
		}
		return $accountIDArray;
	}
	
	/*	
		This function brings out the user and his/her account manager's data.
		The input used here are the account managers to which the users can belong and the userids whose account managers data is to be returned
	*/
	function getUsersAndAccountManagerData(){
		global $userIdmappedToUserAndAccountMgrData;
		global $accountIdsForInQuery;
		global $listUserID;
		$query	=	"Select userId, accountId, name, mailId, userType from userinfo where accountId IN(".$accountIdsForInQuery.") AND userType = ".ADMIN." OR userId IN(".$listUserID.") order by accountId";
		$userAndAccountMgrData	=	DB_Query($query);
		$userIdmappedToUserAndAccountMgrData	=	array();
		$listOfAccountManagersData	=	array();
		$listOfOperatorUsersData	=	array();
		if($userAndAccountMgrData != false && count($userAndAccountMgrData) > 0){
			for($i = 0; $i < count($userAndAccountMgrData); $i++) {
				$rowData	=	$userAndAccountMgrData[$i];
				if($rowData['userType']	==	ADMIN)
					$listOfAccountManagersData[$rowData['accountId']]	=	$rowData;
				else
					$listOfOperatorUsersData[$rowData['userId']]	=	array($rowData);
			}
			foreach($listOfOperatorUsersData as $userID => $operatorsDataRowArray)	{
				$operatorsData	=	$operatorsDataRowArray[0];
				$accountId	=	$operatorsData['accountId'];
				$accMgrData	=	$listOfAccountManagersData[$accountId];
				$operatorsDataRowArray[]	=	$accMgrData;
				$listOfOperatorUsersData[$userID]	=	$operatorsDataRowArray;	
			}
		}
		
		$userIdmappedToUserAndAccountMgrData	=	$listOfOperatorUsersData;
		
		
		return $userIdmappedToUserAndAccountMgrData;
	}
	
	function getUserMailingDetails($userIdmappedToUserAndAccountMgrData){
		global $Output;
		global $channelListObj;
		global $profileListObj;
		foreach($userIdmappedToUserAndAccountMgrData as $userID => $operatorAndAccMgrData){	//arg was the userid = report filename
			$operatorData	=	$operatorAndAccMgrData[0];
			$accMgrData	=	$operatorAndAccMgrData[1];
			$reportRecipients	=	$operatorData['mailId'].', '.$accMgrData['mailId'];
			$reportUserName	=	$operatorData['mailId'];
			$mailSubject	=	generateReportSubject($reportUserName);

			$reportFileName	=	$userID;
			$mailBodyHtml		=	generateReportMailBody($reportFileName, $reportUserName, $channelListObj, $profileListObj);
			$sendMailOutput = send_Email($reportRecipients, $mailSubject, $mailBodyHtml);
			if(!is_bool($sendMailOutput) && $sendMailOutput != ''){
				SetErrorCodes($sendMailOutput, __LINE__,  __FILE__);
			}else if(!$sendMailOutput){
				ErrorLogging('Mail_sent_failed near line number '.__LINE__.' in '.__FILE__);
			}
		}
		$Output	=	'&STATUS=SUCCESS&MESSAGE=Mail_sent_successfully';
	}
	$FileList	=	$raciParam['FileList'];
	$listUserID	=	'';
	$accountIds	=	getListOfUniqueAccountIDSForUsers($FileList);
	if(count($accountIds) > 0){
		$accountIdsForInQuery	=	createCommaSeparatedListForMysqlIN($accountIds);
		$clause	=	'accountId IN('.$accountIdsForInQuery.')';
	}
	$getChannelIdsInputArray	=	array(
		'Table' => 'channelinfo',
		'Fields'=> 'channelId, channelName',
		'clause'=> $clause
	);
	$channelIDArray	=	array();
	$channelIDsResult	=	DB_Read($getChannelIdsInputArray,'ASSOC','');
	foreach($channelIDsResult as $key => $value){
		$channelListObj[$value['channelId']]	=	$value['channelName'];
		$channelIDArray[]	=	$value['channelId'];
	}
	
	$clause	=	'';
	if(count($channelIDArray) > 0){
		$channelIdsForInQuery	=	createCommaSeparatedListForMysqlIN($channelIDArray);
		$clause	=	'channelId IN('.$channelIdsForInQuery.')';
	}
	$getProfileIdsInputArray	=	array(
		'Table' => 'profileinfo',
		'Fields'=> 'profileId, profileInformation',
		'clause'=> $clause
	);

	$tempResult	=	'';
	$tempResult	=	DB_Read($getProfileIdsInputArray,'ASSOC','');
	foreach($tempResult as $key => $value){
		$profileListObj[$value['profileId']]	=	$value['profileInformation'];
	}

	$tempResult	=	'';
	$userIdmappedToUserAndAccountMgrData	=	getUsersAndAccountManagerData();
	getUserMailingDetails($userIdmappedToUserAndAccountMgrData);
}
?>