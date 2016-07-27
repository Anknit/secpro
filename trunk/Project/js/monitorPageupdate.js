/*
* Author: Ankit
* date: 21-Feb-2015
* Description: This file defines functions for monitor page update
*/

var sessionStartTime	=	new Date();
sessionStartTime	=	sessionStartTime.getTime()/1000;
var htmlDataObject	=	new Object();
var channelIDarray	=	new Array();
var channelIDERRarray	=	new Array();
var completeChannelErrorObject	=	new Object();
var storedTimeLimit	=	1;	//configure error data expiration minutes
var xhr = '';
var j = 0;
var blob = '';
var storeErrorObject		=	new Object();
var LastErrorTimeObject		=	new Object();
var instantDataTimeConstant	=	60*1000;	// time interval window for current error data
var clearErrTimeOutConstant	=	15*60*1000; // time interval to store past error data 
var ErrDataPollTimeConstant	=	6*1000;		// error data polling frequency
var TNDataPollTimeConstant	=	15*1000;	// Tn data polling frequency
var loginUpdateTimeConstant =	1;			//Time in minutes after which operator login details should be saved | Depends on ErrDataPollTimeConstant
var staticLoginUpdateTimeConstant = 10*loginUpdateTimeConstant;

$(function(){
	if(!hybrid2NodeFlag){
		getInitialChannelErrorState();
	}
//	if($(mutationTarget).length > 0){
//		setMutationEvent();
//	}
});
function startPastErrorModification(){
	setInterval(function(){modifyPastError();},ErrDataPollTimeConstant);
}

function repeatCall(){
	ajaxRequestObject.actionScriptURL	=	'./../ControllerNotification/monitorDataRequest.php?Operation=TN&userId='+userID;
	ajaxRequestObject.sendMethod	=	'GET';
	ajaxRequestObject.responseType	=	1;
	ajaxRequestObject.callBack	=	function(Response){
		deloadImage();
		var defaultCheck = checkResponseUrl(Response);
		if(defaultCheck){
			Response	=	Response.responseText;
			if(IsValueNull(Response)){
				return false;
			}
			Response	=	JSON.parse(Response);
			if(typeof(Response) == "string"){
				channelIDarray.push(Response);
			}
			else{
				channelIDarray	=	Response;
			}
		}
	};
	send_remoteCall(ajaxRequestObject);
	ajaxRequestObject	=	{};
	for(i=0;i<channelIDarray.length;i++){
		blobBinarydata(channelIDarray[i],j);
	}

	updateChannelTNToDefault(channelIDarray);
	venera_update_data(htmlDataObject);
	htmlDataObject={};
	
	channelIDarray	=	[];
	j++;
}

function blobBinarydata(ChannelID,j){
	window.URL = window.URL || window.webkitURL;
	TNimagePath	=	SERVER_ROOT+"/tndir/";

	htmlDataObject[$('img[channelId="'+ChannelID+'"]').attr('customValueOf')]	=	{'src': TNimagePath+ChannelID+".jpeg?t="+j};
	$('.channelInfo[channel="'+ChannelID+'"]').find('.infoUpdateTime').html(new Date().toLocaleTimeString('en-US', { hour12: false }));
	
	if(hybrid2NodeFlag){
		updateHybrid2NodeTime(ChannelID); 	//To update the time of tooltip in hybrid2layout
	}

}

// To change the thumbnail to default status ("NO Preview") when no thumnbnail is generated
var updateChannelTNToDefault = function(channelIDarray){
	
//	console.log(channelIDarray +' : '+(new Date()).getSeconds());
	for(var x in completeChannelErrorObject){
		if(!in_array(x,channelIDarray)){
			$('img[channelId="'+x+'"]').attr('src', './../../Common/images/tndefault.gif');
		}
	}

};

var updateLoginParam	=	function(){
	var result = '';
	if(staticLoginUpdateTimeConstant == 0){
		staticLoginUpdateTimeConstant = loginUpdateTimeConstant*10;
		result = loginUpdateTimeConstant;
	}else{
		staticLoginUpdateTimeConstant--;
	}
	
	return result;
};

var pollErrData	=	function(){
	var loginTimeConstant = updateLoginParam();
	ajaxRequestObject.actionScriptURL	=	'./../ControllerNotification/monitorDataRequest.php?Operation=ERR&userId='+userID+'&loginUpdateConst='+loginTimeConstant;
	ajaxRequestObject.sendMethod	=	'GET';
	ajaxRequestObject.responseType	=	1;
	ajaxRequestObject.callBack	=	function(Response){
			deloadImage();
			var defaultCheck = checkResponseUrl(Response);
			if(defaultCheck){
			Response	=	Response.responseText;
//			console.log('Raw Response: '+Response);
			for(var cha	in completeChannelErrorObject){
				completeChannelErrorObject[cha]['audio']	=	true;
			}
			if(IsValueNull(Response)){
				for(var cha	in completeChannelErrorObject){
					if(completeChannelErrorObject[cha]['audio']	==	false){
						$('.channelInfo[channel="'+cha+'"]').find('.infoChannelAudio img').attr({'src':'./../../Common/images/speakerMute.gif','title':'Audio absent'});
					}
					else{
						$('.channelInfo[channel="'+cha+'"]').find('.infoChannelAudio img').attr({'src':'./../../Common/images/speaker.gif','title':'Audio present'});
					}
				}
				return false;
			}
			Response	=	JSON.parse(Response);
			
//			Code to check whether there is some account error returned
			if(Response === "E1"){
				AlertMessage({'msg':'Your account credit minutes has been exhausted. Please contact your account manager to refill the credits'});
				return false;
			}
			else if(Response === "E2"){
				AlertMessage({'msg':'Your account has been deactivated. Please contact your registering authority'});
				return false;
			}
//			Code block finished
			
			else if(typeof(Response) == "string"){
				channelIDERRarray.push(Response);
			}
			else{
				channelIDERRarray	=	Response;
			}
			Response	=	'';
			for(i=0;i<channelIDERRarray.length;i++){
				updateChannelStatusInfo(channelIDERRarray[i]);
			}
			for(var cha	in completeChannelErrorObject){
				if(completeChannelErrorObject[cha]['audio']	==	false){
					$('.channelInfo[channel="'+cha+'"]').find('.infoChannelAudio img').attr({'src':'./../../Common/images/speakerMute.gif','title':'Audio absent'});
				}
				else{
					$('.channelInfo[channel="'+cha+'"]').find('.infoChannelAudio img').attr({'src':'./../../Common/images/speaker.gif','title':'Audio present'});
				}
			}
			venera_update_data(htmlDataObject);
			htmlDataObject={};
			channelIDERRarray	=	[];
		}
	};
	send_remoteCall(ajaxRequestObject);
	ajaxRequestObject	=	{};
	clearError();
};

var updateChannelStatusInfo	=	function(ChannelInfo){
//	console.log('Channel Response: '+ChannelInfo);
	var ChannelInfoStr = ChannelInfo.split('##');
	chId = ChannelInfoStr[0].trim();
	var ChannelInfoStrNew = ChannelInfoStr[1].split('?@');
	if(ChannelInfoStrNew[0] != '11'){
//		if(hybrid2NodeFlag || hybridNodeFlag){
			defaultMonitoringStatus(chId);
//		}
		return false;
	}else{
//		if(hybrid2NodeFlag || hybridNodeFlag){
			changeMonitoringStatus(chId);
//		}
	}

	if(IsValueNull(ChannelInfoStrNew[1])){
		return false;
	}
	
	var subStr1 = ChannelInfoStrNew;
		
//	var subStr1	=	ChannelInfo.split('?@');
//	chId	=	subStr1[0].trim();
	if(completeChannelErrorObject[chId]== '' || completeChannelErrorObject[chId]==undefined ||completeChannelErrorObject[chId]== null)
		completeChannelErrorObject[chId]	=	new Object();
	subStr1.splice(0,1);
	for(k=0;k<subStr1.length;k++){
		subStr2	=	subStr1[k].split('||');
		profileId	=	subStr2[0].trim();
		if(completeChannelErrorObject[chId][profileId]== '' || completeChannelErrorObject[chId][profileId]==undefined ||completeChannelErrorObject[chId][profileId]== null)
			completeChannelErrorObject[chId][profileId]	=	new Array();
		subStr2.splice(0,1);
		for(l=0;l<subStr2.length;l++){
			if(subStr2[l] != ''){
				subStr3=subStr2[l].split('|');
				errorType		=	subStr3[0].trim();
				if(errorType == 'AudioPresence'){
					completeChannelErrorObject[chId]['audio']	=	false;
				}
				else{
					startTime		=	subStr3[1].trim();
					endTime			=	subStr3[2].trim();
					errMsg			=	subStr3[3].trim();
					insertAction	=	completeChannelErrorObject[chId][profileId].push({'type':errorType,'start':startTime,'end':endTime,'msg':errMsg});
					storeError(chId,profileId);
				}
			}
		}
	}
	curTime	=	new Date();
	LastErrorTimeObject[chId]	=	curTime.getTime();
	curTime	=	null;
	if($('.channelInfo[channelRefName="'+assignedChannelIdList[chId]['channelName']+'"]').length >0){
		$('.channelInfo[channelRefName="'+assignedChannelIdList[chId]['channelName']+'"]').find('.infoUpdateTime').html(new Date().toLocaleTimeString('en-US', { hour12: false }));
	}
	else{
		$('.channelInfo[channel="'+chId+'"]').find('.infoUpdateTime').html(new Date().toLocaleTimeString('en-US', { hour12: false }));
	}	
	$('.statusIcon[channel="'+chId+'"]').find('.infoChannelStatus.present').not('.errorClass').addClass('errorClass');
	
	//For enhanced layout
	if(hybridNodeFlag){
		showHybridChannelStatusDiv(chId);
	}
	
	//For updating last update time in channel list div in hybrid layout 2
	if(hybrid2NodeFlag){
		updateHybrid2NodeTime(chId);
	}
};
var storeError	=	function(chId,profileId){
	curTime	=	new Date();
	if(!(typeof(storeErrorObject[curTime.getTime()]) == "object")){
		storeErrorObject[curTime.getTime()]	=	new Array();
	}
	storeErrorObject[curTime.getTime()].push(chId+","+profileId);
	curTime	=	null;
};

var clearError	=	function(){
	curTime			=	new Date();
	cutoffTimeStamp	=	curTime.getTime() - instantDataTimeConstant;
	curTime	=	null;
	var temp = '';
	for(var timekeys in storeErrorObject){
		if((cutoffTimeStamp-parseInt(timekeys))>0){
			for(chpro=0;chpro<storeErrorObject[timekeys].length;chpro++){
				temp	=	storeErrorObject[timekeys][chpro].split(',');
				completeChannelErrorObject[temp[0]][temp[1]].splice(0,1);
			}
			delete storeErrorObject[timekeys];
		}
	}
	if(!hybridNodeFlag){
		for(var chanel in completeChannelErrorObject){
			temp = true;
			for(var profil in completeChannelErrorObject[chanel]){
				if(completeChannelErrorObject[chanel][profil].length > 0){
					temp = false;
					break;
				}
			}
			if(temp){
				$('.statusIcon[channel="'+chanel+'"]').find('.infoChannelStatus.present.errorClass').removeClass('errorClass');
			}
		}
	}
};

var modifyPastError = function(){
	for(var key in LastErrorTimeObject){
		curTime	=	new Date();
		if((curTime.getTime() - LastErrorTimeObject[key]) < clearErrTimeOutConstant){
			$('.statusIcon[channel="'+key+'"]').find('.infoChannelStatus.past').not('.errorClass').addClass('errorClass');
		}
		else{
			$('.statusIcon[channel="'+key+'"]').find('.infoChannelStatus.past.errorClass').removeClass('errorClass');
			if(hybrid2NodeFlag){
				hideHybrid2RowDiv(key);
			}
		}
		curTime = null;	
	}
};

var showChannelStatusDiv	=	function(event){
	if($(event.currentTarget).closest('.channelContainer').hasClass('inactiveChannelStatus')){
		return false;
	}
	if($(event.currentTarget).closest('.monitorProfileTable').hasClass('inactiveChannelStatus')){
		return false;
	}
	var channelId	=	$(event.currentTarget).closest('.statusIcon').attr('channel');
	topPos	=	event.clientY;
	leftPos	=	event.clientX;
	if(topPos>200)
		topPos	=	200;
	$('#channelInfoHoverDiv').css('top',topPos);
	if(leftPos>600)
		leftPos	=	600;
	$('#channelInfoHoverDiv').css('left',leftPos);
	$('#hoverDivChannelName').html(assignedChannelIdList[channelId]['channelName']+' - '+assignedChannelIdList[channelId]['nodeName'] );
	errCount	=	0;
	$('#channelInfoBody').html('');
	tableBodyStr	=	'';
	for(var profiles in completeChannelErrorObject[channelId]){
		if(profiles != 'audio'){
			errCount	+= completeChannelErrorObject[channelId][profiles].length;
			for(d=0;d<completeChannelErrorObject[channelId][profiles].length;d++){
				tableBodyStr	+=	'<tr><td>';
				tableBodyStr	+=	Math.floor(parseInt(assignedChannelIdList[channelId]['profiles'][profiles]['profileInformation'])/1000);
				tableBodyStr	+=	'</td><td align="center">';
				tableBodyStr	+=	completeChannelErrorObject[channelId][profiles][d]['type'];
				tableBodyStr	+=	'</td><td align="center">';
				tableBodyStr	+=	completeChannelErrorObject[channelId][profiles][d]['start'];
				tableBodyStr	+=	'</td><td align="center">';
				tableBodyStr	+=	completeChannelErrorObject[channelId][profiles][d]['end'];
				tableBodyStr	+=	'</td><td>';
				tableBodyStr	+=	completeChannelErrorObject[channelId][profiles][d]['msg'];
				tableBodyStr	+=	'</td></tr>';
			}
		}
	}
	$('#channelInfoBody').html(tableBodyStr);
	$('#hoverDivChannelErrorCount').html(errCount);
	$('#channelInfoHoverDiv').css('display','block');
	$('#modalErrorInfo').css('display','block');
	$('#channelInfoHoverDiv').css('height',$('#channelInfoHoverDiv').find('table').height()+50);
};
var hideChannelStatusInfo	=	function(event){
	$('#modalErrorInfo').css('display','none');
	$('#channelInfoHoverDiv').css('display','none');
};

var showChannelPastStatusDiv	=	function(event){
	if($(event.currentTarget).closest('.channelContainer').hasClass('inactiveChannelStatus') && (!$(event.currentTarget).hasClass('errorClass'))){
		return false;
	}
	if($(event.currentTarget).closest('.monitorProfileTable').hasClass('inactiveChannelStatus') && (!$(event.currentTarget).hasClass('errorClass'))){
		return false;
	}
	loadImage();
	var channelId	=	$(event.currentTarget).closest('.statusIcon').attr('channel');
	topPos	=	event.clientY;
	leftPos	=	event.clientX;
	if(topPos>200)
		topPos	=	200;
	$('#channelInfoHoverDiv').css('top',topPos);
	if(leftPos>600)
		leftPos	=	600;
	$('#channelInfoHoverDiv').css('left',leftPos);
	$('#hoverDivChannelName').html(assignedChannelIdList[channelId]['channelName']+' - '+assignedChannelIdList[channelId]['nodeName'] );
	errCount	=	0;
	$('#channelInfoBody').html('');
	tableBodyStr	=	'';
	channelIdList	=	channelId;
	curTime		=	new Date();
	startTime	=	(curTime.getTime()-clearErrTimeOutConstant)/1000;
/*	if(sessionStartTime > startTime){
		startTime	=	sessionStartTime;
	}
*/	endTime		=	curTime.getTime()/1000;
	ajaxRequestObject.actionScriptURL	=	'./../ControllerNotification/monitorDataRequest.php?Operation=DASH&userId='+userID+'&chList='+channelIdList+'&st='+startTime+'&et='+endTime;
	ajaxRequestObject.sendMethod	=	'GET';
	ajaxRequestObject.callType	=	'SYNC';
	ajaxRequestObject.responseType	=	1;
	ajaxRequestObject.callBack	=	function(Response){
		deloadImage();
		var defaultCheck = checkResponseUrl(Response);
		if(defaultCheck){
			Response	=	Response.responseText;
			if(IsValueNull(Response)){
				AlertMessage({'msg':'Error in retreiving data'});
				return false;
			}
			if(Response == "0" || Response ==0){
				ajaxRequestObject.actionScriptURL	=	'./../UserInterface/fetchData.php?data=dash';
				ajaxRequestObject.sendMethod	=	'GET';
				ajaxRequestObject.callType	=	'SYNC';
				ajaxRequestObject.callBack	=	function(Response){
					Response	=	JSON.parse(Response);
					ResponseData	=	Response.rows;
					if(ResponseData != "" && ResponseData != null){
						errCount	=	ResponseData.length;
						for(g=0;g<errCount;g++){
							tableBodyStr	+=	'<tr><td>';
							tableBodyStr	+=	Math.floor(parseInt(assignedChannelIdList[channelId]['profiles'][ResponseData[g]['Profile'].trim()]['profileInformation'])/1000);
							tableBodyStr	+=	'</td><td align="center">';
							tableBodyStr	+=	ResponseData[g]['type'];
							tableBodyStr	+=	'</td><td align="center">';
							tableBodyStr	+=	ResponseData[g]['start'];
							tableBodyStr	+=	'</td><td align="center">';
							tableBodyStr	+=	ResponseData[g]['end'];
							tableBodyStr	+=	'</td><td>';
							tableBodyStr	+=	ResponseData[g]['msg'];
							tableBodyStr	+=	'</td></tr>';
						}
					}
					$('#channelInfoBody').html(tableBodyStr);
					$('#hoverDivChannelErrorCount').html(errCount);
					$('#channelInfoHoverDiv').css('display','block');
					$('#modalErrorInfo').css('display','block');
					$('#channelInfoHoverDiv').css('height',$('#channelInfoHoverDiv').find('table').height()+50);
				};
				send_remoteCall(ajaxRequestObject);
				ajaxRequestObject	=	{};
			}
		}
	};
	send_remoteCall(ajaxRequestObject);
	ajaxRequestObject	=	{};
};

function getInitialChannelErrorState(){
	channelIdArr	=	Object.keys(assignedChannelIdList)
	channelIdList	=	channelIdArr.join(",");
	curTime		=	new Date();
	startTime	=	(curTime.getTime()-clearErrTimeOutConstant)/1000;
	endTime		=	curTime.getTime()/1000;
	ajaxRequestObject.actionScriptURL	=	'./../ControllerNotification/monitorDataRequest.php?Operation=DASH&userId='+userID+'&chList='+channelIdList+'&st='+startTime+'&et='+endTime;
	ajaxRequestObject.sendMethod	=	'GET';
	ajaxRequestObject.callType	=	'SYNC';
	ajaxRequestObject.responseType	=	1;
	ajaxRequestObject.callBack	=	function(Response){
		var defaultCheck = checkResponseUrl(Response);
		if(defaultCheck){
			Response	=	Response.responseText;
			if(IsValueNull(Response)){
				AlertMessage({'msg':'Error in retreiving data'});
				return false;
			}
			if(Response == "0" || Response ==0){
				ajaxRequestObject.actionScriptURL	=	'./../UserInterface/fetchData.php?data=dash';
				ajaxRequestObject.sendMethod	=	'GET';
				ajaxRequestObject.callBack	=	function(Response){
					Response	=	JSON.parse(Response);
					ResponseData	=	Response.rows;
					if(ResponseData != "" && ResponseData != null){
						for(g=0;g<ResponseData.length;g++){
								channId	=	parseInt(ResponseData[g]['Channel'].trim());
								$('.statusIcon[channel="'+channId+'"]').find('.past').not('.errorClass').addClass('errorClass');
								timeErr	=	new Date(ResponseData[g]['start'].trim());
								LastErrorTimeObject[channId]	=	timeErr.getTime()-(timeErr.getTimezoneOffset())*60*1000;
						}
					}
				};
				send_remoteCall(ajaxRequestObject);
				ajaxRequestObject	=	{};
			}
		}
	};
	send_remoteCall(ajaxRequestObject);
	ajaxRequestObject	=	{};
}
//var setMutationEvent	=	function(){
//	var target = $(mutationTarget);
//	for(var obser=0; obser<target.length;obser++){
//		observer.observe(target[obser], config);
//	}
//};
//var observer = new MutationObserver(function(mutations) {
//	mutations.forEach(function(mutation) {
//		$(mutation.target).closest('.inactiveChannelStatus').removeClass('inactiveChannelStatus');
//		if(hybridNodeFlag){
//			var channelId	=	$(mutation.target).closest('.channelInfo').attr('channel');
//			if(!IsValueNull(channelId)){
//				getProfileResolutionInactive(channelId);
//			}
//		}
//	});
//	observer.disconnect();
//	if($(mutationTarget).length > 0){
//		setMutationEvent();
//	}
//});    
