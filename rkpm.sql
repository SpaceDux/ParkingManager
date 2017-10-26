-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Oct 26, 2017 at 01:01 AM
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
  `type` varchar(20) DEFAULT NULL,
  `timein` varchar(20) DEFAULT NULL,
  `tid` text,
  `col` varchar(4) DEFAULT '1',
  `paid` text,
  `timeout` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `parking`
--

INSERT INTO `parking` (`id`, `company`, `reg`, `type`, `timein`, `tid`, `col`, `paid`, `timeout`) VALUES
(7, 'UNKNOWN', 'BV13ABC', '6', '20/02:53', '87656', '2', 'CARDÂ£6', ''),
(8, 'SAWYERS', 'DS212', '3', '20/03:00', '', '1', '', ''),
(9, 'DIXON', '141MH23', '2', '25/04:00', '', '1', '', ''),
(10, 'DIXON', '141MH237', '2', '25/04:07', '87666', '2', 'ACCTÂ£10', ''),
(11, 'DIXON', '141MH235', '2', '25/04:13', '87743', '3', 'ACCTÂ£10', '26/09:11'),
(12, 'SAWYERS', 'UHZ6677', '2', '25/05:55', 'BREAK', '3', '', '25/12:33'),
(13, 'CAFFREY', '141MH1886', '2', '25/17:52', 'BREAK', '3', '', '26/00:03'),
(14, 'UPS', '141KE2212', '4', '25/23:58', '87655', '2', 'CARDÂ£23', ''),
(15, 'MORGAN', 'FHZ3434', '1', '26/00:04', '', '1', '', ''),
(16, 'HANNON', 'VFZ2001', '2', '26/00:05', '87667', '2', 'ACCTÂ£10', ''),
(17, 'NWC', '161MH765', '2', '25:18:17', '', '1', '', ''),
(18, 'DIXON', 'KY65OMO', '2', '26/00:24', '87654', '2', 'ACCTÂ£10', ''),
(19, 'SAWYERS', 'UHZ5565', '2', '26/00:25', '87653', '3', 'ACCTÂ£6', '26/03:27'),
(20, 'DIXON1', '141MH235', '1', '26/00:25', '', '1', '', ''),
(21, 'DIXON', '141MH2374', '2', '26/00:25', 'BREAK', '3', '', '26/00:29'),
(22, 'SAWYERS', 'DS214', '3', '26/00:26', '87623', '2', 'ACCTÂ£15', '');

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
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
