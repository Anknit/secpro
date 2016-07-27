<?php
/*
 * Author: Nitin Aloria
 * Date: 11-September-2015
 * Description: This file is used for deleting server on cloud
 */
?>
<?php
function getRequestObj($reqId) {
	$reqObj = DB_Query ( "Select requestedAgentInfo.createdTime, requestedAgentInfo.uniqueServerID, nodeinfo.nodeLocation from requestedAgentInfo LEFT JOIN nodeinfo ON requestedAgentInfo.nodeId = nodeinfo.nodeId where requestedAgentInfo.reqId = " . $reqId, "ASSOC", "" );
	return $reqObj [0];
}



if (isset ( $raciParam ['requestAction'] )) {
	
	$reqId = $raciParam ['RequestId'];
	$reqObj = getRequestObj ( $reqId );
	updateReqtime ( 'requestedAgentInfo','deleteRequestTime',$reqId );
	
	$cloudServiceAuthDetailsObj = serverDetailsAuthorization();
	$tokenId = $cloudServiceAuthDetailsObj['TokenID'];
	$tenantId = $cloudServiceAuthDetailsObj['TenantID'];
	
	$serverParams = array(
			'TokenID'=>$tokenId,
			'TenantID'=>$tenantId,
			'ServerLocation'=>$reqObj['nodeLocation'],
			'ServerID'=>$reqObj['uniqueServerID']
	);
	
	$deleteServerResponse	=	getInfoFrom('cloudServersAPI', 'cloudServerDelete', $serverParams);
	
	if($deleteServerResponse['status'] == 1 || $deleteServerResponse['status'] == '1'){
// 		$serverDetails = getServerDetails ( array('TokenID'=>$tokenId, 'TenantID'=>$tenantId, 'ServerLocation'=>$reqObj['nodeLocation'], 'ServerID'=>$reqObj['uniqueServerID']), $reqId );
		$serverDetailsObjParams = array (
				'TokenID' => $tokenId,
				'TenantID' => $tenantId,
				'ServerLocation' => $reqObj ['nodeLocation'],
				'Filters' => array (
						'Changed'	=> $reqObj ['createdTime'],
						'Status'	=>	'DELETED'
				)
		);
		$serverDetailsObj = getInfoFrom('cloudServersAPI', 'cloudServerLists', $serverDetailsObjParams);
		$serverDetails = $serverDetailsObj['Servers'][$reqObj['uniqueServerID']];
		if($serverDetails['Status'] == 'DELETED'){
			$serverDeleteStatus = 'DELETED';
		}else{
			$serverDeleteStatus = 'DELETING';
		}
		
		$updateDeleteServerDetails = DB_Update ( array (
				'Table' => 'requestedAgentInfo',
				'Fields' => array (
						'status' => $serverDeleteStatus,
				),
				'clause' => 'reqId	= "' . $reqId . '"'
		) );
		
	$Output = '&STATUS=SUCCESS';
	
	}else{
		$Output = '&STATUS=FAILURE';
	}	
	
}
?>