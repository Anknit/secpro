<?php
/*
* Author: Aditya
* date: 08-Aug-2014
* Description: This defines variables for various permission sets
*
*/
require_once  __DIR__.'/definitions.php';

//Permissions for backend
$UI_Allowed_To_SuperUser	=	array(SUPERUSER);	//Allow superUser
$UI_Allowed_To_Admin		=	array(ADMIN,SUPERUSER);	//Allow admin
$UI_Allowed_To_All_Users	=	array(ADMIN, OPERATOR, SUPERUSER, SALES);	//Allow both
$UI_Allowed_To_Operator		=	array(OPERATOR);	//Allow only operator
$UI_Allowed_To_Sales		=	array(SALES);	//Allow only operator
$UI_FOR_CUSTOMER_MGMT		=	array(SUPERUSER,SALES);
$UI_Allowed_To_AccMgr		=	array(ADMIN);
?>