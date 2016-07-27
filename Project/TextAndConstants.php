<?php
/*
* Author: Aditya
* date: 08-Aug-2014
* Description: This defines different texts as constants
*
*/
//Texts displayed in User interface
define('UserTableCaption',	'User Details');
define("COPYRIGHT",	'<b>Copyright © 2015 Venera Technologies Pvt. Ltd.<br />All rights reserved.</b>');
define('NOVAVersion',	'Version: 1.0 (beta)');
define('TemplateVersion',	1);

define('installerFileName',	'Nova.exe');
define('installerGuideFileName','NOVAInstallationGuide.pdf');
define('ReleaseNotesFileName', 'ReleaseNotes.pdf');

//Below are the variables and constants that are used globally across scripts but their value needs to be populated at run time
$systemDetails 	= getInfoFrom('retreive_data', 'systemSettings');
$systemDetailsCount	=	count($systemDetails);	

?>
