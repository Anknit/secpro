<?php
/*
 * Author: Ankit
 * Date: 11-Aug-2014
 * Description: Home page to all users. 
 * 
 */
 
/*
$queryString 		= $tempQuery;
$cleanQuery			= Random_decode($queryString);
*/

function fill_user_profile_data_columns($ActiveUserProfileInfo){
	global $CustomHtml;
	global $Elements_DisplayBlock;
	global $Elements_DisplayTable;
	
	$CustomHtml['.GlobalInfoSection div']	=   'Welcome '.$ActiveUserProfileInfo['name'].' ';
	$Elements_DisplayTable[]			=	'.GlobalInfoSection';
	$CustomHtml['#profileName']			=	$ActiveUserProfileInfo['name'];
	$CustomHtml['#profileOrg']			=	$ActiveUserProfileInfo['organization'];
	
	if($ActiveUserProfileInfo['website'] != "" || $ActiveUserProfileInfo['website'] != NULL)
		$CustomHtml['#profileWeb']			=	$ActiveUserProfileInfo['website'];
	else 
		$CustomHtml['#profileWeb'] = "-";
	
	$emptyaddress = true;
	$CustomHtml['#profileAdd']	=	'';
	if($ActiveUserProfileInfo['address'] != "" || $ActiveUserProfileInfo['address'] != NULL){
		$CustomHtml['#profileAdd']			=	$ActiveUserProfileInfo['address'];
		$emptyaddress = false;
	}
	
	if($ActiveUserProfileInfo['city'] != "" || $ActiveUserProfileInfo['city'] != NULL){
		if(!$emptyaddress)	
			$CustomHtml['#profileAdd']	.=	', ';
		$CustomHtml['#profileAdd']	.=	$ActiveUserProfileInfo['city'];
		$emptyaddress = false;
	}
	
	if($ActiveUserProfileInfo['country'] != "" || $ActiveUserProfileInfo['country'] != NULL){
		if(!$emptyaddress)	
			$CustomHtml['#profileAdd']	.=	', ';
		$CustomHtml['#profileAdd']	.=	$ActiveUserProfileInfo['country'];
		$emptyaddress = false;
	}
	
	if($ActiveUserProfileInfo['pincode'] != "" || $ActiveUserProfileInfo['pincode'] != NULL){
		if(!$emptyaddress)	
			$CustomHtml['#profileAdd']	.=	', ';
		$CustomHtml['#profileAdd']	.=	$ActiveUserProfileInfo['pincode'];
		$emptyaddress = false;
	}
	
	if($emptyaddress)
		$CustomHtml['#profileAdd']	.= "-";
	
	if($ActiveUserProfileInfo['mailId'] != "" || $ActiveUserProfileInfo['mailId'] != NULL)
		$CustomHtml['#profileEmail']	=	$ActiveUserProfileInfo['mailId'];
	
	else
		$CustomHtml['#profileEmail'] = "-";
	
	if($ActiveUserProfileInfo['phonePersonal'] != "" || $ActiveUserProfileInfo['phonePersonal'] != NULL)
		$CustomHtml['#profilePersP']			=	$ActiveUserProfileInfo['phonePersonal'];
	
	else
		$CustomHtml['#profilePersP'] = "-";
	
	if($ActiveUserProfileInfo['phoneOffice'] != "" || $ActiveUserProfileInfo['phoneOffice'] != NULL)
		$CustomHtml['#profileOffP']			=	$ActiveUserProfileInfo['phoneOffice'];
	
	else
		$CustomHtml['#profileOffP'] = "-";
	
	$CustomHtml['#profileRegTime']		=	$ActiveUserProfileInfo['registeredOn'];
	
	
	$CustomHtml['#profileRegAuth']		=	$ActiveUserProfileInfo['regAuthorityName'];
	$usrtype							=	$ActiveUserProfileInfo['userType'];
	switch ($usrtype){
		case 0:{
			$usrtype = "SuperUser";
			break;
		}
		case 1:{
			$usrtype = "Admin";
			break;
		}
		case 2:{
			$usrtype = "Operator";
			break;
		}
		case 3:{
			$usrtype = "Sales";
			break;
		}
		default:{
			break;
		}
	}
	$CustomHtml['.GlobalInfoSection div']	.=	'('.$usrtype.') | <a class="LogoutLink" title="Check your Profile info" href="#" onclick ="showProfileDiv();">My Profile</a> | <a class="LogoutLink" href="'.$_SESSION['HTTP_ROOT'].'NOVA/UserInterface/Logout.php">Logout</a>'; // $_SESSION['HTTP_ROOT'] must include forward slash "/" at the end of the string.
}

if($_SESSION['userTYPE'] == SUPERUSER ){
	if(count($systemDetailsCount) > 0) {
		$CustomData['#smtpHostName']	=	$systemDetails['smtpHostName'];
		$CustomData['#SmtpPortNumber']	=	$systemDetails['smtpPort'];
		$CustomData['#SmtpSenderName']	=	$systemDetails['sender'];
		$CustomData['#smtpUserName']	=	$systemDetails['smtpUsername'];
	}
}

$ActiveUserProfileInfo					=	getInfoFrom('retreive_data', 'profile', $_SESSION['userID']);

fill_user_profile_data_columns($ActiveUserProfileInfo);

if($_SESSION['userTYPE'] == ADMIN){
	$mailFreqVal	=	DB_Query('Select `interval` from reportsettings where accountId = '.$_SESSION['accountID']);		
	$timeZoneObj	=	DB_Query('Select accountinfo.timezoneId, timezoneinfo.zoneOffset, timezoneinfo.DSTapply, timezoneinfo.DSTvalue, timezoneinfo.DSTstart, timezoneinfo.DSTend from accountinfo LEFT JOIN timezoneinfo ON accountinfo.timezoneId = timezoneinfo.timezoneId where accountId = '.$_SESSION['accountID']);
	
	$ActiveUserAccountInfo	=	getInfoFrom('retreive_data', 'registeredUsersAccountInfo', array($_SESSION['accountID']));
	$CustomHtml['.GlobalInfoSection div']	.=	'<br />Remaining Credit Minutes: '.$ActiveUserAccountInfo[0]['creditMinutes'].', Valid upto: '.date('M d Y', $ActiveUserAccountInfo[0]['accountValidity']).' UTC';
}

?>
<script>
<?php if($_SESSION['userTYPE'] == SALES || $_SESSION['userTYPE'] == SUPERUSER) {?>
var CustomerName				=	JSON.parse('<?php $data = 'customer';		require './fetchData.php'; $data= ''; ?>');
<?php }

if($_SESSION['userTYPE'] == ADMIN || $_SESSION['userTYPE'] == SUPERUSER) {?>
	var NodeTableData				=	JSON.parse('<?php $data = 'node';		require './fetchData.php'; $data= ''; ?>');
	var ChannelTableData			=	JSON.parse('<?php $data = 'channel';	require './fetchData.php'; $data= ''; ?>');
	var BouquetTableData			=	JSON.parse('<?php $data = 'bouquet';	require './fetchData.php'; $data= ''; ?>');
	var AgentTableData				=	JSON.parse('<?php $data = 'agent';		require './fetchData.php'; $data= ''; ?>');
	var OperatorList				=	JSON.parse('<?php $data = 'operator';	require './fetchData.php'; $data= ''; ?>');
	var TemplateList				=	JSON.parse('<?php $data = 'template';	require './fetchData.php'; $data= ''; ?>');
//	var OperatorSetting				=	JSON.parse('<?php $data = 'opsetting';	require './fetchData.php'; $data= ''; ?>');
	var TimezoneTableData			=	JSON.parse('<?php $data = 'TimezoneTableData';	require './fetchData.php'; $data= ''; ?>');
	var autoReportFreq				= 	'<?php if($mailFreqVal != '') echo $mailFreqVal[0]['interval'];?>';
	<?php if($_SESSION['userTYPE'] == ADMIN) {?>
	var timezoneSettingsObj			= 	JSON.parse('<?php if($timeZoneObj != '') echo json_encode($timeZoneObj[0]);?>');
	// Range of Error alert settings constants initialized in definitions.php
	var ErrorAlertFrequencyRange = JSON.parse('<?php echo json_encode($ErrorAlertFrequencyRange);?>');
	var ErrorAlertThresholdRange = JSON.parse('<?php echo json_encode($ErrorAlertThresholdRange);?>');
	var ErrorAlertSetting			=	JSON.parse('<?php $data = 'alertsettings';	require './fetchData.php'; $data= ''; ?>');
	<?php }
 }
elseif($_SESSION['userTYPE'] == OPERATOR) { ?>
	var assignedChannelIdList		=	JSON.parse('<?php $data = 'assignedChannels';	require './fetchData.php'; $data= ''; ?>');
	var OperatorSetting				=	JSON.parse('<?php $data = 'opsetting';			require './fetchData.php'; $data= ''; ?>');
	var channelProfilesObj			=	JSON.parse('<?php $data = 'channelProfiles';	require './fetchData.php'; $data= ''; ?>');
<?php }
?>
	var regUserType					=	'<?php echo $_SESSION['userTYPE']; ?>';
	var userID 						= 	'<?php echo $_SESSION['userID']; ?>';
	var username 					= 	'<?php echo $_SESSION['Username'];?>';
	var GRID_UNIQUE_ID;
</script>
<?php 
	if($_SESSION['userTYPE'] == OPERATOR){
		?>
<div class="operatorHeaderContainer">
	<a class="NovaTagline" href="./UserPage.php"><img src="../images/Nova_2_40px.png" class="NovaLogo" alt="NOVA"/></a>
<?php 	}
?>
<div id="menuBar" class="JqxMenus" style="width: 99%;">
	<ul>
		<?php
			foreach($UIMENU_List as $key=>$value) {
                echo '<li title = "'.$value['title'].'" class="menuItems c_p" value='.$value['name'].' assocDiv='.$value['assocDiv'].'>'.$value['name'];
				$sublistitem	=	$value['SubMenuItems'];
				if(count($sublistitem) > 0) {	//If submenu names array has some elements
					echo '<ul>';
					foreach($sublistitem as $key=>$value){
						$submenu = $sublistitem[$key];
						/*data is obtained just need to put the data code is incomplete */
						echo '<li style="font-family: Arial" value='.$submenu['name'].' title="'.$submenu['title'].'" assocDiv='.$submenu['assocDiv'].'>'.$submenu['name'].'</li>';
					}
					echo '</ul>';
				}
                echo '</li>';
            }	
		?>
	</ul>
</div>
<?php 
	if($_SESSION['userTYPE'] == OPERATOR){
		?>
		</div>
<?php 	}
?>
		<div id='contentPANE' style="height:95%; max-height:94% ;overflow-y:auto;overflow-x:hidden">
	<?php    
        foreach($UIMENU_List as $key=>$value) {
            require_once $value['PageName'];
        }
        foreach($UIMENU_List as $key=>$value) {
            $sublistitem	=	$value['SubMenuItems'];
            foreach($sublistitem as $key=>$value)
            	require_once $sublistitem[$key]['PageName'];
        }
        require_once 'userPageProfile.php';
    ?>
</div>

<link rel="stylesheet" href="../../Common/css/jqueryUI/themes/jquery-ui.css">
<link rel="stylesheet" href="../../Common/css/ui.jqgrid.css" />
<script type="text/javascript" src="../../Common/js/grid.locale-en.js"></script>
<script type="text/javascript" src="../../Common/js/GridRelated.js"></script>
<script type="text/javascript" src="../../Common/js/jquery.jqGrid.min.js"></script>
<script type="text/javascript" src="../../Common/js/jqueryUI/jquery-ui.custom.js"></script>
<script type="text/javascript" src="../js/createjqgrid.js"></script>
<script type="text/javascript" src="../../Common/js/jqx/jqxwindow.js"></script>
<link rel="stylesheet" href="../../Common/css/jqx/jqx.base.css" />
<link rel="stylesheet" href="../../Common/css/jqx/jqx.arctic.css" />
<link rel="stylesheet" href="../../NOVA/css/NovaCommon.css" type="text/css" />
<link rel="stylesheet" href="../css/UserPage.css" type="text/css" />
<script type="text/javascript" src="../../Common/js/jqx/jqxmenu.js"></script>
<script type="text/javascript" src="../../Common/js/jqx/jqxscrollbar.js"></script>
<script type="text/javascript" src="../../Common/js/jqx/jqxbuttons.js"></script>
<script type="text/javascript" src="../../Common/js/jqx/jqxcheckbox.js"></script>
<script type="text/javascript" src="../../Common/js/jqx/jqxradiobutton.js"></script>
<script type="text/javascript" src="../../Common/js/jqx/jqxlistbox.js"></script>
<script type="text/javascript" src="../../Common/js/jqx/jqxtabs.js"></script>
<script type="text/javascript" src="../../Common/js/jqx/jqxdropdownlist.js"></script>
<script type="text/javascript" src="../../Common/js/jqx/jqxdatetimeinput.js"></script>
<script type="text/javascript" src="../../Common/js/jqx/jqxcalendar.js"></script>
<script type="text/javascript" src="../../Common/js/jqx/globalization/globalize.js"></script>
<script type="text/javascript" src="../../Common/js/jqx/jqxcore.js"></script>
<script type="text/javascript" src="../../Common/js/jqx/jqxsplitter.js"></script>
<script type="text/javascript" src="../../Common/js/jqx/jqxtooltip.js"></script>
<script type="text/javascript" src="../js/UserPage.js"></script>
