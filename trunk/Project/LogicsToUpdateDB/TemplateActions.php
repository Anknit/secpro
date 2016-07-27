<?php
error_reporting(0);
global $Module;
require_once __DIR__.'./../require.php';
require_once Common.'php/MailMgr.php';
	
// This function deletes coressponding template data from database
function deleteTemplateData($tempId){
	$deleteTemplateObj	=	DB_Query('DELETE templateinfo, errorseverityinfo FROM templateinfo LEFT JOIN errorseverityinfo ON templateinfo.templateId = errorseverityinfo.templateId WHERE templateinfo.templateId = "'.$tempId.'"','ASSOC','');
	return $deleteTemplateObj;
}

if($Module['TemplateManagement'])	//If subscription update is set to true for the logged in user
{
	if(isset($_SESSION) && $_SESSION['userID'] != "" && ($_SESSION['userTYPE'] == ADMIN || $_SESSION['userTYPE'] == SUPERUSER))
	{
		if($cat == 'add'){
						
			$createTemplateInput 	= array(
				'Table'=> 'templateinfo',					
				'Fields'=> array (							
					'templateName'      	=>$name,
					'templateDescription'   =>$desc,
					'accountId'				=>$_SESSION['accountID'],
				)
			);
			$resultSaveTemplate = DB_Insert($createTemplateInput);

			$xmlDom = new DOMDocument('1.0', 'UTF-8');
		    
		    $templateRoot = $xmlDom->createElement('NovaTemplate');
		    $templateRoot = $xmlDom->appendChild($templateRoot);
		    $templateRoot->setAttribute('version',TemplateVersion);
		
		    $templateNode = $xmlDom->createElement('Template');
		    $templateNode = $templateRoot->appendChild($templateNode);
		    $templateNode->setAttribute("ID",$resultSaveTemplate);
		    $templateNode->setAttribute("NAME",$name);
		    
			$templateCheckObject	=	json_decode($templateCheckObject,TRUE);
			$xmlNodeName	=	'Rule';
			$xmlChildNodeName	=	'Param';
		    foreach($templateCheckObject as $key=>$value){
		    	if(!is_array($value)){
		    		$templateCheckNode	=	$xmlDom->createElement($xmlNodeName,$value);
		    		$templateCheckNode	= 	$templateNode->appendChild($templateCheckNode);
		    		$templateCheckNode->setAttribute("name", $key);
		       	}
		       	else{
		    		$templateCheckNode	=	$xmlDom->createElement($xmlNodeName);
		    		$templateCheckNode	= 	$templateNode->appendChild($templateCheckNode);
		    		$templateCheckNode->setAttribute("name", $key);
		    		foreach($value as $childkey=>$childvalue){
		    			if(!is_array($childvalue)){
				    		$CheckChildNode	=	$xmlDom->createElement($xmlChildNodeName,$childvalue);
				    		$CheckChildNode	= 	$templateCheckNode->appendChild($CheckChildNode);
				    		$CheckChildNode->setAttribute("name", $childkey);
		    			}
		    			else{
				    		$CheckChildNode	=	$xmlDom->createElement($xmlChildNodeName,count($childvalue));
				    		$CheckChildNode	= 	$templateCheckNode->appendChild($CheckChildNode);
				    		$CheckChildNode->setAttribute("name", $childkey);
				    		foreach ($childvalue as $subchildkey=>$subchildvalue){
				    			if(!is_array($subchildvalue)){
						    		$CheckSubChildNode	=	$xmlDom->createElement($xmlChildNodeName,$subchildvalue);
						    		$CheckSubChildNode	= 	$templateCheckNode->appendChild($CheckSubChildNode);
						    		$CheckSubChildNode->setAttribute("name", $subchildkey);
				    			}
				    			else{
						    		foreach ($subchildvalue as $entry=>$entryvalue){
							    		$CheckSubChildEntryNode	=	$xmlDom->createElement($xmlChildNodeName,$entryvalue);
							    		$CheckSubChildEntryNode	= 	$templateCheckNode->appendChild($CheckSubChildEntryNode);
							    		$CheckSubChildEntryNode->setAttribute("name", $entry);
    								}
				    			}
				    		}
						}
		    		}
		       	}
		    }
/*			foreach($templateCheckObject as $key=>$value){
		    	if(!is_array($value)){
		    		$templateCheckNode	=	$xmlDom->createElement($xmlNodeName,$value);
		    		$templateCheckNode	= 	$templateNode->appendChild($templateCheckNode);
		    		$templateCheckNode->setAttribute("name", $key);
		       	}
		       	else{
		    		$templateCheckNode	=	$xmlDom->createElement($xmlNodeName);
		    		$templateCheckNode	= 	$templateNode->appendChild($templateCheckNode);
		    		$templateCheckNode->setAttribute("name", $key);
		    		foreach($value as $childkey=>$childvalue){
		    			if(!is_array($childvalue)){
				    		$CheckChildNode	=	$xmlDom->createElement($xmlChildNodeName,$childvalue);
				    		$CheckChildNode	= 	$templateCheckNode->appendChild($CheckChildNode);
				    		$CheckChildNode->setAttribute("name", $childkey);
		    			}
		    			else{
				    		$CheckChildNode	=	$xmlDom->createElement($xmlChildNodeName);
				    		$CheckChildNode	= 	$templateCheckNode->appendChild($CheckChildNode);
				    		$CheckChildNode->setAttribute("name", $childkey);
				    		foreach ($childvalue as $subchildkey=>$subchildvalue){
				    			if(!is_array($subchildvalue)){
						    		$CheckSubChildNode	=	$xmlDom->createElement($xmlChildNodeName,$subchildvalue);
						    		$CheckSubChildNode	= 	$CheckChildNode->appendChild($CheckSubChildNode);
						    		$CheckSubChildNode->setAttribute("name", $subchildkey);
				    			}
				    			else{
						    		$CheckSubChildNode	=	$xmlDom->createElement($xmlChildNodeName);
						    		$CheckSubChildNode	= 	$CheckChildNode->appendChild($CheckSubChildNode);
						    		$CheckSubChildNode->setAttribute("name", $subchildkey);
						    		foreach ($subchildvalue as $entry=>$entryvalue){
							    		$CheckSubChildEntryNode	=	$xmlDom->createElement($xmlChildNodeName,$entryvalue);
							    		$CheckSubChildEntryNode	= 	$CheckSubChildNode->appendChild($CheckSubChildEntryNode);
							    		$CheckSubChildEntryNode->setAttribute("name", $entry);
    								}
				    			}
				    		}
						}
		    		}
		       	}
		    }
*/					    
		    $updateTemplateChecksData	=	DB_Update(array(
		    	'Table'=>'templateinfo',
		    	'Fields'=>array('File'=>$xmlDom->saveXML()),
		    	'clause'=>'templateId = '.$resultSaveTemplate	
		    ));
		    // Add entries to error severity info table for the respective template Id
		    $insertTemplateErrorSeverityInfoData	=	DB_Insert(array(
		    		'Table'=>'errorseverityinfo',
		    		'Fields'=>array('templateId' => $resultSaveTemplate)
		    ));
		    
		    
		    if($updateTemplateChecksData){
				$controllerResponse	=	NOVA_COMMUNICATION('notify',array('type'=>'add-template',id=>$resultSaveTemplate));
				if($controllerResponse !== 0 && $controllerResponse !== '0'){
					$Output	=	$controllerResponse;
					SetErrorCodes($controllerResponse, __LINE__,  __FILE__);
					$deleteTemplate = deleteTemplateData($resultSaveTemplate);
				}
		    }
		    else{
				$deleteTemplate = deleteTemplateData($resultSaveTemplate);
				$Output	=	1;
		    }
		}
		if($cat == 'delete'){
			$deleteTemplate = deleteTemplateData($templateId);
			if($deleteTemplate){
				$controllerResponse	=	NOVA_COMMUNICATION('notify',array('type'=>'delete-template',id=>$templateId));
				if($controllerResponse !== 0 && $controllerResponse !== '0'){
					$Output	=	$controllerResponse;
					SetErrorCodes($controllerResponse, __LINE__,  __FILE__);
				}
			}
		}
		if($cat == 'edit'){
			
			$xmlDom = new DOMDocument('1.0', 'UTF-8');
		    
		    $templateRoot = $xmlDom->createElement('NovaTemplate');
		    $templateRoot = $xmlDom->appendChild($templateRoot);
		    $templateRoot->setAttribute('version',TemplateVersion);
		
		    $templateNode = $xmlDom->createElement('Template');
		    $templateNode = $templateRoot->appendChild($templateNode);
		    $templateNode->setAttribute("ID",$tempId);
		    $templateNode->setAttribute("NAME",$name);
		    
			$templateCheckObject	=	json_decode($templateCheckObject,TRUE);
			$xmlNodeName	=	'Rule';
			$xmlChildNodeName	=	'Param';
		    foreach($templateCheckObject as $key=>$value){
		    	if(!is_array($value)){
		    		$templateCheckNode	=	$xmlDom->createElement($xmlNodeName,$value);
		    		$templateCheckNode	= 	$templateNode->appendChild($templateCheckNode);
		    		$templateCheckNode->setAttribute("name", $key);
		       	}
		       	else{
		    		$templateCheckNode	=	$xmlDom->createElement($xmlNodeName);
		    		$templateCheckNode	= 	$templateNode->appendChild($templateCheckNode);
		    		$templateCheckNode->setAttribute("name", $key);
		    		foreach($value as $childkey=>$childvalue){
		    			if(!is_array($childvalue)){
				    		$CheckChildNode	=	$xmlDom->createElement($xmlChildNodeName,$childvalue);
				    		$CheckChildNode	= 	$templateCheckNode->appendChild($CheckChildNode);
				    		$CheckChildNode->setAttribute("name", $childkey);
		    			}
		    			else{
				    		$CheckChildNode	=	$xmlDom->createElement($xmlChildNodeName,count($childvalue));
				    		$CheckChildNode	= 	$templateCheckNode->appendChild($CheckChildNode);
				    		$CheckChildNode->setAttribute("name", $childkey);
				    		foreach ($childvalue as $subchildkey=>$subchildvalue){
				    			if(!is_array($subchildvalue)){
						    		$CheckSubChildNode	=	$xmlDom->createElement($xmlChildNodeName,$subchildvalue);
						    		$CheckSubChildNode	= 	$templateCheckNode->appendChild($CheckSubChildNode);
						    		$CheckSubChildNode->setAttribute("name", $subchildkey);
				    			}
				    			else{
						    		foreach ($subchildvalue as $entry=>$entryvalue){
							    		$CheckSubChildEntryNode	=	$xmlDom->createElement($xmlChildNodeName,$entryvalue);
							    		$CheckSubChildEntryNode	= 	$templateCheckNode->appendChild($CheckSubChildEntryNode);
							    		$CheckSubChildEntryNode->setAttribute("name", $entry);
    								}
				    			}
				    		}
						}
		    		}
		       	}
		    }
		    
		    $updateTemplateChecksData	=	DB_Update(array(
		    	'Table'=>'templateinfo',
		    	'Fields'=>array('File'=>$xmlDom->saveXML(),
		    					'templateName'=>$name,
		    					'templateDescription'=>$desc,		
		    			),
		    	'clause'=>'templateId = '.$tempId	
		    ));
		    if($updateTemplateChecksData){
				$controllerResponse	=	NOVA_COMMUNICATION('notify',array('type'=>'modify-template',id=>$tempId));
				if($controllerResponse !== 0 && $controllerResponse !== '0'){
					$Output	=	$controllerResponse;
					SetErrorCodes($controllerResponse, __LINE__,  __FILE__);
				}
		    }
			
		}
	}
}
?>