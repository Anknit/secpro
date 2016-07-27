<?php
function getSoapClientObject(&$variable){
	$novaControllerWsdlPath	=	NOVA."ControllerNotification/nova.wsdl";
	
	$api = new SoapClient($novaControllerWsdlPath);
	if($api){
		$variable	=	$api;
		return true;
	}
	else{
		return false;
	}
}
?>
