/*
SQLyog Community Edition- MySQL GUI v6.15
MySQL - 5.6.17 : Database - novadatabase
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

create database if not exists `novadatabase`;

USE `novadatabase`;

/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

/*Table structure for table `accountinfo` */

DROP TABLE IF EXISTS `accountinfo`;

CREATE TABLE `accountinfo` (
  `accountId` int(10) NOT NULL AUTO_INCREMENT,
  `accountValidity` varchar(50) DEFAULT NULL,
  `accountStatus` varchar(10) DEFAULT NULL,
  `creationDate` varchar(50) DEFAULT NULL,
  `updationDate` varchar(50) DEFAULT NULL,
  `creditMinutes` varchar(50) DEFAULT NULL,
  `acountMgr` int(10) DEFAULT NULL,
  `currencyCode` varchar(50) DEFAULT NULL,
  `usageMinutes` varchar(50) DEFAULT NULL,
  `timezoneId` int(10) DEFAULT NULL,
  PRIMARY KEY (`accountId`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `accountinfo` */

insert  into `accountinfo`(`accountId`,`accountValidity`,`accountStatus`,`creationDate`,`updationDate`,`creditMinutes`,`acountMgr`,`currencyCode`,`usageMinutes`,`timezoneId`) values (0,'2015-05-12','1','2015-04-27 15:28:47',NULL,'50',NULL,'USD','0',NULL),(1,'1439942400','1',NULL,'2015-07-30','46576',NULL,NULL,'13496',2);

/*Table structure for table `agentinfo` */

DROP TABLE IF EXISTS `agentinfo`;

CREATE TABLE `agentinfo` (
  `agentId` int(10) NOT NULL AUTO_INCREMENT,
  `agentUniqueNumber` varchar(255) DEFAULT NULL,
  `accountId` int(10) DEFAULT NULL,
  `agentName` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `agentDescription` varchar(511) CHARACTER SET utf8 DEFAULT NULL,
  `nodeId` int(10) DEFAULT NULL,
  `agentType` varchar(255) DEFAULT NULL,
  `agentState` varchar(255) DEFAULT NULL,
  `capacity` varchar(255) DEFAULT NULL,
  `CurrentCapacity` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`agentId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `agentinfo` */

/*Table structure for table `bouquetinfo` */

DROP TABLE IF EXISTS `bouquetinfo`;

CREATE TABLE `bouquetinfo` (
  `bouquetId` int(10) NOT NULL AUTO_INCREMENT,
  `accountId` int(10) DEFAULT NULL,
  `bouquetName` varchar(255) NOT NULL,
  `bouquetDescription` varchar(511) DEFAULT NULL,
  `userId` int(10) NOT NULL,
  PRIMARY KEY (`bouquetId`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

/*Data for the table `bouquetinfo` */

/*Table structure for table `channelbouquetmapping` */

DROP TABLE IF EXISTS `channelbouquetmapping`;

CREATE TABLE `channelbouquetmapping` (
  `bouquetId` int(10) NOT NULL,
  `channelId` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `channelbouquetmapping` */

/*Table structure for table `channelinfo` */

DROP TABLE IF EXISTS `channelinfo`;

CREATE TABLE `channelinfo` (
  `channelId` int(10) NOT NULL AUTO_INCREMENT,
  `accountId` int(10) DEFAULT NULL,
  `nodeId` int(10) DEFAULT NULL,
  `channelName` varchar(255) CHARACTER SET utf8 NOT NULL,
  `channelUrl` varchar(511) CHARACTER SET utf8 NOT NULL,
  `channelStatus` int(10) NOT NULL DEFAULT '2',
  `templateId` varchar(10) DEFAULT NULL,
  `timezoneId` int(10) DEFAULT NULL,
  PRIMARY KEY (`channelId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `channelinfo` */

/*Table structure for table `channelthumbnailmap` */

DROP TABLE IF EXISTS `channelthumbnailmap`;

CREATE TABLE `channelthumbnailmap` (
  `channelid` int(10) NOT NULL,
  `profileid` int(10) DEFAULT NULL,
  PRIMARY KEY (`channelid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `channelthumbnailmap` */

/*Table structure for table `cloudserverdetails` */

DROP TABLE IF EXISTS `cloudserverdetails`;

CREATE TABLE `cloudserverdetails` (
  `tokenPrimaryKey` int(10) NOT NULL AUTO_INCREMENT,
  `tokenId` varchar(20) DEFAULT NULL,
  `tokenExpiry` varchar(50) DEFAULT NULL,
  `tokenStatus` varchar(20) DEFAULT NULL,
  `tenantId` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`tokenPrimaryKey`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC;

/*Data for the table `cloudserverdetails` */

/*Table structure for table `cloudserviceeventlogs` */

DROP TABLE IF EXISTS `cloudserviceeventlogs`;

CREATE TABLE `cloudserviceeventlogs` (
  `logId` int(10) NOT NULL,
  `serviceProvider` varchar(50) DEFAULT NULL,
  `url` text,
  `response` varchar(100) DEFAULT NULL,
  `httpResponse` text,
  PRIMARY KEY (`logId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `cloudserviceeventlogs` */

/*Table structure for table `database_version` */

DROP TABLE IF EXISTS `database_version`;

CREATE TABLE `database_version` (
  `DBVersion` int(11) NOT NULL,
  `ProductVersion` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `database_version` */

insert  into `database_version`(`DBVersion`,`ProductVersion`) values (1,'1.0.0.1');

/*Table structure for table `eventinfo` */

DROP TABLE IF EXISTS `eventinfo`;

CREATE TABLE `eventinfo` (
  `eventId` int(10) NOT NULL AUTO_INCREMENT,
  `channelId` int(10) DEFAULT NULL,
  `startTime` varchar(50) DEFAULT NULL,
  `endTime` varchar(50) DEFAULT NULL,
  `timeZone` varchar(50) DEFAULT NULL COMMENT 'additional seconds after UTC 00',
  `repetition` varchar(50) DEFAULT NULL COMMENT '0 for no repitions otherwise number would be comma separated(Eg, 1= sun,4,7)',
  `untill` varchar(50) DEFAULT NULL COMMENT '0 for Forever otherwise Time',
  `reminder` varchar(50) DEFAULT NULL COMMENT 'unit is min. This duration is used to send mail alert to user befor start monitoring',
  `eventStatus` varchar(10) DEFAULT NULL,
  `eventRunningStatus` varchar(10) DEFAULT NULL COMMENT 'Status about resource allocation and monitoring maintanined by controller',
  PRIMARY KEY (`eventId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `eventinfo` */

/*Table structure for table `licenseinfo` */

DROP TABLE IF EXISTS `licenseinfo`;

CREATE TABLE `licenseinfo` (
  `licenseId` int(10) NOT NULL AUTO_INCREMENT,
  `accountId` int(10) DEFAULT NULL,
  `licenseKey` varchar(50) DEFAULT NULL,
  `SUID` varchar(50) DEFAULT NULL,
  `serviceId` varchar(50) DEFAULT 'NOVA',
  PRIMARY KEY (`licenseId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `licenseinfo` */

/*Table structure for table `nodeinfo` */

DROP TABLE IF EXISTS `nodeinfo`;

CREATE TABLE `nodeinfo` (
  `nodeId` int(10) NOT NULL AUTO_INCREMENT,
  `accountId` int(10) DEFAULT NULL,
  `nodeName` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `nodeDescription` varchar(511) CHARACTER SET utf8 DEFAULT NULL,
  `backupAgent` varchar(10) DEFAULT '0',
  `nodeType` varchar(20) DEFAULT NULL,
  `nodeLocation` varchar(50) DEFAULT NULL,
  `serviceProvider` varchar(100) DEFAULT NULL,
  `userId` int(10) DEFAULT NULL,
  PRIMARY KEY (`nodeId`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `nodeinfo` */

insert  into `nodeinfo`(`nodeId`,`accountId`,`nodeName`,`nodeDescription`,`backupAgent`,`nodeType`,`nodeLocation`,`serviceProvider`,`userId`) values (1,0,'Venera Node','Demo','0',NULL,'IAD',NULL,NULL);

/*Table structure for table `nodelicense` */

DROP TABLE IF EXISTS `nodelicense`;

CREATE TABLE `nodelicense` (
  `licenseId` int(10) NOT NULL AUTO_INCREMENT,
  `nodeId` int(10) DEFAULT NULL,
  `accountId` int(10) DEFAULT NULL,
  `createdOn` varchar(50) DEFAULT NULL,
  `expiresOn` varchar(50) DEFAULT NULL,
  `licenseStatus` varchar(10) DEFAULT NULL,
  `latestUpdate` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`licenseId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `nodelicense` */

/*Table structure for table `operatorsettings` */

DROP TABLE IF EXISTS `operatorsettings`;

CREATE TABLE `operatorsettings` (
  `userId` int(10) DEFAULT NULL,
  `accountId` int(10) DEFAULT NULL,
  `monitorView` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `operatorsettings` */

insert  into `operatorsettings`(`userId`,`accountId`,`monitorView`) values (7,1,'1'),(8,1,'1');

/*Table structure for table `paymentinfo` */

DROP TABLE IF EXISTS `paymentinfo`;

CREATE TABLE `paymentinfo` (
  `paymentId` int(10) NOT NULL AUTO_INCREMENT,
  `transactionId` varchar(50) DEFAULT NULL,
  `accountId` int(10) DEFAULT NULL,
  `amountPaid` varchar(50) DEFAULT NULL,
  `creditAmount` varchar(50) DEFAULT NULL,
  `serviceRate` varchar(50) DEFAULT NULL,
  `creditMinutes` varchar(50) DEFAULT NULL,
  `paymentDate` varchar(50) DEFAULT NULL,
  `validityPeriod` varchar(50) DEFAULT NULL,
  `paymentMode` varchar(10) DEFAULT NULL,
  `paymentStatus` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`paymentId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `paymentinfo` */

/*Table structure for table `profileagentmap` */

DROP TABLE IF EXISTS `profileagentmap`;

CREATE TABLE `profileagentmap` (
  `profileid` int(11) DEFAULT NULL,
  `agentid` int(10) DEFAULT NULL,
  `status` int(10) DEFAULT NULL COMMENT '1 = scheduled 2 = Monitoring',
  `scheduledSession` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `profileagentmap` */

/*Table structure for table `profileinfo` */

DROP TABLE IF EXISTS `profileinfo`;

CREATE TABLE `profileinfo` (
  `profileId` int(10) NOT NULL AUTO_INCREMENT,
  `profileName` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `profileUrl` varchar(511) CHARACTER SET utf8 DEFAULT NULL,
  `channelId` int(10) NOT NULL,
  `profileStatus` varchar(255) DEFAULT NULL,
  `profileInformation` varchar(511) DEFAULT NULL,
  `encription` varchar(10) DEFAULT NULL,
  `updateState` int(10) DEFAULT NULL COMMENT 'default 1,2 = New 3 =Not present, 4= Hidden',
  `profileResolution` varchar(50) DEFAULT NULL COMMENT 'Width x Height',
  PRIMARY KEY (`profileId`)
) ENGINE=InnoDB AUTO_INCREMENT=69 DEFAULT CHARSET=latin1;

/*Data for the table `profileinfo` */

/*Table structure for table `reportsettings` */

DROP TABLE IF EXISTS `reportsettings`;

CREATE TABLE `reportsettings` (
  `accountId` int(10) DEFAULT NULL,
  `userId` int(10) NOT NULL,
  `interval` int(10) DEFAULT NULL COMMENT 'in hrs',
  PRIMARY KEY (`userId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `reportsettings` */

insert  into `reportsettings`(`accountId`,`userId`,`interval`) values (1,7,24),(1,8,24);

/*Table structure for table `requestedagentinfo` */

DROP TABLE IF EXISTS `requestedagentinfo`;

CREATE TABLE `requestedagentinfo` (
  `reqID` int(10) NOT NULL AUTO_INCREMENT COMMENT 'PK Unique.',
  `eventID` int(10) DEFAULT NULL,
  `nodeID` int(10) DEFAULT NULL,
  `ipAddress` varchar(20) DEFAULT NULL,
  `configurationID` varchar(100) DEFAULT NULL,
  `uniqueServerID` varchar(100) DEFAULT NULL,
  `reqTime` varchar(50) DEFAULT NULL,
  `serverURL` varchar(100) DEFAULT NULL,
  `serverPassword` varchar(100) DEFAULT NULL,
  `createdTime` varchar(100) DEFAULT NULL,
  `serverName` varchar(50) DEFAULT NULL,
  `progress` varchar(20) DEFAULT NULL,
  `status` varchar(10) DEFAULT NULL,
  `flavorID` varchar(50) DEFAULT NULL,
  `flavorLink` varchar(50) DEFAULT NULL,
  `serverRequestResponse` text,
  `serverDetailsResponse` text,
  `activeTime` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`reqID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `requestedagentinfo` */

/*Table structure for table `sessioninfo` */

DROP TABLE IF EXISTS `sessioninfo`;

CREATE TABLE `sessioninfo` (
  `sessionId` varchar(50) NOT NULL,
  `userId` int(10) DEFAULT NULL,
  `startTime` varchar(50) DEFAULT NULL,
  `endTime` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `sessioninfo` */

/*Table structure for table `systemsettings` */

DROP TABLE IF EXISTS `systemsettings`;

CREATE TABLE `systemsettings` (
  `accountId` int(10) NOT NULL AUTO_INCREMENT,
  `smtpHostName` varchar(50) DEFAULT NULL,
  `smtpUsername` varchar(50) DEFAULT NULL,
  `smtpPassword` varchar(50) DEFAULT NULL,
  `smtpPort` varchar(50) DEFAULT NULL,
  `sender` varchar(50) DEFAULT NULL,
  `webServerUrl` varchar(512) DEFAULT NULL COMMENT 'http path of web server for RACI communication',
  PRIMARY KEY (`accountId`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `systemsettings` */

insert  into `systemsettings`(`accountId`,`smtpHostName`,`smtpUsername`,`smtpPassword`,`smtpPort`,`sender`,`webServerUrl`) values (1,'mail.veneratech.com','novaadmin@veneratech.com','noad12*','25','novaadmin@veneratech.com','http://192.168.0.228/branch/NOVA/InterfaceToControllerReception.php');

/*Table structure for table `templateinfo` */

DROP TABLE IF EXISTS `templateinfo`;

CREATE TABLE `templateinfo` (
  `templateId` int(10) NOT NULL AUTO_INCREMENT,
  `accountId` int(10) DEFAULT NULL,
  `templateName` varchar(50) DEFAULT NULL,
  `templateDescription` varchar(250) DEFAULT NULL,
  `File` longtext,
  PRIMARY KEY (`templateId`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

/*Data for the table `templateinfo` */

insert  into `templateinfo`(`templateId`,`accountId`,`templateName`,`templateDescription`,`File`) values (3,1,'testing template','eval purpose','<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<NovaTemplate version=\"1\"><Template ID=\"3\" NAME=\"testing template\"><Rule name=\"avSignalDrop\"><Param name=\"Duration\">1</Param></Rule><Rule name=\"fileIntegrity\"><Param name=\"missingProfile\">1</Param><Param name=\"missingSegment\">1</Param><Param name=\"invalidSegment\">1</Param><Param name=\"indexFileDoesNotRefresh\">1</Param></Rule><Rule name=\"loudnessDetection\"><Param name=\"Mode\">1</Param><Param name=\"thresholdLevel\">2</Param><Param name=\"EBUTimescale\">1</Param><Param name=\"EBUmaxLevelSign\">1</Param><Param name=\"EBUmaxLoudLevel\">5</Param><Param name=\"EBUmaxLoudTolerance\">6</Param><Param name=\"EBULevelSign\">1</Param><Param name=\"EBUminLoudLevel\">87</Param><Param name=\"EBUminLoudTolerance\">1</Param><Param name=\"EBUTimescale\">2</Param><Param name=\"EBUmaxLevelSign\">1</Param><Param name=\"EBUmaxLoudLevel\">5</Param><Param name=\"EBUmaxLoudTolerance\">6</Param><Param name=\"EBULevelSign\">1</Param><Param name=\"EBUminLoudLevel\">87</Param><Param name=\"EBUminLoudTolerance\">1</Param></Rule><Rule name=\"closedCaptionMissing\"><Param name=\"Duration\">1</Param></Rule></Template></NovaTemplate>\n'),(6,1,'New Format Complete Template','File Integrity and A / V signal drop implemented','<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<NovaTemplate version=\"1\"><Template ID=\"6\" NAME=\"New Format Complete Template\"><Rule name=\"avSignalDrop\"><Param name=\"Duration\">3</Param></Rule><Rule name=\"fileIntegrity\"><Param name=\"missingProfile\">1</Param><Param name=\"missingSegment\">1</Param><Param name=\"invalidSegment\">1</Param><Param name=\"indexFileDoesNotRefresh\">1</Param></Rule><Rule name=\"loudnessDetection\"><Param name=\"Mode\">1</Param><Param name=\"thresholdLevel\">2</Param><Param name=\"EBUTimescale\">1</Param><Param name=\"EBUmaxLevelSign\">1</Param><Param name=\"EBUmaxLoudLevel\">1</Param><Param name=\"EBUmaxLoudTolerance\">2</Param><Param name=\"EBULevelSign\">1</Param><Param name=\"EBUminLoudLevel\">1</Param><Param name=\"EBUminLoudTolerance\">0</Param><Param name=\"EBUTimescale\">2</Param><Param name=\"EBUmaxLevelSign\">1</Param><Param name=\"EBUmaxLoudLevel\">1</Param><Param name=\"EBUmaxLoudTolerance\">2</Param><Param name=\"EBULevelSign\">1</Param><Param name=\"EBUminLoudLevel\">1</Param><Param name=\"EBUminLoudTolerance\">0</Param></Rule><Rule name=\"closedCaptionMissing\"><Param name=\"Presence\">1</Param></Rule><Rule name=\"bufferUnderRun\">1</Rule></Template></NovaTemplate>\n');

/*Table structure for table `timezoneinfo` */

DROP TABLE IF EXISTS `timezoneinfo`;

CREATE TABLE `timezoneinfo` (
  `timezoneId` int(10) NOT NULL AUTO_INCREMENT COMMENT 'Unique Identifier',
  `zoneName` varchar(255) DEFAULT NULL COMMENT 'Name of timezone',
  `zoneOffset` varchar(50) DEFAULT NULL COMMENT 'offset value of timezone',
  `DSTapply` int(10) DEFAULT NULL COMMENT 'Flag for dst applicability 1: Applicable/2: Not applicable',
  `DSTvalue` varchar(10) DEFAULT NULL COMMENT 'Value of DST offset (if applicable) 0 for normal time and 1 for i hour offset',
  `DSTregion` varchar(10) DEFAULT NULL COMMENT '1:Northern /2: Southern',
  `DSTstart` varchar(255) DEFAULT NULL COMMENT 'rule to define the start time of DST alteration',
  `DSTend` varchar(255) DEFAULT NULL COMMENT 'rule to define the end time of DST alteration',
  PRIMARY KEY (`timezoneId`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `timezoneinfo` */

insert  into `timezoneinfo`(`timezoneId`,`zoneName`,`zoneOffset`,`DSTapply`,`DSTvalue`,`DSTregion`,`DSTstart`,`DSTend`) values (1,'UTC Time','+0.0',2,'0','0',NULL,NULL),(2,'JST','+9.0',2,'0','0',NULL,NULL),(3,'CST','-6.0',1,'1',NULL,'1425801600','1446361200');

/*Table structure for table `usageinfo` */

DROP TABLE IF EXISTS `usageinfo`;

CREATE TABLE `usageinfo` (
  `usageId` int(10) NOT NULL AUTO_INCREMENT,
  `eventId` int(10) DEFAULT NULL,
  `accountId` int(10) DEFAULT NULL,
  `usedMinutes` varchar(50) DEFAULT NULL,
  `usageDate` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`usageId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `usageinfo` */

/*Table structure for table `userinfo` */

DROP TABLE IF EXISTS `userinfo`;

CREATE TABLE `userinfo` (
  `userId` int(10) NOT NULL AUTO_INCREMENT,
  `accountId` int(10) DEFAULT NULL,
  `userName` varchar(100) DEFAULT NULL,
  `userType` varchar(10) DEFAULT NULL,
  `userStatus` varchar(10) DEFAULT NULL,
  `mailId` varchar(100) DEFAULT NULL,
  `regAuthorityId` int(10) DEFAULT NULL,
  `regAuthorityName` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `pincode` varchar(255) DEFAULT NULL,
  `organization` varchar(255) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `phoneOffice` varchar(255) DEFAULT NULL,
  `phonePersonal` varchar(255) DEFAULT NULL,
  `registeredOn` varchar(255) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`userId`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

/*Data for the table `userinfo` */

insert  into `userinfo`(`userId`,`accountId`,`userName`,`userType`,`userStatus`,`mailId`,`regAuthorityId`,`regAuthorityName`,`name`,`address`,`city`,`country`,`pincode`,`organization`,`website`,`phoneOffice`,`phonePersonal`,`registeredOn`,`password`) values (4,0,'superuser@nova.com','0','1','ankit.agrawal@veneratech.com',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'Vener',NULL,NULL,NULL,NULL,'0192023a7bbd73250516f069df18b500'),(5,1,'test_user4@veneratech.com','1','1','test_user4@veneratech.com',4,'superuser@nova.com','Test User','','','','','Venera','','','','2015-04-24 16:24:37','0192023a7bbd73250516f069df18b500'),(7,1,'test_user3@veneratech.com','2','1','test_user3@veneratech.com',5,'test_user4@veneratech.com','User3 ','','','','','Venera','','','','2015-04-27 15:32:46','0192023a7bbd73250516f069df18b500'),(8,1,'test_user2@veneratech.com','2','1','test_user2@veneratech.com',5,'test_user4@veneratech.com','test_user2 ','','','','','venera','','','','2015-07-10 15:20:52','0192023a7bbd73250516f069df18b500'),(9,1,'sales@nova.com','3','1','ankit@agrawal@veneratech.com',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'0192023a7bbd73250516f069df18b500');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
