var saveLayoutSettings	=	function(){
	loadImage();
	var monitorSettingObj	=	new Object();
	var userRows	=	$('#operatorMonitorSetting').find('tr.userEntry');
	for(var f=0; f<userRows.length;f++){
		monitorSettingObj[userRows.eq(f).attr('id')]	=	userRows.eq(f).find('.layout-opt.selected').attr('value');
	}
	ajaxRequestObject.actionScriptURL	=	'./../InterfaceToDatabaseUpdates.php?Operation=MonitorSetting&settingObj='+JSON.stringify(monitorSettingObj);
	ajaxRequestObject.sendMethod	=	'GET';
	ajaxRequestObject.responseType	=	1;
	ajaxRequestObject.callBack	=	function(Response){
		deloadImage();
		var defaultCheck = checkResponseUrl(Response);
		if(defaultCheck){
			Response	=	Response.responseText;
			if(Response==0 || Response=='0')
				refreshdata('HomePageMonitor#17', true);
			else{
				erMsg	=	'Layout Settings configuration failed';
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

$(function(){
	callBacksFirstLevel.setLayoutHover	=	function(){
		$('#menuBar li[value="Layouts"]').off('hover');	
		$('#menuBar li[value="Layouts"]').hover(function(){popUpModalDivForLayoutSettings();},function(){});
		$('#layout-setting-modal').hover(function(){},function(){hideLayoutPopup();});
		$('#layout-setting-modal').css({'transition':'opacity linear 0.25s,font-size linear 0.25s'});
	};
var tableBody = '';
if(regUserType == '2'){
	if(OperatorSetting != ''){
		for(var key in OperatorSetting){
			tableBody += '<tr class="userEntry" id="'+key+'"><td>'+username+'</td><td><div class="layoutOptionDropdown"><div value="1" class="layout-opt';
			if(OperatorSetting[key] == '1'){
				tableBody += ' selected';
			}
			tableBody += '">Default</div><div value="2" class="layout-opt';
			if(OperatorSetting[key] == '2'){
				tableBody += ' selected';
			}
			tableBody += '">Consolidated</div><div value="3" class="layout-opt';
			if(OperatorSetting[key] == '3'){
				tableBody += ' selected';
			}
			tableBody += '">Enhanced</div><div value="4" class="layout-opt';
			if(OperatorSetting[key] == '4'){
				tableBody += ' selected';
			}
			tableBody += '">Enhanced v2</div></div></td></tr>';
		}
	}
	$('#operatorMonitorSetting').find('tbody').prepend(tableBody);	
	$('#operatorMonitorSetting tr.userEntry .layout-opt').on('click',function(event){
		$('.layout-opt.selected').removeClass('selected');
		$(this).addClass('selected');
		saveLayoutSettings();
	});

}
});
var popUpModalDivForLayoutSettings = function(){
	$('#layout-setting-modal').css({'font-size':'12px','opacity':'1','margin-left':'-15px','padding-left':'15px','margin-top':'-35px','padding-top':'35px',});
	$('.layout-opt').css({'padding':'5px 20px 5px 10px'});
	$('[assocdiv="HomePageLayoutSetting"]').css({'border-color':'#999'})
};
var hideLayoutPopup = function(){
	$('#layout-setting-modal').css({'font-size':'0px','opacity':'0','margin-left':'0px','padding-left':'0px','margin-top':'0px','padding-top':'0px',});
	$('.layout-opt').css({'padding':'0px'});
	$('[assocdiv="HomePageLayoutSetting"]').css({'border-color':''})
};