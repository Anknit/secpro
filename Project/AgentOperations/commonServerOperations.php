<?php
/**
* Author: Nitin
* Date: 31-Aug-2015
* Description: This file is used for agent scale common functions
*
*/
?>
<?php
function updateReqtime($tableName,$fieldName, $reqId) {
	$updateReqTimeStatus = DB_Update ( array (
			'Table' => $tableName,
			'Fields' => array (
					$fieldName => gmdate("M d Y H:i:s", time())
			),
			'clause' => 'reqId	= "' . $reqId . '"'
	) );
};

function initializeAuthentication(){
	
	$authData	=	getInfoFrom('cloudServersAPI', 'cloudServerAuthentication', cloudServersAPICredentials());
	if($authData['TokenID'] == '' || $authData['TokenID'] == null){
		$authData = initializeAuthentication();
	}else{
		$updateInitializedData = DB_Insert (
				array(
						'Table' => 'cloudserverdetails',
						'Fields' => array (
								'tokenId' => $authData['TokenID'],
								'tokenExpiry'=> $authData['TokenExpiry'],
								'tenantId'=> $authData['TenantID'],
								'tokenStatus'=>'ACTIVE'
						)
				)
		);
	}
	
	
	return $authData;
}


function getServerDetails($tokenExists, $requestId){
	$tokenId = $tokenExists['TokenID'];
	$tenantId = $tokenExists['TenantID'];
	if(!(isset($tokenExists['ServerLocation']) && isset($tokenExists['ServerID']))){
		$serverDetailsQuery = DB_Query ( "SELECT nodeinfo.nodeLocation, requestedAgentInfo.uniqueServerID FROM requestedAgentInfo LEFT JOIN nodeinfo ON requestedAgentInfo.nodeId = nodeinfo.nodeId WHERE reqID= ".$requestId, "ASSOC", "" );
		$ServerLocation	=	$serverDetailsQuery[0]['nodeLocation'];
		$ServerID		=	$serverDetailsQuery[0]['uniqueServerID'];
	}
	else{
		$ServerLocation	=	$tokenExists['ServerLocation'];
		$ServerID	=	$tokenExists['ServerID'];
	}
	$serverDetailsObj = getInfoFrom('cloudServersAPI', 'cloudServerDetails', array('TokenID'=>$tokenId,'TenantID'=>$tenantId,'ServerLocation'=>$ServerLocation,'ServerID'=>$ServerID));
	
	return $serverDetailsObj; 
}


function serverDetailsAuthorization(){
	
// 	$tokenExists = DB_Query ( 'SELECT * FROM cloudserverdetails where tokenStatus = "ACTIVE"', 'ASSOC', '' );
// 	$d1=new DateTime($tokenExists[0]['tokenExpiry']);
// 	$date1 = $d1->getTimestamp();
// 	$d2=new DateTime(gmdate("Y-m-d\Th:i:s.000\Z", time()));
// 	$date2 = $d2->getTimestamp();
	
// 	if(isset($tokenExists[0]['tokenExpiry']) && ($date1>$date2)){
// 		$serverAuthDetailsObj = array('TokenID'=>$tokenExists[0]['tokenId'],'TenantID'=>$tokenExists[0]['tenantId']);
// 	}else{
// 		$deleteBouquetAction	=	DB_Update ( array (
// 											'Table' => 'cloudserverdetails',
// 											'Fields' => array (
// 													'tokenStatus' => 'EXPIRED'
// 											)
// 									) );
		
	$deleteExistingTokens	=	DB_Delete(
			array(
					'Table' => 'cloudserverdetails'
			)
	);
		 $serverAuthDetailsObj = initializeAuthentication();
// 	}
	
	return $serverAuthDetailsObj;
}
?>