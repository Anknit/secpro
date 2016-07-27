<?php
/*
 * Author: Nitin Aloria
 * Date: 28-August-2015
 * Description: This file is used for creating server on cloud
 */
?>
<?php

function GetIpv4Recursively($tokenExists, $requestId){
	
	$serverDetails = getServerDetails ( $tokenExists, $requestId );
	if($serverDetails ['Server'] ['Address'] =='' || $serverDetails ['Server'] ['Address'] == null){
		$serverDetails = GetIpv4Recursively($tokenExists, $requestId);
	}
	return $serverDetails;
}

function getRequestObj($reqId) {
	$reqObj = DB_Query ( "Select requestedAgentInfo.configurationID, nodeinfo.nodeLocation, nodeinfo.nodeId from requestedAgentInfo LEFT JOIN nodeinfo ON requestedAgentInfo.nodeId = nodeinfo.nodeId where requestedAgentInfo.reqId = " . $reqId, "ASSOC", "" );
	
	return $reqObj [0];
}

if (isset ( $raciParam ['requestAction'] )) {
	
	$reqId = $raciParam ['RequestId'];
	$reqObj = getRequestObj ( $reqId );
	updateReqtime ( 'requestedAgentInfo','reqTime',$reqId );
	
	$cloudServiceAuthDetailsObj = serverDetailsAuthorization();
	$tokenId = $cloudServiceAuthDetailsObj['TokenID'];
	$tenantId = $cloudServiceAuthDetailsObj['TenantID'];
	
	$serverName = 'NovaAgent_'.$reqObj['nodeId'].'_'.$reqId.'_'.gmdate("M d Y H:i:s", time());
	$imageId = 'a3b11f19-7347-4827-b55a-c5edb5338cae';
	$serverParams = array(
			'TokenID'=>$tokenId, 
			'TenantID'=>$tenantId,
			'ServerLocation'=>$reqObj['nodeLocation'],
			'ServerName'=>$serverName,
			'ImageID'=>$imageId,
			'ServerFlavorID'=>$reqObj['configurationID']);
	
	$createServerResponse	=	getInfoFrom('cloudServersAPI', 'cloudServerCreateServer', $serverParams);

	$updateCreateServerDetails = DB_Update ( array (
			'Table' => 'requestedAgentInfo',
			'Fields' => array (
					'uniqueServerID' => $createServerResponse['Server']['id'],
					'serverURL' => $createServerResponse['Server']['link'],
					'serverPassword' => $createServerResponse['Server']['Password'],
					'serverRequestResponse'=>$createServerResponse['ServerResponse']
			),
			'clause' => 'reqId	= "' . $reqId . '"'
	) );
	
	if($createServerResponse['status'] == 1 || $createServerResponse['status'] == '1'){
		$serverDetails = GetIpv4Recursively(array('TokenID'=>$tokenId, 'TenantID'=> $tenantId),$reqId);

		$updateServerDetails = DB_Update ( array (
				'Table' => 'requestedAgentInfo',
				'Fields' => array (
						'ipAddress' => $serverDetails ['Server'] ['Address'],
						'serverName' => $serverDetails ['Server'] ['name'],
						'progress' => $serverDetails ['Server'] ['Progress'],
						'status' => $serverDetails ['Server'] ['Status'],
						'createdTime' => $serverDetails ['Server'] ['Created'],
						'flavorID' => $serverDetails ['Server'] ['Flavor'] ['id'],
						'flavorLink' => $serverDetails ['Server'] ['Flavor'] ['link'],
						'serverDetailsResponse' => $serverDetails ['ServerResponse']
				),
				'clause' => 'reqId	= "' . $reqId . '"'
		) );
		$Output = '&STATUS=SUCCESS';
	}else{
		$Output = '&STATUS=FAILURE';
	}
	
}
?>