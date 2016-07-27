<?php
/*
 * Author: Ankit
* date: 08-Aug-2014
* Description: Login is the landing page in user driven mode
*/
@extract($_GET);
$queryString 	= $_SERVER['QUERY_STRING'];
$cleanQuery		= Random_decode($queryString);
parse_str($cleanQuery);
//require_once __DIR__.'./../../../Common/php/phpcaptcha/phpCaptcha.php';;
if(!isset($_SESSION)){
	session_start();
}
// if(isset($_POST['Submit'])){
// 	// code for check server side validation
// 	if(empty($_SESSION['captcha_code'] ) || strcasecmp($_SESSION['captcha_code'], $_POST['captcha_code']) != 0){  
// 		$msg="<span style='color:red'>The Validation code does not match!</span>";// Captcha verification is incorrect.		
// 	}else{// Captcha verification is Correct. Final Code Execute here!		
// 		$msg="<span style='color:green'>The Validation code has been matched.</span>";		
// 	}
// }	

if(isset($FormValues)) {
	require_once __DIR__.'./../VerifyUser.php';
}
if(isset($_SESSION['userID']))
	RedirectTo('Home');
	
if(isset($err) && $err != ''){$CustomHtml['#Status']	=	getErrorMessage($err);}
?>
<link rel="stylesheet" href="../css/Login.css" type="text/css" />
<hr style="margin-left: 0px;opacity: 0.5;color: #eee;" />
<div style="padding: 1%;" align="center">
    <form id="LoginForm" action="">
        <fieldset style="height: 260px">
            <legend style="font-color; opacity:0.7" align="center">Sign in</legend>
                <table class="Login" style="height:100%">
                    <tr>
                        <td>Email</td>
                        <td><input class="mediumInputBox" title = '<?php echo TITLE1 ;?>' type="text" id="usname" name="usname" /></td>
                    </tr>
                    <tr>
                        <td>Password</td>
                        <td><input class="mediumInputBox" title = '<?php echo TITLE2 ;?>' type="password" id="pswd" name="pswd" /></td>
                    </tr>
                    <tr>
                        <td colspan="2" align = 'center'>
					        <input type="hidden" name="FormValues" id="FormValues" value="" />
                        	<button type="submit" class="largeButton" id="loginButton" onClick="return Login();">Login</button>
                        </td>
                    </tr>
                    <tr>
                    	<td colspan="2" align="center" style="font-size: small">
                    		<a title = '<?php echo TITLE3 ;?>' href="ForgotPassword.php" style="margin-left: 5px">
                                Forgot Password?  
                            </a>
                    	</td>
                    </tr>
                </table>
        </fieldset>
    </form><!--
    <input type="submit" value="Sign Up" class="largeButton" id="signUpButton" onClick="return signUp();">
--></div>
<!--<div id='signUpModal'>
	<div id='signUpDiv' onclick="closeModalDiv(event);">
		<form>
			<table>
				<tr>
					<td>
						<label for='signUpEMail' class='inputLabel'>Email</label>
					</td>
					<td>
						<input type='email' class='mediumInputBox' id='signupEmail' name='signupEmail' />
					</td>
				</tr>
				<?php if(isset($msg)){?>
	    		<tr>
	     	 		<td colspan="2" align="center" valign="top"><?php echo $msg;?></td>
	    		</tr>
	    		<?php } ?>
	    		<tr>
	     			<td align="right" valign="top">Validation code:</td>
	      			<td>
	      				<img src="./../../Common/php/phpcaptcha/phpCaptcha.php?rand=<?php echo rand();?>" id='captchaimg'><br>
				        <label for='message'>Enter the code above here :</label>
	        			<br>
	        			<input id="captcha_code" name="captcha_code" type="text">
				        <br>
	        			Can't read the image? click <a href='javascript: refreshCaptcha();'>here</a> to refresh.
	        		</td>
		    	</tr>
			    <tr>
	      			<td colspan='2'>
						<input type="submit" class='largeButton' onclick='return signUpUser();'>
			      </td>
	    		</tr>
			</table>
		</form>
	</div>
</div>
<script>
function refreshCaptcha(){
	var img = document.images['captchaimg'];
	img.src = img.src.substring(0,img.src.lastIndexOf("?"))+"?rand="+Math.random()*1000;
}
</script>-->
<div id="Status" align="center"></div>
<script type="text/javascript" src="../js/Login.js"></script>
