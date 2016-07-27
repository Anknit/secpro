USER_GRID_UNIQUE_ID	=	'CustomerUserTable';
var ResizeUser	=	0;

var	AllOperatorsIdAndNames	=	new Array(); 
var SalescolModel	=	function(){
	var colModel = [
						{name:'UserID',				index:'UserID',				width:60,	align: 'left',		title: false, formatter:salescoModelFormatterFunction.Editbutton},
						{name:'Username',			index:'Username',			width:220,	sorttype: "float",	align:"left", title: false},
						{name:'Name',				index:'Name',				width:140, 	sorttype: "float", 	align: 'left',title: false},
						{name:'userStatus',			index:'userStatus',			width:120, 	sorttype: "float", 	align: 'left',title: false, formatter:salescoModelFormatterFunction.EditSaveUserStatus},
						{name:'Plan',				index:'Plan',				width:200,	sorttype: "int", 	align: 'left', title: false, formatter:salescoModelFormatterFunction.EditSaveUserPlan},		
						{name:'Features',			index:'Features',			width:200, 	sorttype: "float",	align: 'left',formatter:salescoModelFormatterFunction.EditSaveUserFeatures},
						{name:'Auto_Renewal',		index:'Auto_Renewal',		width:90,	sortable: false, 	align: 'center', title: false, formatter:salescoModelFormatterFunction.AutoRenew},		
						{name:'Expiry',				index:'Expiry',				width:80, 	sorttype: "date",	align: 'left', formatter:salescoModelFormatterFunction.Expiry},
						{name:'Delete',				index:'Delete',				width:30, 	align: 'left',		formatter:salescoModelFormatterFunction.deleteUserImage},
					];
	return colModel;
};

var salescoModelFormatterFunction	=	new Object();
function DefineSalesColModelFormatterFunctions(){
	salescoModelFormatterFunction.deleteUserImage	=	function(val,colModelOB,rowdata){
		var value = rowdata.UserID;
		if(rowdata.userStatus == 1 && value != userID)
			return '<img src="../../Common/images/delete.png" title="Delete user" style="cursor:pointer" onclick="showDeleteUserForm(this);" value="'+value+'"/>';
		else
			return '&nbsp;';
	};
	
	salescoModelFormatterFunction.EditSaveUserStatus		=	function(val,colModelOB, rowdata){
		AllOperatorsIdAndNames[rowdata.UserID]	=	rowdata.Username;
		var innerhtml='';
		switch (val){
			case '1':{
				innerhtml = 'Unverified';
				break;
			}
			case '2':{
				innerhtml = 'Active';
				break;
			}
			case '3':{
				innerhtml = 'Inactive';
				break;
			}
			default:{
				break;
			}
		}
		innerhtml += '<input type="hidden" id="portalUserStatus_'+rowdata.UserID+'" value="'+val+'" /> ';
		return innerhtml;
	};

	salescoModelFormatterFunction.EditSaveUserPlan		=	function(val,colModelOB, rowdata){
		var innerhtml='';
		switch (val){
			case '1':{
				innerhtml = PPU_TEXT_CONSTANTS.subscriptionConstant[0];
				break;
			}
			case '2':{
				innerhtml = PPU_TEXT_CONSTANTS.subscriptionConstant[1];
				break;
			}
			default:{
				break;
			}
		}
		innerhtml += '<input type="hidden" id="portalUserPlan_'+rowdata.UserID+'" value="'+val+'" /> ';
		return innerhtml;
	};
	
	salescoModelFormatterFunction.AutoRenew		=	function(val,colModelOB, rowdata){
		if(rowdata.Plan	==	'2'){
			var innerhtml;
			switch(val){
			case '1':
				innerhtml	=	'ON';
				break;
			case '2':
				innerhtml	=	'OFF';
				break;
			}
		innerhtml += '<input type="hidden" id="portalUserRenew_'+rowdata.UserID+'" value="'+val+'" /> ';	
		return innerhtml;
		}
		else{
			return '&nbsp;';
		}
	}
	
	salescoModelFormatterFunction.EditSaveUserFeatures		=	function(val,colModelOB, rowdata){
		var innerhtml='';
		switch (val){
			case '3':{
				innerhtml = PPU_TEXT_CONSTANTS.featuresConstant[0];
				break;
			}
			default:{
				innerhtml = '-';
				break;
			}
		}
		innerhtml += '<input type="hidden" id="portalUserFeatures_'+rowdata.UserID+'" value="'+val+'" /> ';
		return innerhtml;
	};
	
	salescoModelFormatterFunction.Editbutton	=	function (val,colModelOB, rowdata){
		if(rowdata.userStatus != '1'){	//If unverified user
			uid	=	rowdata.UserID;
			var innerhtml	=	'<div style="float:left" id="EditUserDiv_'+uid+'"><img id="EditUser_'+uid+'" src="../../Common/images/report.png" value="'+uid+'" onclick="RenderGridInputs(this)" title="click to edit"  style="cursor:pointer"></div>';
			innerhtml		+=	'<div id="SaveUserDiv_'+uid+'" style="float:left;display:none">';
			innerhtml		+=	'<img id="SaveUser_'+uid+'" src="../../Common/images/save_floppy.png" value="'+uid+'" width="16" height="16" onclick="RestoreEditmode(this)" title = "click to save" style="cursor:pointer">';
			innerhtml		+=	'<img id="CancelUser_'+uid+'" src="../../Common/images/cancel_undo.png" value="'+uid+'" width="16" height="16" onclick="CancelAndRestoreEditmode(this)" title = "cancel" style="margin-left:8px;cursor:pointer">';
			innerhtml		+=	'</div>';
			
			return innerhtml;
		}
		else
			return '&nbsp;';
	};
	salescoModelFormatterFunction.Expiry	=	function (val,colModelOB, rowdata){
		if(rowdata.Plan != '1'){	//If unverified user
			return val;
		}
		else
			return '&nbsp;';
	};

	salescoModelFormatterFunction.gridComplete	=	function(){
		var Table			=	$(this);
		GRID_UNIQUE_ID	=	USER_GRID_UNIQUE_ID;
		if(ResizeUser	==	0){
			CommonGridCompleteFunctions(Table);
			ResizeUser++;
		}	
		Table.find('tr').each(function(){
			$($(this).find('td')[3]).addClass('column_status');
			$($(this).find('td')[4]).addClass('subsType');
		});	
		worksOnAllGridComplete(Table);
	};
}

DefineSalesColModelFormatterFunctions();

//Show input options and switch to save action image
function RenderGridInputs(editButton){
	//get the row whose column is to be altered
	var parentRow		=	$(editButton).closest('tr');
	//replace status with the select options
	var statusColumn	=	$(parentRow).children().eq(3);
	var planColumn		=	$(parentRow).children().eq(4);
	var featuresColumn	=	$(parentRow).children().eq(5);
	var RenewColumn		=	$(parentRow).children().eq(6);
	var EdituserID		=	$(editButton).attr('value');
	var userStatus		=	Element('portalUserStatus_'+EdituserID).value;
	var userPlan		=	Element('portalUserPlan_'+EdituserID).value;
	var userFeatures	=	Element('portalUserFeatures_'+EdituserID).value;
	if(userPlan	== 2)
		var userAutoRenew	=	Element('portalUserRenew_'+EdituserID).value;
	if(userStatus != 1){
		//call create drop down list
		statusColumn.html(getStatusInputElement(EdituserID));
		if(userPlan == 1){
			planColumn.html(getPlanInputElement(EdituserID));
			featuresColumn.html(getFeaturesInputElement(EdituserID, userFeatures));
		}
		RenewColumn.html(getRenewInputElement(EdituserID, userAutoRenew));
		
		createDropDownList();
		BindMethodForUIActions();
		$('#Status_'+EdituserID).val(userStatus);
		$('#AutoRenew_'+EdituserID).val(userAutoRenew);
		if(userPlan == 1){	//By content duration
			$('#Subscription_'+EdituserID).val(userPlan);
			$('#AutoRenew_'+EdituserID).val(2);	//For ppu the auto renewal is to be off
//			$('#Subscription_'+EdituserID).on('change', showHideFeatureInput);
//			var featureItem = $('#Features_'+EdituserID).jqxDropDownList('getItemByValue', userFeatures);
//			$('#Features_'+EdituserID).jqxDropDownList('checkItem', featureItem);
		}
		editMyUser(editButton, 1);
		//$('Status_'+EdituserID).jqxDropDownList('selectIndex',userStatus);
//		toggleUserOption(EdituserID,2);
	}
}

//Remove input elements and switch to edit action image
function RestoreEditmode(saveButton){
	var stat ="", type="", feat="",pack="";
	var parentRow			=	$(saveButton).closest('tr');
	//replace status with the select options
	var statusColumn		=	$(parentRow).children().eq(3);
	var planColumn			=	$(parentRow).children().eq(4);
	var featuresColumn		=	$(parentRow).children().eq(5);
	var EdituserID				=	$(saveButton).attr('value');
	//Modify status/subscription
	editMyUser(saveButton, 2);
	var newrowdata		=	new Object();
	newrowdata.UserID	=	EdituserID;
	statusColumn.html(salescoModelFormatterFunction.EditSaveUserStatus(stat, '', newrowdata));
	planColumn.html(salescoModelFormatterFunction.EditSaveUserPlan(type, '', newrowdata));
	featuresColumn.html(salescoModelFormatterFunction.EditSaveUserFeatures(feat, '', newrowdata));
	toggleUserOption(EdituserID,1);
	RefreshGrid(USER_GRID_UNIQUE_ID);
}

function CancelAndRestoreEditmode(saveButton){
	RefreshGrid(USER_GRID_UNIQUE_ID);
}

function showHideFeatureInput(event){
	var args = event.args;
    if (args) {
	    var item = args.item;
	    var value = item.value;
	    if(value == 2){
	    	
	    }
    }
}