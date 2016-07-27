/*
* Author: Ankit
* date: 21-Feb-2015
* Description: Create grid from JSON object
*/

var USER_GRID_UNIQUE_ID ;

$(function(){
	RenderJQGrids();
});
var RenderJQGrids = function(){ 	
	$('.convertTojqGrid').each(function(){
		customJqgrid($(this)[0]);
	});
};

var ResizeTable = function(Table)
{
	var TableHeight		=	Table.height();
	var MaxDivHeight	=	Element('contentPANE').clientHeight;
	var MaxDivWidth		=	Element('contentPANE').clientWidth;
	var SetHeight	=	MaxDivHeight-130;
	var SetWidth	=	0.97 * MaxDivWidth;
	Table.jqGrid('setGridHeight', SetHeight);
	Table.jqGrid('setGridWidth', SetWidth);
};

var checkGridRowListValues = function(gridObject){
	var returnVal = $(gridObject).is('[gridRowListValues]')	?	$(gridObject).attr('gridRowListValues').split(',')	:	[10,20,30];
	
	return returnVal;
};

var fetchjqGridObject = function(gridObject){
	return {
			datatype: 	function(postdata){
				jQuery.ajax({
					url:$(gridObject).attr('url'),
					data:postdata,
					contentType: "application/json",
					dataType:"json",
					complete: function(jsondata,stat){
					  if(stat=="success") {
							TotalPages		=	jsondata.responseJSON.total;
							ResponseData	=	jsondata.responseJSON.rows;
							var thegrid 	= jQuery('#'+$(gridObject).attr('id'))[0];
							thegrid.addJSONData(jsondata.responseJSON);
					  }
				   }
				});
			},
			colNames:$(gridObject).attr('colNames').split(','),
			colModel:window[$(gridObject).attr('colModel')](),
			jsonReader : {
				 root: "rows",
				 records: "records",
				 viewrecords: true,
				 repeatitems: true,
				 cell: "",
				 id: "0"
			},
			rowNum:20,
			rowList:checkGridRowListValues(gridObject),
			gridview: true,
			ignoreCase: true,
			autoencode: true,
			//loadonce: true,	If this is on the total pages in pager wouldn't work well. This will load records at once only
   			emptyrecords: "No records found",
  			shrinktoFit: true,
 			pager : '#gridpager_'+$(gridObject).attr('id'),
  			forceFit: true,
			recordpos: 'left',
			viewrecords: true,
			pginput : true,
  			sortname: $(gridObject).attr('sortBy'),
			sortorder: $(gridObject).is('[sortOrder]') ? $(gridObject).attr('sortOrder') : 'asc',
			toolbar:[false,'top'],
			onSelectRow: function(rowid,status,e){
				selectRadioButton	=	$(e.target).closest('tr').find('input[type="radio"]');
				if(status == false || selectRadioButton.length == 0){
					$(this).jqGrid("resetSelection");
				}
				if(selectRadioButton.length > 0){
					if(!($(selectRadioButton).is(':checked'))){
						$(selectRadioButton).prop('checked',true);
						$(selectRadioButton).change();
					}
					else{
						$(selectRadioButton).prop('checked',false);
						$(selectRadioButton).change();
					}
				}
				if(!IsValueNull($(gridObject).attr('selectRowFunc'))){
					window[$(gridObject).attr('selectRowFunc')].selectRowFunction(rowid,status,e);
				}
			},
			gridComplete: window[$(gridObject).attr('gridComplete')].gridComplete
		};
};

var customJqgrid = function(gridObject){
	var GridUniqueid	=	$(gridObject).attr('id');
	var ResponseData	=	"";
	var TotalPages;
	var jqgridOBJECT = fetchjqGridObject(gridObject);
	$('#'+GridUniqueid).jqGrid(jqgridOBJECT);
};
