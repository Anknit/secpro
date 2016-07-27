<?php
/*
* Author: Ankit
* Date: 12-Aug-2014
* Description: This is the page from where the password reset mail
*  			   is generated and send to the user.
*/

require_once("../../Common/php/MailMgr.php");

$Username = $_POST['UserEmail'];
$userExist 	= array(
		                'Table'=> 'userinfo',					
		                'Fields'=> '*',
		                'clause'=> 'userName = "'.$Username.'"'
		          );
$result = DB_Read($userExist, 'ASSOC', '');
if($result != 0){ 	// valid email address
	$details = $result[0];
	$UserID = $details['userId'];
	$MailBody	=	"<table>
						<tr>
							<td>
								Hi please click on link to reset your password.
								<br />
								<a href = '".$_SESSION['HTTP_ROOT']."/NOVA/UserInterface/changePassword.php?".Random_encode("UID=".$UserID)."'>Reset Password</a>
							</td>
						</tr>
					</table>";
	$mailResult	=	send_Email($Username, "Reset Password NOVA" , $MailBody);
	if($mailResult){
		$output	=	true;
	}
}
else
{
	$output	=	SetErrorCodes(40, __LINE__,  __FILE__);
}
?>