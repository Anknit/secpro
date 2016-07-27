<?php
/**
* Author: Nitin
* Date: 28-Aug-2015
* Description: This file is used for agent scale operations
*
*/
?>
<?php
error_reporting(E_ALL);
// require_once __DIR__.'/require.php';
require_once __DIR__.'./../Common/php/OperateDB/DbMgrInterface.php';
require_once __DIR__.'./../Common/php/cloudServerAPI.php';
require_once __DIR__.'/AgentOperations/commonServerOperations.php';
require_once __DIR__.'./ControllerNotification/requestMethods.php';
require_once __DIR__.'/../Common/php/ErrorHandling.php';
require_once __DIR__.'/definePaths.php';

if(!isset($raciParam['requestAction']) && isset($_GET)){
	$raciParam	=	$_GET;
}

$action['AgentUp']		=	'AgentOperations/createServer.php';
$action['AgentDown']	=	'AgentOperations/deleteServer.php';

if(isset($raciParam['requestAction']))	{
	require_once	$action[$raciParam['requestAction']];	//Run the logic of corresponding file
}
?>