function checkEmail(){
	var EmailAdd = $('#UserEmail').val();
	if(EmailAdd == "" || EmailAdd == undefined || EmailAdd == null){
		$("#UserEmail").jqxTooltip({ content: ErrorMessages[9],  position: 'right',  left: 10, name: 'testTooltip',theme:JQXTHEME});
		$("#UserEmail").jqxTooltip('open');
        $("#UserEmail").jqxTooltip('close',500);
		return;
	}
/*	var resetPwd	=	new Object();
	resetPwd.actionScriptURL	=	'sendPwdResetMail.php?user='+EmailAdd;
	resetPwd.callBack		=	function (Response){
									if(Response == 'mail_send'){
										$('#resetMsg').css("display",'none');
										$('#emailAddress').css("display",'none');
										$('#resetCode').css("display",'');
										$('#codeSentMsg').css("display",'');
									}
									else if(Response == 'user_not_exist'){
										$("#UserEmail").jqxTooltip({ content: 'Enter a valid Email address',  position: 'right',  left: 10, name: 'testTooltip',theme:JQXTHEME});
										$("#UserEmail").jqxTooltip('open');
								        $("#UserEmail").jqxTooltip('close',500);
										return;
									}
								};
	send_remoteCall(resetPwd);
*/}

function validateCode(){
	var EnteredCode = $('#enterCode').val();
	if(EnteredCode != '1234'){
		$("#enterCode").jqxTooltip({ content: ErrorMessages[16],  position: 'right',  left: 10, name: 'testTooltip',theme:JQXTHEME});
		$("#enterCode").jqxTooltip('open');
        $("#enterCode").jqxTooltip('close',500);
		return;
	}
	window.location = 'changePassword.php';
	
}