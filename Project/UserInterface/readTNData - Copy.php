<?php 
error_reporting(0);
header("Content-Type: text/event-stream\n\n");
header('Cache-Control: no-cache');
session_start();
$channelIdListArr	=	array('301','302','303','101','102','103','201','202','203');
if(!isset($_SESSION['modifyTime'])){
	$_SESSION['modifyTime'] = '000';
}
$TNdataDir	=	'./../TN/';
$EncodeToJsonArray	= '';
$EncodeToJsonArray	=	array();
for($i=0;$i<count($channelIdListArr);$i++){
	$imageName	=	$TNdataDir.$channelIdListArr[$i].'/TN.png';
	if(filemtime($imageNames) != $_SESSION[$channelIdListArr[$i]]['modifyTime']){
		$imageData				=	base64_encode(file_get_contents($imageName));
// 		$EncodeToJsonArray[]	=	$channelIdListArr[$i]	=>	"data:image/png;base64, {$imageDataChann1}\n\n ";
								
		$EncodeToJsonArray	=	json_encode($EncodeToJsonArray);
		$_SESSION['modifyTime']	=	filemtime($imageNames[0]);
	}
}
	echo $EncodeToJsonArray;//.$EncodeToJsonArray;
	flush();
?>