/*
* Author: Ankit
* date: 21-Feb-2015
* Description: 
*/

$(function(){
	$('#NewPswd').keypress(function(event){
		return nospaceallowed(event);
	});
	$('#confNewPswd').keypress(function(event){
		return nospaceallowed(event);
	});
});

function saveNewPwd(){
	var newPassword = $('#NewPswd').val();
	if(newPassword.length <= 6 || newPassword.length >=20){
		alert(ErrorMessages[11]);
		return false;
	}
	if(newPassword == $('#confNewPswd').val()){
		var updatePwd	=	new Object();
		updatePwd.actionScriptURL	=	'action/updateUserPwd.php?UID='+UID+'&pwd='+newPassword;
		updatePwd.callBack		=	function (Response){
										if(Response == '1'){
											$('#change').css("display",'none');
											$('#SubmitStatus').css("display",'block');
										}
									};
		send_remoteCall(updatePwd);
		return;
	}
	alert(ErrorMessages[12]);
	return false;
}

function redirectToLogin(){
	window.location = "index.php";
}