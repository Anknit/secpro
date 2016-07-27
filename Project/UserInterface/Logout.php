<?php
/*
 * Author: Aditya
* date: 13-Aug-2014
* Description: Login is the landing page in user driven mode
*/
error_reporting(0);
require_once '../require.php';
require_once '../ControllerNotification/requestMethods.php';

$d1=new DateTime(gmdate("M d Y H:i:s",time()));
$date1 = $d1->getTimestamp();
DB_Query('UPDATE sessioninfo SET endTime = "'.$date1.'" WHERE sessionId ="'.session_id().'" AND userId = "'.$_SESSION['userID'].'" ORDER BY sessionPrimaryKey DESC LIMIT 1');

$controllerResponse	=	NOVA_COMMUNICATION('notify',array('type'=>'logout','id'=>$_SESSION['userID']));
if($controllerResponse !== 0 && $controllerResponse !== '0'){
	$Output	=	$controllerResponse;
	SetErrorCodes($controllerResponse, __LINE__,  __FILE__);
}
function unset_all_vars($a)
{ 
	foreach($a as $key => $val)
  	{
		if(isset($GLOBALS))
			unset($GLOBALS[$key]);
	}
  return serialize($a); 
}
if(isset($_COOKIE['tab']))
	 	setcookie("tab", "", time()-3600);
session_destroy();	//destroy all the session variable
unset_all_vars(get_defined_vars());	//unset all the variable (memory free)
RedirectTo('Login');//redirect to home page
?>