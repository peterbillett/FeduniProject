-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 26, 2017 at 11:15 PM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 7.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `connectMeBallarat`
--
DROP DATABASE IF EXISTS `connectMeBallarat`;
CREATE DATABASE `library` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `connectMeBallarat`;

-- Setup database user
GRANT SELECT, INSERT, UPDATE, DELETE
  ON connectMeBallarat.*
  TO 'cmbdba'@'localhost'
  IDENTIFIED BY 'Osq6JkgqBzPUC8tQ';

-- --------------------------------------------------------

--
-- Table structure for table `client`
--

CREATE TABLE `client` (
  `clientID` int(10) NOT NULL,
  `clientFirstName` varchar(35) NOT NULL,
  `clientLastName` varchar(35) NOT NULL,
  `email` varchar(255) NOT NULL,
  `clientPassword` varchar(100) NOT NULL,
  `FKgroup` int(10) DEFAULT NULL,
  `lastSeen` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `accountType` varchar(20) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `client`
--

INSERT INTO `client` (`clientID`, `clientFirstName`, `clientLastName`, `email`, `clientPassword`, `FKgroup`, `lastSeen`, `accountType`) VALUES
(3, 'Gerard', 'May', 'gerdington@gmail.com', '$2y$10$OloLj1M/1A1lVHlpis7lnerPIqhtCS8/lEGCK0xMkfqKUauIosRTm', NULL, '2017-10-12 17:00:59', '1'),
(4, 'Tim', 'Russell', 'timjarussell@gmail.com', '$2y$10$DDBKUS3vsP76aLLHVr/1be.1kDYmE8oycrSmQnBsnM35Rg8crJ91C', 1, '2017-07-17 23:13:59', '1'),
(5, 'Tim', 'McKnight', 'tmcknight@gmail.com', '$2y$10$UMsc7xqP85HaKgRPYWY3j.Pvgx0qNNpd8.B0qi9EsUXGme3wT.1jy', 2, '2017-07-17 23:13:59', '1'),
(6, 'Baljit', 'Kaur', 'kaurbaljit046@gmail.com', '$2y$10$gGhELtJXzo.t2txN6fDYYugaxP5d31nJRMzYfjGd7Yn9wHdIS7IRS', 10, '2017-07-17 23:13:59', '1'),
(7, 'Peter', 'Billett', 'peterbillettsemail@gmail.com', '$2y$10$fsJv77cLdQIs2EM90QOnzOCTXh56TcoRCw13C/S8USv1gsxROt4Py', 17, '2017-09-19 08:11:21', '2'),
(8, 'Rodrigo', 'Sanchez', 'jeneralpanano@hotmail.com', '$2y$10$U1q2RoSlx14gHOeQIUH29O7db7RpLr9S4x.HDkHi9p7xQGA95UXnu', 1, '2017-10-17 20:22:05', '2'),
(9, 'Tim', 'McKnight', 'red@red.net', '$2y$10$iEHrxPtWa24Z6y4gznQ8.Ozl9NW.oSu3a0xRPdrdGRsdqRHUHiSrO', NULL, '2017-10-16 21:28:40', '1'),
(11, 'Admin', 'Admin', 'admin@admin.com', '$2y$10$vROLCDI7msSzssmh1.8E.uTrOwjZTcX.QMj0Ey2uMLPStxYbQkpc2', NULL, '2017-10-17 07:40:46', '3'),
(13, 'Tim', 'Albert', 'anaccount@email.net', '$2y$10$JPCWSI3NKM.43GboQjwtjeYtc2CbXsaABQx.8zpP1JEv1SdziQyO2', NULL, '2017-08-28 14:22:15', '1'),
(14, 'Jim', 'Thompson', 'themangohunter@gmail.com', '$2y$10$kD8XZyhz5VlG638F2L8d0.el0H73Yip9nzjlXL49FfDR5u.sjb8aO', NULL, '2017-08-25 22:19:55', '1'),
(16, 'Bob', 'Stuart', 'bob@bmail.com', '$2y$10$2F0CwVVSMNYECbpsE8NvWuaJUe3evJ1QQFgOTalk4lQFXynCUt/1G', NULL, '2017-08-28 16:29:32', '1'),
(37, 'Kathleen', 'Keogh', 'k.keogh@federation.edu.au', '$2y$10$Ct3At8o/xK7hlvzbrPSNtOcN/WOaFEfYqFz5KQQ7l.7V/PUj8NZEi', 15, '2017-09-19 14:11:32', '2'),
(38, 'Basil', 'Theofanides', 'basil@dogtraining.com.au', '$2y$10$MSvXYNeNX2w.U/tCIo6j0.uDQyzp62TS2EMPUd0Z24sKFkRjAf..a', NULL, '2017-10-25 10:01:28', 'A8371034');

-- --------------------------------------------------------

--
-- Table structure for table `emailqueue`
--

CREATE TABLE `emailqueue` (
  `emailID` int(10) NOT NULL,
  `referenceNum` int(10) NOT NULL,
  `emailType` tinyint(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `homepagenews`
--

CREATE TABLE `homepagenews` (
  `newID` int(10) NOT NULL,
  `title` varchar(100) NOT NULL,
  `news` varchar(20000) NOT NULL,
  `newsDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `homepagenews`
--

INSERT INTO `homepagenews` (`newID`, `title`, `news`, `newsDate`) VALUES
(1, 'WARNING', 'This website is currently in development and might have some broken features during this time.', '2017-08-08 10:01:02'),
(2, 'Welcome', 'This website has been developed by a group of Federation University students for the Ballarat Council.<br>It has been designed for the volunteer organisations in Ballarat so they can share their resources online easier.<br>Volunteers can create listings to the services they need or can provide which can then easily be found by other volunteers.<br><a style=\"font-size: x-large\" href=\"https://www.surveymonkey.com/r/FKFMSFS\" target=\"_blank\">Please click here to share your opinion on this site</a><br><img src=\"img/logo.png\" alt=\"Logo\" class=\"homePageImage\">', '2017-10-13 08:48:50');

-- --------------------------------------------------------

--
-- Table structure for table `item`
--

CREATE TABLE `item` (
  `itemID` int(10) NOT NULL,
  `name` varchar(250) NOT NULL,
  `endtime` datetime NOT NULL,
  `description` varchar(500) NOT NULL,
  `category` set('Request','Supplying') NOT NULL,
  `FKclient` int(10) DEFAULT NULL,
  `finished` tinyint(4) NOT NULL DEFAULT '0',
  `organisation` int(10) DEFAULT NULL,
  `FKTagID` int(10) DEFAULT NULL,
  `lastModifiedTime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `perishable` tinyint(1) NOT NULL DEFAULT '0',
  `location` varchar(250) DEFAULT NULL,
  `image` varchar(13) DEFAULT NULL,
  `dateCreated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `item`
--

INSERT INTO `item` (`itemID`, `name`, `endtime`, `description`, `category`, `FKclient`, `finished`, `organisation`, `FKTagID`, `lastModifiedTime`, `perishable`, `location`, `image`, `dateCreated`) VALUES
(3, 'Coaches', '2017-08-18 12:08:00', 'Looking for people to help out with coaching under 12 basketball. Please ensure you have working with children qualifications before applying.', 'Request', 8, 2, 1, 6, '2017-08-18 09:29:26', 0, NULL, NULL, '2017-10-10 12:57:43'),
(5, 'Sausages', '2017-11-10 23:19:52', '10kg of sausages. Please contact for more information.', 'Supplying', 7, 1, 17, 7, '2017-09-22 14:35:06', 1, NULL, NULL, '2017-10-10 12:57:43'),
(6, 'Workers', '2017-10-05 00:00:00', 'Offering to help any organisation in need every Wednesday this month. Ring me on ##########', 'Supplying', 3, 2, NULL, 15, '2017-08-15 17:56:51', 0, NULL, NULL, '2017-10-10 12:57:43'),
(24, 'Coaches', '2017-10-13 12:10:00', 'Looking for people to help out with coaching under 12 basketball. Please ensure you have working with children qualifications before applying.', 'Request', 4, 2, NULL, 6, '2017-10-13 09:43:37', 0, NULL, NULL, '2017-10-10 12:57:43'),
(25, 'Sausages', '2018-01-19 00:00:00', 'Looking for sausages for a fund raiser', 'Request', 5, 0, 2, 7, '2017-07-17 23:19:52', 1, NULL, NULL, '2017-10-10 12:57:43'),
(27, 'Workers', '2017-08-28 00:00:00', 'Offering to help any organisation in need every Wednesday this month. Ring me on ##########', 'Supplying', 3, 2, NULL, 15, '2017-08-15 17:57:10', 0, NULL, NULL, '2017-10-10 12:57:43'),
(38, 'Coaches', '2017-07-30 23:19:52', 'Looking for people to help out with coaching under 12 basketball. Please ensure you have working with children qualifications before applying.', 'Request', 4, 2, NULL, 6, '2017-07-28 12:26:10', 0, NULL, NULL, '2017-10-10 12:57:43'),
(41, 'Workers', '2017-04-28 00:00:00', 'Offering to help any organisation in need every Wednesday this month. Ring me on ##########', 'Supplying', 3, 2, NULL, 15, '2017-07-17 23:19:52', 0, NULL, NULL, '2017-10-10 12:57:43'),
(52, 'Coaches', '2017-07-30 23:19:52', 'Looking for people to help out with coaching under 12 basketball. Please ensure you have working with children qualifications before applying.', 'Supplying', 4, 2, NULL, 6, '1900-01-31 00:00:00', 0, NULL, NULL, '2017-10-10 12:57:43'),
(55, 'Workers', '2017-04-28 00:00:00', 'Offering to help any organisation in need every Wednesday this month. Ring me on ##########', 'Supplying', 3, 2, NULL, 15, '1900-01-31 00:00:00', 0, NULL, NULL, '2017-10-10 12:57:43'),
(59, 'Coaches', '2017-07-30 23:19:52', 'Looking for people to help out with coaching under 12 basketball. Please ensure you have working with children qualifications before applying.', 'Request', 4, 2, NULL, 6, '2017-07-31 00:00:00', 0, NULL, NULL, '2017-10-10 12:57:43'),
(62, 'Workers', '2017-04-28 00:00:00', 'Offering to help any organisation in need every Wednesday this month. Ring me on ##########', 'Supplying', 3, 2, NULL, 15, '2017-08-17 23:19:00', 0, NULL, NULL, '2017-10-10 12:57:43'),
(73, 'Coaches', '2017-07-30 23:19:52', 'Looking for people to help out with coaching under 12 basketball. Please ensure you have working with children qualifications before applying.', 'Request', 4, 2, NULL, 6, '2017-07-17 23:19:52', 0, NULL, NULL, '2017-10-10 12:57:43'),
(76, 'Workers', '2017-04-28 00:00:00', 'Offering to help any organisation in need every Wednesday this month. Ring me on ##########', 'Supplying', 3, 2, NULL, 15, '2017-07-17 23:19:52', 0, NULL, NULL, '2017-10-10 12:57:43'),
(81, 'Workers', '2017-04-28 00:00:00', 'Offering to help any organisation in need every Wednesday this month. Ring me on ##########', 'Supplying', 3, 2, NULL, 15, '2017-07-17 23:19:52', 0, NULL, NULL, '2017-10-10 12:57:43'),
(86, 'Workers', '2017-04-28 00:00:00', 'Offering to help any organisation in need every Wednesday this month. Ring me on ##########', 'Supplying', 3, 2, NULL, 15, '2017-07-17 23:19:52', 0, NULL, NULL, '2017-10-10 12:57:43'),
(94, 'Coaches', '2017-07-30 23:19:52', 'Looking for people to help out with coaching under 12 basketball. Please ensure you have working with children qualifications before applying.', 'Request', 4, 2, NULL, 6, '2017-07-17 23:19:52', 0, NULL, NULL, '2017-10-10 12:57:43'),
(97, 'Workers', '2017-04-28 00:00:00', 'Offering to help any organisation in need every Wednesday this month. Ring me on ##########', 'Supplying', 3, 2, NULL, 15, '2017-07-17 23:19:52', 0, NULL, NULL, '2017-10-10 12:57:43'),
(108, 'Coaches', '2017-07-30 23:19:52', 'Looking for people to help out with coaching under 12 basketball. Please ensure you have working with children qualifications before applying.', 'Request', 4, 2, NULL, 6, '2017-07-17 23:19:52', 0, NULL, NULL, '2017-10-10 12:57:43'),
(111, 'Workers', '2017-04-28 00:00:00', 'Offering to help any organisation in need every Wednesday this month. Ring me on ##########', 'Supplying', 3, 2, NULL, 15, '2017-07-17 23:19:52', 0, NULL, NULL, '2017-10-10 12:57:43'),
(115, 'Coaches', '2017-07-30 23:19:52', 'Looking for people to help out with coaching under 12 basketball. Please ensure you have working with children qualifications before applying.', 'Request', 4, 2, NULL, 6, '2017-07-17 23:19:52', 0, NULL, NULL, '2017-10-10 12:57:43'),
(118, 'Workers', '2017-04-28 00:00:00', 'Offering to help any organisation in need every Wednesday this month. Ring me on ##########', 'Supplying', 3, 2, NULL, 15, '2017-07-17 23:19:52', 0, NULL, NULL, '2017-10-10 12:57:43'),
(129, 'Coaches', '2017-07-30 23:19:52', 'Looking for people to help out with coaching under 12 basketball. Please ensure you have working with children qualifications before applying.', 'Request', 4, 2, NULL, 6, '2017-07-17 23:19:52', 0, NULL, NULL, '2017-10-10 12:57:43'),
(132, 'Workers', '2017-04-28 00:00:00', 'Offering to help any organisation in need every Wednesday this month. Ring me on ##########', 'Supplying', 3, 2, NULL, 15, '2017-07-17 23:19:52', 0, NULL, NULL, '2017-10-10 12:57:43'),
(136, 'Coaches', '2017-07-30 23:19:52', 'Looking for people to help out with coaching under 12 basketball. Please ensure you have working with children qualifications before applying.', 'Request', 4, 2, NULL, 6, '2017-07-17 23:19:52', 0, NULL, NULL, '2017-10-10 12:57:43'),
(139, 'Workers', '2017-04-28 00:00:00', 'Offering to help any organisation in need every Wednesday this month. Ring me on ##########', 'Supplying', 3, 2, NULL, 15, '2017-07-17 23:19:52', 0, NULL, NULL, '2017-10-10 12:57:43'),
(150, 'Coaches', '2017-07-30 23:19:52', 'Looking for people to help out with coaching under 12 basketball. Please ensure you have working with children qualifications before applying.', 'Request', 4, 2, NULL, 6, '2017-07-17 23:19:52', 0, NULL, NULL, '2017-10-10 12:57:43'),
(153, 'Workers', '2017-04-28 00:00:00', 'Offering to help any organisation in need every Wednesday this month. Ring me on ##########', 'Supplying', 3, 2, NULL, 15, '2017-07-17 23:19:52', 0, NULL, NULL, '2017-10-10 12:57:43'),
(239, 'Cleaning Products', '2017-08-23 05:08:00', 'A variety of Cleaning Products are available to anyone who wants them.', 'Supplying', 13, 2, NULL, 11, '2017-08-14 14:24:37', 1, '12 Doveton Street North, Ballarat Central, Victoria, Australia', NULL, '2017-10-10 12:57:43'),
(241, 'Onions', '2018-07-18 11:07:00', 'Several bags of onions available', 'Supplying', 9, 0, NULL, 7, '2017-08-16 10:41:14', 1, '1 Sturt Street, Ballarat Central, Victoria, Australia', NULL, '2017-10-10 12:57:43'),
(242, 'Clothing', '2017-08-17 10:08:00', 'Clean secondhand baby clothing wanted', 'Request', 9, 2, NULL, 14, '2017-08-16 10:45:05', 0, '1 Sturt Street, Ballarat Central, Victoria, Australia', NULL, '2017-10-10 12:57:43'),
(243, 'A thing of value', '2017-08-23 04:08:00', 'Only one thing get it quick', 'Supplying', 13, 2, NULL, 1, '2017-08-18 16:28:51', 0, '1 Sturt Street, Ballarat Central, Victoria, Australia', NULL, '2017-10-10 12:57:43'),
(244, 'apple', '2017-08-19 05:08:00', 'apple', 'Request', 3, 2, NULL, 1, '2017-08-18 18:05:27', 0, 'Null', NULL, '2017-10-10 12:57:43'),
(247, 'More Things', '2017-09-05 06:09:00', 'Things for supply', 'Supplying', 9, 2, NULL, 8, '2017-08-22 10:14:08', 1, '1813 Sturt Street, Alfredton, Victoria, Australia', NULL, '2017-10-10 12:57:43'),
(285, 'an item', '2017-08-29 04:08:00', 'an item for distribution', 'Request', 11, 2, NULL, 1, '2017-08-28 16:35:00', 0, NULL, NULL, '2017-10-10 12:57:43'),
(339, 'Bottled Water', '2017-09-26 12:09:00', '10 lots of 12x bottles of water', 'Supplying', 8, 2, NULL, 8, '2017-09-22 16:31:42', 0, NULL, NULL, '2017-10-10 12:57:43'),
(356, 'bike parts available', '2017-09-20 02:09:00', 'I have a number of old bicycles available for parts', 'Supplying', 37, 2, NULL, 6, '2017-09-19 14:13:49', 0, 'Soldiers Hill, Victoria, Australia', NULL, '2017-10-10 12:57:43'),
(361, 'Sporting Equipment', '2017-10-15 12:10:00', 'A mixture of second hand sporting equipment available for pickup.', 'Supplying', 9, 2, NULL, 6, '2017-10-15 10:13:04', 0, '1 University Drive, Mount Helen, Victoria, Australia', '361.png', '2017-10-15 10:09:57'),
(362, 'Children\'s Books', '2017-10-15 12:10:00', 'A collection of second hand popular books for children. Approximately 100 books Dr Seuss, Golden Books etc. All in excellent condition.', 'Supplying', 9, 2, NULL, 12, '2017-10-15 10:20:05', 0, '2 University Drive, Mount Helen, Victoria, Australia', '362.png', '2017-10-15 10:16:38');

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

CREATE TABLE `notification` (
  `NotificationID` int(10) NOT NULL,
  `FKClient` int(10) NOT NULL,
  `FKTag` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `notification`
--

INSERT INTO `notification` (`NotificationID`, `FKClient`, `FKTag`) VALUES
(4, 7, 15),
(6, 7, 13),
(8, 7, 5),
(11, 7, 1),
(12, 7, 7),
(13, 7, 10),
(75, 7, 4),
(90, 7, 6),
(91, 7, 8),
(92, 7, 9),
(93, 7, 11),
(94, 7, 12),
(95, 7, 14),
(105, 8, 7),
(106, 8, 12);

-- --------------------------------------------------------

--
-- Table structure for table `organisation`
--

CREATE TABLE `organisation` (
  `groupID` int(10) NOT NULL,
  `name` varchar(255) NOT NULL,
  `Information` varchar(10000) DEFAULT NULL,
  `currentNews` varchar(2000) DEFAULT NULL,
  `address` varchar(300) DEFAULT NULL,
  `lastModified` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `organisation`
--

INSERT INTO `organisation` (`groupID`, `name`, `Information`, `currentNews`, `address`, `lastModified`) VALUES
(1, 'YMCA Ballarat', '(03) 5329 2800 ballarat.hr@ymca.org.au', 'TESTING CURRENT NEWS TESTING CURRENT NEWS TESTING CURRENT NEWS TESTING CURRENT NEWS TESTING CURRENT NEWS TESTING CURRENT NEWS UPDATE.', 'Ballarat YMCA, Lyons Street North, Ballarat, Victoria, Australia', '2017-10-13 09:41:25'),
(2, 'Ballarat Health Services', 'https://www.bhs.org.au/how-we-can-help', NULL, 'Ballarat Health Services', '2017-10-13 09:39:38'),
(3, 'Uniting Care Ballarat', '105 Dana Street PO Box 608 Ballarat VIC 3353 Phone 03 5332 1286', NULL, 'Uniting Care Ballarat', '2017-10-13 09:39:38'),
(4, 'Southern Cross Care', 'https://www.sccv.org.au/contact-us-(1)', NULL, 'Southern Cross Care', '2017-10-13 09:39:38'),
(5, 'Salvation Army', 'Major Volunteer Organisation provides multiple community services.', NULL, 'Salvation Army', '2017-10-13 09:39:38'),
(6, 'Ballarat Wildlife Park', 'http://wildlifepark.com.au/', NULL, 'Ballarat Wildlife Park', '2017-10-13 09:39:38'),
(7, 'Conservation Volunteers Australia', 'http://conservationvolunteers.com.au/contact-us/office-locations/victoria/ballarat/', NULL, 'Conservation Volunteers Australia', '2017-10-13 09:39:38'),
(10, 'Ballarat Autism Network', 'http://www.ballaratautism.com/', NULL, 'Ballarat Autism Network', '2017-10-13 09:39:38'),
(12, 'Ballarat Headspace', 'https://headspace.org.au/headspace-centres/ballarat/', NULL, 'Ballarat Headspace', '2017-10-13 09:39:38'),
(13, 'Ballarat Tramway Museum', 'http://btm.org.au', NULL, 'Ballarat Tramway Museum', '2017-10-13 09:39:38'),
(14, 'Soup Bus Ballarat', 'http://www.soupbus.com.au/index.asp', NULL, 'Soup Bus Ballarat', '2017-10-13 09:39:38'),
(15, 'Food is Free Laneway', 'https://www.facebook.com/foodisfreelanewayballarat/', NULL, 'Food is Free Laneway', '2017-10-13 09:39:38'),
(16, 'Meals on Wheels', 'http://www.ballarat.vic.gov.au/pc/seniors/in-home-support/meals-on-wheels.aspx', NULL, 'Meals on Wheels', '2017-10-13 09:39:38'),
(17, 'Harvest Ministry of Food', 'http://harvestministryoffood.com/', NULL, 'Harvest Ministry of Food', '2017-10-13 09:39:38'),
(18, 'Breezeway Meals Program', 'http://www.unitingcareballarat.com.au/services/breezeway-meals-program', NULL, 'Breezeway Meals Program', '2017-10-13 09:39:38'),
(19, 'Peplow House', 'https://www.centacareballarat.org.au/services/homelessness-support/peplow-house-crisis-and-transitional/', NULL, 'Peplow House', '2017-10-13 09:39:38'),
(20, 'Parent Place', 'http://www.ballarat.vic.gov.au/pc/family-and-children/parent-place.aspx', NULL, 'Parent Place', '2017-10-13 09:39:38'),
(21, 'The Tipping Foundation', 'https://www.tipping.org.au/', NULL, 'The Tipping Foundation', '2017-10-13 09:39:38'),
(22, 'Ballarat Sports Clubs', 'http://www.ballarat.vic.gov.au/lae/sports/sporting-groups.aspx', NULL, 'Ballarat Sports Clubs', '2017-10-13 09:39:38'),
(23, 'Eureka Mums', 'http://www.eurekamums.org/', NULL, 'Eureka Mums', '2017-10-13 09:39:38'),
(24, 'Connection Youth Mentoring (CAFS)', 'https://cafs.org.au/', NULL, 'Connection Youth Mentoring (CAFS)', '2017-10-13 09:39:38'),
(25, 'AIME Mentoring', 'http://www.aimementoring.com/', NULL, 'AIME Mentoring', '2017-10-13 09:39:38'),
(26, 'RSPCA Victoria', '115A Gillies St S\r\n(03) 5334 2075\r\nhttp://www.rspcavic.org/about-us/pets-place', NULL, 'RSPCA Victoria', '2017-10-13 09:39:38'),
(27, 'Art Gallery of Ballarat', 'https://artgalleryofballarat.com.au/support/volunteer/', NULL, 'Art Gallery of Ballarat', '2017-10-13 09:39:38'),
(28, 'Senior Citizens Clubs', 'http://www.ballarat.vic.gov.au/pc/community-directory.aspx?Parent=110202&Child=110203', NULL, 'Senior Citizens Clubs', '2017-10-13 09:39:38'),
(29, 'Ballarat Community Garden', 'http://ballaratcommunitygarden.org.au/contact-us/', NULL, 'Ballarat Community Garden', '2017-10-13 09:39:38');

-- --------------------------------------------------------

--
-- Table structure for table `tag`
--

CREATE TABLE `tag` (
  `tagID` int(10) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
-- Indexes for dumped tables
--

--
-- Indexes for table `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`clientID`),
  ADD UNIQUE KEY `ClientID` (`clientID`),
  ADD KEY `FKgroup` (`FKgroup`);

--
-- Indexes for table `emailqueue`
--
ALTER TABLE `emailqueue`
  ADD PRIMARY KEY (`emailID`),
  ADD KEY `itemNumber` (`referenceNum`);

--
-- Indexes for table `homepagenews`
--
ALTER TABLE `homepagenews`
  ADD PRIMARY KEY (`newID`);

--
-- Indexes for table `item`
--
ALTER TABLE `item`
  ADD PRIMARY KEY (`itemID`),
  ADD KEY `FKClient` (`FKclient`),
  ADD KEY `FKGroupID` (`organisation`),
  ADD KEY `FKTagID` (`FKTagID`);

--
-- Indexes for table `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`NotificationID`),
  ADD KEY `FKClientID` (`FKClient`),
  ADD KEY `FKTagID` (`FKTag`);

--
-- Indexes for table `organisation`
--
ALTER TABLE `organisation`
  ADD PRIMARY KEY (`groupID`);

--
-- Indexes for table `tag`
--
ALTER TABLE `tag`
  ADD PRIMARY KEY (`tagID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `client`
--
ALTER TABLE `client`
  MODIFY `clientID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;
--
-- AUTO_INCREMENT for table `emailqueue`
--
ALTER TABLE `emailqueue`
  MODIFY `emailID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `homepagenews`
--
ALTER TABLE `homepagenews`
  MODIFY `newID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `item`
--
ALTER TABLE `item`
  MODIFY `itemID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=363;
--
-- AUTO_INCREMENT for table `notification`
--
ALTER TABLE `notification`
  MODIFY `NotificationID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=107;
--
-- AUTO_INCREMENT for table `organisation`
--
ALTER TABLE `organisation`
  MODIFY `groupID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;
--
-- AUTO_INCREMENT for table `tag`
--
ALTER TABLE `tag`
  MODIFY `tagID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
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
  ADD CONSTRAINT `FKGroupID` FOREIGN KEY (`organisation`) REFERENCES `organisation` (`groupID`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `FKTag` FOREIGN KEY (`FKTagID`) REFERENCES `tag` (`tagID`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `FKclient` FOREIGN KEY (`FKclient`) REFERENCES `client` (`clientID`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `notification`
--
ALTER TABLE `notification`
  ADD CONSTRAINT `FKClientID` FOREIGN KEY (`FKClient`) REFERENCES `client` (`clientID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FKTagID` FOREIGN KEY (`FKTag`) REFERENCES `tag` (`tagID`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
