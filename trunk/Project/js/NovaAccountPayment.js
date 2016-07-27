/*
 * Author: Nitin Aloria
 * Date: 28-July-2015
 * Description: This page is used for getting Menu and Submenu data for reports tab.
 *
 */

var ResizeAccountPayment	=	0;
var accountPaymentColModel	=	function(){
	var colModel = [
	                	{name:'paymentId',			index:'paymentId',		width:'0px',	title: false},
						{name:'transactionId',		index:'transactionId',	width:'180px',	align: 'left',	title: false},
						{name:'paymentDate',		index:'paymentDate',	width:'160px',	align: 'left', 	sorttype: "float",	title: false},		
						{name:'amountPaid',			index:'amountPaid',		width:'150px',	align: 'left', 	sortable: false,	title: false},		
						{name:'creditAmount',		index:'creditAmount',	width:'150px',	align: 'left', 	sortable: false,	title: false},		
						{name:'serviceRate',		index:'serviceRate',	width:'170px',	align: 'left', 	sortable: false,	title: false},		
						{name:'creditMinutes',		index:'creditMinutes',	width:'140px',	align: 'left', 	sortable: false,	title: false},		
						{name:'validityPeriod',		index:'validityPeriod',	width:'150px',	align: 'left', 	sorttype: "float",	title: false, formatter:accountPaymentColModelFormatterFunction.Validity},		
						{name:'paymentMode',		index:'paymentMode',	width:'90px',	align: 'left', 	sorttype: "float",	title: false, formatter:accountPaymentColModelFormatterFunction.Mode},		
						{name:'paymentStatus',		index:'paymentStatus',	width:'90px',	align: 'left', 	sorttype: "float",	title: false, formatter:accountPaymentColModelFormatterFunction.Status},		
					];
	return colModel;
};
var accountPaymentColModelFormatterFunction	=	new Object();
function DefineAccountPaymentColModelFormatterFunction(){
	accountPaymentColModelFormatterFunction.Validity	=	function(val,colModelOB, rowdata){
		var expiryD	=	new Date(parseInt(val)*1000);
		return expiryD.getFullYear() + '-'+ (expiryD.getMonth()+1) + '-' +expiryD.getDate();  
	};
	accountPaymentColModelFormatterFunction.Mode			=	function(val,colModelOB, rowdata){
		var innerHtml	=	'';
		var modeString	=	'';
		switch (val){
		case '1':
			modeString	=	'Nova Sales';
			break;
		case '2':
			modeString	=	'Paypal';
			break;
		default:
			modeString	=	'Nova Sales';
			break;
		}
		innerHtml	+= modeString;
		return innerHtml;
	};
	accountPaymentColModelFormatterFunction.Status			=	function(val,colModelOB, rowdata){
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
	accountPaymentColModelFormatterFunction.gridComplete	=	function(){
		var Table			=	$(this);
		GRID_UNIQUE_ID	=	'AccountPaymentTable';
		if(ResizeAccountPayment	==	0){
			CommonGridCompleteFunctions(Table);
			ResizeAccountPayment++;
		}	
		$('#AccountPaymentTable').jqGrid('setCaption', 'Payment History');
		worksOnAllGridComplete(Table);
	};
}
DefineAccountPaymentColModelFormatterFunction();