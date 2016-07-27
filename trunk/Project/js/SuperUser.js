USER_GRID_UNIQUE_ID	=	'SuperUserTable';
var AdminMailFormLoaded	=	false;
var ResizeUser	=	0;
var	AllUsersData	=	new Array();
AllUsersData[userID]	=	new Object();
AllUsersData[userID].Username	=	username;
$(function(){
	var date = new Date();
	var mindate = new Date();
	mindate.setDate(date.getDate()+1);
	$('#user_NAME').html('');
});
var SupercolModel	=	function(){
	var colModel = [
						{name:'UserID',				index:'UserID',				width:30,	align: 'left',		 title: false, formatter:SupercolModelFormatterFunction.Editbutton},
						{name:'Username',			index:'Username',			width:250, align: 'left',		sorttype: "float", title: false},
						{name:'userStatus',			index:'userStatus',			width:100, align: 'left',		 formatter:SupercolModelFormatterFunction.EditSaveUserStatus},
						{name:'Organization',		index:'Organization',		width:240,	sorttype: "float",	align:"left", title: false},
						{name:'regAuthorityName',	index:'regAuthorityName',	width:200,	sorttype: "float",	align:"left", title: false},		
						{name:'RegisteredOn',		index:'RegisteredOn',		width:140,	sorttype: "date",	align:"left", title: false},		
						{name:'UserType',			index:'UserType',			width:150,	sorttype: "float",	align:"left", title: false, formatter:SupercolModelFormatterFunction.userTYPEVALUE},	
						{name:'Delete',				index:'Delete',				width:80,	sortable:false,		align:"right", formatter:SupercolModelFormatterFunction.deleteUserImage}		
					];
	return colModel;
};

var SupercolModelFormatterFunction	=	new Object();
function DefineSuperColModelFormatterFunctions(){
	SupercolModelFormatterFunction.deleteUserImage	=	function(val,colModelOB,rowdata){
		var value = rowdata.UserID;
		AllUsersData[value]	=	rowdata;
		var innerhtml ='';
		if(rowdata.UserType == 1 || rowdata.UserType == 3)
			innerhtml += '<img src="../../Common/images/Refresh-icon.png" title="Reset SUID" style="margin-right:5px;cursor:pointer" width="16px" height="16px" onclick="resetSUID('+value+');" value="'+value+'" />';
		innerhtml += '<img src="../../Common/images/sendMailIcon.png" title="Send Mail" onclick="showSendMailForm(this);" dest="'+rowdata.Username+'" width="16px" height="16px" style="margin-right:5px;cursor:pointer"/>';
		innerhtml += '<img src="../../Common/images/delete.png" title="Delete Users" onclick="showDeleteUserForm(this);" width="16px" height="16px" value="'+value+'" style="cursor:pointer"/>';
		return innerhtml;
	};

	SupercolModelFormatterFunction.EditSaveUserStatus		=	function(val,colModelOB, rowdata){
//		AllUsersData[rowdata.UserID]	=	rowdata.Username;
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

	SupercolModelFormatterFunction.Editbutton	=	function (val,colModelOB, rowdata){
		if(rowdata.userStatus != '1'){
			uid	=	rowdata.UserID;
			var innerhtml	=	'<img id="EditUser_'+uid+'" src="../../Common/images/report.png" value="'+uid+'" onclick="showEditUserForm(this)" title = "click to edit" style="cursor:pointer">';
			return innerhtml;
		}
		else
			return '&nbsp;';
	};

	SupercolModelFormatterFunction.userTYPEVALUE	=	function(val,colModelOB, rowdata){
		value	=	val;
		if(value == 1)
			return "&nbsp; Operator";
		else if(value == 2)
			return "&nbsp; Reseller";
		else if(value == 3)
			return "&nbsp; Account Manager";
		else if(value == 4)
			return "&nbsp; Super User";
		else if(value == 5)
			return "&nbsp; Venera Sales";
		else
			return "&nbsp; Sales Representative";
	};

	SupercolModelFormatterFunction.gridComplete	=	function(){
		var Table			=	$(this);
		GRID_UNIQUE_ID	=	USER_GRID_UNIQUE_ID;
		if(ResizeUser	==	0){
			CommonGridCompleteFunctions(Table);
			ResizeUser++;
		}	
		worksOnAllGridComplete(Table);
	};
	
}

DefineSuperColModelFormatterFunctions();

//Show input options and switch to save action image

var SuperUser	=	new Object();
SuperUser.SubmitSMTP	=	function(){
	var EntryCorrect = this.SmtpValidate();
	if(EntryCorrect == 'correct'){
		var SmtpDetails	=	new Object();
	
		var smtpHostName	= $('#smtpHostName').val();
		var SmtpPortNumber	= $('#SmtpPortNumber').val();
		var SmtpSenderName 	= $('#SmtpSenderName').val();
		var smtpUserName	= $('#smtpUserName').val();
		var smtpPassword 	= $('#smtpPassword').val();
		
		SmtpDetails.actionScriptURL	=	'action/saveSMTP.php?smtpHostName='+smtpHostName+'&SmtpPortNumber='+SmtpPortNumber+'&SmtpSenderName='+SmtpSenderName+'&smtpUserName='+smtpUserName+'&smtpPassword='+smtpPassword;
		SmtpDetails.callBack		=	function (Response){
			if(Response == 'success')
				AlertMessage({msg: SuccessMessages[8], error:0});
			else
				AlertMessage({msg: ErrorMessages[17]});
			refreshdata('#SMTPdiv');
		};
		send_remoteCall(SmtpDetails);
	}
	else if(EntryCorrect == 'err1'){
        alert(SMTPErrorMessages[0]);
		return false;
	}
	else if(EntryCorrect == 'err2'){
		alert(SMTPErrorMessages[1]);
		return false;
	}
	else if(EntryCorrect == 'err3'){
		alert(SMTPErrorMessages[2]);
		return false;
	}
	else if(EntryCorrect == 'err4'){
		alert(ErrorMessages[8]);
		return false;
	}
	else if(EntryCorrect == 'err5'){
		alert(ErrorMessages[12]);
		return false;
	}
};

SuperUser.SmtpValidate	=	function(){
	if($('#smtpHostName').val() == '' || $('#smtpHostName').val() == undefined ){
		return 'err1';
	}
	else if($('#SmtpPortNumber').val() == '' || $('#SmtpPortNumber').val() == undefined ){
		return 'err2';
	}
	else if($('#SmtpSenderName').val() == '' || $('#SmtpSenderName').val() == undefined ){
		return 'err3';
	}
	else if($('#smtpUserName').val() == '' || $('#smtpUserName').val() == undefined ){
		return 'err4';
	}
	else if($('#smtpPassword').val() != $('#smtpRetypePassword').val() ){
		return 'err5';
	}
	else {
		return 'correct';
	}
};

SuperUser.saveSupportEmailID	=	function(){
	var supportEmailID = Element('supportEmailID').value;
	if(supportEmailID != '' && supportEmailID != undefined && supportEmailID != null && emailcheck(supportEmailID)) {
		var saveSupportEmailID	=	new Object();

		saveSupportEmailID.actionScriptURL	=	'action/saveSystemSettings.php?supportEmailID='+supportEmailID+'&requestType=1';
		saveSupportEmailID.callBack		=	function (Response){
			if(Response == '1')
				AlertMessage({msg: SuccessMessages[10], error:0});
			else
				AlertMessage({msg: ErrorMessages[25]});
		};
		send_remoteCall(saveSupportEmailID);
	}
};

SuperUser.downloadMysqlbackup	=	function(){
		var DbBackup	=	new Object();
		DbBackup.actionScriptURL	=	'action/DbBackupForAdmin.php';
		DbBackup.callBack		=	function (Response){
			if(Response == '0')
				AlertMessage({msg: ErrorMessages[22]});
			else{
					$('#dbBackupLink').attr('href','../../temp/'+Response);
			}
		};
		send_remoteCall(DbBackup);
};

var showEditUserForm	=	function(editButton){
	var obj = new Object();
	obj.id 	= '#EditUserdiv';
	obj.WindowHeight	=	'370';
	obj.WindowWidth		=	'450';
	obj.Heading = '<span style="font-family:Arial; font-size:12px">Edit</span>';
	obj.ok 		= 'confirmEditUser';
	obj.cancel 	= 'cancelEditUser';
	obj.tab		= '#myUsersSubscription';
	createWindow(obj);
	createDropDownList();
	$('#EditUserdiv').css('display',"block");
	var edit_UserID	=	$(editButton).attr('value');
	showHideEditableOptions(AllUsersData[edit_UserID].UserType);
	$('#user_NAME').text(AllUsersData[edit_UserID].Username);

};

var resetSUID	=	function(userID){
	if(!IsValueNull(userID)){
		var userIDResetSUID	=	new Object();
		var Data_random 	= randomize_Data('Operation=resetUserSUID&userID='+userID);
		var Data_encoded 	= EncodeData(Data_random);
		userIDResetSUID.actionScriptURL	=	'../InterfaceToDatabaseUpdates.php?'+Data_encoded;
		userIDResetSUID.callBack		=	function (Response){
			if(Response == '11'){
				AlertMessage({msg:SuccessMessages[11],error:0});
			}
			else if(Response != '0'){
				AlertMessage({msg:ErrorMessages[Response]});
			}
			else {
				AlertMessage({msg:ErrorMessages[28]});
			}
		};
		send_remoteCall(userIDResetSUID);
	}
};

var showSendMailForm	=	function(object){
	var recipient	=	$(object).attr('dest');
	if(!IsValueNull(recipient)){
		$('#adminMailRecipient').html(recipient);
		if(AdminMailFormLoaded){
			displayAdminMailForm();
			return;
		}
		AdminMailFormLoaded	=	true;
		var obj = new Object();
		obj.id 	= '#MailFormdiv';
		obj.WindowHeight	=	'335';
		obj.WindowWidth		=	'750';
		obj.Heading = '<span style="font-family:Arial; font-size:12px">Mail</span>';
		obj.cancel 	= 'cancelSendMail';
		obj.tab		= '#myUsersSubscription';
		createWindow(obj);
		$('#MailFormdiv').css('display',"block");
	}
};


var send_Admin_Mail	=	function(){
	var Mailreceiver	=	$('#adminMailRecipient').html();
	var Subject			=	$('#AdminMailSubject').val();
	var MailBody		=	$('#AdminMailDescription').val();
	if(!IsValueNull(Mailreceiver) && !IsValueNull(Subject) && !IsValueNull(MailBody)){
		var admMail	=	new Object();
		var Data_random 	= randomize_Data('Operation=sendAdminMail&rec='+Mailreceiver+'&sub='+Subject+'&desc='+MailBody);
		var Data_encoded 	= EncodeData(Data_random);
		admMail.actionScriptURL	=	'../InterfaceToDatabaseUpdates.php?'+Data_encoded;
		admMail.callBack		=	function (Response){
			if(Response == '12'){
				AlertMessage({msg:SuccessMessages[12],error:0});
			}
			else{
				AlertMessage({msg:ErrorMessages[Response]});
			}
		};
		send_remoteCall(admMail);
	}
	else{
		AlertMessage({msg:'Please fill all entries'});
	}
};
