-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.19 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             10.1.0.5464
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Dumping database structure for rev_anpr
CREATE DATABASE IF NOT EXISTS `rev_anpr` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `rev_anpr`;

-- Dumping structure for table rev_anpr.rev_camera_configuration
CREATE TABLE IF NOT EXISTS `rev_camera_configuration` (
  `id` int NOT NULL AUTO_INCREMENT,
  `IPAddress` varchar(60) COLLATE utf8mb4_general_ci NOT NULL,
  `Port` varchar(60) COLLATE utf8mb4_general_ci NOT NULL,
  `Username` varchar(60) COLLATE utf8mb4_general_ci NOT NULL,
  `Password` varchar(60) COLLATE utf8mb4_general_ci NOT NULL,
  `LaneID` int NOT NULL,
  `LaneNane` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `BarrierControl` varchar(70) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `Status` int NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Configure Lanes, Camera, ';

-- Data exporting was unselected.
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
