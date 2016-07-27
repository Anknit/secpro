<?php
/*
 * 	Author: Nitin Aloria
 * 	Date: 03-July-2015
 *	Description: This file is used for generating Node licences in xml format; saved as 'NovaLicenseFile.xml' and sending them in mail to their respective acoount managers.
 */
?>
<?php

if (isset ( $raciParam ['requestAction'] )) {
	
	function addLicenseInfo($nodeid) {
		
		$nodeExists = DB_Read ( array (
				'Table' => 'nodelicense',
				'Fields' => 'nodeId,licenseId',
				'clause' => 'nodeId = "' . $nodeid . '" ' 
		), 'ASSOC', '' );
		
		if (isset ( $nodeExists [0] ['nodeId'] )) {
			
			$latestUpdateInfo = DB_Update ( array (
					'Table' => 'nodelicense',
					'Fields' => array (
							'latestUpdate' => 'now()' 
					),
					'clause' => 'nodeId	= "' . $nodeid . '"' 
			) );
			$licenseid = $nodeExists [0] ['licenseId'];
			
		} else {
			
			$licenseid = DB_Insert ( array (
					'Table' => 'nodelicense',
					'Fields' => array ( 
							'nodeId' => $nodeid,
							'accountId' => $_SESSION ['accountID'],
							'createdOn' => 'now()',
							'expiresOn' => '',
							'licenseStatus' => 1,
							'latestUpdate' => 'now()' 
					) 
			) );
		}
		
		return $licenseid;
	}
	
	function getNodeName($nodeid) { // To get nodename using node ID
		
		$nodename = DB_Read ( array (
				'Table' => 'nodeinfo',
				'Fields' => 'nodeName',
				'clause' => 'nodeId = "' . $nodeid . '" ' 
		), 'ASSOC', '' );
		
		return $nodename [0] ['nodeName'];
	}
	
	function getCmsInfo(){
		
		$xml = simplexml_load_file(NOVA."ControllerNotification/nova.wsdl");
		return $xml->service->port->children('http://schemas.xmlsoap.org/wsdl/soap/')->attributes()->location;
	}
	
	function generateLicenseKey($nodeid) { // To generate license key xml file using node ID
		
		$cmsInfo 	= getCmsInfo();
		$cmsInfo	=	explode(':', $cmsInfo);

		$xmlDom = new DOMDocument ( '1.0', 'UTF-8' );
		
		$licenseRoot = $xmlDom->createElement ( 'NOVA' );
		$licenseRoot = $xmlDom->appendChild ( $licenseRoot );
		
		$agentLicenseNode = $xmlDom->createElement ( 'AgentLicenseInfo' );
		$agentLicenseNode = $licenseRoot->appendChild ( $agentLicenseNode );
		$agentLicenseNode->setAttribute ( "version", '1.0' );
		
		$accountNode = $xmlDom->createElement ( 'AccountId', $_SESSION ['accountID'] );
		$accountNode = $agentLicenseNode->appendChild ( $accountNode );
		
		$nodeID = $xmlDom->createElement ( 'NodeId', $nodeid );
		$nodeID = $agentLicenseNode->appendChild ( $nodeID );
		
		$cmsNode = $xmlDom->createElement ( 'CMSIP', $cmsInfo[0].':'.$cmsInfo[1] );
		$cmsNode = $agentLicenseNode->appendChild ( $cmsNode );
		
		$cmsPortNode = $xmlDom->createElement ( 'CMSPort', $cmsInfo[2] );
		$cmsPortNode = $agentLicenseNode->appendChild ( $cmsPortNode );
		
		$cleanXml = $xmlDom->saveXML ();
		$dirtyXml = base64_encode ( $cleanXml );
		
		return $dirtyXml;
	}
	
	function getEmailID($accountid) { // To get email ID using account ID
		
		$emailid = DB_Read ( array (
				'Table' => 'userinfo',
				'Fields' => 'mailId',
				'clause' => 'accountId = "' . $accountid . '" AND userType = "'.ADMIN.'"'
		), 'ASSOC', '' );
		
		return $emailid [0] ['mailId'];
	}
	
	$nodeId = $raciParam ['nodeId'];
	$licenseId = addLicenseInfo ( $nodeId );
	$nodeName = getNodeName ( $nodeId );
	$licenseKeyString = generateLicenseKey ( $nodeId );
	$targetFilePath = $_SESSION ['SETUP_ROOT'] . 'temp/';
	$file = $targetFilePath .'NovaLicenseFile.nlf'; // Creating License file
	$putresult = file_put_contents ( $file, $licenseKeyString );
	
	$getSubjectArguments = array (
			'case' => 'mailForNodeLicenseKey',
			'args' => $nodeName 
	);
	$mailSubject = getMailSubject ( $getSubjectArguments );
	
	$getMailBodyArguments = array (
			'case' => 'mailForNodeLicenseKey',
			'args' => array('nodeName' => $nodeName)
	);
	
	$mailBodyHtml = getMailBody ( $getMailBodyArguments );
	$accountID = $_SESSION ['accountID'];
	$emailID = getEmailID ( $accountID );
	$Output = send_Email ( $emailID, $mailSubject, $mailBodyHtml, '', $file );
	$fileResult = unlink ( $file ); // Deleting License file from filesystem
	if(!is_bool($Output) && $Output != ''){
		SetErrorCodes($Output, __LINE__,  __FILE__);
	}else if(!$Output){
		ErrorLogging('Mail_sent_failed near line number '.__LINE__.' in '.__FILE__);
	}
	if ($Output) {
		$Output = '&STATUS=SUCCESS&MESSAGE=Mail_sent_successfully';
	} else {
		$Output = '&STATUS=FAILURE&MESSAGE=Mail_sent_failed';
	}
}
?>