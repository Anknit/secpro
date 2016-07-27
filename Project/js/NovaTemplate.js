var templateCheckObject	=	new Object();
var editTemplateId	=	'';
$(function(){
	bindTemplateChecks();
	$('#templateForm').on('close',resetTemplateData);
});
var ResizeTemplateTable	=	0;
var templateColModel	=	function(){
	var colModel = [
	                	{name:'templateId',			index:'templateId',			width:'20px',	title: false, formatter:templateColModelFormatterFunction.templateSelector},
						{name:'templateName',		index:'templateName',		width:'100%',	align: 'left',	title: false},
						{name:'templateDescription',index:'templateDescription',width:'100%',	align: 'left',	title: false}
					];
	return colModel;
};
var templateColModelFormatterFunction	=	new Object();
function DefinetemplateColModelFormatterFunctions(){
	templateColModelFormatterFunction.templateSelector	=	function(val,colModelOB, rowdata){
		var innerhtml='<input type="radio" name="template_list_items_radio" id="Template_'+rowdata.templateId+'" value="'+val+'" /> ';
		return innerhtml;
	};
	templateColModelFormatterFunction.gridComplete	=	function(){
		var Table			=	$(this);
		GRID_UNIQUE_ID	=	'TemplateTable';
		if(ResizeTemplateTable	==	0){
			CommonGridCompleteFunctions(Table);
			ResizeTemplateTable++;
		}	
		$('#TemplateTable').jqGrid('setCaption', 'Monitoring setting List');
		worksOnAllGridComplete(Table);
		bindTemplateRadioButtons();
	};
}
DefinetemplateColModelFormatterFunctions();
var deleteTemplate = function(){
	var confirmation	=	confirm('Do you want to delete monitoring setting');
	if(!confirmation)
		return false;
	var deleteTemplateId	=	$('#HomePageTemplates').find('input[type="radio"][name="template_list_items_radio"]:checked').attr('value');
	ajaxRequestObject.actionScriptURL	=	'./../InterfaceToDatabaseUpdates.php?Operation=TemplateInfo&cat=delete&templateId='+deleteTemplateId;
	ajaxRequestObject.sendMethod	=	'GET';
	ajaxRequestObject.responseType	=	1;
	ajaxRequestObject.callBack	=	function(Response){
		deloadImage();
		var defaultCheck = checkResponseUrl(Response);
		if(defaultCheck){
			Response	=	Response.responseText;
			if(Response == 0 || Response == "0")
				refreshdata('HomePageTemplates#12');
			else{
				erMsg	=	'Monitoring setting not deleted properly';
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
var saveTemplate	=	function(){
	var checkflag = checkOnUpdateForInvalidEntries();
	if(!checkflag){
		return false;
	}
	var templateName		=	$('#TemplateName').val().trim();
	var templateDescription	=	$('#TemplateDescription').val().trim();
	var operationTypeString	=	'&cat=add';
	var msgNo	=	'13';
	if(editTemplateId != ''){
		msgNo	=	'14';
		operationTypeString	=	'&cat=edit&tempId='+editTemplateId;
	}
	if(templateName !='' && templateDescription != ''){
		if(validateTemplateChecks()){
			ajaxRequestObject.actionScriptURL	=	'./../InterfaceToDatabaseUpdates.php?Operation=TemplateInfo'+operationTypeString+'&templateCheckObject='+JSON.stringify(templateCheckObject)+'&name='+templateName+'&desc='+templateDescription;
			ajaxRequestObject.sendMethod	=	'GET';
			ajaxRequestObject.responseType	=	1;
			ajaxRequestObject.callBack	=	function(Response){
				deloadImage();
				var defaultCheck = checkResponseUrl(Response);
				if(defaultCheck){
					Response	=	Response.responseText;
					editTemplateId	=	'';
					if(Response==0 || Response=='0')
						refreshdata('HomePageTemplates#'+msgNo);
					else{
						erMsg	=	'Monitoring setting configuration failed';
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
		}
	}
	else{
		AlertMessage({msg:TemplateErrorMessages[0]});
	}
};
var resetTemplateData	=	function(){
	$('#templateName').val('');
	editTemplateId	=	'';
	$('#templateDescription').val('');
	$($('#templateForm').find('input[type="text"]')).val('');
	$($('#templateForm').find('input[type="checkbox"]')).prop('checked',false);
	$($('#templateForm').find('select')).val(1);
	$($('#templateForm').find('.loudnessTableBody')).each(function(){
		$(this).html($(this).find('tr').eq(0));
	});
};
var cancelSaveTemplate = function(){
	$('#templateForm').jqxWindow('close');
};
var bindTemplateRadioButtons	=	function(){
	$('input[type="radio"][name="template_list_items_radio"]').each(function(){
		$(this).change(function(){
			var CheckCondition	=	$(this).is(':checked');
			var targetElements	=	$('#HomePageTemplates').find('.menu_item_disable');
			enableDisableButtons(targetElements, CheckCondition);
		});
	});
};
var bindTemplateChecks	=	function(){
	$('#templateForm').find('input[type="checkbox"]').each(function(){
		$(this).on('change',function(){
			if($(this).is(':checked')){
				$(this).closest('.item').siblings('.bind_hidden').css('display','block');
				if($(this).attr('name') == 'loudnessDetection'){
					$('[loudnessType="'+$('#loudnessDetectionMode').val()+'"]').css('display','block');
				}
			}
			else{
				$(this).closest('.item').siblings('.bind_hidden').css('display','none');
			}
		});
	});
	$('#loudnessDetectionMode').on('change',function(){
		$('[loudnessType]').css('display','none');
		$('[loudnessType="'+$(this).val()+'"]').css('display','block');
	});
};
var editTemplate	=	function(){
	loadImage();
	$('#templateForm').jqxWindow('open');
	$('#templateForm').find('.windowHead').children().eq(0).html('Edit setting');
	$('#templateForm').find('[value="Add"]').attr('value','Update');
	var templateId	=	$('#HomePageTemplates').find('input[name="template_list_items_radio"]:checked').attr('value');
	editTemplateId	=	templateId;
	$('#TemplateName').val(TemplateList[templateId]['templateName']);
	$('#TemplateDescription').val(TemplateList[templateId]['templateDescription']);
	ajaxRequestObject.actionScriptURL	=	'./fetchData.php?data=checks&tempId='+templateId;
	ajaxRequestObject.sendMethod	=	'GET';
	ajaxRequestObject.responseType	=	1;
	ajaxRequestObject.callBack	=	function(Response){
		deloadImage();
		var defaultCheck = checkResponseUrl(Response);
		if(defaultCheck){
			Response	=	Response.responseText;
			deloadImage();
			RenderTemplateChecks(JSON.parse(Response));
		}
	};
	send_remoteCall(ajaxRequestObject);
	ajaxRequestObject	=	{};
};
var validateTemplateChecks	=	function(){
	var inputField	=	'';
	var checkname	=	'';
	var validationOutput	=	true;
	$('#templateForm').find('.windowBody').find('input[type="checkbox"]:checked').not('.checkVal').each(function(){
		checkname	=	$(this).attr('name');
		if($(this).hasClass('onlyCheckBoxValue')){
			templateCheckObject[checkname]	=	1;
		}
		else if($(this).hasClass('TemplateCheckException')){
			validationOutput = window[$(this).attr('validateCheckFunction')]($(this));
		}
		else{
			inputField	=	$(this).closest('.item_Row').find('.checkVal');
			if(inputField.length>0){
				for(i=0;i<inputField.length;i++){
					if($(inputField[i]).val() == '' ||  $(inputField[i]).val() == undefined ){
						AlertMessage({msg:TemplateErrorMessages[$(inputField[i]).attr('templateErrorMessage')]});
						validationOutput	=	false;
						return false;
					}
					else{
						if(typeof(templateCheckObject[checkname]) != "object")
							templateCheckObject[checkname]	=	{};
						if(inputField[i].type == "checkbox"){
							if($(inputField[i]).is(':checked')){
								templateCheckObject[checkname][$(inputField[i]).attr('xmlName')]	=	1;
							}
							else{
								templateCheckObject[checkname][$(inputField[i]).attr('xmlName')]	=	0;
							}
						}
						else{
							templateCheckObject[checkname][$(inputField[i]).attr('xmlName')]	=	$(inputField[i]).val();
						}
					}
				}
			}
		}
	});
	return validationOutput;
};

var RenderTemplateChecks	=	function(templateChecks){
	for(var key in templateChecks){
		if(key == 'loudnessDetection'){
			RenderLoudnessCheck(templateChecks[key]);
		}
		else{
			if(typeof(templateChecks[key]) == "object"){
				$('#templateForm').find('[name="'+key+'"]').prop('checked',true);
				for(var childkey in templateChecks[key]){
					if(typeof(templateChecks[key][childkey]) == "object"){
						for(var subchildkey in templateChecks[key][childkey]){
							if(typeof(templateChecks[key][childkey][subchildkey]) == "object"){
								for(var entry in templateChecks[key][childkey][subchildkey]){
									$('#templateForm').find('[name="'+key+'"]').closest('.item_Row').find('[xmlname="'+entry+'"]').val(templateChecks[key][childkey][subchildkey][entry]);
								}
							}
							else{
								$('#templateForm').find('[name="'+key+'"]').closest('.item_Row').find('[xmlname="'+subchildkey+'"]').val(templateChecks[key][childkey][subchildkey]);
							}
						}
					}
					else{
						$('#templateForm').find('[name="'+key+'"]').closest('.item_Row').find('[xmlname="'+childkey+'"]').val(templateChecks[key][childkey]);
					}
				}
			}
			else{
				$('#templateForm').find('[name="'+key+'"]').prop('checked',true);
			}
		}
	}
	$('#templateForm').find('input[type="checkbox"]').change();
};
var ebuParamRow	=	function(){
	if($('#EBU_paramTable').find('tbody').find('tr').length>1){
		AlertMessage({msg:'No more rows can be added'});
	}
	else{
		$('#EBU_paramTable').find('tbody').find('tr').clone().appendTo('.loudnessTableBody');
	}
};
var deleteParamRow	=	function(imgObj){
	if($('#EBU_paramTable').find('tbody').find('tr').length<2){
		AlertMessage({msg:'At least one row must be present'});
	}
	else{
		$(imgObj).closest('tr').remove();
	}
};
var loudnessCheckValidate	=	function(loudnessCheckBox){
	
	var localValidationOutput	=	true;
	templateCheckObject['loudnessDetection']	=	{};
	templateCheckObject['loudnessDetection']['Mode']	=	$('#loudnessDetectionMode').val();
	var thresholdLevel	=	$('tbody[mode="'+$('#loudnessDetectionMode').val()+'"]').children();
	var thresholdLevelCount		=	thresholdLevel.length;

	templateCheckObject['loudnessDetection']['thresholdLevel']	= [];	
	if($('[xmlname="EBUTimescale"]').length >1){
		if($($('[xmlname="EBUTimescale"]')[0]).val() == $($('[xmlname="EBUTimescale"]')[1]).val()){
			AlertMessage({msg:'Both timescale for EBU mode cannot be same'});
			localValidationOutput	=	false;
			return false;
		}
	}
	for(thresholdRow=0;thresholdRow<thresholdLevelCount;thresholdRow++){
		if(!localValidationOutput){
			return false;
		}
		templateCheckObject['loudnessDetection']['thresholdLevel'][thresholdRow]	= {};	
		maxLoudlevel	=	$(thresholdLevel[thresholdRow]).find('[name="EBU_maxLoudLevel"]').val();
		minLoudlevel	=	$(thresholdLevel[thresholdRow]).find('[name="EBU_minLoudLevel"]').val();
		if(maxLoudlevel == '' && minLoudlevel == ''){
			AlertMessage({msg:'At least one out of maximum and minimum audio loudness level must be specified'});
			localValidationOutput	=	false;
			return false;
		}

		if(maxLoudlevel != '' && minLoudlevel != '' ){
			maxLoudValue	=	 parseInt($(thresholdLevel[thresholdRow]).find('[name="EBU_maxLoudSign"] option:selected').text()+maxLoudlevel);
			minLoudValue	=	 parseInt($(thresholdLevel[thresholdRow]).find('[name="EBU_minLoudSign"] option:selected').text()+minLoudlevel);
			if( maxLoudValue< minLoudValue){
				AlertMessage({msg:'Please enter minimum loudness level that is lower than maximum loudness level for an Averaging duration'});
				localValidationOutput	=	false;
				return false;
			}
		}
		
		inputField	=	$(thresholdLevel[thresholdRow]).find('.checkVal');
		for(i=0;i<inputField.length;i++){
			templateCheckObject['loudnessDetection']['thresholdLevel'][thresholdRow][$(inputField[i]).attr('xmlName')]	=	$(inputField[i]).val();
		}

	}
	return localValidationOutput;
};
var RenderLoudnessCheck	=	function(loudnessCheckObj){
	$('#loudnessDetectionMode').val(loudnessCheckObj['Mode']);
	$('div[loudnessType]').css('display','none');
	$('div[loudnessType="'+loudnessCheckObj['Mode']+'"]').css('display','block');
	$('#templateForm').find('[name="loudnessDetection"]').prop('checked',true);
	var thresholdLevels	=	loudnessCheckObj['thresholdLevel'];
	var thresholdCount	=	thresholdLevels.length;
	for(c=0;c<thresholdCount;c++){
		if(c != 0){
			tableBody	=	$('div[loudnessType="'+loudnessCheckObj['Mode']+'"]').find('tbody');
			newRow	=	$(tableBody.find('tr')[0]).clone(false);
			$(tableBody).append(newRow);
		}
		for(var entry in thresholdLevels[c]){
			$('#templateForm').find('[xmlname="'+entry+'"]')[c].value	=	thresholdLevels[c][entry];
		}
	}

};

var checkOnUpdateForInvalidEntries = function() {
		var returnVal	=	true;
		var elem	=	$('#templateForm input[min]');
		for(i=0; i<elem.length; i++){
			if (elem[i].value == '') {
				returnVal = true;
				continue;
			}
			else if (elem[i].value < $(elem[i]).attr('min')) {
				elem[i].value = $(elem[i]).attr('min');
				AlertMessage({
					msg : 'Please enter value greater than or equal to '+numberString($(elem[i]).attr('min'))+'.'
				});
				returnVal = false;
				break;
			}
		}
		return returnVal;
};

var numberString	=	function(val){
	var out = '';
	switch(parseInt(val)){
	case 1:
		out += 'one';
		break;
	case 0:
		out += 'zero';
		break;
	default:
		break;
	}
	return out;
};