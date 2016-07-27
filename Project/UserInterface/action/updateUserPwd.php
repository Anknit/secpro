<?php
/*
* Author: Ankit
* Date: 12-Aug-2014
* Description: This is the page from where the new password of the 
* 				user will get updated in the DB.
*/

require_once __DIR__."./../../../Common/php/OperateDB/DbMgrInterface.php";

$Output	=	0;
if($_GET['pwd'] != NULL && $_GET['pwd'] != "") {
	if(DB_Update(array(	'Table'		=> 'userinfo',					
							'Fields'	=> array (							
											'password'	=> md5($_GET['pwd']),
											),
							'clause'	=> 'userId = '.$_GET['UID']
		)		  )		){
		$Output	=	1;
	}
}
echo $Output;