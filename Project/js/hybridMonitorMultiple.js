var defaultMonitoringStatus	=	function(chId){
	if($('.rowDiv[chIden="'+chId+'"]').find('.channelContainer').not('inactiveChannelStatus')){
		$('.rowDiv[chIden="'+chId+'"]').find('.channelContainer').addClass('inactiveChannelStatus');
		$('img[channelId="'+chId+'"]').attr('src', './../../Common/images/tndefault.gif');
	}
};

var changeMonitoringStatus	=	function(chId){
	
	if($('.rowDiv[chIden="'+chId+'"]').find('.channelContainer').hasClass('inactiveChannelStatus')){
		$('.rowDiv[chIden="'+chId+'"]').find('.channelContainer').removeClass('inactiveChannelStatus');
	}
	getProfileResolutionInactive(chId);
};

var showHybridChannelStatusDiv	=	function(chI){

	var channelId	=	chI;
	if($('.rowDiv[chIden="'+channelId+'"]').find('.channelContainer').hasClass('inactiveChannelStatus')){
		return false;
	}
	errCount	=	0;
	$('.ErrorInfoContent[channel='+channelId+']').find('#channelInfoBody').html('');
	tableBodyStr	=	'';
	for(var profiles in completeChannelErrorObject[channelId]){
		if(profiles != 'audio'){
			errCount	+= completeChannelErrorObject[channelId][profiles].length;
			for(d=0;d<completeChannelErrorObject[channelId][profiles].length;d++){
				tableBodyStr	+=	'<tr><td>';
				tableBodyStr	+=	Math.floor(parseInt(assignedChannelIdList[channelId]['profiles'][profiles]['profileInformation'])/1000);
				tableBodyStr	+=	' Kbps';
				tableBodyStr	+=	'</td><td align="left">';
				tableBodyStr	+=	completeChannelErrorObject[channelId][profiles][d]['type'];
				tableBodyStr	+=	'</td><td align="left">';
				tableBodyStr	+=	completeChannelErrorObject[channelId][profiles][d]['start'];
				tableBodyStr	+=	'</td><td align="left">';
				tableBodyStr	+=	completeChannelErrorObject[channelId][profiles][d]['end'];
				if(completeChannelErrorObject[channelId][profiles][d]['end'] != '-'){
					tableBodyStr	+=	' sec </td><td>';	
				}else{
					tableBodyStr	+=	' </td><td>';
				}
				tableBodyStr	+=	'<div class="channelInfoBodyErrorMsg">';
				tableBodyStr	+=	completeChannelErrorObject[channelId][profiles][d]['msg'];
				tableBodyStr	+=	'</td></tr>';
			}
		}
	}
	$('.ErrorInfoContent[channel='+channelId+']').find('#channelInfoBody').html(tableBodyStr);
	$('.ErrorInfoContent[channel='+channelId+']').find('#hoverDivChannelErrorCount').html(errCount);
	setHybridClearTimer(channelId);
};


function setProfileResolution(){
	
	var ProfileResolutionIdArrayString = ProfileResolutionIdArray.toString();
	ajaxRequestObject.actionScriptURL	=	'./../UserInterface/fetchData.php?data=profileResolution&profileId='+ProfileResolutionIdArrayString;
	ajaxRequestObject.sendMethod	=	'GET';
	ajaxRequestObject.callType	=	'SYNC';
	ajaxRequestObject.responseType	=	1;
	ajaxRequestObject.callBack	=	function(Response){
		deloadImage();
		var defaultCheck = checkResponseUrl(Response);
		if(defaultCheck){
			Response	=	Response.responseText;
			Response	=	JSON.parse(Response);
			if(IsValueNull(Response)){
				return false;
			}
			
			for(var i=0;i<Object.keys(Response).length;i++){ 
				var profileDivElement = $('[profileId='+Response[i].profileId+']').find('.proR').html(Response[i].profileResolution);
				if(Response[i].profileStatus != 2){
					profileDivElement.closest('.proEntry').removeClass('.inactive');
				}
				var indexOfProfile = ProfileResolutionIdArray.indexOf(Response[i].profileId);
				ProfileResolutionIdArray.splice(indexOfProfile, 1);
			}
			
			if(ProfileResolutionIdArray.length == 0){
				clearInterval(intervalResolution);
			}

		}
	};
	
	send_remoteCall(ajaxRequestObject);
	ajaxRequestObject	=	{};
}


function generateAssignedChannelTables() {

	if (assignedChannelIdList != null && assignedChannelIdList != '') {

		var channelTableHtml = '<div id="mainDiv">';
		for ( var key in assignedChannelIdList) {
			channelTableHtml += '<div class="rowDiv" chIden="'+key+'">';
			
			//For Channel Thumbnail
			channelTableHtml	+=	'<div align="center" class="channelContainer';
			if(assignedChannelIdList[key]['monitorStatus'] != '2'){
				channelTableHtml	+=	' inactiveChannelStatus';
			}
			channelTableHtml	+=	'">';
			channelTableHtml	+=	'<div class="chInfo wrapThis" title="'+assignedChannelIdList[key]['channelName']+' ( '+assignedChannelIdList[key]['nodeName']+' )'+'">'+assignedChannelIdList[key]['channelName']+' <span>( '+assignedChannelIdList[key]['nodeName']+' )</span></div>';
			channelTableHtml	+=	'<div class="bouqInfo" style="display:none;"><span class="infoHead">Group:</span>'+assignedChannelIdList[key]['bouquetName']+'</div>';
			channelTableHtml	+=	'<img src="./../../Common/images/tndefault.gif" class="tnimage" channelId="'+key+'" customValueOf="channel_'+key+'_thumb" customValueAs="attr" />';
			channelTableHtml	+=	'<div class="channelInfo" channel="'+key+'" align="center">';
			channelTableHtml	+=	'<div class="statusIcon" channel="'+key+'" align="center">';
			channelTableHtml	+=	'<div class="infoChannelStatus past c_p" title="Past Error Data" onclick="showHybridChannelPastStatusDiv(event);">Past Error</div>';
			channelTableHtml	+=	'<div class="infoChannelStatus present" title="Current Error Data"';
				//onclick="showHybridChannelStatusDiv('+key+');" For disabling past error link
			channelTableHtml	+=	'></div>';
			channelTableHtml	+=	'<div class="infoChannelAudio"><img src="./../../Common/images/speaker.gif" title="Audio presence"></div>';
			channelTableHtml	+=	'</div>';
			channelTableHtml	+=	'<div align="center" class="updateTimeContainer">Last Update <br /><span class="infoUpdateTime" ></span></div>';
			channelTableHtml	+=	'</div></div>';
			$('#channelsList').append('<option value="'+key+'">'+assignedChannelIdList[key]['channelName']+' - '+assignedChannelIdList[key]['nodeName']+'</option>');

			//For profile summary
			channelTableHtml 	+= '<div class="summaryDiv">';
			channelTableHtml 	+= '<div class="sumHybrid">Summary</div>';
			channelTableHtml 	+= '<div class="proHybrid">Profiles';
			var profOb	=	assignedChannelIdList[key]['profiles'];
			for(var key2 in profOb){
				channelTableHtml 	+= '<div class="proEntry';
				if(profOb[key2]['profileStatus'] == '2'){
					channelTableHtml 	+= ' inactive';
				}
				channelTableHtml 	+= '" profileId='+profOb[key2]['profileId']+'>';
				channelTableHtml 	+= '<div class="proN" >';
				channelTableHtml 	+= Math.floor(parseInt(profOb[key2]['profileInformation'])/1000);
				channelTableHtml 	+= ' Kbps </div>';
				channelTableHtml 	+= '<div class="proR" >';
				channelTableHtml 	+= profOb[key2]['profileResolution'];
				channelTableHtml 	+= '</div>';
				channelTableHtml 	+= '</div>';
				if(assignedChannelIdList[key]['monitorStatus'] == '2' && profOb[key2]['profileResolution'] == 'N.A.'){
					ProfileResolutionIdArray.push(profOb[key2]['profileId']);
				}
			}
			channelTableHtml 	+= '</div>';
			channelTableHtml 	+= '</div>';
			
			//For table view
			channelTableHtml 	+= 	'<div class="ErrorInfoContent" channel="'+key+'">';
			channelTableHtml 	+= 	'<table cellspacing="0" cellpadding="5" style="width:100%"><thead><tr>';
			channelTableHtml 	+= 	'<th colspan="5" style="display:none">Error List for last 15 minutes<span id="hoverDivChannelErrorCount" style="display:none">0</span></th></tr>';
			channelTableHtml 	+= 	'<tr><th align="left" >Profile</th><th align="left" >Error Type</th><th align="left" >Start Time (UTC)</th><th align="left" >Duration</th><th align="left" >Error Message</th></tr>';
			channelTableHtml 	+= 	'</thead><tbody></tbody></table>';
			channelTableHtml 	+= 	'<div class="channelInfoBodyDiv">';
			channelTableHtml 	+= 	'<table cellspacing="0" cellpadding="5" style="width:100%; table-layout: fixed;"><tbody id="channelInfoBody"></tbody></table>';
			channelTableHtml 	+= 	'</div>';
			channelTableHtml 	+= 	'</div>';
			channelTableHtml 	+= 	'</div>';
		}

		channelTableHtml 	+= 	'</div>';
		$('#ChannelMonitorHybrid').html(channelTableHtml);
		repeatCall();
		setInterval(repeatCall, TNDataPollTimeConstant);
		pollErrData();
		setInterval(pollErrData, ErrDataPollTimeConstant);
		startPastErrorModification();
		$('.infoUpdateTime').html(new Date().toLocaleTimeString('en-US', { hour12: false }));
		if(ProfileResolutionIdArray.length > 0){
			intervalResolution	=	setInterval(setProfileResolution, ProfileResoultionTimeConstant);
		}
	}

}
var intervalResolution	=	'';
var hybridNodeFlag = true;
var hybrid2NodeFlag = false;
var ProfileResoultionTimeConstant = 60*1000;
var ProfileResolutionIdArray = [];
var mutationTargetForProfileResolution = '.channelContainer';
var mutationTarget	=	'.inactiveChannelStatus';
var hyClearTimer = {};
var config = { attributes: true, childList: true, characterData: true, subtree: true, attributeFilter: ['src','text'] };
$(function() {
	generateAssignedChannelTables();
	instantDataTimeConstant	=	15*60*1000;	
//	callBacksFirstLevel.setDynamicWidth	=	function(){
//		$('.ErrorInfoContent').css('width',($('.rowDiv')[0].clientWidth-($('.channelContainer')[0].clientWidth+$('.summaryDiv')[0].clientWidth)-35).toString()+'px');
//	};
});
var setHybridClearTimer	=	function(ch){
	if(hyClearTimer[ch]){
		clearTimeout(hyClearTimer[ch]);
	}
	hyClearTimer[ch]	=	setTimeout(function(){
		$('.statusIcon[channel="'+ch+'"]').find('.infoChannelStatus.present.errorClass').removeClass('errorClass');
	},60*1000);
};
var getProfileResolutionInactive	=	function(channelId){
	for(var key in assignedChannelIdList[channelId].profiles){
		var currentProfile	=	assignedChannelIdList[channelId].profiles[key].profileId;
		if(ProfileResolutionIdArray.indexOf(currentProfile) == -1)
			ProfileResolutionIdArray.push(currentProfile);
	}
	clearInterval(intervalResolution);
	intervalResolution	=	setInterval(setProfileResolution, ProfileResoultionTimeConstant);
};