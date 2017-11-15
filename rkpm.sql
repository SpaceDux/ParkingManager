-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 15, 2017 at 10:06 PM
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
  `deleted` int(3) NOT NULL DEFAULT '0',
  `h_light` int(3) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `parking`
--

INSERT INTO `parking` (`id`, `company`, `reg`, `trlno`, `type`, `timein`, `tid`, `col`, `paid`, `timeout`, `deleted`, `h_light`) VALUES
(7, 'UNKNOWN', 'BV13ABC', '', '6', '29-10-2017 20:08:00', '87656', '2', 'CARDÂ£6', '', 0, 1),
(8, 'SAWYERS', 'DS212', NULL, '3', '20/03:00', '', '3', '', '13-11-2017 00:44:00', 0, 1),
(9, 'DIXON', '141MH23', 'MDI122', '1', '25/04:00', '', '3', '', '13-11-2017 00:44:00', 0, 1),
(10, 'DIXON', '141MH237', '', '2', '29-10-2017 20:10:00', '87666', '2', 'ACCTÂ£10', '', 0, 2),
(11, 'DIXON', '141MH235', '', '2', '25/04:13', '87743', '3', 'ACCTÂ£10', '29-10-2017 20:22:00', 0, 0),
(12, 'SAWYERS', 'UHZ6677', '', '2', '25/05:55', 'BREAK', '3', '', '29-10-2017 18:08:00', 0, 0),
(13, 'CAFFREY', '141MH1886', '', '2', '25/17:52', 'BREAK', '3', '', '29-10-2017 20:55:00', 0, 0),
(14, 'UPS', '141KE2212', '', '4', '29-10-2017 20:23:00', '87655', '2', 'CARDÂ£23', '', 0, 3),
(15, 'MORGAN', 'FHZ3434', NULL, '1', '26/00:04', '', '3', '', '13-11-2017 00:44:00', 0, 1),
(16, 'HANNON', 'VFZ2001', '', '2', '29-10-2017 20:33:00', '87667', '2', 'ACCTÂ£10', '', 0, 0),
(17, 'NWC', '161MH765', NULL, '2', '25:18:17', '', '3', '', '13-11-2017 00:44:00', 0, 0),
(18, 'DIXON', 'KY65OMO', '', '2', '29-10-2017 20:54:00', '87654', '2', 'ACCTÂ£10', '', 0, 0),
(19, 'SAWYERS', 'UHZ5565', '', '2', '26/00:25', '87653', '3', 'ACCTÂ£6', '29-10-2017 20:52:00', 0, 0),
(20, 'DIXON', '141MH235', NULL, '1', '26/00:25', '', '3', '', '13-11-2017 00:44:00', 0, 0),
(21, 'DIXON', '141MH2374', '', '2', '26/00:25', 'BREAK', '3', '', '29-10-2017 20:44:00', 0, 0),
(22, 'SAWYERS', 'DS214', '', '3', '26/00:26', '87623', '3', 'ACCTÂ£15', '29-10-2017 20:16:00', 0, 0),
(23, 'MARKTRANS', 'WPR1134M', NULL, '1', '26/02:41', '', '3', '', '13-11-2017 00:44:00', 0, 0),
(24, 'HANNON', 'OFZ5011', 'HAN121', '1', '26/03:21', '86544', '3', 'ACCTÂ£15', '29-10-2017 20:32:00', 0, 0),
(25, 'DIXON', '141MH232', 'MDI222', '1', '26/03:48', '', '3', '', '13-11-2017 00:44:00', 0, 0),
(26, 'SAWYERS', 'UHZ4445', '', '2', '26/03:50', '', '3', '', '13-11-2017 00:44:00', 0, 0),
(27, 'STAMP', '141KE245672', '', '2', '26/04:00', '88767 87787', '3', 'CARDÂ£10', '29-10-2017 20:18:00', 0, 0),
(28, 'CAMPBELL', '141LH2776', '', '2', '29-10-2017 20:32:00', '88773', '2', 'SNAPÂ£10', '26/19:54', 0, 0),
(29, 'NOONE', '131MH76', '', '2', '29-10-2017 20:15:00', '87653', '2', 'ACCTÂ£10', '', 0, 1),
(30, 'UNKNOWN', 'BV16DNS', '', '1', '23/06:01', '', '3', '', '13-11-2017 00:44:00', 0, 0),
(31, 'DIXON', '161MH288', 'MDI109', '1', '29-10-2017 20:30:00', '87658', '2', 'ACCTÂ£15', '27/14:30', 0, 0),
(32, 'SAWYERS', 'UHZ6685', 'DS307', '1', '27/14:42', '', '3', '', '08-11-2017 13:19:00', 0, 0),
(33, 'BLAH', 'BLHAHAH', '123', '1', '29-10-2017 20:04:00', '87663', '2', 'ACCTÂ£10', '', 0, 0),
(34, 'IDK', '131MH7766', 'DFJSKJHAFH', '2', '27/15:55', '', '3', '', '08-11-2017 13:19:00', 0, 0),
(35, 'KCT', '11KK926', '', '2', '29-10-2017 20:12:00', '87654', '2', 'ACCTÂ£10', '', 0, 3),
(36, 'DIXON', '131MH67', '', '2', '29-10-2017 20:11:00', '77464', '2', 'ACCTÂ£10', '', 0, 2),
(37, 'NOLAN', '07WX6775', 'NT88RX', '1', '22-10-2017 19:59:00', '87766', '3', 'ACCTÂ£15', '29-10-2017 20:18:00', 0, 0),
(38, 'NOLAN', '06WX4545', '', '2', '29-10-2017 20:08:00', '87233', '3', 'ACCTÂ£15', '29-10-2017 01:02:00', 0, 0),
(39, 'NOLAN', '08WX7766', 'NT66NX', '1', '28-10-2017 23:53:00', '87644', '2', 'ACCTÂ£10', '', 0, 0),
(40, 'IDKTRANS', '11KK926', '', '1', '12-10-2017 20:04:00', '', '1', '', '', 0, 0),
(41, 'IDKTRANS2', '163QWGDGF', '', '1', '12-10-2017 20:05:00', '', '1', '', '', 0, 0),
(42, 'SWS', '141D11232', '', '2', '12-10-2017 20:08:00', '', '1', '', '', 0, 0),
(43, 'DAFAV', 'ADSFAFA', '', '1', '29-10-2017 20:21:00', '', '3', '', '08-11-2017 13:20:00', 0, 1),
(44, 'FSGSGS', '141MH23', '', '3', '06-11-2017 23:05:00', '', '3', '', '08-11-2017 13:19:00', 0, 0),
(45, 'MARKTRANS', 'WPR1121M', '', '1', '13-11-2017 00:44:00', '', '1', '', '', 0, 0),
(46, 'DIXON', '141MH23', '', '2', '13-11-2017 01:26:00', '', '1', '', '', 0, 0),
(47, 'NOLAN', '09WX7334', '', '2', '28-10-2017 23:53:00', '', '3', '', '13-11-2017 01:33:00', 0, 0),
(48, 'NOLAN', '09WX2223', '', '2', '13-11-2017 01:33:00', '', '1', '', '', 0, 0),
(49, 'NOLAN', '05WX5545', '', '2', '13-11-2017 14:26:00', '', '1', '', '', 0, 0),
(50, 'MARCTRANS', '141MH1112', '', '2', '14-11-2017 11:39:00', '', '1', '', '', 0, 0),
(51, 'DIXON', '131MH333', 'DS123', '1', '14-11-2017 16:32:00', '73774', '3', 'CCTÂ£10', '14-11-2017 16:32:00', 0, 0);

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
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
