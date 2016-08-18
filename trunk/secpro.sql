/*
SQLyog Community Edition- MySQL GUI v6.15
MySQL - 5.6.17 : Database - secpro
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

/*Table structure for table `appsettings` */

CREATE TABLE `appsettings` (
  `userid` int(11) DEFAULT NULL,
  `uploadmode` int(11) DEFAULT NULL,
  `gpsdata` int(11) DEFAULT NULL,
  `mediafrequency` int(11) DEFAULT NULL,
  `gpsfrequency` int(11) DEFAULT NULL,
  UNIQUE KEY `userid_UNIQUE` (`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `groupdata` */

CREATE TABLE `groupdata` (
  `groupid` int(11) NOT NULL AUTO_INCREMENT,
  `accmgrid` int(11) DEFAULT NULL,
  `groupstatus` int(11) DEFAULT NULL,
  `groupname` varchar(100) DEFAULT NULL,
  `groupdataaccess` int(11) DEFAULT NULL,
  `groupprivacy` int(11) DEFAULT NULL,
  `groupcreated` datetime DEFAULT NULL,
  `groupmediafrequency` int(11) DEFAULT NULL,
  `groupgpsfrequency` int(11) DEFAULT NULL,
  PRIMARY KEY (`groupid`),
  UNIQUE KEY `groupid_UNIQUE` (`groupid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `groupusersmapping` */

CREATE TABLE `groupusersmapping` (
  `groupid` int(11) DEFAULT NULL,
  `userid` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `sessiondata` */

CREATE TABLE `sessiondata` (
  `sessionid` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) DEFAULT NULL,
  `sessionname` varchar(100) DEFAULT NULL,
  `sessiontype` int(11) DEFAULT NULL,
  `sessionstart` datetime DEFAULT NULL,
  `sessionend` datetime DEFAULT NULL,
  `comments` text,
  PRIMARY KEY (`sessionid`),
  UNIQUE KEY `sessionid_UNIQUE` (`sessionid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `userdata` */

CREATE TABLE `userdata` (
  `id` int(100) NOT NULL AUTO_INCREMENT COMMENT 'unique identifier',
  `email` varchar(50) NOT NULL COMMENT 'email address',
  `username` varchar(100) DEFAULT NULL COMMENT 'username for login purpose',
  `password` varchar(64) DEFAULT NULL,
  `userstatus` int(5) DEFAULT NULL COMMENT 'active, inactive, blocked',
  `usertype` int(5) DEFAULT NULL COMMENT 'normal, admin',
  `logintype` int(5) DEFAULT NULL COMMENT 'email, google, facebook, twitter',
  `registeredon` timestamp NULL DEFAULT NULL COMMENT 'timestamp of registration',
  `firstname` varchar(50) DEFAULT NULL,
  `lastname` varchar(50) DEFAULT NULL,
  `profilelink` varchar(50) DEFAULT NULL COMMENT 'male, female, other',
  `phone` varchar(20) DEFAULT NULL,
  `registeredusing` int(5) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

/*Table structure for table `verificationlinks` */

CREATE TABLE `verificationlinks` (
  `linkId` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) DEFAULT NULL,
  `verificationLink` varchar(60) DEFAULT NULL,
  PRIMARY KEY (`linkId`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
