<?php

//USER TYPE DEFINTION 
define('SUPERUSER', 0);
define('ADMIN', 1);
define('NORMAL', 2);
define('SALES', 3);
define('OPERATOR', 4);

//User Status
define('USER_UNVERIFIED', 1); 
define('USER_ACTIVE', 2); 
define('USER_INACTIVE', 3);

//Account Types
define('AC_TYPE_INDIVIDUAL',1);
define('AC_TYPE_GROUP',2);
define('AC_TYPE_PUBLIC',3);

//Account Status
define('AC_ACTIVE', 1); 
define('AC_INACTIVE', 2); 
define('AC_UNVERIFIED', 3); 

//Login Types
define("EMAIL",1);
define("GOOGLE",2);

define('THRESHOLD', 30); 

//Agent Assigned Status
define('Assigned', 1); 
define('Unassigned', 2); 

//Agent Types
define('Normal', 1); 
define('Backup', 2); 

//Agent State
define('Running', 1); 
define('Dead', 2); 

//Profile status
define('Profile_Active',1);
define('Profile_Inactive',2);

//Channel status
define('Channel_Active',1);
define('Channel_Inactive',2);

//Default dates
$defaultNOVADates[1]	=	"+15 day";	//Add new Account FOR EVAL and set the accountValidity by this date
$defaultNOVADates[2]	=	"+30 day";	//
$defaultNOVADates[3]	=	'+1 year';	// For expiry date of Node license key

// Per account limit of channels
define('AccountChannelLimit', 100000);

// For removed entries of channel/events
define('REMOVED', 9);

define('NovaSupportEmail', 'novaadmin@veneratech.com');

// Default Error alert settings constants
define('ErrorAlertFrequency', 10);
define('ErrorAlertThreshold', 10);

// Range of Error alert settings 
$ErrorAlertFrequencyRange = [1,60];
$ErrorAlertThresholdRange = [1,100];

// To use testing credentials for agent scaling Feature
$sandBox = true;

// Channel email alert default state
define('ChannelEmailAlertDefault',0);

// Default timezone Id | 9 is for UTC
define('DefaultTimezonId',9);

// Default monitor layout setting value | 1:Default, 2:Consolidated, 3:Enhanced, 4:Enhanced v2
define('DefaultMonitorLayout',4);
?>