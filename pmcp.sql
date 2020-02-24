-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.1.38-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             10.1.0.5464
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Dumping structure for table pmcp.bans
CREATE TABLE IF NOT EXISTS `bans` (
  `id` int(16) NOT NULL AUTO_INCREMENT,
  `IPAddress` varchar(50) NOT NULL DEFAULT '0',
  `Reason` text NOT NULL,
  `Date` datetime NOT NULL,
  `Status` int(16) NOT NULL DEFAULT '0',
  `Last_Updated` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.
-- Dumping structure for table pmcp.bookings
CREATE TABLE IF NOT EXISTS `bookings` (
  `id` int(16) NOT NULL AUTO_INCREMENT,
  `Uniqueref` varchar(68) NOT NULL,
  `Site` int(16) NOT NULL,
  `Plate` varchar(68) NOT NULL,
  `Date` datetime NOT NULL,
  `ETA` datetime NOT NULL,
  `ETD` datetime NOT NULL,
  `Requestee` varchar(68) NOT NULL,
  `Last_Updated` datetime NOT NULL,
  `Status` int(3) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.
-- Dumping structure for table pmcp.settings
CREATE TABLE IF NOT EXISTS `settings` (
  `id` int(16) NOT NULL AUTO_INCREMENT,
  `SiteName` varchar(58) NOT NULL,
  `SiteSpaces` int(16) NOT NULL,
  `ActiveBookings` int(3) NOT NULL,
  `Address` text NOT NULL,
  `AccessKey` varchar(112) NOT NULL,
  `Email` varchar(168) NOT NULL,
  `Information` text,
  `API_User` varchar(112) NOT NULL,
  `API_Password` varchar(112) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Data exporting was unselected.
-- Dumping structure for table pmcp.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(16) NOT NULL AUTO_INCREMENT,
  `Uniqueref` varchar(58) NOT NULL,
  `FirstName` varchar(58) NOT NULL,
  `LastName` varchar(58) NOT NULL,
  `EmailAddress` varchar(168) NOT NULL,
  `Telephone` varchar(58) NOT NULL,
  `Password` varchar(128) NOT NULL,
  `Company` varchar(58) DEFAULT NULL,
  `Associated_Account` varchar(112) DEFAULT NULL,
  `Rank` int(3) NOT NULL,
  `MaxSpaces` int(3) NOT NULL,
  `LoggedIn` int(3) NOT NULL,
  `Last_Updated` datetime NOT NULL,
  `Date_Registered` datetime NOT NULL,
  `Registered_IP` varchar(58) NOT NULL,
  `Last_IP` varchar(58) NOT NULL,
  `Status` int(3) NOT NULL,
  `Activated` int(3) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Data exporting was unselected.
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
