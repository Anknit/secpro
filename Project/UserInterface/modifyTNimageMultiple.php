<?php 

function GetFilesNameArray($dir){
	$filenameArray	=	'';
	if (is_dir($dir)) {
	    if ($dh = opendir($dir)) {
	    	$filenameArray	=	array();
	        while (($file = readdir($dh)) !== false) {
	        	if($file!='.' && $file!='..'){
		            $filenameArray[]	=	 $file;
	        	}
	        }
	        closedir($dh);
	    }
	}
	return $filenameArray;
}
function CallThisEveryinterval($fileList){
	$channelIdListArr	=	array('301','302','303','101','102','103','201','202','203');
	for($i=0;$i<count($channelIdListArr);$i++){
		$latestTn[$channelIdListArr[$i]]	=	$fileList[$channelIdListArr[$i]][rand(0,count($fileList[$channelIdListArr[$i]])-1)];
	}
	copyNewTN($latestTn);
}
function copyNewTN($latestTn){
	$channelTN=	'TN.png';
	$sourceDir	=	'C:\\wamp\www\Web_Projects\Trunk\NOVA\images2\\';
	$destDir	=	'C:\\wamp\www\Web_Projects\Trunk\NOVA\TN2\\';
	foreach($latestTn as $key => $value){
		$updateTN	=	copy($sourceDir.$key.'\\'.$value, $destDir.$key.'\\'.$channelTN);
	}
}
$sourceDir	=	'C:\\wamp\www\Web_Projects\Trunk\NOVA\images2\\';
$channelIdListArr	=	array('301','302','303','101','102','103','201','202','203');
for($i=0;$i<count($channelIdListArr);$i++){
	$fileList[$channelIdListArr[$i]]	=	GetFilesNameArray($sourceDir.$channelIdListArr[$i]);
}
while (true) {
	sleep(10);
    CallThisEveryinterval($fileList);
}

?>