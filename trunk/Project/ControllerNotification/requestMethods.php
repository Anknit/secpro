<?php
/*
* Author: Ankit	
* date: 26-Feb-2015
* Description: 
*
*/

ini_set('default_socket_timeout', 600);
require_once __DIR__.'./../SoapClient.php';
	function NOVA_COMMUNICATION($controllerApi, $paramArr){
		$soapClient;
		getSoapClientObject($soapClient);

		if($controllerApi	==	'notify'){
			try {
				$resData	=	$soapClient->WebNotification($paramArr);
			} 
			catch (SoapFault $fault) {
				$data	=	"SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
			}
			if($resData != ''){
				$data	=	$resData->Responce;
				if($data != 0 && $data != "0"){
//					setcookie("soapError", json_encode($resData->vecOfString), time()+10);
					$data	=	$resData->vecOfString;
				}
			}
		}
		if($controllerApi	==	'monitor'){
			try {
				$data	=	$soapClient->RequestMonitoringData($paramArr);
			}
			catch (SoapFault $fault) {
				$data	=	"SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
			}
		}
		if($controllerApi	==	'dashboard'){
			try {
				$data	=	$soapClient->GenerateReport($paramArr);
			}
			catch (SoapFault $fault) {
				$data	=	"SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
			}
		}
		return $data;
	}
?>