var ResizePayment	=	0;
var paymentColModel	=	function(){
	var colModel = [
	                	{name:'paymentId',			index:'paymentId',		width:'0px',	title: false},
						{name:'userName',			index:'userName',		width:'180px', 	align: 'left',	sorttype: "float", 	title: false, formatter:paymentColModelFormatterFunction.customerName},
						{name:'transactionId',		index:'transactionId',	width:'180px',	align: 'left',	title: false},
						{name:'paymentDate',		index:'paymentDate',	width:'150px',	align: 'left', 	sorttype: "float",	title: false},		
						{name:'amountPaid',			index:'amountPaid',		width:'150px',	align: 'left', 	sortable: false,	title: false},		
						{name:'creditAmount',		index:'creditAmount',	width:'150px',	align: 'left', 	sortable: false,	title: false},		
						{name:'serviceRate',		index:'serviceRate',	width:'170px',	align: 'left', 	sortable: false,	title: false},		
						{name:'creditMinutes',		index:'creditMinutes',	width:'140px',	align: 'left', 	sortable: false,	title: false},		
						{name:'validityPeriod',		index:'validityPeriod',	width:'140px',	align: 'left', 	sorttype: "float",	title: false, formatter:paymentColModelFormatterFunction.Validity},		
						{name:'paymentMode',		index:'paymentMode',	width:'90px',	align: 'left', 	sorttype: "float",	title: false, formatter:paymentColModelFormatterFunction.Mode},		
						{name:'paymentStatus',		index:'paymentStatus',	width:'90px',	align: 'left', 	sorttype: "float",	title: false, formatter:paymentColModelFormatterFunction.Status},		
					];
	return colModel;
};
var paymentColModelFormatterFunction	=	new Object();
function DefinepaymentColModelFormatterFunctions(){
	paymentColModelFormatterFunction.Validity	=	function(val,colModelOB, rowdata){
		var expiryD	=	new Date(parseInt(val)*1000);
		return expiryD.getFullYear() + '-'+ (expiryD.getMonth()+1) + '-' +expiryD.getDate();  
	};
	paymentColModelFormatterFunction.customerName	=	function(val,colModelOB, rowdata){
		return val;
	};
	paymentColModelFormatterFunction.Mode			=	function(val,colModelOB, rowdata){
		var innerHtml	=	'';
		var modeString	=	'';
		switch (val){
		case '1':
			modeString	=	'Manual';
			break;
		case '2':
			modeString	=	'Automatic';
			break;
		default:
			modeString	=	'Manual';
			break;
		}
		innerHtml	+= modeString;
		return innerHtml;
	};
	paymentColModelFormatterFunction.Status			=	function(val,colModelOB, rowdata){
		var innerHtml	=	'';
		var statusString	=	'';
		switch (val){
		case '1':
			statusString	=	'Success';
			break;
		case '2':
			statusString	=	'Pending';
			break;
		case '3':
			statusString	=	'Failure';
			break;
		default:
			statusString	=	'Success';
			break;
		}
		innerHtml	+= statusString;
		return innerHtml;
	};
	paymentColModelFormatterFunction.gridComplete	=	function(){
		var Table			=	$(this);
		GRID_UNIQUE_ID	=	'PaymentTable';
		if(ResizePayment	==	0){
			CommonGridCompleteFunctions(Table);
			ResizePayment++;
		}	
		$('#PaymentTable').jqGrid('setCaption', 'Payment List');
		worksOnAllGridComplete(Table);
	};
}
DefinepaymentColModelFormatterFunctions();
var addPayment		=	function(){
	var payObj	=	{'custNam':$('#customerListSelect').val(),'amountP':$('#payAmountP').val(),'amountC':$('#payAmountC').val(),'rate':$('#serviceRate').val(),'creditMin':$('#creditMin').val(),'validity':$('#validityExt').val()};
	ajaxRequestObject.actionScriptURL	=	'./../InterfaceToDatabaseUpdates.php?Operation=PaymentInfo&cat=add&payObj='+JSON.stringify(payObj);
	ajaxRequestObject.sendMethod	=	'GET';
	ajaxRequestObject.callType	=	'SYNC';
	ajaxRequestObject.callBack	=	function(Response){
		deloadImage();
		if(Response == 0 || Response == "0")
			refreshdata('HomePagePayments#18');
		else{
			erMsg	=	'Failed to add payment';
			if(Response.indexOf('||') != -1){
				erCode	=	Response.split('||')[1];
				if(SoapErrorMessages[erCode] != '')
					erMsg	=	SoapErrorMessages[erCode];
			}
			AlertMessage({msg:erMsg});
		}
	};
	send_remoteCall(ajaxRequestObject);
	$('#payment_add_form').jqxWindow('close');
};
var cancelPayment	=	function(){
	$('#payment_add_form').jqxWindow('close');
};

var setCurrentExpiry	=	function(){
	var curExpVal	=	$('#customerListSelect option:selected').attr('curExp');
	$('#validityCur').val(new Date(parseInt(curExpVal)*1000));
	$('#validityExt').jqxDateTimeInput('setDate', new Date(parseInt(curExpVal)*1000));
};

$(function(){
	var tempStr	=	'';
	for (var key in CustomerName){
		tempStr += '<option value="'+key+'" curExp="'+CustomerName[key]['accountValidity']+'">'+CustomerName[key]['userName']+'</option>';
	}
	$('#customerListSelect').html(tempStr);
	
	$('#customerListSelect').on('change',setCurrentExpiry);
	
	$('.dateTimeInput').jqxDateTimeInput({ width: '150px', height: '25px', formatString: "yyyy-MM-dd" });
	$('#validityCur').jqxDateTimeInput('disabled',true);
	$('#payment_add_form').on('open',setCurrentExpiry);
	$('#payment_add_form').on('close',function(){
		$('#payment_add_form').find('input[type="number"]').each(function(){$(this).val('');});
	});
	$('#serviceRate').on('keyup',function(){
		$('#creditMin').val(Math.floor($('#payAmountC').val()*60/$('#serviceRate').val()));
	});
});