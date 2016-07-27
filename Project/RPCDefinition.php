<?php
include_once  "../Common/php/SessionManager.php"; 
include_once  "LicenseManager.php";
include_once "BusinessRuleManager.php";
/*
 * Author: Rajarshi
* date: 28-jul-2014
* Description: This module provides all RPC defintion which in turn calls module specific
* functions. These defintion helps caller app. as to what kind of paramters one should expect as part 
* of return. 
*
*All RPC function names are preceded by RPC_XXXX 
*
*/


/*===========================================================================================
 * Function Name:RPC_SessionInitialize
 * Paramters : 
 * PHPSESSIONID --  NULL as default 	
 *  USERID -- user mail ID should be provided as User ID
	PASSWORD-- md5 password. 
	SUID -- system unique ID 
	SERVICE_FAMILY -- SERVICE FAMILY say : "PULSAR" 
	CLIENT_TYPE -- 'BROWSER | OTHER_APPS'
	//SERVICE_ID  --  "PPU" | "SAS" | "PRO" ETC.. dont require this as portal should have this information
	
 * Return Value:  
 		 STATUS="SUCCESS" | "FAIL"
 		 SESSIONID- value of sesson ID if successful else 0 or NULL 
 		 MESSAGE --  error message in case of failure 
 * Description:
 * This function intializes the session whenever the user tries to intiiate a session from the Pulsar
 * PPU interface. It will create a session and return the session value to the client for subsewuent
 * communcation. 
 * The client needs to provide the paramters as part of this RPC call 
 * ALWAYS START WITH & TO AVOID /r /n INTRODUCTION BY HTTP CHANNEL
 =============================================================================================*/
function RPC_SessionInitialize(&$respParam)
{
	$status = SessionInitialize($respParam); 
	return $status; 
}


/*===========================================================================================
 * Function Name: RPC_GetLicenseInfo
* Paramters :
* PHPSESSIONID --  value of sessionID 
*  
* Return Value:
* STATUS='SUCCESS' | 'FAIL' 
  LICENSE_CODE=value of the license code
* Description:
* This function gets the license info applicable for the session which in turn is associated with 
* userID + ServiceId etc.. in the SessionInitialized function. 
*
=============================================================================================*/
function RPC_GetLicenseInfo(&$respParam)
{
	$retval = LM_GetLicenseInfo($respParam);
	return $retval;  
	
}

/*===========================================================================================
 * Function Name: RPC_ValidateUsage
* Paramters :
* PHPSESSIONID --  value of sessionID
* JOB_ID -- value of the job ID
* FILE_NAME -- name of the file intended for the job 
* CONTENT_DURATION -- duration of the content analysed in minutes 
* FEATURELIST[] -- array of features used for this job
* e.g.: '&FEATURELIST[]=' + 'BASE' + '&FEATURELIST[]=' + 'LOUDNESS_CORRECTION' + '&FEATURELIST[]=' + 'ULTRA_HD'
* Return Value:
* STATUS='SUCCESS' | 'FAIL'
* ERROR_MESSAGE = 'some error messages if status fails'
* Description:
* This function gets the license info applicable for the session which in turn is associated with
* userID + ServiceId etc.. in the SessionInitialized function.
*
=============================================================================================*/
function RPC_ValidateUsage(&$respParam)
{
	BRM_ValidateUsage($respParam); 
}


/*===========================================================================================
 * Function Name: RPC_ConfirmDebit
* Paramters :
* PHPSESSIONID --  value of sessionID
* JOB_ID -- value of the job ID* 
* Return Value:
* STATUS='SUCCESS' | 'FAIL'
* ERROR_MESSAGE = 'some error messages if status fails'
* Description:
* This function is called by the Client to confirm that the last JobId report has been
* filed. 
*
=============================================================================================*/
function RPC_ConfirmDebit(&$respParam)
{
	BRM_ConfirmDebit($respParam); 
}

function RPC_CloseSession($sessionID)
{	
	closeSession($sessionID); 
	return true; 
}

?>