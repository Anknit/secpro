<?php
/*
 * Author: Nitin Aloria
 * Date: 01-September-2015
 * Description: This file is used for updating server status in database
 */
?>
<?php
require_once __DIR__.'./../definitions.php';
require_once __DIR__.'./../../Common/php/cloudServerAPI.php';
require_once __DIR__.'./../AgentOperations/commonServerOperations.php';
require_once __DIR__.'./../ControllerNotification/requestMethods.php';
require_once __DIR__.'./../../Common/php/OperateDB/DbMgrInterface.php';
require_once __DIR__.'./../../Common/php/ErrorHandling.php';
require_once __DIR__.'./../../Common/php/commonfunctions.php';
require_once __DIR__.'./../definePaths.php';
require_once __DIR__.'./../ErrorMessages.php';
require_once __DIR__.'./../../Common/php/MailMgr.php';
require_once __DIR__.'./../mailsHTML.php';

function checkCreateServerResponse(){
	
	$dbResults = DB_Query ( 'Select requestedAgentInfo.reqID, requestedAgentInfo.uniqueServerID, nodeinfo.nodeLocation from requestedAgentInfo LEFT JOIN nodeinfo ON requestedAgentInfo.nodeId = nodeinfo.nodeId where requestedAgentInfo.status = "BUILD" OR requestedAgentInfo.status = ""', 'ASSOC', '' );

	if(count($dbResults) && $dbResults != 0 ){
		$getTokenDetails = serverDetailsAuthorization();
		$tokenId	=	$getTokenDetails['TokenID'];
		$tenantId	=	$getTokenDetails['TenantID'];
				
		foreach($dbResults as $key=>$value){
			if(!isset($value['uniqueServerID'])){ //When status == ""
				continue;
			}
			$serverDetails = getServerDetails ( array('TokenID'=>$tokenId, 'TenantID'=>$tenantId, 'ServerLocation'=>$value['nodeLocation'], 'ServerID'=>$value['uniqueServerID']), $value ['reqID']);
			//Updating Database	
			$updateServerDetails = DB_Update ( array (
					'Table' => 'requestedAgentInfo',
					'Fields' => array (
							'progress' => $serverDetails ['Server'] ['Progress'],
							'status' => $serverDetails ['Server'] ['Status'],
							'activeTime' => gmdate("M d Y H:i:s", time())
					),
					'clause' => 'reqId	= "' . $value ['reqID'] . '"'
			) );

			if($serverDetails ['Server'] ['Status'] != 'BUILD'){
				// Sending Response to Controller

				if($serverDetails ['Server'] ['Status'] == 'ACTIVE'){
					$createServerStatus = '0';	//For Success
				}else{
					$createServerStatus = '1';	//For Failure
				}
				
				$controllerResponse = NOVA_COMMUNICATION ( 'notify', array (
						'type' => 'agentup-res',
						'id' => $value ['reqID'] . '||' . $createServerStatus 
				) );
				
				//Setting Error Codes
				if ($controllerResponse !== 0 && $controllerResponse !== '0') {
					SetErrorCodes ( $controllerResponse, __LINE__, __FILE__ );
				}
			}
			
		}//foreach
	}
}

function checkDeleteServerResponse(){

	$dbResults = DB_Query ( 'Select requestedAgentInfo.createdTime, requestedAgentInfo.deleteRequestTime, requestedAgentInfo.reqID, requestedAgentInfo.uniqueServerID, nodeinfo.nodeLocation, requestedAgentInfo.serverName, requestedAgentInfo.ipAddress, requestedAgentInfo.serverPassword from requestedAgentInfo LEFT JOIN nodeinfo ON requestedAgentInfo.nodeId = nodeinfo.nodeId where requestedAgentInfo.status = "DELETING"', 'ASSOC', '' );
	
	if(count($dbResults) && $dbResults != 0 ){
		$getTokenDetails = serverDetailsAuthorization();
		$tokenId	=	$getTokenDetails['TokenID'];
		$tenantId	=	$getTokenDetails['TenantID'];
		
		foreach($dbResults as $key=>$value){
// 			$serverDetails = getServerDetails ( array('TokenID'=>$tokenId, 'TenantID'=>$tenantId, 'ServerLocation'=>$value['nodeLocation'], 'ServerID'=>$value['uniqueServerID']), $value ['reqID']);
			$serverDetailsObjParams = array (
					'TokenID' => $tokenId,
					'TenantID' => $tenantId,
					'ServerLocation' => $value ['nodeLocation'],
					'Filters' => array (
							'Changed'	=> $value ['createdTime'],
							'Status'	=>	'DELETED'
					)
			);
			$serverDetailsObj = getInfoFrom('cloudServersAPI', 'cloudServerLists', $serverDetailsObjParams);
			$serverDetails = $serverDetailsObj['Servers'][$value['uniqueServerID']];	
			if($serverDetails['Status'] == 'DELETED'){
					$createServerStatus = '0';	//For Success
					$deleteStatus = 'DELETED';
			}else{
				 	$d1=new DateTime($value['deleteRequestTime']);
					$date1 = $d1->getTimestamp();
					$d2=new DateTime(gmdate("M d Y H:i:s", time()));	//Current Time
					$date2 = $d2->getTimestamp();
					
					if(($date1+3600) < $date2){
						$createServerStatus = '1';		// For Failure			
 						$deleteStatus = 'DELETION_FAILED';
						
						$getSubjectArguments = array (
								'case' => 'agentDeletionFailed'
						);
						$mailSubject = getMailSubject ( $getSubjectArguments );
						
						$getMailBodyArguments = array (
								'case' => 'agentDeletionFailed',
								'args' => array(
										'serverName' 	=>	$value['serverName'],
										'serverId'	=>	$value['uniqueServerID'],
										'serverIpAddress'	=>	$value['ipAddress'],
										'serverPassword'	=>	$value['serverPassword']
								)
						);
						$mailBodyHtml = getMailBody ( $getMailBodyArguments );
						$emailID = NovaSupportEmail;
						$sendmailOutput = send_Email ( $emailID, $mailSubject, $mailBodyHtml);
					}else{
						updateReqtime( 'requestedAgentInfo','activeTime',$value ['reqID'] );
						continue;
					}
			}
			
			//Updating Database
			$updateServerDetails = DB_Update ( array (
					'Table' => 'requestedAgentInfo',
					'Fields' => array (
							'status' => $deleteStatus,
							'activeTime' => gmdate("M d Y H:i:s", time())
					),
					'clause' => 'reqId	= "' . $value ['reqID'] . '"'
			) );
			
			if($deleteStatus == 'DELETION_FAILED'){ //For not sending error response to controller on deletion fail
				continue;
			}
			$controllerResponse = NOVA_COMMUNICATION ( 'notify', array (
					'type' => 'agentdown-res',
					'id' => $value ['reqID'] . '||' . $createServerStatus
			) );
				
			//Setting Error Codes
			if ($controllerResponse !== 0 && $controllerResponse !== '0') {
				SetErrorCodes ( $controllerResponse, __LINE__, __FILE__ );
			}
			
		}//Foreach
	}
}

checkCreateServerResponse();
checkDeleteServerResponse();
?>