-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 07, 2017 at 04:27 AM
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
-- Table structure for table `item`
--

DROP TABLE IF EXISTS `item`;
CREATE TABLE `item` (
  `itemID` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `end` datetime NOT NULL,
  `description` varchar(500) NOT NULL,
  `type` set('Request','Supplying') NOT NULL,
  `FKuser` int(11) NOT NULL,
  `finished` tinyint(4) NOT NULL DEFAULT '0',
  `organisation` int(11) DEFAULT NULL,
  `FKTagID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `item`
--

INSERT INTO `item` (`itemID`, `name`, `end`, `description`, `type`, `FKuser`, `finished`, `organisation`, `FKTagID`) VALUES
(3, 'Coaches', '2017-04-14 00:00:00', 'Looking for people to help out with coaching under 12 basketball', 'Request', 4, 0, 1, 6),
(4, 'Sausages', '2017-04-13 00:00:00', 'Looking for sausages for a fund raiser', 'Request', 5, 0, 2, 7),
(5, 'Sausages', '2017-04-10 00:00:00', '10kg of sausages. Please contact for more information.', 'Supplying', 7, 0, 17, 7),
(6, 'Workers', '2017-04-28 00:00:00', 'Offering to help any organisation in need every Wednesday this month. Ring me on ##########', 'Supplying', 3, 0, NULL, 15);

-- --------------------------------------------------------

--
-- Table structure for table `notifcation`
--

DROP TABLE IF EXISTS `notifcation`;
CREATE TABLE `notifcation` (
  `NotificationID` int(11) NOT NULL,
  `FKUser` int(11) NOT NULL,
  `FKTag` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `notifcation`
--

INSERT INTO `notifcation` (`NotificationID`, `FKUser`, `FKTag`) VALUES
(3, 3, 4),
(4, 3, 8),
(5, 3, 13),
(6, 4, 13),
(7, 4, 15),
(8, 6, 7);

-- --------------------------------------------------------

--
-- Table structure for table `organisation`
--

DROP TABLE IF EXISTS `organisation`;
CREATE TABLE `organisation` (
  `groupID` int(10) NOT NULL,
  `name` varchar(255) NOT NULL,
  `Information` varchar(10000) DEFAULT NULL,
  `currentNews` varchar(2000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `organisation`
--

INSERT INTO `organisation` (`groupID`, `name`, `Information`, `currentNews`) VALUES
(1, 'YMCA Ballarat', '03 5329 2800 ballarat.hr@ymca.org.au', NULL),
(2, 'Ballarat Health Services', 'https://www.bhs.org.au/how-we-can-help', NULL),
(3, 'Uniting Care Ballarat', '105 Dana Street PO Box 608 Ballarat VIC 3353 Phone 03 5332 1286', NULL),
(4, 'Southern Cross Care', 'https://www.sccv.org.au/contact-us-(1)', NULL),
(5, 'Salvation Army', 'Major Volunteer Organisation provides multiple community services.', NULL),
(6, 'Ballarat Wildlife Park', 'http://wildlifepark.com.au/', NULL),
(7, 'Conservation Volunteers Australia', 'http://conservationvolunteers.com.au/contact-us/office-locations/victoria/ballarat/', NULL),
(10, 'Ballarat Autism Network', 'http://www.ballaratautism.com/', NULL),
(11, 'Ballarat Wildlife Park', 'http://wildlifepark.com.au/', NULL),
(12, 'Ballarat Headspace', 'https://headspace.org.au/headspace-centres/ballarat/', NULL),
(13, 'Ballarat Tramway Museum', 'http://btm.org.au', NULL),
(14, 'Soup Bus Ballarat', 'http://www.soupbus.com.au/index.asp', NULL),
(15, 'Food is Free Laneway', 'https://www.facebook.com/foodisfreelanewayballarat/', NULL),
(16, 'Meals on Wheels', 'http://www.ballarat.vic.gov.au/pc/seniors/in-home-support/meals-on-wheels.aspx', NULL),
(17, 'Harvest Ministry of Food', 'http://harvestministryoffood.com/', NULL),
(18, 'Breezeway Meals Program', 'http://www.unitingcareballarat.com.au/services/breezeway-meals-program', NULL),
(19, 'Peplow House', 'https://www.centacareballarat.org.au/services/homelessness-support/peplow-house-crisis-and-transitional/', NULL),
(20, 'Parent Place', 'http://www.ballarat.vic.gov.au/pc/family-and-children/parent-place.aspx', NULL),
(21, 'The Tipping Foundation', 'https://www.tipping.org.au/', NULL),
(22, 'Ballarat Sports Clubs', 'http://www.ballarat.vic.gov.au/lae/sports/sporting-groups.aspx', NULL),
(23, 'Eureka Mums', 'http://www.eurekamums.org/', NULL),
(24, 'Connection Youth Mentoring (CAFS)', 'https://cafs.org.au/', NULL),
(25, 'AIME Mentoring', 'http://www.aimementoring.com/', NULL),
(26, 'RSPCA Victoria', '115A Gillies St S\r\n(03) 5334 2075\r\nhttp://www.rspcavic.org/about-us/pets-place', NULL),
(27, 'Art Gallery of Ballarat', 'https://artgalleryofballarat.com.au/support/volunteer/', NULL),
(28, 'Senior Citizens Clubs', 'http://www.ballarat.vic.gov.au/pc/community-directory.aspx?Parent=110202&Child=110203', NULL),
(29, 'Ballarat Community Garden', 'http://ballaratcommunitygarden.org.au/contact-us/', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tag`
--

DROP TABLE IF EXISTS `tag`;
CREATE TABLE `tag` (
  `tagID` int(11) NOT NULL,
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

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `userID` int(10) NOT NULL,
  `userFirstName` varchar(35) NOT NULL,
  `userLastName` varchar(35) NOT NULL,
  `email` varchar(255) NOT NULL,
  `FKgroup` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`userID`, `userFirstName`, `userLastName`, `email`, `FKgroup`) VALUES
(3, 'Gerard', 'May', 'gerdington@gmail.com', NULL),
(4, 'Tim', 'Russel', 'timjarussell@gmail.com', 1),
(5, 'Tim', 'McKnight', 'tmcknight@gmail.com', 2),
(6, 'Baljit', 'Kaur', 'kaurbaljit046@gmail.com', 10),
(7, 'Peter', 'Billett', 'peterbillettsemail@gmail.com', 17);

-- --------------------------------------------------------

--
-- Stand-in structure for view `user/organisations with tags`
-- (See below for the actual view)
--
DROP VIEW IF EXISTS `user/organisations with tags`;
CREATE TABLE `user/organisations with tags` (
`Tag ID` int(11)
,`Tag Name` varchar(50)
,`User ID` int(10)
,`userFirstName` varchar(35)
,`userLastName` varchar(35)
,`Organisation ID` int(11)
,`Organisation Name` varchar(255)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `users in organisations`
-- (See below for the actual view)
--
DROP VIEW IF EXISTS `users in organisations`;
CREATE TABLE `users in organisations` (
`userID` int(10)
,`userFirstName` varchar(35)
,`userLastName` varchar(35)
,`FKgroup` int(11)
,`name` varchar(255)
);

-- --------------------------------------------------------

--
-- Structure for view `user/organisations with tags`
--
DROP TABLE IF EXISTS `user/organisations with tags`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `user/organisations with tags`  AS  select `tag`.`tagID` AS `Tag ID`,`tag`.`name` AS `Tag Name`,`user`.`userID` AS `User ID`,`user`.`userFirstName` AS `userFirstName`,`user`.`userLastName` AS `userLastName`,`user`.`FKgroup` AS `Organisation ID`,`organisation`.`name` AS `Organisation Name` from (((`tag` join `user`) join `organisation`) join `notifcation`) where ((`notifcation`.`FKUser` = `user`.`userID`) and (`notifcation`.`FKTag` = `tag`.`tagID`) and (`organisation`.`groupID` = `user`.`FKgroup`)) ;

-- --------------------------------------------------------

--
-- Structure for view `users in organisations`
--
DROP TABLE IF EXISTS `users in organisations`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `users in organisations`  AS  select `user`.`userID` AS `userID`,`user`.`userFirstName` AS `userFirstName`,`user`.`userLastName` AS `userLastName`,`user`.`FKgroup` AS `FKgroup`,`organisation`.`name` AS `name` from (`user` join `organisation` on((`organisation`.`groupID` = `user`.`FKgroup`))) ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `item`
--
ALTER TABLE `item`
  ADD PRIMARY KEY (`itemID`),
  ADD KEY `FKUser` (`FKuser`),
  ADD KEY `FKGroupID` (`organisation`),
  ADD KEY `FKTagID` (`FKTagID`);

--
-- Indexes for table `notifcation`
--
ALTER TABLE `notifcation`
  ADD PRIMARY KEY (`NotificationID`),
  ADD KEY `FKUserID` (`FKUser`),
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
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`userID`),
  ADD UNIQUE KEY `UserID` (`userID`),
  ADD KEY `FKgroup` (`FKgroup`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `item`
--
ALTER TABLE `item`
  MODIFY `itemID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `notifcation`
--
ALTER TABLE `notifcation`
  MODIFY `NotificationID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `organisation`
--
ALTER TABLE `organisation`
  MODIFY `groupID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;
--
-- AUTO_INCREMENT for table `tag`
--
ALTER TABLE `tag`
  MODIFY `tagID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `userID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `item`
--
ALTER TABLE `item`
  ADD CONSTRAINT `FKGroupID` FOREIGN KEY (`organisation`) REFERENCES `organisation` (`groupID`),
  ADD CONSTRAINT `FKUser` FOREIGN KEY (`FKuser`) REFERENCES `user` (`userID`),
  ADD CONSTRAINT `item_ibfk_1` FOREIGN KEY (`FKTagID`) REFERENCES `tag` (`tagID`);

--
-- Constraints for table `notifcation`
--
ALTER TABLE `notifcation`
  ADD CONSTRAINT `FKTagID` FOREIGN KEY (`FKTag`) REFERENCES `tag` (`tagID`),
  ADD CONSTRAINT `FKUserID` FOREIGN KEY (`FKUser`) REFERENCES `user` (`userID`);

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `FKGroup` FOREIGN KEY (`FKgroup`) REFERENCES `organisation` (`groupID`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
