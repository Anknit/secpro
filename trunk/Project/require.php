<?php
/*
* Author: Aditya
* date: 08-Aug-2014
* Description: This is required to be included to include basic functional files e.g. DBMgr.php.  If there exists a file which is in general required most of the times e.g. for permission set or constant defining class, then all such files should be included into this file.
*
*/
    require_once __DIR__.'./../config.php';	//This has some neccessary variables which define permissions for different users. Hence included at the top
    require_once __DIR__.'/definitions.php';	//This has some neccessary variables which define permissions for different users. Hence included at the top
	require_once __DIR__.'/PermissionSets.php';	//This has some neccessary variables which define permissions for different users. Hence included at the top
	require_once __DIR__.'./../Common/php/SessionManager.php';
	SM_StartSession();

	//if session setup_root is not set, then set its value
	if(!isset($_SESSION['SETUP_ROOT'])){	
		$_SESSION['SETUP_ROOT'] = str_replace(PROJECT,"",__DIR__); 
	}
	//if session HTTP_ROOT is not set, then set its value
	if(!isset($_SESSION['HTTP_ROOT'])){	
		$_SESSION['HTTP_ROOT'] = strstr(str_replace(basename(__FILE__), "", "http".(!empty($_SERVER['HTTPS'])?"s":"")."://".$_SERVER['SERVER_NAME'].':'.$_SERVER['SERVER_PORT'].$_SERVER['SCRIPT_NAME']), PROJECT, true);
	}
	//if session HTTP_ROOT is not set, then set its value
	if(!isset($_SESSION['SERVER_ROOT'])){	
		$_SESSION['SERVER_ROOT'] = "http".(!empty($_SERVER['HTTPS'])?"s":"")."://".$_SERVER['SERVER_NAME'].':'.$_SERVER['SERVER_PORT'];
	}
	require_once __DIR__.'/toolTipMessage.php';
	require_once __DIR__.'/UserSpecificPermissions.php';	//This has variables that defines user specific permissions
    require_once __DIR__.'./../Common/php/OperateDB/DbMgrInterface.php';
?>
