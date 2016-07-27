/*
* Author: Ankit
* date: 21-Feb-2015
* Description: 
*/
var editBouquetUserStr = '';
$(function(){
	if(BouquetTableData != '' && BouquetTableData != null)
		generateBouquetTable(BouquetTableData);
	if(OperatorList != '' && OperatorList != null){
		for(var key in OperatorList){
			if(editBouquetUserStr != ''){
				editBouquetUserStr	+= ";";
			}
			editBouquetUserStr	+= key;
			editBouquetUserStr	+= ":";
			editBouquetUserStr	+= OperatorList[key];
			$('.mapOperatorList').append('<option value="'+key+'">'+OperatorList[key]+'</option>');
		}
		$('#bouquetUserSelect').val('1');
	}
});

/*Bouquet Grid */
var ResizeBouquet	=	0;
var bouquetColModel	=	function(){
	var colModel = [
	                	{name:'bouquetId',			index:'bouquetId',			width:'20px',	title: false, formatter:bouquetColModelFormatterFunction.bouquetSelector},
						{name:'bouquetName',		index:'bouquetName',		width:'100%',	align: 'left',	title: false},
						{name:'bouquetDescription',	index:'bouquetDescription',	width:'100%',	align: 'left',	title: false, editable:true},
						{name:'userId',				index:'userId',				width:'100%',	align: 'left',	title: false, formatter:bouquetColModelFormatterFunction.userName, editable:true, edittype:"select", editoptions:{value:editBouquetUserStr}},
					];
	return colModel;
};
var bouquetColModelFormatterFunction	=	new Object();
function DefinebouquetColModelFormatterFunctions(){

	bouquetColModelFormatterFunction.bouquetSelector	=	function(val,colModelOB, rowdata){
		var innerhtml='<input type="radio" name="bouquet_list_items_radio" id="Bouquet_'+rowdata.bouquetId+'" value="'+val+'" /> ';
		return innerhtml;
	};
	
	bouquetColModelFormatterFunction.userName		=	function(val,colModelOB, rowdata){
		var innerhtml='';
		if($.isNumeric(rowdata.userId))
			innerhtml += OperatorList[val];
		else{
			innerhtml += val;
		}
		return innerhtml;
	};
	bouquetColModelFormatterFunction.selectRowFunction	=	function(rowid,status,e){
		if(!status){
			RefreshGrid('BouquetTable');
	     }
		else{
		     if(rowid && rowid!==lastSel){ 
		         $('#BouquetTable').restoreRow(lastSel); 
		         lastSel=rowid; 
		      }

		}
	};
	
	bouquetColModelFormatterFunction.gridComplete	=	function(){
		var Table			=	$(this);
		GRID_UNIQUE_ID	=	'BouquetTable';
		if(ResizeBouquet	==	0){
			CommonGridCompleteFunctions(Table);
			ResizeBouquet++;
		}
		$('#BouquetTable').jqGrid('setCaption', 'Group List');
		worksOnAllGridComplete(Table);
		bindBouquetRadioButtons();
	};
}
DefinebouquetColModelFormatterFunctions();

/* All Channels List table grid*/
var allChannelColModel	=	function(){
	var colModel = [
	                	{name:'channelId',	index:'channelId',	width:'15px',	align: 'center',	title: false, formatter:allChannelColModelFormatterFunction.channelSelect},
						{name:'channelName',index:'channelName',width:'100%',	align: 'left',	title: false},
						{name:'nodeId',		index:'nodeId',		width:'100%',	align: 'left',	sorttype: "float",	title: false, formatter:allChannelColModelFormatterFunction.nodeName},
					];
	return colModel;
};
var allChannelColModelFormatterFunction	=	new Object();
function DefineallChannelColModelFormatterFunctions(){

	allChannelColModelFormatterFunction.channelSelect	=	function(val,colModelOB, rowdata){
		var innerhtml='<input type="checkbox" style="display:none" name="all_channel_checkbox" id="Channel_'+val+'" ChannelCheckId="'+val+'" class="'+rowdata.bouquetIdList+'"/> ';
		return innerhtml;
	};
	allChannelColModelFormatterFunction.nodeName	=	function(val,colModelOB, rowdata){
		var innerhtml; 
		if(val	==	"0"){
			innerhtml	=	'-';
		}
		else{
			innerhtml = NodeTableData[val]['nodeName'];
		}
		return innerhtml;
	};
	allChannelColModelFormatterFunction.gridComplete	=	function(){
		var Table		=	$(this);
		GRID_UNIQUE_ID	=	Table.id;
		CommonGridCompleteFunctions(Table);
		worksOnAllGridComplete(Table);
		$('#AllChannelsTable').jqGrid('setCaption', 'Assigned Sources');
		if(!$('#HomePageBouquets').find('[value="Apply"]').is(':disabled')){
			editBouquet();
		}
	};
}
DefineallChannelColModelFormatterFunctions();

/* Delete Bouquet*/
var deleteBouquet = function(){
	var confirmation	=	confirm('Do you want to delete group');
	if(!confirmation)
		return false;
	var bouquetId	=	$('#BouquetTable').find('[name="bouquet_list_items_radio"]:checked').attr('value');
	ajaxRequestObject.actionScriptURL	=	'./../InterfaceToDatabaseUpdates.php?Operation=BouquetInfo&cat=delete&bouquetId='+bouquetId;
	ajaxRequestObject.sendMethod	=	'GET';
	ajaxRequestObject.callType	=	'SYNC';
	ajaxRequestObject.responseType	=	1;
	ajaxRequestObject.callBack	=	function(Response){
		deloadImage();
		var defaultCheck = checkResponseUrl(Response);
		if(defaultCheck){
			Response	=	Response.responseText;
			if(Response == 0 || Response == "0")
				refreshdata('HomePageBouquets#8');
		}
	};
	send_remoteCall(ajaxRequestObject);
	ajaxRequestObject	=	{};
};

/*Add Bouquet*/
var addBouquet	=	function(){
	var newBouquetName	=	$('#new_bouquet_input_name').val();
	var newBouquetDesc	=	$('#new_bouquet_input_description').val();
	var newBouquetUser	=	$('#bouquetUserSelect').val();
	
	if(newBouquetName == '' && newBouquetDesc ==''){
		AlertMessage({msg:'Please add group name and description to continue.'});
		return false;
	}
	
	loadImage();
	ajaxRequestObject.actionScriptURL	=	'./../InterfaceToDatabaseUpdates.php?Operation=BouquetInfo&cat=add&name='+newBouquetName+'&desc='+newBouquetDesc+'&user='+newBouquetUser;
	ajaxRequestObject.sendMethod	=	'GET';
	ajaxRequestObject.callType	=	'SYNC';
	ajaxRequestObject.responseType	=	1;
	ajaxRequestObject.callBack	=	function(Response){
		deloadImage();
		var defaultCheck = checkResponseUrl(Response);
		if(defaultCheck){
			Response	=	Response.responseText;
			if(Response == 0 || Response == "0")
				refreshdata('HomePageBouquets#9');
			else
				AlertMessage({msg:'Failed to add group'});
		}
	};
	send_remoteCall(ajaxRequestObject);
};

/*Cancel add Bouquet*/
var cancelNewBouquet = function(){
	$('#new_bouquet_input_name').val('');
	$('#new_bouquet_input_description').val('');
	$('#new_bouquet_input_user').val('');
	$('#bouquet_add_form').jqxWindow('close');
};

/*Edit bouquet*/
var editBouquet = function(){
	$('#BouquetChannelGrid').css('display','none');
	var currentBouquetId	=	$('#BouquetTable').find('[name="bouquet_list_items_radio"]:checked').attr('value');
	var rowid	=	$('input[type="radio"][name="bouquet_list_items_radio"]:checked').closest('tr').attr('id');

	$('#AllChannelsTable').find('[name="all_channel_checkbox"]').closest('tr').css('display','table-row');
	$('#AllChannelsTable').find('[name="all_channel_checkbox"]').css('display','inline-block');

	$('#HomePageBouquets').find('[value="Apply"]').jqxButton({disabled:false});
	$('#HomePageBouquets').find('[value="Remove"]').jqxButton({disabled:true});
	$('#allBouquetChannelsGridDiv').css('display','block');
//	$('[name="all_channel_checkbox"]').attr({'checked': false,'disabled':false});
	$('.'+currentBouquetId).prop('checked', true);
//	$('.'+currentBouquetId).attr('disabled',false);
//	$('.0').attr('disabled',false);
	$('#bouquetEditUserSelect').val(BouquetTableData[currentBouquetId]['userId']);
	$('#bouquetDescriptionEdit').val(BouquetTableData[currentBouquetId]['bouquetDescription']);

	$("#BouquetTable").jqGrid('editRow',rowid, 
			{ 
			    keys : true, 
			    oneditfunc: function() {
//			        alert ("edited"); 
			    }
			});
};

/*Save Bouquet*/
var saveBouquet = function(){
	loadImage();
	var mappingAddData	=	new Object();
	var mappingRemoveData	=	new Object();
	var bouquetId	=	$('#BouquetTable').find('[name="bouquet_list_items_radio"]:checked').attr('value');

	$('[name="all_channel_checkbox"]:checked:not(".'+bouquetId+'")').each(function(){
		mappingAddData[$(this).attr('channelcheckid')]	=	bouquetId;
	});
	
	$('.'+bouquetId+'[name="all_channel_checkbox"]:not(:checked)').each(function(){
		mappingRemoveData[$(this).attr('channelcheckid')]	=	bouquetId;
	});
	
	var assignedUser	=	$('#BouquetTable').find('select[name="userId"]').val();
	var bouquetDescription	=	$('#BouquetTable').find('input[name="bouquetDescription"]').val();
	
	ajaxRequestObject.actionScriptURL	=	'./../InterfaceToDatabaseUpdates.php?Operation=BouquetInfo&cat=map&adddata='+JSON.stringify(mappingAddData)+'&removedata='+JSON.stringify(mappingRemoveData);
	ajaxRequestObject.callType	=	'SYNC';
	ajaxRequestObject.sendMethod	=	'GET';
	ajaxRequestObject.responseType	=	1;
	ajaxRequestObject.callBack	=	function(Response){
		deloadImage();
		var defaultCheck = checkResponseUrl(Response);
		if(defaultCheck){
			Response	=	Response.responseText;
			ajaxRequestObject.actionScriptURL	=	'./../InterfaceToDatabaseUpdates.php?Operation=BouquetInfo&cat=edit&bouquetId='+bouquetId+'&desc='+bouquetDescription+'&userId='+assignedUser;
			ajaxRequestObject.sendMethod	=	'GET';
			ajaxRequestObject.callType	=	'SYNC';
			ajaxRequestObject.callBack	=	function(Response){
				deloadImage();
				if(Response == 0 || Response == "0")
					refreshdata('HomePageBouquets#10');
				else{
					erMsg	=	'Failed to update Bouquet';
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
};

/*Generate bouquet Channel table*/
var generateBouquetTable	=	function(BouquetDataObject){
	var nodeNameTableHeadString	=	'';
	var channelString	=	'';
	var getNodeIdsArray	=	Array();

	for(var key in NodeTableData){
		nodeNameTableHeadString	+=	'<th nodeIdref='+NodeTableData[key]['nodeId']+'><div class="list_head_name">'+NodeTableData[key]['nodeName']+'</div></th>';
	}

	uniqueChannelArray	=	new Array();
	uniqueNodeArray	=	new Array();
	
	for(var key in BouquetDataObject){
		channelString += '<table bouquetChannelRef='+BouquetDataObject[key]['bouquetId']+' class="added_list_table" style="display:none"><caption>Sources of <span class="selected_item_span">'+BouquetDataObject[key]['bouquetName']+'</span></caption><thead><tr><th><div class="list_head_name">Channel</div></th>'+nodeNameTableHeadString+'</tr></thead>';
		for(j=0;j<BouquetDataObject[key]['channels'].length;j++){
			if(BouquetDataObject[key]['channels'][j] != null && BouquetDataObject[key]['channels'][j] != undefined){
				channelName	=	ChannelTableData[BouquetDataObject[key]['channels'][j]]['channelName'];
				nodeId		=	ChannelTableData[BouquetDataObject[key]['channels'][j]]['nodeId'];
				if(!in_array(nodeId,uniqueNodeArray)){
					uniqueNodeArray.push(nodeId);
				}
				if(!in_array(channelName,uniqueChannelArray)){
					uniqueChannelArray.push(channelName);
					channelString	+=	'<tr channelRef='+ChannelTableData[BouquetDataObject[key]['channels'][j]]['channelName']+'>';
					channelString	+= 	'<td><div class="list_item">'+channelName+'</div></td>';
					for(var key1 in NodeTableData)
						channelString	+=	'<td><div nodeIdref='+key1+' class="list_item"></div></td>';			
					channelString	+=	'</tr>';
				}
			}
			else{
				channelString	+=	'<tbody></tbody>';
			}
		}

		uniqueNodeArray	=	[];
		uniqueChannelArray	=	[];
		channelString +=	'</table>';	

		$('#BouquetChannelListDiv').html($('#BouquetChannelListDiv').html()+channelString);
		channelString	=	'';

		for(m=0;m<BouquetDataObject[key]['channels'].length;m++){
			if(BouquetDataObject[key]['channels'][m] != null && BouquetDataObject[key]['channels'][m] != undefined){
				$($('[bouquetChannelRef="'+key+'"]').find('[channelref="'+ChannelTableData[BouquetDataObject[key]['channels'][m]]['channelName']+'"]').find('div[nodeidref="'+ChannelTableData[BouquetDataObject[key]['channels'][m]]['nodeId']+'"]')).html('Monitoring');
			}
		}
	}
};

/* Bind Bouquet List Radio buttons*/
var bindBouquetRadioButtons	=	function(){
	$('#BouquetTable').find('[name="bouquet_list_items_radio"]').each(function(){
		$(this).change(function(){
			var CheckCondition	=	$(this).is(':checked');
			var targetElements	=	$('#HomePageBouquets').find('.menu_item_disable');
			enableDisableButtons(targetElements, CheckCondition);
			if(!$('#HomePageBouquets').find('[value="Apply"]').is(':disabled')){
				$('#HomePageBouquets').find('[value="Apply"]').jqxButton({disabled:'disabled'});
				//RefreshGrid('AllChannelsTable');
				$('#AllChannelsTable').find('[name="all_channel_checkbox"]').css('display','none');
				$('#AllChannelsTable').find('[name="all_channel_checkbox"]').closest('tr').css('display','table-row');
				$('#AllChannelsTable').find('[name="all_channel_checkbox"]').not('.'+$(this).attr("value")).closest('tr').css('display','none');
				$('#allBouquetChannelsGridDiv').css('display','none');
			}
			if(CheckCondition){
				$('#allBouquetChannelsGridDiv').css('display','block');
				$('#AllChannelsTable').find('[name="all_channel_checkbox"]').closest('tr').css('display','table-row');
				$('#AllChannelsTable').find('[name="all_channel_checkbox"]').not('.'+$(this).attr("value")).closest('tr').css('display','none');
//				loadBouquetChannelGridFromTable($(this).attr('value'));
			}
			else{
				$('#AllChannelsTable').find('[name="all_channel_checkbox"]').css('display','none');
				$('#AllChannelsTable').find('[name="all_channel_checkbox"]').closest('tr').css('display','table-row');
				$('#AllChannelsTable').find('[name="all_channel_checkbox"]').not('.'+$(this).attr("value")).closest('tr').css('display','none');
				$('#allBouquetChannelsGridDiv').css('display','none');
				$('#BouquetTable').restoreRow(lastSel); 
				$("#BouquetChannelGrid").jqGrid('GridUnload');
				$("#BouquetChannelGrid").attr({'gridWidth':'0.47', 'gridHeight':'0.20'});
			}
		});
	});
};

var getActiveProfilesCount	=	function(profileArray){
	activeProfileCount	=	0;
	for (k=0;k<profileArray.length;k++){
		if(profileArray[k]['profileStatus']	==	'1')
			activeProfileCount++;
	}
	return activeProfileCount;
};

var getUsername	=	function(userId){
	// demo function
	return 'Operator';
};

var checkBouquetNodeChannels	=	function(bouquetReference,nodeReference){
	for(i=0;i<BouquetTableData[bouquetReference]['channels'].length;i++){
		$('[bouquetnodeidref='+nodeReference+']').find('[bouquetnodechannelidref='+BouquetTableData[bouquetReference]['channels'][i]+']').find('input[type="checkbox"]').attr('checked', true);
	}
};
var loadBouquetChannelGridFromTable	=	function(bouquetRef){
	$("#BouquetChannelGrid").jqGrid('GridUnload');
	$("#BouquetChannelGrid").attr({'gridWidth':'0.47', 'gridHeight':'0.20'});
    var rows = $('[bouquetchannelref="'+bouquetRef+'"] tbody tr');
    var columns = $('[bouquetchannelref="'+bouquetRef+'"] thead th');
    var channelListJsonData = [];
    var gridColumnNames	=	[];
    var gridColumnProps	=	[];
    for (var k = 0; k < columns.length; k++) {
        var columnName = $.trim($(columns[k]).text());
        gridColumnNames[k]	=	columnName;
    }
    for (var i = 0; i < rows.length; i++) {
        var row = rows[i];
        var datarow = {};
        for (var j = 0; j < columns.length; j++) {
            var columnName = $.trim($(columns[j]).text());
            var cell = $(row).find('td:eq(' + j + ')');
            datarow[columnName] = $.trim(cell.text());
        }
        channelListJsonData[channelListJsonData.length] = datarow;
    }
    for(k=0;k<gridColumnNames.length;k++){
    	gridColumnProps[k]	=	{name:gridColumnNames[k], index:gridColumnNames[k],align:'left'};
    }
	$("#BouquetChannelGrid").jqGrid({
		datatype: function(postdata) {
			jsondata	=	channelListJsonData;
			ResponseData	=	jsondata.rows;
			var thegrid = jQuery("#BouquetChannelGrid")[0];
			thegrid.addJSONData(jsondata);
		},
		colNames:gridColumnNames,
		colModel:gridColumnProps,
		jsonReader : {
		 root: "rows",
		 records: "records",
		 repeatitems: true,
		 cell: "",
		 id: "0"
		},
		rowNum:20,
		rowList:[10,20,30],
		gridview: true,
		ignoreCase: true,
		autoencode: true,
		emptyrecords: "No records found",
		shrinktoFit: true,
		pager : '#gridpager_BouquetChannelGrid',
		forceFit: true,
		recordpos: 'left',
		viewrecords: true,
		pginput : true,
		sortorder: 'asc',
		toolbar:[false,'top'],
		beforeSelectRow: function(){
			return false;
		},
		gridComplete: function(){
			var Table			=	$('#BouquetChannelGrid');
			GRID_UNIQUE_ID	=	'BouquetChannelGrid';
			CommonGridCompleteFunctions(Table);
			worksOnAllGridComplete(Table);
		}
	});
};
