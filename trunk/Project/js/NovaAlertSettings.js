/*
* Author: Nitin Aloria
* date: 05-August-2015
* Description: This defines methods required for automated email alerts settings
*/

$(function(){
	$('#alertFrequency').val(ErrorAlertSetting[0]['interval']);
	$('#errorThreshold').val(ErrorAlertSetting[0]['errorLimit']);
	$('#errorAlertEmail').val(ErrorAlertSetting[0]['recipentEmailIds']);
});
var saveAutoAlertSettings	=	function (){
	var alertMailArr	=	$('#alertFrequency, #errorThreshold, #errorAlertEmail').map(function(){ return this.value;});
	var validateFlag = validateAutoAlertSettings(alertMailArr);
	if(validateFlag){
		alertMailArr[2] = alertMailArr[2].replace(/\s+/g,'');
		ajaxRequestObject.actionScriptURL	=	'./../InterfaceToDatabaseUpdates.php?Operation=AlertSettings&alertFrequency='+alertMailArr[0]+'&errorThreshold='+alertMailArr[1]+'&errorAlertEmail='+alertMailArr[2];
		ajaxRequestObject.sendMethod	=	'GET';
		ajaxRequestObject.responseType	=	1;
		ajaxRequestObject.callBack	=	function(Response){
			deloadImage();
			var defaultCheck = checkResponseUrl(Response);
			if(defaultCheck){
				Response	=	Response.responseText;
				if(Response==0 || Response=='0')
					refreshdata('HomePageAlertSettings#23');
				else{
					erMsg	=	'Automated Alert configuration failed';
					if(Response.indexOf('||') != -1){
						erCode	=	Response.split('||')[1];
						if(SoapErrorMessages[erCode] != '')
							erMsg	=	SoapErrorMessages[erCode];
					}
					AlertMessage({msg:erMsg});
				}
			}
		};
		send_remoteCall(ajaxRequestObject);
		ajaxRequestObject	=	{};
	}
};

var validateAutoAlertSettings = function(alertMailArr){
	var output = true;
	if((alertMailArr[0] < ErrorAlertFrequencyRange[0] || alertMailArr[0] > ErrorAlertFrequencyRange[1]) || (alertMailArr[1] < ErrorAlertThresholdRange[0] || alertMailArr[1] > ErrorAlertThresholdRange[1])){
		erMsg = 'Values out of range.';
		AlertMessage({msg:erMsg});
		output = false;
	}else if(alertMailArr[2] != ''){
		var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,6})?$/;
		var emailArr = alertMailArr[2].split(',');
		for(var x in emailArr){
			output = emailReg.test(emailArr[x].trim());
			if(!output){
				erMsg = 'Please enter a valid email address.';
				AlertMessage({msg:erMsg});
				break;
			}
		}		
	}


	return output;
};