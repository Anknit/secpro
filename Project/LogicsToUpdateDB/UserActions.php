<?php
error_reporting(0);
global $Module;
require_once __DIR__.'./../require.php';
require_once Common.'php/MailMgr.php';
	
if($Module['UserManagement'])	//If subscription update is set to true for the logged in user
{
	if(isset($_SESSION) && $_SESSION['userID'] != "" && ($_SESSION['userTYPE'] == ADMIN || $_SESSION['userTYPE'] == SUPERUSER || $_SESSION['userTYPE'] == SALES))
	{
		if($cat == 'add'){
			$Output	=	'0';
			$name			= trim($mail);

			$userExist 	= array(
					'Table'=> 'userinfo',					
					'Fields'=> '*',
					'clause'=> 'userName = "'.$name.'"'
			  );
			$resultCheckUserExistence = DB_Read($userExist, 'NUM_ROWS', '');
			
			if($resultCheckUserExistence > 0){
				$Output	=	'1';
				return;
			}
			
			function CreateNewAccount(){
				global $currencyCode, $creditMinutes, $accountValidity, $timeZone;
				$createAccount =  DB_Insert(array(	//Just for demo
						'Table'=> 'accountinfo',					
						'Fields'=> array (							
								'creationDate'      =>'now()',
								'creditMinutes'		=>$creditMinutes,
								'accountStatus'		=>AC_UNVERIFIED,
								'accountValidity'	=>$accountValidity,
								'currencyCode'		=>$currencyCode,
								'timezoneId'			=>$timeZone,
				)
				));
				return $createAccount;
			}
			
	//		$User_Type		= $_GET['type'];
			$regAuthorityID = $_SESSION['userID'];
	
			$currencyCode	=	'USD';
			if(isset($_GET['currencyCode']))
				$currencyCode 	= $_GET['currencyCode'];
			$timeZone		=	DefaultTimezonId;
			if(isset($_GET['$timeZone']))
				$timeZone 	= $_GET['$timeZone'];
			$accountValidity	=	strtotime(defaultNOVADates(1));
			$creditMinutes	=	0;
			if(IfValid($_GET['DemoMinutes']) && $_GET['DemoMinutes']	==	1) {
				$creditMinutes	=	defaultMinutes;
				$accountValidity	=	strtotime(defaultNOVADates(2));
			}
				
			$regAuthorityName = $_SESSION['Username'];
			
			//1.1 Add entry in account table so as to get accountID
			if($_SESSION['userTYPE']== ADMIN){
				$AccountID	=	$_SESSION['accountID'];
				$newUserType	=	'2';
			}
			elseif($_SESSION['userTYPE']== SUPERUSER || $_SESSION['userTYPE']== SALES) {
				$AccountID	=	CreateNewAccount();
				$newUserType	=	'1';
				if(!$AccountID) {
					echo '2';
					return;
				}
				elseif($creditMinutes != 0) {
					//Placeholder section for recording transaction of demo minutes
				}
				
				// Add entry in emailalertsettings
				$createDefaultAlertSettings 	= DB_Insert(array(
						'Table'=> 'emailalertsettings',
						'Fields'=> array (
								'accountId'		=>$AccountID,
								'`interval`'      =>ErrorAlertFrequency,
								'errorLimit'	=>ErrorAlertThreshold,
						)
				));
			}
					
			//2 Add user entry in userinfo table
			$createUserInput 	= array(
				'Table'=> 'userinfo',					
				'Fields'=> array (							
					'userName'          =>$name,
					'mailID'            =>$name,
					'accountId'			=>$AccountID,
					'userType'          =>$newUserType,
					'userStatus'        =>'0',
					'registeredOn'		=>'now()',
					'regAuthorityId'    =>$regAuthorityID,
					'regAuthorityName'  =>$regAuthorityName
				)
			);
				
			$resultAddUser = DB_Insert($createUserInput);	//$resultAddUser contains the uid
			if($resultAddUser)
			{
				if($_SESSION['userTYPE']== SUPERUSER || $_SESSION['userTYPE']== SALES ) {
					$Insertlicenseinfo =  DB_Insert(array(
						'Table'=> 'licenseinfo',					
						'Fields'=> array (							
								'accountID'       =>$AccountID,
								'ServiceID'       =>'NOVA'
						 )
					));
				}
				else if($_SESSION['userTYPE']== ADMIN){
					$InsertoperatorSettinginfo =  DB_Insert(array(
						'Table'=> 'operatorsettings',					
						'Fields'=> array (							
								'accountId'     =>$_SESSION['accountID'],
								'userId'       	=>$resultAddUser,
								'monitorView'	=> DefaultMonitorLayout
						 )
					));
										
					$reportinterval	=	24;
					$DefinedInterval	=	DB_Query("Select Distinct `interval` from reportsettings where accountId = ".$_SESSION['accountID'],'ASSOC','');
					if(!empty($DefinedInterval)){
						$reportinterval	=	$DefinedInterval[0]['interval'];
					}
					$InsertreportSettinginfo =  DB_Insert(array(
						'Table'=> 'reportsettings',					
						'Fields'=> array (							
								'accountId'     =>$_SESSION['accountID'],
								'userId'       	=>$resultAddUser,
								'`interval`'	=>$reportinterval
						 )
					));
					if($InsertreportSettinginfo){
						$controllerResponse	=	NOVA_COMMUNICATION('notify',array('type'=>'add-reportSetting','id'=>$resultAddUser));
						if($controllerResponse !== 0 && $controllerResponse !== '0'){
							$Output	=	$resultAddUser.'||51';
							SetErrorCodes($controllerResponse, __LINE__,  __FILE__);
						}
					}
				}
				
				//3 send e-Mail to user for registration complete
				function GenerateQueryToVerifyUser($username, $uid)
				{
					$Expirydate		=	defaultNOVADates(2);
					$QueryString	=	"userID=".$uid."&email=".$username."&ExpireOn=".$Expirydate;
					return $QueryString;
				}
				$VerificationLinkQueryData	=	Random_encode(GenerateQueryToVerifyUser($name, $resultAddUser));
				$VerificationPageAddress	=	$_SESSION['HTTP_ROOT'].'NOVA/UserInterface/Registration.php?'.$VerificationLinkQueryData;
				$VerificationLink			=	"<a href = '".$VerificationPageAddress."'>Register</a>";
	
				$NewUserMailBody		=	getEmailBody('NewUser', array('NewUserType' => $newUserType, 'RegistrationLink' => $VerificationLink, 'RegistrationPageAddress' => $VerificationPageAddress));
				$NewUserMailSubject		=	getEmailSubject('NewUser', array('NewUserType' => $newUserType));
				
				$mailResult	=	send_Email($name, $NewUserMailSubject , $NewUserMailBody);
				if(!$mailResult){
					$Output = '2';
				}
			}
		}
		if($cat == 'delete'){
			if($userId == $_SESSION['userID']){
				return false;
			}
			$Output	=	'0';
			$checkBouquetAssign	=	DB_Read(
				array(
					'Table'=> 'bouquetinfo',					
					'Fields'=> '*',
					'clause'=> 'userId = "'.$userId.'"'
				), 'NUM_ROWS', ''
			);
			if($checkBouquetAssign > 0){
				$Output	=	'1';
				return;
			}
			else{
				if($_SESSION['userTYPE'] != ADMIN){
					$getAccountId	=	DB_Read(
						array(
							'Table' => 	'userinfo',
							'Fields'=>	'accountId',
							'clause'=>	'userId = "'.$userId.'"'
					),'ASSOC','');
					$account	=	$getAccountId[0]['accountId'];
					$getAccountChannels	=	DB_Read(
						array(
							'Table'		=>	'channelinfo',
							'Fields'	=>	'channelId',
							'clause'	=>	'accountId = "'.$account.'"'	
						),'ASSOC',''
					);
					$channels	=	array();
					if($getAccountChannels != 0){
						for($i=0;$i<count($getAccountChannels);$i++){
							array_push($channels,$getAccountChannels[$i]['channelId']);
						}
					}
					$deleteaccountInfo	=	DB_Query("Delete accountinfo, templateinfo, usageinfo, reportsettings, paymentinfo, operatorsettings, nodelicense,nodeinfo,licenseinfo, bouquetinfo, agentinfo, userinfo, emailalertsettings from accountinfo LEFT JOIN templateinfo On accountinfo.accountId = templateinfo.accountId LEFT JOIN usageinfo On accountinfo.accountId = usageinfo.accountId LEFT JOIN reportsettings On accountinfo.accountId = reportsettings.accountId LEFT JOIN paymentinfo On accountinfo.accountId = paymentinfo.accountId LEFT JOIN operatorsettings On accountinfo.accountId = operatorsettings.accountId LEFT JOIN nodelicense On accountinfo.accountId = nodelicense.accountId LEFT JOIN nodeinfo On accountinfo.accountId = nodeinfo.accountId LEFT JOIN licenseinfo On accountinfo.accountId = licenseinfo.accountId LEFT JOIN bouquetinfo On accountinfo.accountId = bouquetinfo.accountId LEFT JOIN agentinfo On accountinfo.accountId = agentinfo.accountId LEFT JOIN userinfo On accountinfo.accountId = userinfo.accountId LEFT JOIN emailalertsettings ON emailalertsettings.accountId = accountinfo.accountId where accountinfo.accountId = '".$account."'","ASSOC","");
					$deletechannelInfo	=	true;
					if(count($channels)>0){
						$channnelM	=	createCommaSeparatedListForMysqlIN($channels);
						$deletechannelInfo	=	DB_Query("Delete channelbouquetmapping, eventinfo, profileinfo, channelinfo from channelinfo LEFT JOIN channelbouquetmapping On channelinfo.channelId = channelbouquetmapping.channelId LEFT JOIN eventinfo On channelinfo.channelId = eventinfo.channelId LEFT JOIN profileinfo On channelinfo.channelId = profileinfo.channelId where channelinfo.channelId IN (".$channelM.")","ASSOC",""); 				
					}
					if($deleteaccountInfo==0 && $deletechannelInfo){
						$controllerResponse	=	NOVA_COMMUNICATION('notify',array('type'=>'delete-account','id'=>$account));
						if($controllerResponse !== 0 && $controllerResponse !== '0'){
							SetErrorCodes($controllerResponse, __LINE__,  __FILE__);
						}
					}
				}
				else{
					$deleteUser	=	DB_Delete(
						array(
						'Table'	=>	'userinfo',
						'clause'=>	'userId	= "'.$userId.'"'
						)
					);
					$deleteReportSetting	=	DB_Delete(
						array(
						'Table'	=>	'reportsettings',
						'clause'=>	'userId	= "'.$userId.'"'
						)
					);
					$deleteOperatorSetting	=	DB_Delete(
						array(
						'Table'	=>	'operatorsettings',
						'clause'=>	'userId	= "'.$userId.'"'
						)
					);
					if($deleteReportSetting && $deleteOperatorSetting){
						$controllerResponse	=	NOVA_COMMUNICATION('notify',array('type'=>'delete-reportSetting','id'=>$userId));
						if($controllerResponse !== 0 && $controllerResponse !== '0'){
							$Output	=	$userId.'||52';
							SetErrorCodes($controllerResponse, __LINE__,  __FILE__);
						}
					}
				}
				
			}
		}
		if($cat == 'status'){
			if(isset($accId) && in_array($_SESSION['userTYPE'],$UI_FOR_CUSTOMER_MGMT)){
				$accStatusUpdate	=	DB_Update(array(
					'Table'	=>	'accountinfo',
					'Fields'=>	array('accountStatus'	=> $state),
					'clause'=>	'accountId = "'.$accId.'"'
				));
				if($accStatusUpdate && $state == '2'){
					$controllerResponse	=	NOVA_COMMUNICATION('notify',array('type'=>'inactive-account','id'=>$accId));
					if($controllerResponse !== 0 && $controllerResponse !== '0'){
						SetErrorCodes($controllerResponse, __LINE__,  __FILE__);
						$Output	=	1;
					}
					$usersArr	=	array();
					$usersIDList	=	DB_Read(array(
						'Table'		=>	'userinfo',
						'Fields'	=>	'userId',
						'clause'	=>	'accountId = "'.$accId.'"'
					),'ASSOC','');
					for($l=0;$l<count($usersIDList);$l++){
						array_push($usersArr, $usersIDList[$l]['userId']);
					}
					$sessionIDList	=	DB_Read(array(
						'Table'	=>	'sessioninfo',
						'Fields'=>	'sessionId',
						'clause'=>	'userId IN ( '.createCommaSeparatedListForMysqlIN($usersArr).' )'	
					));

					// 1. commit session if it's started.
					if (session_id()) {
					    session_commit();
					}
					
					// 2. store current session id
					session_start();
					$current_session_id = session_id();
					session_commit();

					for($s=0;$s<count($sessionIDList);$s++){
						$session_id_to_destroy = $sessionIDList[$s]['sessionId'];
						// 3. hijack then destroy session specified.
						session_id($session_id_to_destroy);
						session_start();
						session_destroy();
						session_commit();
						
					}
					
					// 4. restore current session id. If don't restore it, your current session will refer to the session you just destroyed!
					session_id($current_session_id);
					session_start();
					session_commit();
				
				}
				else{
					$controllerResponse	=	NOVA_COMMUNICATION('notify',array('type'=>'active-account','id'=>$accId));
					if($controllerResponse !== 0 && $controllerResponse !== '0'){
						SetErrorCodes($controllerResponse, __LINE__,  __FILE__);
						$Output	=	1;
					}
				}
			} 
			else{
				$Output	=	1;
			}
		}
	}
}
?>