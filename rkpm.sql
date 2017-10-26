-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Oct 26, 2017 at 04:05 AM
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
  `timein` varchar(20) DEFAULT NULL,
  `tid` text,
  `col` varchar(4) DEFAULT '1',
  `paid` text,
  `timeout` varchar(20) DEFAULT NULL,
  `deleted` int(3) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `parking`
--

INSERT INTO `parking` (`id`, `company`, `reg`, `trlno`, `type`, `timein`, `tid`, `col`, `paid`, `timeout`, `deleted`) VALUES
(7, 'UNKNOWN', 'BV13ABC', NULL, '6', '20/02:53', '87656', '2', 'CARDÂ£6', '', 0),
(8, 'SAWYERS', 'DS212', NULL, '3', '20/03:00', '', '1', '', '', 0),
(9, 'DIXON', '141MH23', 'MDI122', '1', '25/04:00', '', '1', '', '', 0),
(10, 'DIXON', '141MH237', NULL, '2', '25/04:07', '87666', '2', 'ACCTÂ£10', '', 0),
(11, 'DIXON', '141MH235', NULL, '2', '25/04:13', '87743', '3', 'ACCTÂ£10', '26/09:11', 0),
(12, 'SAWYERS', 'UHZ6677', NULL, '2', '25/05:55', 'BREAK', '3', '', '25/12:33', 0),
(13, 'CAFFREY', '141MH1886', NULL, '2', '25/17:52', 'BREAK', '3', '', '26/00:03', 0),
(14, 'UPS', '141KE2212', NULL, '4', '25/23:58', '87655', '2', 'CARDÂ£23', '', 0),
(15, 'MORGAN', 'FHZ3434', NULL, '1', '26/00:04', '', '1', '', '', 0),
(16, 'HANNON', 'VFZ2001', NULL, '2', '26/00:05', '87667', '2', 'ACCTÂ£10', '', 0),
(17, 'NWC', '161MH765', NULL, '2', '25:18:17', '', '1', '', '', 0),
(18, 'DIXON', 'KY65OMO', NULL, '2', '26/00:24', '87654', '2', 'ACCTÂ£10', '', 0),
(19, 'SAWYERS', 'UHZ5565', NULL, '2', '26/00:25', '87653', '3', 'ACCTÂ£6', '26/03:27', 0),
(20, 'DIXON', '141MH235', NULL, '1', '26/00:25', '', '1', '', '', 0),
(21, 'DIXON', '141MH2374', NULL, '2', '26/00:25', 'BREAK', '3', '', '26/00:29', 0),
(22, 'SAWYERS', 'DS214', NULL, '3', '26/00:26', '87623', '2', 'ACCTÂ£15', '', 0),
(23, 'MARKTRANS', 'WPR1134M', NULL, '1', '26/02:41', '', '1', '', '', 0),
(24, 'HANNON', 'OFZ5011 HAN121', NULL, '1', '26/03:21', '86544', '3', 'ACCTÂ£15', '26/03:56', 0),
(25, 'DIXON', '141MH232', 'MDI222', '1', '26/03:48', '', '1', '', '', 0),
(26, 'SAWYERS', 'UHZ4445', '', '2', '26/03:50', '', '1', '', '', 0),
(27, 'STAMP', '141KE245672', '', '2', '26/04:00', '88767 87787', '2', 'CARDÂ£10', '', 0);

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
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
