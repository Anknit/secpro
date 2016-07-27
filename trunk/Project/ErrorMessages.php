<?php
/*
* Author: Ankit
* date: 08-Mar-2015
* Description: This defines some common functions required throughout the project
*
*/

// PLEASE DO NOT USE INDEX 41 IT IS USED FOR DYNAMIC PURPOSE 
$ErrorCodes[0]	= array('ErrorMessage'	=>	'All requests have been completed successfully');
$ErrorCodes[1]	= array('ErrorMessage'	=>	'User has not set the password which was mandatory');
$ErrorCodes[2]	= array('ErrorMessage'	=>	'Duplicate Url Detected');
$ErrorCodes[3]	= array('ErrorMessage'	=>	'There is no file for verification of Url');
$ErrorCodes[4]	= array('ErrorMessage'	=>	'No media file found');
$ErrorCodes[5]	= array('ErrorMessage'	=>	'Network Error');
$ErrorCodes[6]	= array('ErrorMessage'	=>	'Media file is not valid');
$ErrorCodes[7]	= array('ErrorMessage'	=>	'No data in database');
$ErrorCodes[8]	= array('ErrorMessage'	=>	'No agent available for monitoring task');
$ErrorCodes[9]	= array('ErrorMessage'	=>	'Invalid Report Path');
$ErrorCodes[10]	= array('ErrorMessage'	=>	'Invalid template XML');
$ErrorCodes[11]	= array('ErrorMessage'	=>	'Web Notificatio type is undefined');
$ErrorCodes[24]	= array('ErrorMessage'	=>	'Database is disconnected');
$ErrorCodes[25]	= array('ErrorMessage'	=>	'Database Query failed');
$ErrorCodes[31]	= array('ErrorMessage'	=>	'Duplicate entry in database');
$ErrorCodes[40]	= array('ErrorMessage'	=>	'Unable to send password reset mails');
$ErrorCodes[42]	= array('ErrorMessage'	=>	'No sources found for EventID list while sending reminder mails for event scheduled');
$ErrorCodes[43]	= array('ErrorMessage'	=>	'Incorrect Username or password. Please re-enter your credentials');
$ErrorCodes[44]	= array('ErrorMessage'	=>	'Your Status is Inactive. Please contact your Registering Authority');
$ErrorCodes[45]	= array('ErrorMessage'	=>	'Your Account is Inactive. Please contact your Registering Authority');

// PLEASE DO NOT USE INDEX 41 IT IS USED FOR DYNAMIC PURPOSE

function getErrorMessage($ErrorNumber)
{
	global $ErrorCodes;
	if($ErrorNumber != '') {
		return $ErrorCodes[$ErrorNumber]['ErrorMessage'];
	}
}

function SetErrorCodes($Output, $LineNumber, $FileName, $writeLog = 1)
{
	global $ErrorCodes;
	if($Output != '1' && $Output != '0' && $writeLog == 1) {
		ErrorLogging($Output.' near line number '.$LineNumber.' in '.$FileName);
	}
	return $Output;
}
?>
