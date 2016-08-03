-- MySQL dump 10.13  Distrib 5.7.13, for Linux (x86_64)
--
-- Host: 127.0.0.1    Database: secpro
-- ------------------------------------------------------
-- Server version	5.7.13-0ubuntu0.16.04.2

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `appsettings`
--

DROP TABLE IF EXISTS `appsettings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `appsettings` (
  `userid` int(11) DEFAULT NULL,
  `uploadmode` int(11) DEFAULT NULL,
  `gpsdata` int(11) DEFAULT NULL,
  `mediafrequency` int(11) DEFAULT NULL,
  `gpsfrequency` int(11) DEFAULT NULL,
  UNIQUE KEY `userid_UNIQUE` (`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `appsettings`
--

LOCK TABLES `appsettings` WRITE;
/*!40000 ALTER TABLE `appsettings` DISABLE KEYS */;
/*!40000 ALTER TABLE `appsettings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `groupdata`
--

DROP TABLE IF EXISTS `groupdata`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `groupdata`
--

LOCK TABLES `groupdata` WRITE;
/*!40000 ALTER TABLE `groupdata` DISABLE KEYS */;
/*!40000 ALTER TABLE `groupdata` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `groupusersmapping`
--

DROP TABLE IF EXISTS `groupusersmapping`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `groupusersmapping` (
  `groupid` int(11) DEFAULT NULL,
  `userid` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `groupusersmapping`
--

LOCK TABLES `groupusersmapping` WRITE;
/*!40000 ALTER TABLE `groupusersmapping` DISABLE KEYS */;
/*!40000 ALTER TABLE `groupusersmapping` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessiondata`
--

DROP TABLE IF EXISTS `sessiondata`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessiondata`
--

LOCK TABLES `sessiondata` WRITE;
/*!40000 ALTER TABLE `sessiondata` DISABLE KEYS */;
/*!40000 ALTER TABLE `sessiondata` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `userdata`
--

DROP TABLE IF EXISTS `userdata`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `userdata`
--

LOCK TABLES `userdata` WRITE;
/*!40000 ALTER TABLE `userdata` DISABLE KEYS */;
INSERT INTO `userdata` VALUES (4,'ankit.agrawal@veneratech.com','ankit.agrawal@veneratech.com','0192023a7bbd73250516f069df18b500',1,2,1,'2016-07-26 16:49:43',NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `userdata` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-08-03 23:43:01
