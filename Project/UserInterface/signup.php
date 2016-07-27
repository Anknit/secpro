<?php 
// if(!isset($_SESSION))
// 	session_start();
	
require_once './../require.php';

if(isset($_GET['Submit'])){
	if(empty($_SESSION['captcha_code'] ) || strcasecmp($_SESSION['captcha_code'], $_GET['captcha_code']) != 0){
		$Output = 1;
	}
	else{
		$Output = 0;
		$Module['UserManagement']		=	true;
		$autoSignFlag	=	true;		
		require_once './../LogicsToUpdateDB/UserActions.php';
	}
	echo $msg;
}
?>