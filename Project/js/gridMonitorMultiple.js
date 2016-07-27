/*
* Author: Ankit
* date: 21-Feb-2015
* Description: This file create grid based monitoring UI for operator (Single Node Interface)
*/
var hybridNodeFlag = false;

var defaultMonitoringStatus	=	function(chId){
	if($('.statusIcon[channel="'+chId+'"]').closest('.channelContainer').not('inactiveChannelStatus')){
		$('.statusIcon[channel="'+chId+'"]').closest('.channelContainer').addClass('inactiveChannelStatus');
		$('img[channelId="'+chId+'"]').attr('src', './../../Common/images/tndefault.gif');
	}
};

var changeMonitoringStatus	=	function(chId){
	
	if($('.statusIcon[channel="'+chId+'"]').closest('.channelContainer').hasClass('inactiveChannelStatus')){
		$('.statusIcon[channel="'+chId+'"]').closest('.channelContainer').removeClass('inactiveChannelStatus');
	}
};
$(function(){
	generateAssignedChannelTables();
});
var generateAssignedChannelTables	=	function(){
	var channelTableHtml	=	'<div style="display: block;margin: auto;width: 100%;text-align: center;">';
	if(assignedChannelIdList != null && assignedChannelIdList != ''){
		for(var key in assignedChannelIdList){
			channelTableHtml	+=	'<div align="center" class="channelContainer';
			if(assignedChannelIdList[key]['monitorStatus'] != '2'){
				channelTableHtml	+=	' inactiveChannelStatus';
			}
			channelTableHtml	+=	'">';
			channelTableHtml	+=	'<div class="chInfo wrapThis" title="'+assignedChannelIdList[key]['channelName']+' - '+assignedChannelIdList[key]['nodeName']+'">'+assignedChannelIdList[key]['channelName']+' - <span>'+assignedChannelIdList[key]['nodeName']+'</span></div>';
			channelTableHtml	+=	'<div class="bouqInfo"><span class="infoHead">Group:</span>'+assignedChannelIdList[key]['bouquetName']+'</div>';
			channelTableHtml	+=	'<img src="./../../Common/images/tndefault.gif" class="tnimage" channelId="'+key+'" customValueOf="channel_'+key+'_thumb" customValueAs="attr" />';
			channelTableHtml	+=	'<div class="channelInfo" channel="'+key+'" align="center">';
			channelTableHtml	+=	'<div class="statusIcon" channel="'+key+'" align="center">';
			channelTableHtml	+=	'<div class="infoChannelStatus past c_p" title="Past Error Data" onclick="showChannelPastStatusDiv(event);">Past Error</div>';
			channelTableHtml	+=	'<div class="infoChannelStatus present c_p" title="Current Error Data" onclick="showChannelStatusDiv(event);"></div>';
			channelTableHtml	+=	'<div class="infoChannelAudio"><img src="./../../Common/images/speaker.gif" title="Audio presence"></div>';
			channelTableHtml	+=	'</div>';
			channelTableHtml	+=	'<div align="right" class="updateTimeContainer">Last Update <span class="infoUpdateTime" ></span></div>';
			channelTableHtml	+=	'</div></div>';
			$('#channelsList').append('<option value="'+key+'">'+assignedChannelIdList[key]['channelName']+' - '+assignedChannelIdList[key]['nodeName']+'</option>');
		}
		channelTableHtml	+=	'</div>';
		$('#ChannelMonitorgrid').html(channelTableHtml);
		repeatCall();
		setInterval(repeatCall, TNDataPollTimeConstant);
		pollErrData();
		setInterval(pollErrData, ErrDataPollTimeConstant);
		startPastErrorModification();
		$('.infoUpdateTime').html(new Date().toLocaleTimeString('en-US', { hour12: false }));
	}
};
var hybridNodeFlag = false;
var hybrid2NodeFlag = false;
//var mutationTarget	=	'.inactiveChannelStatus';
//var config = { attributes: true, childList: true, characterData: true, subtree: true, attributeFilter: ['src','text'] };