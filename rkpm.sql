-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 31, 2017 at 03:17 PM
-- Server version: 10.1.28-MariaDB
-- PHP Version: 7.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rkpm`
--

-- --------------------------------------------------------

--
-- Table structure for table `parking`
--

CREATE TABLE `parking` (
  `id` int(12) NOT NULL,
  `company` varchar(50) DEFAULT NULL,
  `reg` varchar(56) NOT NULL,
  `trlno` varchar(20) DEFAULT NULL,
  `type` varchar(20) DEFAULT NULL,
  `timein` datetime DEFAULT NULL,
  `tid` text NOT NULL,
  `col` varchar(20) DEFAULT '1',
  `paid` text,
  `timeout` varchar(30) DEFAULT NULL,
  `deleted` int(3) NOT NULL DEFAULT '0',
  `h_light` int(3) NOT NULL DEFAULT '0',
  `comment` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `parking`
--

INSERT INTO `parking` (`id`, `company`, `reg`, `trlno`, `type`, `timein`, `tid`, `col`, `paid`, `timeout`, `deleted`, `h_light`, `comment`) VALUES
(1, 'NOLAN', '09WX8833', 'NT112EX', '1', '2017-10-05 22:37:34', '', '3', '', '2017-11-07 22:40:00', 0, 0, NULL),
(2, 'NOLAN', '08WX2452', '', '2', '2017-11-24 22:37:53', '', '3', '', '2017-11-24 22:40:00', 0, 0, NULL),
(3, 'NOLAN', '02WX2345', '', '1', '2017-12-24 22:38:10', '', '3', '', '2017-12-25 22:38:10', 0, 0, NULL),
(4, 'NOLAN2', '07WZ6634', '', '2', '2017-11-22 22:38:27', '', '3', '', '2017-12-28 16:46:00', 0, 0, NULL),
(5, 'NOLAN', '09WX7766', '', '1', '2017-11-01 22:39:51', '', '3', '', '2017-12-28 17:14:00', 0, 0, NULL),
(6, 'DIXON', '131MH63', '', '1', '2017-11-26 01:54:06', '99889 88777 99887', '2', 'ACCTÂ£10', '', 0, 0, NULL),
(7, 'HITRANSIT', 'SHSHSHS', '', '1', '2017-12-06 21:53:42', '', '3', '', '2017-12-06 21:54:00', 0, 0, NULL),
(8, 'HSHSHSH', 'SHSHSHH', 'SHSHHFHF', '4', '2017-12-29 03:30:40', '', '1', '', '', 0, 0, NULL),
(9, 'SSFFFFS', 'DSDDFAFHAHF', 'FWGHFSHFG', '3', '2017-12-29 03:30:50', '', '1', '', '', 0, 0, NULL),
(10, 'DFGHBSFJDKASFKN', 'GHJK', 'BFJNDASKML', '1', '2017-12-29 03:30:58', '', '1', '', '', 0, 0, NULL),
(11, 'DHDFHDH', 'DHDHDH', 'DHDHDH', '4', '2017-12-31 15:01:52', '', '1', '', '', 0, 0, ''),
(12, 'SSDS', 'SSS', '', '1', '2017-12-31 15:03:52', '', '1', '', '', 0, 0, 'took his shower'),
(13, '223', 'SDFGHJ', '', '1', '2017-12-31 15:16:42', '', '3', '', '2017-12-31 15:16:00', 0, 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `trucks`
--

CREATE TABLE `trucks` (
  `id` int(12) NOT NULL,
  `company` varchar(26) DEFAULT NULL,
  `reg` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `parking`
--
ALTER TABLE `parking`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `trucks`
--
ALTER TABLE `trucks`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `parking`
--
ALTER TABLE `parking`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
