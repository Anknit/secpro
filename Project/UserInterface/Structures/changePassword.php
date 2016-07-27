<?php
/*
 * Author: Ankit
* date: 08-Aug-2014
* Description: This page is displayed when the user is redirected to change the password 
*/
error_reporting(0);
$queryString	=	$_SERVER['QUERY_STRING'];
$cleanQuery		= 	Random_decode($queryString);
parse_str($cleanQuery);
$user = $UID;
if($user == '' || $user == null){
   	$page	=	"Login";
   	$url	=	"";
	RedirectTo($page, $url);
}
?>
<script>
	var UID	=	<?php echo json_encode($user);?>
</script>
<link rel="stylesheet" href="../css/changePassword.css" type="text/css" />
<hr style="margin-left: 0px;opacity: 0.5;color: #eee;" />
<div id = 'change'>
	<form>
		<table>
			<tr>
				<td align="right">
                	Choose new password
				</td>
				<td>
					<input class="mediumInputBox" title = '<?php echo TITLE14 ;?>' type="password" id="NewPswd">
				</td>
			</tr>
			<tr>
				<td align="right">
                	Confirm password
				</td>
				<td>
					<input class="mediumInputBox" type="password" id="confNewPswd">
				</td>
			</tr>
			<tr>
				<td>
				</td>
				<td>
					<button type="button" class="xxlargeButton" id="chngPwd" onclick="saveNewPwd();">Change password</button>
				</td>
			</tr>
		</table>
	</form>
</div>
<div id="SubmitStatus" style="display:none">
	<strong>Password changed Successfully !!!</strong><br />
	Click on the button below to login<br />
	<button type="button" class="largeButton" id="gotoLogin" onclick="redirectToLogin();">Login</button>
</div>
<script type="text/javascript" src="../js/changePassword.js"></script>