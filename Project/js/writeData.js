$(function(){
	for (var key in CustomDataForInternalPurposes) {
		$(key).attr('value',CustomDataForInternalPurposes[key]);
	}

	for (var key in CustomHtmlForInternalPurposes) {
		$(key).html(CustomHtmlForInternalPurposes[key]);
	}
	
	for(var i = 0; i< Elements_DisplayBlock.length; i++) {
		$(Elements_DisplayBlock[i]).css('display', 'block');
	}

	for(var i = 0; i< Elements_DisplayTable.length; i++) {
		$(Elements_DisplayTable[i]).css('display', 'table');
	}
	
	for(var i = 0; i< Elements_DisplayNone.length; i++) {
		$(Elements_DisplayNone[i]).css('display', 'none');
	}

	for (var key in callBacksFirstLevel) {
    	callBacksFirstLevel[key]();
     }
});