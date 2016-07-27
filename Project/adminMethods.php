<?php
/*
* Author: Aditya
* date: 05-Nov-2014
* Description: This defines some common functions required only by admin
*
*/

function DB_Backup($backupFilePath = ''){
	
	if($backupFilePath == '') { 
		//$newlyCreatedFilename = date("Y-m-d_H-i-s").".sql";
		$newlyCreatedFilename = "NovaDbBackup.sql";
		$setupRoot		=	getSetupRoot();
		$sqlPathInfo	=	$setupRoot."/temp/";
		$backupFilePath	=	$sqlPathInfo.$newlyCreatedFilename;
	}
	require __DIR__.'./../Common/php/OperateDB/DbConfig.php';
	$query = "mysqldump -h ".$host." --port=".$port." --user=".$username." --password=".$password." --databases ".$database." > ".$backupFilePath;

	exec($query);
	if(file_exists($backupFilePath))
		return basename($backupFilePath);
	else
		return false;	
}

function getSetupRoot(){
	$setupRootDir	=	str_replace("NOVA","",__DIR__); 
	return $setupRootDir;
}

function deactivateAccount(){
	$output	=	0;
	$expiredAccountList		=	DB_Read(array(
		'Table'	=>	'accountinfo',
		'Fields'=>	'accountId',
		'clause'=> 'accountValidity <= "'.time().'" AND accountStatus = 1',
	));
	if(count($expiredAccountList) > 0){
		$expiredAccArr	=	array();
		for($eacc=0;$eacc<count($expiredAccountList);$eacc++){
			array_push($expiredAccArr,$expiredAccountList[$eacc]['accountId']);
		}
		$updateAccountStatus	=	DB_Update(array(
			'Table'	=> 'accountinfo',
			'Fields'=> array('accountStatus'	=>	2),
			'clause'=> 'accountValidity <= "'.time().'" AND accountStatus = 1',
		)); 
		if($updateAccountStatus)
			$output	=	$expiredAccArr;
	}
	return $output;
}
?>
