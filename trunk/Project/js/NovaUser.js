var ResizeUser	=	0;
var userColModel	=	function(){
	var colModel = [
	                	{name:'userId',			index:'userId',			width:'20px',	title: false, formatter:userColModelFormatterFunction.userSelector},
						{name:'userName',		index:'userName',		width:'100%',	align: 'left',	title: false},
						{name:'userType',		index:'userType',		width:'100%',	align: 'left',	title: false, formatter:userColModelFormatterFunction.usertype},
						{name:'userStatus',		index:'userStatus',		width:'100%', 	align: 'left',	sorttype: "float", 	title: false, formatter:userColModelFormatterFunction.status},
						{name:'registeredOn',	index:'registeredOn',	width:'100%',	align: 'left', 	sorttype: "float",	title: false},		
					];
	return colModel;
};
var userColModelFormatterFunction	=	new Object();
function DefineuserColModelFormatterFunctions(){
	userColModelFormatterFunction.userSelector	=	function(val,colModelOB, rowdata){
		var innerhtml	=	'';
		if(val != userID){
			innerhtml+='<input type="radio" name="user_list_items_radio" id="User_'+rowdata.userId+'" value="'+val+'" /> ';
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
			case '0':{
				innerhtml = 'Unverified';
				break;
			}
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
	userColModelFormatterFunction.gridComplete	=	function(){
		var Table			=	$(this);
		GRID_UNIQUE_ID	=	'UserTable';
		if(ResizeUser	==	0){
			CommonGridCompleteFunctions(Table);
			ResizeUser++;
		}	
		$('#UserTable').jqGrid('setCaption', 'User List');
		worksOnAllGridComplete(Table);
		bindUserRadioButtons();
		
	};
}
DefineuserColModelFormatterFunctions();
var deleteUser = function(){
	var confirmation	=	confirm('Do you want to delete user');
	if(!confirmation)
		return false;
	var deleteUserId	=	$('#HomePageUsers').find('input[type="radio"][name="user_list_items_radio"]:checked').attr('value');
	ajaxRequestObject.actionScriptURL	=	'./../InterfaceToDatabaseUpdates.php?Operation=UserInfo&cat=delete&userId='+deleteUserId;
	ajaxRequestObject.sendMethod	=	'GET';
	ajaxRequestObject.responseType	=	1;
	ajaxRequestObject.callBack	=	function(Response){
		deloadImage();
		var defaultCheck = checkResponseUrl(Response);
		if(defaultCheck){
			Response	=	Response.responseText;
			if(Response == 0 || Response == '0')
				refreshdata('HomePageUsers#2');
			else{
				if(Response == '' )
					erMsg	=	'User not deleted';
				else if(Response == '1' || Response == 1){
					erMsg	=	'Please remove this user from the assigned groups.';
				}else{
					erMsg	=	Response;
				}
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
	ajaxRequestObject.responseType	=	1;
	ajaxRequestObject.callBack	=	function(Response){
		deloadImage();
		var defaultCheck = checkResponseUrl(Response);
		if(defaultCheck){
			Response	=	Response.responseText;
			deloadImage();
			if(Response == 0 || Response == '0')
				refreshdata('HomePageUsers#3');
			else{
				if(Response == '' )
					erMsg	=	'Failed to add new user';
				else if(Response == 1 || Response == '1')
					AlertMessage({msg: 'User already registered'});
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
			var CheckCondition	=	$(this).is(':checked');
			var targetElements	=	$('#HomePageUsers').find('.menu_item_disable');
			enableDisableButtons(targetElements, CheckCondition);
		});
	});
};