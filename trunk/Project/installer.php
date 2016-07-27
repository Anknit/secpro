<?php
/*
 * Author: Aditya
* date: 08-Aug-2014
* Description:
*/
global $error;
global $DocRootPath;
global $RemoteSystem;
global $ProjectSpecificCodePath;
global $databaseSourcePath;
global $newUserConfigFile;
global $CommonCodePath;
global $tempFolderPath;
global $indexFilePath;
global $sampleInterfacePath;

$error	=	'';
$DocRootPath	=	dirname(dirname(__FILE__));
$RemoteSystem	=	true;


if(isset($_POST['remote']) && $_POST['remote'] == 'localhost'){
//Before using the installer file set this to true or false accordingly
	if(isset($_POST["local_Password"]) && $_POST["local_Password"] != null)
		$RemoteSystem	=	false;
	else{
		$error ='Local system password not provided';
		continueOrNot();
	}
}

if(isset($_POST['Install_Code']) && $_POST['Install_Code'] == 'on') {
	if(isset($_POST['project']) && $_POST['project'] != ''){
	//Set the path for project specific code
		$ProjectSpecificCodePath	=	$_POST['project'];
		$CommonCodePath				=	'./Common';
		$tempFolderPath				=	'./temp';
		$indexFilePath				=	'./index.php';
		$sampleInterfacePath		=	'./sampleInterfaces'	;
	}
	 
	if(isset($_POST['phpINI']) && $_POST['phpINI'] == 'on'){	
	// Step 1 : rename existing php.ini to php_datetime.ini
		backupPhpINI();	
		
	// Step	2 :	upload new php.ini
		replacePhpINI();
	}
	
	if(isset($_POST['codeDirName'])){
	// Step 3 : move complete code to the www directory
		copyCode();
	}
}

//Required in installer and migrate data

if(isset($_POST['mysql_host']) && isset($_POST['mysql_user']) && isset($_POST['mysql_pswd']) && isset($_POST['newDatabase'])){
// Step 4 : Create new database with provided name
	createNewDatabase();

// Step 5 : Import database from query in the code
	importDatabase();

// Step 6 : Create a new user for the database
	createUserToAccessDatabase();
}

 // Step 7 : Get update
	getAptUpdate();

if(isset($_POST['support_PDF']) && $_POST['support_PDF'] == 'on'){	
// Step 8 : Install wkhtmltopdf 
	installPdfSupport();
}

if(isset($_POST['support_JSON']) && $_POST['support_JSON'] == 'on'){	
// Step 9 : Install json support 
	installJSONSupport();
}
 
if(isset($_POST['support_Curl']) && $_POST['support_Curl'] == 'on'){	
// Step 10 : Install curl library support 
	installCurlSupport();
}
 
if(isset($_POST['Install_Code']) && $_POST['Install_Code'] == 'on') {
// Step 11 : Give permissions to DocRoot
	permissionToDirectory();
}

if(isset($_POST['Data_Migrate']) && $_POST['Data_Migrate'] == 'on') {
// Step 12 : If data migration required than include respective script
	//Set variables required inside of migratedata.php
	$mysqlHost				=	$_POST['data_mig_src_host'];
	$mysqlUsername			=	$_POST['data_mig_src_user'];
	$mysqlPassword			=	$_POST['data_mig_src_pswd'];
	$ImportDataFromDatabase	=	$_POST['data_mig_src_db'];
	require_once 'PulsarPPU/installer assets/migrateDataFromBetaTo.php';
}
else{
	$pathToDbMgrInterface	=	$destinationCodeFolder.'/Common/php/OperateDB/DbMgrInterface.php';
	
	// Include DbMgrInterface
	require_once $pathToDbMgrInterface;
	$NeccessaryStaticDatabaseEntries	=	DB_Query("INSERT INTO systemsettings SET smtpHostName = 'mail.veneratech.com' , smtpUsername = 'pulsarppuadmin@veneratech.com', smtpPassword = 'ppuadminVenera12*', smtpPort = '25' , sender='pulsarppuadmin@veneratech.com', supportEmailID='pulsarsupport@veneratech.com'");
	$NeccessaryStaticDatabaseEntries	=	DB_Query("insert  into `userinfo`(`UserID`,`AccountID`,`Username`,`MailID`,`Password`,`UserType`,`userStatus`,`regAuthorityID`,`regAuthorityName`,`Name`,`Address`,`City`,`Country`,`PinCode`,`Organization`,`Website`,`phoneOffice`,`phonePersonal`,`PartnerID`,`Commision`,`RegisteredOn`) values (1,0,'admin@veneratech.com','pulsarppuadmin@veneratech.com','0192023a7bbd73250516f069df18b500',4,2,1,'Aditya','Aditya ','Noida','Noida','India','110007','Venera Technologies','www.venera.com','7503790445','8862598745',NULL,NULL,'2014-08-28')");
	
}
// step 12: Redirect to index page
	header('Location: ./../'.$_POST['codeDirName'].'/index.php');
		
function continueOrNot(){
	global $error;
	if($error	!=	''){
		echo $error;
		die();	
	}
}

function getCurrentDateTime(){
	return date('Y-m-d|H:i:s');
}

function run_system_query($query){
	if($query == '')
		$output	=	false;
	else{
		global $RemoteSystem;
		if(!$RemoteSystem)
			$query	=	'echo '.$_POST["local_Password"].' | sudo -S xvfb-run -a '.$query;
		else
			$query	=	'xvfb-run -a '.$query;
		
		$output	=	exec ($query);
	}
	return $output;
}

function backupPhpINI(){
	global $newPhpINI;
	global $error;
	$existingPhpINI	=	 php_ini_loaded_file();
	$newPhpINI		=	 str_replace('.ini','',$existingPhpINI).'-'.getCurrentDateTime().'.ini';
	$copyphpIniQuery	=	"cp '".$existingPhpINI."' '".$newPhpINI."'";
	$resultCopyIni	=	run_system_query($copyphpIniQuery);
	
	if(!file_exists($newPhpINI)) {
		$error	=	'php.ini file not backed up';
		continueOrNot();
	}	
}

function replacePhpINI(){
	global $newPhpINI;
	global $error;
	$destinationNewPhpINI	=	php_ini_loaded_file();
	$sourceNewPhpINI		=	'./'.$_POST['project'].'/installer assets/php.ini';

	if(!file_exists($sourceNewPhpINI)) {
		$error	=	'new php.ini file missing';
		continueOrNot();
	}	

	$removeOldPhpINI		=	"rm '".$destinationNewPhpINI."'";
	$resultRemoveIni		=	run_system_query($removeOldPhpINI);
	if(file_exists($destinationNewPhpINI)) {
		$error	=	'old php.ini file not deleted';
		continueOrNot();
	}	

	$replacephpIniQuery		=	"cp '".$sourceNewPhpINI."' '".$destinationNewPhpINI."'";
	$resultReplaceIni		=	run_system_query($replacephpIniQuery);
	if(!file_exists($destinationNewPhpINI)) {
		$error	=	'php.ini file not replaced';
		$restorephpIniQuery		=	"cp '".$newPhpINI."' '".$destinationNewPhpINI."'";
		$restorePhpINIResult	=	run_system_query($restorephpIniQuery);
		continueOrNot();
	}
}

function copyCode(){
	global $error;
	global $destinationCodeFolder;
	global $DocRootPath;
	global $ProjectSpecificCodePath;
	global $CommonCodePath;
	global $tempFolderPath;
	global $indexFilePath;
	global $sampleInterfacePath;
	$FolderNameForCopyCode	=	'';
	$FolderNameForCopyCode	=	$_POST['codeDirName'];
	
	if($FolderNameForCopyCode	==	'' || 	$FolderNameForCopyCode	==	NULL){
		$error	=	'code folder name has not been provided by user which is to be placed under www';
		continueOrNot();
	}

	$destinationCodeFolder	=	'./../'.$FolderNameForCopyCode;
	if(file_exists($destinationCodeFolder)) {
		if(isset($_POST['Overwrite_Dir']) && $_POST['Overwrite_Dir'] == 'on' && isset($_POST['Backup_Dir_Name']) && $_POST['Backup_Dir_Name'] != ''){
			// rename existing Directory
			$backUpCodeFolder	=	'./../'.$_POST['Backup_Dir_Name'];
			$renameExistingCodeDirQuery		=	"cp -R '".$destinationCodeFolder."' '".$backUpCodeFolder."'";	
			$renameExistingCodeDirResult	=	run_system_query($renameExistingCodeDirQuery);
			$deleteExistingCodeDirQuery		=	"rm -R '".$destinationCodeFolder."'";	
			$deleteExistingCodeDirResult	=	run_system_query($deleteExistingCodeDirQuery);
		}
		else{
			$error	=	'Code folder name already exist. Please try again with a new code folder name';
			continueOrNot();
		}
	}
	
	if(file_exists($destinationCodeFolder)) {
		$error	=	'existing code not backed up.';
		continueOrNot();
	}	

	$createCodeDirQuery			=	"mkdir '".$destinationCodeFolder."'";	
	$createCodeDirResult		=	run_system_query($createCodeDirQuery);
	
	if(!file_exists($ProjectSpecificCodePath) || !file_exists($CommonCodePath) || !file_exists($tempFolderPath) || !file_exists($sampleInterfacePath) || !file_exists($indexFilePath)) {
		$error	=	'source code folder missing';
		continueOrNot();
	}	
	

	if(!file_exists($destinationCodeFolder)) {
		$error	=	'code not copied to destination';
		continueOrNot();
	}
	
	$permissionToDestinationFolderQuery	=	"chmod -R 777 ".$destinationCodeFolder;
	$permissionToDestinationFolderQueryResult	=	run_system_query($permissionToDestinationFolderQuery);
// failure at below copy command

	$FoldersToCopy	=	array($_POST['project'],'Common','temp','sampleInterfaces','index.php');
	for($i =0; $i< count($FoldersToCopy); $i++){
		$copyCodeQuery	=	"cp -r '".__DIR__."/".$FoldersToCopy[$i]."' '".$destinationCodeFolder."/'";
		$copyCodeResult	=	run_system_query($copyCodeQuery);
		
		if(!file_exists($destinationCodeFolder.'/'.$FoldersToCopy[$i])) {
			$error	=	'folder '.$FoldersToCopy[$i].' not copied to destination';
			continueOrNot();
		}
	}
	$permissionToDestinationFolderQuery	=	"chmod -R 777 ".$destinationCodeFolder;
	$permissionToDestinationFolderQueryResult	=	run_system_query($permissionToDestinationFolderQuery);
	
}

function createNewDatabase(){
	global $error;
	global $hostname;
	global $MysqlUsername;
	global $MysqlPassword;
	global $newDatabaseName;
	
	$hostname			=	$_POST['mysql_host'];
	$MysqlUsername		=	$_POST['mysql_user'];
	$MysqlPassword		=	$_POST['mysql_pswd'];
	$newDatabaseName	=	$_POST['newDatabase'];
	
	if($hostname	==	'' || 	$hostname	==	NULL){
		$error	=	'hostname not provided for database';
		continueOrNot();
	}

	if($MysqlUsername	==	'' || 	$MysqlUsername	==	NULL){
		$error	=	'username for mysql not provided';
		continueOrNot();
	}
	
	if($MysqlPassword	==	'' || 	$MysqlPassword	==	NULL){
		$error	=	'password not provided for Mysql user';
		continueOrNot();
	}

	if($newDatabaseName	==	'' || 	$newDatabaseName	==	NULL){
		$error	=	'database name not provided';
		continueOrNot();
	}
		
	global $mysqlCon;
	$mysqlCon = mysqli_connect($hostname,$MysqlUsername,$MysqlPassword);

	if (mysqli_connect_errno())
	{
		$error = "Failed to connect to MySQL: " . mysqli_connect_error();
		continueOrNot();
	}
	
	$createDatabaseQuery	=	"create database ".$newDatabaseName.";";
	$createDatabaseResult	=	mysqli_real_query ($mysqlCon, $createDatabaseQuery);
}

function importDatabase(){
	global $newDatabaseName;
	global $hostname;
	global $MysqlUsername;
	global $MysqlPassword;
	global $ProjectSpecificCodePath;
	global $destinationCodeFolder;
	global $error;
	global $databaseSourcePath;
	global $newUserConfigFile;

	$databaseSourcePath			=	$destinationCodeFolder.'/'.$ProjectSpecificCodePath.'/installer assets/database.sql';
	$DBConfigFilePath			=	$destinationCodeFolder.'/Common/php/OperateDB/DbConfig.php';
	$newUserConfigFile			=	$destinationCodeFolder.'/'.$ProjectSpecificCodePath.'/installer assets/dbuserQuery.php';
	
	if(!file_exists($databaseSourcePath)) {
		$error	=	'source database file missing';
		continueOrNot();
	}
/*	
	$copiedDatabaseSourceFile	=	str_replace('.sql','-'.getCurrentDateTime().'.sql',$databaseSourcePath);
	$copiedDbConfigFile			=	str_replace('.php','-'.getCurrentDateTime().'.php',$DBConfigFilePath);
	$copyDatabaseFileQuery		=	"cp -r {'".basename($copiedDatabaseSourceFile).",".basename($copiedDbConfigFile)."}' '".dirname($databaseSourcePath)."/'";	
	$copyDatabaseFileResult		=	run_system_query($copyDatabaseFileResult);
*/	
	if(!file_exists($databaseSourcePath)) {
		$error	=	'database file not copied';
		continueOrNot();
	}
	
	file_put_contents($databaseSourcePath,str_replace('demoDatabase',$newDatabaseName,file_get_contents($databaseSourcePath)));
	file_put_contents($DBConfigFilePath,str_replace('demoDatabase',$newDatabaseName,file_get_contents($DBConfigFilePath)));
	
	$importDatabaseQuery	=	"mysql -h ".$hostname." --user=".$MysqlUsername." --password=".$MysqlPassword." < '".$databaseSourcePath."'";
	$importDatabaseResult	=	run_system_query ($importDatabaseQuery);
}

function createUserToAccessDatabase(){
	global $mysqlCon;
	global $error;
	global $hostname;
	global $MysqlUsername;
	global $MysqlPassword;
	global $newUserConfigFile;
	if(!file_exists($newUserConfigFile)) {
		$error	=	'new user config file missing';
		continueOrNot();
	}
	
	require_once $newUserConfigFile;
	$skipUserCreation = false;
	$checkUserExistQuery	=	"SELECT * FROM mysql.user WHERE User = '".$createNewUserName."'";
	$checkUserExistResult	=	mysqli_query($mysqlCon, $checkUserExistQuery);
	if(mysqli_num_rows($checkUserExistResult) > 0){
		if(isset($_POST['DefaultUser']) && $_POST['DefaultUser'] == 'on'){
			$skipUserCreation	=	true;
		}
		else{
			$error	=	"User already exist in mysql table";
			continueOrNot();
		}
	}
	if(!$skipUserCreation)
		$createNewUserResult	=	mysqli_query($mysqlCon, $userQuery);
	$grantPriviligesResult	=	mysqli_query($mysqlCon, $userPrivilegesQuery);
	$flushPriviligesResult	=	mysqli_query($mysqlCon, $flushPrivilegesQuery);
	
}

 function getAptUpdate(){
 	$updateQuery	=	'apt-get update';
 	$updateResult	=	run_system_query($updateQuery);
 }
 
 function installPdfSupport(){
 	$PDFSupportinstallquery		=	'apt-get install wkhtmltopdf';
 	$PDFSupportinstallResult	=	run_system_query($PDFSupportinstallquery);
 }

 function installJSONSupport(){
 	$JSONSupportinstallquery	=	'apt-get install php5-json';
 	$JSONSupportinstallResult	=	run_system_query($JSONSupportinstallquery);
 }

 function installCurlSupport(){
 	$CurlSupportinstallquery	=	'apt-get install curl libcurl3 libcurl3-dev php5-curl';
 	$CurlSupportinstallResult	=	run_system_query($CurlSupportinstallquery);
 }
 
 function permissionToDirectory(){
 	global $DocRootPath;
 	$permissionSetQuery		=	'chmod -R 777 '.$DocRootPath;		
 	$permissionSetResult	=	run_system_query($permissionSetQuery);
 }
 
?>