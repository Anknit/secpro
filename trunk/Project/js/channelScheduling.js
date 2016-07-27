var channelAddFlag	= false;
var channelEditFlag	= false;
var allDayFlag	=	false;
var foreverFlag	=	false;

var toggleScheduleOption	=	function(action){
	if(action == 1){
		$('tr.scheduleInput').css("display","none");
	}
	else if(action == 2){
		$('tr.scheduleInput').css("display","table-row");
	}
	if(event){
		$('#channel_add_form').css('width',parseInt($(event.target).closest('table').eq(0).width())+20+'px');
		$('#channel_add_form').css('height',parseInt($(event.target).closest('table').eq(0).height())+50+'px');	
		$('#channel_add_form').find('.windowHead').css('width',parseInt($(event.target).closest('table').eq(0).width())+10+'px');	
		$('#channel_add_form').find('.windowBody').css('width',parseInt($(event.target).closest('table').eq(0).width())+15+'px');	
		$('#channel_add_form').find('.windowBody').css('height',parseInt($(event.target).closest('table').eq(0).height())+20+'px');	
	}
};

var modifyTimestampIfInDaylightRange	=	function(validateTimestamp){
	
	var modifiedTimestamp	=	validateTimestamp;
	if (parseInt(timezoneSettingsObj['DSTapply']) == 1) {
		if(validateTimestamp >= (parseInt(timezoneSettingsObj['DSTstart'])*1000)	||	validateTimestamp	<=	(parseInt(timezoneSettingsObj['DSTend'])*1000)){
			modifiedTimestamp	+=	(parseInt(timezoneSettingsObj['DSTvalue'])*60*60);
		}
	}
	
	return	modifiedTimestamp;
};

var renderChannelScheduleData	=	function(){
	allDayFlag	=	false;
	foreverFlag	=	false;
	channelAddFlag	= false;
	channelEditFlag	= false;
	var currentTimezone = 'Time Zone: '+TimezoneTableData[parseInt(timezoneSettingsObj['timezoneId'])].zoneName+ ' (UTC '+timezoneSettingsObj['zoneOffset']+')<span id="currentTimezoneId" style="display:none;">*</span>';	//setting timezone in scheduling modal div
	$('#currentTimezone').html(currentTimezone);
    $('#scheduleListTable .channel-time-zone').text(TimezoneTableData[parseInt(timezoneSettingsObj['timezoneId'])].zoneName);
	if(parseInt(timezoneSettingsObj['DSTapply']) == 1) {
		$('#currentTimezone').prop('title', 'Adjusted for DST');
		$('#currentTimezoneId').css('display', 'initial');
	}
	$('#allDayContainerCheckInput').prop('checked',false);
	$('#newScheduleEnd').css('opacity',1);
	$('#newScheduleRepeat').css('opacity',1);
	$('.allDayContainer').css('visibility','hidden');
	channelScheduleData	= '';
	editFlag	=	false;
	$('#scheduleListTable').find('tbody').find('tr.optionRow').addClass('activeEventRow').removeAttr('evid').css('display','none');
	$('#scheduleConfirmButton').css('visibility','hidden');
	var channelId	=	$('#HomePageChannels').find('input[type="radio"][name="channel_list_items_radio"]:checked').attr('value');
	$('#scheduleListTable').find('tbody').find('tr:not(.optionRow)').remove();
	$('.schedulerOption').find('input[type="button"][value="Add"]').jqxButton({ disabled:false});
	$('.schedulerOption').find('input.menu_item_disable[type="button"]').jqxButton({ disabled:'disabled'});
	channelScheduleData	=	fetchScheduleData(channelId);
	var scheduleRows	=	'';
	for(var i=0;i<channelScheduleData.length;i++){
		scheduleRows	+=	'<tr ';
		if(channelScheduleData[i]['endTime'] == 0){
			scheduleRows	+=	'allDayEvent=true ';
		}
		scheduleRows	+=	'evid="'+channelScheduleData[i]['eventId']+'"><td><input type="radio" name="scheduleEventSelect"></td>';
		scheduleRows	+=	'<td><div>'+getDateString(modifyTimestampIfInDaylightRange(parseInt(channelScheduleData[i]['startTime']))	+	(parseFloat(timezoneSettingsObj['zoneOffset'])*60*60) + (parseFloat(new Date().getTimezoneOffset())*60))+'</div></td>';
		if(channelScheduleData[i]['endTime'] != 0 || channelScheduleData[i]['endTime'] != '0'){
			scheduleRows	+=	'<td><div>'+getDateString(modifyTimestampIfInDaylightRange(parseInt(channelScheduleData[i]['endTime']))	+	(parseFloat(timezoneSettingsObj['zoneOffset'])*60*60) + (parseFloat(new Date().getTimezoneOffset())*60))+'</div></td>';
		}
		else{
			scheduleRows	+=	'<td><div>'+getDateString(parseInt(channelScheduleData[i]['endTime']))+'</div></td>';
		}
/*		scheduleRows	+=	'<td>'+getTimeZoneString(channelScheduleData[i]['timeZone'])+'</td>';
*/
		scheduleRows	+=	'<td>'+getRepeatitionString(channelScheduleData[i]['repetition'],modifyTimestampIfInDaylightRange(parseInt(channelScheduleData[i]['startTime']))	+	(parseFloat(timezoneSettingsObj['zoneOffset'])*60*60) + (parseFloat(new Date().getTimezoneOffset())*60))+'</td>';
		if(channelScheduleData[i]['untill'] == 0 || channelScheduleData[i]['untill'] == '0'){
			scheduleRows	+=	'<td><div>Forever</div></td>';
		}
		else{
			scheduleRows	+=	'<td><div>'+getDateString(modifyTimestampIfInDaylightRange(parseInt(channelScheduleData[i]['untill']))	+	(parseFloat(timezoneSettingsObj['zoneOffset'])*60*60) + (parseFloat(new Date().getTimezoneOffset())*60))+'</div></td>';
		}	
		scheduleRows	+=	'<td><div style="display: inline-block;">'+channelScheduleData[i]['reminder']+'</div> minutes before</td>';
		scheduleRows	+=	'<td>'+getEventStatusString(channelScheduleData[i]['eventStatus'])+'</td>';
		scheduleRows	+=	'</tr>';
	}
	$('#scheduleListTable').find('tbody').prepend(scheduleRows);
	$('.weekdayContainer').css('display','none');
	$('[name="newScheduleRepeat"]').on('change', toggleDayContainer);
	lastSelScheduleRow	=	'';
	bindScheduleRadios();
};
var toggleDayContainer	=	function(event){
	var value = $(this).val();
	if(value == '8' && $('.dateTimeInput').val() != ''){
		$(this).closest('td').next('td').children().eq(0).css('visibility','visible');
		$(this).closest('td').next('td').children().eq(1).css('display','block');
		$("#scheduleTableBody").animate({ scrollTop: $('#scheduleTableBody')[0].scrollTop+25}, 250);
		$('.weekdayContainer').css('display','block');
		var day	=	$('#newScheduleStart').jqxDateTimeInput('getDate').getDay()+1;
		$('.weekdayContainer').find('span.repeatOnDay').removeClass('repeatOnDay');
		$('.weekdayContainer').find('span[data-day="'+day+'"]').addClass('repeatOnDay');
		changeWeekDayTitle();
	}
	else{
		if(value == '0'){
			$(this).closest('td').next('td').children().eq(0).css('visibility','hidden');
			$(this).closest('td').next('td').children().eq(1).css('display','none');
		}
		else{
			$(this).closest('td').next('td').children().eq(0).css('visibility','visible');
			$(this).closest('td').next('td').children().eq(1).css('display','block');
		}
		$('.weekdayContainer').css('display','none');
	}
};

var getTimeZoneString	=	function(timezoneId){
	var selectedOption	=	$('[name="newScheduleTimeZone"]').find('option[data-timezoneid="'+timezoneId+'"]');
	var timeZoneString	=	'<div offset="'+selectedOption.attr('value')+'" timezoneval="'+timezoneId+'">';
	timeZoneString		+=	selectedOption.text();
	timeZoneString		+=	'</div>';
	return timeZoneString;
};

var getRepeatitionString	=	function(repeatVal, startDate){
	var repeatitionString = '';
	var repeatDayArr;
	repeatDayMatchArr	=	['Once','Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'];
	if(repeatVal.indexOf(',') != -1){
		repeatDayArr	=	repeatVal.split(',');
	}
	else{
		repeatDayArr	= [repeatVal];
	}
	if(repeatDayArr.length == 1 && repeatVal == '0'){
		tdate	=	new Date(parseInt(startDate*1000));
		weekDay	=	tdate.getDay()+1;
		repeatitionString	+=	'<div repeatVal	= "'+repeatDayArr[0]+'" dayval="'+weekDay+'">';
		if(repeatDayArr[0] == '0')
			repeatitionString	+=	repeatDayMatchArr[0];
		else
			repeatitionString	+=	'<span style="margin-right:5px">Weekly</span><a href="#" title="'+repeatDayMatchArr[parseInt(repeatDayArr[0])]+'">[?]</a>';
	}
	else if(repeatDayArr.length == 7){
		repeatitionString	+=	'<div repeatVal	= "1,2,3,4,5,6,7" dayVal="1,2,3,4,5,6,7">';
		repeatitionString	+=	'Daily';
	}
	else{
		repeatitionString	+=	'<div repeatVal	= "8" dayVal ="';
		tempstr	=	'';
		for(var i=0;i<repeatDayArr.length;i++){
			if(i>0){
				tempstr	+=	', ';
				repeatitionString	+=	',';
			}
			tempstr	+=	repeatDayMatchArr[parseInt(repeatDayArr[i])];
			repeatitionString	+=	parseInt(repeatDayArr[i]);

		}
		repeatitionString	+=	'" >';
		repeatitionString	+=	'<span style="margin-right:5px">Weekly</span><a href="#" title="'+tempstr+'">[?]</a>';
	}
	repeatitionString	+=	'</div>';
	return	repeatitionString;
};

var getEventStatusString	=	function(statusVal){
	statusString	=	'<div statusval="1">Active</div>';
	if(statusVal	==	'2'){
		statusString	=	'<div statusval="2">Inactive</div>';
	}
	return statusString;
};

var fetchScheduleData	=	function(channelId){
	ajaxRequestObject	=	{};
	var returnData =	'';
	ajaxRequestObject.actionScriptURL	=	'./../UserInterface/fetchData.php?data=schedule&channel='+channelId;
	ajaxRequestObject.sendMethod		=	'GET';
	ajaxRequestObject.callType			=	false;
	ajaxRequestObject.responseType	=	1;
	ajaxRequestObject.callBack	=	function(Response){
		deloadImage();
		var defaultCheck = checkResponseUrl(Response);
		if(defaultCheck){
			Response	=	Response.responseText;
			if(Response != '')
				returnData	=	JSON.parse(Response);
		}
	};
	send_remoteCall(ajaxRequestObject);
	ajaxRequestObject	=	{};
	return returnData;
};
var addChannelSchedulling	=	function(){
	if($('#scheduleTableBody').find('tr[allDayEvent]').length>0){
		AlertMessage({msg:'This source is already set for continuous monitoring'});
		return false;
	}
	channelAddFlag	=	true;
	$("#scheduleTableBody").animate({ scrollTop: $('#scheduleTableBody')[0].scrollHeight}, 1000);
	var editableRow	=	$('#scheduleListTable').find('tbody').find('tr.optionRow').addClass('activeEventRow').attr('evid','0').css('display','table-row');
	$('#scheduleConfirmButton').css('visibility','visible');
	initializeSchedulingOption(editableRow);
	bindForeverScheduleAction();
	if($('#scheduleTableBody').find('tr').length<2){
		$('.allDayContainer').css('visibility','visible');
		bindAllDayAction();
	}
	$('.schedulerOption').find('input[type="button"][value="Add"]').jqxButton({ disabled:'disabled'});
};
var saveSchedulling	=	function(){
	var channelId	=	$('#HomePageChannels').find('input[type="radio"][name="channel_list_items_radio"]:checked').attr('value');
	var currentDataRow	=	$('.activeEventRow').eq(0);
	scheduleDataObj		=	{};
	if(currentDataRow.attr('evid') != 0 && currentDataRow.attr('evid') != "0"){
		scheduleDataObj['eventId']	=	currentDataRow.attr('evid');
		currentDataRow.attr('evid','0');
	}
	scheduleDataObj['channel']	=	channelId;
	var hoursOffsetLocal	=	(-1)*(new Date().getTimezoneOffset()/60);
	var timezoneSettingsOffsetWithDaylight = daylightSaving(parseFloat(timezoneSettingsObj['zoneOffset']));
	scheduleDataObj['start']	=	currentTime(hoursOffsetLocal,currentDataRow.find('div[name="newScheduleStart"]').jqxDateTimeInput('getDate'),timezoneSettingsOffsetWithDaylight);
	scheduleDataObj['end']		=	currentTime(hoursOffsetLocal,currentDataRow.find('div[name="newScheduleEnd"]').jqxDateTimeInput('getDate'),timezoneSettingsOffsetWithDaylight);
/*	scheduleDataObj['timezone']	=	currentDataRow.find('[name="newScheduleTimeZone"]').find('option:selected').attr('data-timeZoneId');
	scheduleDataObj['offset']	=	currentDataRow.find('[name="newScheduleTimeZone"]').find('option:selected').attr('value');
*/	repeatSelectVal		=	currentDataRow.find('[name="newScheduleRepeat"]').val();
	if(repeatSelectVal == '8'){
		dayArr	=	currentDataRow.find('.weekdayContainer span.repeatOnDay');
		tempStr	=	'';
		for(var i=0; i< dayArr.length; i++){
			if(i>0)
				tempStr	+=	',';
			tempStr	+=	$(dayArr[i]).attr('data-day');
		}
		scheduleDataObj['repeat']	=	tempStr;
		scheduleDataObj['dayval']	=	tempStr;
	}
	else{
		scheduleDataObj['repeat']	=	repeatSelectVal;
		tdate	=	new Date(scheduleDataObj['start']);
		scheduleDataObj['dayval']	=	(tdate.getDay()+1).toString();
	}
	if(repeatSelectVal == '0' && !$('#allDayContainerCheckInput').is(':checked')){
		scheduleDataObj['untill']	=	scheduleDataObj['end'];
	}
	else{
		scheduleDataObj['untill']	=	currentTime(hoursOffsetLocal,currentDataRow.find('div[name="newScheduleUntill"]').jqxDateTimeInput('getDate'),timezoneSettingsOffsetWithDaylight);
	}
	scheduleDataObj['reminder']	=	currentDataRow.find('[name="newScheduleReminder"]').val();
	scheduleDataObj['status']	=	currentDataRow.find('[name="newScheduleStatus"]').val();
	if($('#allDayContainerCheckInput').is(':checked')){
		allDayFlag	=	true;
		scheduleDataObj['end']	=	0;
		scheduleDataObj['repeat'] = 0;
	}
	if($('#repeatForeverCheckBox').jqxCheckBox('checked')){
		foreverFlag	=	true;
		scheduleDataObj['untill']	=	0;
	}
	validOutput	=	validateScheduleDataObj(scheduleDataObj);
	if(validOutput){
		scheduleDataObj['start']	=	new Date(scheduleDataObj['start']).getTime()/1000;
		if(scheduleDataObj['end'] != 0){
			scheduleDataObj['end']		=	new Date(scheduleDataObj['end']).getTime()/1000;
		}
		
		if(scheduleDataObj['untill'] != 0){
			scheduleDataObj['untill']	=	new Date(scheduleDataObj['untill']).getTime()/1000;
		}
		
		ajaxRequestObject	=	{};
		ajaxRequestObject.actionScriptURL	=	'./../InterfaceToDatabaseUpdates.php?Operation=ChannelInfo&cat=schedule&channelId='+channelId+'&scheduleData='+JSON.stringify(scheduleDataObj);
		ajaxRequestObject.sendMethod		=	'GET';
		ajaxRequestObject.callType			=	true;
		var scheduleState = false; 
		ajaxRequestObject.responseType	=	1;
		ajaxRequestObject.callBack	=	function(Response){
			deloadImage();
			var defaultCheck = checkResponseUrl(Response);
			if(defaultCheck){
				Response	=	Response.responseText;
				if(Response == 0 || Response == '0'){
					renderChannelScheduleData();
					scheduleState = true;
				}else{
					AlertMessage({msg:'Failed to add event.'});
				}
			}
		};
		send_remoteCall(ajaxRequestObject);
		ajaxRequestObject	=	{};
	}
	else{
		return false;
	}
	return scheduleState;
};

var validateDaylightTime	=	function(validateTimestamp){
	if((validateTimestamp	>=	(parseInt(timezoneSettingsObj['DSTstart'])*1000)	&&	(validateTimestamp	<=	((parseInt(timezoneSettingsObj['DSTstart'])*1000)	+	3600000)))	||	(validateTimestamp	<=	(parseInt(timezoneSettingsObj['DSTend'])*1000)	&&	(validateTimestamp	>=	((parseInt(timezoneSettingsObj['DSTend'])*1000)	-	3600000)))){
		if(validateTimestamp >= (parseInt(timezoneSettingsObj['DSTstart'])*1000)	||	validateTimestamp	<=	(parseInt(timezoneSettingsObj['DSTend'])*1000)){
			validateTimestamp	-=	(parseInt(timezoneSettingsObj['DSTvalue'])*60*60);
		}
		return true;
	}else{
		return false;
	}
};

var validateScheduleDataObj	=	function(DataRowObj){
	invalidFlag	=	false;
	
	if(DataRowObj['start'] >= DataRowObj['end'] && !allDayFlag){
		AlertMessage({'msg':'End time must be greater than start time'});
		invalidFlag	=	true;
		return 	!invalidFlag;
	}
	else if(DataRowObj['end'] > DataRowObj['untill'] && !foreverFlag && !allDayFlag){
		AlertMessage({'msg':'End time must be less than until time'});
		invalidFlag	=	true;
		return 	!invalidFlag;
	}
	else if((DataRowObj['end'] - DataRowObj['start'] > 86399000) && !allDayFlag){
		AlertMessage({'msg':'Difference between end time and start time must be less than 24 hours'});
		invalidFlag	=	true;
		return 	!invalidFlag;
	}
	else if( (DataRowObj['start'] < (new Date().getTime()-60000)) && !($('#newScheduleStart').jqxDateTimeInput('disabled'))){
		AlertMessage({'msg':'Start time cannot be a past value'});
		invalidFlag	=	true;
		return 	!invalidFlag;
	}
	scheduledEventRows	=	$('#scheduleTableBody').find('tr[evid]:not(.activeEventRow)');
	rowCount	=	scheduledEventRows.length;
	var hoursOffsetLocal	=	(-1)*(new Date().getTimezoneOffset()/60);
	var timezoneSettingsOffsetWithDaylight = daylightSaving(parseInt(timezoneSettingsObj['zoneOffset']));
	if(rowCount > 0){
		for(var p=0;p<rowCount;p++){
			if(invalidFlag)
				break;
			
			// check if start date of current event is less than untill date of other task
			// or if untill date of current task is greater than the start date of other task
			// if yes then validate more else it will be non-overlapping always
			c_sTime		=	DataRowObj['start'];
			c_eTime		=	DataRowObj['end'];
			if(DataRowObj['untill'] == 0 || DataRowObj['untill'] == '0'){
				c_uTime		=	new Date(2050,0,1).getTime();
			}
			else{
				c_uTime		=	DataRowObj['untill'];
			}
			c_offset	=	0;
/*			c_offset	=	DataRowObj['offset'];
*/			o_sTime		=	currentTime(hoursOffsetLocal,createDateFromString(scheduledEventRows.eq(p).find('td').eq(1).children().eq(0).text()),timezoneSettingsOffsetWithDaylight);
			o_eTime		=	currentTime(hoursOffsetLocal,createDateFromString(scheduledEventRows.eq(p).find('td').eq(2).children().eq(0).text()),timezoneSettingsOffsetWithDaylight);
			if(scheduledEventRows.eq(p).find('td').eq(4).children().eq(0).text() == "Forever"){
				o_uTime		=	new Date(2050,0,1).getTime();
			}
			else{
				o_uTime		=	currentTime(hoursOffsetLocal,createDateFromString(scheduledEventRows.eq(p).find('td').eq(4).children().eq(0).text()),timezoneSettingsOffsetWithDaylight);
			}
			o_offset	=	0;
/*			o_offset	=	scheduledEventRows.eq(p).find('td').eq(3).children().eq(0).attr('offset');
*/			
			if(	(compareDateOnly(o_uTime,c_sTime,o_offset,c_offset) && compareDateOnly(c_sTime,o_sTime,c_offset,o_offset))	||	(compareDateOnly(c_uTime,o_sTime,c_offset,o_offset) && compareDateOnly(o_sTime,c_sTime,o_offset,c_offset))){
				
				//check if day(s) of occurence of current event lies in day(s) of occurence of other event
				// if yes then validate more else it will be non-overlapping

				// get current event repeat day value
				currentRepeatArray	=	scheduleDataObj['dayval'].split(',');

				// get other event repeat day value
				otherRepeatArray	=	scheduledEventRows.eq(p).find('td').eq(3).children().eq(0).attr('dayval').split(',');

				for(var t=0;t<currentRepeatArray.length;t++){
					if(invalidFlag)
						break;
					// if any of the day coincides then validate more
					if(otherRepeatArray.indexOf(currentRepeatArray[t]) != -1){
						
						// if start time or end time(ONLY TIME) of current task lies between start and end time of other task then validate more
						if( (	compareTimeOnly(c_sTime,o_sTime,c_offset,o_offset) && compareTimeOnly(o_eTime,c_sTime,o_offset,c_offset)) || (compareTimeOnly(c_eTime,o_sTime,c_offset,o_offset) && compareTimeOnly(o_sTime,c_sTime,o_offset,c_offset))){
							AlertMessage({'msg':'Event overlapping found ! Reschedule...'});
							invalidFlag	=	true;
						}
					}	
				}
				
			}
		}
	}
	
	//For daylight validity
	if(parseInt(timezoneSettingsObj['DSTapply']) == 1) {
		var validateStartTime = validateDaylightTime(DataRowObj['start']);
		var validateEndTime = validateDaylightTime(DataRowObj['end']);
		var validateUntillTime = validateDaylightTime(DataRowObj['untill']);
		
		if(validateStartTime){
			AlertMessage({'msg':'Due to Daylight Saving Time, the entered start time is invalid.'});
			invalidFlag	=	true;
			return 	!invalidFlag;
		}else if(!allDayFlag	&&	validateEndTime){
			AlertMessage({'msg':'Due to Daylight Saving Time, the entered end time is invalid.'});
			invalidFlag	=	true;
			return 	!invalidFlag;
		}else if(!foreverFlag	&&	validateUntillTime){
			AlertMessage({'msg':'Due to Daylight Saving Time, the entered untill time is invalid.'});
			invalidFlag	=	true;
			return 	!invalidFlag;
		}
		
	}
	return 	!invalidFlag;
};
var cancelSchedulling	=	function(){
	renderChannelScheduleData();
};
var bindScheduleRadios	=	function(){
	$('#scheduleTableBody').find('tr').each(function(){
		var radio	=	$(this).find('input[type="radio"][name="scheduleEventSelect"]');
		$(radio).change(function(){
			var CheckCondition	=	$(this).is(':checked');
			if(CheckCondition){
				$('.schedulerOption').find('input[type="button"][value="Add"]').jqxButton({ disabled:'disabled'});
				$(this).closest('tr').addClass('activeEventRow');
			}
			else{
				$('.schedulerOption').find('input[type="button"][value="Add"]').jqxButton({ disabled:false});
				$(this).closest('tr').removeClass('activeEventRow');
			}
			var targetElements	=	$('.schedulerOption').find('.menu_item_disable');
			enableDisableButtons(targetElements, CheckCondition);
		});
		$(this).on('click',function(){
			if(editFlag){
				return false;
			}
			if(lastSelScheduleRow != $(this).attr('evid')){
				$(this).find('input[type="radio"][name="scheduleEventSelect"]').prop('checked','checked');
				$('#scheduleTableBody').find('tr[evid="'+lastSelScheduleRow+'"]').find('input[type="radio"][name="scheduleEventSelect"]').change();
				lastSelScheduleRow	=	$(this).attr('evid');
			}
			else{
				$(this).find('input[type="radio"][name="scheduleEventSelect"]').prop('checked',false);
				lastSelScheduleRow	=	'';
			}
			$(this).find('input[type="radio"][name="scheduleEventSelect"]').change();
		});
	});
};

var editChannelSchedulling	=	function(){
	channelEditFlag	=	true;
	$('#scheduleConfirmButton').css('visibility','visible');
	$('.schedulerOption').find('input[type="button"][value="Add"]').jqxButton({ disabled:'disabled'});
	$('.schedulerOption').find('input[type="button"][value="Remove"]').jqxButton({ disabled:'disabled'});
	var activeRow	=	$('#scheduleTableBody').find('input[type="radio"][name="scheduleEventSelect"]:checked').closest('tr').addClass('activeEventRow');
	var eventId		=	$(activeRow).attr('evid');
	if(activeRow.attr('alldayevent')){
		$('#allDayContainerCheckInput').prop('checked',true);
	}
	showScheduleEditOption(activeRow);
};

var showScheduleEditOption	=	function(activerow){
	curStartDate	=	$(activerow).find('td').eq(1).children().eq(0).text();
	curEndDate		=	$(activerow).find('td').eq(2).children().eq(0).text();
/*	curTimezone		=	$(activerow).find('td').eq(3).children().eq(0).attr('timezoneval');
*/	curRepeat		=	$(activerow).find('td').eq(3).children().eq(0).attr('repeatval');
	if(curRepeat	==	'8'){
		dayRepeat	=	$(activerow).find('td').eq(3).children().eq(0).attr('dayval');
		$('.weekdayContainer').css('display','block');
		dayrepeatArray	=	dayRepeat.split(',');
		for ( var key in dayrepeatArray) {
			$('.weekdayContainer').find('span[data-day="'+dayrepeatArray[key]+'"]').addClass('repeatOnDay');
		}
		changeWeekDayTitle();
	}
	curUntillDate	=	$(activerow).find('td').eq(4).children().eq(0).text();
	curReminder		=	$(activerow).find('td').eq(5).children().eq(0).text();
	curStatus		=	$(activerow).find('td').eq(6).children().eq(0).attr('statusval');
	var hoursOffsetLocal	=	(-1)*(new Date().getTimezoneOffset()/60);
	var timezoneSettingsOffsetWithDaylight = daylightSaving(parseInt(timezoneSettingsObj['zoneOffset']));
	if((curRepeat == '0' && curEndDate != "-" && createDateFromString(curEndDate) < new Date(currentTime(timezoneSettingsOffsetWithDaylight,new Date(),hoursOffsetLocal))) || (curRepeat != '0' && curUntillDate !="Forever" && createDateFromString(curUntillDate) < new Date(currentTime(timezoneSettingsOffsetWithDaylight,new Date(),hoursOffsetLocal)))){
		AlertMessage({msg:"The event cannot be edit"});
		return false;
	}
	if($('#scheduleTableBody').find('tr').length<3){
		$('.allDayContainer').css('visibility','visible');
		bindAllDayAction();
	}
	editFlag	=	true;
	$(activerow).css('display','none');
	var newEditRow	=	$('#scheduleTableBody').find('tr.optionRow').insertBefore(activerow);
	$(newEditRow).find('td').eq(1).children().eq(0).val(curStartDate);
	if($(newEditRow).find('td').eq(1).children().eq(0).jqxDateTimeInput('getDate').getTime() < currentTime(timezoneSettingsOffsetWithDaylight,new Date(),hoursOffsetLocal)){
		$(newEditRow).find('td').eq(1).children().eq(0).jqxDateTimeInput('disabled','disabled');
	}
	if(curEndDate	==	'-'){
		$(newEditRow).find('td').eq(2).children().eq(0).val(new Date(currentTime(timezoneSettingsOffsetWithDaylight,new Date(),hoursOffsetLocal)));
		$(newEditRow).find('td').eq(2).children().eq(0).css('opacity',0);
		$(newEditRow).find('td').eq(3).children().eq(0).css('opacity',0);
	}
	else{
		$(newEditRow).find('td').eq(2).children().eq(0).val(curEndDate);
		$(newEditRow).find('td').eq(2).children().eq(0).css('opacity',1);
	}
/*	$(newEditRow).find('td').eq(3).children().eq(0).find('option[data-timeZoneId="'+curTimezone+'"]').attr('selected','selected');
*/	
	$(newEditRow).find('td').eq(3).children().eq(0).val(curRepeat);
	if(curUntillDate == 'Forever'){
		$(newEditRow).find('td').eq(4).children().eq(0).css('display','none');
		$(newEditRow).find('td').eq(4).children().find('#repeatForeverCheckBox').jqxCheckBox({ checked:true});
	}
	else{
		$(newEditRow).find('td').eq(4).children().eq(0).css('display','block');
		$(newEditRow).find('td').eq(4).children().eq(0).val(curUntillDate);
	}
	$(newEditRow).find('td').eq(4).children().eq(1).css('display','block');
	bindForeverScheduleAction();
	if(curRepeat	==	'0' && curUntillDate != 'Forever'){
		if(curEndDate	==	'-'){
			$(newEditRow).find('td').eq(4).children().eq(0).css('visibility','visible');
		}
		else{
			$(newEditRow).find('td').eq(4).children().eq(0).css('visibility','hidden');
		}
		$(newEditRow).find('td').eq(4).children().eq(1).css('display','none');
	}
	else{
		$(newEditRow).find('td').eq(4).children().eq(0).css('visibility','visible');
		$(newEditRow).find('td').eq(4).children().eq(1).css('display','block');
	}
	$(newEditRow).find('td').eq(5).children().eq(0).val(curReminder);
	$(newEditRow).find('td').eq(6).children().eq(0).val(curStatus);
	$(newEditRow).insertBefore(activerow).attr('evid',$(activerow).attr('evid'));
	$(newEditRow).css('display','table-row');
};

var removeChannelSchedulling	=	function(){
	loadImage();
	var eventid	=	$('#scheduleTableBody').find('input[type="radio"][name="scheduleEventSelect"]:checked').closest('tr').attr('evid');
	ajaxRequestObject	=	{};
	ajaxRequestObject.actionScriptURL	=	'./../InterfaceToDatabaseUpdates.php?Operation=ChannelInfo&cat=schedule&action=delete&eventid='+eventid;
	ajaxRequestObject.sendMethod		=	'GET';
	ajaxRequestObject.callType			=	false;
	ajaxRequestObject.responseType	=	1;
	ajaxRequestObject.callBack	=	function(Response){
		deloadImage();
		var defaultCheck = checkResponseUrl(Response);
		if(defaultCheck){
			Response	=	Response.responseText;
			if(Response){
				renderChannelScheduleData();
			}
		}
	};
	send_remoteCall(ajaxRequestObject);
	ajaxRequestObject	=	{};
};

// For converting local timezone to account managers timezone
var currentTime	=	function(offsetRequired,dateStamp,currentDateOffset){
	if(dateStamp != undefined || dateStamp != null){
		var	a	= dateStamp;
	}
	else{
		var a	=	new Date();
	}
	var b = a.getTime();
	if(currentDateOffset != undefined || currentDateOffset != null){
		b = b - (parseFloat(currentDateOffset)*60*60*1000);
	}
	else{
		b = b	+	(a.getTimezoneOffset()*60*1000)
	}
	b	=	b	+	(parseFloat(offsetRequired)*60*60*1000);
	return b;
}

var daylightSaving	=	function(offSet){
	if (parseInt(timezoneSettingsObj['DSTapply']) == 1) {
			offSet += parseInt(timezoneSettingsObj['DSTvalue']);
	}
	return offSet;
};

var initializeSchedulingOption	=	function(editRow){
	var curTimeOffset = daylightSaving(parseFloat(timezoneSettingsObj['zoneOffset']));
	curTime	= new Date(currentTime(curTimeOffset));
	editRow.find('#newScheduleStart').jqxDateTimeInput('setDate',new Date(curTime.getFullYear(), curTime.getMonth(), curTime.getDate(), curTime.getHours(), curTime.getMinutes(), curTime.getSeconds(), curTime.getMilliseconds()));
	editRow.find('#newScheduleStart').jqxDateTimeInput('disabled',false);
	editRow.find('#newScheduleEnd').jqxDateTimeInput('setDate',new Date(curTime.getFullYear(), curTime.getMonth(), curTime.getDate(), curTime.getHours()+1, curTime.getMinutes(), curTime.getSeconds(), curTime.getMilliseconds()));
	editRow.find('#newScheduleUntill').jqxDateTimeInput('setDate',new Date(curTime.getFullYear(), curTime.getMonth(), curTime.getDate()+1, curTime.getHours()+1, curTime.getMinutes(), curTime.getSeconds(), curTime.getMilliseconds()));
	editRow.find('[name="newScheduleRepeat"]').val('0');
	editRow.find('[name="newScheduleReminder"]').val('5');
	editRow.find('[name="newScheduleStatus"]').val('1');
	editRow.find('#newScheduleUntill').css('visibility','hidden');
	editRow.find('#newScheduleUntill').css('display','block');
	editRow.find('#foreverSchedule').css('display','none');
	editRow.find('#repeatForeverCheckBox').jqxCheckBox({checked:false});
    $('#newScheduleStart').jqxDateTimeInput({'min' : new Date(curTime.getFullYear(), curTime.getMonth(), curTime.getDate()-1, curTime.getHours(), curTime.getMinutes(), curTime.getSeconds(), curTime.getMilliseconds())});
	editRow.find('#newScheduleStart').on('change', function (event){  
	    var jsDate = event.args.date;
	    $('#newScheduleEnd').jqxDateTimeInput({'min' : new Date(jsDate.getFullYear(), jsDate.getMonth(), jsDate.getDate(), jsDate.getHours(), jsDate.getMinutes()+30, jsDate.getSeconds(), jsDate.getMilliseconds())});
	    $('#newScheduleEnd').jqxDateTimeInput({'max' : new Date(jsDate.getFullYear(), jsDate.getMonth(), jsDate.getDate()+1, jsDate.getHours(), jsDate.getMinutes(), jsDate.getSeconds(), jsDate.getMilliseconds())});
	});
};
var getDateString	=	function(timestamp){
	if(timestamp	==	0 || timestamp == '0'){
		return '-';
	}
	var outStr	=	'';
	tempDate	=	new Date(parseInt(timestamp)*1000);
	outStr	+=	tempDate.getFullYear()+'-'+(tempDate.getMonth()+1)+'-'+tempDate.getDate()+' '+tempDate.getHours()+':'+tempDate.getMinutes()+':'+tempDate.getSeconds();
	return outStr;
};
var bindAllDayAction	=	function(){
	$('#allDayContainerCheckInput').on('change',function(){
		var addNewRow	=	$('#scheduleListTable').find('tbody').find('tr.optionRow[evid]').eq(0);
		var curTimeOffset = daylightSaving(parseFloat(timezoneSettingsObj['zoneOffset']));
		curTime	= new Date(currentTime(curTimeOffset));
		if($(this).is(':checked')){
			addNewRow.find('#newScheduleEnd').jqxDateTimeInput('val',0);
			addNewRow.find('#newScheduleEnd').css('opacity',0);
			addNewRow.find('#newScheduleUntill').jqxDateTimeInput('setDate',new Date(curTime.getFullYear(), curTime.getMonth(), curTime.getDate()+1, curTime.getHours()+1, curTime.getMinutes(), curTime.getSeconds(), curTime.getMilliseconds()));
			addNewRow.find('[name="newScheduleRepeat"]').val('0');
			addNewRow.find('[name="newScheduleRepeat"]').css('opacity',0);
			addNewRow.find('[name="newScheduleReminder"]').val('5');
			addNewRow.find('[name="newScheduleStatus"]').val('1');
			addNewRow.find('#newScheduleUntill').css('visibility','visible');
			addNewRow.find('#foreverSchedule').css('display','block');
			bindForeverScheduleAction();
		}
		else{
			addNewRow.find('#newScheduleEnd').jqxDateTimeInput('setDate',new Date(curTime.getFullYear(), curTime.getMonth(), curTime.getDate(), curTime.getHours()+1, curTime.getMinutes(), curTime.getSeconds(), curTime.getMilliseconds()));
			addNewRow.find('#newScheduleEnd').css('opacity',1);
			addNewRow.find('#newScheduleUntill').jqxDateTimeInput('setDate',new Date(curTime.getFullYear(), curTime.getMonth(), curTime.getDate()+1, curTime.getHours()+1, curTime.getMinutes(), curTime.getSeconds(), curTime.getMilliseconds()));
			addNewRow.find('[name="newScheduleRepeat"]').val('0');
			addNewRow.find('[name="newScheduleRepeat"]').css('opacity',1);
			addNewRow.find('[name="newScheduleReminder"]').val('5');
			addNewRow.find('[name="newScheduleStatus"]').val('1');
			addNewRow.find('#newScheduleUntill').css('visibility','hidden');
			addNewRow.find('#foreverSchedule').css('display','none');
		}
	});
};
var bindForeverScheduleAction	=	function(){
	$('#repeatForeverCheckBox').on('change',function(event){
		var addNewRow	=	$('#scheduleListTable').find('tbody').find('tr.optionRow[evid]').eq(0);
		var curTimeOffset = daylightSaving(parseFloat(timezoneSettingsObj['zoneOffset']));
		curTime	= new Date(currentTime(curTimeOffset));
		if(event.args.checked){
			addNewRow.find('#newScheduleUntill').css('display','none');
		}
		else{
			addNewRow.find('#newScheduleUntill').jqxDateTimeInput('setDate',new Date(curTime.getFullYear(), curTime.getMonth(), curTime.getDate()+1, curTime.getHours()+1, curTime.getMinutes(), curTime.getSeconds(), curTime.getMilliseconds()));
			addNewRow.find('#newScheduleUntill').css('display','block');
		}
	});
};