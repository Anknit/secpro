var defaultMonitoringStatus	=	function(chId){
	if($('.channelListDiv[channel='+chId+']').hasClass('newErrorClass')){
		$('.channelListDiv[channel='+chId+']').removeClass('newErrorClass');
	}
	if($('.channelListDiv[channel='+chId+']').hasClass('monitoringStarted')){
		$('.channelListDiv[channel='+chId+']').removeClass('monitoringStarted');
	}
	if($('.rowDiv[chIden="'+chId+'"]').find('.channelContainer').not('inactiveChannelStatus')){
		$('.rowDiv[chIden="'+chId+'"]').find('.channelContainer').addClass('inactiveChannelStatus');
		$('img[channelId="'+chId+'"]').attr('src', './../../Common/images/tndefault.gif');
	}
};

var changeMonitoringStatus	=	function(chId){
	if($('.channelListDiv[channel='+chId+']').hasClass('newErrorClass')){
		return false;
	}
	$('.channelListDiv[channel='+chId+']').not('monitoringStarted').addClass('monitoringStarted');
	
	if($('.rowDiv[chIden="'+chId+'"]').find('.channelContainer').hasClass('inactiveChannelStatus')){
		$('.rowDiv[chIden="'+chId+'"]').find('.channelContainer').removeClass('inactiveChannelStatus');
	}
	getProfileResolutionInactive(chId);
};

var hideHybrid2RowDiv	=	function(chI){
	if(!$('.rowDiv[chIden="'+chI+'"]').hasClass('pinned')){
		$('.rowDiv[chIden="'+chI+'"]').addClass('newDiv');
	}
//	$('.channelListDiv[channel="'+chI+'"]').hasClass('newErrorClass').removeClass('newErrorClass');
//	$('.channelListDiv[channel="'+chI+'"]').not('monitoringStarted').addClass('monitoringStarted');
};

var updateHybrid2NodeTime	=	function(chID){
	$('.tooltipDiv[chKey="'+chID+'"]').find('.infoUpdateTime').html(new Date().toLocaleTimeString('en-US', { hour12: false }));
};

var showHybridChannelStatusDiv	=	function(chI){

	var channelId	=	chI;
	if($('.rowDiv[chIden="'+channelId+'"]').find('.channelContainer').hasClass('inactiveChannelStatus')){
		return false;
	}
	errCount	=	0;
	if($('.rowDiv[chIden="'+chI+'"]').hasClass('newDiv')){
		$('.rowDiv[chIden="'+chI+'"]').removeClass('newDiv');
	}
	
	if($('.channelListDiv[channel="'+chId+'"]').hasClass('monitoringStarted')){
		$('.channelListDiv[channel="'+chId+'"]').removeClass('monitoringStarted');
	}
	$('.channelListDiv[channel="'+chId+'"]').not('.newErrorClass').addClass('newErrorClass');
	$('.ErrorInfoContent[channel='+channelId+']').find('#channelInfoBody').html('');
	var tableBodyStr	=	'';
	var rowElement	=	'';
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
				tableBodyStr	+=	'</div></td></tr>';
			}
		}
	}
	$('.ErrorInfoContent[channel='+channelId+']').find('#channelInfoBody').html(tableBodyStr);
	$('.ErrorInfoContent[channel='+channelId+']').find('#hoverDivChannelErrorCount').html(errCount);

	if(!$('.rowDiv[chIden="'+channelId+'"]').hasClass('pinned')){
		if($( "#mainDiv .rowDiv.unpinned" ).first().attr('chIden') != channelId){	//
			rowElement = $('.rowDiv[chIden="'+channelId+'"]').detach();
			
			if ($('.rowDiv.pinned').length) {
				$('.rowDiv.pinned').last().after(rowElement);
			}else {
				$('#mainDiv').prepend(rowElement);
			}
			
			var channelInfoBodyDivElem = $('.ErrorInfoContent[channel='+channelId+']').find('.channelInfoBodyDiv')[0];
			scrollToBottom(channelInfoBodyDivElem);
		}else{
			var scrollDivElem = $('.ErrorInfoContent[channel='+channelId+']').find('.channelInfoBodyDiv')[0];
			animateScrollToBottom(scrollDivElem);
		}
	}
	else{
		var scrollDivElem = $('.ErrorInfoContent[channel='+channelId+']').find('.channelInfoBodyDiv')[0];
		animateScrollToBottom(scrollDivElem);
	}
		
	setHybridClearTimer(channelId);
};

var animateScrollToBottom	=	function(scrollDivElem){
	if(!IsValueNull(scrollDivElem)){
		$(scrollDivElem).animate({ scrollTop: scrollDivElem.scrollHeight}, 1000);
	}
};

var scrollToBottom	=	function(scrollDivElem){
	if(!IsValueNull(scrollDivElem)){
		$(scrollDivElem).scrollTop(scrollDivElem.scrollHeight);
	}
};

var bindPinEvents	=	function(event){
	
	var pinDivElem	=	$(event.currentTarget);
	var pinnedDivChannelId	=	pinDivElem.attr('pinId');
	
	if(pinDivElem.hasClass('pinned')){
		
		removePinned(pinnedDivChannelId);
		
	}else{
		
		addPinned(pinnedDivChannelId);
	}
	
	changeUnpinIconStatusDynamically();

};

var addPinned	=	function(pinnedDivChannelId){
	var scrollFlag = 1;
	$('[pinId="'+pinnedDivChannelId+'"').removeClass('unpinned').addClass('pinned');
	var pinCounter	=	increasedPinCounter();
//	$('.rowDiv.pinned[pinId="'+pinnedDivChannelId+'"], .channelListDiv.pinned[pinId="'+pinnedDivChannelId+'"]').attr('pinOrder',pinCounter);
	$('.rowDiv.pinned[pinId="'+pinnedDivChannelId+'"]').attr('pinOrder',pinCounter);
	
	if($('.rowDiv[chIden="'+pinnedDivChannelId+'"]').hasClass('newDiv')){
		$('.rowDiv[chIden="'+pinnedDivChannelId+'"]').removeClass('newDiv');
		scrollFlag	=	0;
	}
	
	if($( "#mainDiv .rowDiv" ).first().attr('chIden') != pinnedDivChannelId){
		var rowNode = $('.rowDiv[chIden="'+pinnedDivChannelId+'"]').detach();
		
		if ($('.rowDiv.unpinned').length) {
			$('.rowDiv.unpinned').first().before(rowNode);
		} else {
			$("#mainDiv").append(rowNode);
		}
		
		if(scrollFlag){
			var channelInfoBodyDivElem = $('.ErrorInfoContent[channel='+pinnedDivChannelId+']').find('.channelInfoBodyDiv')[0];
			scrollToBottom(channelInfoBodyDivElem);
		}
		
	}else if(scrollFlag){
		var channelInfoBodyDivElem = $('.ErrorInfoContent[channel='+pinnedDivChannelId+']').find('.channelInfoBodyDiv')[0];
		animateScrollToBottom(channelInfoBodyDivElem);
	}
};

var removePinned	=	function(pinnedDivChannelId){
	
	$('[pinId="'+pinnedDivChannelId+'"').removeClass('pinned').addClass('unpinned');
//	$('.rowDiv.pinned[pinId="'+pinnedDivChannelId+'"], .channelListDiv.pinned[pinId="'+pinnedDivChannelId+'"]').attr('pinOrder','');
	$('.rowDiv.pinned[pinId="'+pinnedDivChannelId+'"]').attr('pinOrder','');
	
	var rowNode = $('.rowDiv[chIden="'+pinnedDivChannelId+'"]').detach();
	if ($('.rowDiv.pinned').length) {
		$('.rowDiv.pinned').last().after(rowNode);
	}else {
		$("#mainDiv").prepend(rowNode);
	}
	
	if(!$('.channelListDiv[channel='+pinnedDivChannelId+']').hasClass('newErrorClass')){
		$('.rowDiv[chIden="'+pinnedDivChannelId+'"]').addClass('newDiv');
	}else{
		// scroll to bottom
		var channelInfoBodyDivElem = $('.ErrorInfoContent[channel='+pinnedDivChannelId+']').find('.channelInfoBodyDiv')[0];
		scrollToBottom(channelInfoBodyDivElem);
	}
};

var unpinAll	=	function(){
	
	$('.channelListDiv.pinned').map(function() {
		var pinnedDivChannelId	=	$(this).attr('pinId');
		removePinned(pinnedDivChannelId);
	});
	
	var localStorageElem	=	'pinnedSettingsFor'+userID;
	removeStorageData(localStorageElem);
};

var savePinnedChannelToLocalStorage	=	function(){
	if (typeof (Storage) !== "undefined") {

		var pinnedSettingsObj = {};
		pinnedSettingsObj[userID]	=	{};
		$('.rowDiv.pinned').map(function() {
			var pinId = $(this).attr('pinId');
			var pinOrder = $(this).attr('pinOrder');

			pinnedSettingsObj[userID][pinOrder]	=	{
				'pinId' : pinId,
				'pinOrder' : pinOrder
			};
		});

		var localStorageElem	=	'pinnedSettingsFor'+userID;
		var pinnedSettingsStr	=	JSON.stringify(pinnedSettingsObj);
		setStorageData(localStorageElem, pinnedSettingsStr);
		
	} else {
		erMsg = 'Sorry, your browser does not support web storage and hence pinned channels could not be saved.';
		AlertMessage({msg:erMsg});
	}
};

var pinSavedChannelsFromLocalStorage	=	function(){
	if (typeof (Storage) !== "undefined") {
		var localElem	=	'pinnedSettingsFor'+userID;
		var localElemVal	=	getStorageData(localElem);
		if(!IsValueNull(localElemVal)){
			try{
				var pinnedSettings	=	JSON.parse(localElemVal);
			}catch(e){
				removeStorageData(localElem);
				erMsg = 'Corrupted pinned settings found. Pinned channels settings have been deleted.';
				AlertMessage({msg:erMsg});
				return false;
			}
			
			if(!IsValueNull(pinnedSettings[userID])){
				var pinnedSettingsObj	=	pinnedSettings[userID];
				
				for(var key in pinnedSettingsObj){
					var pinnedDivChannelId	=	pinnedSettingsObj[key]['pinId'];
					addPinned(pinnedDivChannelId);
				}
			}
		}
	}
};

var setStorageData	=	function(localStorageElem, localStorageElemValue){
	localStorage.setItem(localStorageElem, localStorageElemValue);
};

var getStorageData	=	function(localStorageElem){
	var localStorageElemVal	=	localStorage.getItem(localStorageElem);
	return localStorageElemVal;
};

var removeStorageData	=	function(localStorageElem){
	localStorage.removeItem(localStorageElem);
};

var addUnpinAllIcon	=	function(){
	
	if($('.channelListDiv').length){
		var unpinIconHtml	=	'';
		
		if($('.channelListDiv.pinned').length){
			unpinIconHtml	=	'<div class="unpinAllIcon disableUserSelect" title="Unpin all pinned Channels.">&#128204;</div>';
		}else{
			unpinIconHtml	=	'<div class="unpinAllIcon disableUnpinAll disableUserSelect" title="Unpin all pinned Channels.">&#128204;</div>';
		}
		
		$('#HomePageMonitor').append(unpinIconHtml);	
		$('#HomePageMonitor').on('click','.unpinAllIcon',unpinIconHandler);
		$('.unpinAllIcon').draggable({
			  containment: "parent"
		});
	}
	
};

var unpinIconHandler	=	function(event){
	
	if($('.channelListDiv.pinned').length){
		unpinAll();
		changeUnpinIconStatusDynamically();
	}
//	else{
//		erMsg = 'No channels to Unpin.';
//		AlertMessage({msg:erMsg});
//	}
	
};

var changeUnpinIconStatusDynamically	=	function(){
	
	var unpinAllElem	=	$('.unpinAllIcon');
	
	if($('.channelListDiv.pinned').length){
		unpinAllElem.removeClass('disableUnpinAll');
	}else{
		unpinAllElem.addClass('disableUnpinAll');
	}
	
};

var upArrowHandler	=	function(event){
	
	var eventElem			=	$(event.currentTarget);
	var elemParent 			=	eventElem.closest('.rowDiv.pinned');
	var elemParentPinOrder	=	elemParent.attr('pinOrder');
	var prevElem			=	elemParent.prev('.rowDiv.pinned');
	var prevElemPinOrder	=	prevElem.attr('pinOrder');
	
	if(prevElem.length){
		var detachedElem	=	elemParent.detach();
		prevElem.before(detachedElem);
		
		//swap pin order		
		elemParent.attr('pinOrder',prevElemPinOrder);
		prevElem.attr('pinOrder',elemParentPinOrder);
	}
	
};

var downArrowHandler	=	function(event){
	
	var eventElem			=	$(event.currentTarget);
	var elemParent 			=	eventElem.closest('.rowDiv.pinned');
	var elemParentPinOrder	=	elemParent.attr('pinOrder');
	var nextElem			=	elemParent.next('.rowDiv.pinned');
	var nextElemPinOrder	=	nextElem.attr('pinOrder');
	
	if(nextElem.length){
		var detachedElem	=	elemParent.detach();
		nextElem.after(detachedElem);
		
		//swap pin order
		elemParent.attr('pinOrder',nextElemPinOrder);
		nextElem.attr('pinOrder',elemParentPinOrder);
	}
	
};

function setProfileResolution(){
	
	var ProfileResolutionIdArrayString = ProfileResolutionIdArray.toString();
	ajaxRequestObject.actionScriptURL	=	'./../UserInterface/fetchData.php?data=profileResolution&profileId='+ProfileResolutionIdArrayString;
	ajaxRequestObject.sendMethod	=	'GET';
	ajaxRequestObject.callType	=	'SYNC';
	ajaxRequestObject.responseType	=	1;
	ajaxRequestObject.callBack	=	function(Response){
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
		var	channelListDiv	=	'';		
		for ( var key in assignedChannelIdList) {
			var	profileTooltip	=	'';
			channelTableHtml += '<div class="rowDiv newDiv unpinned" pinId="'+key+'" chIden="'+key+'">';
			channelTableHtml	+=	'<div class="upArrow c_p disableUserSelect" >&#9650;</div><div class="downArrow c_p disableUserSelect">&#9660;</div>';
			channelTableHtml	+=	'<div class="pinIcon unpinned disableUserSelect pinnable rowDivPin c_p" pinId="'+key+'">&#128204;</div>';
			
			//For Channel Thumbnail
			channelTableHtml	+=	'<div align="center" class="channelContainer';
			if(assignedChannelIdList[key]['monitorStatus'] != '2'){
				channelTableHtml	+=	' inactiveChannelStatus';
			}
			channelTableHtml	+=	'">';
			channelTableHtml	+=	'<div class="chInfo wrapthis" title="'+assignedChannelIdList[key]['channelName']+' ( '+assignedChannelIdList[key]['nodeName']+' )'+'">'+assignedChannelIdList[key]['channelName']+' <span>( '+assignedChannelIdList[key]['nodeName']+' )</span></div>';
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
			profileTooltip 		= '<div class="proHybrid">Profiles';
			var profOb	=	assignedChannelIdList[key]['profiles'];
			for(var key2 in profOb){
				profileTooltip 	+= '<div class="proEntry';
				if(profOb[key2]['profileStatus'] == '2'){
					profileTooltip 	+= ' inactive';
				}
				profileTooltip 	+= '" profileId='+profOb[key2]['profileId']+'>';
				profileTooltip 	+= '<div class="proN" >';
				profileTooltip 	+= Math.floor(parseInt(profOb[key2]['profileInformation'])/1000);
				profileTooltip 	+= ' Kbps </div>';
				profileTooltip 	+= '<div class="proR" >';
				profileTooltip 	+= profOb[key2]['profileResolution'];
				profileTooltip 	+= '</div>';
				profileTooltip 	+= '</div>';
				if(assignedChannelIdList[key]['monitorStatus'] == '2' && profOb[key2]['profileResolution'] == 'N.A.'){
					ProfileResolutionIdArray.push(profOb[key2]['profileId']);
				}
			}
			profileTooltip	 	+= '</div>';
			channelTableHtml	+=	profileTooltip;
			channelTableHtml 	+= '</div>';
			
			//For table view
			channelTableHtml 	+= 	'<div class="ErrorInfoContent" channel="'+key+'">';
			channelTableHtml 	+= 	'<table cellspacing="0" cellpadding="5" style="width:100%;"><thead><tr>';
			channelTableHtml 	+= 	'<th colspan="5" style="display:none">Error List for last 15 minutes<span id="hoverDivChannelErrorCount" style="display:none">0</span></th></tr>';
			channelTableHtml 	+= 	'<tr><th align="left" >Profile</th><th align="left" >Error Type</th><th align="left" >Start Time (UTC)</th><th align="left" >Duration</th><th align="left" >Error Message</th></tr>';
			channelTableHtml 	+= 	'</thead><tbody></tbody></table>';
			channelTableHtml 	+= 	'<div class="channelInfoBodyDiv">';
			channelTableHtml 	+= 	'<table cellspacing="0" cellpadding="5" style="width:100%;"><tbody id="channelInfoBody"></tbody></table>';
			channelTableHtml 	+= 	'</div>';
			channelTableHtml 	+= 	'</div>';
			channelTableHtml 	+= 	'</div>';
			
			//For channel list window div
			channelListDiv	+=	'<div class="channelListDiv disableUserSelect d_p unpinned" pinId="'+key+'" channel="'+key+'" tooltipData="<div class=\'tooltipDiv\' chKey='+key+'>';
			channelListDiv	+=	'<div class=\'tooltipChannel\'><span class=\'tooltipChannelText\'>'+assignedChannelIdList[key]['channelName']+' </span>( '+assignedChannelIdList[key]['nodeName']+') </div>';
			channelListDiv	+=	'<div class=\'tooltipUrl\'><span class=\'tooltipUrlText\'> Source URL: </span>'+assignedChannelIdList[key]['channelUrl']+'</div>';
			channelListDiv	+=	profileTooltip.replace(/\"/g,"\\'")+'<div class=\'tooltipUpdateTimeContainer\'><span class=\'tooltipUpdateTimeContainerText\'> Last Update </span><span class=\'infoUpdateTime\' ></span></div></div>">';
			channelListDiv	+=	'<div class="pinIcon pinnable unpinned listDivPin c_p" title="Pin this Channel." pinId="'+key+'">&#128204;</div>';
			channelListDiv	+=	'<div>'+assignedChannelIdList[key]['channelName']+'<span> ( '+assignedChannelIdList[key]['nodeName']+' )</span></div>';
			channelListDiv	+=	'</div>';
		}

		channelTableHtml 	+= 	'</div>';
		$('#ChannelMonitorHybrid').html(channelTableHtml);
		$('#HybridBottomPanel').html(channelListDiv);
		$('[tooltipData]').each(function(){
			$(this).jqxTooltip({ width: 300, content: $(this).attr('tooltipData').replace(/\\'/g,"'"), position: 'top', autoHideDelay: 0, name: 'channelTooltip'});
		});
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
var hybrid2NodeFlag = true;
var ProfileResoultionTimeConstant = 60*1000;
var ProfileResolutionIdArray = [];
//var mutationTargetForProfileResolution = '.channelContainer';
//var mutationTarget	=	'.inactiveChannelStatus';
var hyClearTimer = {};
//var config = { attributes: true, childList: true, characterData: true, subtree: true, attributeFilter: ['src','text'] };

//JavaScript Closure function to increase the pin counter whenever a channel is pinned
var increasedPinCounter = (function () {
    var counter = 0;
    return function () {return counter += 1;}
})();

$(function() {
	generateAssignedChannelTables();
	instantDataTimeConstant	=	15*60*1000;	
//	callBacksFirstLevel.setDynamicWidth	=	function(){
//		$('.ErrorInfoContent').css('width',($('.rowDiv')[0].clientWidth-($('.channelContainer')[0].clientWidth+$('.summaryDiv')[0].clientWidth)-35).toString()+'px');
//	};
	//For jqxSplitter
	$('#mainSplitter').jqxSplitter({ width: '100%', height: '100%', splitBarSize: 10, orientation: 'horizontal', panels: [{ size: '76%', collapsible: false }, { size: '24%', collapsible: true }] });
	
	// Bind pin events to channel List Div and save them to local storage
	$('.pinnable').on('click',function(event){bindPinEvents(event);savePinnedChannelToLocalStorage(event);});
	
	// Bind up down pinning arrow events
	$('.upArrow').on('click',function(event){upArrowHandler(event);savePinnedChannelToLocalStorage(event);});
	$('.downArrow').on('click',function(event){downArrowHandler(event);savePinnedChannelToLocalStorage(event);});
	
	// pin Saved Channels From Local Storage
	pinSavedChannelsFromLocalStorage();
	
	addUnpinAllIcon();
});

var setHybridClearTimer	=	function(ch){
	if(hyClearTimer[ch]){
		clearTimeout(hyClearTimer[ch]);
	}
	hyClearTimer[ch]	=	setTimeout(function(){
		$('.statusIcon[channel="'+ch+'"]').find('.infoChannelStatus.present.errorClass').removeClass('errorClass');
//		$('.channelListDiv[channel='+ch+']').removeClass('newErrorClass').addClass('monitoringStarted');
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