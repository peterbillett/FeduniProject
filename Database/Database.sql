-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 17, 2017 at 04:28 PM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 7.1.1

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `project01`
--
DROP DATABASE IF EXISTS `project01`;
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
  `clientPassword` varchar(50) NOT NULL,
  `FKgroup` int(11) DEFAULT NULL,
  `lastSeen` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`clientID`),
  UNIQUE KEY `ClientID` (`clientID`),
  KEY `FKgroup` (`FKgroup`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `client`
--

INSERT INTO `client` (`clientID`, `clientFirstName`, `clientLastName`, `email`, `clientPassword`, `FKgroup`, `lastSeen`) VALUES
(3, 'Gerard', 'May', 'gerdington@gmail.com', 'password', NULL, '2017-07-17 23:13:59'),
(4, 'Tim', 'Russell', 'timjarussell@gmail.com', '5f4dcc3b5aa765d61d8327deb882cf99', 1, '2017-07-17 23:13:59'),
(5, 'Tim', 'McKnight', 'tmcknight@gmail.com', '5f4dcc3b5aa765d61d8327deb882cf99', 2, '2017-07-17 23:13:59'),
(6, 'Baljit', 'Kaur', 'kaurbaljit046@gmail.com', '5f4dcc3b5aa765d61d8327deb882cf99', 10, '2017-07-17 23:13:59'),
(7, 'Peter', 'Billett', 'peterbillettsemail@gmail.com', '5f4dcc3b5aa765d61d8327deb882cf99', 17, '2017-07-17 23:13:59'),
(8, 'Test', 'Test', 'test@test.com', 'password', 1, '2017-07-18 00:28:21'),
(9, 'red', 'red', 'red@red.net', 'redalbert1', NULL, '2017-07-17 23:13:59'),
(10, 'New', 'New', 'new@new.com', 'password', 34, '2017-07-17 23:13:59');

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
  PRIMARY KEY (`itemID`),
  KEY `FKClient` (`FKclient`),
  KEY `FKGroupID` (`organisation`),
  KEY `FKTagID` (`FKTagID`)
) ENGINE=InnoDB AUTO_INCREMENT=196 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `item`
--

INSERT INTO `item` (`itemID`, `name`, `endtime`, `description`, `category`, `FKclient`, `finished`, `organisation`, `FKTagID`, `lastModifiedTime`) VALUES
(3, 'Coaches', '2017-04-14 00:00:00', 'Looking for people to help out with coaching under 12 basketball. Please ensure you have working with children qualifications before applying.', 'Request', 4, 2, 1, 6, '2017-08-17 23:21:55'),
(4, 'Sausages', '2017-04-13 00:00:00', 'Looking for sausages for a fund raiser', 'Request', 5, 2, 2, 7, '2017-08-17 23:19:52'),
(5, 'Sausages', '2017-04-10 00:00:00', '10kg of sausages. Please contact for more information.', 'Supplying', 7, 2, 17, 7, '2017-07-17 23:19:52'),
(6, 'Workers', '2017-04-28 00:00:00', 'Offering to help any organisation in need every Wednesday this month. Ring me on ##########', 'Supplying', 3, 2, NULL, 15, '2017-07-17 23:19:52'),
(14, 'New name ', '2017-06-01 12:06:00', 'New description ', 'Supplying', 8, 2, 1, 1, '2017-07-17 23:19:52'),
(15, 'TESTa', '2017-06-01 12:06:00', 'et', 'Request', 8, 2, 1, 1, '2017-07-17 23:19:52'),
(17, 'testaaaa', '2017-06-01 01:06:00', 'as', 'Request', 8, 2, 1, 1, '2017-07-17 23:19:52'),
(18, 'testa', '2017-06-01 01:06:00', 'testa', 'Request', 8, 2, 1, 1, '2017-07-17 23:19:52'),
(20, 'Testa', '2017-06-01 01:06:00', 'test', 'Request', 8, 2, 1, 1, '2017-07-17 23:19:52'),
(22, 'Test0', '2017-06-01 10:06:00', 'Test0', 'Supplying', 8, 2, 1, 1, '2017-07-17 23:19:52'),
(23, 'test', '2017-06-01 10:06:00', 'test', 'Request', 8, 2, 1, 1, '2017-07-17 23:19:52'),
(24, 'Coaches', '2018-04-14 00:00:00', 'Looking for people to help out with coaching under 12 basketball. Please ensure you have working with children qualifications before applying.', 'Request', 4, 1, 1, 6, '2017-07-17 23:19:52'),
(25, 'Sausages', '2017-10-13 00:00:00', 'Looking for sausages for a fund raiser', 'Request', 5, 1, 2, 7, '2017-07-17 23:19:52'),
(26, 'Sausages', '2017-09-10 00:00:00', '10kg of sausages. Please contact for more information.', 'Supplying', 7, 1, 17, 7, '2017-07-17 23:19:52'),
(27, 'Workers', '2017-08-28 00:00:00', 'Offering to help any organisation in need every Wednesday this month. Ring me on ##########', 'Supplying', 3, 1, NULL, 15, '2017-07-17 23:19:52'),
(28, 'a', '2017-06-01 12:06:00', 'TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TEST', 'Request', 8, 2, 1, 1, '2017-07-17 23:19:52'),
(29, 'Testtesttest', '2017-07-30 12:06:00', 'etsgsgswhwjbwdbdb', 'Request', 8, 1, 1, 1, '2017-07-17 23:19:52'),
(30, 'testing', '2017-06-01 01:06:00', 'test', 'Request', 8, 2, 1, 1, '2017-07-17 23:19:52'),
(31, 'test', '2017-06-01 01:06:00', 'test', 'Request', 8, 2, 1, 1, '2017-07-17 23:19:52'),
(32, 'test', '2017-06-01 01:06:00', 'test', 'Request', 8, 2, 1, 1, '2017-07-17 23:19:52'),
(33, 'test', '2017-06-01 01:06:00', 'test', 'Request', 8, 2, 1, 1, '2017-07-17 23:19:52'),
(34, 'Test', '2017-06-01 01:06:00', 'test', 'Request', 8, 2, 1, 1, '2017-07-17 23:19:52'),
(35, 'Test', '2017-00-15 10:06:00', 'Test', 'Request', 8, 2, 1, 1, '2017-08-17 23:19:52'),
(36, 'Test', '2017-07-13 10:06:00', 'Test', 'Request', 8, 2, 1, 1, '2017-07-17 23:19:52'),
(37, 'test', '2017-08-01 10:06:00', 'test', 'Request', 8, 0, 1, 1, '2017-07-17 23:19:52'),
(38, 'Coaches', '2017-04-14 00:00:00', 'Looking for people to help out with coaching under 12 basketball. Please ensure you have working with children qualifications before applying.', 'Request', 4, 2, 1, 6, '2017-07-17 23:19:52'),
(39, 'Sausages', '2017-04-13 00:00:00', 'Looking for sausages for a fund raiser', 'Request', 5, 2, 2, 7, '2017-07-17 23:19:52'),
(40, 'Sausages', '2017-04-10 00:00:00', '10kg of sausages. Please contact for more information.', 'Supplying', 7, 2, 17, 7, '2017-07-17 23:19:52'),
(41, 'Workers', '2017-04-28 00:00:00', 'Offering to help any organisation in need every Wednesday this month. Ring me on ##########', 'Supplying', 3, 2, NULL, 15, '2017-07-17 23:19:52'),
(42, 'a', '2017-06-01 12:06:00', 'TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TEST', 'Request', 8, 2, 1, 1, '2017-07-17 23:19:52'),
(43, 'et', '2017-06-01 12:06:00', 'et', 'Request', 8, 2, 1, 1, '2017-07-17 23:19:52'),
(44, 'testing', '2017-06-01 01:06:00', 'test', 'Request', 8, 2, 1, 1, '2017-07-17 23:19:52'),
(45, 'test', '2017-06-01 01:06:00', 'test', 'Request', 8, 2, 1, 1, '2017-07-17 23:19:52'),
(46, 'test', '2017-06-01 01:06:00', 'test', 'Request', 8, 2, 1, 1, '2017-07-17 23:19:52'),
(47, 'test', '2017-06-01 01:06:00', 'test', 'Request', 8, 2, 1, 1, '2017-07-17 23:19:52'),
(48, 'Test', '2017-06-01 01:06:00', 'test', 'Request', 8, 2, 1, 1, '2017-07-17 23:19:52'),
(49, 'Test', '2017-06-01 10:06:00', 'Test', 'Supplying', 8, 2, 1, 1, '2017-07-17 23:19:52'),
(50, 'Test', '2017-06-01 10:06:00', 'Test', 'Supplying', 8, 2, 1, 1, '2017-07-17 23:19:52'),
(52, 'Coaches', '2017-04-14 00:00:00', 'Looking for people to help out with coaching under 12 basketball. Please ensure you have working with children qualifications before applying.', 'Supplying', 4, 2, 1, 6, '2017-07-17 23:19:52'),
(53, 'Sausages', '2017-04-13 00:00:00', 'Looking for sausages for a fund raiser', 'Supplying', 5, 2, 2, 7, '2017-07-17 23:19:52'),
(54, 'Sausages', '2017-04-10 00:00:00', '10kg of sausages. Please contact for more information.', 'Supplying', 7, 2, 17, 7, '2017-07-17 23:19:52'),
(55, 'Workers', '2017-04-28 00:00:00', 'Offering to help any organisation in need every Wednesday this month. Ring me on ##########', 'Supplying', 3, 2, NULL, 15, '2017-07-17 23:19:52'),
(56, 'a', '2017-06-01 12:06:00', 'TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TEST', 'Supplying', 8, 2, 1, 1, '2017-07-17 23:19:52'),
(59, 'Coaches', '2017-04-14 00:00:00', 'Looking for people to help out with coaching under 12 basketball. Please ensure you have working with children qualifications before applying.', 'Request', 4, 2, 1, 6, '2017-07-17 23:19:52'),
(60, 'Sausages', '2017-04-13 00:00:00', 'Looking for sausages for a fund raiser', 'Request', 5, 2, 2, 7, '2017-07-17 23:19:52'),
(61, 'Sausages', '2017-04-10 00:00:00', '10kg of sausages. Please contact for more information.', 'Supplying', 7, 2, 17, 7, '2017-07-17 23:19:52'),
(62, 'Workers', '2017-04-28 00:00:00', 'Offering to help any organisation in need every Wednesday this month. Ring me on ##########', 'Supplying', 3, 2, NULL, 15, '2017-07-17 23:19:52'),
(63, 'a', '2017-06-01 12:06:00', 'TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TEST', 'Request', 8, 2, 1, 1, '2017-07-17 23:19:52'),
(64, 'et', '2017-06-01 12:06:00', 'et', 'Request', 8, 2, 1, 1, '2017-07-17 23:19:52'),
(65, 'testing', '2017-06-01 01:06:00', 'test', 'Request', 8, 2, 1, 1, '2017-07-17 23:19:52'),
(66, 'test', '2017-06-01 01:06:00', 'test', 'Request', 8, 2, 1, 1, '2017-07-17 23:19:52'),
(67, 'test', '2017-06-01 01:06:00', 'test', 'Request', 8, 2, 1, 1, '2017-07-17 23:19:52'),
(68, 'test', '2017-06-01 01:06:00', 'test', 'Request', 8, 2, 1, 1, '2017-07-17 23:19:52'),
(69, 'Test', '2017-06-01 01:06:00', 'test', 'Request', 8, 2, 1, 1, '2017-07-17 23:19:52'),
(70, 'Test', '2017-06-01 10:06:00', 'Test', 'Request', 8, 2, 1, 1, '2017-07-17 23:19:52'),
(71, 'Test', '2017-06-01 10:06:00', 'Test', 'Request', 8, 2, 1, 1, '2017-07-17 23:19:52'),
(72, 'test', '2017-06-01 10:06:00', 'test', 'Request', 8, 2, 1, 1, '2017-07-17 23:19:52'),
(73, 'Coaches', '2017-04-14 00:00:00', 'Looking for people to help out with coaching under 12 basketball. Please ensure you have working with children qualifications before applying.', 'Request', 4, 2, 1, 6, '2017-07-17 23:19:52'),
(74, 'Sausages', '2017-04-13 00:00:00', 'Looking for sausages for a fund raiser', 'Request', 5, 2, 2, 7, '2017-07-17 23:19:52'),
(75, 'Sausages', '2017-04-10 00:00:00', '10kg of sausages. Please contact for more information.', 'Supplying', 7, 2, 17, 7, '2017-07-17 23:19:52'),
(76, 'Workers', '2017-04-28 00:00:00', 'Offering to help any organisation in need every Wednesday this month. Ring me on ##########', 'Supplying', 3, 2, NULL, 15, '2017-07-17 23:19:52'),
(77, 'a', '2017-06-01 12:06:00', 'TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TEST', 'Request', 8, 2, 1, 1, '2017-07-17 23:19:52'),
(78, 'et', '2017-06-01 12:06:00', 'et', 'Request', 8, 2, 1, 1, '2017-07-17 23:19:52'),
(79, 'testing', '2017-06-01 01:06:00', 'test', 'Request', 8, 2, 1, 1, '2017-07-17 23:19:52'),
(80, 'Sausages', '2017-04-10 00:00:00', '10kg of sausages. Please contact for more information.', 'Supplying', 7, 2, 17, 7, '2017-07-17 23:19:52'),
(81, 'Workers', '2017-04-28 00:00:00', 'Offering to help any organisation in need every Wednesday this month. Ring me on ##########', 'Supplying', 3, 2, NULL, 15, '2017-07-17 23:19:52'),
(82, 'testing', '2017-06-01 01:06:00', 'test', 'Request', 8, 2, 1, 1, '2017-07-17 23:19:52'),
(83, 'test', '2017-06-01 01:06:00', 'test', 'Request', 8, 2, 1, 1, '2017-07-17 23:19:52'),
(84, 'test', '2017-06-01 01:06:00', 'test', 'Request', 8, 2, 1, 1, '2017-07-17 23:19:52'),
(85, 'test', '2017-06-01 01:06:00', 'test', 'Request', 8, 2, 1, 1, '2017-07-17 23:19:52'),
(86, 'Workers', '2017-04-28 00:00:00', 'Offering to help any organisation in need every Wednesday this month. Ring me on ##########', 'Supplying', 3, 2, NULL, 15, '2017-07-17 23:19:52'),
(87, 'a', '2017-06-01 12:06:00', 'TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TEST', 'Request', 8, 2, 1, 1, '2017-07-17 23:19:52'),
(88, 'test', '2017-06-01 01:06:00', 'test', 'Request', 8, 2, 1, 1, '2017-07-17 23:19:52'),
(89, 'Test', '2017-06-01 01:06:00', 'test', 'Request', 8, 2, 1, 1, '2017-07-17 23:19:52'),
(90, 'test', '2017-06-01 10:06:00', 'test', 'Request', 8, 2, 1, 1, '2017-07-17 23:19:52'),
(91, 'Sausages', '2017-04-10 00:00:00', '10kg of sausages. Please contact for more information.', 'Supplying', 7, 2, 17, 7, '2017-07-17 23:19:52'),
(92, 'et', '2017-06-01 12:06:00', 'et', 'Request', 8, 2, 1, 1, '2017-07-17 23:19:52'),
(93, 'test', '2017-06-01 01:06:00', 'test', 'Request', 8, 2, 1, 1, '2017-07-17 23:19:52'),
(94, 'Coaches', '2017-04-14 00:00:00', 'Looking for people to help out with coaching under 12 basketball. Please ensure you have working with children qualifications before applying.', 'Request', 4, 2, 1, 6, '2017-07-17 23:19:52'),
(95, 'Sausages', '2017-04-13 00:00:00', 'Looking for sausages for a fund raiser', 'Request', 5, 2, 2, 7, '2017-07-17 23:19:52'),
(96, 'Sausages', '2017-04-10 00:00:00', '10kg of sausages. Please contact for more information.', 'Supplying', 7, 2, 17, 7, '2017-07-17 23:19:52'),
(97, 'Workers', '2017-04-28 00:00:00', 'Offering to help any organisation in need every Wednesday this month. Ring me on ##########', 'Supplying', 3, 2, NULL, 15, '2017-07-17 23:19:52'),
(98, 'a', '2017-06-01 12:06:00', 'TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TEST', 'Request', 8, 2, 1, 1, '2017-07-17 23:19:52'),
(99, 'et', '2017-06-01 12:06:00', 'et', 'Request', 8, 2, 1, 1, '2017-07-17 23:19:52'),
(100, 'testing', '2017-06-01 01:06:00', 'test', 'Request', 8, 2, 1, 1, '2017-07-17 23:19:52'),
(101, 'test', '2017-06-01 01:06:00', 'test', 'Request', 8, 2, 1, 1, '2017-07-17 23:19:52'),
(102, 'test', '2017-06-01 01:06:00', 'test', 'Request', 8, 2, 1, 1, '2017-07-17 23:19:52'),
(103, 'test', '2017-06-01 01:06:00', 'test', 'Request', 8, 2, 1, 1, '2017-07-17 23:19:52'),
(104, 'Test', '2017-06-01 01:06:00', 'test', 'Request', 8, 2, 1, 1, '2017-07-17 23:19:52'),
(105, 'Test', '2017-06-01 10:06:00', 'Test', 'Request', 8, 2, 1, 1, '2017-07-17 23:19:52'),
(106, 'Test', '2017-06-01 10:06:00', 'Test', 'Request', 8, 2, 1, 1, '2017-07-17 23:19:52'),
(107, 'test', '2017-06-01 10:06:00', 'test', 'Request', 8, 2, 1, 1, '2017-07-17 23:19:52'),
(108, 'Coaches', '2017-04-14 00:00:00', 'Looking for people to help out with coaching under 12 basketball. Please ensure you have working with children qualifications before applying.', 'Request', 4, 2, 1, 6, '2017-07-17 23:19:52'),
(109, 'Sausages', '2017-04-13 00:00:00', 'Looking for sausages for a fund raiser', 'Request', 5, 2, 2, 7, '2017-07-17 23:19:52'),
(110, 'Sausages', '2017-04-10 00:00:00', '10kg of sausages. Please contact for more information.', 'Supplying', 7, 2, 17, 7, '2017-07-17 23:19:52'),
(111, 'Workers', '2017-04-28 00:00:00', 'Offering to help any organisation in need every Wednesday this month. Ring me on ##########', 'Supplying', 3, 2, NULL, 15, '2017-07-17 23:19:52'),
(112, 'a', '2017-06-01 12:06:00', 'TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TEST', 'Request', 8, 2, 1, 1, '2017-07-17 23:19:52'),
(113, 'et', '2017-06-01 12:06:00', 'et', 'Request', 8, 2, 1, 1, '2017-07-17 23:19:52'),
(114, 'testing', '2017-06-01 01:06:00', 'test', 'Request', 8, 2, 1, 1, '2017-07-17 23:19:52'),
(115, 'Coaches', '2017-04-14 00:00:00', 'Looking for people to help out with coaching under 12 basketball. Please ensure you have working with children qualifications before applying.', 'Request', 4, 2, 1, 6, '2017-07-17 23:19:52'),
(116, 'Sausages', '2017-04-13 00:00:00', 'Looking for sausages for a fund raiser', 'Request', 5, 2, 2, 7, '2017-07-17 23:19:52'),
(117, 'Sausages', '2017-04-10 00:00:00', '10kg of sausages. Please contact for more information.', 'Supplying', 7, 2, 17, 7, '2017-07-17 23:19:52'),
(118, 'Workers', '2017-04-28 00:00:00', 'Offering to help any organisation in need every Wednesday this month. Ring me on ##########', 'Supplying', 3, 2, NULL, 15, '2017-07-17 23:19:52'),
(119, 'a', '2017-06-01 12:06:00', 'TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TEST', 'Request', 8, 2, 1, 1, '2017-07-17 23:19:52'),
(120, 'et', '2017-06-01 12:06:00', 'et', 'Request', 8, 2, 1, 1, '2017-07-17 23:19:52'),
(121, 'testing', '2017-06-01 01:06:00', 'test', 'Request', 8, 2, 1, 1, '2017-07-17 23:19:52'),
(122, 'test', '2017-06-01 01:06:00', 'test', 'Request', 8, 2, 1, 1, '2017-07-17 23:19:52'),
(123, 'test', '2017-06-01 01:06:00', 'test', 'Request', 8, 2, 1, 1, '2017-07-17 23:19:52'),
(124, 'test', '2017-06-01 01:06:00', 'test', 'Request', 8, 2, 1, 1, '2017-07-17 23:19:52'),
(125, 'Test', '2017-06-01 01:06:00', 'test', 'Request', 8, 2, 1, 1, '2017-07-17 23:19:52'),
(126, 'Test', '2017-06-01 10:06:00', 'Test', 'Request', 8, 2, 1, 1, '2017-07-17 23:19:52'),
(127, 'Test', '2017-06-01 10:06:00', 'CSS BUG', 'Request', 8, 2, 1, 1, '2017-07-17 23:19:52'),
(128, 'test', '2017-06-01 10:06:00', 'Better description', 'Request', 8, 2, 1, 1, '2017-07-17 23:19:52'),
(129, 'Coaches', '2017-04-14 00:00:00', 'Looking for people to help out with coaching under 12 basketball. Please ensure you have working with children qualifications before applying.', 'Request', 4, 2, 1, 6, '2017-07-17 23:19:52'),
(130, 'Sausages', '2017-04-13 00:00:00', 'Looking for sausages for a fund raiser', 'Request', 5, 2, 2, 7, '2017-07-17 23:19:52'),
(131, 'Sausages', '2017-04-10 00:00:00', '10kg of sausages. Please contact for more information.', 'Supplying', 7, 2, 17, 7, '2017-07-17 23:19:52'),
(132, 'Workers', '2017-04-28 00:00:00', 'Offering to help any organisation in need every Wednesday this month. Ring me on ##########', 'Supplying', 3, 2, NULL, 15, '2017-07-17 23:19:52'),
(133, 'a', '2017-06-01 12:06:00', 'TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TEST', 'Request', 8, 2, 1, 1, '2017-07-17 23:19:52'),
(134, 'et', '2017-06-01 12:06:00', 'et', 'Request', 8, 2, 1, 1, '2017-07-17 23:19:52'),
(135, 'testing', '2017-06-01 01:06:00', 'test', 'Request', 8, 2, 1, 1, '2017-07-17 23:19:52'),
(136, 'Coaches', '2017-04-14 00:00:00', 'Looking for people to help out with coaching under 12 basketball. Please ensure you have working with children qualifications before applying.', 'Request', 4, 2, 1, 6, '2017-07-17 23:19:52'),
(137, 'Sausages', '2017-04-13 00:00:00', 'Looking for sausages for a fund raiser', 'Request', 5, 2, 2, 7, '2017-07-17 23:19:52'),
(138, 'Sausages', '2017-04-10 00:00:00', '10kg of sausages. Please contact for more information.', 'Supplying', 7, 2, 17, 7, '2017-07-17 23:19:52'),
(139, 'Workers', '2017-04-28 00:00:00', 'Offering to help any organisation in need every Wednesday this month. Ring me on ##########', 'Supplying', 3, 2, NULL, 15, '2017-07-17 23:19:52'),
(140, 'a', '2017-06-01 12:06:00', 'TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TEST', 'Request', 8, 2, 1, 1, '2017-07-17 23:19:52'),
(141, 'et', '2017-06-01 12:06:00', 'et', 'Request', 8, 2, 1, 1, '2017-07-17 23:19:52'),
(142, 'testing', '2017-06-01 01:06:00', 'test', 'Request', 8, 2, 1, 1, '2017-07-17 23:19:52'),
(143, 'test', '2017-06-01 01:06:00', 'test', 'Request', 8, 2, 1, 1, '2017-07-17 23:19:52'),
(144, 'test', '2017-06-01 01:06:00', 'test', 'Request', 8, 2, 1, 1, '2017-07-17 23:19:52'),
(145, 'test', '2017-06-01 01:06:00', 'test', 'Request', 8, 2, 1, 1, '2017-07-17 23:19:52'),
(146, 'Test', '2017-06-01 01:06:00', 'test', 'Request', 8, 2, 1, 1, '2017-07-17 23:19:52'),
(147, 'Test', '2017-06-01 10:06:00', 'Test', 'Request', 8, 2, 1, 1, '2017-07-17 23:19:52'),
(148, 'Test', '2017-06-01 10:06:00', 'Test', 'Request', 8, 2, 1, 1, '2017-07-17 23:19:52'),
(149, 'test', '2017-06-01 10:06:00', 'test', 'Request', 8, 2, 1, 1, '2017-07-17 23:19:52'),
(150, 'Coaches', '2017-04-14 00:00:00', 'Looking for people to help out with coaching under 12 basketball. Please ensure you have working with children qualifications before applying.', 'Request', 4, 2, 1, 6, '2017-07-17 23:19:52'),
(151, 'Sausages', '2017-04-13 00:00:00', 'Looking for sausages for a fund raiser', 'Request', 5, 2, 2, 7, '2017-07-17 23:19:52'),
(152, 'Sausages', '2017-04-10 00:00:00', '10kg of sausages. Please contact for more information.', 'Supplying', 7, 2, 17, 7, '2017-07-17 23:19:52'),
(153, 'Workers', '2017-04-28 00:00:00', 'Offering to help any organisation in need every Wednesday this month. Ring me on ##########', 'Supplying', 3, 2, NULL, 15, '2017-07-17 23:19:52'),
(154, 'a', '2017-06-01 12:06:00', 'TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING TEST', 'Request', 8, 2, 1, 1, '2017-07-17 23:19:52'),
(155, 'et', '2017-06-01 12:06:00', 'et', 'Request', 8, 2, 1, 1, '2017-07-17 23:19:52'),
(156, 'LAST', '2017-06-01 01:06:00', 'test', 'Request', 8, 2, 1, 1, '2017-07-17 23:19:52'),
(157, 'NEWTEST', '2017-06-13 02:06:00', 'Internet explorer 11 test', 'Supplying', 8, 2, 1, 4, '2017-07-17 23:19:52'),
(158, 'IENewItemTest', '2017-06-14 02:06:00', 'IENewItemTest', 'Request', 8, 2, 1, 5, '2017-07-17 23:19:52'),
(159, 'test', '1970-01-01 01:01:00', 'TEST', 'Request', 8, 2, 1, 1, '2017-07-17 23:19:52'),
(160, 'test', '1970-01-01 01:01:00', 'EST', 'Request', 8, 2, 1, 1, '2017-07-17 23:19:52'),
(161, 'Test from mobile ', '1970-01-01 01:01:00', 'Testing', 'Request', 8, 2, 1, 10, '2017-07-17 23:19:52'),
(162, 'TET', '1970-01-01 01:01:00', 'TET', 'Request', 8, 2, 1, 1, '2017-07-17 23:19:52'),
(163, 'TEST', '1970-01-01 01:01:00', 'TEST', 'Request', 8, 2, 1, 1, '2017-07-17 23:19:52'),
(164, 'SPA TEST', '1970-01-01 01:01:00', 'TEST', 'Request', 8, 2, 1, 1, '2017-07-17 23:19:52'),
(165, 'SPA TEST2', '1970-01-01 01:01:00', 'TEST', 'Request', 8, 2, 1, 1, '2017-07-17 23:19:52'),
(166, 'SPA TEST3', '1970-01-01 01:01:00', 'TEST', 'Request', 8, 2, 1, 1, '2017-07-17 23:19:52'),
(167, 'SPA TEST4', '1970-01-01 01:01:00', 'TESTETSTETSTESTSEIHE TSKIEHIKUSHIKUESENSNEIUYSEHIJUYSJEHIUYS EHIJUYSEIJUYSEIJUYHSE', 'Request', 8, 2, 1, 1, '2017-07-17 23:19:52'),
(168, 'test', '1970-01-01 01:01:00', 'ests', 'Request', 8, 2, 1, 1, '2017-07-17 23:19:52'),
(169, 'SPA TEST FINAL', '1970-01-01 01:01:00', 'TEST', 'Request', 8, 2, 1, 1, '2017-07-17 23:19:52'),
(170, 'ETET', '1970-01-01 01:01:00', 'TETET', 'Request', 8, 2, 1, 1, '2017-07-17 23:19:52'),
(171, 'SPA TEST CHECK', '1970-01-01 01:01:00', 'testetstest', 'Request', 8, 2, 1, 1, '2017-07-17 23:19:52'),
(172, 'Test Item', '1970-01-01 01:01:00', 'This is a Test', 'Supplying', 9, 2, NULL, 7, '2017-07-17 23:19:52'),
(173, 'Mobile spa test', '1970-01-01 01:01:00', 'Test', 'Supplying', 8, 2, 1, 5, '2017-07-17 23:19:52'),
(174, 'TEST', '1970-01-01 01:01:00', 'TEST', 'Request', 8, 2, 1, 1, '2017-07-17 23:19:52'),
(175, 'TEST', '1970-01-01 01:01:00', 'TEST', 'Request', 8, 2, 1, 1, '2017-07-17 23:19:52'),
(176, 'TEST1', '1970-01-01 01:01:00', 'TEST1', 'Request', 8, 2, 1, 1, '2017-07-17 23:19:52'),
(177, 'TEST2', '1970-01-01 01:01:00', 'TEST2', 'Request', 8, 2, 1, 1, '2017-07-17 23:19:52'),
(178, 'TEST3', '1970-01-01 01:01:00', 'TEST3', 'Request', 8, 2, 1, 1, '2017-07-17 23:19:52'),
(179, 'TEST4', '1970-01-01 01:01:00', 'TEST4', 'Request', 8, 2, 1, 1, '2017-07-17 23:19:52'),
(180, 'TEST5', '1970-01-01 01:01:00', 'TEST5', 'Request', 8, 2, 1, 1, '2017-07-17 23:19:52'),
(181, 'TEST6', '1970-01-01 01:01:00', 'TEST6', 'Request', 8, 2, 1, 1, '2017-07-17 23:19:52'),
(182, 'TEST7', '1970-01-01 01:01:00', 'TEST7', 'Request', 8, 2, 1, 1, '2017-07-17 23:19:52'),
(183, 'TEST8', '1970-01-01 01:01:00', 'TEST8', 'Request', 8, 2, 1, 1, '2017-07-17 23:19:52'),
(184, 'TEST9', '1970-01-01 01:01:00', 'TEST9', 'Request', 8, 2, 1, 1, '2017-07-17 23:19:52'),
(185, 'Test', '1970-01-01 01:01:00', 'Test', 'Request', 8, 2, 1, 1, '2017-07-17 23:19:52'),
(186, 'Test', '1970-01-01 01:01:00', 'Test', 'Request', 8, 2, 1, 1, '2017-07-17 23:19:52'),
(187, 'New', '1970-01-01 01:01:00', 'New', 'Supplying', 8, 2, 1, 1, '2017-07-17 23:19:52'),
(188, 'New', '1970-01-01 01:01:00', 'New', 'Request', 8, 2, 1, 1, '2017-07-17 23:19:52'),
(189, 'New', '1970-01-01 01:01:00', 'New', 'Supplying', 8, 2, 1, 1, '2017-07-17 23:19:52'),
(190, 'New', '1970-01-01 01:01:00', 'New', 'Supplying', 8, 2, 1, 1, '2017-07-17 23:19:52'),
(191, 'New', '1970-01-01 01:01:00', 'New', 'Supplying', 8, 2, 1, 1, '2017-07-17 23:19:52'),
(192, 'Long title test Long title test Long title test Long title test Long title test Long title test Long title test Long title test Long title test ', '1970-01-01 01:01:00', 'Testing', 'Request', 8, 2, 1, 1, '2017-07-17 23:19:52'),
(193, 'New', '1970-01-01 01:01:00', 'test', 'Supplying', 8, 2, 1, 1, '2017-07-17 23:19:52'),
(194, 'New', '1970-01-01 01:01:00', 'new', 'Supplying', 8, 2, 1, 1, '2017-07-17 23:19:52'),
(195, 'Test', '1970-01-01 01:01:00', 'test', 'Request', 8, 2, 1, 1, '2017-07-17 23:19:52');

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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `notification`
--

INSERT INTO `notification` (`NotificationID`, `FKClient`, `FKTag`) VALUES
(3, 3, 4),
(4, 8, 8),
(5, 3, 13),
(6, 8, 13),
(7, 8, 1),
(8, 6, 7);

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
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `organisation`
--

INSERT INTO `organisation` (`groupID`, `name`, `Information`, `currentNews`, `address`) VALUES
(1, 'YMCA Ballarat', '03 5329 2800 ballarat.hr@ymca.org.au', NULL, 'YMCA Ballarat'),
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
(29, 'Ballarat Community Garden', 'http://ballaratcommunitygarden.org.au/contact-us/', NULL, 'Ballarat Community Garden'),
(30, 'Carl Sagan Appreciation Group', 'Appreciating the work and life of Carl Sagan', NULL, 'Carl Sagan Appreciation Group'),
(33, 'TEST', 'TEST', NULL, NULL),
(34, 'TEST2', 'TEST', NULL, NULL);

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
SET FOREIGN_KEY_CHECKS=1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
