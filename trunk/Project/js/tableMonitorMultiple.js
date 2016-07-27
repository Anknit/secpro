var hybridNodeFlag = false;

var defaultMonitoringStatus	=	function(chId){
//	if($('.rowDiv[chIden="'+chId+'"]').find('.channelContainer').not('inactiveChannelStatus')){
//		$('.rowDiv[chIden="'+chId+'"]').find('.channelContainer').addClass('inactiveChannelStatus');
//		$('img[channelId="'+chId+'"]').attr('src', './../../Common/images/tndefault.gif');
//	}
	if($('.monitorProfileTable[channel="'+chId+'"]').not('inactiveChannelStatus')){
		$('.monitorProfileTable[channel="'+chId+'"]').addClass('inactiveChannelStatus');
	}
	
	if($('.channelInfo .statusIcon[channel="'+chId+'"]').not('inactiveChannelStatus')){
		$('.channelInfo .statusIcon[channel="'+chId+'"]').addClass('inactiveChannelStatus');
	}
	
};

var changeMonitoringStatus	=	function(chId){
	
//	if($('.rowDiv[chIden="'+chId+'"]').find('.channelContainer').hasClass('inactiveChannelStatus')){
//		$('.rowDiv[chIden="'+chId+'"]').find('.channelContainer').removeClass('inactiveChannelStatus');
//	}
	var elem = $('.inactiveChannelStatus .infoChannelStatus.present').closest('.inactiveChannelStatus[channel="'+chId+'"]');
	if($(elem).hasClass('inactiveChannelStatus')){
		$(elem).removeClass('inactiveChannelStatus');
	}
};

$(function(){
	generateAssignedChannelTables();
});
var generateAssignedChannelTables	=	function(){
	var channelTableHtml	=	'';
	var channelTableHead	=	'';
	var channelTableBody	=	'';
	var profobj	=	'';
	var uniqueChannelNames	=	new Object();
	var uniqueNodeNames		=	new Array();
	var nodeChannelPresence	=	false;
	if(assignedChannelIdList != null && assignedChannelIdList != ''){
		channelTableHtml		+=	'<table id="operatorChannelsTable" style="width:100%;">';
		channelTableHead		+=	'<thead><tr><th width="15%">Source</th>';
		channelTableBody		+=	'<tbody>';
		for(var key in assignedChannelIdList){
			$('#channelsList').append('<option value="'+key+'">'+assignedChannelIdList[key]['channelName']+'</option>');
			if(uniqueNodeNames.indexOf(assignedChannelIdList[key]['nodeId']) == -1){
				uniqueNodeNames.push(assignedChannelIdList[key]['nodeId']);
				channelTableHead	+=	'<th>'+assignedChannelIdList[key]['nodeName']+'</th>';
			}
			if(Object.keys(uniqueChannelNames).indexOf(assignedChannelIdList[key]['channelName']) == -1){
				uniqueChannelNames[assignedChannelIdList[key]['channelName']] = new Array();
			}
			uniqueChannelNames[assignedChannelIdList[key]['channelName']].push(assignedChannelIdList[key]['channelId']);
		}
		for(var key in uniqueChannelNames){
			channelTableBody	+=	'<tr class="channelInfo" channel="'+uniqueChannelNames[key][0]+'" channelRefName='+key+'>';
			channelTableBody	+=	'<td><div align="center"><div class="chInfo">'+key+'</div></div>';
			channelTableBody	+=	'<div align="center">Last Update <span class="infoUpdateTime" ></span></div></td>';
			for(cc=0;cc<uniqueNodeNames.length;cc++){
				channelTableBody	+=	'<td noderef='+uniqueNodeNames[cc]+'>';
				for(dd=0;dd<uniqueChannelNames[key].length;dd++){
					if(assignedChannelIdList[uniqueChannelNames[key][dd]]['nodeId'] == uniqueNodeNames[cc]){
						channelTableBody	+=	'<table class="monitorProfileTable';
						if(assignedChannelIdList[uniqueChannelNames[key][dd]]['monitorStatus'] != '2'){
							channelTableBody	+=	' inactiveChannelStatus';
						}
						channelTableBody	+=	'" channel="'+uniqueChannelNames[key][dd]+'">';
						profobj	=	assignedChannelIdList[uniqueChannelNames[key][dd]]['profiles'];
						for(var key1 in profobj){
							if(profobj[key1]['profileStatus'] == '1'){
								channelTableBody	+=	'<tr><td>'+Math.floor(parseInt(profobj[key1]['profileInformation'])/1000)+' kbps</td></tr>';
							}
						}
						channelTableBody	+=	'<tr><td><div class="statusIcon " channel="'+uniqueChannelNames[key][dd]+'" align="center">';
						channelTableBody	+=	'<div class="infoChannelStatus past c_p" title="Past Error Data" onclick="showChannelPastStatusDiv(event);">Past Error</div>';
						channelTableBody	+=	'<div class="infoChannelStatus present c_p" title="Current Error Data" onclick="showChannelStatusDiv(event);"></div>';
						channelTableBody	+=	'</div></td></tr>';
						channelTableBody	+=	'</table>';
						nodeChannelPresence	=	true;
						break;
					}
				}
				if(!nodeChannelPresence){
					channelTableBody	+=	'&nbsp;';
				}
				channelTableBody	+=	'</td>';
				nodeChannelPresence	=	false;
			}
		}
		channelTableHead	+=	'</tr></thead>';
		channelTableBody	+=	'</tbody>';
		channelTableHtml	+=	channelTableHead;
		channelTableHtml	+=	channelTableBody;
		channelTableHtml	+=	'</table>';
		$('#ChannelMonitortable').html(channelTableHtml);
//		repeatCall();
//		setInterval(repeatCall, TNDataPollTimeConstant);
		pollErrData();
		setInterval(pollErrData, ErrDataPollTimeConstant);
		startPastErrorModification();
		$('.infoUpdateTime').html(new Date().toLocaleTimeString('en-US', { hour12: false }));
	}
};
var hybridNodeFlag = false;
var hybrid2NodeFlag = false;
//var mutationTarget	=	'.inactiveChannelStatus .infoChannelStatus.present';
//var config = { attributes: true, childList: true, characterData: true, subtree: true, attributeFilter: ['class'] };