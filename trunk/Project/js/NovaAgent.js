/*
* Author: Ankit
* date: 21-Feb-2015
* Description: 
*/

$(function(){
	if(AgentTableData != '' && AgentTableData != null)
		generateAgentTable(AgentTableData);
});
var ResizeAgent	=	0;
var agentColModel	=	function(){
	var colModel = [
						{name:'agentName',			index:'agentName',			width:'100%',	align: 'left',	title: false},
						{name:'agentDescription',	index:'agentDescription',	width:'100%',	align: 'left',	sorttype: "float",	title: false},
						{name:'nodeId',				index:'nodeId',				width:'100%',	align: 'left',	sorttype: "float", 	title: false, formatter:agentColModelFormatterFunction.nodeName},
						{name:'agentType',			index:'agentType',			width:'100%', 	align: 'left',	sorttype: "float", 	title: false, formatter:agentColModelFormatterFunction.agentType},
						{name:'agentState',			index:'agentState',			width:'100%',	align: 'left', 	sorttype: "float",	title: false, formatter:agentColModelFormatterFunction.agentState},		
					];
	return colModel;
};
var agentColModelFormatterFunction	=	new Object();
function DefineagentColModelFormatterFunctions(){

	agentColModelFormatterFunction.agentType		=	function(val,colModelOB, rowdata){
		var innerhtml='';
		switch (val){
			case '1':{
				innerhtml = 'Normal';
				break;
			}
			case '2':{
				innerhtml = 'Backup';
				break;
			}
			default:{
				break;
			}
		}
		innerhtml += '<input type="hidden" id="Agent_'+rowdata.agentId+'" value="'+val+'" /> ';
		return innerhtml;
	};

	agentColModelFormatterFunction.agentState		=	function(val,colModelOB, rowdata){
		var innerhtml='';
		switch (val){
			case '1':{
				innerhtml = 'Active';
				break;
			}
			case '2':{
				innerhtml = 'Inactive';
				break;
			}
			default:{
				break;
			}
		}
		return innerhtml;
	};
	
	agentColModelFormatterFunction.nodeName	=	function(val,colModelOB, rowdata){
		var innerhtml='';
		if(val == 0 || val == '0'){
			innerhtml	=	'-';
		}
		else{
			innerhtml	= NodeTableData[val]['nodeName'];
		}
			return innerhtml;
	};
	agentColModelFormatterFunction.gridComplete	=	function(){
		var Table			=	$(this);
		GRID_UNIQUE_ID	=	'AgentTable';
		if(ResizeAgent	==	0){
			CommonGridCompleteFunctions(Table);
			ResizeAgent++;
		}	
		$('#AgentTable').jqGrid('setCaption', 'Agent List');
		worksOnAllGridComplete(Table);
	};
}

DefineagentColModelFormatterFunctions();
var generateAgentTable	=	function(AgentDataObject){
	var tableString	=	'';
	var nodeAssigned	=	'';
	$('#agentListTable').html("<thead><tr><td></td><td><div class='list_head_name'>Agent Name</div></td><td><div class='list_head_name'>Description</div></td><td><div class='list_head_name'>Assigned node</div></td><td><div class='list_head_name'>Agent Type</div></td><td><div class='list_head_name'>Agent State</div></td></tr></thead>");
	if(AgentDataObject != ''){
		for(var key in AgentDataObject){
			if(AgentDataObject[key]['nodeId']	!= 0 && AgentDataObject[key]['nodeId'] != "0")
				nodeAssigned	=	NodeTableData[AgentDataObject[key]['nodeId']]['nodeName'];
			else
				nodeAssigned	=	'Unassigned';
			tableString += '<tr><td><input type="radio" name="agent_list_items_radio"></td><td><div class="list_item">'+AgentDataObject[key]['agentName']+'</div></td><td><div class="list_item">'+AgentDataObject[key]['agentDescription']+'</div></td><td><div class="list_item">'+nodeAssigned+'</div></td><td><div class="list_item">'+getAgentType(AgentDataObject[key]['agentType'])+'</div></td><td><div class="list_item">'+getAgentStatus(AgentDataObject[key]['agentState'])+'</div></td></tr>';
		}
	}
	$('#agentListTable').html($('#agentListTable').html()+tableString);
	tableString	=	'';
	$('#HomePageAgents').find('.main_list_table input[type="radio"]').each(function(){
		$(this).change(function(){
			var CheckCondition	=	$(this).is(':checked');
			var targetElements	=	$(this).closest('.container_div').siblings('.menu_container').find('.menu_item_disable');
			enableDisableElements(targetElements, CheckCondition);
		});
	});

};

var getAgentType	=	function(typeCode){
	var AgentType	=	'Normal';
	if(typeCode	==	"2"){
		AgentType	=	'Backup';
	}
	return AgentType;
};