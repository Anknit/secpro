var TRANS_REP_GRID_UNIQUE_ID	=	'TransRepTable';
var	ResizeTransRep	=	0;
var UserNamehiddenflag	=	false;
if(regUserType	==	User_CUSTOMER)
	UserNamehiddenflag	=	true;
var TransRepColModel	=	function(){
	var colModel = [
	                	{name:'PaymentIndex',	index:'PaymentIndex',	width:0,	hidden: true, 		title: false},
	                	{name:'CustomerID',		index:'CustomerID',		width:0,	hidden: true, 		title: false},
						{name:'TransactionID',	index:'TransactionID',	width:80,	align: 'left', 		title: false},
						{name:'AmountPaid',		index:'AmountPaid',		width:40,	align: 'left',		sorttype: "float",	align:"left", title: false, formatter:TransRepColModelFormatterFunction.Credits},
						{name:'PayDate',		index:'PayDate',		width:60,	align: 'left',		sorttype: "float", 	title: false, formatter:TransRepColModelFormatterFunction.Date},
						{name:'Username',		index:'CustomerID',		width:100,	hidden:	UserNamehiddenflag,				align: 'left',		sorttype: "float", 	title: false, formatter:TransRepColModelFormatterFunction.UserName},
						{name:'Pay_Mode',		index:'Pay_Mode',		width:60, 	align: 'left',		sorttype: "float", 	title: false, formatter:TransRepColModelFormatterFunction.Mode},
						{name:'Payment_ModeID',	index:'Payment_ModeID',	width:100, 	align: 'left',		hidden: true},
						{name:'Invoice',		index:'Invoice',		width:15, 	align: 'left',		hidden: false, formatter:TransRepColModelFormatterFunction.Invoice},
					];
	return colModel;
};

var TransRepColModelFormatterFunction	=	new Object();
function DefineTransRepColModelFormatterFunctions(){

	TransRepColModelFormatterFunction.Credits		=	function(val,colModelOB, rowdata){
		var currency = ' USD';
		return val+currency;
	};
	
	TransRepColModelFormatterFunction.Date		=	function(val,colModelOB, rowdata){
		var timezone	=	' UTC';
		return val+timezone;
	};
	
	TransRepColModelFormatterFunction.Mode		=	function(val,colModelOB, rowdata){
		var innerhtml='';
		switch (val){
			case '0':{
				innerhtml = PPU_TEXT_CONSTANTS.reportsConstant[0];
				break;
			}
			case '1':{
				innerhtml = PPU_TEXT_CONSTANTS.reportsConstant[1];
				break;
			}
			case '2':{
				innerhtml = PPU_TEXT_CONSTANTS.reportsConstant[2];
				break;
			}
			default:{
				break;
			}
		}
		innerhtml += '<input type="hidden" id="Voucher_'+rowdata.PaymentIndex+'" value="'+val+'" /> ';
		return innerhtml;
	};
	
	TransRepColModelFormatterFunction.UserName	=	function(val,colModelOB, rowdata){
		if(!UserNamehiddenflag){
			if(!IsValueNull(AllUsersData[rowdata.CustomerID]))
				return AllUsersData[rowdata.CustomerID].Username;
			else
				return 'N/A';
		}
	}
	
	TransRepColModelFormatterFunction.Invoice		=	function(val,colModelOB, rowdata){
		if(rowdata.Pay_Mode	!=	'1'){
			return '&nbsp;';
			var voucherID = rowdata.TransactionID;
			var InvoiceUserID =	rowdata.CustomerID;
			return '<img src="../../Common/images/pdf.png" title="Generate Invoice" onclick="GenerateTransactionInvoice(this);" mode=2 voucherID="'+voucherID+'" InvoiceUserID="'+InvoiceUserID+'" style="cursor:pointer"/>';
		}
		else{
			var value	=	rowdata.PaymentIndex;
			return '<img src="../../Common/images/pdf.png" title="Generate Invoice" onclick="GenerateTransactionInvoice(this);" mode=1 value="'+value+'" style="cursor:pointer"/>';
		}
	};
	
/*	TransRepColModelFormatterFunction.AssignedTo	=	function(val,colModelOB, rowdata){
		var innerhtml='';
		if(!IsValueNull(rowdata.CustomerID))
			innerhtml	+=	getCustomerUserName(rowdata.CustomerID);
		else{
			if(rowdata.voucherStatus == 1)
				innerhtml	+= "<input id='assignInput_"+ rowdata.voucherIndex+"' class='assigninput' list='voucherCustomers' name='voucherCustomer' style='float:left'/><img value="+rowdata.voucherIndex+" src='../../PulsarPPU/images/tag.png' onclick='assignVoucher(this)' title='Assign to user' alt='assign user' style='width:12%;cursor:pointer'>";
		}
			return innerhtml;
	}
	
	TransRepColModelFormatterFunction.DeleteVoucher	=	function(val, colModelOB, rowdata){
		var value = rowdata.voucherIndex;
		if(rowdata.voucherStatus == 1)
			return '<img src="../../Common/images/delete.png" title="Cancel Voucher" onclick="showDeleteVoucherForm(this);" value="'+value+'" style="cursor:pointer"/>';
		else
			return '&nbsp;';
	}
*/
	TransRepColModelFormatterFunction.gridComplete	=	function(){
		var Table			=	$(this);
		GRID_UNIQUE_ID	=	TRANS_REP_GRID_UNIQUE_ID;
		if(ResizeTransRep	==	0){
			CommonGridCompleteFunctions(Table);
			ResizeTransRep++;
		}	
		worksOnAllGridComplete(Table);
	};
}

DefineTransRepColModelFormatterFunctions();