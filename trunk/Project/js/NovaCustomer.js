var ResizeUser	=	0;
var userColModel	=	function(){
	var colModel = [
	                	{name:'userId',				index:'userId',				width:'20px',	title: false, formatter:userColModelFormatterFunction.userSelector},
						{name:'userName',			index:'userName',			width:'100%',	align: 'left',	title: false},
						{name:'accountStatus',		index:'accountStatus',		width:'100%', 	align: 'left',	sortable: false, 	title: false, formatter:userColModelFormatterFunction.status},
						{name:'registeredOn',		index:'registeredOn',		width:'100%',	align: 'left', 	sorttype: "float",	title: false},		
						{name:'regAuthorityName',	index:'regAuthorityName',	width:'100%',	align: 'left', 	sorttype: "float",	title: false},		
						{name:'creditMinutes',		index:'creditMinutes',		width:'100%',	align: 'left', 	sortable: false,	title: false},		
						{name:'usageMinutes',		index:'usageMinutes',		width:'100%',	align: 'left', 	sortable: false,	title: false},		
						{name:'accountValidity',	index:'accountValidity',	width:'100%',	align: 'left', 	sortable: false,	title: false, formatter:userColModelFormatterFunction.Validity},		
					];
	return colModel;
};
var userColModelFormatterFunction	=	new Object();
function DefineuserColModelFormatterFunctions(){
	userColModelFormatterFunction.userSelector	=	function(val,colModelOB, rowdata){
		var innerhtml	=	'';
		if(val != userID){
			innerhtml+='<input type="radio" name="user_list_items_radio" id="User_'+rowdata.userId+'" value="'+val+'" accval="'+rowdata.accountId+'" /> ';
		}
		return innerhtml;
	};
	userColModelFormatterFunction.usertype		=	function(val,colModelOB, rowdata){
		var innerhtml='';
		switch (val){
			case '0':{
				innerhtml = 'SuperUser';
				break;
			}
			case '1':{
				innerhtml = 'Admin';
				break;
			}
			case '2':{
				innerhtml = 'Operator';
				break;
			}
			case '3':{
				innerhtml = 'Sales';
				break;
			}
			default:{
				break;
			}
		}
		return innerhtml;
	};
	userColModelFormatterFunction.status		=	function(val,colModelOB, rowdata){
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
			case '3':{
				innerhtml = 'Unverified';
				break;
			}
			default:{
				break;
			}
		}
		return innerhtml;
	};
	userColModelFormatterFunction.Validity	=	function(val,colModelOB, rowdata){
		var expiryD	=	new Date(parseInt(val)*1000);
		return expiryD.getFullYear() + '-'+ (expiryD.getMonth()+1) + '-' +expiryD.getDate();  
	};
	userColModelFormatterFunction.gridComplete	=	function(){
		var Table			=	$(this);
		GRID_UNIQUE_ID	=	'UserTable';
		if(ResizeUser	==	0){
			CommonGridCompleteFunctions(Table);
			ResizeUser++;
		}	
		$('#UserTable').jqGrid('setCaption', 'Customer List');
		worksOnAllGridComplete(Table);
		bindUserRadioButtons();
	};
}
DefineuserColModelFormatterFunctions();
var deleteUser = function(){
	var confirmation	=	confirm('Do you want to delete customer');
	if(!confirmation)
		return false;
	var deleteUserId	=	$('#HomePageCustomers').find('input[type="radio"][name="user_list_items_radio"]:checked').attr('value');
	ajaxRequestObject.actionScriptURL	=	'./../InterfaceToDatabaseUpdates.php?Operation=UserInfo&cat=delete&userId='+deleteUserId;
	ajaxRequestObject.sendMethod	=	'GET';
	ajaxRequestObject.callBack	=	function(Response){
		if(Response == 0 || Response == '0')
			refreshdata('HomePageCustomers#20');
		else{
			if(Response == '' )
				erMsg	=	'Customer not deleted';
			else{
				erMsg	=	Response;
			}
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
};
var addUser	=	function(){
	var newUserMail		=	$('#newUserEmail').val();
	if(IsValueNull(newUserMail)){
		AlertMessage({msg:'Please enter a valid email'});
		return false;
	}
	loadImage();
	ajaxRequestObject.actionScriptURL	=	'./../InterfaceToDatabaseUpdates.php?Operation=UserInfo&cat=add&mail='+newUserMail;
	ajaxRequestObject.sendMethod	=	'GET';
	ajaxRequestObject.callBack	=	function(Response){
		deloadImage();
		if(Response == 0 || Response == '0')
			refreshdata('HomePageCustomers#19');
		else{
			if(Response == '' )
				erMsg	=	'Failed to add new customer';
			else if(Response == 1 || Response == '1')
				AlertMessage({msg: 'Customer already registered'});
			else{
				erMsg	=	Response;
			}
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
};
var cancelNewUser = function(){
	$('#newUserEmail').val('');
	$('#user_add_form').jqxWindow('close');
};
var bindUserRadioButtons	=	function(){
	$('input[type="radio"][name="user_list_items_radio"]').each(function(){
		$(this).change(function(){
			$('input.hide').css('display','none');
			var CheckCondition	=	$(this).is(':checked');
			var targetElements	=	$('#HomePageCustomers').find('.menu_item_disable');
			enableDisableButtons(targetElements, CheckCondition);
			if($(this).is(':checked')){
				changeStatusButton();
			}
		});
	});
};
var changeStatusButton	=	function(){
	var currentCustomer		=	$('#HomePageCustomers').find('input[type="radio"][name="user_list_items_radio"]:checked');
	var presentAccountState	=	currentCustomer.closest('tr').find('[aria-describedby="UserTable_accountStatus"]').html();
	if(presentAccountState	==	'Unverified'){
		return false;
	}	
	else if(presentAccountState	==	'Active'){
		$('input.hide').val('Deactivate');
		$('input.hide').attr('title','Deactivate customer account');
	}
	else{
		$('input.hide').val('Activate');
		$('input.hide').attr('title','Activate customer account');
	}
	$('input.hide').css('display','block');
};
var changeAccountStatus	=	function(){
	var currentCustomer		=	$('#HomePageCustomers').find('input[type="radio"][name="user_list_items_radio"]:checked');
	var customerAccountId	=	currentCustomer.attr('accval');
	var presentAccountState	=	currentCustomer.closest('tr').find('[aria-describedby="UserTable_accountStatus"]').html();
	var newState	=	'';
	if(presentAccountState	==	'Active'){
		confirmStr	=	'Do you want to inactive customer account';
		newState	=	2;
	}
	else{
		confirmStr	=	'Do you want to active customer account';
		newState	=	1;
	}
	var confirmation		=	confirm(confirmStr);
	if(!confirmation)
		return false;
	ajaxRequestObject.actionScriptURL	=	'./../InterfaceToDatabaseUpdates.php?Operation=UserInfo&cat=status&accId='+customerAccountId+'&state='+newState;
	ajaxRequestObject.sendMethod	=	'GET';
	ajaxRequestObject.callBack	=	function(Response){
		if(Response == 0 || Response == '0')
			refreshdata('HomePageCustomers#22');
		else{
			if(Response == '' )
				erMsg	=	'Account Status not changed';
			else{
				erMsg	=	Response;
			}
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
};