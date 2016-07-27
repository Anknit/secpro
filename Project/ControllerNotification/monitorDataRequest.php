<?php
/*
* Author: Ankit	
* date: 26-Feb-2015
* Description: 
*
*/
error_reporting(0);
require_once '../require.php';
require_once 'requestMethods.php';

function updateSessionInfo($userId,$loginUpdateConst){
	$updateEndTime = DB_Query('UPDATE sessioninfo SET loginDuration = loginDuration +'.$loginUpdateConst.' WHERE userId = '.$userId.' AND sessionId	= "'.session_id().'" ORDER BY sessionPrimaryKey DESC LIMIT 1');
}

if(isset($_SERVER['QUERY_STRING']))
{
	$cleanQuery			= $_SERVER['QUERY_STRING'];
	parse_str($cleanQuery);
	if(isset($userId)&& isset($Operation))
	{
		if($Operation == 'TN'){
			$response	=	NOVA_COMMUNICATION('monitor',array('type'=>'TN-data','userID'=>$userId));
			if($response != '' && $response != null && $response->vecOfString != null){
				echo json_encode($response->vecOfString);
			}			
		}
		if($Operation == 'ERR'){
			if(isset($loginUpdateConst) && $loginUpdateConst != ''){
				updateSessionInfo($userId,$loginUpdateConst);
			}
			$response	=	NOVA_COMMUNICATION('monitor',array('type'=>'error-data','userID'=>$userId));
			if($response != '' && $response != null && $response->vecOfString != null){
				echo json_encode($response->vecOfString);
			}			
		}
		if($Operation == 'DASH'){
			$response	=	NOVA_COMMUNICATION('dashboard',array('userID'=>$userId,'channelIdList'=>$chList,'startTime'=>$st,'endTime'=>$et));
			if($response != '' && $response != null){
				echo json_encode($response->Res);
			}			
		}
	}
}
?>