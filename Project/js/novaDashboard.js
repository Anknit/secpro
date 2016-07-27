var channelIdListArr	=	[];
var activeChannelProfileArr	=	{};
$(function(){
	$('.dateTimeInput').jqxDateTimeInput({ width: '200px', height: '25px',  formatString: 'ddd, MMM dd, yyyy hh:mm:ss tt',min: new Date(2015, 0, 1), max: new Date()});
	$("#channelsListDropDown").jqxDropDownList({ width: 200, height: 25,checkboxes:true});
	$("#channelsListDropDown").jqxDropDownList('loadFromSelect', 'channelsList');
	$('#dashboardStartTime').on('change',function(event){
		var jsDate = event.args.date; 
		$('#dashboardEndTime').jqxDateTimeInput('setMinDate', jsDate);
	});
	$('#menuBar').on('itemclick',function(event){
		if(event.target.textContent == 'Reports'){
			resetReportTime();
		}
	});
	$("#channelsListDropDown").on('checkChange', function(event){
		if (event.args) {
			$('#dashboardEndTime').jqxDateTimeInput('setMaxDate', new Date());
		    var item = event.args.item;
		    var value = item.value;
		    var checked = item.checked;
		    if(value == "0"){
		    	if(checked){
		    		$("#channelsListDropDown").jqxDropDownList('checkAll');
		    	}
		    	else{
		    		if($("#channelsListDropDown").jqxDropDownList('getCheckedItems').length == Object.keys(assignedChannelIdList).length)
		    			$("#channelsListDropDown").jqxDropDownList('uncheckAll');
		    	}
		    }
		}
	});
});

function generateDashBoardReport(){
	var channelIdList	=	$("#channelsListDropDown").val();
	if(channelIdList == "" || channelIdList == null){
		AlertMessage({'msg':'Please select at least one source'});
		return false;
	}

	var stTime		=	$('#dashboardStartTime').jqxDateTimeInput('getDate');
	var edTime			=	$('#dashboardEndTime').jqxDateTimeInput('getDate');
	channelIdListArr	=	channelIdList.split(",");
	startTime		=	(stTime.getTime()/1000);
	endTime			=	(edTime.getTime()/1000);
	if(channelIdListArr.indexOf("0") != -1){
		channelIdListArr.splice(channelIdListArr.indexOf("0"),1);
	}
	if(channelIdListArr.length > 0){
		loadImage();
		channelIdList	=	channelIdListArr.join(",");
		ajaxRequestObject.actionScriptURL	=	'./../ControllerNotification/monitorDataRequest.php?Operation=DASH&userId='+userID+'&chList='+channelIdList+'&st='+startTime+'&et='+endTime;
		ajaxRequestObject.sendMethod	=	'GET';
		ajaxRequestObject.callType	=	'SYNC';
		ajaxRequestObject.callBack	=	function(Response){
			if(IsValueNull(Response)){
				AlertMessage({'msg':'Error in generating report'});
				return false;
			}
			if(Response == "0" || Response ==0){
				if($('.ui-jqgrid').length == 0){
					customJqgrid($('#DashboardReportTable')[0]);
//					$("#DashboardReportTable").jqGrid("filterToolbar",{
//						stringResult: true,
//						searchOnEnter: false,
//						defaultSearch: "cn",
//						beforeSearch: modifyFilterPostdata					
//					});
					$('.ui-jqgrid').css('float','left');
				}
				else{
					$("#DashboardReportTable").jqGrid('destroyFilterToolbar');
					$("#DashboardReportTable").jqGrid("setColProp", "Source", {searchoptions: dashboardColModelFormatterFunction.getChannelFilterSearchoption()});
					$("#DashboardReportTable").jqGrid("setColProp", "Profile", {searchoptions: dashboardColModelFormatterFunction.getProfileFilterSearchoption()});
					$("#DashboardReportTable").jqGrid('filterToolbar', { 
						stringResult: true,
						searchOnEnter: false,
						defaultSearch: "cn",
//						beforeSearch: modifyFilterPostdata	
						});
					$("#DashboardReportTable")[0].clearToolbar();
					

					addChannelFilterOptions();
					addProfileFilterOptions();
					RefreshGrid('DashboardReportTable');
				}
				$('#dashboardReportExportIcon').css('display','block');
			}
			else
				alert("Error in generating report");
			deloadImage();
		};
		send_remoteCall(ajaxRequestObject);
		ajaxRequestObject	=	{};
	}
	else{
		AlertMessage({'msg':'Please select at least one source'});
	}
}

var ResizeDashboard = 0;

var dashboardColModel	=	function(){
	var colModel = [
                	{name:'Channel',	index:'Channel',	width:140,	align: 'left',	title: false, search: true,	stype:'select',	searchoptions: dashboardColModelFormatterFunction.getChannelFilterSearchoption(), formatter: dashboardColModelFormatterFunction.ChannelName},
					{name:'Profile',	index:'Profile',	width:140,	align: 'center',	title: false, search: true,	stype:'select',	searchoptions: dashboardColModelFormatterFunction.getProfileFilterSearchoption(), formatter: dashboardColModelFormatterFunction.ProfileName},
					{name:'type',		index:'type',		width:140,	align: 'left',	sorttype: "float", search: false,	title: false},
					{name:'start',		index:'start',		width:140,	align: 'left',	sorttype: "float", search: false,	title: false},
					{name:'end',		index:'end',		width:100, 	align: 'center',	sorttype: "float", search: false,	title: false},
					{name:'msg',		index:'msg',		width:650, 	align: 'left', 	sorttype: "float", search: false,	title: false},		
				];
	return colModel;
};
var dashboardColModelFormatterFunction	=	new Object();
function DefinedashboardColModelFormatterFunctions(){

	dashboardColModelFormatterFunction.ChannelName		=	function(val,colModelOB, rowdata){
		val	=	val.trim();
		var innerhtml = assignedChannelIdList[val]['channelName'];
		return innerhtml;
	};

	dashboardColModelFormatterFunction.ProfileName		=	function(val,colModelOB, rowdata){
		val	=	val.trim();
		chan	=	rowdata.Channel.trim();
		var innerhtml = Math.floor(parseInt(channelProfilesObj[chan]['profiles'][val]['profileInformation'])/1000);
		return innerhtml;
	};

	dashboardColModelFormatterFunction.getChannelFilterSearchoption	=	function(){
		var searchOptionString	=	":All";
		var searchOptionObject	=	{ value: searchOptionString};
		return searchOptionObject;
	};

	dashboardColModelFormatterFunction.getProfileFilterSearchoption	=	function(){
		var searchOptionString	=	":All";
		var searchOptionObject	=	{ value: searchOptionString};
		return searchOptionObject;
	};

	dashboardColModelFormatterFunction.gridComplete	=	function(){
		var Table			=	$(this);
		GRID_UNIQUE_ID	=	'DashboardReportTable';
		$('#'+GRID_UNIQUE_ID).jqGrid('filterToolbar', { stringResult: true, searchOnEnter: false, defaultSearch: "cn" });
		if(ResizeDashboard	==	0){
			CommonGridCompleteFunctions(Table);
			ResizeDashboard++;
			addChannelFilterOptions();
			addProfileFilterOptions();
		}	
		worksOnAllGridComplete(Table);
//		bindReportFilters();
	};
}

DefinedashboardColModelFormatterFunctions();

function resetReportTime(){
	curTime = new Date();
	$('#dashboardEndTime').jqxDateTimeInput('setMaxDate', curTime);
	$('#dashboardEndTime').jqxDateTimeInput('setDate',new Date(curTime.getFullYear(), curTime.getMonth(), curTime.getDate(), curTime.getHours(), curTime.getMinutes(), curTime.getSeconds(), curTime.getMilliseconds()));
	$('#dashboardStartTime').jqxDateTimeInput('setDate',new Date(curTime.getFullYear(), curTime.getMonth(), curTime.getDate(), curTime.getHours()-1, curTime.getMinutes(), curTime.getSeconds(), curTime.getMilliseconds()));
}

var modifyFilterPostdata	=	function(){
//	var cId	=	$('#gs_Channel').val();
//	var profileFilterSelectedValues = $('#gs_Profile').val();
//	
//	console.log('Original Postdata: '	+	$('#DashboardReportTable').jqGrid('getGridParam','postData').filters);
//	var filterObj	=	JSON.parse($("#DashboardReportTable").jqGrid('getGridParam','postData').filters);
//	if((cId	!=	'') && (profileFilterSelectedValues != '')){
//		var profileFilterSelectedValuesArr = profileFilterSelectedValues.split(',')
//		var newProfileRule = [];
//		for (var x in activeChannelProfileArr[cId]){
//			if(in_array(activeChannelProfileArr[cId][x],profileFilterSelectedValuesArr)){
//				newProfileRule.push(activeChannelProfileArr[cId][x]);
//			}
//		}
//		for(var x in filterObj.rules){
//			if(filterObj.rules[x].field == 'Profile'){
//				filterObj.rules[x].data = newProfileRule.toString();
//			}
//		}
//	}
	
	console.log('Modified Postdata: '	+	$('#DashboardReportTable').jqGrid('getGridParam','postData').filters);
};
function bindReportFilters(){
//	$('#gs_Channel').on('change',function(){
////		loadImage();
//		cId = $('#gs_Channel').val();
//		
//		if(typeof(cId) !== "undefined"){
//			return true;
//		}
//		console.log('Original: '+$("#DashboardReportTable").jqGrid('getGridParam','postData').filters);
//		if(cId == ""){
//			$('#gs_Profile option').css('display','block');
//			$('#gs_Profile option[value!=""]').map(function(){
//				$(this).attr('value',this.className.replace(/ /g ,','));
//			});
//
//			if(JSON.parse($("#DashboardReportTable").jqGrid('getGridParam','postData').filters).rules.length){
//				var profilefilterSelectedValue = $('#gs_Profile').val();
//				var newFilterObj = '{"groupOp":"AND","rules":[{"field":"Profile","op":"eq","data":"'+profilefilterSelectedValue+'"}]}';
//				$("#DashboardReportTable").jqGrid('getGridParam','postData').filters = newFilterObj;
//			}
	
//				$('#gs_Profile option.'+activeChannelProfileArr[cId][v]).css('display','block').attr('value',activeChannelProfileArr[cId][v]);
//		}
//		else if(typeof(cId) !== "undefined"){
//			$('#gs_Profile option').css('display','none');
//			$('#gs_Profile option[value=""]').css('display','block');
//			for(v=0;v<activeChannelProfileArr[cId].length;v++){
//				$('#gs_Profile option.'+activeChannelProfileArr[cId][v]).css('display','block').attr('value',activeChannelProfileArr[cId][v]);
//			}
//			if(JSON.parse($("#DashboardReportTable").jqGrid('getGridParam','postData').filters).rules.length){
//				var profilefilterSelectedValue = $('#gs_Profile').val();
//				var profilefilterSelectedClass = $('#gs_Profile option[value="'+profilefilterSelectedValue+'"]').attr('class').replace(/ /g,',');
//				var newFilterObj = '{"groupOp":"AND","rules":[{"field":"Channel","op":"eq","data":"86"},{"field":"Profile","op":"eq","data":"'+profilefilterSelectedClass+'"}]}';
//				$("#DashboardReportTable").jqGrid('getGridParam','postData').filters = newFilterObj;
//			}
//		}
//		deloadImage();
//	});
//		console.log('Modified: '+$("#DashboardReportTable").jqGrid('getGridParam','postData').filters);
}
var addProfileFilterOptions = function(){
	var tempString;
	var tempArr = [];
	var selectedChannelArr = $('#channelsListDropDown').val().split(",");
	for(b=0;b<channelIdListArr.length;b++){
		if(in_array(channelIdListArr[b],selectedChannelArr)){
			profileArray	=	assignedChannelIdList[channelIdListArr[b]]['profiles'];
			activeChannelProfileArr[channelIdListArr[b]] = [];
			for(var key in profileArray){
				activeChannelProfileArr[channelIdListArr[b]].push(key);
				if(!in_array(Math.floor(parseInt(profileArray[key]['profileInformation'])/1000)),tempArr )){
					tempArr.push(Math.floor(parseInt((profileArray[key]['profileInformation'])/1000)));
					tempString	=	"<option value='"+key+"' data-bitrate='"+Math.floor(parseInt(profileArray[key]['profileInformation'])/1000)+"' class='"+key+"' >"+Math.floor(parseInt(profileArray[key]['profileInformation'])/1000)+"</option>";
					$('#gs_Profile').append(tempString);
				}
				else{
					var sameProfileBitrateOption = $('#gs_Profile').find('option[data-bitrate="'+Math.floor(parseInt(profileArray[key]['profileInformation'])/1000)+'"]')
					var oldValue	=	sameProfileBitrateOption.attr('value');
					sameProfileBitrateOption.addClass(key).attr('value',oldValue+','+key);
				}
			}
		}
	}
};
var addChannelFilterOptions = function(){
	var selectedChannelArr = $('#channelsListDropDown').val().split(",");
	var tempString;
	for(b=0;b<channelIdListArr.length;b++){
		if(in_array(channelIdListArr[b],selectedChannelArr)){
			tempString	=	"<option value='"+channelIdListArr[b]+"'>"+assignedChannelIdList[channelIdListArr[b]]['channelName']+" - "+assignedChannelIdList[channelIdListArr[b]]['nodeName']+"</option>";
			$('#gs_Channel').append(tempString);
		}
	}
}