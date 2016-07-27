<?php
error_reporting(0);
global $Module;
require_once __DIR__.'./../require.php';
require_once Common.'php/MailMgr.php';

if($Module['BouquetManagement'])	//If subscription update is set to true for the logged in user
{
	if(isset($_SESSION) && $_SESSION['userID'] != "" )
	{
		if($cat == 'add'){
			$addBouquetAction	=	DB_Insert(
				array(	
				'Table' => 'bouquetinfo',
				'Fields'=>	array(							//Mandatory
							'bouquetName' =>$name,
							'bouquetDescription' =>$desc,
							'userId'	=> $user,
							'accountId'	=> $_SESSION['accountID'],
							)
				)
			);
		}
		if($cat == 'delete'){
			$deleteBouquetAction	=	DB_Delete(
				array(	
				'Table' => 'bouquetinfo',
				'clause'=> 'bouquetId = "'.$bouquetId.'"'
				)
			);
			if($deleteBouquetAction){
				$deleteBouquetChannelMapping	=	DB_Delete(
					array(
					'Table'	=>	'channelbouquetmapping',
					'clause'=>	'bouquetId	= "'.$bouquetId.'"'
					)
				);
			}
		}
		if($cat == 'map'){
			$adddata	=	json_decode($adddata,TRUE);
			$removedata	=	json_decode($removedata,TRUE);
			$firstKey	=	true;
			$addMappingTableQuery	=	"insert into channelbouquetmapping (bouquetId,channelId) values ";
			foreach($adddata as $key => $value){
				if(!$firstKey){
					$addMappingTableQuery .= ",";
				}
				$addMappingTableQuery .= "(".$adddata[$key].",".$key.")";
				$firstKey	=	false;
			}
			if(count($adddata)){
				DB_Query($addMappingTableQuery);
			}
			
			$firstKey	=	true;
			$deleteMappedChannelIds	=	'';	
			foreach($removedata as $key => $value){
				if(!$firstKey){
					$deleteMappedChannelIds .= ",";
				}
				$deleteMappedChannelIds	.=	$key;
				$firstKey	=	false;
				$bouquetId	=	$removedata[$key];
			}
			if(count($removedata)){
				$deleteBouquetChannelMapping	=	DB_Delete(
						array(
								'Table'	=>	'channelbouquetmapping',
								'clause'=>	'bouquetId	= "'.$bouquetId.'" AND channelId IN ('.$deleteMappedChannelIds.')'
						)
						);
			}
			
		}
		if($cat == 'edit'){
			$updateBouquetInfo	= DB_Update(
				array(
					'Table'	=>	'bouquetinfo',
					'Fields'=>	array(
									'bouquetDescription'	=> $desc,
									'userId'		=> $userId,
								),
					'clause'=>	'bouquetId	= "'.$bouquetId.'"'
				)
			);
		}
	}
}
?>