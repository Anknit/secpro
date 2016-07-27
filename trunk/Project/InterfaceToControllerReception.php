<?php
/*
* Author: Ankit	
* date: 25-May-2015
* Description: 
*
*/

// require_once __DIR__.'/require.php';
//require_once 'ControllerReception/reportMailing.php';
require_once __DIR__.'/ErrorMessages.php';
require_once __DIR__.'/../Common/php/commonfunctions.php';

extract($_GET); //The parameters will be recieved via getRaciParameters()
$raciParam	=	getRaciParameters();

global $Output;	
$Output	=	SetErrorCodes(0, __LINE__,  __FILE__);
//For all the backend processes, define an elment in below array

$OperationTable['SendMail']				=	'InterfaceToSendMails.php';
$OperationTable['ControlAgentSystem']	=	'InterfaceToAgentOperations.php';	//for this operation there shall be two different actions, agent start/agent shutdown

if(isset($OPERATION_NAME))
{
	require_once	$OperationTable[$OPERATION_NAME];	//Run the logic of corresponding file
}
echo $Output;
?>