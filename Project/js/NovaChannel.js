var channelScheduleData	;
var lastSelScheduleRow	=	'';
var currentTemplateID	=	0;
var currentprofileStateStr	=	'';
var editFlag	=	false;
$(function(){
	$('#repeatForeverCheckBox').jqxCheckBox({width:80, height:10, boxSize:"10px" });
	if(ChannelTableData != '' && ChannelTableData != null){
		generateChannelTable(ChannelTableData);
	}
	$('#nodeListSelect').val('1');
	if(TemplateList != '' && TemplateList != null){
		for(var key in TemplateList){
			$('.mapTemplateList').append('<option value="'+key+'">'+TemplateList[key]['templateName']+'</option>');
		}
	}
	$('#channel_edit_form').jqxWindow({height: 400, width: 1150, isModal: true, autoOpen: false });
//	$('#channel_edit_form').on('open', function(event){ResizeModal(event);});

	$('#templateListSelect').val('1');
//	$('.jqxRadioButton').jqxRadioButton({ width: 150, height: 25});
//	$('.jqxRadioButton.checked').jqxRadioButton({checked: true});
//	$("#timeZoneOffset").jqxDropDownList({ width: 200, height: 25, selectedIndex:0});
//	$('#timeZoneOffset').jqxDropDownList('loadFromSelect', 'timezoneSelect');
/*	$('#timeZoneOffset').on('change',function(event){
		$(this).attr('title',$('#timeZoneOffset').text());
	});
*/	$('#editChannelTabContainer').jqxTabs({ height: '80%', width:  '100%' });
	$('.dateTimeInput').jqxDateTimeInput({ width: '150px', height: '25px', formatString: "yyyy-MM-dd HH:mm:ss" });
//	$('.dateTimeInput').each(function(){$(this).val(null);});
//	$("#scheduleRepeatDropDown").jqxDropDownList({ width: 200, height: 25,autoDropDownHeight: true, selectedIndex:0});
//	$("#scheduleRepeatDropDown").jqxDropDownList('loadFromSelect', 'scheduleRepeat');
	$('.weekdayContainer').find('span').on('click',function(){
		if($(this).hasClass('repeatOnDay')){
			if($('.repeatOnDay').length>1)
				$(this).removeClass('repeatOnDay');
			else{
				AlertMessage({msg:'Choose at least one day of week'});
			}
		}
		else{
			$(this).addClass('repeatOnDay');
		}
		changeWeekDayTitle();
	});
	$('#editChannelTabContainer').on('tabclick', function (event) { 
		renderChannelScheduleData();
	});
/*	$('#channel_add_form').on('open', function(event){
		$('.jqxRadioButton.checked').click();
		$('tr.scheduleInput').css("display","none");
		$('#nodeListSelect').find('option').eq(0).attr('selected','selected');
		$('#templateListSelect').find('option').eq(0).attr('selected','selected');
		$("#scheduleRepeatDropDown").jqxDropDownList('selectedIndex',0);
	});
*/});

function changeWeekDayTitle(){
	$('.weekdayContainer').find('span[data-day]').each(function(){
		if($(this).hasClass('repeatOnDay'))
			$(this).attr('title','Remove repeat on '+$(this).attr('data-dayName'));
		else
			$(this).attr('title','Click to repeat on '+$(this).attr('data-dayname'));
	});
}

// To save channle email alert error settings
var saveAlertCheckbox = function(elem){
	var channelId = $(elem).attr('channelId');
	var elemVal = $(elem).prop('checked');
	var checkVal = elemVal?1:0;
	
	ajaxRequestObject.actionScriptURL	=	'./../InterfaceToDatabaseUpdates.php?Operation=ChannelInfo&cat=emailAlert&channelId='+channelId+'&checkVal='+checkVal;
	ajaxRequestObject.sendMethod	=	'GET';
	ajaxRequestObject.responseType	=	1;
	ajaxRequestObject.callBack	=	function(Response){
		var defaultCheck = checkResponseUrl(Response);
		if(defaultCheck){
			Response	=	Response.responseText;
			if(Response == 0 || Response == "0"){
				AlertMessage({msg:'Source updated properly',error:0});
			}else{
				AlertMessage({msg:'Source not updated properly'});
			}	
		}
	};
	send_remoteCall(ajaxRequestObject);
	ajaxRequestObject	=	{};  
	
	
};

/* Channel table Grid functions*/
var ResizeChannel	=	0;
var channelColModel	=	function(){
	var colModel = [
	                	{name:'channelId',			index:'channelId',			width:'20px',	title: false, formatter:channelColModelFormatterFunction.channelSelector},
						{name:'channelName',		index:'channelName',		width:'100%',	align: 'left',	title: false},
						{name:'channelUrl',			index:'channelUrl',			width:'200%',	align: 'left',	title: true},
						{name:'total_profiles',		index:'total_profiles',		width:'50%',	align: 'left',	sortable: false, title: false, formatter:channelColModelFormatterFunction.totalProfiles},
						{name:'active_profiles',	index:'active_profiles',	width:'50%',	align: 'left',	sortable: false, title: false, formatter:channelColModelFormatterFunction.activeProfiles},
						{name:'nodeId',				index:'nodeId',				width:'100%', 	align: 'left',	sorttype: "float", 	title: false, formatter:channelColModelFormatterFunction.nodeName},
						{name:'nodeDescription',	index:'nodeId',				width:'100%',	align: 'left', 	sorttype: "float",	title: false, formatter:channelColModelFormatterFunction.nodeDescription},		
						{name:'channelStatus',		index:'channelStatus',		width:'80%',	align: 'left', 	sorttype: "float",	title: false, formatter:channelColModelFormatterFunction.channelStatus},	
						{name:'emailAlert',			index:'emailAlert',			width:'60%',	align: 'center',	title: false,	editable:true,	edittype:'checkbox', editoptions: { value: "0:1" }, formatter:channelColModelFormatterFunction.checkbox, formatoptions:{disabled:false}}
					];
	return colModel;
};
var channelColModelFormatterFunction	=	new Object();
function DefinechannelColModelFormatterFunctions(){

	channelColModelFormatterFunction.channelSelector	=	function(val,colModelOB, rowdata){
		var innerhtml='<input type="radio" name="channel_list_items_radio" id="Channel_'+rowdata.channelId+'" value="'+val+'" /> ';
		return innerhtml;
	};
	
	channelColModelFormatterFunction.totalProfiles		=	function(val,colModelOB, rowdata){
		var innerhtml='';
		innerhtml += rowdata['profiles'].length;
		return innerhtml;
	};
	channelColModelFormatterFunction.activeProfiles		=	function(val,colModelOB, rowdata){
		var innerhtml='';
		innerhtml += getActiveProfilesCount(rowdata['profiles']);
		return innerhtml;
	};
	channelColModelFormatterFunction.nodeName		=	function(val,colModelOB, rowdata){
		var innerhtml='';
		innerhtml += NodeTableData[rowdata['nodeId']]['nodeName'];
		return innerhtml;
	};
	channelColModelFormatterFunction.nodeDescription		=	function(val,colModelOB, rowdata){
		var innerhtml='';
		innerhtml += NodeTableData[rowdata['nodeId']]['nodeDescription'];
		return innerhtml;
	};
	channelColModelFormatterFunction.channelStatus		=	function(val,colModelOB, rowdata){
		var innerhtml='';
		switch (val){
			case '1':{
				innerhtml = 'Active';
				break;
			}
			case '2':{
				innerhtml = 'Inactive';
				break;
			}
			default:{
				break;
			}
		}
		return innerhtml;
	};
	
	channelColModelFormatterFunction.checkbox	=	function(val,colModelOB, rowdata){
		var output	=	'<input class="alertCheckbox" channelId="'+rowdata.channelId+'" type="checkbox" value="'+val+'" onclick="saveAlertCheckbox(this)"'+((val==='1')?'checked':'')+' />';
		return output;
	};
	
	channelColModelFormatterFunction.gridComplete	=	function(){
		var Table			=	$(this);
		GRID_UNIQUE_ID	=	'ChannelTable';
		if(ResizeChannel	==	0){
			CommonGridCompleteFunctions(Table);
			ResizeChannel++;
		}
		$('#ChannelTable').jqGrid('setCaption','Source List');
		worksOnAllGridComplete(Table);
		bindChannelRadioButtons();
	};
}
DefinechannelColModelFormatterFunctions();

var hasSpecialChar = function(channelName){
	var regexString = /^[a-zA-Z0-9\s]+$/;
	var boolVal = regexString.test(channelName);
	var boolValResult = false;
	if(boolVal){
		boolValResult = false;
	}else{
		boolValResult = true;
	}
	return boolValResult;
};

/*Add channel*/
var addChannel	=	function(){

	var newChannelNode		=	$('#nodeListSelect').val();
	var newChannelUrl		=	encodeURIComponent($('#newChannelURL').val().trim());
	var newChannelTemplate	=	$('#templateListSelect').val();
	var newChannelName		=	$('#newChannelName').val().trim();
	if(newChannelName == '' || newChannelUrl == ''){
		AlertMessage({msg:"Please don't leave blank inputs for Channel Name/URL."});
		return false;
	}else if(hasSpecialChar(newChannelName)){
		AlertMessage({msg:"Please don't enter special characters."});
		return false;
	}
	loadImage();
	ajaxRequestObject.actionScriptURL	=	'./../InterfaceToDatabaseUpdates.php?Operation=ChannelInfo&cat=add&name='+newChannelName+'&nodeId='+newChannelNode+'&url='+newChannelUrl+'&temp='+newChannelTemplate+'&channelTimezoneId='+parseInt(timezoneSettingsObj['timezoneId']);
	ajaxRequestObject.sendMethod	=	'GET';
	ajaxRequestObject.callType	=	'SYNC';
	ajaxRequestObject.responseType	=	1;
	ajaxRequestObject.callBack	=	function(Response){
		deloadImage();
		var defaultCheck = checkResponseUrl(Response);
		if(defaultCheck){
			Response	=	Response.responseText;
			deloadImage();
			if((Response == 0 || Response == "0") && Response != '')
				refreshdata('HomePageChannels#4');
			else if(Response == 101 || Response == "101"){
				AlertMessage({msg:'Source Limit exceeded'});
			}
			else if(Response == 102 || Response == "102"){
				AlertMessage({msg:'Source with the same name or url already exist at this node'});
			}
			else{
				erMsg	=	'Failed to Add source';
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
	$('#channel_add_form').jqxWindow('close');
};

/* Cancel add channel*/
var cancelNewChannel = function(){
	$('#newChannelName').val('');
//	$('#nodeListSelect').val(NodeTableData[Object.keys(NodeTableData)[0]]['nodeId']);
	$('#newChannelURL').val('');
//	$('#templateListSelect').val(TemplateList[Object.keys(TemplateList)[0]]['templateId']);
	$('#channel_add_form').jqxWindow('close');
};

/*Delete Channel*/
var deleteChannel = function(){
	
	var channelId	=	$('#HomePageChannels').find('input[type="radio"][name="channel_list_items_radio"]:checked').attr('value');
	
	var output = 0;
	(function () {	 // check events for channel
		loadImage();
		ajaxRequestObject.actionScriptURL	=	'./../InterfaceToDatabaseUpdates.php?Operation=ChannelInfo&cat=checkEvent&channelId='+channelId;
		ajaxRequestObject.sendMethod	=	'GET';
		ajaxRequestObject.responseType	=	1;
		ajaxRequestObject.callBack	=	function(Response){
			deloadImage();
			var defaultCheck = checkResponseUrl(Response);
			if(defaultCheck){
				Response	=	Response.responseText;
				if(Response == 0 || Response == "0"){
					output = 0;
				}
				else{
					output	= 1;
	
				}
			}
		};
		send_remoteCall(ajaxRequestObject);
		ajaxRequestObject	=	{};  
		
	})();
	
	if(output == 0){
		
		var confirmation	=	confirm('Do you want to delete channel');
		if(!confirmation)
			return false;
		loadImage();
		
		ajaxRequestObject.actionScriptURL	=	'./../InterfaceToDatabaseUpdates.php?Operation=ChannelInfo&cat=delete&channelId='+channelId;
		ajaxRequestObject.sendMethod	=	'GET';
		ajaxRequestObject.callBack	=	function(Response){
			deloadImage();
			if(Response == 0 || Response == "0")
				refreshdata('HomePageChannels#6');
			else{
				erMsg	=	'Source not deleted properly';
				if(Response.indexOf('||') != -1){
					erCode	=	Response.split('||')[1];
					if(SoapErrorMessages[erCode] != '')
						erMsg	=	SoapErrorMessages[erCode];
				}
				AlertMessage({msg:erMsg});
			}
		};
		send_remoteCall(ajaxRequestObject);
		ajaxRequestObject	=	{};
	}else if(output == 1){
		erMsg = 'Please remove the respective events before removing this source.';
		AlertMessage({msg:erMsg});
	}
		
};

/*update Channel*/
var updateChannel = function(){
	var confirmation	=	confirm('Do you want to update source');
	if(!confirmation)
		return false;
	
	loadImage();
	var channelId	=	$('#HomePageChannels').find('input[type="radio"][name="channel_list_items_radio"]:checked').attr('value');
	ajaxRequestObject.actionScriptURL	=	'./../InterfaceToDatabaseUpdates.php?Operation=ChannelInfo&cat=update&channelId='+channelId;
	ajaxRequestObject.sendMethod	=	'GET';
	ajaxRequestObject.responseType	=	1;
	ajaxRequestObject.callBack	=	function(Response){
		deloadImage();
		var defaultCheck = checkResponseUrl(Response);
		if(defaultCheck){
			Response	=	Response.responseText;
			if(Response == 0 || Response == "0")
				refreshdata('HomePageChannels#16');
			else{
				erMsg	=	'Source not updated properly';
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



/*Edit channel*/
var editChannel = function(){
	$('#channel_edit_form').jqxWindow('open');
	var channelId	=	$('#HomePageChannels').find('input[type="radio"][name="channel_list_items_radio"]:checked').attr('value');
	$('#editChannelNameSpan').html(ChannelTableData[channelId]['channelName']);
//	$('#editChannelStatusSelect').val(ChannelTableData[channelId]['channelStatus']);
	currentTemplateID	=	ChannelTableData[channelId]['templateId'];
	$('#editChannelTemplateSelect').val(currentTemplateID);
	$('#editChannelProfileTable').find('tr[channelref]').css('display','none');
	var currentChPro	=	$('#editChannelProfileTable').find('tr[channelref="'+channelId+'"]');
	for(var f = 0;f<currentChPro.length;f++){
		currentprofileStateStr	+=	currentChPro.eq(f).find('select').val();
	}
	currentChPro.css('display','table-row');
	renderChannelScheduleData();
};

/*Cancel channel edit*/
var cancelEditChannel	=	function(){
	if(channelAddFlag || channelEditFlag){
		cancelSchedulling();
		channelAddFlag	=	false;
		channelEditFlag	=	false;
	}
	else{
		$('#channel_edit_form').jqxWindow('close');
		currentprofileStateStr	=	'';
		currentTemplateID	=	0;
	}
};

/* Save channel*/
var saveChannel = function(){
	var scheduleSet	=	true;
	var notifyChangeFlag	=	0;
	var profileData			=	new Object();
	var templateId			=	$('#editChannelTemplateSelect').val();
	var scheduleDataRows	=	$('#scheduleTableBody').find('tr[evid]');
	var savetempstr	=	'';
	var channelId			=	$('#HomePageChannels').find('input[type="radio"][name="channel_list_items_radio"]:checked').attr('value');
	$('#editChannelProfileTable').find('[channelref="'+channelId+'"]').each(function(){
		profileData[$(this).attr('profileref')]	=	$(this).find('select').val();
		savetempstr	+=	$(this).find('select').val();
	});
	if(scheduleDataRows.length<1){
		scheduleSet	=	false;
	}
	if(!channelAddFlag && !channelEditFlag && (templateId == currentTemplateID) && (savetempstr == currentprofileStateStr)){
		cancelEditChannel();
		return false;
	}
	if(!scheduleSet){
		var confirmation	=	confirm('No scheduling has been set for this source. Do you still want to save the changes');
		if(!confirmation)
			return false;
		else{
			notifyChangeFlag	=	0;
		}
	}
	var oldEventStatus	=	$('.activeEventRow').eq(1).find('div[statusval]').attr('statusval');
	var newEventStatus	=	$('.activeEventRow').eq(0).find('[name="newScheduleStatus"]').val();
	if((savetempstr != currentprofileStateStr) || (templateId != currentTemplateID)){
		notifyChangeFlag = 1;
	}

	if((oldEventStatus != newEventStatus) && (!IsValueNull(oldEventStatus))){
		notifyChangeFlag	=	0;
	}


	loadImage();
//	if(savetempstr != currentprofileStateStr){
		ajaxRequestObject.actionScriptURL	=	'./../InterfaceToDatabaseUpdates.php?Operation=ProfileInfo&cat=edit&chId='+channelId+'&data='+JSON.stringify(profileData);
		ajaxRequestObject.sendMethod	=	'GET';
		ajaxRequestObject.callType	=	'SYNC';
		ajaxRequestObject.responseType	=	1;
		ajaxRequestObject.callBack	=	function(Response){
			deloadImage();
			var defaultCheck = checkResponseUrl(Response);
			if(defaultCheck){
				Response	=	Response.responseText;
				channelStatus	=	1;
				ajaxRequestObject.actionScriptURL	=	'./../InterfaceToDatabaseUpdates.php?Operation=ChannelInfo&cat=edit&channelId='+channelId+'&template='+templateId+'&status='+channelStatus+'&notify='+notifyChangeFlag;
				ajaxRequestObject.sendMethod	=	'GET';
				ajaxRequestObject.callType	=	'SYNC';
				ajaxRequestObject.callBack	=	function(Response){
					deloadImage();
					if(Response == 0 || Response == "0"){
						if(channelAddFlag || channelEditFlag){
							scheduleSaveAction	=	saveSchedulling();
							if(!scheduleSaveAction){
								deloadImage();
								return false;
							}
						}
						refreshdata('HomePageChannels#7');
					}
					else{
						erMsg	=	'Source not updated properly';
						if(Response.indexOf('||') != -1){
							erCode	=	Response.split('||')[1];
							if(SoapErrorMessages[erCode] != '')
								erMsg	=	SoapErrorMessages[erCode];
						}
						AlertMessage({msg:erMsg});
					}
				};
				send_remoteCall(ajaxRequestObject);
				ajaxRequestObject	=	{};
			}
		};
		send_remoteCall(ajaxRequestObject);
		ajaxRequestObject	=	{};
/*	}
	else{
		deloadImage();
	}
*/
};

var generateChannelTable	=	function(ChannelDataObject){
	var profileString	=	'';
	for(var key in ChannelDataObject){
		var channelProfileArr	=	ChannelDataObject[key]['profiles'];
		for(j=0;j<channelProfileArr.length;j++){
			if(channelProfileArr[j]['updateState'] != '4'){
				profileString += 		'<tr ';
				if(channelProfileArr[j]['updateState'] == '2'){
					profileString += 	'class="newProfile" ';
				}
				else if(channelProfileArr[j]['updateState'] == '3'){
					profileString += 	'class="notPresentProfile" ';
				}
				profileString += 		'channelref='+key+' profileref='+channelProfileArr[j]['profileId']+'><td><div class="list_item">'+Math.floor(parseInt(channelProfileArr[j]['profileInformation'])/1000)+'</div></td><td><select title="Only active Profiles will be monitored"';
				if(channelProfileArr[j]['updateState'] == '3'){
					profileString += 	' disabled="disabled" ';
				}
				profileString += 		'><option value="1"';
				if(channelProfileArr[j]['profileStatus']== "1"){
					profileString += 	' selected="selected"';
				}
				profileString += '>Active</option><option value="2"';
				if(channelProfileArr[j]['profileStatus']== "2"){
					profileString += 	' selected="selected"';
				}
				profileString += '>Inactive</option></select></td></tr>';
			}
		}
	}
	$('#editChannelProfileTable').find('tbody').html(profileString);
//	bindProfileStatusOption();
	profileString	=	'';
};

var getChannelStatus	=	function(statusCode){
	var channelStateString	=	'';
	switch (statusCode){
	case "1":
		channelStateString	=	'Active';
		break;
	case "2":
		channelStateString	=	'Inactive';
		break;
	}
	return channelStateString;
};
var bindChannelRadioButtons	=	function(){
	$('#HomePageChannels').find('input[type="radio"][name="channel_list_items_radio"]').each(function(){
		$(this).change(function(){
			var CheckCondition	=	$(this).is(':checked');
			var targetElements	=	$(this).closest('.container_div').siblings('.menu_container').find('.menu_item_disable');
			enableDisableButtons(targetElements, CheckCondition);
		});
	});
};
var getActiveProfilesCount	=	function(profileArray){
	activeProfileCount	=	0;
	for (k=0;k<profileArray.length;k++){
		if(profileArray[k]['profileStatus']	==	'1')
			activeProfileCount++;
	}
	return activeProfileCount;
};
var bindProfileStatusOption	=	function(){
	$('#editChannelProfileTable').find('tr[]');
};
