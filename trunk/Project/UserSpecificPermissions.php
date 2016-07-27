<?php
/*
* Author: Ankit
* date: 14-Jan-2015
* Description: This defines Permissions specific to a user
*
*/

// Create user specific permissions for various modules
$Module['NodeManagement']		=	false;
$Module['TemplateManagement']	=	false;
$Module['ChannelManagement']	=	false;
$Module['ProfileManagement']	=	false;
$Module['BouquetManagement']	=	false;
$Module['AgentManagement']		=	false;
$Module['ReportManagement']		=	false;
$Module['UserManagement']		=	false;
$Module['PaymentManagement']	=	false;
$Module['Reports']				=	false;
$Module['Monitor']				=	false;
$Module['Dashboard']			=	false;
$Module['LayoutManagement']		=	false;

if(isset($_SESSION['userTYPE'])) {
	if(in_array($_SESSION['userTYPE'], $UI_Allowed_To_Admin)){
		$Module['NodeManagement']		=	true;
		$Module['TemplateManagement']	=	true;
		$Module['ChannelManagement']	=	true;
		$Module['ProfileManagement']	=	true;
		$Module['BouquetManagement']	=	true;
		$Module['AgentManagement']		=	true;
		$Module['UserManagement']		=	true;
		$Module['ReportManagement']		=	true;
		$Module['Reports']				=	true;
	}
	if(in_array($_SESSION['userTYPE'], $UI_Allowed_To_Operator)){
		$Module['Monitor']				=	true;
		$Module['Dashboard']			=	true;
		$Module['LayoutManagement']		=	true;
	}
	if(in_array($_SESSION['userTYPE'], $UI_Allowed_To_Sales)){
		$Module['PaymentManagement']	=	true;
		$Module['UserManagement']		=	true;
	}
}	

$SubMenu['Sources']			=	array();
$SubMenu['Groups']			=	array();
$SubMenu['Nodes']			=	array();
//$SubMenu['Templates']		=	array();
$SubMenu['Agents']			=	array();
$SubMenu['Users']			=	array();
$SubMenu['Reports']			=	array();
$SubMenu['Monitor']			=	array();
$SubMenu['Dashboard']		=	array();
$SubMenu['Layouts']			=	array();
$SubMenu['Settings']		=	array();
$SubMenu['Customers']		=	array();
$SubMenu['Payments']		=	array();

// Create the array of UIMENU list. Only the tabs which will exist in uimenu_list array will be generated
$SubMenu['Settings']['Mail Settings']		=	array('PermissionSet' => $UI_Allowed_To_SuperUser,	'title' => TITLE17, 'assocDiv'	=>	'MailSettings', 			'name' => 'Mail Settings',			'PageName'	=> 'mailSettings.php');
$SubMenu['Settings']['Monitoring Settings']	=	array('PermissionSet' => $UI_Allowed_To_AccMgr,		'title' => TITLE13, 'assocDiv'	=>	'HomePageTemplates', 		'name' => 'Monitoring Settings',	'PageName'	=> 'userPageTemplates.php');
$SubMenu['Settings']['Automated Reports']	=	array('PermissionSet' => $UI_Allowed_To_AccMgr,		'title' => TITLE18, 'assocDiv'	=>	'HomePageAutoReport', 		'name' => 'Automated Report',		'PageName'	=> 'userPageReportSettings.php');
$SubMenu['Settings']['Alert Settings']		=	array('PermissionSet' => $UI_Allowed_To_AccMgr,		'title' => TITLE44, 'assocDiv'	=>	'HomePageAlertSettings', 	'name' => 'Alert Settings',			'PageName'	=> 'userPageAlertSettings.php');
// $SubMenu['Settings']['Layout Settings']		=	array('PermissionSet' => $UI_Allowed_To_AccMgr,		'title' => TITLE37, 'assocDiv'	=>	'HomePageLayoutSetting', 	'name' => 'Layout Settings',		'PageName'	=> 'userPageLayoutSettings.php');
$SubMenu['Settings']['Timezone Settings']	=	array('PermissionSet' => $UI_Allowed_To_AccMgr,		'title' => TITLE40, 'assocDiv'	=>	'HomePageTimezoneSetting', 	'name' => 'Timezone Settings',		'PageName'	=> 'userPageTimezoneSettings.php');
$SubMenu['Reports']['Account Payment']		=	array('PermissionSet' => $UI_Allowed_To_AccMgr,		'title' => TITLE41, 'assocDiv'	=>	'HomePageReports', 			'name' => 'Payment History',		'PageName'	=> 'userPageReports.php');
$SubMenu['Reports']['Usage Info']			=	array('PermissionSet' => $UI_Allowed_To_AccMgr,		'title' => TITLE42, 'assocDiv'	=>	'HomePageUsageInfo', 		'name' => 'Usage Information',		'PageName'	=> 'userPageUsageInfo.php');
$SubMenu['Reports']['Login Details']		=	array('PermissionSet' => $UI_Allowed_To_AccMgr,		'title' => TITLE43, 'assocDiv'	=>	'HomePageLoginDetails', 	'name' => 'Login Details',			'PageName'	=> 'userPageLoginDetails.php');
foreach($SubMenu as $key=>$value) {
	$subMenuItem	=	$key;
	foreach($SubMenu[$subMenuItem] as $key=>$value) {
		if(isset($_SESSION['userTYPE'])) {
			if(!in_array($_SESSION['userTYPE'], $value['PermissionSet']))
				unset($SubMenu[$subMenuItem][$key]);
		}
	}
}

// Create the array of UIMENU list. Only the tabs which will exist in uimenu_list array will be generated
$UIMENU_List['Customers']	=	array('name' => 'Customers',	'PageName' => 'userPageCustomers.php',	'PermissionSet' => $UI_FOR_CUSTOMER_MGMT,	'SubMenuItems' => $SubMenu['Customers'],	'title' => TITLE39,		'assocDiv'	=>	'HomePageCustomers');
$UIMENU_List['Users']		=	array('name' => 'Users',		'PageName' => 'userPageUsers.php', 		'PermissionSet' => $UI_Allowed_To_AccMgr,	'SubMenuItems' => $SubMenu['Users'],		'title' => TITLE7,		'assocDiv'	=>	'HomePageUsers');
$UIMENU_List['Nodes']		=	array('name' => 'Nodes',		'PageName' => 'userPageNodes.php', 		'PermissionSet' => $UI_Allowed_To_Admin,	'SubMenuItems' => $SubMenu['Nodes'],		'title' => TITLE8,		'assocDiv'	=>	'HomePageNodes');
$UIMENU_List['Sources']		=	array('name' => 'Sources',		'PageName' => 'userPageChannels.php', 	'PermissionSet' => $UI_Allowed_To_AccMgr,	'SubMenuItems' => $SubMenu['Sources'],		'title' => TITLE9,		'assocDiv'	=>	'HomePageChannels');
$UIMENU_List['Groups']		=	array('name' => 'Groups',		'PageName' => 'userPageBouquets.php', 	'PermissionSet' => $UI_Allowed_To_AccMgr,	'SubMenuItems' => $SubMenu['Groups'],		'title' => TITLE10,		'assocDiv'	=>	'HomePageBouquets');
$UIMENU_List['Agents']		=	array('name' => 'Agents',		'PageName' => 'userPageAgents.php', 		'PermissionSet' => $UI_Allowed_To_Admin,	'SubMenuItems' => $SubMenu['Agents'],		'title' => TITLE12,		'assocDiv'	=>	'HomePageAgents');
//$UIMENU_List['Templates']	=	array('name' => 'Templates',		'PageName' => 'userPageTemplates.php',	'PermissionSet' => $UI_Allowed_To_Admin,	'SubMenuItems' => $SubMenu['Templates'],	'title' => TITLE13,		'assocDiv'	=>	'HomePageTemplates');
$UIMENU_List['Reports']		=	array('name' => 'Reports',		'PageName' => 'userPageReports.php', 		'PermissionSet' => $UI_Allowed_To_Admin,	'SubMenuItems' => $SubMenu['Reports'],		'title' => TITLE14,		'assocDiv'	=>	'HomePageReports');
$UIMENU_List['Monitor']		=	array('name' => 'Monitor',		'PageName' => 'userPageMonitor.php',  	'PermissionSet' => $UI_Allowed_To_Operator,	'SubMenuItems' => $SubMenu['Monitor'],		'title' => TITLE15,		'assocDiv'	=>	'HomePageMonitor');
$UIMENU_List['Dashboard']	=	array('name' => 'Reports',		'PageName' => 'userPageDashboard.php',  	'PermissionSet' => $UI_Allowed_To_Operator, 'SubMenuItems' => $SubMenu['Dashboard'],	'title' => TITLE16,		'assocDiv'	=>	'HomePageDashboard');
$UIMENU_List['Layouts']		=	array('name' => 'Layouts',		'PageName' => 'userPageLayoutSettings.php',  	'PermissionSet' => $UI_Allowed_To_Operator, 'SubMenuItems' => $SubMenu['Layouts'],		'title' => TITLE37,		'assocDiv'	=>	'HomePageLayoutSetting');
$UIMENU_List['Settings']	=	array('name' => 'Settings',		'PageName' => 'userPageSettings.php',  	'PermissionSet' => $UI_Allowed_To_Admin,	'SubMenuItems' => $SubMenu['Settings'],		'title' => TITLE19,		'assocDiv'	=>	'HomePageTemplates');
$UIMENU_List['Payments']	=	array('name' => 'Payments',		'PageName' => 'userPagePayment.php',  	'PermissionSet' => $UI_Allowed_To_Sales,	'SubMenuItems' => $SubMenu['Payments'],		'title' => TITLE38,		'assocDiv'	=>	'HomePagePayments');

//$UIMENU_List['Profile']	=	array('name' => 'Profile',		'PageName' => 'userPageProfile.php',		'PermissionSet' => $UIMenu_ProfileTabToUsers,	'SubMenuItems' => $SubMenu['Profile']);

foreach($UIMENU_List as $key=>$value) {
	if(isset($_SESSION['userTYPE'])) {
		if(!in_array($_SESSION['userTYPE'], $value['PermissionSet']))
			unset($UIMENU_List[$key]);
	}	
}
?>