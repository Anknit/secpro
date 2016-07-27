$(function(){
	var quesDiv			=	$('.ques_FAQ');
	var actionImages	=	$("<img src='../../Common/images/parent-collapsed-darkgrey.png' state='collapsed'><img src='../../Common/images/parent-expanded-darkgrey.png' state='expanded'>");
	quesDiv.prepend(actionImages);
	quesDiv.attr('state','collapsed');
	quesDiv.each(function(){
		$(this).on('click',function(){
			showHideAns(this);
		});
	});
});

var showHideAns	=	function(object){
	var obj	= $(object);
	var ansDivObj	=	obj.next();
	var objState	=	obj.attr('state');
	if(objState	==	'collapsed'){
		obj.find('img[state="collapsed"]').css('display','none');
		obj.find('img[state="expanded"]').css('display','block');
		ansDivObj.css('display', 'block');
		obj.attr('state','expanded');
	}
	else if(objState	==	'expanded'){
		obj.find('img[state="collapsed"]').css('display','block');
		obj.find('img[state="expanded"]').css('display','none');
		ansDivObj.css('display', 'none');
		obj.attr('state','collapsed');
	}
};