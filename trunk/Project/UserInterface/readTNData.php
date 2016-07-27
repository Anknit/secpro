<?php 
error_reporting(0);
session_start();
if(!isset($_SESSION['modifyTime'])){
	$_SESSION['modifyTime'] = '000';
}
$imageNames	=	array('./../TN/channel1.png');
$EncodeToJsonArray	= '';
if(filemtime($imageNames[0]) != $_SESSION['modifyTime']){
	$imageDataChann1	=	base64_encode(file_get_contents($imageNames[0]));	
	$EncodeToJsonArray	=	array("channel1" => "data:image/png;base64, {$imageDataChann1}\n\n");

	$EncodeToJsonArray	=	json_encode($EncodeToJsonArray);
	$_SESSION['modifyTime']	=	filemtime($imageNames[0]);
}
echo $EncodeToJsonArray;
flush();
?>