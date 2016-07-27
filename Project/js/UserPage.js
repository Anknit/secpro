$(function(){
	var id="";
	var custominnerhtml = '';
	var openedTab	=	'';
	soapErr		=	extractCookie('soapError');
	if(soapErr){
		AlertMessage({msg:SoapErrorMessages[soapErr]});
	}
	openedTab	=	extractCookie('tab');
	if(!openedTab){
		if(regUserType == 2 )
			openedTab	=	"HomePageMonitor";
		else if(regUserType == 1)
			openedTab 	=	"HomePageUsers";
		else
			openedTab 	=	"HomePageCustomers";
	}
	else{
		if(openedTab.indexOf('#') != -1){
			msgId		=	openedTab.split('#')[1];
			openedTab	=	openedTab.split('#')[0];
			AlertMessage({msg:RefreshMessages[msgId], error:0});
		}
	}
/*	if(regUserType == 2){
		$('.GlobalInfoSection').css('top','1%');
		$('.GlobalInfoSection').css('margin-top','5px');
	}
*/	$('.tabDiV').css("display","none");
	$('#'+openedTab).css("display","");
	$('#menuBar').on('itemclick', changeTab);
	//put a space in empty table cells
	callBacksFirstLevel.FillEmptyCells	=	function(){
		$('li[assocdiv="'+openedTab+'"]').addClass('activeMenu');
		var allTableCells	=	$('tr[id]').find($('td'));
		allTableCells.each(function(){
			if($(this).html()	==	'')
				$(this).html('&nbsp;');
		});
	};
});
var changeTab = function (event){
	$('input[type="radio"]:checked').closest('.convertTojqGrid').jqGrid('resetSelection');	
	$('input[type="radio"]:checked').prop('checked',false);
	$('input[type="radio"]').change();
	$('.sub_list_container').css('display','none');
	var element = event.target;
	if(element.nodeName == "IMG"){
		return false;
	}else if(element.textContent == 'Layouts'){
		return false;
	}
	$('.activeMenu').removeClass('activeMenu');
	$(element).addClass('activeMenu');
	var displayDiv	=	$($(element).closest('li')).attr('assocDiv');
	if($('#'+displayDiv).length == 0)
		return false;
	else{
		$('.tabDiV').css("display","none");
		$('#'+displayDiv).css('display','block');
	}
};
var showProfileDiv = function(){
	$('.tabDiV').css("display","none");
	$('#personalInfoDiv').css("display","");
};
function editProfile(){
	var Data_random 	= randomize_Data('email='+username+'&userID='+userID);
	var Data_encoded 	= EncodeData(Data_random);
	window.location 	= 'Registration.php?'+Data_encoded;
}
