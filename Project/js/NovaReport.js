/*
* Author: Ankit
* date: 21-Jan-2015
* Description: This defines methods which are common but for some reason are still nova specific
*/

$(function(){
	if(OperatorList.length < 1){
		$('#autoReportFrequency').attr('disabled','disabled');
		$('.noOperatorInitMsg').css('display','table-row');
	}
	if(autoReportFreq != ''){
		$('#autoReportFrequency').val(autoReportFreq);
	}
	fetchTimezoneSettings();
	if(parseInt(timezoneSettingsObj['timezoneId']) != ''){
		$('#systemTimezone').val(parseInt(timezoneSettingsObj['timezoneId']));
	}
});
var saveAutoReportSettings	=	function (){
	var mailFreq	=	$('#autoReportFrequency').val();
	ajaxRequestObject.actionScriptURL	=	'./../InterfaceToDatabaseUpdates.php?Operation=ReportSetting&frequency='+mailFreq;
	ajaxRequestObject.sendMethod	=	'GET';
	ajaxRequestObject.responseType	=	1;
	ajaxRequestObject.callBack	=	function(Response){
		deloadImage();
		var defaultCheck = checkResponseUrl(Response);
		if(defaultCheck){
			Response	=	Response.responseText;
			if(Response==0 || Response=='0')
				refreshdata('HomePageAutoReport#15');
			else{
				erMsg	=	'Automated Report configuration failed';
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
};
var saveTimezoneSettings	=	function(){
	var timeZoneVal	=	$('#systemTimezone').val();
	ajaxRequestObject.actionScriptURL	=	'./../InterfaceToDatabaseUpdates.php?Operation=ReportSetting&timezone='+timeZoneVal;
	ajaxRequestObject.sendMethod	=	'GET';
	ajaxRequestObject.responseType	=	1;
	ajaxRequestObject.callBack	=	function(Response){
		deloadImage();
		var defaultCheck = checkResponseUrl(Response);
		if(defaultCheck){
			Response	=	Response.responseText;
			if(Response==0 || Response=='0')
				refreshdata('HomePageTimezoneSetting#21');
			else{
				erMsg	=	'Timezone settings update failed';
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
};

var fetchTimezoneSettings	=	function(){
			if(IsValueNull(TimezoneTableData)){
				return false;
			}
			var innerDataForTimeZone = '';
			for(var key in TimezoneTableData){
				innerDataForTimeZone += '<option value="'+TimezoneTableData[key].timezoneId+'">(UTC '+TimezoneTableData[key].zoneOffset+') '+TimezoneTableData[key].zoneName+'</option>';
			}
			
			$('#systemTimezone').append(innerDataForTimeZone);

};