-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 25, 2017 at 11:52 PM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 7.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `project01`
--
CREATE DATABASE IF NOT EXISTS `project01` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `project01`;

-- --------------------------------------------------------

--
-- Table structure for table `client`
--

DROP TABLE IF EXISTS `client`;
CREATE TABLE IF NOT EXISTS `client` (
  `clientID` int(10) NOT NULL AUTO_INCREMENT,
  `clientFirstName` varchar(35) NOT NULL,
  `clientLastName` varchar(35) NOT NULL,
  `email` varchar(255) NOT NULL,
  `clientPassword` varchar(100) NOT NULL,
  `FKgroup` int(11) DEFAULT NULL,
  `lastSeen` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `accountType` tinyint(3) NOT NULL DEFAULT '1',
  PRIMARY KEY (`clientID`),
  UNIQUE KEY `ClientID` (`clientID`),
  KEY `FKgroup` (`FKgroup`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `client`
--

INSERT INTO `client` (`clientID`, `clientFirstName`, `clientLastName`, `email`, `clientPassword`, `FKgroup`, `lastSeen`, `accountType`) VALUES
(3, 'Gerard', 'May', 'gerdington@gmail.com', '$2y$10$OloLj1M/1A1lVHlpis7lnerPIqhtCS8/lEGCK0xMkfqKUauIosRTm', NULL, '2017-08-18 21:53:37', 2),
(4, 'Tim', 'Russell', 'timjarussell@gmail.com', '$2y$10$DDBKUS3vsP76aLLHVr/1be.1kDYmE8oycrSmQnBsnM35Rg8crJ91C', 1, '2017-07-17 23:13:59', 1),
(5, 'Tim', 'McKnight', 'tmcknight@gmail.com', '$2y$10$UMsc7xqP85HaKgRPYWY3j.Pvgx0qNNpd8.B0qi9EsUXGme3wT.1jy', 2, '2017-07-17 23:13:59', 1),
(6, 'Baljit', 'Kaur', 'kaurbaljit046@gmail.com', '$2y$10$gGhELtJXzo.t2txN6fDYYugaxP5d31nJRMzYfjGd7Yn9wHdIS7IRS', 10, '2017-07-17 23:13:59', 1),
(7, 'Peter', 'Billett', 'jeneralpanano@hotmail.com', '$2y$10$fsJv77cLdQIs2EM90QOnzOCTXh56TcoRCw13C/S8USv1gsxROt4Py', 17, '2017-07-17 23:13:59', 1),
(8, 'Test', 'Test', 'test@test.com', '$2y$10$Y9i1Da.Ss0XwPWzsrMY6BuOkYWzobwsSs0HvQMi5wm56B5EyEk99u', 1, '2017-08-25 23:04:47', 2),
(9, 'red', 'red', 'red@red.net', '$2y$10$iEHrxPtWa24Z6y4gznQ8.Ozl9NW.oSu3a0xRPdrdGRsdqRHUHiSrO', NULL, '2017-08-25 10:23:48', 1),
(11, 'Admin', 'Admin', 'admin@admin.com', '$2y$10$vROLCDI7msSzssmh1.8E.uTrOwjZTcX.QMj0Ey2uMLPStxYbQkpc2', NULL, '2017-08-25 17:19:51', 3),
(13, 'red', 'albert', 'anaccount@email.net', '$2y$10$JPCWSI3NKM.43GboQjwtjeYtc2CbXsaABQx.8zpP1JEv1SdziQyO2', NULL, '2017-08-25 10:29:17', 1),
(14, 'test', 'test', 'testtest@test.com', '$2y$10$kD8XZyhz5VlG638F2L8d0.el0H73Yip9nzjlXL49FfDR5u.sjb8aO', NULL, '2017-08-25 22:19:55', 1);

-- --------------------------------------------------------

--
-- Table structure for table `emailqueue`
--

DROP TABLE IF EXISTS `emailqueue`;
CREATE TABLE IF NOT EXISTS `emailqueue` (
  `emailID` int(11) NOT NULL AUTO_INCREMENT,
  `itemNumber` int(11) NOT NULL,
  `emailType` tinyint(5) NOT NULL,
  PRIMARY KEY (`emailID`),
  KEY `itemNumber` (`itemNumber`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `homepagenews`
--

DROP TABLE IF EXISTS `homepagenews`;
CREATE TABLE IF NOT EXISTS `homepagenews` (
  `newID` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `news` varchar(20000) NOT NULL,
  `newsDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`newID`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `homepagenews`
--

INSERT INTO `homepagenews` (`newID`, `title`, `news`, `newsDate`) VALUES
(1, 'WARNING', 'The website is currently in development and will have some broken features during this time.', '2017-08-08 10:01:02');

-- --------------------------------------------------------

--
-- Table structure for table `item`
--

DROP TABLE IF EXISTS `item`;
CREATE TABLE IF NOT EXISTS `item` (
  `itemID` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `endtime` datetime NOT NULL,
  `description` varchar(500) NOT NULL,
  `category` set('Request','Supplying') NOT NULL,
  `FKclient` int(11) NOT NULL,
  `finished` tinyint(4) NOT NULL DEFAULT '0',
  `organisation` int(11) DEFAULT NULL,
  `FKTagID` int(11) NOT NULL,
  `lastModifiedTime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `perishable` tinyint(1) NOT NULL DEFAULT '0',
  `location` varchar(250) DEFAULT NULL,
  `image` varchar(13) DEFAULT NULL,
  PRIMARY KEY (`itemID`),
  KEY `FKClient` (`FKclient`),
  KEY `FKGroupID` (`organisation`),
  KEY `FKTagID` (`FKTagID`)
) ENGINE=InnoDB AUTO_INCREMENT=285 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `item`
--

INSERT INTO `item` (`itemID`, `name`, `endtime`, `description`, `category`, `FKclient`, `finished`, `organisation`, `FKTagID`, `lastModifiedTime`, `perishable`, `location`, `image`) VALUES
(3, 'Coaches', '2017-08-18 12:08:00', 'Looking for people to help out with coaching under 12 basketball. Please ensure you have working with children qualifications before applying.', 'Request', 8, 2, 1, 6, '2017-08-18 09:29:26', 0, NULL, '3.png'),
(4, 'Sausages', '2017-10-13 00:00:00', 'Looking for sausages for a fund raiser', 'Request', 5, 1, 2, 7, '2017-07-17 23:19:52', 1, NULL, NULL),
(5, 'Sausages', '2017-11-10 23:19:52', '10kg of sausages. Please contact for more information.', 'Supplying', 7, 1, 17, 7, '2017-08-01 17:39:23', 1, NULL, '5.png'),
(6, 'Workers', '2017-10-05 00:00:00', 'Offering to help any organisation in need every Wednesday this month. Ring me on ##########', 'Supplying', 3, 1, NULL, 15, '2017-08-15 17:56:51', 0, NULL, NULL),
(14, 'New name ', '2018-01-05 23:19:52', 'New description ', 'Supplying', 7, 1, 1, 1, '2017-08-15 17:56:53', 0, NULL, NULL),
(15, 'TESTa', '2018-02-28 23:19:52', 'et', 'Request', 4, 0, 1, 1, '2017-08-18 16:58:55', 0, NULL, NULL),
(17, 'testaaaa', '2017-10-21 01:06:00', 'as', 'Request', 3, 0, 1, 1, '2017-07-24 23:19:52', 0, NULL, NULL),
(20, 'Testa', '2017-09-28 01:06:00', 'test', 'Request', 5, 0, 1, 1, '2017-07-31 23:19:52', 0, NULL, NULL),
(22, 'Test0', '2017-09-25 10:06:00', 'Test0', 'Supplying', 9, 0, 1, 1, '2017-08-15 17:57:01', 0, NULL, NULL),
(23, 'test', '2017-08-12 23:19:52', 'test', 'Request', 4, 2, 1, 7, '2017-07-31 23:19:52', 1, NULL, NULL),
(24, 'Coaches', '2017-10-19 23:19:52', 'Looking for people to help out with coaching under 12 basketball. Please ensure you have working with children qualifications before applying.', 'Request', 4, 0, 1, 6, '2017-07-17 23:19:52', 0, NULL, NULL),
(25, 'Sausages', '2018-01-19 00:00:00', 'Looking for sausages for a fund raiser', 'Request', 5, 0, 2, 7, '2017-07-17 23:19:52', 1, NULL, NULL),
(26, 'Sausages', '2017-11-10 23:19:52', '10kg of sausages. Please contact for more information.', 'Supplying', 7, 1, 17, 7, '2017-08-15 17:57:07', 1, NULL, NULL),
(27, 'Workers', '2017-08-28 00:00:00', 'Offering to help any organisation in need every Wednesday this month. Ring me on ##########', 'Supplying', 3, 1, NULL, 15, '2017-08-15 17:57:10', 0, NULL, NULL),
(29, 'urieo', '2017-08-18 12:08:00', 'etsgsgswhwjbwdbdb', 'Request', 8, 2, 1, 1, '2017-08-18 18:49:12', 0, NULL, '29.png'),
(30, 'testing', '2018-05-11 01:06:00', 'test', 'Request', 3, 0, 1, 1, '2017-07-27 23:19:52', 0, NULL, NULL),
(31, 'test', '2017-11-10 01:06:00', 'test', 'Request', 6, 0, 1, 1, '2017-07-31 23:19:52', 0, NULL, NULL),
(32, 'test', '2017-10-15 23:19:52', 'test', 'Request', 4, 0, 1, 1, '2017-07-31 00:00:00', 0, NULL, NULL),
(33, 'test', '2017-06-01 01:06:00', 'test', 'Request', 6, 2, 1, 1, '2017-07-31 23:19:52', 0, NULL, NULL),
(34, 'Test', '2017-06-01 01:06:00', 'test', 'Request', 9, 2, 1, 1, '2017-08-17 23:19:52', 0, NULL, NULL),
(35, 'Test', '2017-00-15 10:06:00', 'Test', 'Request', 8, 2, 1, 1, '2017-07-31 00:00:00', 0, NULL, NULL),
(37, 'test', '2017-08-01 10:06:00', 'test', 'Request', 9, 2, 1, 13, '2017-07-31 23:19:52', 0, NULL, NULL),
(38, 'Coaches', '2017-07-30 23:19:52', 'Looking for people to help out with coaching under 12 basketball. Please ensure you have working with children qualifications before applying.', 'Request', 4, 2, 1, 6, '2017-07-28 12:26:10', 0, NULL, NULL),
(39, 'Sausages', '2017-04-13 00:00:00', 'Looking for sausages for a fund raiser', 'Request', 5, 2, 2, 7, '2017-07-17 23:19:52', 1, NULL, NULL),
(40, 'Sausages', '2017-11-10 23:19:52', '10kg of sausages. Please contact for more information.', 'Supplying', 7, 1, 17, 7, '2017-08-15 17:57:16', 1, NULL, NULL),
(41, 'Workers', '2017-04-28 00:00:00', 'Offering to help any organisation in need every Wednesday this month. Ring me on ##########', 'Supplying', 3, 2, NULL, 15, '2017-07-17 23:19:52', 0, NULL, NULL),
(42, 'a', '2017-06-01 12:06:00', 'TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TEST', 'Request', 6, 2, 1, 1, '2017-07-17 23:19:52', 0, NULL, NULL),
(43, 'et', '2017-06-01 12:06:00', 'et', 'Request', 6, 2, 1, 1, '2017-07-17 23:19:52', 0, NULL, NULL),
(44, 'testing', '2017-06-01 01:06:00', 'test', 'Request', 3, 2, 1, 1, '2017-07-17 23:19:52', 0, NULL, NULL),
(45, 'test', '2017-06-01 01:06:00', 'test', 'Request', 9, 2, 1, 1, '2017-07-17 23:19:52', 0, NULL, NULL),
(46, 'test', '2017-06-01 01:06:00', 'test', 'Request', 9, 2, 1, 1, '2017-07-17 23:19:52', 0, NULL, NULL),
(47, 'test', '2017-06-01 01:06:00', 'test', 'Request', 8, 2, 1, 1, '2017-07-17 23:19:52', 0, NULL, NULL),
(48, 'Test', '2017-06-01 01:06:00', 'test', 'Request', 9, 2, 1, 1, '2017-08-17 23:19:52', 0, NULL, NULL),
(49, 'Test', '2017-06-01 10:06:00', 'Test', 'Supplying', 5, 2, 1, 1, '2017-08-17 23:19:52', 0, NULL, NULL),
(50, 'Test', '2017-06-01 10:06:00', 'Test', 'Supplying', 9, 2, 1, 1, '2017-08-17 23:19:52', 0, NULL, NULL),
(52, 'Coaches', '2017-07-30 23:19:52', 'Looking for people to help out with coaching under 12 basketball. Please ensure you have working with children qualifications before applying.', 'Supplying', 4, 2, 1, 6, '1900-01-31 00:00:00', 0, NULL, NULL),
(53, 'Sausages', '2017-04-13 00:00:00', 'Looking for sausages for a fund raiser', 'Supplying', 5, 2, 2, 7, '2017-07-31 00:00:00', 1, NULL, NULL),
(54, 'Sausages', '2017-11-10 23:19:52', '10kg of sausages. Please contact for more information.', 'Supplying', 7, 1, 17, 7, '2017-08-15 17:57:19', 1, NULL, NULL),
(55, 'Workers', '2017-04-28 00:00:00', 'Offering to help any organisation in need every Wednesday this month. Ring me on ##########', 'Supplying', 3, 2, NULL, 15, '1900-01-31 00:00:00', 0, NULL, NULL),
(56, 'a', '2017-06-01 12:06:00', 'TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TEST', 'Supplying', 3, 2, 1, 1, '1900-01-31 00:00:00', 0, NULL, NULL),
(59, 'Coaches', '2017-07-30 23:19:52', 'Looking for people to help out with coaching under 12 basketball. Please ensure you have working with children qualifications before applying.', 'Request', 4, 2, 1, 6, '2017-07-31 00:00:00', 0, NULL, NULL),
(60, 'Sausages', '2017-04-13 00:00:00', 'Looking for sausages for a fund raiser', 'Request', 5, 2, 2, 7, '2017-07-31 23:19:52', 1, NULL, NULL),
(61, 'Sausages', '2017-11-10 23:19:52', '10kg of sausages. Please contact for more information.', 'Supplying', 7, 1, 17, 7, '2017-08-15 17:57:22', 1, NULL, NULL),
(62, 'Workers', '2017-04-28 00:00:00', 'Offering to help any organisation in need every Wednesday this month. Ring me on ##########', 'Supplying', 3, 2, NULL, 15, '2017-08-17 23:19:00', 0, NULL, NULL),
(63, 'a', '2017-06-01 12:06:00', 'TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TEST', 'Request', 3, 2, 1, 1, '2017-08-17 23:19:52', 0, NULL, NULL),
(64, 'et', '2017-07-30 23:19:52', 'et', 'Request', 4, 2, 1, 1, '2017-07-17 23:19:52', 0, NULL, NULL),
(65, 'testing', '2017-06-01 01:06:00', 'test', 'Request', 9, 2, 1, 1, '2017-07-17 23:19:52', 0, NULL, NULL),
(66, 'test', '2017-11-10 23:19:52', 'test', 'Request', 7, 0, 1, 1, '2017-07-17 23:19:52', 0, NULL, NULL),
(67, 'test', '2017-07-30 23:19:52', 'test', 'Request', 4, 2, 1, 1, '2017-07-19 15:54:54', 0, NULL, NULL),
(68, 'test', '2017-06-01 01:06:00', 'test', 'Request', 6, 2, 1, 1, '2017-07-17 23:19:52', 0, NULL, NULL),
(69, 'Test', '2017-11-10 23:19:52', 'test', 'Request', 7, 0, 1, 1, '2017-07-17 23:19:52', 0, NULL, NULL),
(70, 'Test', '2017-11-10 23:19:52', 'Test', 'Request', 7, 0, 1, 1, '2017-07-17 23:19:52', 0, NULL, NULL),
(71, 'Test', '2017-06-01 10:06:00', 'Test', 'Request', 9, 2, 1, 1, '2017-07-17 23:19:52', 0, NULL, NULL),
(72, 'test', '2017-06-01 10:06:00', 'test', 'Request', 9, 2, 1, 1, '2017-07-17 23:19:52', 0, NULL, NULL),
(73, 'Coaches', '2017-07-30 23:19:52', 'Looking for people to help out with coaching under 12 basketball. Please ensure you have working with children qualifications before applying.', 'Request', 4, 2, 1, 6, '2017-07-17 23:19:52', 0, NULL, NULL),
(74, 'Sausages', '2017-04-13 00:00:00', 'Looking for sausages for a fund raiser', 'Request', 5, 2, 2, 7, '2017-07-17 23:19:52', 1, NULL, NULL),
(75, 'Sausages', '2017-11-10 23:19:52', '10kg of sausages. Please contact for more information.', 'Supplying', 7, 1, 17, 7, '2017-08-15 17:57:25', 1, NULL, NULL),
(76, 'Workers', '2017-04-28 00:00:00', 'Offering to help any organisation in need every Wednesday this month. Ring me on ##########', 'Supplying', 3, 2, NULL, 15, '2017-07-17 23:19:52', 0, NULL, NULL),
(77, 'a', '2017-06-01 12:06:00', 'TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TEST', 'Request', 6, 2, 1, 1, '2017-07-17 23:19:52', 0, NULL, NULL),
(78, 'et', '2017-06-01 12:06:00', 'et', 'Request', 8, 2, 1, 1, '2017-07-17 23:19:52', 0, NULL, NULL),
(79, 'testing', '2017-06-01 01:06:00', 'test', 'Request', 5, 2, 1, 1, '2017-07-17 23:19:52', 0, NULL, NULL),
(80, 'Sausages', '2017-11-10 23:19:52', '10kg of sausages. Please contact for more information.', 'Supplying', 7, 0, 17, 7, '2017-07-17 23:19:52', 1, NULL, NULL),
(81, 'Workers', '2017-04-28 00:00:00', 'Offering to help any organisation in need every Wednesday this month. Ring me on ##########', 'Supplying', 3, 2, NULL, 15, '2017-07-17 23:19:52', 0, NULL, NULL),
(82, 'testing', '2017-06-01 01:06:00', 'test', 'Request', 6, 2, 1, 1, '2017-07-17 23:19:52', 0, NULL, NULL),
(83, 'test', '2017-06-01 01:06:00', 'test', 'Request', 6, 2, 1, 1, '2017-07-17 23:19:52', 0, NULL, NULL),
(84, 'test', '2017-11-10 23:19:52', 'test', 'Request', 7, 0, 1, 1, '2017-07-17 23:19:52', 0, NULL, NULL),
(85, 'test', '2017-06-01 01:06:00', 'test', 'Request', 6, 2, 1, 1, '2017-07-17 23:19:52', 0, NULL, NULL),
(86, 'Workers', '2017-04-28 00:00:00', 'Offering to help any organisation in need every Wednesday this month. Ring me on ##########', 'Supplying', 3, 2, NULL, 15, '2017-07-17 23:19:52', 0, NULL, NULL),
(87, 'a', '2017-06-01 12:06:00', 'TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TEST', 'Request', 9, 2, 1, 1, '2017-07-17 23:19:52', 0, NULL, NULL),
(88, 'test', '2017-06-01 01:06:00', 'test', 'Request', 5, 2, 1, 1, '2017-07-17 23:19:52', 0, NULL, NULL),
(89, 'Test', '2017-11-10 23:19:52', 'test', 'Request', 7, 0, 1, 1, '2017-07-17 23:19:52', 0, NULL, NULL),
(90, 'test', '2017-11-10 23:19:52', 'test', 'Request', 7, 0, 1, 1, '2017-07-17 23:19:52', 0, NULL, NULL),
(91, 'Sausages', '2017-11-10 23:19:52', '10kg of sausages. Please contact for more information.', 'Supplying', 7, 0, 17, 7, '2017-07-17 23:19:52', 1, NULL, NULL),
(92, 'et', '2017-06-01 12:06:00', 'et', 'Request', 3, 2, 1, 1, '2017-07-17 23:19:52', 0, NULL, NULL),
(94, 'Coaches', '2017-07-30 23:19:52', 'Looking for people to help out with coaching under 12 basketball. Please ensure you have working with children qualifications before applying.', 'Request', 4, 2, 1, 6, '2017-07-17 23:19:52', 0, NULL, NULL),
(95, 'Sausages', '2017-04-13 00:00:00', 'Looking for sausages for a fund raiser', 'Request', 5, 2, 2, 7, '2017-07-17 23:19:52', 1, NULL, NULL),
(96, 'Sausages', '2017-11-10 23:19:52', '10kg of sausages. Please contact for more information.', 'Supplying', 7, 0, 17, 7, '2017-07-17 23:19:52', 1, NULL, NULL),
(97, 'Workers', '2017-04-28 00:00:00', 'Offering to help any organisation in need every Wednesday this month. Ring me on ##########', 'Supplying', 3, 2, NULL, 15, '2017-07-17 23:19:52', 0, NULL, NULL),
(98, 'a', '2017-06-01 12:06:00', 'TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TEST', 'Request', 5, 2, 1, 1, '2017-07-17 23:19:52', 0, NULL, NULL),
(99, 'et', '2017-11-10 23:19:52', 'et', 'Request', 7, 0, 1, 1, '2017-07-17 23:19:52', 0, NULL, NULL),
(100, 'testing', '2017-07-30 23:19:52', 'test', 'Request', 4, 2, 1, 1, '2017-07-17 23:19:52', 0, NULL, NULL),
(101, 'test', '2017-06-01 01:06:00', 'test', 'Request', 5, 2, 1, 1, '2017-07-17 23:19:52', 0, NULL, NULL),
(103, 'test', '2017-06-01 01:06:00', 'test', 'Request', 8, 2, 1, 1, '2017-07-17 23:19:52', 0, NULL, NULL),
(104, 'Test', '2017-11-10 23:19:52', 'test', 'Request', 7, 0, 1, 1, '2017-07-17 23:19:52', 0, NULL, NULL),
(105, 'Test', '2017-11-10 23:19:52', 'Test', 'Request', 7, 0, 1, 1, '2017-07-17 23:19:52', 0, NULL, NULL),
(106, 'Test', '2017-06-01 10:06:00', 'Test', 'Request', 6, 2, 1, 1, '2017-07-17 23:19:52', 0, NULL, NULL),
(107, 'test', '2017-06-01 10:06:00', 'test', 'Request', 5, 2, 1, 1, '2017-07-17 23:19:52', 0, NULL, NULL),
(108, 'Coaches', '2017-07-30 23:19:52', 'Looking for people to help out with coaching under 12 basketball. Please ensure you have working with children qualifications before applying.', 'Request', 4, 2, 1, 6, '2017-07-17 23:19:52', 0, NULL, NULL),
(109, 'Sausages', '2017-04-13 00:00:00', 'Looking for sausages for a fund raiser', 'Request', 5, 2, 2, 7, '2017-07-17 23:19:52', 1, NULL, NULL),
(110, 'Sausages', '2017-11-10 23:19:52', '10kg of sausages. Please contact for more information.', 'Supplying', 7, 0, 17, 7, '2017-07-17 23:19:52', 1, NULL, NULL),
(111, 'Workers', '2017-04-28 00:00:00', 'Offering to help any organisation in need every Wednesday this month. Ring me on ##########', 'Supplying', 3, 2, NULL, 15, '2017-07-17 23:19:52', 0, NULL, NULL),
(112, 'a', '2017-06-01 12:06:00', 'TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TEST', 'Request', 5, 2, 1, 1, '2017-07-17 23:19:52', 0, NULL, NULL),
(113, 'et', '2017-06-01 12:06:00', 'et', 'Request', 9, 2, 1, 1, '2017-07-17 23:19:52', 0, NULL, NULL),
(114, 'testing', '2017-06-01 01:06:00', 'test', 'Request', 9, 2, 1, 1, '2017-07-17 23:19:52', 0, NULL, NULL),
(115, 'Coaches', '2017-07-30 23:19:52', 'Looking for people to help out with coaching under 12 basketball. Please ensure you have working with children qualifications before applying.', 'Request', 4, 2, 1, 6, '2017-07-17 23:19:52', 0, NULL, NULL),
(116, 'Sausages', '2017-04-13 00:00:00', 'Looking for sausages for a fund raiser', 'Request', 5, 2, 2, 7, '2017-07-17 23:19:52', 1, NULL, NULL),
(117, 'Sausages', '2017-11-10 23:19:52', '10kg of sausages. Please contact for more information.', 'Supplying', 7, 0, 17, 7, '2017-07-17 23:19:52', 1, NULL, NULL),
(118, 'Workers', '2017-04-28 00:00:00', 'Offering to help any organisation in need every Wednesday this month. Ring me on ##########', 'Supplying', 3, 2, NULL, 15, '2017-07-17 23:19:52', 0, NULL, NULL),
(119, 'a', '2017-06-01 12:06:00', 'TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TEST', 'Request', 9, 2, 1, 1, '2017-07-17 23:19:52', 0, NULL, NULL),
(120, 'et', '2017-11-10 23:19:52', 'et', 'Request', 7, 0, 1, 1, '2017-07-17 23:19:52', 0, NULL, NULL),
(121, 'testing', '2017-06-01 01:06:00', 'test', 'Request', 5, 2, 1, 1, '2017-07-17 23:19:52', 0, NULL, NULL),
(124, 'test', '2017-06-01 01:06:00', 'test', 'Request', 3, 2, 1, 1, '2017-07-17 23:19:52', 0, NULL, NULL),
(125, 'Test', '2017-06-01 01:06:00', 'test', 'Request', 3, 2, 1, 1, '2017-07-17 23:19:52', 0, NULL, NULL),
(126, 'Test', '2017-07-30 23:19:52', 'Test', 'Request', 4, 2, 1, 1, '2017-07-17 23:19:52', 0, NULL, NULL),
(127, 'Test', '2017-11-10 23:19:52', 'CSS BUG', 'Request', 7, 0, 1, 1, '2017-07-17 23:19:52', 0, NULL, NULL),
(128, 'test', '2017-06-01 10:06:00', 'Better description', 'Request', 6, 2, 1, 1, '2017-07-17 23:19:52', 0, NULL, NULL),
(129, 'Coaches', '2017-07-30 23:19:52', 'Looking for people to help out with coaching under 12 basketball. Please ensure you have working with children qualifications before applying.', 'Request', 4, 2, 1, 6, '2017-07-17 23:19:52', 0, NULL, NULL),
(130, 'Sausages', '2017-04-13 00:00:00', 'Looking for sausages for a fund raiser', 'Request', 5, 2, 2, 7, '2017-07-17 23:19:52', 1, NULL, NULL),
(131, 'Sausages', '2017-11-10 23:19:52', '10kg of sausages. Please contact for more information.', 'Supplying', 7, 0, 17, 7, '2017-07-17 23:19:52', 1, NULL, NULL),
(132, 'Workers', '2017-04-28 00:00:00', 'Offering to help any organisation in need every Wednesday this month. Ring me on ##########', 'Supplying', 3, 2, NULL, 15, '2017-07-17 23:19:52', 0, NULL, NULL),
(133, 'a', '2017-06-01 12:06:00', 'TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TEST', 'Request', 8, 2, 1, 1, '2017-07-17 23:19:52', 0, NULL, NULL),
(134, 'et', '2017-06-01 12:06:00', 'et', 'Request', 3, 2, 1, 1, '2017-07-17 23:19:52', 0, NULL, NULL),
(135, 'testing', '2017-06-01 01:06:00', 'test', 'Request', 5, 2, 1, 1, '2017-07-17 23:19:52', 0, NULL, NULL),
(136, 'Coaches', '2017-07-30 23:19:52', 'Looking for people to help out with coaching under 12 basketball. Please ensure you have working with children qualifications before applying.', 'Request', 4, 2, 1, 6, '2017-07-17 23:19:52', 0, NULL, NULL),
(137, 'Sausages', '2017-04-13 00:00:00', 'Looking for sausages for a fund raiser', 'Request', 5, 2, 2, 7, '2017-07-17 23:19:52', 1, NULL, NULL),
(138, 'Sausages', '2017-11-10 23:19:52', '10kg of sausages. Please contact for more information.', 'Supplying', 7, 0, 17, 7, '2017-07-17 23:19:52', 1, NULL, NULL),
(139, 'Workers', '2017-04-28 00:00:00', 'Offering to help any organisation in need every Wednesday this month. Ring me on ##########', 'Supplying', 3, 2, NULL, 15, '2017-07-17 23:19:52', 0, NULL, NULL),
(140, 'a', '2017-06-01 12:06:00', 'TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TEST', 'Request', 3, 2, 1, 1, '2017-07-17 23:19:52', 0, NULL, NULL),
(141, 'et', '2017-06-01 12:06:00', 'et', 'Request', 6, 2, 1, 1, '2017-07-17 23:19:52', 0, NULL, NULL),
(142, 'testing', '2017-06-01 01:06:00', 'test', 'Request', 3, 2, 1, 1, '2017-07-17 23:19:52', 0, NULL, NULL),
(143, 'test', '2017-07-30 23:19:52', 'test', 'Request', 4, 2, 1, 1, '2017-07-17 23:19:52', 0, NULL, NULL),
(144, 'test', '2017-06-01 01:06:00', 'test', 'Supplying', 8, 2, 1, 1, '2017-07-19 17:43:20', 0, NULL, NULL),
(146, 'Test', '2017-06-01 01:06:00', 'test', 'Request', 8, 2, 1, 1, '2017-07-17 23:19:52', 0, NULL, NULL),
(147, 'Test', '2017-06-01 10:06:00', 'Test', 'Request', 9, 2, 1, 1, '2017-07-17 23:19:52', 0, NULL, NULL),
(148, 'Test', '2017-06-01 10:06:00', 'Test', 'Request', 8, 2, 1, 1, '2017-07-17 23:19:52', 0, NULL, NULL),
(150, 'Coaches', '2017-07-30 23:19:52', 'Looking for people to help out with coaching under 12 basketball. Please ensure you have working with children qualifications before applying.', 'Request', 4, 2, 1, 6, '2017-07-17 23:19:52', 0, NULL, NULL),
(151, 'Sausages', '2017-04-13 00:00:00', 'Looking for sausages for a fund raiser', 'Request', 5, 2, 2, 7, '2017-07-17 23:19:52', 1, NULL, NULL),
(152, 'Sausages', '2017-11-10 23:19:52', '10kg of sausages. Please contact for more information.', 'Supplying', 7, 0, 17, 7, '2017-07-17 23:19:52', 1, NULL, NULL),
(153, 'Workers', '2017-04-28 00:00:00', 'Offering to help any organisation in need every Wednesday this month. Ring me on ##########', 'Supplying', 3, 2, NULL, 15, '2017-07-17 23:19:52', 0, NULL, NULL),
(154, 'a', '2017-11-10 23:19:52', 'TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TEST', 'Request', 7, 0, 1, 1, '2017-07-17 23:19:52', 0, NULL, NULL),
(155, 'et', '2017-06-01 12:06:00', 'et', 'Request', 5, 2, 1, 1, '2017-07-17 23:19:52', 0, NULL, NULL),
(156, 'LAST', '2017-06-01 01:06:00', 'test', 'Request', 8, 2, 1, 1, '2017-07-17 23:19:52', 0, NULL, NULL),
(157, 'NEWTEST', '2017-06-13 02:06:00', 'Internet explorer 11 test', 'Supplying', 6, 2, 1, 4, '2017-07-17 23:19:52', 0, NULL, NULL),
(158, 'IENewItemTest', '2017-06-14 02:06:00', 'IENewItemTest', 'Request', 3, 2, 1, 5, '2017-07-17 23:19:52', 0, NULL, NULL),
(159, 'test', '1970-01-01 01:01:00', 'TEST', 'Request', 5, 2, 1, 1, '2017-07-17 23:19:52', 0, NULL, NULL),
(160, 'test', '1970-01-01 01:01:00', 'EST', 'Request', 6, 2, 1, 1, '2017-07-17 23:19:52', 0, NULL, NULL),
(162, 'TET', '2017-07-30 23:19:52', 'TET', 'Request', 4, 2, 1, 1, '2017-07-17 23:19:52', 0, NULL, NULL),
(163, 'TEST', '2017-11-10 23:19:52', 'TEST', 'Request', 7, 0, 1, 1, '2017-07-17 23:19:52', 0, NULL, NULL),
(167, 'SPA TEST4', '1970-01-01 01:01:00', 'TESTETSTETSTESTSEIHE TSKIEHIKUSHIKUESENSNEIUYSEHIJUYSJEHIUYS EHIJUYSEIJUYSEIJUYHSE', 'Supplying', 8, 2, 1, 1, '2017-07-17 23:19:52', 0, NULL, NULL),
(169, 'SPA TEST FINAL', '1970-01-01 01:01:00', 'TEST', 'Request', 6, 2, 1, 1, '2017-07-17 23:19:52', 0, NULL, NULL),
(170, 'ETET', '1970-01-01 01:01:00', 'TETET', 'Request', 6, 2, 1, 1, '2017-07-17 23:19:52', 0, NULL, NULL),
(172, 'Test Item', '1970-01-01 01:01:00', 'This is a Test', 'Supplying', 9, 2, NULL, 7, '2017-07-17 23:19:52', 1, NULL, NULL),
(173, 'Mobile spa test', '1970-01-01 01:01:00', 'Test', 'Supplying', 6, 2, 1, 5, '2017-07-17 23:19:52', 0, NULL, NULL),
(174, 'TEST', '1970-01-01 01:01:00', 'TEST', 'Request', 6, 2, 1, 1, '2017-07-17 23:19:52', 0, NULL, NULL),
(175, 'TEST', '1970-01-01 01:01:00', 'TEST', 'Request', 8, 2, 1, 1, '2017-07-17 23:19:52', 0, NULL, NULL),
(176, 'TEST1', '2017-07-30 23:19:52', 'TEST1', 'Request', 4, 2, 1, 1, '2017-07-17 23:19:52', 0, NULL, NULL),
(177, 'TEST2', '1970-01-01 01:01:00', 'TEST2', 'Request', 8, 2, 1, 1, '2017-07-17 23:19:52', 0, NULL, NULL),
(178, 'TEST3', '2017-07-30 23:19:52', 'TEST3', 'Request', 4, 2, 1, 1, '2017-07-17 23:19:52', 0, NULL, NULL),
(179, 'TEST4', '1970-01-01 01:01:00', 'TEST4', 'Request', 8, 2, 1, 1, '2017-07-17 23:19:52', 0, NULL, NULL),
(180, 'TEST5', '1970-01-01 01:01:00', 'TEST5', 'Request', 3, 2, 1, 1, '2017-07-17 23:19:52', 0, NULL, NULL),
(181, 'TEST6', '1970-01-01 01:01:00', 'TEST6', 'Request', 5, 2, 1, 1, '2017-07-17 23:19:52', 0, NULL, NULL),
(182, 'TEST7', '1970-01-01 01:01:00', 'TEST7', 'Request', 5, 2, 1, 1, '2017-07-17 23:19:52', 0, NULL, NULL),
(183, 'TEST8', '1970-01-01 01:01:00', 'TEST8', 'Request', 5, 2, 1, 1, '2017-07-17 23:19:52', 0, NULL, NULL),
(185, 'Test', '1970-01-01 01:01:00', 'Test', 'Request', 9, 2, 1, 1, '2017-07-17 23:19:52', 0, NULL, NULL),
(186, 'Test', '1970-01-01 01:01:00', 'Test', 'Request', 5, 2, 1, 1, '2017-07-17 23:19:52', 0, NULL, NULL),
(187, 'New', '1970-01-01 01:01:00', 'New', 'Supplying', 3, 2, 1, 1, '2017-07-17 23:19:52', 0, NULL, NULL),
(188, 'New', '2017-11-10 23:19:52', 'New', 'Request', 7, 0, 1, 1, '2017-07-17 23:19:52', 0, NULL, NULL),
(189, 'New', '1970-01-01 01:01:00', 'New', 'Supplying', 5, 2, 1, 1, '2017-07-17 23:19:52', 0, NULL, NULL),
(190, 'New', '1970-01-01 01:01:00', 'New', 'Supplying', 9, 2, 1, 1, '2017-07-17 23:19:52', 0, NULL, NULL),
(191, 'New', '1970-01-01 01:01:00', 'New', 'Supplying', 5, 2, 1, 1, '2017-07-17 23:19:52', 0, NULL, NULL),
(192, 'Long title test Long title test Long title test Long title test Long title test Long title test Long title test Long title test Long title test ', '2017-07-30 23:19:52', 'Testing', 'Request', 4, 2, 1, 1, '2017-07-17 23:19:52', 0, NULL, NULL),
(193, 'New', '2017-07-30 23:19:52', 'test', 'Supplying', 4, 2, 1, 1, '2017-07-17 23:19:52', 0, NULL, NULL),
(194, 'New', '1970-01-01 01:01:00', 'new', 'Supplying', 3, 2, 1, 1, '2017-07-17 23:19:52', 0, NULL, NULL),
(195, 'Test', '1970-01-01 01:01:00', 'test', 'Request', 8, 2, 1, 1, '2017-07-17 23:19:52', 0, NULL, NULL),
(196, 'TEST', '1970-01-01 01:01:00', 'TESTTIME', 'Request', 8, 2, 1, 1, '2017-07-19 01:23:53', 0, NULL, NULL),
(197, 'TEST', '1970-01-01 01:01:00', 'TEST', 'Request', 8, 2, 1, 1, '2017-07-19 01:25:03', 0, NULL, NULL),
(198, 'TEST', '1970-01-01 01:01:00', 'TEST', 'Request', 8, 2, 1, 1, '2017-07-19 01:27:53', 0, NULL, NULL),
(199, 'TEST', '2017-07-29 01:07:00', 'TEST', 'Request', 8, 2, 1, 1, '2017-07-28 12:26:28', 0, NULL, NULL),
(201, 'TEST', '2017-07-21 12:07:00', 'TESTY', 'Request', 8, 2, 1, 1, '2017-07-19 01:53:35', 0, NULL, NULL),
(202, 'TESTING', '2017-07-22 12:07:00', 'TEST', 'Supplying', 8, 2, 1, 1, '2017-07-22 11:18:35', 0, NULL, NULL),
(205, 'test', '2017-07-19 12:07:00', 'test', 'Request', 8, 2, 12, 1, '2017-07-19 20:51:59', 0, NULL, NULL),
(206, 'test', '2017-07-19 12:07:00', 'test', 'Request', 8, 2, 12, 1, '2017-07-19 20:52:47', 0, NULL, NULL),
(207, 'test', '2017-07-19 12:07:00', 'test', 'Request', 8, 2, 12, 1, '2017-07-19 20:53:44', 0, NULL, NULL),
(208, 'test', '2017-07-19 12:07:00', 'test', 'Request', 8, 2, 12, 1, '2017-07-19 21:01:12', 0, NULL, NULL),
(209, 'test', '2017-07-19 12:07:00', 'test', 'Request', 8, 2, 12, 1, '2017-07-19 21:01:29', 0, NULL, NULL),
(210, 'test', '2017-07-19 12:07:00', 'test', 'Request', 8, 2, 12, 1, '2017-07-19 21:01:59', 0, NULL, NULL),
(211, 'test', '2017-07-19 12:07:00', 'test', 'Request', 8, 2, 12, 1, '2017-07-19 21:02:14', 0, NULL, NULL),
(212, 'test', '2017-07-19 12:07:00', 'test', 'Request', 8, 2, 12, 1, '2017-07-19 21:03:09', 0, NULL, NULL),
(213, 'test', '2017-07-19 12:07:00', 'test', 'Request', 8, 2, 12, 1, '2017-07-19 21:04:43', 0, NULL, NULL),
(215, 'test', '2017-07-19 12:07:00', 'test', 'Request', 8, 2, 12, 1, '2017-07-19 21:13:32', 0, NULL, NULL),
(216, 'test', '2017-07-19 12:07:00', 'tset', 'Request', 8, 2, 12, 1, '2017-07-19 21:13:52', 0, NULL, NULL),
(217, 'TEST NEW', '2017-07-31 12:07:00', 'TEST NEW', 'Supplying', 8, 2, 1, 8, '2017-07-28 11:48:51', 0, NULL, NULL),
(218, 'TEST NEW', '2017-07-31 12:07:00', 'TEST NEW', 'Supplying', 8, 2, 1, 8, '2017-07-28 11:55:43', 1, NULL, NULL),
(220, 'TEST NEW', '2017-07-31 12:07:00', 'TEST NEW', 'Supplying', 8, 2, 1, 7, '2017-07-28 11:59:10', 1, NULL, NULL),
(221, 'TEST NEW', '2017-07-31 12:07:00', 'TEST NEW', 'Supplying', 8, 2, 1, 7, '2017-07-28 11:59:58', 1, 'YMCA Ballarat', NULL),
(222, 'TEST DON\'T LINK ORG', '0000-00-00 00:00:00', 'TESTING', 'Request', 8, 2, 1, 1, '2017-08-05 15:05:06', 1, 'YMCA Ballarat', NULL),
(223, 'a', '2017-07-31 12:07:00', 'a', 'Request', 8, 2, 1, 1, '2017-07-28 12:02:52', 1, 'YMCA Ballarat', NULL),
(224, 'a', '2017-07-31 12:07:00', 'a', 'Request', 8, 2, 1, 1, '2017-07-28 12:04:34', 1, 'YMCA Ballarat', NULL),
(225, 'NEW TEST', '2017-07-28 12:07:00', 'aaaasasa', 'Supplying', 8, 2, NULL, 5, '2017-07-28 12:15:13', 0, NULL, NULL),
(226, 'as', '2017-07-28 12:07:00', 'as', 'Request', 8, 2, 1, 1, '2017-07-28 12:15:24', 0, 'YMCA Ballarat', NULL),
(227, 'a', '2017-07-28 12:07:00', 'a', 'Request', 8, 2, 1, 1, '2017-07-28 12:15:52', 0, NULL, NULL),
(228, 'as', '2017-07-28 12:07:00', 'as', 'Request', 8, 2, NULL, 1, '2017-07-28 12:16:02', 0, NULL, NULL),
(229, 'a', '2017-08-28 12:07:00', 'a', 'Request', 8, 1, NULL, 1, '2017-07-28 14:53:12', 0, NULL, NULL),
(230, 'Organisation owner test', '2017-08-28 12:07:00', 'a', 'Request', 3, 0, 1, 1, '2017-07-28 14:55:03', 0, NULL, NULL),
(231, 'Notification test', '2017-08-04 00:00:00', 'Test', 'Supplying', 5, 2, NULL, 1, '2017-08-02 20:21:46', 0, NULL, NULL),
(232, 'Notification test', '2017-08-15 00:00:00', 'Test', 'Supplying', 8, 2, NULL, 1, '2017-08-02 20:39:44', 0, '7 Lyons St N, Ballarat Central VIC 3350', NULL),
(235, 'Picture upload test', '2017-10-20 01:10:00', 'TESTING', 'Supplying', 8, 0, 1, 1, '2017-08-07 13:21:47', 0, 'Ballarat YMCA, Lyons Street North, Ballarat Central, Victoria, Australia', '235.png'),
(236, 'test', '2017-08-09 05:08:00', 'test', 'Request', 8, 2, NULL, 1, '2017-08-08 17:15:16', 0, 'Null', NULL),
(238, 'test', '2017-08-11 07:08:00', 'test', 'Request', 8, 2, NULL, 1, '2017-08-10 07:59:45', 0, 'Null', NULL),
(239, 'Cleaning Products', '2017-08-23 05:08:00', 'A variety of Cleaning Products are available to anyone who wants them.', 'Supplying', 13, 2, NULL, 11, '2017-08-14 14:24:37', 1, '12 Doveton Street North, Ballarat Central, Victoria, Australia', NULL),
(240, 'A Thing', '2017-08-15 12:08:00', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum commodo ut metus eu gravida. Duis feugiat eget mi sit amet lacinia. Phasellus suscipit tincidunt lorem at aliquam. Quisque posuere sem eget orci ultrices faucibus. Mauris venenatis tellus quis turpis feugiat, et ultricies orci tincidunt. In vel ligula rutrum, placerat arcu sed, facilisis quam. Vestibulum a odio eget diam interdum pellentesque. Aenean quis ipsum lobortis, volutpat magna non, dignissim lorem. Suspendisse id mi eli', 'Supplying', 9, 2, NULL, 10, '2017-08-15 17:41:36', 0, '10 Sturt Street, Ballarat Central, Victoria, Australia', '240.png'),
(241, 'Onions', '2018-07-18 11:07:00', 'Several bags of onions available', 'Supplying', 9, 0, NULL, 7, '2017-08-16 10:41:14', 1, '1 Sturt Street, Ballarat Central, Victoria, Australia', NULL),
(242, 'Clothing', '2017-08-17 10:08:00', 'Clean secondhand baby clothing wanted', 'Request', 9, 2, NULL, 14, '2017-08-16 10:45:05', 0, '1 Sturt Street, Ballarat Central, Victoria, Australia', NULL),
(243, 'A thing of value', '2017-08-23 04:08:00', 'Only one thing get it quick', 'Supplying', 13, 2, NULL, 1, '2017-08-18 16:28:51', 0, '1 Sturt Street, Ballarat Central, Victoria, Australia', NULL),
(244, 'apple', '2017-08-19 05:08:00', 'apple', 'Request', 3, 2, NULL, 1, '2017-08-18 18:05:27', 0, 'Null', NULL),
(245, 'TEST', '2017-08-19 06:08:00', 'TEST', 'Request', 8, 2, NULL, 1, '2017-08-18 18:08:26', 0, '8 Eleanor Drive, Lucas, Victoria, Australia', NULL),
(246, 'TEST', '2017-08-19 06:08:00', 'TEST', 'Request', 8, 2, NULL, 1, '2017-08-18 18:10:14', 0, 'Ararat RSL, 101 High Street, Ararat, Victoria, Australia', NULL),
(247, 'More Things', '2017-09-05 06:09:00', 'Things for supply', 'Supplying', 9, 1, NULL, 8, '2017-08-22 10:14:08', 1, '1813 Sturt Street, Alfredton, Victoria, Australia', NULL),
(248, 'TEST', '2017-08-24 10:08:00', 'TEST', 'Supplying', 8, 2, NULL, 6, '2017-08-22 10:16:10', 1, NULL, NULL),
(249, 'TEST', '2017-08-23 12:08:00', 'TEST', 'Request', 8, 2, NULL, 1, '2017-08-22 12:46:10', 0, 'Null', NULL),
(250, 'TEST', '2017-08-23 12:08:00', 'TEST', 'Request', 8, 2, NULL, 1, '2017-08-22 12:48:39', 0, 'Null', NULL),
(251, 'TEST', '2017-08-23 12:08:00', 'TEST', 'Request', 8, 2, NULL, 1, '2017-08-22 12:56:58', 0, 'Null', NULL),
(252, 'TEST', '2017-08-23 12:08:00', 'TEST', 'Request', 8, 2, NULL, 1, '2017-08-22 12:58:36', 0, 'Null', NULL),
(253, 'TEST', '2017-08-23 12:08:00', 'TEST', 'Request', 8, 2, NULL, 1, '2017-08-22 12:58:49', 0, 'Null', NULL),
(254, 'TEST', '2017-08-23 01:08:00', 'TEST', 'Request', 8, 2, NULL, 1, '2017-08-22 13:29:40', 0, 'Null', NULL),
(255, 'test', '2017-08-23 01:08:00', 'TEST', 'Request', 8, 2, NULL, 1, '2017-08-22 13:34:32', 0, 'Null', NULL),
(256, 'test', '2017-08-23 01:08:00', 'test', 'Request', 8, 2, NULL, 1, '2017-08-22 13:35:46', 0, 'Null', NULL),
(257, 'test', '2017-08-23 01:08:00', 'test', 'Request', 8, 2, NULL, 1, '2017-08-22 13:39:39', 0, 'Null', NULL),
(258, 'test', '2017-08-23 01:08:00', 'test', 'Request', 8, 2, NULL, 1, '2017-08-22 13:40:12', 0, 'Null', NULL),
(259, 'test', '2017-08-23 01:08:00', 'test', 'Request', 8, 2, NULL, 1, '2017-08-22 13:40:47', 0, 'Null', NULL),
(260, 'test', '2017-08-23 01:08:00', 'test', 'Request', 8, 2, NULL, 1, '2017-08-22 13:45:33', 0, 'Null', NULL),
(261, 'test', '2017-08-23 01:08:00', 'test', 'Request', 8, 2, NULL, 1, '2017-08-22 13:46:34', 0, 'Null', NULL),
(262, 'test', '2017-08-23 01:08:00', 'test', 'Request', 8, 2, NULL, 1, '2017-08-22 13:49:53', 0, 'Null', NULL),
(263, 'Test item', '2017-08-23 02:08:00', 'testing email send', 'Request', 8, 2, NULL, 1, '2017-08-22 14:07:56', 0, 'Null', NULL),
(264, 'TEST', '2017-08-23 02:08:00', 'TESTING', 'Request', 8, 2, NULL, 1, '2017-08-22 14:09:42', 0, 'Null', NULL),
(265, 'test', '2017-08-23 02:08:00', 'test', 'Request', 8, 2, NULL, 1, '2017-08-22 14:11:58', 0, 'Null', NULL),
(266, 'test', '2017-08-23 02:08:00', 'test', 'Request', 8, 2, NULL, 1, '2017-08-22 14:12:33', 0, 'Null', NULL),
(267, 'test', '2017-08-23 02:08:00', 'test', 'Request', 8, 2, NULL, 1, '2017-08-22 14:13:00', 0, 'Null', NULL),
(268, 'test', '2017-08-23 02:08:00', 'test', 'Request', 8, 2, NULL, 1, '2017-08-22 14:14:10', 0, 'Null', NULL),
(269, 'test', '2017-08-23 02:08:00', 'test', 'Request', 8, 2, NULL, 1, '2017-08-22 14:16:24', 0, 'Null', NULL),
(270, 'test', '2017-08-23 02:08:00', 'test', 'Request', 8, 2, NULL, 1, '2017-08-22 14:17:35', 0, 'Null', NULL),
(271, 'test', '2017-08-23 02:08:00', 'test', 'Request', 8, 2, NULL, 1, '2017-08-22 14:20:50', 0, 'Null', NULL),
(272, 'test', '2017-08-23 02:08:00', 'test', 'Request', 8, 2, NULL, 1, '2017-08-22 14:22:02', 0, 'Null', NULL),
(273, 'test', '2017-08-23 02:08:00', 'test', 'Request', 8, 2, NULL, 1, '2017-08-22 14:31:17', 0, 'Null', NULL),
(274, 'test', '2017-08-23 02:08:00', 'test', 'Request', 8, 2, NULL, 1, '2017-08-22 14:38:24', 0, 'Null', NULL),
(275, 'test', '2017-08-23 02:08:00', 'test', 'Request', 8, 2, NULL, 1, '2017-08-22 14:44:13', 0, 'Null', NULL),
(276, 'test', '2017-08-23 02:08:00', 'test', 'Request', 8, 2, NULL, 1, '2017-08-22 14:45:17', 0, 'Null', NULL),
(277, 'test', '2017-08-23 02:08:00', 'test', 'Request', 8, 2, NULL, 1, '2017-08-22 14:46:02', 0, 'Null', NULL),
(278, 'test', '2017-08-23 02:08:00', 'test', 'Request', 8, 2, NULL, 1, '2017-08-22 14:46:57', 0, 'Null', NULL),
(279, 'test', '2017-08-23 02:08:00', 'test', 'Request', 8, 2, NULL, 1, '2017-08-22 14:47:32', 0, 'Null', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

DROP TABLE IF EXISTS `notification`;
CREATE TABLE IF NOT EXISTS `notification` (
  `NotificationID` int(11) NOT NULL AUTO_INCREMENT,
  `FKClient` int(11) NOT NULL,
  `FKTag` int(11) NOT NULL,
  PRIMARY KEY (`NotificationID`),
  KEY `FKClientID` (`FKClient`),
  KEY `FKTagID` (`FKTag`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `notification`
--

INSERT INTO `notification` (`NotificationID`, `FKClient`, `FKTag`) VALUES
(4, 7, 8),
(6, 7, 13),
(8, 7, 5),
(11, 7, 1),
(12, 7, 7),
(13, 7, 10);

-- --------------------------------------------------------

--
-- Table structure for table `organisation`
--

DROP TABLE IF EXISTS `organisation`;
CREATE TABLE IF NOT EXISTS `organisation` (
  `groupID` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `Information` varchar(10000) DEFAULT NULL,
  `currentNews` varchar(2000) DEFAULT NULL,
  `address` varchar(300) DEFAULT NULL,
  PRIMARY KEY (`groupID`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `organisation`
--

INSERT INTO `organisation` (`groupID`, `name`, `Information`, `currentNews`, `address`) VALUES
(1, 'YMCA Ballarat', '(03) 5329 2800 ballarat.hr@ymca.org.au', 'TESTING CURRENT NEWS TESTING CURRENT NEWS TESTING CURRENT NEWS TESTING CURRENT NEWS TESTING CURRENT NEWS TESTING CURRENT NEWS.', 'YMCA Ballarat'),
(2, 'Ballarat Health Services', 'https://www.bhs.org.au/how-we-can-help', NULL, 'Ballarat Health Services'),
(3, 'Uniting Care Ballarat', '105 Dana Street PO Box 608 Ballarat VIC 3353 Phone 03 5332 1286', NULL, 'Uniting Care Ballarat'),
(4, 'Southern Cross Care', 'https://www.sccv.org.au/contact-us-(1)', NULL, 'Southern Cross Care'),
(5, 'Salvation Army', 'Major Volunteer Organisation provides multiple community services.', NULL, 'Salvation Army'),
(6, 'Ballarat Wildlife Park', 'http://wildlifepark.com.au/', NULL, 'Ballarat Wildlife Park'),
(7, 'Conservation Volunteers Australia', 'http://conservationvolunteers.com.au/contact-us/office-locations/victoria/ballarat/', NULL, 'Conservation Volunteers Australia'),
(10, 'Ballarat Autism Network', 'http://www.ballaratautism.com/', NULL, 'Ballarat Autism Network'),
(12, 'Ballarat Headspace', 'https://headspace.org.au/headspace-centres/ballarat/', NULL, 'Ballarat Headspace'),
(13, 'Ballarat Tramway Museum', 'http://btm.org.au', NULL, 'Ballarat Tramway Museum'),
(14, 'Soup Bus Ballarat', 'http://www.soupbus.com.au/index.asp', NULL, 'Soup Bus Ballarat'),
(15, 'Food is Free Laneway', 'https://www.facebook.com/foodisfreelanewayballarat/', NULL, 'Food is Free Laneway'),
(16, 'Meals on Wheels', 'http://www.ballarat.vic.gov.au/pc/seniors/in-home-support/meals-on-wheels.aspx', NULL, 'Meals on Wheels'),
(17, 'Harvest Ministry of Food', 'http://harvestministryoffood.com/', NULL, 'Harvest Ministry of Food'),
(18, 'Breezeway Meals Program', 'http://www.unitingcareballarat.com.au/services/breezeway-meals-program', NULL, 'Breezeway Meals Program'),
(19, 'Peplow House', 'https://www.centacareballarat.org.au/services/homelessness-support/peplow-house-crisis-and-transitional/', NULL, 'Peplow House'),
(20, 'Parent Place', 'http://www.ballarat.vic.gov.au/pc/family-and-children/parent-place.aspx', NULL, 'Parent Place'),
(21, 'The Tipping Foundation', 'https://www.tipping.org.au/', NULL, 'The Tipping Foundation'),
(22, 'Ballarat Sports Clubs', 'http://www.ballarat.vic.gov.au/lae/sports/sporting-groups.aspx', NULL, 'Ballarat Sports Clubs'),
(23, 'Eureka Mums', 'http://www.eurekamums.org/', NULL, 'Eureka Mums'),
(24, 'Connection Youth Mentoring (CAFS)', 'https://cafs.org.au/', NULL, 'Connection Youth Mentoring (CAFS)'),
(25, 'AIME Mentoring', 'http://www.aimementoring.com/', NULL, 'AIME Mentoring'),
(26, 'RSPCA Victoria', '115A Gillies St S\r\n(03) 5334 2075\r\nhttp://www.rspcavic.org/about-us/pets-place', NULL, 'RSPCA Victoria'),
(27, 'Art Gallery of Ballarat', 'https://artgalleryofballarat.com.au/support/volunteer/', NULL, 'Art Gallery of Ballarat'),
(28, 'Senior Citizens Clubs', 'http://www.ballarat.vic.gov.au/pc/community-directory.aspx?Parent=110202&Child=110203', NULL, 'Senior Citizens Clubs'),
(29, 'Ballarat Community Garden', 'http://ballaratcommunitygarden.org.au/contact-us/', NULL, 'Ballarat Community Garden');

-- --------------------------------------------------------

--
-- Table structure for table `tag`
--

DROP TABLE IF EXISTS `tag`;
CREATE TABLE IF NOT EXISTS `tag` (
  `tagID` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`tagID`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tag`
--

INSERT INTO `tag` (`tagID`, `name`) VALUES
(1, 'Other'),
(4, 'Gardening'),
(5, 'Towels/Blankets'),
(6, 'Sports'),
(7, 'Food'),
(8, 'Drinks'),
(9, 'Catering'),
(10, 'Furniture'),
(11, 'Cleaning'),
(12, 'Books'),
(13, 'Toys'),
(14, 'Baby goods'),
(15, 'Workers');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `client`
--
ALTER TABLE `client`
  ADD CONSTRAINT `FKGroup` FOREIGN KEY (`FKgroup`) REFERENCES `organisation` (`groupID`);

--
-- Constraints for table `emailqueue`
--
ALTER TABLE `emailqueue`
  ADD CONSTRAINT `itemNumber` FOREIGN KEY (`itemNumber`) REFERENCES `item` (`itemID`);

--
-- Constraints for table `item`
--
ALTER TABLE `item`
  ADD CONSTRAINT `FKClient` FOREIGN KEY (`FKclient`) REFERENCES `client` (`clientID`),
  ADD CONSTRAINT `FKGroupID` FOREIGN KEY (`organisation`) REFERENCES `organisation` (`groupID`),
  ADD CONSTRAINT `item_ibfk_1` FOREIGN KEY (`FKTagID`) REFERENCES `tag` (`tagID`);

--
-- Constraints for table `notification`
--
ALTER TABLE `notification`
  ADD CONSTRAINT `FKClientID` FOREIGN KEY (`FKClient`) REFERENCES `client` (`clientID`),
  ADD CONSTRAINT `FKTagID` FOREIGN KEY (`FKTag`) REFERENCES `tag` (`tagID`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
