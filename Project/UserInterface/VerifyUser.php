<?php
/*
 * Author: Ankit
* date: 08-Aug-2014
* Description:	This page verifies the login credentials of the signing user.
*/
    require_once __DIR__."./../require.php";
    $queryString 	= $_GET['FormValues'];
    $cleanQuery		= Random_decode($queryString);
    parse_str($cleanQuery);
    $Username		= trim($usname);
	$Password		= trim($pswd);
    $readInput      = array(
				'Table' => 'userinfo',					
				'Fields'=> 'userId, userType, accountId, userStatus',
                                'clause'=> 'userName = "'.$Username.'" AND password = "'.md5($Password).'"'
                               );
        
    $result = DB_Read($readInput, 'ASSOC', '');
    $url	=	"";
    $accountActiveCheck	=	DB_Query("Select accountStatus from accountinfo where accountId = '".$result[0]['accountId']."'","ASSOC","");
    if($accountActiveCheck[0]['accountStatus'] != AC_ACTIVE){
    	$page	=	"Login";
    	$url = Random_encode("err=44");
    }
    else if($result){
	    if($result[0]['userId'] != "" || $result[0]['userStatus'] != '0'){
	    	SetUserLoginSessionVars($result[0]['userId'], $result[0]['userType'], $Username, $result[0]['accountId']);
	    	$d1=new DateTime(gmdate("M d Y H:i:s",time()));
	    	$date1 = $d1->getTimestamp();
	    	DB_Query("INSERT INTO sessioninfo (sessionId, userId, startTime, loginDuration) VALUES('".session_id()."', ".$result[0]['userId'].", ".$date1.", 0)");
//     		DB_Query("INSERT INTO sessioninfo (sessionId, userId, startTime) VALUES('".session_id()."', ".$result[0]['userId'].", ".time().") ON DUPLICATE KEY UPDATE sessionId=VALUES(sessionId), startTime=VALUES(startTime)");
	    	$page	=	"Home";
	    }

    }
    else{
    	$page	=	"Login";
    	$url = Random_encode("err=43");
    }
    RedirectTo($page, $url);
?>