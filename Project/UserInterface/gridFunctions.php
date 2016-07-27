<?php
		function getTotalRecords($clause, $table){
			$query	=	"Select Count(*) AS TotalRecordsAvailable FROM ".$table;
			if($clause != '')
				$query	.=	" WHERE ".$clause;
				
			$TotalRecordsResult	=	DB_Query($query,'ASSOC', '');
			$recordCount = $TotalRecordsResult[0]['TotalRecordsAvailable'];
			return $recordCount;
		}
		function getAgentData($clause=''){
			$AgentInfo	=	array();
			$limit	=	$_GET['rows'];
			if($limit != -1)
			{
				$page	=	$_GET['page'];
				$start = $limit*$page - $limit;
				$recordCount	=	DB_Query("Select Count(*) AS TotalRecordsAvailable FROM agentinfo LEFT JOIN nodeinfo On agentinfo.nodeId = nodeinfo.nodeId Where ".$clause,'ASSOC', '')[0]['TotalRecordsAvailable'];
//				$recordCount	=	getTotalRecords($clause, 'agentinfo'); 
				$orderClause	=	$_GET['sidx']." ".$_GET['sord']." LIMIT $start , $limit";
				$total_pages = ceil($recordCount/$limit);
			}
			else
			{
				$page	=	1;
				$total_pages = 1; 
			}
			
			$agentDataClause	=	array();
			if($clause != ''){
				$agentDataClause['clause']	=	$clause;
			}
				
			if($orderClause != ''){
				$agentDataClause['orderclause']	=	$orderClause;
			}
				
			$AgentInfo	=	getInfoFrom('retreive_data', 'completeAgentDetails', $agentDataClause);
			if($AgentInfo != 0 && count($AgentInfo) > 0) {
				for($i=0;$i<count($AgentInfo);$i++){
					$AgentInfo[$i]['monitorStatus']	=	'2';
					$currentProfileMonitor	=	DB_Query('Select count(*) as profileCount from profileagentmap where agentid = "'.$AgentInfo[$i]['agentId'].'"','ASSOC','');
					if($currentProfileMonitor[0]['profileCount']>0){
						$AgentInfo[$i]['monitorStatus']	=	'1';
					}
				}
			}
				
			//Return result to jTable
			$jTableResult = array();
			$jTableResult['total'] 		= $total_pages;
			$jTableResult['page'] 		= $page;
			$jTableResult['records']	= $recordCount;
			$jTableResult['rows'] 	 	= $AgentInfo;
			return $jTableResult;
		}
		function getNodeData($clause	=	''){
			$NodeInfo	=	array();
			$limit	=	$_GET['rows'];
			if($limit != -1)
			{
				$page	=	$_GET['page'];
				$start = $limit*$page - $limit;
				$recordCount	=	getTotalRecords($clause, 'nodeinfo'); 
				$orderClause	=	$_GET['sidx']." ".$_GET['sord']." LIMIT $start , $limit";
				$total_pages = ceil($recordCount/$limit);
			}
			else
			{
				$page	=	1;
				$total_pages = 1; 
			}
			
			$nodeDataClause	=	array();
			if($_SESSION['userTYPE'] == SUPERUSER )
				$clause	=	'';
			if($clause != ''){
				$nodeDataClause['clause']	=	$clause;
			}
				
			if($orderClause != ''){
				$nodeDataClause['orderclause']	=	$orderClause;
			}
			
			$NodeInfo	=	getInfoFrom('retreive_data', 'completeNodeDetails', $nodeDataClause);

			//Return result to jTable
			$jTableResult = array();
			$jTableResult['total'] 		= $total_pages;
			$jTableResult['page'] 		= $page;
			$jTableResult['records']	= $recordCount;
			$jTableResult['rows'] 	 	= $NodeInfo;
			return $jTableResult;
		}
		function getChannelData($clause	=	''){
			$ChannelInfo	=	array();
			$limit	=	$_GET['rows'];
			if($limit != -1)
			{
				$page	=	$_GET['page'];
				$start = $limit*$page - $limit;
				$recordCount	=	getTotalRecords($clause, 'channelinfo'); 
				$orderClause	=	$_GET['sidx']." ".$_GET['sord']." LIMIT $start , $limit";
				$total_pages = ceil($recordCount/$limit);
			}
			else
			{
				$page	=	1;
				$total_pages = 1; 
			}
			$channelDataClause	=	array();
			if($_SESSION['userTYPE'] == SUPERUSER )
				$clause	=	'';
			if($clause != ''){
				$channelDataClause['clause']	=	$clause;
			}
				
			if($orderClause != ''){
				$channelDataClause['orderclause']	=	$orderClause;
			}
			
			
			$ChannelInfo	=	getInfoFrom('retreive_data', 'completeChannelDetails', $channelDataClause);

			//Return result to jTable
			$jTableResult = array();
			$jTableResult['total'] 		= $total_pages;
			$jTableResult['page'] 		= $page;
			$jTableResult['records']	= $recordCount;
			$jTableResult['rows'] 	 	= $ChannelInfo;
			return $jTableResult;
			
		}
		function getBouquetData($clause	=	''){
			$BouquetInfo	=	array();
			$limit	=	$_GET['rows'];
			if($limit != -1)
			{
				$page	=	$_GET['page'];
				$start = $limit*$page - $limit;
				$recordCount	=	getTotalRecords($clause, 'bouquetinfo'); 
				$orderClause	=	$_GET['sidx']." ".$_GET['sord']." LIMIT $start , $limit";
				$total_pages = ceil($recordCount/$limit);
			}
			else
			{
				$page	=	1;
				$total_pages = 1; 
			}
			
			$bouquetDataClause	=	array();
			if($_SESSION['userTYPE'] == SUPERUSER )
				$clause	=	'';
			if($clause != ''){
				$bouquetDataClause['clause']	=	$clause;
			}
				
			if($orderClause != ''){
				$bouquetDataClause['orderclause']	=	$orderClause;
			}
			
			$BouquetInfo	=	getInfoFrom('retreive_data', 'completeBouquetDetails', $bouquetDataClause);
		
			//Return result to jTable
			$jTableResult = array();
			$jTableResult['total'] 		= $total_pages;
			$jTableResult['page'] 		= $page;
			$jTableResult['records']	= $recordCount;
			$jTableResult['rows'] 	 	= $BouquetInfo;
			return $jTableResult;
		}
		function getUserData(){
			$UserInfo	=	array();
			$clause	=	'accountId = '.$_SESSION['accountID'];
			if( $_SESSION['userTYPE'] == SUPERUSER || $_SESSION['userTYPE'] == SALES){
				$clause	=	'userType = '.ADMIN;
			}
			$limit	=	$_GET['rows'];
			if($limit != -1)
			{
				$page	=	$_GET['page'];
				$start = $limit*$page - $limit;
				$recordCount	=	getTotalRecords($clause, 'userinfo');
				$orderClause	=	$_GET['sidx']." ".$_GET['sord']." LIMIT $start , $limit";
				$total_pages = ceil($recordCount/$limit);
			}
			else
			{
				$page	=	1;
				$total_pages = 1; 
			}

			$userDataClause	=	array();
			if($clause != ''){
				$userDataClause['clause']	=	$clause;
			}
				
			if($orderClause != ''){
				$userDataClause['orderclause']	=	$orderClause;
			}
			
			$userTableData	=	getInfoFrom('retreive_data', 'completeUserDetails', $userDataClause);

			//Return result to jTable
			$jTableResult = array();
			$jTableResult['total'] 		= $total_pages;
			$jTableResult['page'] 		= $page;
			$jTableResult['records']	= $recordCount;
			$jTableResult['rows'] 	 	= $userTableData;
			return $jTableResult;
		}
		function getTemplateData($clause=''){
			
			$limit	=	$_GET['rows'];
			if($limit != -1)
			{
				$page	=	$_GET['page'];
				$start = $limit*$page - $limit;
				$recordCount	=	getTotalRecords($clause, 'templateinfo');
				$orderClause	=	$_GET['sidx']." ".$_GET['sord']." LIMIT $start , $limit";
				$total_pages = ceil($recordCount/$limit);
			}
			else
			{
				$page	=	1;
				$total_pages = 1; 
			}
			$userDataClause	=	array();
			if($clause != ''){
				$userDataClause['clause']	=	$clause;
			}
				
			if($orderClause != ''){
				$userDataClause['orderclause']	=	$orderClause;
			}
			
			$templateTableData	=	DB_Read(array(
				'Table'=>'templateinfo',
				'Fields'=>'templateId,templateName,templateDescription',
				'clause'=>$userDataClause['clause'],
				'order'=>$userDataClause['orderclause']	
			),'ASSOC','');
			
			
			//Return result to jTable
			$jTableResult = array();
			$jTableResult['total'] 		= $total_pages;
			$jTableResult['page'] 		= $page;
			$jTableResult['records']	= $recordCount;
			$jTableResult['rows'] 	 	= $templateTableData;
			return $jTableResult;
		}
		
		function getPaymentData($dataElem){
			$limit	=	$_GET['rows'];
			$clause	=	"";
			if($dataElem == 'accountpayment'){
				$clause = 'accountId = '.$_SESSION['accountID'];
			}
			if($limit != -1)
			{
				$page	=	$_GET['page'];
				$start = $limit*$page - $limit;
				$recordCount	=	getTotalRecords($clause, 'paymentinfo');
				$orderClause	=	$_GET['sidx']." ".$_GET['sord']." LIMIT $start , $limit";
				$total_pages = ceil($recordCount/$limit);
			}
			else
			{
				$page	=	1;
				$total_pages = 1; 
			}
			
			if($dataElem == 'payment'){
				$clause = ' userinfo.userType = '.ADMIN;
				$paymentQuery	=	'Select paymentinfo.*, userinfo.userName from paymentinfo LEFT JOIN userinfo ON paymentinfo.accountId = userinfo.accountId ';
			}else if ($dataElem == 'accountpayment'){
				$clause = 'accountId = '.$_SESSION['accountID'];
				$paymentQuery	=	'Select * from paymentinfo ';
			}
			
			$userDataClause	=	array();
			
			if($clause != ''){
//				$userDataClause['clause']	=	$clause;
				$paymentQuery	.=	'Where '.$clause;
			}
				
			if($orderClause != ''){
//				$userDataClause['orderclause']	=	$orderClause;
				$paymentQuery	.=	' Order By '.$orderClause;
			}
			$paymentTableData	=	DB_Query($paymentQuery,'ASSOC','');
			
			
			//Return result to jTable
			$jTableResult = array();
			$jTableResult['total'] 		= $total_pages;
			$jTableResult['page'] 		= $page;
			$jTableResult['records']	= $recordCount;
			$jTableResult['rows'] 	 	= $paymentTableData;
			return $jTableResult;
		}
		
		function getUsageInfoData(){
			$limit	=	$_GET['rows'];
			$clause = 'usageinfo.accountId = '.$_SESSION['accountID'];
			$usageQuery	=	'Select usageinfo.*, eventinfo.startTime, eventinfo.endTime, channelinfo.channelName from usageinfo LEFT JOIN eventinfo ON usageinfo.eventId = eventinfo.eventId LEFT JOIN channelinfo ON eventinfo.channelId = channelinfo.channelId ';
			
			if($limit != -1)
			{
				$page	=	$_GET['page'];
				$start = $limit*$page - $limit;
				$recordCount	=	getTotalRecords($clause, 'usageinfo');
				$orderClause	=	$_GET['sidx']." ".$_GET['sord']." LIMIT $start , $limit";
				$total_pages = ceil($recordCount/$limit);
			}
			else
			{
				$page	=	1;
				$total_pages = 1;
			}
			$userDataClause	=	array();
			
			if($clause != ''){
				//				$userDataClause['clause']	=	$clause;
				$usageQuery	.=	'Where '.$clause;
			}
			
			if($orderClause != ''){
				//				$userDataClause['orderclause']	=	$orderClause;
				$usageQuery	.=	' Order By '.$orderClause;
			}
			$usageTableData	=	DB_Query($usageQuery,'ASSOC','');
				
				
			//Return result to jTable
			$jTableResult = array();
			$jTableResult['total'] 		= $total_pages;
			$jTableResult['page'] 		= $page;
			$jTableResult['records']	= $recordCount;
			$jTableResult['rows'] 	 	= $usageTableData;
			return $jTableResult;
		}
		
		function getLoginDetailsData(){
			$limit	=	$_GET['rows'];
			$clause = '';
			$loginQuery	=	'SELECT sessioninfo.sessionPrimaryKey, userinfo.name, userinfo.mailId, sessioninfo.startTime, sessioninfo.loginDuration FROM sessioninfo LEFT JOIN userinfo ON sessioninfo.userId = userinfo.userId ';
				
			if($limit != -1)
			{
				$page	=	$_GET['page'];
				$start = $limit*$page - $limit;
				$recordCount	=	getTotalRecords($clause, 'sessioninfo');
				$orderClause	=	$_GET['sidx']." ".$_GET['sord']." LIMIT $start , $limit";
				$total_pages = ceil($recordCount/$limit);
			}
			else
			{
				$page	=	1;
				$total_pages = 1;
			}
		
			$clause = 'userinfo.userType = '.OPERATOR.' AND userinfo.regAuthorityId = '.$_SESSION['userID'];
			if($clause != ''){

				$loginQuery	.=	'Where '.$clause;
			}
				
			if($orderClause != ''){

				$loginQuery	.=	' Order By '.$orderClause;
			}
			$loginTableData	=	DB_Query($loginQuery,'ASSOC','');
		
		
			//Return result to jTable
			$jTableResult = array();
			$jTableResult['total'] 		= $total_pages;
			$jTableResult['page'] 		= $page;
			$jTableResult['records']	= $recordCount;
			$jTableResult['rows'] 	 	= $loginTableData;
			return $jTableResult;
		}
		function getRequestedReportData($start, $limit, $filter){
			$responseMyDataArr	=	array();
			global $myArray;
			for($i=$start;$i<($start+$limit);$i++){
				if($myArray[$i] != '' && $myArray[$i] != null)
					array_push($responseMyDataArr, $myArray[$i]);
			}
			if(count($responseMyDataArr)==0)
				$responseMyDataArr	=	'';
			return $responseMyDataArr;
		}
		
		function sortBy($field, &$array, $direction = 'asc')
		{
		    usort($array, create_function('$a, $b', '
		        $a = $a["' . $field . '"];
		        $b = $b["' . $field . '"];
		
		        if ($a == $b)
		        {
		            return 0;
		        }
		
		        return ($a ' . ($direction == 'desc' ? '>' : '<') .' $b) ? -1 : 1;
		    '));
		
		    return true;
		}
		
		function filter_by_value (&$array, $index, $value){ 
	        if(is_array($array) && count($array)>0)  
	        { 
	        	$newarray	=	array();
	            foreach ($array as $key1 => $value1){
	                if (in_array(trim($array[$key1][$index]),$value)) { 
	                  array_push($newarray,$array[$key1]);
					} 
	            }
	            $array	=	$newarray;
	          } 
	      return true; 
	    }
?>