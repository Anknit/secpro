<?php
/*
 * Author: Ankit
* date: 08-Aug-2014
* Description: This page is displayed when the user select forgot password on the login page 
*/
error_reporting(0);
if(isset($_POST['Submit']))
{
	require_once(NOVA."/UserInterface/sendPwdResetMail.php");
}

if(isset($output))
{
	if($output	===	true) {
		$Elements_DisplayBlock[]	=	'#MailSuccess';
		$Elements_DisplayNone[]		=	'#resetMsg';
		$Elements_DisplayNone[]		=	'#resetPasswordDiv';
	}
	elseif($output	==	'3')
		$Elements_CreateTooltip[]	=	array('Content'=> 'Enter a valid Email address', 'Selector'=>'#UserEmail');
}
?>
<link rel="stylesheet" href="../css/ResetPassword.css" type="text/css" />
<hr style="margin-left: 0px;opacity: 0.5;color: #eee;" />
<div id="resetMsg" align="center">
	<p>
		<strong>Having trouble signing in?</strong><br />
		Enter email address below to receive instructions to reset password
	</p>
</div>
<div id="resetPasswordDiv" align="center">
	<form action="" method="post">
		<table id="emailAddress" cellspacing="5px">
			<tr>
				<td>Email address</td>
				<td>
					<input class="mediumInputBox" title = '<?php echo TITLE1 ;?>' type="email" name="UserEmail" id="UserEmail">
				</td>
			</tr>
			<tr>
			<td>&nbsp;</td>
				<td align="center">
					<button type="submit" name="Submit" class="xxlargeButton" onclick="return checkEmail();">Send Reset Instructions</button>
				</td>
			</tr>
		</table>
	</form>
</div>
<div id ="MailSuccess" style="display:none">
    <p align="center">
        <strong>Reset Instructions Sent !!!</strong><br />
        A link has been sent to your Email address <br />
        Follow the instructions on the link to change your password<br />
    </p>
</div>
<script type="text/javascript" src="../js/ResetPassword.js"></script>