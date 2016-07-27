<?php
/*
 * Author: Ankit
 * Date: 11-Aug-2014
 * Description: Page to fetch data from Database. 
 * 
 */

require_once __DIR__.'./../../require.php';

$data	=	$_GET['data'];
switch($data){
	case 1:{
		getVoucherData();
		break;
	}
	case 2:{
		getUserData();
		break;
	}
	case 3:{
		getTransReportData();
		break;
	}
	case 4:{
		getUsageReportData();
		break;
	}
	default:{
		break;
	}
}

function getTotalRecords($clause, $table){
	$query	=	"Select Count(*) AS TotalRecordsAvailable FROM ".$table;
	if($clause != '')
		$query	.=	" WHERE ".$clause;
		
	$TotalRecordsResult	=	DB_Query($query,'ASSOC', '');
	$recordCount = $TotalRecordsResult[0]['TotalRecordsAvailable'];
	return $recordCount;
}

function getTransReportData(){
	if($_SESSION['userTYPE']	==	VENERA_SALES){
		$userIDlist	=	getInfoFrom('user_details', 'users_under_all_Levels_to_customers',$_SESSION['userID'],$_SESSION['userTYPE']);
		$myCustomerusersId	=	array();
		for($i = 0; $i< count($userIDlist); $i++){
			$myCustomerusersId[]	=	$userIDlist[$i]['userID'];
		}
		$clause	=	'CustomerID IN (\''.implode('\',\'', $myCustomerusersId).'\')';
//		$clause = 'CustomerID IN '.$userIDlist;
	}
	elseif($_SESSION['userTYPE']	==	SUPERUSER){
		$clause	=	'';
	}
	else
		$clause = 'CustomerID = '.$_SESSION['userID'];
	$limit	=	$_GET['rows'];
	if($limit != -1)
	{
		$page	=	$_GET['page'];
		$start = $limit*$page - $limit;
		$recordCount	=	getTotalRecords($clause, 'payment_info'); 
		$orderClause	=	$_GET['sidx']." ".$_GET['sord']." LIMIT $start , $limit";
		$total_pages = ceil($recordCount/$limit);
	}
	else
	{
		$page	=	1;
		$total_pages = 1; 
	}
	
/*	if($total_pages < 1)
		$total_pages	=	1;
*/		
	$readInput	=	array(
					'Table'=> 'payment_info',					
					'Fields'=> '*',						
					'clause'=> $clause,
					'order'	=>$orderClause
					);

	$MyPaymentInfo				=	DB_Read($readInput, 'ASSOC','');
	if(count($MyPaymentInfo) > 0) {
	
		//Return result to jTable
		$jTableResult = array();
		$jTableResult['total'] 		= $total_pages;
		$jTableResult['page'] 		= $page;
		$jTableResult['records']	= $recordCount;
		$jTableResult['rows'] 	 	= $MyPaymentInfo;
		$OutputJson					= json_encode($jTableResult);
		echo $OutputJson;
	}
}

function getUsageReportData(){
	if($_SESSION['userTYPE'] == CUSTOMER){
		$MyAccountUsers		=	getInfoFrom('user_details', 'accountUsersProfile', '');
		for($i=0;$i<count($MyAccountUsers);$i++){
			$UsageReportuserIDList[$i]	=	$MyAccountUsers[$i]['UserID'];
		}
	}
	else{
		$UsageReportuserIDList	=	array($_SESSION['userID']);
	}
	
	$clause = 'UserID IN (\''.implode('\',\'', $UsageReportuserIDList).'\')';
	if($_SESSION['userTYPE'] == SUPERUSER)
		$clause	='';
	$limit	=	$_GET['rows'];
	if($limit != -1)
	{
		$page	=	$_GET['page'];
		$start = $limit*$page - $limit;
		$recordCount	=	getTotalRecords($clause, 'usageinfo'); 
		$limitOrderclause	=	" ORDER BY ".$_GET['sidx']." ".$_GET['sord']." LIMIT $start , $limit";
		$total_pages = ceil($recordCount/$limit);
	}
	else
	{
		$page			=	1;
		$total_pages	=	1; 
	}
		
	$usageReportForUser					=	array();
	$usageReportForUser['clause']		=	$limitOrderclause;
	$MyUsageInfoMysqlresult				=	array();
	
	$MyUsageInfoMysqlresult				=	getInfoFrom('user_details', 'usageDetails', $usageReportForUser);
	if(is_array($MyUsageInfoMysqlresult)) {
		for($i = 0; $i< count($MyUsageInfoMysqlresult); $i++){
			$arrayFeaturesEmployed	=	explode('+', $MyUsageInfoMysqlresult[$i]['FeaturesUsed']);
			if($arrayFeaturesEmployed[0]	==	'BASE')
				unset($arrayFeaturesEmployed[0]);//Remove base
				
			$MyUsageInfoMysqlresult[$i]['FeaturesUsed']	=	implode(', ', array_filter($arrayFeaturesEmployed, 'trim'));
		}
	}	
	$MyUsageInfo	=	$MyUsageInfoMysqlresult;	
	//Return result to jTable
	$jTableResult = array();
	$jTableResult['total'] 		= $total_pages;
	$jTableResult['page'] 		= $page;
	$jTableResult['records']	= $recordCount;
	$jTableResult['rows'] 	 	= $MyUsageInfo;
	$OutputJson					= json_encode($jTableResult);
	echo $OutputJson;
}


function getVoucherData(){
	$clause	=	'';
	if($_SESSION['userTYPE']	==	VENERA_SALES){
		$usersList	=	getInfoFrom('user_details', 'commaSeparatedUserIDStringRegisteredBy', $_SESSION['userID']);
		//$usersList	=	array_filter($usersList, 'checkUserTypeReseller');
		
		if($usersList	!=	'')
			$usersList	.=	', ';
		
		$usersList	.=	'"'.$_SESSION['userID'].'"';
		
		$usersclause	=	'IN ('. $usersList.')';
	}
	elseif($_SESSION['userTYPE']	==	RESELLER){
		$usersList		=	$_SESSION['userID'];
		$usersclause	=	' = '.$_SESSION['userID'];
	}
	if($_SESSION['userTYPE']	!=	SUPERUSER)
		$clause = 'GeneratedBy '.$usersclause;

	$limit	=	$_GET['rows'];
	if($limit != -1)
	{
		$page	=	$_GET['page'];
		$start = $limit*$page - $limit;
		$recordCount	=	getTotalRecords($clause, 'voucherinfotable'); 
		$limitOrderclause	=	" ORDER BY ".$_GET['sidx']." ".$_GET['sord']." LIMIT $start , $limit";
		$total_pages = ceil($recordCount/$limit);
	}
	else
	{
		$page	=	1;
		$total_pages = 1; 
	}
	
	$voucher_generated_by_Users		=	array();
	$voucher_generated_by_Users['userIdList']	=	$usersList;
	$voucher_generated_by_Users['clause']		=	$limitOrderclause;
	
	$MyGeneratedVouchersMysqlresult				=	getInfoFrom('user_details', 'vouchersGeneratedByUser', $voucher_generated_by_Users);
/*	while($row	=	mysqli_fetch_assoc($MyGeneratedVouchersMysqlresult)){
		$MyGeneratedVouchers[]	=	$row;
	}*/
	$MyGeneratedVouchers	=	$MyGeneratedVouchersMysqlresult;
		//Return result to jTable
		$jTableResult = array();
		$jTableResult['total'] 		= $total_pages;
		$jTableResult['page'] 		= $page;
		$jTableResult['records']	= $recordCount;
		$jTableResult['rows'] 	 	= $MyGeneratedVouchers;
		$OutputJson					= json_encode($jTableResult);
		echo $OutputJson;
	}

function getUserData(){
	global $userTypeListForSales, $userTypeListForSuperUser;
	switch($_SESSION['userTYPE']){
		case VENERA_SALES:{
			$userIdArray	=	getInfoFrom('user_details', 'users_under_all_Levels_to_customers', $_SESSION['userID'], $_SESSION['userTYPE']);
			$userIdUnderSales	=	array();
			for($i = 0; $i< count($userIdArray); $i++){
				$userIdUnderSales[]	=	$userIdArray[$i]['userID'];
			}
			$clause = 'UserID IN (\''.implode('\',\'', $userIdUnderSales).'\')';
			break;
		}
		case SUPERUSER:{
			$clause = 'UserType IN (\''.implode('\',\'', $userTypeListForSuperUser).'\')';
			break;
		}
		case RESELLER:{
			$clause = 'regAuthorityID = '.$_SESSION['userID'];
			break;
		}
		case CUSTOMER:{
			$clause = 'AccountID = '.$_SESSION['accountID'];
			break;
		}
		default:{
			break;
		}
	}

	$limit	=	$_GET['rows'];
	if($limit != -1)
	{
		$page	=	$_GET['page'];
		$start = $limit*$page - $limit;
		$recordCount		=	getTotalRecords($clause,'userinfo');
/*		if($_GET['sidx']	==	'UserID')
			 $_GET['sidx']	=	'userinfo.UserID';
*/		$limitOrderclause	=	" ORDER BY ".$_GET['sidx']." ".$_GET['sord']." LIMIT $start , $limit";
		$total_pages = ceil($recordCount/$limit);
	}
	else
	{
		$page	=	1;
		$total_pages = 1; 
	}
	
	$MyRegisteredUsersAccountInfo	=	array();
	$creditsINFO					=	array();
	if($_SESSION['userTYPE'] == CUSTOMER){
		$MyRegisteredUsersAccountInfo		=	getInfoFrom('user_details', 'customerAccountDetails', $_SESSION['accountID'], $limitOrderclause);
		for($i = 0; $i < count($MyRegisteredUsersAccountInfo); $i++) {
			$MyRegisteredUsersAccountInfo[$i]['Features']	=	GetCommaSeparatedApplicationFeatures($MyRegisteredUsersAccountInfo[$i]['Features']);
			if($MyRegisteredUsersAccountInfo[$i]['Plan']	==	Subscription_PayPerUse) {
				$MyRegisteredUsersAccountInfo[$i]['Expiry']	=	''; //$MyRegisteredUsersAccountInfo[$i]['accountValidity'];
			}
		}
		
//		$MyRegisteredUsersAccountInfo		=	DB_Query('Select *, Subscription_Type AS Plan, Validity_End_Date As Expiry From userinfo Left Join usersubscriptioninfo On userinfo.UserID = usersubscriptioninfo.UserID Left Join licenseinfo  On userinfo.UserID = licenseinfo.UserID Where AccountID = '.$_SESSION['accountID'].$limitOrderclause);
		
	}
	else{
		$MyRegisteredUsersAccountInfo		=	getInfoFrom('user_details', 'registeredUsersProfile', array('userId' => $_SESSION['userID'], 'clause' => $limitOrderclause));
		if(is_array($MyRegisteredUsersAccountInfo)) {
			for( $i = 0; $i < count($MyRegisteredUsersAccountInfo); $i++){
				$accountIDArray					=	array($MyRegisteredUsersAccountInfo[$i]['AccountID']);
				$creditsINFO					=	getInfoFrom('user_details', 'registeredUsersAccountInfo', $accountIDArray);
				$MyRegisteredUsersAccountInfo[$i]['Credits']	=	$creditsINFO[0]['CreditAmount'];	
			}
		}
}

	if(count($MyRegisteredUsersAccountInfo) > 0) {
	
		//Return result to jTable
		$jTableResult = array();
		$jTableResult['total'] 		= $total_pages;
		$jTableResult['page'] 		= $page;
		$jTableResult['records']	= $recordCount;
		$jTableResult['rows'] 	 	= $MyRegisteredUsersAccountInfo;
		$OutputJson					= json_encode($jTableResult);
		echo $OutputJson;
	}
}
?>