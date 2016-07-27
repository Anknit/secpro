2<?php
/*
 * Author: Ankit
* date: 08-Aug-2014
* Description: This page update the profile info of the user 
*/

require_once __DIR__."./../../require.php";

$queryString 	= $_GET['RegisterValues'];
$cleanQuery		= Random_decode($queryString);
parse_str($cleanQuery);
$userStatus = '1';	//

$updateInput 	= array(
						'Table'=> 'userinfo',					
						'Fields'=> array (							
								'userStatus'	=>$userStatus,
								'name'			=>$fname.' '.$lname,
								'address'		=>$add,
								'city'			=>$city,
								'country'		=>$country,
								'pincode'		=>$pin,
								'organization'	=>$org,
								'website'		=>$csite,
								'phoneOffice'	=>$offPhone,
								'phonePersonal'	=>$persPhone
						),  
						'clause' => 'userId = "'.$userID.'"'
);

if($usrStatus	==	'0')	//If user completes registration for first time, the status is unverified, so update password if it is not blank
{
	if($pwd	==	'') {
		$Output	=	SetErrorCodes(1 , __LINE__ , __FILE__);	//User has not set the password which was mandatory
		$page	=	"Login";
		$url = Random_encode('err='.$Output);
		RedirectTo($page, $url);
		exit();
	}
	else {
		$updateInput['Fields']['password']	=	md5($pwd);
	}
}
else {
	if($pwd	!=	'') {
		$updateInput['Fields']['password']	=	md5($pwd);
	}
}

$result = DB_Update($updateInput);
if($result){
	//Read user details from database to set session variables for this user	
	 $userInfo = DB_Read(array(
							'Table'=> 'userinfo',					
							'Fields'=> '*',  
							'clause' => 'userId = "'.$userID.'"'
							 ),'ASSOC','' );
	 $userInfoResult	=	$userInfo[0];
 
	//Set session variables when a new user completes the registration			
	 if($result && $result[0]['userId'] != "" && $result[0]['userStatus'] == '1' && !isset($_SESSION['UserID'])) {
		SetUserLoginSessionVars($userInfoResult['userId'], $userInfoResult['userType'], $userInfoResult['userName'], $userInfoResult['accountId']);
	 }
	$url	=	''; 
	if($usrStatus	==	'0'){	//If user completes registration for first time, the status is unverified
		if($userInfoResult['userType'] == ADMIN){
			$acActiveResult	=	DB_Query("Update accountinfo SET accountStatus = '".AC_ACTIVE."' where accountId = '".$userInfoResult['accountId']."'");
			if(!$acActiveResult)
				$url = Random_encode("err=45");
		}
		$page	=	"Logout";
	}
	else{
		$page	=	"Home";
		setcookie('tab','personalInfoDiv#11',time()+5);
	}

}
else{
	$page	=	"Login";
	$url = Random_encode("err=1");
}
RedirectTo($page, $url);