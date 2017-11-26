-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 26, 2017 at 01:39 AM
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
  `h_light` int(3) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `parking`
--

INSERT INTO `parking` (`id`, `company`, `reg`, `trlno`, `type`, `timein`, `tid`, `col`, `paid`, `timeout`, `deleted`, `h_light`) VALUES
(1, 'NOLAN', '09WX8833', 'NT112EX', '1', '2017-10-05 22:37:34', '', '3', '', '2017-11-07 22:40:00', 0, 0),
(2, 'NOLAN', '08WX2452', '', '2', '2017-11-24 22:37:53', '', '3', '', '2017-11-24 22:40:00', 0, 0),
(3, 'NOLAN', '02WX2345', '', '1', '2017-11-24 22:38:10', '', '1', '', '', 0, 0),
(4, 'NOLAN', '07WZ6634', '', '1', '2017-11-22 22:38:27', '', '1', '', '', 0, 0),
(5, 'NOLAN', '09WX7766', '', '1', '2017-11-01 22:39:51', '', '1', '', '', 0, 0);

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
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
