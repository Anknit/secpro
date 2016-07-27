<?php
/*
* Author: Ankit
* date: 05-Feb-2015
* Description: This class retrieves all associated with agents, Bouquets, Channels, Events, Users
*
*/

class retreive_data{
	
/*
* @access public
* @param  $userId. It is optional in the sense that the default value will be considered as session id
* @return Associative array of values or errors according to dbmanager module
*/
	public function profile($userId	=	''){
		if($userId	==	'')
			$userId	=	$_SESSION['userID'];
			
		$UserProfileInfo	= 	DB_Read(
			array(	'Table'=> 'userinfo',
					'Fields'=> '*',
					'clause' => 'UserID = "'.$userId.'"'
				 ),
				 'ASSOC',
				 ''
		);
		if($UserProfileInfo)
			return $UserProfileInfo[0];
	}

	public function getChannelNodeID($channelId	=	''){
		if($channelId	==	'')
			return false;

		$NodeID	= 	DB_Read(
			array(	'Table'=> 'channelinfo',
					'Fields'=> 'nodeId',
					'clause' => 'channelId = "'.$channelId.'" AND channelStatus != '.REMOVED
				 ),
				 'ASSOC',
				 ''
		);
		if($NodeID)
			return $NodeID[0]['nodeId'];
		else
			return false;
	}	

	public function getAgentNodeID($agentId	=	''){
		if($agentId	==	'')
			return false;

		$NodeID	= 	DB_Read(
			array(	'Table'=> 'agentinfo',
					'Fields'=> 'nodeId',
					'clause' => 'agentId = "'.$agentId.'"'
				 ),
				 'ASSOC',
				 ''
		);
		if($NodeID)
			return $NodeID[0]['nodeId'];
		else
			return false;
	}	
	
	public function commaSeparatedNodeAgentID($nodeId	=	''){
		if($nodeId	==	'')
			return false;
						
		$agentsIdInfo	= 	DB_Read(
			array(	'Table'=> 'agentinfo',
					'Fields'=> 'agentID',
					'clause' => 'nodeID IN ("'.$nodeId.'")'
				 ),
				 'NUM_ARR',
				 ''
		);
		$agentsIdString	=	'';
		if($agentsIdInfo) {
			for($i = 0; $i< count($agentsIdInfo); $i++){
				if($agentsIdString != '')
					$agentsIdString	.=	', ';

				$agentsIdString	.=		'"'.$agentsIdInfo[$i][0].'"';
			}
		}	
		return $agentsIdString;
	}
	
/*
* @access public
* @param  $userId. It is optional in the sense that the default value will be considered as session id
* This argument can be a list(array) of users	
* @return all the users whose regAuthorityid (added by) is userId(provided in argument). In case of array argument also, all the users registered by the provided userid's will be returned.
*/
	public function usersRegisteredBy($userIdList	=	''){
		if($userIdList	==	'' || count($userIdList) <= 0 || $userIdList	==	NULL){
			return false;
		}
		
		//Dont show operators to anyone other than customers.
		$excludeUserType	=	0;
		if($_SESSION['userTYPE']	!=	ADMIN)
			$excludeUserType	=	OPERATOR;
		
		if($_SESSION['userTYPE']	==	SUPERUSER || $_SESSION['userTYPE']	==	SALES )
			$clause	=	'userType = '.ADMIN;
		else{
			$clause	=	'regAuthorityID IN (\''.implode('\',\'', $userIdList).'\') AND UserType != '.$excludeUserType;
		}
		$registeredUsers	= 	DB_Read(
			array(	'Table'=> 'userinfo',					
					'Fields'=> 'userID',						
					'clause'=> $clause
				 ),
				 'ASSOC',
				 ''
		);
		return $registeredUsers;
	}
	
/*
* @access public
* @param  $userId. It is optional in the sense that the default value will be considered as session id
* @return all the users who are registered by the users(referred in argument) or the users down the lane upto the level of customers.
* Only if the userType is superuser, then the information of operators would also be returned
*/
	public function users_under_all_Levels_to_customers($userId	=	'', $userType){
		if($userId	==	'')
			$userId	=	$_SESSION['userID'];
		
		$maxLoopCount	=	1;
		if($userType	==	SUPERUSER)
			$maxLoopCount	=	4;
		elseif($userType	==	VENERA_SALES)
			$maxLoopCount	=	2;
		elseif($userType	==	RESELLER || $userType	==	CUSTOMER)
			$maxLoopCount	=	1;
		
		$usersIDINFO	=	array();
		$retrieve_Users_registered_by	=	array();
		$retrieve_Users_registered_by[]	=	$userId;
		
		for($i = 0; $i< $maxLoopCount; $i++){
			$resultOFUSERSLIST	=	$this -> usersRegisteredBy($retrieve_Users_registered_by);
			$retrieve_Users_registered_by	=	array();	//empty the values
			for($j = 0; $j < count($resultOFUSERSLIST); $j++){
				$retrieve_Users_registered_by[]	=	$resultOFUSERSLIST[$j]['userID'];
			}
			$usersIDINFO		=	array_indexed_merge_at_end($usersIDINFO, $resultOFUSERSLIST);
		}
		
		return $usersIDINFO;
	}
	
/*
* @access public
* @param  $userId. It is optional in the sense that the default value will be considered as session id
  Behavior:	 For the userID user type is determined and as per the permission sets the profile of users registered under them are retrieved
  Hence if the userid is that of VENERA SALES person, the USER's list would comprise of all the users
* @return 
*/
	public function registeredUsersProfile($arrayParams	=	''){
		if(isset($arrayParams['userId']))
			$userId	=	$arrayParams['userId'];
			
		$ExcessClauseForSortAndLimit	=	'';
		if(isset($arrayParams['clause']))
			$ExcessClauseForSortAndLimit	=	$arrayParams['clause'];

		$userType	=	'';
		if($userId	==	''){
			$userId		=	$_SESSION['userID'];
			$userType	=	$_SESSION['userType'];
		}
		
		if($userType	==	''){
			$userProfile	=	$this ->	profile($userId);
			$userType		=	$userProfile['userType'];
		}
		$clause	=	'regAuthorityID = '.$userId;

		$clause	.=	$ExcessClauseForSortAndLimit;
		$regUsersProfileInfo	= 	DB_Read(
			array(	'Table'=> 'userinfo',					
					'Fields'=> '*',						
					'clause'=> $clause
				 ),
				 'ASSOC',
				 ''
		);
		return $regUsersProfileInfo;
	}
	
	public function accountUsersProfile($accountID	=	'', $arrayParam	=	''){
		if($accountID	==	''){
			$accountID	=	$_SESSION['accountID'];
		}
		$clause	=	'AccountID = '.$accountID;

		if(isset($arrayParam['clause'])){
			$clause	.=	$arrayParam['clause'];
		}
		
		$accountUsersProfile	= 	DB_Read(
			array(	'Table'=> 'userinfo',					
					'Fields'=> '*',						
					'clause'=> $clause
				 ),
				 'ASSOC',
				 ''
		);
		return $accountUsersProfile;
	}
	
	public function registeredUsersAccountInfo($userIdList){
		if($userIdList	==	'' || count($userIdList) <= 0 || $userIdList	==	NULL){
			return false;
		}

		$clause	=	'accountId IN (\''.implode('\',\'', $userIdList).'\')';
		$registeredUsersAccountInfo	= 	DB_Read(
			array(	'Table'=> 'accountinfo',					
					'Fields'=> '*',						
					'clause'=> $clause
				 ),
				 'ASSOC',
				 ''
		);
		return $registeredUsersAccountInfo;
	}
	
	public function systemSettings($uid = ''){	//argument has not been used inside of function. But is just a  filler
		global $UIMENU_List;
		if(isset($UIMENU_List['System']) && !$UIMENU_List['System']){
			return false;	//Unauthorized user
		}
		
		$systemSettings	= 	DB_Read(
			array(	'Table'=> 'systemsettings',					
					'Fields'=> '*'
				 ),
				 'ASSOC',
				 ''
		);
		$systemSettings	=	$systemSettings[0];
		return $systemSettings;
	}
			
	public function completeAgentDetails($agentClause = ''){
		$queryStr		=	'Select * from agentinfo LEFT JOIN nodeinfo On agentinfo.nodeId = nodeinfo.nodeId ';
		if($agentClause['clause'] != ''){
			$clause	=	$agentClause['clause'];
			$queryStr		.= 'Where '.$clause;
		}
		if($agentClause['orderclause'] != ''){
			$order	=	$agentClause['orderclause'];
			$queryStr		.= ' Order By '.$order;
		}
		$AgentList	=	DB_Query( $queryStr,'ASSOC','');
		return $AgentList;
	}
	
	public function completeNodeDetails($nodeClause = ''){
		if($nodeClause['clause'] != ''){
			$clause	=	$nodeClause['clause'];
		}
		if($nodeClause['orderclause'] != ''){
			$order	=	$nodeClause['orderclause'];
		}
		
		$NodeList	=	DB_Read(
			array(	'Table'=> 'nodeinfo',					
					'Fields'=> '*',
					'clause'=>$clause,
					'order'=>$order						
				),
			'ASSOC',''
		);
		if($NodeList){
			for($i=0; $i<count($NodeList); $i++){
				$nodeAgents	=	DB_Read(
					array(	'Table'=> 'agentinfo',
							'Fields'=> '*',
							'clause'=> 'nodeId = "'.$NodeList[$i]['nodeId'].'"'
					),
					'ASSOC',''
				);
				$NodeList[$i]['agents']	=	$nodeAgents;
				$nodeAgents	=	'';
			}
			$NodeList[0]['otherAgents']	=	DB_Read(
					array(	'Table'=> 'agentinfo',
							'Fields'=> '*',
							'clause'=> 'nodeId = 0'
					),
					'ASSOC',''
				);
			return $NodeList;
		}
	}

	public function completeChannelDetails($channelClause = ''){
		if($channelClause['clause'] != ''){
			$clause	=	$channelClause['clause'];
		}
		if($channelClause['orderclause'] != ''){
			$order	=	$channelClause['orderclause'];
		}
		
		$ChannelList	=	DB_Read(
			array(	'Table'=> 'channelinfo',					
					'Fields'=> '*',
					'clause'=>$clause,
					'order'=>$order						
				),
			'ASSOC',''
		);
		if($ChannelList){
		for($i=0; $i<count($ChannelList); $i++){
			$channelProfiles	=	DB_Read(
				array(	'Table'=> 'profileinfo',
						'Fields'=> '*',
						'clause'=> 'channelId = "'.$ChannelList[$i]['channelId'].'" AND updateState != "4"'
				),
				'ASSOC',''
			);
			$ChannelList[$i]['profiles']	=	$channelProfiles;
			$channelBouquetList	=	DB_Read(
				array(	'Table'=> 'channelbouquetmapping',
						'Fields'=> 'bouquetId',
						'clause'=> 'channelId = "'.$ChannelList[$i]['channelId'].'"'
				),
				'RESULT',''
			);
			$ChannelList[$i]['bouquetIdList']	=	'';
			if($channelBouquetList) {
				while($row = $channelBouquetList->fetch_array(MYSQLI_NUM)){
					if($ChannelList[$i]['bouquetIdList'] != '')
						$ChannelList[$i]['bouquetIdList']	.=	' ';
					$ChannelList[$i]['bouquetIdList']	.=	$row[0];
				}
			}
			if($ChannelList[$i]['bouquetIdList']	==	'')
				$ChannelList[$i]['bouquetIdList']	=	'0';
				
			$channelBouquetList	=	'';
			$channelProfiles	=	'';
		}
		return $ChannelList;
					}
	}
	public function completeBouquetDetails($bouquetClause = ''){
		if($bouquetClause['clause'] != ''){
			$clause	=	$bouquetClause['clause'];
		}
		if($bouquetClause['orderclause'] != ''){
			$order	=	$bouquetClause['orderclause'];
		}
		
		$BouquetList	=	DB_Read(
			array(	'Table'=> 'bouquetinfo',					
					'Fields'=> '*',
					'clause'=>$clause,
					'order'=>$order
			),
			'ASSOC',''
		);
		if($BouquetList){
		for($i=0; $i<count($BouquetList); $i++){
			$bouquetChannels	=	DB_Read(
				array(	'Table'=> 'channelbouquetmapping',
						'Fields'=> '*',
						'clause'=> 'bouquetId = "'.$BouquetList[$i]['bouquetId'].'"'
				),
				'ASSOC',''
			);
			$BouquetList[$i]['channels']	=	array();
			for($j=0;$j<count($bouquetChannels);$j++){
				$BouquetList[$i]['channels'][]	=	$bouquetChannels[$j]['channelId'];
			}
			$bouquetChannels	=	'';
		}
		return $BouquetList;
		}
	}
	
	public function channelOfNode($nodeId){
		if($nodeId == '' || $nodeId == null){
			return false;
		}
		$ChannelIdList	=	DB_Read(
			array(	'Table'=> 'channelinfo',					
					'Fields'=> 'channelId',
					'clause'=> 'nodeId='.$nodeId.' and channelStatus != '.REMOVED,						
				),
			'NUM_ARR',''
		);
		return $ChannelIdList[0];
	}
	
	public function completeUserDetails($userClause){
		if($userClause['clause'] != ''){
			$clause	=	$userClause['clause'];
		}
		if($userClause['orderclause'] != ''){
			$order	=	$userClause['orderclause'];
		}
		$UserList	=	DB_Read(
			array(	'Table'=> 'userinfo',					
					'Fields'=> '*',
					'clause'=> $clause,
					'order'=> $order						
				),
			'ASSOC',''
		);
		if($_SESSION['userTYPE'] == SALES || $_SESSION['userTYPE'] == SUPERUSER){
			$accIDList	=	array();
			for($u=0;$u<count($UserList);$u++){
				array_push($accIDList,$UserList[$u]['accountId']);
			}
			$accountInfo	=	$this ->registeredUsersAccountInfo($accIDList);
			for($a=0;$a<count($accountInfo);$a++){
				$UserList[$a]	=	array_merge($UserList[$a],$accountInfo[$a]);
			}
		}
		return $UserList;
	}
	
	/*
		Input: List of eventIDS. The list could be an array like array(1,2,3,67,5434) Or a comma separated string like '1,2,45,654,32' etc..
		Output:
			false(boolean): If there are no channelIds for the given event ids in database
			ChannelIds(string) : If channelIds for given eventIds are found in database, then a comma separated string od channel ids is returned, e.g. '5,4,6' etc..
			
			*Please note that only the distinct channaleIDS for the given IDS will be reported, i.e. 2 or more eventids with same channel id will include that channelid only once.
			
		Description: The method finds in the eventInfo table the channelIds for the given eventIds.
	*/
	public function channelsForEventIDs($eventIDs){
		$output	=	false;
		$eventIdsForInQuery	=	createCommaSeparatedListForMysqlIN($eventIDs);
		$query	=	'SELECT GROUP_CONCAT(DISTINCT channelId) AS channelIdList from eventinfo WHERE eventId IN('.$eventIdsForInQuery.')';
		$channelIDs	=	DB_Query($query, 'ASSOC');
		if($channelIDs && $channelIDs != 0 && !empty($channelIDs)){
			$output=	$channelIDs[0]['channelIdList'];
		}
		return $output;
	}
	
	/*
		Input: List of channelIds. The list could be an array like array(1,2,3,67,5434) Or a comma separated string like '1,2,45,654,32' etc..
		Output:
			false(boolean): If there is no (channel data and account manager){the combination should exist} for the given channel ids in channelinfo table and userinfo table
			ChannelDataAndAccountMGREmailIDMap(array) : The array is of the format stated below:
			array(
				'accMgr1userName1'	=>	array('channelname1', 'channelUrl1'),
				'accMgr1userName2'	=>	array('channelname2', 'channelUrl2'),
				'accMgr1userName3'	=>	array('channelname3', 'channelUrl3'),
			);
			
		Description: Find the channel name and account managers for the input channel ids.
	*/
	public function accMgrs_AssociatedChannels($channelIds){
		$output	=	false;
		$channelIdsForInQuery	=	createCommaSeparatedListForMysqlIN($channelIds);
		$query	=	'SELECT channelId, channelName, channelUrl, channelinfo.accountId, userName, userType from channelinfo LEFT JOIN userinfo ON channelinfo.accountId = userinfo.accountId WHERE channelId IN('.$channelIdsForInQuery.') AND userType = '.ADMIN;
		//Query all the channels along with the account managers name (those who added these channels).
		$channelData			=	DB_Query($query, 'ASSOC', '');
		if($channelData != false && $channelData != 0 && is_array($channelData)){
			$accountMgrChannelDataArray	=	array();
			$accountIdArray		=	array();
			for($i = 0; $i < count($channelData); $i++) {
				$DataRow	=	$channelData[$i];
				$accountMgr	=	$DataRow['userName'];
				$accountID	=	$DataRow['accountId'];
				if(!in_array($accountID, $accountIdArray)){
					$accountIdArray[]	=	$accountID;
					$accountMgrChannelDataArray[$accountMgr]	=	array('channelName'=>array(), 'channelUrl'=>array());
				}
				array_push($accountMgrChannelDataArray[$accountMgr]['channelName'], $DataRow['channelName']);
				array_push($accountMgrChannelDataArray[$accountMgr]['channelUrl'],	$DataRow['channelUrl']);
			}
			$output	=	$accountMgrChannelDataArray;
		}
		return $output;
	}
};
	
function checkUserTypeCustomer($argArrayUserInfo){
	if($argArrayUserInfo['UserType']	==	ADMIN){
		return true;
	}
	else
		return false;
}
	
function checkUserTypeReseller($argArrayUserInfo){
	if($argArrayUserInfo['UserType']	==	Reseller){
		return true;
	}
	else
		return false;
}
?>
