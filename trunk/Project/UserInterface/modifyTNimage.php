<?php
function GetFilesNameArray($dir){
	$filenameArray	=	'';
	if (is_dir($dir)) {
	    if ($dh = opendir($dir)) {
	    	$filenameArray	=	array();
	        while (($file = readdir($dh)) !== false) {
	        	if($file!='.' && $file!='..' && $file!='logo.PNG' ){
		            $filenameArray[]	=	 $file;
	        	}
	        }
	        closedir($dh);
	    }
	}
	return $filenameArray;
}
function CallThisEveryinterval($fileList){
	$latestTn	=	$fileList[rand(0,count($fileList)-1)];
	copyNewTN($latestTn);
}
function copyNewTN($latestTn){
	$channelTN=	'channel1.png';
	$sourceDir	=	'C:\wamp\www\Web_Projects\Trunk\NOVA\images\\';
	$destDir	=	'C:\wamp\www\Web_Projects\Trunk\NOVA\TN\\';
	$updateTN	=	copy($sourceDir.$latestTn, $destDir.$channelTN);
}

$sourceDir	=	'C:\wamp\www\Web_Projects\Trunk\NOVA\images\\';
$fileList	=	GetFilesNameArray($sourceDir);
while (true) {
	sleep(20);
    CallThisEveryinterval($fileList);
}
?>