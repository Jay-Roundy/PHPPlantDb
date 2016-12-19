-- MySQL dump 10.13  Distrib 5.5.44, for debian-linux-gnu (x86_64)
--
-- Host: 0.0.0.0    Database: plantdb
-- ------------------------------------------------------
-- Server version	5.5.44-0ubuntu0.14.04.1

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
-- Table structure for table `history_db`
--

DROP TABLE IF EXISTS `history_db`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `history_db` (
  `HistoryId` int(6) NOT NULL AUTO_INCREMENT,
  `PlantId` int(6) NOT NULL,
  `UserId` int(6) NOT NULL,
  `Date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Comment` varchar(400) DEFAULT NULL,
  PRIMARY KEY (`HistoryId`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `history_db`
--

LOCK TABLES `history_db` WRITE;
/*!40000 ALTER TABLE `history_db` DISABLE KEYS */;
INSERT INTO `history_db` VALUES (1,1,1,'2016-04-29 03:48:09','Seeds grow quick in river run potting soil with daily water mist'),(2,1,1,'2016-04-29 03:57:39','Seed supplier suggests a june-july planting time'),(3,2,1,'2016-04-29 04:30:08','starts out after a week in river run potting soil, slow to grow but growing '),(4,2,1,'2016-04-29 04:31:14','seed started in april in 3 inch jiffy pot with 4 hrs grow light in window greenhouse'),(5,3,1,'2016-04-29 04:41:08','started indoors in 3 in coconut pots and seeds are slow to grow and small'),(8,3,1,'2016-04-29 22:45:24','i was on swiss chard page :('),(9,3,1,'2016-04-29 23:34:51','testing comment page to database for swiss chard lettuce from pagination'),(10,2,1,'2016-04-29 23:36:15','new thai pepper comment test'),(11,2,1,'2016-05-02 15:59:02','final testing');
/*!40000 ALTER TABLE `history_db` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `plant_db`
--

DROP TABLE IF EXISTS `plant_db`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `plant_db` (
  `PlantId` int(6) NOT NULL AUTO_INCREMENT,
  `Date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Name` varchar(30) NOT NULL,
  `ScientificName` varchar(30) DEFAULT NULL,
  `Category` varchar(20) DEFAULT NULL,
  `Lifecycle` varchar(20) DEFAULT NULL,
  `SoilPreference` varchar(50) DEFAULT NULL,
  `SunPreference` varchar(50) DEFAULT NULL,
  `WateringPreference` varchar(50) DEFAULT NULL,
  `FrostTolerance` varchar(20) DEFAULT NULL,
  `SeedPlanting` varchar(120) DEFAULT NULL,
  `PlantingAreaRequired` varchar(120) DEFAULT NULL,
  `Image` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`PlantId`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `plant_db`
--

LOCK TABLES `plant_db` WRITE;
/*!40000 ALTER TABLE `plant_db` DISABLE KEYS */;
INSERT INTO `plant_db` VALUES (1,'2016-04-27 03:04:37','bush blue lake bean','ejote silvestre','vegetable','annual','Average','Full','keep evenly moist','no','keep 3 inches apart and cover with 2 inches of loose dirt','18 inches apart in rows','image/blue_lake.jpg'),(2,'2016-04-29 04:26:34','Big Thai hybrid hot pepper','Pimiento Picante','vegetable','annual','Rich Organic','Full','keep evenly moist','no','start seeds 1/4 inch deep in 3-4 in. pots about 8-10 weeks before last frost. transplant 2 weeks after last frost when p','18-24 in. apart with 2-3 ft between rows. Store in outdoor covered area for 1 week before planting','image/big_thai.jpg'),(3,'2016-05-02 16:00:07','Swiss Chard','Acelga Flamingo','vegetable','annual','Average soil','Full','keep evenly moist','mild','Direct sow 1/2 in deep and 12 in apart in early spring soil when ground is workable','12 inches between plants','image/swiss_chard.jpg');
/*!40000 ALTER TABLE `plant_db` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_db`
--

DROP TABLE IF EXISTS `user_db`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_db` (
  `UserId` int(6) NOT NULL AUTO_INCREMENT,
  `UserName` varchar(20) NOT NULL,
  `Password` varchar(40) NOT NULL,
  PRIMARY KEY (`UserId`),
  UNIQUE KEY `UserName` (`UserName`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_db`
--

LOCK TABLES `user_db` WRITE;
/*!40000 ALTER TABLE `user_db` DISABLE KEYS */;
INSERT INTO `user_db` VALUES (1,'jsmitty','2936fa6873b510849684d6767e815ffe755cfb25'),(2,'klyn','cacee2da6e3ed1b64391c91b3c79b47c1b39cfc3'),(3,'tbubbles','48542c835b35463b71d0f36821fff98ce25fde1b');
/*!40000 ALTER TABLE `user_db` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-05-02 16:12:32
