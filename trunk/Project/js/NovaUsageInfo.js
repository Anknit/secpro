/*
 * Author: Nitin Aloria
 * Date: 28-July-2015
 * Description: This page is used for getting Submenu data for usage info reports.
 *
 */

var ResizeUsageInfo	=	0;
var usageInfoColModel	=	function(){
	var colModel = [
	                	{name:'usageId',			index:'usageId',		width:'0px',	title: false},
	                	{name:'channelName',		index:'channelName',	width:'100px',	align: 'left', 	sorttype: "float",	title: false, formatter:usageInfoColModelFormatterFunction.NoChannel},	
						{name:'usageDate',			index:'usageDate',		width:'100px',	align: 'left', 	sorttype: "float",	title: false},
						{name:'startTime',			index:'startTime',		width:'100px',	align: 'left', 	sorttype: "float",	title: false, formatter:usageInfoColModelFormatterFunction.ToTime},
						{name:'endTime',			index:'endTime',		width:'100px',	align: 'left', 	sorttype: "float",	title: false, formatter:usageInfoColModelFormatterFunction.ToTime},
						{name:'usedMinutes',		index:'usedMinutes',	width:'100px',	align: 'left', 	sorttype: "float",	title: false},				
					];
	return colModel;
};

var usageInfoColModelFormatterFunction	=	new Object();

function DefineUsageInfoColModelFormatterFunction(){
	
	usageInfoColModelFormatterFunction.NoChannel	=	function(val,colModelOB, rowdata){
		var result = '';
		if(val ===	null){
			result	=	'Not Available';
		}else{
			result	=	val;	
		}
		
		return result;
		
	}
	
	usageInfoColModelFormatterFunction.ToTime	=	function(val,colModelOB, rowdata){
		if(val ===	null){
			return 'Not Available';
		}
        else if(val == "0" || val == 0 ){
			return 'Continuous Monitoring';
        }
		 var dateUsage	=	 new Date(val*1000);
		 return dateUsage.getUTCHours()+':'+dateUsage.getUTCMinutes()+':'+dateUsage.getUTCSeconds();
	};
	
	usageInfoColModelFormatterFunction.gridComplete	=	function(){
		var Table			=	$(this);
		GRID_UNIQUE_ID	=	'UsageInfoTable';
		if(ResizeUsageInfo	==	0){
			CommonGridCompleteFunctions(Table);
			ResizeUsageInfo++;
		}	
		$('#UsageInfoTable').jqGrid('setCaption', 'Usage Information');
		worksOnAllGridComplete(Table);
	};

}

DefineUsageInfoColModelFormatterFunction();