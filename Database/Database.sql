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
CREATE DATABASE `connectMeBallarat` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
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
(1, 'Welcome', 'This website has been developed by a group of Federation University students for the Ballarat Council.<br>It has been designed for the volunteer organisations in Ballarat, so they can share their resources online easier.<br>Volunteers can create listings for the services that they need or can provide, which can then easily be found by other volunteers.<br><img src=\"img/logo.png\" alt=\"Logo\" class=\"homePageImage\">', '2017-10-13 08:48:50');

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

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

CREATE TABLE `notification` (
  `NotificationID` int(10) NOT NULL,
  `FKClient` int(10) NOT NULL,
  `FKTag` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `organisation`
--

CREATE TABLE `organisation` (
  `groupID` int(10) NOT NULL,
  `name` varchar(255) NOT NULL,
  `Information` varchar(10000) NOT NULL,
  `currentNews` varchar(2000) DEFAULT NULL,
  `address` varchar(300) NOT NULL,
  `lastModified` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
