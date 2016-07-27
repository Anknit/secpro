<?php
error_reporting(0);
require_once __DIR__.'./require.php';

XLSexportGridData($_GET['queryExport']);


function GenerateXLSReport($headingArr,$filenam,$assocData)
{
	$cwd	=	getcwd();	
	chdir(dirname(__FILE__).'./../Common/php');
	require_once("Spreadsheet/Excel/Writer.php");
	
	$workbook = new Spreadsheet_Excel_Writer();
	$format_bold =& $workbook->addFormat();
	$format_bold->setBold(); 
	$worksheet =& $workbook->addWorksheet();
	
	// Put the heading column
	for($m=0; $m <count($headingArr); $m++)
	{			
		$worksheet->write(0, $m, $headingArr[$m], $format_bold);
	}
	
	for($row=1;$row<=count($assocData);$row++)
	{	
		$rowData	=	$assocData[$row-1];
		$fields = 0;
		foreach ($rowData as $key=>$value){
			$worksheet->write($row, $fields, $value);
			$fields++;
		}
	}
	chdir($cwd);
	$workbook->send($filenam);
	$workbook->close();
}

function XLSexportGridData($exportQuery) {
	$exportQuery	=	json_decode($exportQuery, true);
	$tableIdentifier	=	$exportQuery['tableName'];
	$limitOrderclause	=	" ORDER BY ".$exportQuery['sidx']." ".$exportQuery['sord']." ";
	$headingArr	=	array();
	switch ($tableIdentifier){
		case 'DashboardReportTable':
			$selectiveChannelId = '';
			$selectiveProfileId = '';
			if(isset($exportQuery['filters']) &&  $exportQuery['filters'] != ''){
				$filterObject	=	json_decode($exportQuery['filters'],true);
				for($a=0;$a<count($filterObject['rules']);$a++){
					if($filterObject['rules'][$a]['field'] == 'Source'){
						$selectiveChannelId = $filterObject['rules'][$a]['data'];
					}
					else{
						$selectiveProfileId = $filterObject['rules'][$a]['data'];
					}
					
				}
			}
			if($selectiveUserId != '' && $selectiveUserId != null ) {
				$UsageReportuserIDList	=	array($selectiveUserId);
			}
			else {	
				if($_SESSION['userTYPE'] == CUSTOMER){
					$MyAccountUsers		=	getInfoFrom('user_details', 'accountUsersProfile', '');
					for($i=0;$i<count($MyAccountUsers);$i++){
						$UsageReportuserIDList[$i]	=	$MyAccountUsers[$i]['UserID'];
					}
				}
				else{
					$UsageReportuserIDList	=	array($_SESSION['userID']);
				}
			}
	
			$clause = 'UserID IN (\''.implode('\',\'', $UsageReportuserIDList).'\')';

			if($_SESSION['userTYPE'] == SUPERUSER && ($selectiveUserId == '' || $selectiveUserId == null))
				$clause	='';
			
				
			$usageReportForUser					=	array();
			$usageReportForUser['clause']		=	$limitOrderclause;
			if($clause != '')
				$usageReportForUser['UserIDList']		=	$clause;
			$MyUsageInfoMysqlresult				=	array();
			
			$MyUsageInfoMysqlresult				=	getInfoFrom('user_details', 'usageDetails', $usageReportForUser);

			$ExportRequiredDataArray	=	array("FileName"=>"File","JobEndTime"=>"End Time","FeaturesUsed"=>"Features","Username"=>"User","ContentDuration"=>"Duration(min.)","Charges"=>"Charges");

			if(is_array($MyUsageInfoMysqlresult)) {
				for($i = 0; $i< count($MyUsageInfoMysqlresult); $i++){
					$UsageRow	=	$MyUsageInfoMysqlresult[$i];
					foreach ($UsageRow as $key => $value){
						if(!in_array($key, array_keys($ExportRequiredDataArray)))
							unset($MyUsageInfoMysqlresult[$i][$key]);
						else{
							if($i == 0){
								array_push($headingArr,$ExportRequiredDataArray[$key]);
							}
						}
					}
					$arrayFeaturesEmployed	=	explode('+', $MyUsageInfoMysqlresult[$i]['FeaturesUsed']);
					if($arrayFeaturesEmployed[0]	==	'BASE')
						unset($arrayFeaturesEmployed[0]);//Remove base
					$MyUsageInfoMysqlresult[$i]['FeaturesUsed']	=	implode(', ', array_filter($arrayFeaturesEmployed, 'trim'));
				}
			}
			$filename="Usage_Report.xls";
			break;
	}
	GenerateXLSReport($headingArr,$filename,$MyUsageInfoMysqlresult); 
}
?>