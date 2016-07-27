<?php
error_reporting(0);
global $Module;
require_once __DIR__.'./../require.php';
require_once Common.'php/MailMgr.php';
	
if($Module['ChannelManagement'])	//If subscription update is set to true for the logged in user
{
	if(isset($_SESSION) && $_SESSION['userID'] != "" )
	{
		$Output = 0;
		if($cat == 'add'){
			
			$getChannelAdded	=	DB_Read(
			array(
					'Table'=> 'channelinfo',					
					'Fields'=> 'channelId',
					'clause'=> 'accountID = "'.$_SESSION['accountID'].'" AND channelStatus != '.REMOVED
			),'NUM_ROWS', '');
			
			if($getChannelAdded > AccountChannelLimit){
				$Output	=	101;
			}
			else{
				$sameChannelAdded	=	DB_Read(
				array(
						'Table'=> 'channelinfo',					
						'Fields'=> 'channelId',
						'clause'=> 'accountID = "'.$_SESSION['accountID'].'" AND nodeId = "'.$nodeId.'" AND (channelName = "'.$name.'" OR channelUrl = "'.$url.'") AND channelStatus != '.REMOVED
				),'NUM_ROWS', '');
				if($sameChannelAdded > 0){
					$Output	=	102;
				}
				else{
					$addChannelAction	=	DB_Insert(
						array(	
						'Table' => 'channelinfo',
						'Fields'=>	array(							//Mandatory
									'channelName' 	=>	$name,
									'nodeId' 		=>	$nodeId,
									'channelUrl'	=> 	$url,
									'templateId'	=> 	$temp,
									'timezoneId'	=> 	$channelTimezoneId,
									'accountId'		=>	$_SESSION['accountID'],
									'emailAlert'	=> 	ChannelEmailAlertDefault,
									'addTimeStamp'	=> 	time()
							)
						)
					);
					if($addChannelAction){
						$controllerResponse	=	NOVA_COMMUNICATION('notify',array('type'=>'add-channel','id'=>$addChannelAction));
					}
					if($controllerResponse !== 0 && $controllerResponse !== '0'){
						$Output	=	$controllerResponse;
						SetErrorCodes($controllerResponse, __LINE__,  __FILE__);
						$deleteChannelAction	=	DB_Delete(
							array(	
							'Table' => 'channelinfo',
							'clause'=> 'channelId = "'.$addChannelAction.'"'
							)
						);
					}
					// 					else{
					// 						$checkProfileStatus = DB_Read(array(
					// 								'Table'	=> 'profileinfo',
					// 								'Fields'=> 'profileId',
					// 								'clause'=> 'channelId="'.$addChannelAction
					// 						),'NUM_ROWS', '');
					// 						if($checkProfileStatus > 0){
						
					// 						}
				}
			}  			  
		}
		if($cat == 'delete'){
			$deleteChannelAction	=	DB_Update(
				array(	
				'Table' => 'channelinfo',
				'Fields'=>	array(
						'channelStatus'		=>	REMOVED,
						'deleteTimeStamp'	=>	time()
				),
				'clause'=> 'channelId = "'.$channelId.'"'
				)
			);
			if($deleteChannelAction){
				$deleteChannelProfiles	=	DB_Delete(
					array(
					'Table'	=>	'profileinfo',
					'clause'=>	'channelId	= "'.$channelId.'"'
					)
				);
				$deleteChannelBouquetMapping	=	DB_Delete(
					array(
					'Table'	=>	'channelbouquetmapping',
					'clause'=>	'channelId	= "'.$channelId.'"'
					)
				);
				$controllerResponse	=	NOVA_COMMUNICATION('notify',array('type'=>'delete-channel','id'=>$channelId));
				if($controllerResponse !== 0 && $controllerResponse !== '0'){
					$Output	=	$controllerResponse;
					SetErrorCodes($controllerResponse, __LINE__,  __FILE__);
				}
			}
		}
		if($cat == 'edit'){
			$updateChannelInfo	= DB_Update(
				array(
					'Table'	=>	'channelinfo',
					'Fields'=>	array(
									'channelStatus'	=> $status,
									'templateId'	=> $template,
								),
					'clause'=>	'channelId	= "'.$channelId.'"'
				)
			);
			if($updateChannelInfo && $notify == '1'){
				$eventidstr	=	'';
				$eventIdList	=	DB_Read(array('Table'=>'eventinfo','Fields'=>'eventId','clause'=>'channelId = '.$channelId.' AND eventStatus != ' .REMOVED),'ASSOC','');
				if($eventIdList != 0){
					foreach ($eventIdList as $rowEvent => $rowValue) {
						if($eventidstr	!= ''){
							$eventidstr	.= ',';
						}
						$eventidstr	.=	(string)$rowValue['eventId'];
					}
					$controllerResponse	=	NOVA_COMMUNICATION('notify',array('type'=>'modify-event','id'=>$eventidstr));
					if($controllerResponse !== 0 && $controllerResponse !== '0'){
						$Output	=	$controllerResponse;
						SetErrorCodes($controllerResponse, __LINE__,  __FILE__);
					}
				}
			}
			if($status	==	'2'){
				$chageProfilestatus	= DB_Update(
					array(
						'Table'	=>	'profileinfo',
						'Fields'=>	array(
										'profileStatus'	=> $status,
									),
						'clause'=>	'channelId	= "'.$channelId.'"'
					)
				);
			}
		}
		if($cat == 'update'){
			$controllerResponse	=	NOVA_COMMUNICATION('notify',array('type'=>'update-channel','id'=>$channelId));
			if($controllerResponse !== 0 && $controllerResponse !== '0'){
				$Output	=	$controllerResponse;
				SetErrorCodes($controllerResponse, __LINE__,  __FILE__);
			}
		}
		if($cat == 'schedule'){
			$scheduleData	=	json_decode($scheduleData, true);
			$fieldsArr	=	array('channelId'	=>	$scheduleData['channel'],'startTime' => $scheduleData['start'], 'endTime' => $scheduleData['end'], 'timeZone' => $scheduleData['timezone'],'repetition' => $scheduleData['repeat'], 'untill' => $scheduleData['untill'],'reminder' => $scheduleData['reminder'],'eventStatus' => $scheduleData['status']);
			if(isset($action) && $action == 'delete' && isset($eventid)){
				$subFieldsArr = array('eventStatus'	=>	REMOVED);
				$scheduleAction	=	DB_Update(array('Table'=>'eventinfo', 'Fields' => $subFieldsArr,'clause'=>'eventId = "'.$eventid.'"'));
// 				$scheduleAction	=	DB_Delete(array('Table'=>'eventinfo','clause'=>'eventId = "'.$eventid.'"'));
				$controllerResponse	=	NOVA_COMMUNICATION('notify',array('type'=>'delete-event','id'=>$eventid));
			}
			else{
				if(isset($scheduleData['eventId'])){
					$scheduleAction	=	DB_Update(array('Table' => 'eventinfo', 'Fields' => $fieldsArr, 'clause' => 'eventId = "'.$scheduleData['eventId'].'"'));
					$controllerResponse	=	NOVA_COMMUNICATION('notify',array('type'=>'modify-event','id'=>$scheduleData['eventId']));
				}
				else{
					$scheduleAction	=	DB_Insert(array('Table' => 'eventinfo', 'Fields' => $fieldsArr));
					$controllerResponse	=	NOVA_COMMUNICATION('notify',array('type'=>'add-event','id'=>$scheduleAction));
					if($controllerResponse != '0'){
						$deleteFailedAddEventEntry = DB_Delete(array('Table'=>'eventinfo', 'clause'=>'eventId = "'.$scheduleAction.'"'));
						$Output = 1;
					}
				}
			}
		}
		
		if($cat == 'checkEvent'){
			$channelEvents	=	DB_Read(
					array(
							'Table'=> 'eventinfo',
							'Fields'=> 'eventId',
							'clause'=> 'channelId = "'.$_GET['channelId'].'" AND eventStatus != '.REMOVED
					),'NUM_ROWS', '');
			
			if($channelEvents > 0)
				$Output = 1;
			else
				$Output = 0;
			
		}
		
		if($cat == 'emailAlert'){
			$channelEmailAlert	=	DB_Update(
					array(
							'Table'=> 'channelinfo',
							'Fields'=> array('emailAlert'=>$checkVal),
							'clause'=> 'channelId = "'.$_GET['channelId'].'"'
					));
				
			if($channelEmailAlert)
				$Output = 0;
			else
				$Output = 1;
				
		}
	}
}
?>