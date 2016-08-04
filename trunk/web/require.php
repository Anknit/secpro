<?php
    require_once __DIR__.'./../config.php';	//This has some neccessary variables which define permissions for different users. Hence included at the top
    require_once __DIR__.'/definitions.php';	//This has some neccessary variables which define permissions for different users. Hence included at the top
	require_once __DIR__.'./../Common/php/SessionManager.php';
    require_once __DIR__.'./../Common/php/OperateDB/DbMgrInterface.php';
	SM_StartSession();
?>
