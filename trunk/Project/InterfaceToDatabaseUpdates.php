<?php
/*
* Author: Ankit	
* date: 06-Feb-2015
* Description: 
*
*/

require_once __DIR__.'/require.php';
require_once 'ControllerNotification/requestMethods.php';

function getFieldsList($Arraydefined)
{
	$List	=	"";
	$List	=	implode(',', $Arraydefined);
}

if(isset($_SERVER['QUERY_STRING']))
{
	$Output	=	SetErrorCodes(0, __LINE__,  __FILE__);
	//For all the backend processes, define an elment in below array
	$OperationTable['UserInfo']			=	'LogicsToUpdateDB/UserActions.php';
	$OperationTable['NodeInfo']			=	'LogicsToUpdateDB/NodeActions.php';
	$OperationTable['AgentInfo']		=	'LogicsToUpdateDB/AgentActions.php';
	$OperationTable['ChannelInfo']		=	'LogicsToUpdateDB/ChannelActions.php';
	$OperationTable['ProfileInfo']		=	'LogicsToUpdateDB/ProfileActions.php';
	$OperationTable['BouquetInfo']		=	'LogicsToUpdateDB/BouquetActions.php';
	$OperationTable['TemplateInfo']		=	'LogicsToUpdateDB/TemplateActions.php';
	$OperationTable['ReportSetting']	=	'LogicsToUpdateDB/ReportSettings.php';
	$OperationTable['MonitorSetting']	=	'LogicsToUpdateDB/MonitorSettings.php';
	$OperationTable['PaymentInfo']		=	'LogicsToUpdateDB/PaymentActions.php';
	$OperationTable['AlertSettings']	=	'LogicsToUpdateDB/AlertSettings.php';
	
	$cleanQuery			= $_SERVER['QUERY_STRING'];
	parse_str($cleanQuery);
	if(isset($OperationTable[$Operation]))
	{
		require_once	$OperationTable[$Operation];	//Run the logic of corresponding file
	}
	echo $Output;
}
?>