-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Oct 29, 2017 at 08:10 PM
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
(7, 'UNKNOWN', 'BV13ABC', '', '6', '20/02:53', '87656', '2', 'CARDÂ£6', '', 0, 0),
(8, 'SAWYERS', 'DS212', NULL, '3', '20/03:00', '', '1', '', '', 0, 1),
(9, 'DIXON', '141MH23', 'MDI122', '1', '25/04:00', '', '1', '', '', 0, 1),
(10, 'DIXON', '141MH237', NULL, '2', '25/04:07', '87666', '2', 'ACCTÂ£10', '', 0, 2),
(11, 'DIXON', '141MH235', NULL, '2', '25/04:13', '87743', '3', 'ACCTÂ£10', '26/09:11', 0, 0),
(12, 'SAWYERS', 'UHZ6677', NULL, '2', '25/05:55', 'BREAK', '3', '', '25/12:33', 0, 0),
(13, 'CAFFREY', '141MH1886', NULL, '2', '25/17:52', 'BREAK', '3', '', '26/00:03', 0, 0),
(14, 'UPS', '141KE2212', NULL, '4', '25/23:58', '87655', '2', 'CARDÂ£23', '', 0, 3),
(15, 'MORGAN', 'FHZ3434', NULL, '1', '26/00:04', '', '1', '', '', 0, 1),
(16, 'HANNON', 'VFZ2001', NULL, '2', '26/00:05', '87667', '2', 'ACCTÂ£10', '', 0, 0),
(17, 'NWC', '161MH765', NULL, '2', '25:18:17', '', '1', '', '', 0, 0),
(18, 'DIXON', 'KY65OMO', NULL, '2', '26/00:24', '87654', '2', 'ACCTÂ£10', '', 0, 0),
(19, 'SAWYERS', 'UHZ5565', NULL, '2', '26/00:25', '87653', '3', 'ACCTÂ£6', '26/03:27', 0, 0),
(20, 'DIXON', '141MH235', NULL, '1', '26/00:25', '', '1', '', '', 0, 0),
(21, 'DIXON', '141MH2374', NULL, '2', '26/00:25', 'BREAK', '3', '', '26/00:29', 0, 0),
(22, 'SAWYERS', 'DS214', NULL, '3', '26/00:26', '87623', '3', 'ACCTÂ£15', '27/14:30', 0, 0),
(23, 'MARKTRANS', 'WPR1134M', NULL, '1', '26/02:41', '', '1', '', '', 0, 0),
(24, 'HANNON', 'OFZ5011', 'HAN121', '1', '26/03:21', '86544', '3', 'ACCTÂ£15', '26/03:56', 0, 0),
(25, 'DIXON', '141MH232', 'MDI222', '1', '26/03:48', '', '1', '', '', 0, 0),
(26, 'SAWYERS', 'UHZ4445', '', '2', '26/03:50', '', '1', '', '', 0, 0),
(27, 'STAMP', '141KE245672', '', '2', '26/04:00', '88767 87787', '2', 'CARDÂ£10', '', 0, 0),
(28, 'CAMPBELL', '141LH2776', '', '2', '26/19:48', '88773', '2', 'SNAPÂ£10', '26/19:54', 0, 0),
(29, 'NOONE', '131MH76', '', '2', '27/06:04', '87653', '2', 'ACCTÂ£10', '', 0, 1),
(30, 'UNKNOWN', 'BV16DNS', '', '1', '23/06:01', '', '1', '', '', 0, 0),
(31, 'DIXON', '161MH288', 'MDI109', '1', '27/14:28', '87658', '2', 'ACCTÂ£15', '27/14:30', 0, 0),
(32, 'SAWYERS', 'UHZ6685', 'DS307', '1', '27/14:42', '', '1', '', '', 0, 0),
(33, 'BLAH', 'BLHAHAH', '123', '1', '27/15:55', '87663', '2', 'ACCTÂ£10', '', 0, 0),
(34, 'IDK', '131MH7766', 'DFJSKJHAFH', '2', '27/15:55', '', '1', '', '', 0, 0),
(35, 'KCT', '11KK926', '', '2', '27/16:12', '87654', '2', 'ACCTÂ£10', '', 0, 0),
(36, 'DIXON', '131MH67', '', '2', '27/16:19', '77464', '2', 'ACCTÂ£10', '', 0, 0),
(37, 'NOLAN', '07WX6775', 'NT88RX', '1', '22-10-2017 19:59:00', '87766', '2', 'ACCTÂ£15', '29-10-2017 09:08:00', 0, 0),
(38, 'NOLAN5', '06WX4545', '', '2', '27/21:30', '87233', '3', 'ACCTÂ£15', '28/21:30', 0, 0),
(39, 'NOLAN', '08WX7766', 'NT66NX', '1', '28-10-2017 23:53:00', '', '1', '', '', 0, 0),
(40, 'IDKTRANS', '11KK926', '', '1', '29-10-2017 20:04:00', '', '1', '', '', 0, 0),
(41, 'IDKTRANS2', '163QWGDGF', '', '1', '29-10-2017 20:05:00', '', '1', '', '', 0, 0),
(42, 'SWS', 'SSDFDF2', '', '1', '29-10-2017 20:08:00', '', '1', '', '', 0, 0);

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
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
