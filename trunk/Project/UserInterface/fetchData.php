<?php
	error_reporting(0);
    require_once __DIR__.'./../require.php';
    require_once 'gridFunctions.php';
	@extract($_GET);
	$result	=	'';
	global $myArray;
	$myArray = array();  
	switch ($data){
		case 'user':
			$userclause		= array('clause'	=>'accountId = "'.$_SESSION['accountID'].'"');
			if( $_SESSION['userTYPE'] == SUPERUSER || $_SESSION['userTYPE'] == SALES)
				$userclause	=	array('clause' => 'userType = '.ADMIN);
			$userTableData	=	getInfoFrom('retreive_data', 'completeUserDetails', $userclause);
			if(isset($act) && $act=='grid'){
				$result	=	getUserData();
				unset($act);
			}
			else{
				for($i=0;$i<count($userTableData);$i++){
					$result[$userTableData[$i]['userId']]	=		$userTableData[$i];
				}
			}
			break;
			
		case 'operator':
			$accountId	=	$_SESSION['accountID'];
			$operatorList	=	DB_Read(array(
				'Table'=>'userinfo',
				'Fields'=>'userId,userName',
				'clause'=>'accountId = "'.$accountId.'" AND userType = 2 AND userStatus = 1',		
			),'ASSOC','');
			if($operatorList != 0){
				for($i=0;$i<count($operatorList);$i++){
						$result[$operatorList[$i]['userId']]	=		$operatorList[$i]['userName'];
				}
			}
			break;
		case 'opsetting':
// 			$accountId	=	$_SESSION['accountID'];
			$userId	=	$_SESSION['userID'];
			$operatorSettingTableData	=	DB_Read(array(
				'Table'=>'operatorsettings',
				'Fields'=>'userId,monitorView',
// 				'clause'=>'accountId = "'.$accountId.'"',		
				'clause'=>'userId = "'.$userId.'"',
			),'ASSOC','');
			if($operatorSettingTableData) {
 				for($i=0;$i<count($operatorSettingTableData);$i++){
					$result[$operatorSettingTableData[$i]['userId']]	=		$operatorSettingTableData[$i]['monitorView'];
				}
// 				$result = $operatorSettingTableData['0']['monitorView'];
			}	
			break;
		case 'template':
			$accountId	=	$_SESSION['accountID'];
			$templateTableData	=	DB_Read(array(
				'Table'=>'templateinfo',
				'Fields'=>'templateId,templateName,templateDescription',
				'clause'=>'accountId = "'.$accountId.'"',		
			),'ASSOC','');
			
			if(isset($act) && $act=='grid'){
				$result	=	getTemplateData('accountId = "'.$accountId.'"');
				unset($act);
			}
			else{
				if($templateTableData) {
					for($i=0;$i<count($templateTableData);$i++){
						$result[$templateTableData[$i]['templateId']]	=		$templateTableData[$i];
					}
				}	
			}
			break;
			
		case 'agent':
			$dataClause	=	'';
			if($_SESSION['userTYPE'] == ADMIN)
				$dataClause	=	' agentinfo.accountId = '.$_SESSION['accountID'].' AND nodeinfo.accountId != 0' ;
			$AgentTableData	=	getInfoFrom('retreive_data', 'completeAgentDetails', array('clause'=>$dataClause));
			if(isset($act) && $act=='grid'){
				$result	=	getAgentData($dataClause);
				unset($act);
			}
			else{
				if($AgentTableData){
					for($i=0;$i<count($AgentTableData);$i++){
						$result[$AgentTableData[$i]['agentId']]	=		$AgentTableData[$i];
					}
				}
			}
			break;
			
		case 'node':
			$dataClause	=	'';
			if($_SESSION['userTYPE'] == ADMIN)
			$dataClause	=	' accountId = 0 || accountId = '.$_SESSION['accountID'];
			$NodeTableData	=	getInfoFrom('retreive_data', 'completeNodeDetails', array('clause'=>$dataClause));
			if(isset($act) && $act=='grid'){
				$result	=	getNodeData($clause	=	"accountId = 0 || accountId = ".$_SESSION['accountID'] );
				unset($act);
			}
			else{
				for($i=0;$i<count($NodeTableData);$i++){
					$result[$NodeTableData[$i]['nodeId']]	=		$NodeTableData[$i];
				}
			}
			break;
		case 'channel':
			if(isset($act) && $act=='grid'){
				$result	=	getChannelData($clause	=	"channelStatus != ".REMOVED." and accountId = ".$_SESSION['accountID'] );
				unset($act);
			}
			else{
				$channelDataClause['clause']	=	'channelStatus != '.REMOVED;
				$channelTableData	=	getInfoFrom('retreive_data', 'completeChannelDetails',$channelDataClause);
				if($channelTableData){
					for($i=0;$i<count($channelTableData);$i++){
						$result[$channelTableData[$i]['channelId']]	=		$channelTableData[$i];
					}
				}
			}
			break;
		case 'bouquet':
			$bouquetTableData	=	getInfoFrom('retreive_data', 'completeBouquetDetails');
			if(isset($act) && $act=='grid'){
				$result	=	getBouquetData($clause	=	"accountId = ".$_SESSION['accountID'] );
				unset($act);
			}
			else{
				if($bouquetTableData){
					for($i=0;$i<count($bouquetTableData);$i++){
						$result[$bouquetTableData[$i]['bouquetId']]	=		$bouquetTableData[$i];
					}
				}
			}
			break;
		case 'nodeAgent':
			if(isset($nodeId)){
				$clause	=	'agentinfo.nodeID = '.$nodeId;
				$result	=	getAgentData($clause);
				unset($nodeId);
			}
			break;
		case 'payment':
		case 'accountpayment':
			if(isset($act) && $act=='grid'){
				$result	=	getPaymentData($data);
				unset($act);
			}
			break;
		case 'usageinfo':
			if(isset($act) && $act=='grid'){
				$result	=	getUsageInfoData();
				unset($act);
			}
			break;
		case 'logindetails':
			if(isset($act) && $act=='grid'){
				$result	=	getLoginDetailsData();
				unset($act);
			}
			break;
		case 'customer':
			$accountMgrs =	DB_Query("Select userinfo.accountId, userinfo.userName, accountinfo.accountValidity from userinfo LEFT JOIN accountinfo ON accountinfo.accountId = userinfo.accountId where userinfo.userType = ".ADMIN, "ASSOC",""); 
			for($i=0;$i<count($accountMgrs);$i++){
				$result[$accountMgrs[$i]['accountId']]	=	$accountMgrs[$i];
			}
			break;
		case 'checks':
			if(isset($tempId)){
				$templateXml	=	DB_Read(array(
					'Table'=>'templateinfo',
					'Fields'=>'File',
					'clause'=>'templateId = '.$tempId
				),'ASSOC','');

				$templateChecksObject	=	array();
				$templateDom = new DOMDocument;
				$templateDom->loadXML($templateXml[0]['File']);
				$s = simplexml_import_dom($templateDom);
				foreach($s->Template->children() as $rules){
					if(count($rules->children())>0){
					  	$templateChecksObject[(string)$rules['name']]	=	array();
					  	$similarCheckFlag	=	false;
					  	$similarCount	=	0;
					  	$lengthCounter	=	0;
					  	$similarCheckArray	=	array();
						foreach ($rules->children() as $params){
/*					  		if(count($params->children())>0){
								$templateChecksObject[(string)$rules['name']][(string)$params['name']]	=	array();
					  			foreach ($params->children() as $subparams){
							  		if(count($subparams->children())>0){
										$templateChecksObject[(string)$rules['name']][(string)$params['name']][(string)$subparams['name']]	=	array();
							  			foreach ($subparams->children() as $entry){
											$templateChecksObject[(string)$rules['name']][(string)$params['name']][(string)$subparams['name']][(string)$entry['name']]	=	(string)$entry;
										}
							  		}
							  		else{
							  			$templateChecksObject[(string)$rules['name']][(string)$params['name']][(string)$subparams['name']]	=	(string)$subparams;
							  		}
								}
					  		}
*/
							if((string)$params['name'] == 'thresholdLevel'){
								$templateChecksObject[(string)$rules['name']][(string)$params['name']]	=	array();
								$similarCheckFlag	=	true;
							}	
							elseif(!$similarCheckFlag){
								$templateChecksObject[(string)$rules['name']][(string)$params['name']]	=	(string)$params;
							}
							elseif($similarCheckFlag){
								if(in_array((string)$params['name'], $similarCheckArray)){
									if($lengthCounter == count($similarCheckArray))
										$similarCount++;
									$lengthCounter--;
									if($lengthCounter == 0)
										$lengthCounter = count($similarCheckArray);
								}
								else{
									$similarCount	=	0;
									array_push($similarCheckArray,(string)$params['name']);
									$lengthCounter++;
								}
								$templateChecksObject[(string)$rules['name']]['thresholdLevel'][$similarCount][(string)$params['name']]	=	(string)$params;
							}
						}
					}
					else{
						$templateChecksObject[(string)$rules['name']]	=	(string)$rules;
					}
				}
				$result	=	$templateChecksObject;
			}
			break;
		case 'assignedChannels':
			/* Get channel ids and bouquet ids of bouquet assigned to user*/
			$assignedChannels	=	DB_Query('Select DISTINCT channelId,channelbouquetmapping.bouquetId from channelbouquetmapping, bouquetinfo Where channelbouquetmapping.bouquetId = bouquetinfo.bouquetId AND bouquetinfo.userId = '.$_SESSION['userID'].' Group By (channelId)','ASSOC','');
			if($assignedChannels){
				$channelIdArr	=	array();
				$nodeIdArr		=	array();
				$bouquetIdArr	=	array();
				$chInfoObj		=	array();
				$profileIdArr	=	array();

				/* Create array of distinct channel ids and bouquet ids*/
				for($i=0;$i<count($assignedChannels);$i++){
					/* push channel ids in an array*/
					array_push($channelIdArr,$assignedChannels[$i]['channelId']);
					
					/* push distinct bouquet ids in array*/
					if(!in_array($assignedChannels[$i]['bouquetId'], $bouquetIdArr)){
						array_push($bouquetIdArr,$assignedChannels[$i]['bouquetId']);
					}
				}
				
				/* Create mysql required format string from array as '"1","2"' etc to be used with IN ( ) query in mysql*/
				$mysqlChannelIdSearchEntity	=	createCommaSeparatedListForMysqlIN($channelIdArr);
				$mysqlBouquetIdSearchEntity	=	createCommaSeparatedListForMysqlIN($bouquetIdArr);

				/* Get channel name, node id of each channel */
				$chInfo			=	DB_Query('Select channelId, channelName, channelUrl, nodeId from channelinfo where channelId IN ('.$mysqlChannelIdSearchEntity.')','ASSOC','');
				
				/* create array of distinct node ids*/
				for($x=0;$x<count($chInfo);$x++){
					/* push distinct node ids in an array*/
					if(!in_array($chInfo[$x]['nodeId'], $nodeIdArr)){
						array_push($nodeIdArr,$chInfo[$x]['nodeId']);
					}
				}
				
				
				/* Create mysql required format string from array as '"1","2"' etc to be used with IN ( ) query in mysql*/
				$mysqlNodeIdSearchEntity	=	createCommaSeparatedListForMysqlIN($nodeIdArr);
				
				/* Fetch data from db related to the user */
				
				/*Get node information for the nodes in node array*/
				$nodeName		=	DB_Query('Select nodeId, nodeName from nodeinfo where nodeId IN ('.$mysqlNodeIdSearchEntity.')','ASSOC','');

				/*Get bouquet information for the bouquets in bouquet array*/
				$bouquetName	=	DB_Query('Select bouquetId, bouquetName from bouquetinfo where bouquetId IN ('.$mysqlBouquetIdSearchEntity.')','ASSOC','');

				/*Get profile information for the channels in channel array*/
				$profilesList	=	DB_Query('Select channelId, profileId, profileName, profileInformation, profileStatus, profileResolution from profileinfo where channelId IN ('.$mysqlChannelIdSearchEntity.') AND updateState = 1','ASSOC','');
				
				$proObj		=	array();
				$nodeObj	=	array();
				$bouquetObj	=	array();
				
				
				/* Associate the data obtained from the database with their respective IDS*/
				
				/*Associate profile object with channel ids*/
				for($j=0;$j<count($profilesList);$j++){
					/* Create distinct channel IDs key in a profile object */
					if(!array_key_exists($profilesList[$j]['channelId'], $proObj)){
						$proObj[$profilesList[$j]['channelId']]	=	array();
					}
					/* Enter profile information into corresponding profile object channel key value*/
					$proObj[$profilesList[$j]['channelId']][$profilesList[$j]['profileId']]	= $profilesList[$j];
					array_push($profileIdArr, $profilesList[$j]['profileId']);	
				}

				/* Associate node information with corresponding node Id*/
				for($k=0;$k<count($nodeName);$k++){
					$nodeObj[$nodeName[$k]['nodeId']]	=	$nodeName[$k];
				}
				
				/* Associate bouquet information with corresponding bouquet Id*/
				for($l=0;$l<count($bouquetName);$l++){
					$bouquetObj[$bouquetName[$l]['bouquetId']]	=	$bouquetName[$l];
				}
				
				/* Associate channel information with corresponding channel Id*/
				for($n=0;$n<count($chInfo);$n++){
					$chInfoObj[$chInfo[$n]['channelId']]	=	$chInfo[$n];
					$chInfoObj[$chInfo[$n]['channelId']]['monitorStatus']	=	'3';	// initialise monitor status for no entry in profileagentmap table
				}

				$mysqlProfileIdSearchEntity = createCommaSeparatedListForMysqlIN($profileIdArr);
				
				/*Get scheduled profiles for the profiles in profile array*/
				$scheduledProfiles = DB_Query('Select profileinfo.profileId, profileinfo.channelId, profileagentmap.status from profileagentmap LEFT JOIN profileinfo on profileinfo.profileId = profileagentmap.profileid where profileagentmap.profileid IN ('.$mysqlProfileIdSearchEntity.') order by profileagentmap.status','ASSOC','');
				
				for($b=0; $b<count($scheduledProfiles); $b++){
					$chInfoObj[$scheduledProfiles[$b]['channelId']]['monitorStatus']	=	'1';
					if($scheduledProfiles[$b]['status'] == '2'){
						$chInfoObj[$scheduledProfiles[$b]['channelId']]['monitorStatus']	=	'2';
					}
				}
				
				/*Prepare output object with channel Id key and object as value*/
				for($m=0;$m<count($assignedChannels);$m++){
					$tempCId	=	$assignedChannels[$m]['channelId'];
					$result[$tempCId]	=	array('bouquetId' =>$assignedChannels[$m]['bouquetId'],'bouquetName' => $bouquetObj[$assignedChannels[$m]['bouquetId']]['bouquetName'],'channelId'=>$tempCId,'channelName'=>$chInfoObj[$tempCId]['channelName'],'channelUrl'=>$chInfoObj[$tempCId]['channelUrl'],'nodeId'=>$chInfo[$m]['nodeId'],'nodeName'=>$nodeObj[$chInfo[$m]['nodeId']]['nodeName'],'profiles'=>$proObj[$tempCId],'monitorStatus'=>$chInfoObj[$tempCId]['monitorStatus']);
				}
			}
			break;
		case 'dash':
		//	$dashData	=	file_get_contents('\\\\192.168.0.166\\Jobs_Report\\'.$_SESSION['userID'].'.txt');
			$fileContent	=	'';
			$file			= $_SESSION['SERVER_ROOT']."/Repdir/".$_SESSION['userID'].".txt";  
			$iterator	=	0;
//			if($fileHandler	= fopen($file , "rb")){
				try {
					$fileContent	= file_get_contents($file);
				}
				catch (Exception $e) {
					$fileContent	= file_get_contents($file);
				}
    			$channelErrArray = explode("\n", $fileContent);
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
		            			$errorProp		=	explode('|',$currentProfileError[$i]);
		            			$myArray[$iterator]	=	array( 'Channel'=>$currentChannelId, 'Profile'=>$currentProfileId, 'type' => array_shift($errorProp) ,'start'=>array_shift($errorProp),'end'=>array_shift($errorProp),'msg'=>array_shift($errorProp));
		            			$iterator++;
		            		}
		            		$i=0;
		            	}
					}
    			}
				if(isset($_GET['filters']) &&  $_GET['filters'] != ''){
					$filterObject	=	json_decode($_GET['filters'],true);
					$filterRules	=	$filterObject['rules'];
					for($j=0;$j<count($filterRules);$j++){
// 						if($filterRules[$j]['field'] == "Profile" && strrpos($filterRules[$j]['data'],',')){
// 							$filterOptionsProfileIds = explode(',',$filterRules[$j]['data']);
// 							for($profID=0;$profID<count($filterOptionsProfileIds);$profID++){
// 								filter_by_value($myArray, $filterRules[$j]['field'], (int)$filterOptionsProfileIds[$profID]);
// 							}
// 						}
// 						else{
						$filterOptionsProfileIds = explode(',',$filterRules[$j]['data']);
						filter_by_value($myArray, $filterRules[$j]['field'], $filterOptionsProfileIds);
// 						}
					}
				}
				if(isset($_GET['sidx']) &&  $_GET['sidx'] != ''){
					sortBy($_GET['sidx'],$myArray,$_GET['sord']);
				}
				if(isset($_GET['sidx']) &&  $_GET['sidx'] != ''){
		    		$limit	=	$_GET['rows'];
					if($limit != -1)
					{
						$page	=	$_GET['page'];
						$start 	= $limit*$page - $limit;
						$recordCount	=	count($myArray); 
						$total_pages = ceil($recordCount/$limit);
					}
					else
					{
						$page	=	1;
						$total_pages = 1; 
					}
				}
    			
				$filter	=	'';
    			$jTableResult = array();
				if(isset($act) && $act=='grid'){
					$jTableResult['total'] 		= $total_pages;
					$jTableResult['page'] 		= $page;
					$jTableResult['records']	= $recordCount;
				}
				else{
					$start	=	0;
					$limit	=	count($myArray);
				}
				$jTableResult['rows'] 	 	= getRequestedReportData($start, $limit, $filter);
    			
				$result	=	$jTableResult;
//		        fclose($filehandler);  
//			}
            break;
		case 'schedule':
			$scheduleInfo	=	DB_Query('Select * from eventinfo where channelId	= '.$channel.' AND eventStatus != '.REMOVED,'ASSOC','');
			if($scheduleInfo != ''){
				$result	=	$scheduleInfo;
			}
			break;
			
		case 'profileResolution':
			
			$profileResult		=	DB_Query('Select profileId, profileResolution, profileStatus from profileinfo where profileId IN ('.$profileId.') AND profileResolution != "N.A."','ASSOC','');	
			if($profileResult){
				$result = $profileResult;
			}else
				$result = '';
			break;
			
		case 'TimezoneTableData':
			
			$timeZoneResult		=	DB_Query('Select timezoneId, zoneName, zoneOffset from timezoneinfo','ASSOC','');
			$timeZoneResultObj	=	array();
			
			for($i=0;$i<count($timeZoneResult);$i++){
				$timeZoneResultObj[$timeZoneResult[$i]['timezoneId']] = $timeZoneResult[$i];
			}
			
			if(count($timeZoneResultObj)){
				$result = $timeZoneResultObj;
			}else
				$result = '';
			
			break;
		case 'alertsettings':
				
			$alertResult		=	DB_Query('Select `interval`, errorLimit, recipentEmailIds from emailalertsettings where accountId ="'.$_SESSION['accountID'].'"','ASSOC','');
			if($alertResult){
				$result = $alertResult;
			}else
				$result = '';
			break;
			
		case 'channelProfiles':
				
// 			$channelProfilesResult		=	DB_Query('SELECT channelinfo.channelId, profileinfo.profileId, profileinfo.profileInformation FROM profileinfo LEFT JOIN channelinfo ON channelinfo.channelId = profileinfo.channelId WHERE channelinfo.accountId ="'.$_SESSION['accountID'].'" AND channelStatus !="'.REMOVED.'"','ASSOC','');
			$channelProfilesResult		=	DB_Query('SELECT profileinfo.profileStatus, profileinfo.channelId, profileinfo.profileId, profileinfo.profileInformation FROM profileinfo JOIN channelbouquetmapping ON channelbouquetmapping.channelId = profileinfo.channelId JOIN bouquetinfo ON bouquetinfo.bouquetId = channelbouquetmapping.bouquetId WHERE bouquetinfo.userId = "'.$_SESSION['userID'].'"','ASSOC','');
			$channelProfilesObj	=	array();
				
			for($i=0;$i<count($channelProfilesResult);$i++){
				$channelProfilesObj[$channelProfilesResult[$i]['channelId']]['profiles'][$channelProfilesResult[$i]['profileId']] = $channelProfilesResult[$i];
			}
				
			if(count($channelProfilesObj)){
				$result = $channelProfilesObj;
			}else
				$result = '';
				
			break;
	}
// 	if((isset($channelTableData) && $data == 'channel') || $data == 'assignedChannels'){
// 		echo addslashes(json_encode($result));
// 	}else{
		echo json_encode($result);
//	}

	?>