-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.1.22-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             9.4.0.5125
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Dumping database structure for project01
DROP DATABASE IF EXISTS `project01`;
CREATE DATABASE IF NOT EXISTS `project01` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `project01`;

-- Dumping structure for table project01.group
DROP TABLE IF EXISTS `group`;
CREATE TABLE IF NOT EXISTS `group` (
  `groupID` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `contactAddress` varchar(255) DEFAULT NULL,
  `Information` varchar(10000) DEFAULT NULL,
  `phoneNumber` bigint(11) DEFAULT NULL,
  `currentNews` varchar(2000) DEFAULT NULL,
  PRIMARY KEY (`groupID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Dumping data for table project01.group: ~2 rows (approximately)
/*!40000 ALTER TABLE `group` DISABLE KEYS */;
REPLACE INTO `group` (`groupID`, `name`, `contactAddress`, `Information`, `phoneNumber`, `currentNews`) VALUES
	(1, 'test\r\n', NULL, NULL, NULL, NULL),
	(2, 'test2', NULL, NULL, NULL, NULL);
/*!40000 ALTER TABLE `group` ENABLE KEYS */;

-- Dumping structure for table project01.item
DROP TABLE IF EXISTS `item`;
CREATE TABLE IF NOT EXISTS `item` (
  `itemID` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `end` datetime NOT NULL,
  `description` varchar(500) NOT NULL,
  `type` set('Request','Supplying') NOT NULL,
  `FKuser` int(11) NOT NULL,
  `finished` tinyint(4) NOT NULL,
  `group` int(11) DEFAULT NULL,
  PRIMARY KEY (`itemID`),
  KEY `FKUser` (`FKuser`),
  KEY `FKGroupID` (`group`),
  CONSTRAINT `FKGroupID` FOREIGN KEY (`group`) REFERENCES `group` (`groupID`),
  CONSTRAINT `FKUser` FOREIGN KEY (`FKuser`) REFERENCES `user` (`userID`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Dumping data for table project01.item: ~1 rows (approximately)
/*!40000 ALTER TABLE `item` DISABLE KEYS */;
REPLACE INTO `item` (`itemID`, `name`, `end`, `description`, `type`, `FKuser`, `finished`, `group`) VALUES
	(1, 'gerd item', '2017-05-04 16:36:32', 'test', 'Request', 1, 0, NULL);
/*!40000 ALTER TABLE `item` ENABLE KEYS */;

-- Dumping structure for table project01.notifcation
DROP TABLE IF EXISTS `notifcation`;
CREATE TABLE IF NOT EXISTS `notifcation` (
  `NotificationID` int(11) NOT NULL AUTO_INCREMENT,
  `FKUser` int(11) NOT NULL,
  `FKTag` int(11) NOT NULL,
  PRIMARY KEY (`NotificationID`),
  KEY `FKUserID` (`FKUser`),
  KEY `FKTagID` (`FKTag`),
  CONSTRAINT `FKTagID` FOREIGN KEY (`FKTag`) REFERENCES `tag` (`tagID`),
  CONSTRAINT `FKUserID` FOREIGN KEY (`FKUser`) REFERENCES `user` (`userID`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Dumping data for table project01.notifcation: ~1 rows (approximately)
/*!40000 ALTER TABLE `notifcation` DISABLE KEYS */;
REPLACE INTO `notifcation` (`NotificationID`, `FKUser`, `FKTag`) VALUES
	(1, 1, 2);
/*!40000 ALTER TABLE `notifcation` ENABLE KEYS */;

-- Dumping structure for table project01.tag
DROP TABLE IF EXISTS `tag`;
CREATE TABLE IF NOT EXISTS `tag` (
  `tagID` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`tagID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Dumping data for table project01.tag: ~2 rows (approximately)
/*!40000 ALTER TABLE `tag` DISABLE KEYS */;
REPLACE INTO `tag` (`tagID`, `name`) VALUES
	(1, 'Boogers'),
	(2, 'Beef');
/*!40000 ALTER TABLE `tag` ENABLE KEYS */;

-- Dumping structure for table project01.user
DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `userID` int(10) NOT NULL AUTO_INCREMENT,
  `userFirstName` varchar(35) NOT NULL,
  `userLastName` varchar(35) NOT NULL,
  `email` varchar(255) NOT NULL,
  `FKgroup` int(11) DEFAULT NULL,
  PRIMARY KEY (`userID`),
  UNIQUE KEY `UserID` (`userID`),
  KEY `FKgroup` (`FKgroup`),
  CONSTRAINT `FKGroup` FOREIGN KEY (`FKgroup`) REFERENCES `group` (`groupID`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Dumping data for table project01.user: ~1 rows (approximately)
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
REPLACE INTO `user` (`userID`, `userFirstName`, `userLastName`, `email`, `FKgroup`) VALUES
	(1, 'Gerd', 'Gerd', 'Gerd', 1);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
