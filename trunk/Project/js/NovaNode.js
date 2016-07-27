var lastSel	=	"0";
$(function(){
	var newNodeName	=	'';
	var newNodeDescription	=	'';
	var buttonObject	=	'';
	var associatedTable	=	'';
	var currentNode = '';
	if(NodeTableData != '' && NodeTableData != null)
		generateNodeTable(NodeTableData);
});

/*Generate tables for agent list of each node*/
var generateNodeTable	=	function(NodeDataObject){
	var tableString	=	'';
	var agentString	=	'';
	var otherAgentStr	=	'';
	$('#NodeAgentListDiv').html('');
	$('#nodeListSelect').html('');
	for(var key in NodeDataObject){
		agentString += '<div agentTableNodeRef='+key+' style="display:none"><table id="NodeAgentTable_'+key+'" class="convertTojqGrid ui-grid-Font subList" url="fetchData.php?data=nodeAgent&act=grid&nodeId='+key+'" colNames="Agent Name, Description, Status, Type" colModel="nodeAgentColModel" sortBy="agentId" gridComplete="nodeAgentColModelFormatterFunction" gridWidth="0.48", gridHeight="0.27"></table><div id="gridpager_NodeAgentTable_'+key+'"></div></div>';
		$('#NodeAgentListDiv').html($('#NodeAgentListDiv').html()+agentString);
		$('#nodeListSelect').html($('#nodeListSelect').html()+'<option value='+NodeDataObject[key]['nodeId']+'>'+NodeDataObject[key]['nodeName']+'</option>');
		agentString	=	'';
	}
};

/* Node List table Grid*/
var ResizeNode	=	0;
var nodeColModel	=	function(){
	var colModel = [
	                	{name:'nodeId',			index:'nodeId',			width:'20px',	align: 'center',	title: false, formatter:nodeColModelFormatterFunction.nodeSelector},
						{name:'nodeName',		index:'nodeName',		width:'100%',	align: 'left',	title: false},
						{name:'nodeDescription',index:'nodeDescription',width:'100%',	align: 'left',	sorttype: "float",	title: false, editable:true},
						{name:'backupAgent',	index:'backupAgent',	width:'100%',	align: 'center',title: false, editable:true, editoptions:{dataInit:nodeColModelFormatterFunction.backupEdit}, hidden: true},
						{name:'licenseKey',		index:'licenseKey',		width:'20px',	align: 'center', title: false ,formatter:nodeColModelFormatterFunction.addLicenseKey}
					];
	return colModel;
};
var nodeColModelFormatterFunction	=	new Object();
function DefinenodeColModelFormatterFunctions(){

	nodeColModelFormatterFunction.nodeSelector	=	function(val,colModelOB, rowdata){
		if(regUserType == '1' && (rowdata.accountId == '0' || rowdata.accountId == 0)){
			return '&nbsp;';
		}
		var innerhtml='<input type="radio" name="node_list_items_radio" id="Node_'+rowdata.nodeId+'" nodeAgentRef="'+val+'" /> ';
		return innerhtml;
	};
	nodeColModelFormatterFunction.selectRowFunction	=	function(rowid,status,e){
		if(!status){
			RefreshGrid('NodeTable');
	     }
		else{
		     if(rowid && rowid!==lastSel){ 
		         $('#NodeTable').restoreRow(lastSel); 
		         lastSel=rowid; 
		      }

		}
	};
	nodeColModelFormatterFunction.backupEdit	=	function(arg1){
		$(arg1).on('keypress',function(e){
			return numbersonly(e);
		});
	};
	nodeColModelFormatterFunction.gridComplete	=	function(){
		var Table			=	$(this);
		GRID_UNIQUE_ID	=	'NodeTable';
		if(ResizeNode	==	0){
			CommonGridCompleteFunctions(Table);
			ResizeNode++;
		}
		$('#NodeTable').jqGrid('setCaption', 'Node List');
		worksOnAllGridComplete(Table);
		bindRadioButtons();
	};

	nodeColModelFormatterFunction.addLicenseKey = function(val,colModelOB, rowdata){
		if(rowdata.accountId == '0' || rowdata.accountId == 0){
			return '&nbsp;';
		}
		var innerhtml = '<span style="cursor:pointer;" title="Generate License Key" onclick="GenerateLicFile(this); event.stopPropagation();" nodeRef="'+rowdata.nodeId+'"> <img src="../../Common/images/report.png" /> </a>';
		return innerhtml;
	};
}
DefinenodeColModelFormatterFunctions();

var GenerateLicFile = function(targetElement){
	
	nodeId = $(targetElement).attr('noderef');
	
	if(nodeId == ''){
		AlertMessage({msg:'Node ID not found.'});
		return false;
	}
	loadImage();
	ajaxRequestObject.actionScriptURL	=	'./../InterfaceToSendMails.php?requestAction=LicenseKey&nodeId='+nodeId;
	ajaxRequestObject.sendMethod	=	'GET';
	ajaxRequestObject.callType	=	'SYNC';
	ajaxRequestObject.responseType	=	1;
	ajaxRequestObject.callBack	=	function(Response){
		deloadImage();
		var defaultCheck = checkResponseUrl(Response);
		if(defaultCheck){
			Response	=	Response.responseText;
			deloadImage();
			if(Response == 0 || Response == "0")
				AlertMessage({msg:SuccessMessages[12],error:0});
			else{
				erMsg	=	'Error occured while sending mail.';
				AlertMessage({msg:erMsg});
			}
		}
	};
	send_remoteCall(ajaxRequestObject);
	ajaxRequestObject	={};
};

/* Node Agent List table grid*/
var nodeAgentColModel	=	function(){
	var colModel = [
	                	{name:'agentName',			index:'agentName',			width:'100%',	align: 'left',	title: false, editable:true},
						{name:'agentDescription',	index:'agentDescription',	width:'100%',	align: 'left',	title: false, editable:true},
						{name:'agentState',			index:'agentState',			width:'100%',	align: 'left',	sorttype: "float",	title: false, formatter:nodeAgentColModelFormatterFunction.agentStatus, editable:true},
						{name:'agentType',			index:'agentType',			width:'100%',	align: 'left',	sorttype: "float",	title: false, formatter:nodeAgentColModelFormatterFunction.agentType, editable:true},
					];
	return colModel;
};
var nodeAgentColModelFormatterFunction	=	new Object();
function DefinenodeAgentColModelFormatterFunctions(){

	nodeAgentColModelFormatterFunction.agentStatus	=	function(val,colModelOB, rowdata){
		var innerhtml='';
		switch (val){
		case "1":
			innerhtml	=	'Active';
			break;
		case "2":
			innerhtml	=	'Inactive';
			break;
		}
		return innerhtml;
	};
	nodeAgentColModelFormatterFunction.agentType	=	function(val,colModelOB, rowdata){
		var innerhtml='';
		switch (val){
		case "1":
			innerhtml	=	'Normal';
			break;
		case "2":
			innerhtml	=	'Backup';
			break;
		}
		return innerhtml;
	};
	nodeAgentColModelFormatterFunction.gridComplete	=	function(){
		var Table		=	$(this);
		GRID_UNIQUE_ID	=	Table.id;
		CommonGridCompleteFunctions(Table);
		worksOnAllGridComplete(Table);
		bindRadioButtons();
	};
}
DefinenodeAgentColModelFormatterFunctions();

/* All Agents List table grid*/
var allAgentColModel	=	function(){
	var colModel = [
	                	{name:'agentId',	index:'agentId',	width:'15px',	align: 'center',	sortable: false,	title: false, formatter:allAgentColModelFormatterFunction.agentSelect},
						{name:'agentName',	index:'agentName',	width:'100%',	align: 'left',		sortable: false,	title: false},
						{name:'nodeId',		index:'nodId',		width:'100%',	align: 'left',		sortable: false,	title: false, formatter:allAgentColModelFormatterFunction.nodeName},
						{name:'agentState',	index:'agentState',	width:'100%',	align: 'left',		sortable: false,	title: false, formatter:allAgentColModelFormatterFunction.agentStatus},
						{name:'agentType',	index:'agentType',	width:'100%',	align: 'left',		sortable: false,	title: false, formatter:allAgentColModelFormatterFunction.agentType},
					];
	return colModel;
};
var allAgentColModelFormatterFunction	=	new Object();
function DefineallAgentColModelFormatterFunctions(){

	allAgentColModelFormatterFunction.agentSelect	=	function(val,colModelOB, rowdata){
		var innerhtml	=	'';
		innerhtml	+='<input type="checkbox" name="all_agent_checkbox" style="display:none" id="Agent_'+val+'" AgentCheckId="'+val+'" NodeCheckId="'+rowdata.nodeId+'" monitorStatus="'+rowdata.monitorStatus+'"/> ';
		return innerhtml;
	};
	allAgentColModelFormatterFunction.nodeName	=	function(val,colModelOB, rowdata){
		var innerhtml; 
		if(val	==	"0"){
			innerhtml	=	'-';
		}
		else{
			innerhtml = NodeTableData[val]['nodeName'];
		}
		return innerhtml;
	};
	allAgentColModelFormatterFunction.agentStatus	=	function(val,colModelOB, rowdata){
		var innerhtml='';
		switch (val){
		case "1":
			innerhtml	=	'Active';
			break;
		case "2":
			innerhtml	=	'Inactive';
			break;
		}
		return innerhtml;
	};
	allAgentColModelFormatterFunction.agentType	=	function(val,colModelOB, rowdata){
		var innerhtml='';
		switch (val){
		case "1":
			innerhtml	=	'Normal';
			break;
		case "2":
			innerhtml	=	'Backup';
			break;
		}
		return innerhtml;
	};
	allAgentColModelFormatterFunction.gridComplete	=	function(){
		var Table		=	$(this);
		GRID_UNIQUE_ID	=	Table.id;
		CommonGridCompleteFunctions(Table);
		worksOnAllGridComplete(Table);
		$('#AllAgentsTable').jqGrid('setCaption', 'Assigned Agents');
		if(!$('#HomePageNodes').find('[value="Apply"]').is(':disabled')){
			editNode();
		}
	};
}
DefineallAgentColModelFormatterFunctions();

/*Add Node*/
var addNode	=	function(){
	newNodeName	=	$('#new_node_input_name').val();
	newNodeDescription	=	$('#new_node_input_description').val();
	
	if(newNodeName == '' && newNodeDescription == ''){
		erMsg = 'Please add node name and node description to continue.'
		AlertMessage({msg:erMsg});
		return false;
	}
	
	ajaxRequestObject.actionScriptURL	=	'./../InterfaceToDatabaseUpdates.php?Operation=NodeInfo&cat=add&name='+newNodeName+'&desc='+newNodeDescription;
	ajaxRequestObject.sendMethod	=	'GET';
	ajaxRequestObject.callType	=	'SYNC';
	ajaxRequestObject.responseType	=	1;
	ajaxRequestObject.callBack	=	function(Response){
		deloadImage();
		var defaultCheck = checkResponseUrl(Response);
		if(defaultCheck){
			Response	=	Response.responseText;
			if(Response == 0 || Response == "0")
				refreshdata('HomePageNodes#5');
			else{
				erMsg	=	'Error in adding node';
				if(Response.indexOf('||') != -1){
					erCode	=	Response.split('||')[1];
					if(SoapErrorMessages[erCode] != '')
						erMsg	=	SoapErrorMessages[erCode];
				}
				AlertMessage({msg:erMsg});
			}
		}
	};
	send_remoteCall(ajaxRequestObject);
	ajaxRequestObject	={};

	newNodeName	=	'';
	newNodeDescription	=	'';
	$('#node_add_form').jqxWindow('close');
};

/* Cancel Node Add*/
var cancelNewNode = function(){
	$('#new_node_input_name').val('');
	$('#new_node_input_description').val('');
	$('#node_add_form').jqxWindow('close');
};

/*Delete Node*/
var deleteNode = function(){
	var confirmation	=	confirm('Do you want to delete node');
	if(!confirmation)
		return false;
	var deleteNodeId	=	$('#HomePageNodes').find('input[type="radio"][nodeAgentRef]:checked').attr('nodeagentref');
	for (var key in ChannelTableData){
		if(ChannelTableData[key]['nodeId'] == deleteNodeId && ChannelTableData[key]['channelStatus'] == '1'){
			alert(ChannelTableData[key]['channelName']+' is currently active on this node. First inactive the sources on this node then remove the node');
			return false;
		}
	}
	ajaxRequestObject.actionScriptURL	=	'./../InterfaceToDatabaseUpdates.php?Operation=NodeInfo&cat=delete&nodeId='+deleteNodeId;
	ajaxRequestObject.callType	=	'SYNC';
	ajaxRequestObject.sendMethod	=	'GET';
	ajaxRequestObject.responseType	=	1;
	ajaxRequestObject.callBack	=	function(Response){
		deloadImage();
		var defaultCheck = checkResponseUrl(Response);
		if(defaultCheck){
			Response	=	Response.responseText;
			if(Response == 0 || Response == "0")
				refreshdata('HomePageNodes#1');
			else{
				erMsg	=	'Node not deleted properly';
				if(Response.indexOf('||') != -1){
					erCode	=	Response.split('||')[1];
					if(SoapErrorMessages[erCode] != '')
						erMsg	=	SoapErrorMessages[erCode];
				}
				AlertMessage({msg:erMsg});
			}
		}
	};
	send_remoteCall(ajaxRequestObject);
	ajaxRequestObject	=	{};
	currentNode	=	'';
	associatedTable	=	'';
	buttonObject	=	'';
	$(associatedTable).find('input[type="radio"]').change();
};

/*Edit Node*/
var editNode = function(){

	var currentNode	=	$('input[type="radio"][nodeAgentRef]:checked').attr('nodeagentref');
	var rowid	=	$('input[type="radio"][nodeAgentRef]:checked').closest('tr').attr('id');
	$('#AllAgentsTable').find('[name="all_agent_checkbox"]').closest('tr').css('display','table-row');
	if(regUserType	!= '1')
		$('#AllAgentsTable').find('[name="all_agent_checkbox"]').css('display','inline-block');
	$('#HomePageNodes').find('[value="Apply"]').jqxButton({disabled:false});
	$('#HomePageNodes').find('[value="Remove"]').jqxButton({disabled:true});
	$('#allNodeAgentsGridDiv').css('display','block');
	$('[name="all_agent_checkbox"]').attr({'checked': false,'disabled':'disabled'});
	$('[nodeCheckId='+currentNode+']').prop('checked', true);
	$('[nodeCheckId='+currentNode+']').attr('disabled',false);
	$('[nodeCheckId="0"]').attr('disabled',false);
	$('#nodeBackupAgent').val(NodeTableData[currentNode]['backupAgent']);
	$('#nodeDescriptionEdit').val(NodeTableData[currentNode]['nodeDescription']);

	$("#NodeTable").jqGrid('editRow',rowid, 
	{ 
	    keys : true, 
	    oneditfunc: function() {
//	        alert ("edited"); 
	    }
	});
};

/*Save Node*/
var saveNode = function(){
	var agentData	=	new Object();
	var restrictAction = false;
	var nodeId	=	$('input[type="radio"][nodeAgentRef]:checked').attr('nodeAgentRef');
	$('[name="all_agent_checkbox"]:checked').each(function(){
		agentData[$(this).attr('agentcheckid')]	=	nodeId;
	});
	$('[name="all_agent_checkbox"]:not(:checked):not(:disabled)').each(function(){
		if($(this).attr('monitorStatus') == '1'){
			var agent_name	=	$(this).closest('td').next('td').html();
			var unassignConfirmation	=	confirm(agent_name+' is currently monitoring source. Do you still want to unassign it?');
			if(!unassignConfirmation){
				restrictAction	=	true;
				agentData	=	{};
				return false;
			}
			else{
				agentData[$(this).attr('agentcheckid')]	=	"0";
			}
		}
		else{
			agentData[$(this).attr('agentcheckid')]	=	"0";
		}
	});
	if(!restrictAction){
		loadImage();
		var backupAgent	=	$('#NodeTable').find('input[name="backupAgent"]').val();
		var nodeDescription	=	$('#NodeTable').find('input[name="nodeDescription"]').val(); 
		ajaxRequestObject.actionScriptURL	=	'./../InterfaceToDatabaseUpdates.php?Operation=AgentInfo&cat=edit&data='+JSON.stringify(agentData);
		ajaxRequestObject.sendMethod	=	'GET';
		ajaxRequestObject.callType	=	'SYNC';
		ajaxRequestObject.responseType	=	1;
		ajaxRequestObject.callBack	=	function(Response){
			deloadImage();
			var defaultCheck = checkResponseUrl(Response);
			if(defaultCheck){
				Response	=	Response.responseText;
				ajaxRequestObject.actionScriptURL	=	'./../InterfaceToDatabaseUpdates.php?Operation=NodeInfo&cat=edit&nodeId='+nodeId+'&desc='+nodeDescription+'&backAgent='+backupAgent;
				ajaxRequestObject.sendMethod	=	'GET';
				ajaxRequestObject.callType	=	'SYNC';
				ajaxRequestObject.callBack	=	function(Response){
					deloadImage();
					if(Response == 0 || Response == "0")
						refreshdata('HomePageNodes#0');
					else{
						erMsg	=	'Node not updated properly';
						if(Response.indexOf('||') != -1){
							erCode	=	Response.split('||')[1];
							if(SoapErrorMessages[erCode] != '')
								erMsg	=	SoapErrorMessages[erCode];
						}
						AlertMessage({msg:erMsg});
					}
				};
				send_remoteCall(ajaxRequestObject);
				ajaxRequestObject	=	{};
			}
		};
		send_remoteCall(ajaxRequestObject);
		ajaxRequestObject	=	{};
	}
};

/*Get Status string*/
var getAgentStatus	=	function(statusCode){
	var agentStateString	=	'';
	switch (statusCode){
	case "1":
		agentStateString	=	'Active';
		break;
	case "2":
		agentStateString	=	'Inactive';
		break;
	}
	return agentStateString;
};

/*Bind radio buttons*/
var bindRadioButtons	=	function(){
	$('input[type="radio"][nodeAgentRef]').each(function(){
		$(this).change(function(){
			var CheckCondition	=	$(this).is(':checked');
			var targetElements	=	$('#HomePageNodes').find('.menu_item_disable');
			$('#AllAgentsTable').find('[name="all_agent_checkbox"]').css('display','none');

			enableDisableButtons(targetElements, CheckCondition);
			if(!$('#HomePageNodes').find('[value="Apply"]').is(':disabled')){
				$('#HomePageNodes').find('[value="Apply"]').jqxButton({disabled:'disabled'});
				$('#AllAgentsTable').find('[name="all_agent_checkbox"]').css('display','none');
				$('#AllAgentsTable').find('[name="all_agent_checkbox"]').closest('tr').css('display','table-row');
				$('#AllAgentsTable').find('[name="all_agent_checkbox"]').not('[nodecheckid="'+$(this).attr("nodeagentref")+'"]').closest('tr').css('display','none');
/*				RefreshGrid('AllAgentsTable');
				$('#AllAgentsTable').find('[name="all_agent_checkbox"]').closest('tr').css('display','table-row');
				$('#AllAgentsTable').find('[name="all_agent_checkbox"]').not('[nodecheckid="'+$(this).attr("nodeagentref")+'"]').closest('tr').css('display','none');
*/				$('#allNodeAgentsGridDiv').css('display','none');
			}
			if(CheckCondition){
				$('#allNodeAgentsGridDiv').css('display','block');
				$('#AllAgentsTable').find('[name="all_agent_checkbox"]').closest('tr').css('display','table-row');
				$('#AllAgentsTable').find('[name="all_agent_checkbox"]').not('[nodecheckid="'+$(this).attr("nodeagentref")+'"]').closest('tr').css('display','none');
				//$(this).closest('.container_div').siblings('.main_table_linked').css('display','block');
				//$(this).closest('.container_div').siblings('.main_table_linked').find("[agentTableNodeRef]").css('display','none');
				//$(this).closest('.container_div').siblings('.main_table_linked').find("[agentTableNodeRef='"+$(this).attr('nodeAgentRef')+"']").css('display','block');
			}
			else{
				$('#AllAgentsTable').find('[name="all_agent_checkbox"]').css('display','none');
				$('#AllAgentsTable').find('[name="all_agent_checkbox"]').closest('tr').css('display','table-row');
				$('#AllAgentsTable').find('[name="all_agent_checkbox"]').not('[nodecheckid="'+$(this).attr("nodeagentref")+'"]').closest('tr').css('display','none');
				$('#allNodeAgentsGridDiv').css('display','none');
				$('#NodeTable').restoreRow(lastSel); 
				$(this).closest('.container_div').siblings('.main_table_linked').css('display','none');
				$(this).closest('.container_div').siblings('.main_table_linked').find("[nodeAgentRef]").css('display','none');
			}
		});
	});
};
