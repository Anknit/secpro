/*
* Author: Ankit
* date: 21-Jan-2015
* Description: This defines methods which are common but for some reason are still nova specific
*/
var ajaxRequestObject	=	new Object();
var	AlertMessageMethods	=	new Object();
AlertMessageMethods.show	=	function(){
	$(' .AnimateMessagesBar').fadeIn( "slow" );
	var timerID	=	window.setTimeout(AlertMessageMethods.Hide, 4000);
	$('.AnimateMessagesBar').mouseover(function(){AlertMessageMethods.cancelAutoHide(timerID)});
};
AlertMessageMethods.Hide	=	function(src){
	var MessageDiv	=	$('.AnimateMessagesBar');
	MessageDiv.fadeOut( 2000 );
};
AlertMessageMethods.cancelAutoHide	=	function(timer){
	 clearTimeout(timer);
};

function AlertMessage(ResponseObject){
	var msg	=	ResponseObject.msg;
	var MessageDiv	=	$('.AnimateMessagesBar');
	if(ResponseObject.error	!=	0)	//By default is error, but if 0 is recieved then successful message
	{
		MessageDiv.css('background-color', '#d7d7d7');		
		MessageDiv.css('color', '#ff0000');		
		MessageDiv.css('opacity', '0.9');		
	}
	else
	{
		MessageDiv.css('background-color', '#E3FFA7');		
		MessageDiv.css('color', '#000');		
		MessageDiv.css('opacity', '0.8');				
	}
		
	$('.ScrollMessagesContent').html(msg);
	AlertMessageMethods.show();
}

var disableElementsByID	=	function(IDArray){
	var selectedDiv	=	'';
	if(IDArray.length >0){
		for(i=0;i<IDArray.length;i++){
			selectedDiv	=	$('#'+IDArray[i])[0];
			$(selectedDiv).closest('tr').css('display','none');
		}
	}
};
function toggleFullScreen(fullScreenElement) {
	if (!document.mozFullScreen && !document.webkitFullScreen) {
		if (fullScreenElement.mozRequestFullScreen) {
			fullScreenElement.mozRequestFullScreen();
		}
		else {
			fullScreenElement.webkitRequestFullScreen(Element.ALLOW_KEYBOARD_INPUT);
		}
	} 
	else {
		if (document.mozCancelFullScreen) {
			document.mozCancelFullScreen();
		} 
		else {
			document.webkitCancelFullScreen();
		}
	}
}

var enableElementsByID	=	function(IDArray){
	var selectedDiv	=	'';
	if(IDArray.length >0){
		for(i=0;i<IDArray.length;i++){
			selectedDiv	=	$('#'+IDArray[i])[0];
			$(selectedDiv).closest('tr').css('display','inline-block');
		}
	}
};

var validateSpecialCharacters	=	function(FieldObject){
	var iChars = "[]'{}\"";
	for (var i = 0; i < FieldObject.value.length; i++) {
		if (iChars.indexOf(FieldObject.value.charAt(i)) != -1) {
			return false;
		}
	}
	return true;
};

function enableDisableElements(jquerySelectorTarget, CheckCondition){
	jquerySelectorTarget.attr('disabled','disabled');
	if(CheckCondition){
		jquerySelectorTarget.removeAttr('disabled');
	}
}
function enableDisableButtons(jquerySelectorTarget, CheckCondition){
	$(jquerySelectorTarget).jqxButton({disabled:'disabled'});
	if(CheckCondition){
		$(jquerySelectorTarget).jqxButton({disabled:false});
	}
}
var openNewItemForm = function(buttonObj){
	var buttonObject	=	$(buttonObj);
	var associatedTable	=	buttonObject.closest('.menu_container').siblings('.container_div').find('.main_list_table');
	$(associatedTable).find('input[type="radio"]:checked').prop('checked', false);
	$(associatedTable).find('input[type="radio"]').change();
	var openDivId = buttonObject.attr('openDivID');
	$('#'+openDivId).jqxWindow('open');
	buttonObject.closest('.menu_container').siblings('.main_table_linked').css('display','none');
};
var worksOnAllGridComplete	=	function(Table){
	var	RowDataArrays	=	Table.jqGrid('getRowData');
	
	
	return ;
	//If no record is found the show no record found at the centre		
	if(RowDataArrays.length	==	0)	//If no records are found then maintain some height of table
	{
		Table.find('.jqgfirstrow').html('<td width="100%" height="200px" valign="middle" style="vertical-align:middle; border:none"><div style="text-align:center; width:100%">No records found</div></td>');
	}
};
var CommonGridCompleteFunctions = function(Table){
	//Get row datas in array
	var	RowDataArrays	=	Table.jqGrid('getRowData');
	ResizeJqGrid(Table);
	ModifyGridHeaderProperties(Table);

	//createDropDownList();
	$('#t_'+GRID_UNIQUE_ID).css('border','none');
	$('#t_'+GRID_UNIQUE_ID).css('height','30px');
	$('#t_'+GRID_UNIQUE_ID).attr('align','left');
	// Manage ui-pg-input element.
	$('input.ui-pg-input').keyup(function() {
		if($(this).val() > TotalPages)
		{
			$(this).val(TotalPages);
			return false;
		}
		else
			return true;
	});
};
var ResizeJqGrid	=	function(Table){
	var TableHeight		=	$(Table).attr('gridHeight');
	var TableWidth		=	$(Table).attr('gridWidth');
	var MaxDivHeight	=	Element('contentPANE').clientHeight;
	var MaxDivWidth		=	Element('contentPANE').clientWidth;
	var SetHeight		=	TableHeight * MaxDivHeight;
	var SetWidth		=	TableWidth * MaxDivWidth;
	Table.jqGrid('setGridHeight', SetHeight);
	Table.jqGrid('setGridWidth', SetWidth);
};

var exportJQGrid	=	function(gridId,filename){
	var exportString	=	'';
	
	var headStr			=	encodeURIComponent($('#'+gridId).jqGrid('getGridParam').colNames.join(';'));
	exportString		+=	headStr+'%0A';
	
	var tableRows	=	$('#'+gridId).find('tr:not(.jqgfirstrow)');
	var bodyStr	=	'';
	for(var e=0; e<tableRows.length;e++){
		tableRows.eq(e).find('td').each(function(){
			var trimmedText = $(this).text().trim();
			if(trimmedText == "-"){
				bodyStr		+=	encodeURIComponent(';');
			}else{
				bodyStr		+=	encodeURIComponent(trimmedText+';');
			}
		});
		bodyStr		+=	'%0A';
	}
	exportString	+=	bodyStr;
	
	if(!IsValueNull(window.navigator.msSaveOrOpenBlob)){
		var blobObject = null;
		blobObject = new Blob([decodeURIComponent(exportString)], {type : 'application/vnd.ms-excel'});
		window.navigator.msSaveOrOpenBlob(blobObject, filename+'.xls');
	}else{
		var a         = document.createElement('a');
		a.href        = 'data:application/vnd.ms-excel,' + exportString;
		a.target      = '_blank';
		a.download    = filename+'.xls';
		document.body.appendChild(a);
		try{
			var clickOutput = a.click();
		}catch(err){
			alert("This feature is not supported by your current browser. Please install other browser or upgrade your browser version to its latest version.");
		}
		
	}
	
};

var checkResponseUrl	=	function(Response, alertTextVal){ // For redirectiion to login
	var boolFlag = false;
	
	if(!IsValueNull(Response.responseURL) && Response.responseURL.indexOf('Login.php') != -1){
		var defaultAlertText = 'Your session has expired. You are being redirected to login.';
		if(!IsValueNull(alertTextVal)){
			switch(alertTextVal){
			case 1: 	
			default: defaultAlertText = 'Your account has been deactivated. You are being redirected to login.';
			}
		}
		alert(defaultAlertText);
		location.href	=	Response.responseURL;
		boolFlag = false;
	}else{
		boolFlag = true;
	}
	
	return boolFlag;
};