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

-- Dumping structure for table parking_manager4.exitcode_log
CREATE TABLE IF NOT EXISTS `exitcode_log` (
  `id` int(64) NOT NULL AUTO_INCREMENT,
  `Site` varchar(164) NOT NULL,
  `Code` varchar(64) NOT NULL,
  `Status` int(10) NOT NULL,
  `Processed` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Data exporting was unselected.
-- Dumping structure for table parking_manager4.flag_comments
CREATE TABLE IF NOT EXISTS `flag_comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Uniqueref` varchar(164) NOT NULL,
  `Plate` varchar(50) NOT NULL,
  `Message` text NOT NULL,
  `Status` int(3) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.
-- Dumping structure for table parking_manager4.flag_list
CREATE TABLE IF NOT EXISTS `flag_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Uniqueref` varchar(164) NOT NULL,
  `Site` varchar(164) NOT NULL,
  `Plate` varchar(50) NOT NULL,
  `Global` int(3) NOT NULL,
  `Processed` datetime NOT NULL,
  `Status` int(3) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
