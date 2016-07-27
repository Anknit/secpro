/*
 * Author: Nitin Aloria
 * Date: 01-October-2015
 * Description: This page is used for getting Submenu data for operator login details.
 *
 */

var ResizeLoginDetails	=	0;
var loginDetailsColModel	=	function(){
	var colModel = [
	                	{name:'sessionPrimaryKey',	index:'sessionPrimaryKey',	width:'0px',	title: false},
	                	{name:'name',				index:'name',				width:'200px',	align: 'left', 	sorttype: "float",	title: false},
	                	{name:'mailId',				index:'mailId',				width:'200px',	align: 'left', 	sorttype: "float",	title: false},
	                	{name:'startTime',			index:'startTime',			width:'200px',	align: 'left', 	sorttype: "float",	title: false, formatter:loginDetailsColModelFormatterFunction.ToTime},
						{name:'loginDuration',		index:'loginDuration',		width:'200px',	align: 'left', 	sorttype: "float",	title: false, formatter:loginDetailsColModelFormatterFunction.ToDuration}			
					];
	return colModel;
};

var loginDetailsColModelFormatterFunction	=	new Object();

function DefineLoginDetailsColModelFormatterFunction(){
	
	loginDetailsColModelFormatterFunction.ToTime	=	function(val,colModelOB, rowdata){
		 var dateUsage	=	 new Date(val*1000);
		 return dateUsage.getFullYear()+'-'+dateUsage.getMonth()+'-'+dateUsage.getDate()+' '+dateUsage.getHours()+':'+dateUsage.getMinutes()+':'+dateUsage.getSeconds();
	};
	
	loginDetailsColModelFormatterFunction.ToDuration	=	function(val,colModelOB, rowdata){
		var result = '';
		if(val ===	null){
			result	=	'Not Available';
		}else if(val == 1 || val == '1'){
			result	=	val+' Minute';	
		}else{
			result	=	val+' Minutes';	
		}
		
		return result;
		
	}
	
	loginDetailsColModelFormatterFunction.gridComplete	=	function(){
		var Table			=	$(this);
		GRID_UNIQUE_ID	=	'LoginDetailsTable';
		if(ResizeLoginDetails	==	0){
			CommonGridCompleteFunctions(Table);
			ResizeLoginDetails++;
		}	
		$('#LoginDetailsTable').jqGrid('setCaption', 'Operator Login Details');
		worksOnAllGridComplete(Table);
	};

}

DefineLoginDetailsColModelFormatterFunction();