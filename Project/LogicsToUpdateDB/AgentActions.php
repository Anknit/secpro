<?php 
error_reporting(0);
global $Module;
require_once __DIR__.'./../require.php';
require_once Common.'php/MailMgr.php';
	
if($Module['AgentManagement'])	//If subscription update is set to true for the logged in user
{
	if(isset($_SESSION) && $_SESSION['userID'] != "" )
	{
		if($cat == 'edit'){
			$data	=	json_decode($data,TRUE);
			$updateAgentTableQuery	=	"UPDATE agentinfo SET accountId=".$_SESSION['accountID'].", nodeId=(CASE ";
			foreach($data as $key => $value){
				$updateAgentTableQuery .= "WHEN agentId='".$key."' THEN ".$data[$key]." ";
			}
			$updateAgentTableQuery .= "ELSE nodeId END)";
			DB_Query($updateAgentTableQuery);	
		}
	}
}
?>