<?php 
error_reporting(0);
global $Module;
require_once __DIR__.'./../require.php';
require_once Common.'php/MailMgr.php';
	
if($Module['NodeManagement'])	//If subscription update is set to true for the logged in user
{
	if(isset($_SESSION) && $_SESSION['userID'] != "" )
	{
		$Output = 0;
		if($cat == 'add'){
			$addNodeAction	=	DB_Insert(
				array(	
				'Table' => 'nodeinfo',
				'Fields'=>	array(							//Mandatory
							'nodeName' =>$name,
							'nodeDescription' =>$desc,
							'accountId'	=>	$_SESSION['accountID']
							)
				)
			);
			
// 			$addLicenseAction = DB_Insert ( array (
// 					'Table' => 'nodelicense',
// 					'Fields' => array ( // Mandatory
// 							'nodeId' => $addNodeAction,
// 							'accountId' => $_SESSION ['accountID'],
// 							'createdOn' => 'now()',
// 							'expiresOn' => '',
// 							'licenseStatus' => 1,
// 							'latestUpdate' => 'now()'
// 					)
// 			) );
				
			if($addNodeAction){
				$controllerResponse	=	NOVA_COMMUNICATION('notify',array('type'=>'add-node','id'=>$addNodeAction));
			}
			if($controllerResponse !== 0 && $controllerResponse !== '0'){
				$Output	=	$controllerResponse;
				SetErrorCodes($controllerResponse, __LINE__,  __FILE__);
				$deleteNodeAction	=	DB_Delete(
					array(	
					'Table' => 'nodeinfo',
					'clause'=> 'nodeId = "'.$addNodeAction.'"'
					)
				);
// 				$deleteLicenseAction	=	DB_Delete(
// 						array(
// 								'Table' => 'nodelicense',
// 								'clause'=> 'licenseId = "'.$addLicenseAction.'"'
// 						)
// 				);
			}
		}
		if($cat == 'delete'){
			$readNodeAgents	=	DB_Read(
				array(
				'Table'	=>	'agentinfo',
				'Fields'=>	'agentId',
				'clause'=>	'nodeId	= "'.$nodeId.'"'
				),'NUM_ARR',''
			);
			$freeNodeAgents	=	DB_Update(
				array(
				'Table'	=>	'agentinfo',
				'Fields'=>	array('nodeId'	=> 0),
				'clause'=>	'nodeId	= "'.$nodeId.'"'
				)
			);
			$controllerResponse	=	NOVA_COMMUNICATION('notify',array('type'=>'delete-node','id'=>$nodeId));
			if($controllerResponse !== 0 && $controllerResponse !== '0'){
				$Output	=	$controllerResponse;
				SetErrorCodes($controllerResponse, __LINE__,  __FILE__);
				$reAssignNodeAgents	=	DB_Update(
					array(
					'Table'	=>	'agentinfo',
					'Fields'=>	array('nodeId'	=> $nodeId),
					'clause'=>	'nodeId	IN ("'.$readNodeAgents.'")'
					)
				);
			}
			else{
				$deleteNodeAction	=	DB_Delete(
					array(	
					'Table' => 'nodeinfo',
					'clause'=> 'nodeId = "'.$nodeId.'"'
					)
				);
				$deleteLicenseKey	=	DB_Delete(
						array(
								'Table' => 'nodelicense',
								'clause'=> 'nodeId = "'.$nodeId.'"'
						)
				);
			}
		}
		if($cat == 'edit'){
			$updateNodeInfo	= DB_Update(
				array(
					'Table'	=>	'nodeinfo',
					'Fields'=>	array(
									'nodeDescription'	=> $desc,
									'backupAgent'		=> $backAgent,
								),
					'clause'=>	'nodeId	= "'.$nodeId.'"'
				)
			);
			if($updateNodeInfo){
				$controllerResponse	=	NOVA_COMMUNICATION('notify',array('type'=>'modify-node',id=>$nodeId));
				if($controllerResponse !== 0 && $controllerResponse !== '0'){
					$Output	=	$controllerResponse;
					SetErrorCodes($controllerResponse, __LINE__,  __FILE__);
				}
			}
		}
	}
}
?>