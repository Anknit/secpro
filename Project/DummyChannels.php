<?php 
	require_once __DIR__.'/require.php';
	require_once 'ControllerNotification/requestMethods.php';
	
	for($i=0;$i<20;$i++){
		$addChannelAction	=	DB_Insert(
			array(	
			'Table' => 'channelinfo',
			'Fields'=>	array(							
						'channelName' 	=>'Dummy_Channel_'.$i,
						'nodeId' 		=>4,
						'channelUrl'	=> 'http://192.168.0.134:81/Demo/manifest.m3u8',
						)
			)
		);
		if($addChannelAction){
			$controllerResponse	=	NOVA_COMMUNICATION('notify',array('type'=>'add-channel','id'=>$addChannelAction));
		}
		$activateProfile	=	DB_Query("Update profileinfo Set profileStatus = 1 where channelId = ".$addChannelAction." and profileUrl = 'http://192.168.0.134:81/Demo/chunklist_b300000.m3u8'");
		if($activateProfile){
			$controllerResponse	=	NOVA_COMMUNICATION('notify',array('type'=>'modify-channel','id'=>$addChannelAction));
		}
		$addChannelToBouquet	=	DB_Insert(array(
			'Table' => 'channelbouquetmapping',
			'Fields'=>	array(							
						'bouquetId' 	=>3,
						'channelId' 	=>$addChannelAction,
						)
		));		
	}
?>