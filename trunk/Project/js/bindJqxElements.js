/*
* Author: Ankit
* date: 21-Feb-2015
* Description: This defines configuration for jqx elements
*/

$(function(){
	if($('.JqxMenus').length >0)
		$('.JqxMenus').jqxMenu({ width: '98%', height: '32px'});
	if($('.modal_div').length >0){
		$('.modal_div').jqxWindow({height: 400, width: 400, isModal: true, autoOpen: false });
		$('.modal_div').on('open', function(event){ResizeModal(event);});
	}
	if($('#templateForm').length>0){
		$('#templateForm').jqxWindow({height: '100%', width: '100%', isModal: true, autoOpen: false });
		$('#templateForm').on('close', function(event){
			$('#templateForm').find('.windowHead').children().eq(0).html('Add Setting');
			$('#templateForm').find('[value="Update"]').attr('value','Add');
			$('#templateForm').find('form')[0].reset();
			$('#templateForm').find('input[type="checkbox"]').change();
		});
	}
	if($('.jqxbutton').length >0)
		$('.jqxbutton').jqxButton({ width: '100px', height: '25px'});
	if($('.menu_item_disable').length >0)
		$('.menu_item_disable').jqxButton({ disabled:'disabled'});
	if($('.jqx-window-close-button-background').length >0)
		$('.jqx-window-close-button-background').css('width','16px');
	if($('input[type="number"],[type="text"],[type="email"]').not('.plainInput').length >0)
		$('input[type="number"],[type="text"],[type="email"]').not('.plainInput').jqxInput({ width: '150px', height: '20px'});
	if($('.size_s').length>0)
		$('.size_s').jqxInput({ width: '60px', height: '20px'});
	if($('textarea').length >0)
		$('textarea').jqxInput({ width: '150px', height: '60px'});
	if($('#TemplateDescription').length>0){
		$('#TemplateDescription').jqxInput({width: '400px', height: '40px'});
	}
});
var ResizeModal	=	function(event){
	var contentTable	=	$(event.target).find('.windowBody').find('table').eq(0);
	var contenTableWidth	=	parseInt(contentTable.css('width').replace('px',''));
	var contenTableHeight	=	parseInt(contentTable.css('height').replace('px',''));
	if(IsValueNull(navigator.systemLanguage)){
		$(event.target).css('height',(contenTableHeight+50).toString()+'px');
		$(event.target).css('width',(contenTableWidth+20).toString()+'px');
		$(event.target).find('.windowBody').css('width',(contenTableWidth+15).toString()+'px');
		$(event.target).find('.windowHead').css('width',(contenTableWidth+40).toString()+'px');
	}
	
// To check if browser is IE or Not
//	if(document.documentMode) { 
//		  document.documentElement.className+=' ie'+document.documentMode;
//		}
	$(event.target).jqxWindow('resize',contenTableWidth+50,contenTableHeight+50);

};