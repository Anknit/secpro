var USAGE_REP_GRID_UNIQUE_ID	=	'UsageRepTable';
var	ResizeUsageRep	=	0;
var UsageRepColModel	=	function(){
	var colModel = [
	                	{name:'JobIndex',		index:'JobIndex',		width:0,	hidden: true, 		title: false},
	                	{name:'jobID',			index:'jobID',			width:0,	hidden: true, 		title: false},
						{name:'FileName',		index:'FileName',		width:180,	hidden: false,		title: false, 		align: 'left'},
						{name:'JobStartTime',	index:'JobStartTime',	width:80,	hidden: true,		title: false,		align:"left", sorttype: "float"},
						{name:'JobEndTime',		index:'JobEndTime',		width:100,	align: 'left', 		title: false,		sorttype: "float", formatter:UsageRepColModelFormatterFunction.JobEndTime},
						{name:'FeaturesUsed',	index:'FeaturesUsed',	width:160, 	align: 'left',		title: false,		sorttype: "float"/*, formatter:UsageRepColModelFormatterFunction.Features*/},
						{name:'Username',		index:'Username',		width:160, 	align: 'left',		title: false/*, formatter:UsageRepColModelFormatterFunction.Username*/},
						{name:'ContentDuration',index:'ContentDuration',width:80, 	align: 'left',		hidden: false},
						{name:'Charges',		index:'Charges',		width:80, 	align: 'left',		hidden: false, formatter:UsageRepColModelFormatterFunction.Credits},
					];
	return colModel;
};

var UsageRepColModelFormatterFunction	=	new Object();
function DefineUsageRepColModelFormatterFunctions(){
/*	UsageRepColModelFormatterFunction.Features		=	function(val,colModelOB, rowdata){
		var innerhtml='';
		switch (val){
			case '1':{
				innerhtml = PPU_TEXT_CONSTANTS.reportsConstant[0];
				break;
			}
			case '2':{
				innerhtml = PPU_TEXT_CONSTANTS.reportsConstant[1];
				break;
			}
			default:{
				break;
			}
		}
		innerhtml += '<input type="hidden" id="Voucher_'+rowdata.PaymentIndex+'" value="'+val+'" /> ';
		return innerhtml;
	};
*/
	UsageRepColModelFormatterFunction.Username		=	function(val,colModelOB, rowdata){
		var userName	=	AllOperatorsIdAndNames[val];
		return userName;
	};
	UsageRepColModelFormatterFunction.JobEndTime	=	function(val, colModelOB, rowdata){
		if(val != '' && val != null)
			val = val+' UTC';
		else
			val	= 'N/A';
		return val;
	};
	UsageRepColModelFormatterFunction.gridComplete	=	function(){
		var Table			=	$(this);
		GRID_UNIQUE_ID	=	USAGE_REP_GRID_UNIQUE_ID;
		if(ResizeUsageRep	==	0){
			CommonGridCompleteFunctions(Table);
			ResizeUsageRep++;
		}	
		worksOnAllGridComplete(Table);
	};
	
	UsageRepColModelFormatterFunction.Credits		=	function(val,colModelOB, rowdata){
		var currency = 'USD';
		return val+' '+currency;
	}
}

DefineUsageRepColModelFormatterFunctions();