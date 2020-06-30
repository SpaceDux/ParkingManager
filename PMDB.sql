-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.4.11-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             11.0.0.5919
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Dumping database structure for pm_portal
CREATE DATABASE IF NOT EXISTS `pm_portal` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;
USE `pm_portal`;

-- Dumping structure for table pm_portal.bans
CREATE TABLE IF NOT EXISTS `bans` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `IPAddress` varchar(50) NOT NULL DEFAULT '0',
  `Reason` text NOT NULL,
  `Date` datetime NOT NULL,
  `Status` int(11) NOT NULL DEFAULT 0,
  `Last_Updated` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table pm_portal.bans: ~0 rows (approximately)
/*!40000 ALTER TABLE `bans` DISABLE KEYS */;
/*!40000 ALTER TABLE `bans` ENABLE KEYS */;

-- Dumping structure for table pm_portal.bays
CREATE TABLE IF NOT EXISTS `bays` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Site` int(11) NOT NULL,
  `Number` varchar(50) NOT NULL,
  `Expiry` datetime DEFAULT NULL,
  `Author` varchar(68) DEFAULT NULL,
  `Temp` int(11) NOT NULL,
  `Last_Updated` datetime NOT NULL,
  `Status` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table pm_portal.bays: ~19 rows (approximately)
/*!40000 ALTER TABLE `bays` DISABLE KEYS */;
INSERT INTO `bays` (`id`, `Site`, `Number`, `Expiry`, `Author`, `Temp`, `Last_Updated`, `Status`) VALUES
	(1, 1, 'High Sec 1', '2020-04-29 06:30:00', '', 0, '2020-04-29 15:39:26', 3),
	(2, 1, 'High Sec 2', '2020-05-02 15:00:00', '', 0, '2020-05-01 12:32:27', 2),
	(3, 1, 'High Sec 3', '2020-05-02 15:00:00', '', 0, '2020-05-01 12:35:08', 2),
	(4, 1, 'High Sec 4', '2020-05-02 15:00:00', '', 0, '2020-05-01 12:36:12', 2),
	(8, 1, 'High Sec 5', '2020-05-02 15:00:00', '', 0, '2020-05-01 12:36:31', 2),
	(9, 1, 'High Sec 6', '2020-05-02 04:00:00', '149202003200957158900', 0, '2020-05-01 13:16:28', 2),
	(10, 1, 'High Sec 7', '2020-05-02 05:00:00', '', 0, '2020-05-04 09:52:20', 0),
	(11, 1, 'High Sec 8', '2020-04-06 14:17:20', '', 0, '2020-04-07 14:32:17', 0),
	(12, 1, 'High Sec 9', '2020-04-06 14:17:24', '', 0, '2020-04-07 14:32:19', 0),
	(13, 1, 'High Sec 10', '2020-04-06 14:17:30', '', 0, '2020-04-07 14:32:18', 0),
	(14, 1, 'High Sec 11', '2020-04-06 14:17:35', '', 0, '2020-04-07 14:32:20', 0),
	(15, 1, 'High Sec 12', '2020-04-06 14:17:39', '', 0, '2020-04-27 14:51:20', 0),
	(16, 1, 'High Sec 13', '2020-04-06 14:17:43', '', 0, '2020-04-27 14:52:35', 0),
	(17, 1, 'Prem 1', '2020-04-07 04:00:00', '', 1, '2020-04-27 14:34:57', 3),
	(18, 1, 'Prem 2', '2020-04-07 16:17:07', '', 1, '2020-04-08 15:57:57', 3),
	(19, 1, 'Prem 3', '2020-04-08 12:04:05', '', 1, '2020-04-08 15:57:58', 3),
	(20, 1, 'Prem 4', '2020-04-08 12:06:27', '', 1, '2020-04-08 15:57:59', 3),
	(21, 1, 'Prem 5', '2020-04-27 14:53:01', '', 1, '2020-04-27 14:53:04', 3),
	(22, 1, 'Fridge Space 1', '2020-05-02 15:00:00', '', 2, '2020-05-01 14:26:57', 3);
/*!40000 ALTER TABLE `bays` ENABLE KEYS */;

-- Dumping structure for table pm_portal.bookings
CREATE TABLE IF NOT EXISTS `bookings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Uniqueref` varchar(68) NOT NULL,
  `Site` int(11) NOT NULL,
  `Plate` varchar(68) NOT NULL,
  `VehicleType` varchar(68) NOT NULL,
  `Date` datetime NOT NULL,
  `ETA` datetime NOT NULL,
  `ETD` datetime NOT NULL,
  `Bay` int(11) NOT NULL,
  `Author` varchar(68) DEFAULT NULL,
  `Company` varchar(70) DEFAULT '',
  `Note` text DEFAULT NULL,
  `Last_Updated` datetime NOT NULL,
  `Status` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table pm_portal.bookings: ~3 rows (approximately)
/*!40000 ALTER TABLE `bookings` DISABLE KEYS */;
INSERT INTO `bookings` (`id`, `Uniqueref`, `Site`, `Plate`, `VehicleType`, `Date`, `ETA`, `ETD`, `Bay`, `Author`, `Company`, `Note`, `Last_Updated`, `Status`) VALUES
	(1, '8102202005011401426714', 1, 'CY15GHX', '1', '2020-05-01 14:01:42', '2020-05-01 21:00:00', '2020-05-02 15:00:00', 22, 'PM', '', NULL, '2020-05-01 14:02:29', 6),
	(2, '9581202005011425164168', 1, 'CY15GHX', '1', '2020-05-01 14:25:16', '2020-05-01 21:00:00', '2020-05-02 15:00:00', 22, 'PM', '', '', '2020-05-01 14:26:57', 6),
	(3, '6722202005011629318445', 1, 'CY15GHX', '2', '2020-05-01 16:29:31', '2020-05-01 21:00:00', '2020-05-02 05:00:00', 10, '149202003200957158900', '', '', '2020-05-04 09:52:20', 6);
/*!40000 ALTER TABLE `bookings` ENABLE KEYS */;

-- Dumping structure for table pm_portal.settings
CREATE TABLE IF NOT EXISTS `settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `SiteName` varchar(58) NOT NULL,
  `Address` text NOT NULL,
  `AccessKey` varchar(112) NOT NULL,
  `Email` varchar(168) NOT NULL,
  `Information` text DEFAULT NULL,
  `API_User` varchar(112) NOT NULL,
  `API_Password` varchar(112) NOT NULL,
  `Last_Updated` datetime NOT NULL,
  `Status` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table pm_portal.settings: ~2 rows (approximately)
/*!40000 ALTER TABLE `settings` DISABLE KEYS */;
INSERT INTO `settings` (`id`, `SiteName`, `Address`, `AccessKey`, `Email`, `Information`, `API_User`, `API_Password`, `Last_Updated`, `Status`) VALUES
	(1, 'Roadking: Cannock', 'Roadking: Cannock, Watling St, Four Crosses, Cannock WS11 1SB', 'AccessKey01', 'admin@roadkingcafe.co.uk', NULL, 'cannock', 'Lorem987', '0000-00-00 00:00:00', 0),
	(2, 'Roadking: Parc Cybi', 'Roadking: Parc Cybi, \r\nHolyhead,\r\nAnglesey, North Wales\r\nLL65 2YQ', '', 'holyhead.parking@rktruckstops.co.uk', NULL, 'holyhead', 'Lorem987', '0000-00-00 00:00:00', 1);
/*!40000 ALTER TABLE `settings` ENABLE KEYS */;

-- Dumping structure for table pm_portal.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Uniqueref` varchar(58) NOT NULL,
  `FirstName` varchar(58) NOT NULL,
  `LastName` varchar(58) NOT NULL,
  `EmailAddress` varchar(168) NOT NULL,
  `Telephone` varchar(58) NOT NULL,
  `Password` varchar(128) NOT NULL,
  `Company` varchar(58) DEFAULT NULL,
  `Associated_Account` varchar(112) DEFAULT NULL,
  `User_Rank` int(11) NOT NULL,
  `MaxSpaces` int(11) NOT NULL,
  `LoggedIn` int(11) NOT NULL,
  `Last_Updated` datetime NOT NULL,
  `Date_Registered` datetime NOT NULL,
  `Registered_IP` varchar(58) NOT NULL,
  `Last_IP` varchar(58) NOT NULL,
  `Status` int(11) NOT NULL,
  `Activated` int(11) NOT NULL,
  `Strikes` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table pm_portal.users: ~74 rows (approximately)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `Uniqueref`, `FirstName`, `LastName`, `EmailAddress`, `Telephone`, `Password`, `Company`, `Associated_Account`, `User_Rank`, `MaxSpaces`, `LoggedIn`, `Last_Updated`, `Date_Registered`, `Registered_IP`, `Last_IP`, `Status`, `Activated`, `Strikes`) VALUES
	(1, '149202003200957158900', 'Ryan', 'Williams', 'ryan@roadkingcafe.co.uk', '07540222638', '$2y$10$qjC/48gMWX1dwQbZZwjHi..pwMBRUCj4tpfsJad527vdxWG1G6pym', '', '', 1, 3, 1, '2020-05-04 09:52:20', '2020-03-20 09:57:15', '5.68.165.40', '192.168.0.24', 0, 1, 16),
	(2, '766202003242227209510', 'Dan', 'Jakob', 'danjakob@pm.me', '01189998819991195253', '$2y$10$z/83MMl9Rs44qVm.Qh5zd.W/vVkIwyf.AJ7Yhl83fRG7Zr/jb5Z06', '', '', 1, 3, 1, '2020-03-24 22:38:03', '2020-03-24 22:27:20', '90.246.212.156', '90.246.212.156', 0, 1, 1),
	(3, '437202003242306249281', 'Kyle', 'Williams', 'kylewilliams26@hotmail.com', '07961430958', '$2y$10$jpOgFGziD2k9aGwDbRr0X.SRniR/ms8kvl3KGtMuM7NcP0L3I.FsC', '', '', 1, 3, 1, '2020-03-25 07:51:40', '2020-03-24 23:06:24', '94.11.115.33', '94.11.115.33', 0, 1, 0),
	(6, '363202003261233104568', 'Nicholas', 'Whatmore', 'mr.njsw@gmail.com', '07813646898', '$2y$10$8xFz3mv83f4rRrMcmnYgR.b0nRwPv2wm5ShRkX6LuEF.5mbUkD.66', '', '', 1, 3, 1, '2020-04-08 12:01:36', '2020-03-26 12:33:10', '90.206.161.203', '82.68.56.109', 0, 1, 1),
	(7, '351202004071739026454', 'Ryan', 'Williams', 'ryan.a.williams@outlook.com', '07540222638', '$2y$10$q.EGNvKU/ciMT2zKZD/qU.3VdeZOJD1sjuD1rLFA9b894gVe1pDCm', '', '', 1, 3, 1, '2020-04-22 17:58:00', '2020-04-07 17:39:02', '5.68.165.40', '5.68.165.40', 0, 1, 0),
	(8, '596202004081158327824', 'Tom', 'Owen', 'tomo7222@gmail.com', '07773379717', '$2y$10$CWuRxoNNdSyhN/70HOXLu.1Zc91rYob.uxjNMqNydegl4kG7hqcgO', '', '', 1, 3, 0, '2020-04-08 12:04:07', '2020-04-08 11:58:32', '82.68.56.109', '78.33.152.138', 0, 1, 0),
	(9, '945202004081232412077', 'Ian', 'Lloyd ', 'illoyd958@gmail.com', '07473090949', '$2y$10$6vdIpo5amtBuLeZmyeRvuuQWG6Djvb77g3Q6r0yiDdCtGXux.K6ra', '', '', 1, 3, 0, '2020-04-08 12:32:41', '2020-04-08 12:32:41', '94.197.120.222', '94.197.120.222', 0, 1, 0),
	(10, '575202004081241583633', 'Kelly', 'Taylor-Johnson', 'kelly@roadkingcafe.co.uk', '07711018641', '$2y$10$PNP.J0biqcWxT4.nhN.ml.LxaLh3YnAqdQBx0z0EAIuo.LJ9t0Vn6', '', '', 1, 3, 1, '2020-04-08 12:42:47', '2020-04-08 12:41:58', '82.68.56.109', '82.68.56.109', 0, 1, 0),
	(11, '657202004081552301568', 'Dan', 'p', 'dan@3264.uk', '46382847', '$2y$10$AbWAkfEPGIwvagqHjqiSR.4UTl1Ztlkg9N.ORVFWsy8Z1maw9.i6u', '', '', 1, 3, 1, '2020-04-10 13:03:37', '2020-04-08 15:52:30', '90.246.227.29', '90.246.211.131', 0, 1, 0),
	(12, '143202004091355445030', 'Nicholas', 'Whatmore', 'reserve@rktravelinn.co.uk', '07813666444', '$2y$10$gNBb3aQ4fKON0zWSS0PQAOt9L5G39Tl64.rWH2wvnmrj9xlUOcUDy', '', '', 1, 3, 1, '2020-04-14 12:57:48', '2020-04-09 13:55:44', '5.64.208.207', '82.68.56.106', 0, 1, 0),
	(13, '524202004091733397562', 'Kevin', 'Wall', 'kevwall@live.co.uk', '07873765440', '$2y$10$KEWZprRJHV2OK5ob1rdYFOmk/iNbU/2/1R0MMVszwdwj4vA7Yhp9G', '', '', 1, 3, 1, '2020-04-26 19:23:23', '2020-04-09 17:33:39', '86.135.234.164', '82.132.187.180', 0, 1, 0),
	(14, '900202004091736578230', 'Aaron ', 'Parry ', 'parryaj20@hotmail.co.uk', '07789224806', '$2y$10$d741rBfI4Uc3/1QCpLTeaOodP5aDBiaasUVFth7uB9DpKwsnBOzh6', '', '', 1, 3, 0, '2020-04-09 17:36:57', '2020-04-09 17:36:57', '85.255.233.144', '85.255.233.144', 0, 0, 0),
	(15, '274202004091737293420', 'john', 'Bernard ', 'john_bernard@btinternet.com', '07465869568', '$2y$10$Vgnty8O2/zvW.zdMOgWpx.9EODy0T4/Cg8755nyyrnmV7P1.4r5bi', '', '', 1, 3, 0, '2020-04-09 17:37:29', '2020-04-09 17:37:29', '188.29.165.172', '188.29.165.172', 0, 0, 0),
	(16, '497202004091746223189', 'Shane ', 'Wyatt ', 'shane.wyatt@ntlworld.com', '07973662252', '$2y$10$GdIWjDl8f.tTBxnCbIsVVuLeMyzM.wc81h9/NhndS32T1wG3s5EiS', '', '', 1, 3, 0, '2020-04-09 17:46:22', '2020-04-09 17:46:22', '81.110.179.129', '81.110.179.129', 0, 0, 0),
	(17, '620202004091747382506', 'Alex', 'Templar', 'atemplar01@googlemail.com', '07817738982', '$2y$10$43OfqoV7PguhoniddQ.IPOX5VOBZ67KFPWJ4F6Uz67UjnY4/EcTlq', '', '', 1, 3, 1, '2020-04-11 22:52:39', '2020-04-09 17:47:38', '213.205.194.51', '82.31.140.69', 0, 1, 0),
	(18, '206202004091751431508', 'Robert ', 'Cook ', 'cookie3074@googlemail.com', '07915485832', '$2y$10$A3WB2GSiiNDv/5Jzzb7tzuxz0rROKfKOIq0vawm7yUNcuhKkDBJly', '', '', 1, 3, 1, '2020-04-10 16:27:27', '2020-04-09 17:51:43', '86.13.89.71', '86.13.89.71', 0, 1, 0),
	(19, '442202004091751455804', 'Adrian', 'Capelin', 'adrian.capelin@gmail.com', '07989704606', '$2y$10$k6Yauh.olqsMCbYJKvqvwuD0JUH7kZN.VDD2wgteUD4aJ8CiJY7Xy', '', '', 1, 3, 1, '2020-04-09 17:57:37', '2020-04-09 17:51:45', '90.220.82.46', '90.220.82.46', 0, 1, 0),
	(20, '782202004091753072870', 'Jerry', 'Oleary ', 'jeremiah1625@yahoo.co.uk', '07775972525', '$2y$10$UsErU2aZTmTpWh8B3sK89.s1g/q3SZ/DTo4wyPaBk1Mx29J7UvpQ6', '', '', 1, 3, 1, '2020-04-09 17:54:29', '2020-04-09 17:53:07', '90.219.148.159', '90.219.148.159', 0, 1, 0),
	(21, '522202004091757592974', 'Gerry ', 'McLaughlin ', 'gerrymclaughlin65@googlemail.com', '07896780904', '$2y$10$f6OvMgmILpkkqEA/LhmbtOl/niZeQvTrJl9I3uhJQswMwzVMx6tge', '', '', 1, 3, 0, '2020-04-09 17:57:59', '2020-04-09 17:57:59', '213.205.241.57', '213.205.241.57', 0, 1, 0),
	(22, '185202004091824121121', 'Annmarie ', 'Loffke', 'bettyboo1985@gmx.com', '07710381235', '$2y$10$KQv56RyczGeHnNIp1.jZ8u85oWxqen7YKXM2vQvPTuMM6d50aX.mu', '', '', 1, 3, 0, '2020-04-09 18:24:12', '2020-04-09 18:24:12', '2.125.46.119', '2.125.46.119', 0, 0, 0),
	(23, '928202004091824459029', 'Michael ', 'May', 'mickmay0314@gmail.com', '07584258268', '$2y$10$A2MNxUQuC5PvLsOqqstboeb5HfSUKspRW9MUiK.aL4x/yvsj4.lgS', '', '', 1, 3, 1, '2020-04-09 20:35:35', '2020-04-09 18:24:45', '82.5.144.224', '82.5.144.224', 0, 1, 0),
	(24, '142202004091827207774', 'Ryan', 'Stewart', 'ryanwstewart@btinternet.com', '07702458101', '$2y$10$7H4oXRhov5EJ4RyJfS48Dus1QY8qJyBtgFxjSNllT7qtzRest.mvK', '', '', 1, 3, 1, '2020-04-09 18:28:18', '2020-04-09 18:27:20', '81.136.39.49', '81.136.39.49', 0, 1, 0),
	(25, '812202004091829245648', 'Peter', 'Jackson ', 'pj0832@yahoo.co.uk', '07480215072', '$2y$10$U1hlvr.7cmCn4AVQpS8NDO7YFzME2xR.AnRPEPABHejIFwajbpfPm', '', '', 1, 3, 1, '2020-04-09 18:30:02', '2020-04-09 18:29:24', '77.99.107.76', '77.99.107.76', 0, 1, 0),
	(26, '546202004091833091925', 'Cam', 'Dean', 'camerondean97@icloud.com', '07387159174', '$2y$10$0tCIP6j/Vzyiy/MRA7li4.02YTsw2L3.BXV0GCnMcIKtPgDcJjcuG', '', '', 1, 3, 0, '2020-04-09 18:33:09', '2020-04-09 18:33:09', '5.71.92.248', '5.71.92.248', 0, 0, 0),
	(27, '930202004091834221287', 'Steven ', 'Ross ', 'rossco1711@hotmail.co.uk', '07811407424 ', '$2y$10$fMp9il.QaGooPAcL.30nFegK4KQhb7O1FStO/8Di0efxWQ6itzrYO', '', '', 1, 3, 0, '2020-04-09 18:34:22', '2020-04-09 18:34:22', '46.69.168.190', '46.69.168.190', 0, 0, 0),
	(28, '734202004091836252602', 'Douglas', 'Cunningham', 'Dougiec2008@gmail.com', '+447411309576', '$2y$10$E0Hw4KKZpfDlapMPRnst5uDQa6t8d.HMOkUIyarxEkAZ/z4XUiLMe', '', '', 1, 3, 1, '2020-04-09 19:40:04', '2020-04-09 18:36:25', '82.132.237.180', '82.132.237.180', 0, 1, 0),
	(29, '213202004091839076431', 'Paul', 'Rigbt', 'paulrigby1268@gmail.con', '07809684093', '$2y$10$DXT8djVS7UsOHDKg2I/7EeTRrDakgOjlZLnP/J/IOgwoRCIl1sefG', '', '', 1, 3, 0, '2020-04-09 18:39:07', '2020-04-09 18:39:07', '82.132.240.247', '82.132.240.247', 0, 0, 0),
	(30, '216202004091840171953', 'Ian', 'Farrington ', 'ianfarrington@outlook.com', '07402092023', '$2y$10$weKD2YfeXdClkhnE5m714OrgAqnuDFfmWNnXirh7T3pzFWAznUtMq', '', '', 1, 3, 1, '2020-04-09 18:42:32', '2020-04-09 18:40:17', '82.22.119.224', '82.22.119.224', 0, 1, 0),
	(31, '272202004091919149317', 'Daniel ', 'Thomas', 'danno5gtt@hotmail.com', '07919263704', '$2y$10$Avy42cHYPTB9Q8xEy94BBOCO8Rh0RWDjCVIJD3vOJnQjtn3MEEsLi', '', '', 1, 3, 1, '2020-04-09 19:20:25', '2020-04-09 19:19:14', '151.229.93.206', '151.229.93.206', 0, 1, 0),
	(32, '906202004091920058917', 'Rafael', 'Francis', 'spanraf@gmail.com', '07703255702', '$2y$10$hJte7RUc3v2EwiuWfcELm.p3.8qeweMwLmF/NdAZkzKVPKzyV1iTG', '', '', 1, 3, 0, '2020-04-09 19:20:05', '2020-04-09 19:20:05', '82.132.234.113', '82.132.234.113', 0, 0, 0),
	(33, '913202004091921079798', 'Brian ', 'Coulter', 'bjc@totalise.co.uk', '07802 858456', '$2y$10$eo42q6Bevgl5xLidp1KPr.lqu6.TOlaFn8IYudgoApNd.RKchkf66', '', '', 1, 3, 0, '2020-04-09 19:21:07', '2020-04-09 19:21:07', '92.40.249.13', '92.40.249.13', 0, 0, 0),
	(34, '565202004091923188277', 'David', 'Richardson', 'dmr464498@gmail.com', '07521198664', '$2y$10$/7RZjhrs/6ZFergtBCZx7.RZAs8zH9QV7xoHUM.1EcWKK7pDk2JBq', '', '', 1, 3, 1, '2020-04-09 19:30:33', '2020-04-09 19:23:18', '185.69.144.155', '185.69.144.155', 0, 1, 0),
	(35, '664202004091927034610', 'Paul ', 'Henson ', 'phenson600@gmail.com', '07591381757', '$2y$10$9hzosCy.rd/R33r/O3tX3.QP3yYzCSIHYbXhJ51.VJuk.LswJ0xUu', '', '', 1, 3, 1, '2020-04-09 19:32:08', '2020-04-09 19:27:03', '176.250.17.215', '176.250.17.215', 0, 1, 0),
	(36, '223202004091928547522', 'Peter ', 'Arstall ', 'peterarstall48@gmail.com', '07722009340', '$2y$10$muafTi.rWujPjfqFiZCPnOOFtRr4iG59H1VtIW/qGo4MFpK4EASe6', '', '', 1, 3, 1, '2020-04-09 19:36:40', '2020-04-09 19:28:54', '213.205.242.171', '213.205.242.171', 0, 1, 0),
	(37, '914202004091934308156', 'Stephen', 'Feenie', 'stephan.feenie@hotmail.co.uk', '07867412389', '$2y$10$WNc9zJ5LTQ544g/qcjtF9uCzGivljS7smbblaeuIYXP9qqeFJdUjK', '', '', 1, 3, 0, '2020-04-09 19:35:34', '2020-04-09 19:34:30', '2.121.106.160', '2.121.106.160', 0, 1, 0),
	(38, '681202004091935187420', 'Paul', 'Attwood ', 'paulieattie@hotmail.com', '07581377208', '$2y$10$E8uVyaECZfRw4YSuv5PZheNK1SI0zXCErbsnboqmcrh.Zj2PHbTJW', '', '', 1, 3, 1, '2020-04-09 19:36:49', '2020-04-09 19:35:18', '213.205.198.182', '213.205.198.182', 0, 1, 0),
	(39, '996202004091949317056', 'Steven', 'Hill', 'steven.hill0106@gmail', '07897488818', '$2y$10$w/rB4GjZt6q8UPNhq4YzqeF2n1TODp0cMmAwfi9j0flnUM1OhpRhm', '', '', 1, 3, 0, '2020-04-09 19:49:31', '2020-04-09 19:49:31', '86.143.227.68', '86.143.227.68', 0, 0, 0),
	(40, '142202004091949402397', 'Steven', 'Hill', 'steven.hill0106@gmail.com', '07897488818', '$2y$10$0kdSlmBKedETrkrDBitFlO3g3RxHp1pORsi5B2OPq/fSmui.e.Wxa', '', '', 1, 3, 0, '2020-04-09 19:49:40', '2020-04-09 19:49:40', '86.143.227.68', '86.143.227.68', 0, 1, 0),
	(41, '707202004092001114192', 'Ross', 'Murray', 'aweebitspecial@hotmail.com', '07825772503', '$2y$10$OYIrYxYre3veUh6zoJVOh.XJOqF3bPgmXx9rzn3ZIuaogALA9HLTW', '', '', 1, 3, 0, '2020-04-09 20:01:11', '2020-04-09 20:01:11', '109.148.18.251', '109.148.18.251', 0, 1, 0),
	(42, '321202004092009235860', 'Martin ', 'Jones', 'mpj81@hotmail.com', '07889914220', '$2y$10$O2upLmDjYRLkq03hn02uDe4bf/ewrjv3.lm299CuOJ23NDkCLQScy', '', '', 1, 3, 1, '2020-04-27 18:27:38', '2020-04-09 20:09:23', '82.132.214.119', '195.99.241.194', 0, 1, 0),
	(43, '128202004092028598064', 'Phill', 'Walker', 'phillip.walker90@hotmail.co.uk', '07918175381', '$2y$10$uvLmYymjnSjASa5xKCk.YuU.x02Dy7I/qiXjHEiGD7naMemdwPMVK', '', '', 1, 3, 0, '2020-04-09 20:28:59', '2020-04-09 20:28:59', '81.106.131.208', '81.106.131.208', 0, 0, 0),
	(44, '162202004092034214863', 'Paul', 'Wickens', 'wickenspaul@hotmail.co.uk', '07879425758', '$2y$10$ne44k0EtOOiBSpxAmblC2.O1LHPUvWgS8RTBKPd3RgvsKuCD1dNSO', '', '', 1, 3, 0, '2020-04-09 20:34:21', '2020-04-09 20:34:21', '90.219.84.224', '90.219.84.224', 0, 0, 0),
	(45, '283202004092217045854', 'Sean', 'Brennan ', 'seanbrennan1980@yahoo.co.uk', '07585667126', '$2y$10$Yy52aGqsGITHzW.lfPzCiOBPkNL8asH3Nyn.HFblQkMCG3DF7EPtq', '', '', 1, 3, 1, '2020-04-09 22:18:09', '2020-04-09 22:17:04', '92.237.144.126', '92.237.144.126', 0, 1, 0),
	(46, '819202004092228052010', 'Andy', 'Williams ', 'williams.andrew5000@gmail.com', '07572190506', '$2y$10$./L/yurpjwp3PQis3qbg6OPXO9FQGBVUkhKwthVOaHCjjS7qHG20e', '', '', 1, 3, 0, '2020-04-09 22:28:05', '2020-04-09 22:28:05', '213.205.203.12', '213.205.203.12', 0, 1, 0),
	(47, '996202004092334298944', 'Neil ', 'Moran', 'neilmoran13@gmail.com', '07733362400', '$2y$10$tlZ/Exbv3AhN77n2FHzFCe3OLKzri4EL/VG/UUyDMhATotV47bq8m', '', '', 1, 3, 1, '2020-04-09 23:39:54', '2020-04-09 23:34:29', '79.72.226.124', '79.72.226.124', 0, 1, 0),
	(48, '118202004100044181689', 'Daniel', 'Grierson', 'd.grierson@live.com', '07760384183', '$2y$10$Gl9w1h5mOJ7Mu7cPFA8DP.c7TzK7GykL.5AzLTtX5vpyrUxZzIkQi', '', '', 1, 3, 0, '2020-04-10 00:44:18', '2020-04-10 00:44:18', '90.253.44.178', '90.253.44.178', 0, 0, 0),
	(49, '474202004100053132281', 'Paul ', 'Beswick ', 'paulntrace69@hotmail.com', '07825652284', '$2y$10$CU5Uo0Lvz6fZ5D4ArstL7.ml5kS1DGv418KlFxmD/e2XgJYzjGiL6', '', '', 1, 3, 1, '2020-04-10 00:54:03', '2020-04-10 00:53:13', '82.25.238.185', '82.25.238.185', 0, 1, 0),
	(50, '912202004100603528930', 'Karl', 'Heath', 'kkarlheath@hotmail.com', '07812432128', '$2y$10$bD81CkxSC2DAi6QJjXt2r.CdhuKaxbUyaNfCvwR.z5HZ.d9QPRtuK', '', '', 1, 3, 1, '2020-04-10 06:05:19', '2020-04-10 06:03:52', '31.124.217.70', '31.124.217.70', 0, 1, 0),
	(51, '208202004100720544137', 'Andy', 'Barlow', 'abee66@outlook.com', '07707767274', '$2y$10$hJclI5/pfcnEISPUVryJ3O6nVUHvLAjdXnmrP5n.4lMz4i/wJcOqO', '', '', 1, 3, 1, '2020-04-14 15:46:14', '2020-04-10 07:20:54', '188.29.164.170', '92.40.202.221', 0, 1, 0),
	(52, '407202004101130151685', 'Paul', 'Henry', 'henrypaul66@gmail.com', '07557857226', '$2y$10$bh3HOu2N6stb69WdRC8EyuDPqLnYARj9PVrfVceXfd8z8zYEJdV/C', '', '', 1, 3, 1, '2020-04-10 11:35:27', '2020-04-10 11:30:15', '81.102.55.213', '81.102.55.213', 0, 1, 0),
	(53, '843202004101206233152', 'Ryan', 'Williams', 'ryan@roadkingcafe.uk', '07540222638', '$2y$10$Fh2Wcc40WoomhS6DxGCrqu.567rZS3WNKZWI6DaNMYrmjHJ7.tAue', '', '', 1, 3, 0, '2020-04-10 12:06:23', '2020-04-10 12:06:23', '5.68.165.40', '5.68.165.40', 0, 1, 0),
	(54, '630202004101427312884', 'Paul', 'Rigby', 'paulrigby1268@gmail.com', '07809684093', '$2y$10$va7kg.Kvk4pZf42dsREt..uRKAeFtkHm1gM3e/UE1xoTB09Vzi8HK', '', '', 1, 3, 0, '2020-04-10 14:30:58', '2020-04-10 14:27:31', '82.132.243.119', '82.132.243.119', 0, 1, 0),
	(55, '424202004101459316153', 'David', 'Forbes', 'forbesy1964@gmail.com', '+447865966500', '$2y$10$6uwtqU1y676UXikWHc3sJeIoTIR9GIEmgE9PwrbFDSPs0kWk5MpvS', '', '', 1, 3, 1, '2020-04-11 22:18:44', '2020-04-10 14:59:31', '2.100.175.196', '2.100.175.196', 0, 1, 0),
	(56, '672202004112134457680', 'Glen', 'Whatmough', 'glen.whatmo_1991@hotmail.co.uk', '07720862810', '$2y$10$H2F8Pqc3NbeCTOcfMook/.bRw2Ukp8YLvY.WXW/TUvoGc2ws6VSK6', '', '', 1, 3, 1, '2020-04-11 21:36:02', '2020-04-11 21:34:45', '5.71.163.214', '5.71.163.214', 0, 1, 0),
	(57, '746202004120948214479', 'Shaun', 'Wrigley', 'shaunafwrigley@hotmail.com', '07516756407', '$2y$10$9MWiS8BBbEkLG3OFryQe0eCv4KO4gBibEbP5ncS4Em9yzjr9aVKI6', '', '', 1, 3, 1, '2020-04-12 09:49:39', '2020-04-12 09:48:21', '86.26.9.129', '86.26.9.129', 0, 1, 0),
	(58, '681202004121249122369', 'Michael', 'Donelon', 'mdonelon10@gmail.com', '00353831003585', '$2y$10$BgNz16DnyCLTNW23LCjjaOY9gVExCsMW03st1Dy2R7IxjWOLu1ary', '', '', 1, 3, 1, '2020-04-12 12:50:37', '2020-04-12 12:49:12', '92.251.158.136', '92.251.158.136', 0, 1, 0),
	(59, '554202004121547433635', 'Mark', 'Lloyd', 'theonebg01@hotmail.com', '07900913816', '$2y$10$XG9JthJq9/0ZamsQJ0BZfOGBQLjVn5sYP6OkD/QIoFNfYi7WMYwz.', '', '', 1, 3, 1, '2020-04-12 15:48:20', '2020-04-12 15:47:43', '86.157.86.104', '86.157.86.104', 0, 1, 0),
	(60, '382202004141553003048', 'Dave ', 'Ellis', 'Daveboy1130@gmail.com', '+447508309779', '$2y$10$s7Kt63jHHPliclemm0Gpvel9jbvD2DXGgnApU1xj/A9VhM3XmCOHy', '', '', 1, 3, 1, '2020-04-22 17:30:28', '2020-04-14 15:53:00', '213.205.194.73', '213.205.242.89', 0, 1, 0),
	(61, '754202004151819108186', 'Michael', 'Lowe', 'mikelowe6883@googlemail.com', '07714406200', '$2y$10$rustXJrVZB3zBoECAUgVUujzI8v/a0XWTdSkWtzi9tyoej.pIEXv2', '', '', 1, 3, 1, '2020-04-16 14:30:17', '2020-04-15 18:19:10', '81.98.147.162', '82.132.236.166', 0, 1, 1),
	(62, '750202004160848197977', 'Ales', 'Horacek', 'aleshor@seznam.cz', '00420736488126', '$2y$10$BqI7ujvgnxy6AmsUWYjJf.lyW96zafMS8Teb7sP3WT2FZut3KAoJK', '', '', 1, 3, 0, '2020-04-16 08:48:19', '2020-04-16 08:48:19', '46.135.6.238', '46.135.6.238', 0, 0, 0),
	(63, '901202004161131583738', 'Ales', 'Horacek', 'aleshor.g@gmail.com', '00420736488126', '$2y$10$qMIlHysgvIpTdVDVzTZxh.hd/4p8o4GdJF5itqhFAo3Eh76KxR/3a', '', '', 1, 3, 1, '2020-04-16 20:58:50', '2020-04-16 11:31:58', '46.135.6.238', '46.135.25.245', 0, 1, 0),
	(64, '204202004211452093556', 'Anthony', 'Mawby', 'tony@toplinesolutions.uk', '07411963780', '$2y$10$dH36nOCXyvCz9ECvv349p.BT1ES84zvH8oF9qNiptouiTR7LsZm.i', '', '', 1, 3, 1, '2020-04-21 16:02:26', '2020-04-21 14:52:09', '92.40.171.32', '92.40.171.32', 0, 1, 0),
	(65, '807202004211648043981', 'Dylan ', 'Stevenson', 'Dylan_stevenson91@hotmail.co.uk', '07557878545', '$2y$10$ncRevE0IPxWJ09obNasB9e9xhtQUPRClrJhv.92SesQwB4OxoCAuu', '', '', 1, 3, 1, '2020-04-21 16:48:51', '2020-04-21 16:48:04', '85.255.236.250', '85.255.236.250', 0, 1, 0),
	(66, '907202004211959186418', 'Stephen', 'Walls', 'wstephen41@gmail.com', '07955451918', '$2y$10$ttMKqLnbbs40oQjBhCyp7OtESwLWOWvxTHp4Du3NmjqHWPKwq.YpK', '', '', 1, 3, 1, '2020-04-22 17:34:17', '2020-04-21 19:59:18', '82.132.218.30', '82.132.186.22', 0, 1, 0),
	(67, '137202004221203363143', 'Mark ', 'Mccormack', 'markuk31@hotmail.com', '07935205426', '$2y$10$Gkxl40Pn2f6A9TXNM5hNIexUaAscW17WgetpN.pdy..7dVHYeP3j.', '', '', 1, 3, 1, '2020-04-22 12:04:44', '2020-04-22 12:03:36', '148.252.128.42', '148.252.128.42', 0, 1, 0),
	(68, '176202004221215022828', 'Arran', 'Page', 'arranpage@googlemail.com', '07720202645', '$2y$10$uPahDaoapb0oPuZ1a0dAVe36JuP03ARKPgCUihhh3eGP4iA9kQzx2', '', '', 1, 3, 1, '2020-04-22 21:49:43', '2020-04-22 12:15:02', '82.132.213.234', '82.132.212.54', 0, 1, 0),
	(69, '292202004221531581128', 'Gavin', 'Pearce', 'gavin.pearce@sharpsbrewery.co.uk', '07772379488', '$2y$10$479siUbxEToP7eNhsBuGleHy771Zjpeqdc97MXxSvzvG5LrQWOrl.', '', '', 1, 3, 0, '2020-04-22 15:31:58', '2020-04-22 15:31:58', '86.181.110.10', '86.181.110.10', 0, 0, 0),
	(70, '975202004231346488943', 'Dan', 'Crowther', 'vanndan2@gmail.com', '07521921209', '$2y$10$qae7FmYgmAyTTWcRzXFOfuhd52HVftcYAgWtfhnsZCFjnMAVM5KYO', '', '', 1, 3, 1, '2020-04-27 20:54:08', '2020-04-23 13:46:48', '148.252.128.172', '185.69.144.2', 0, 1, 0),
	(71, '268202004261109253755', 'Kristoffer ', 'Ibrahim-kori ', 'kriskori@hotmail.co.uk', '07746536205', '$2y$10$XB62t1H1I166/zopizae9O0OBLLSoL.eR72KprhFNMZOONqH6qU0O', '', '', 1, 3, 1, '2020-04-30 14:46:38', '2020-04-26 11:09:25', '90.192.32.211', '82.132.245.20', 0, 1, 0),
	(72, '441202004261152593600', 'Gary', 'Griffiths ', 'garygriffiths76@talktalk.net', '07476373761', '$2y$10$qlWOHJ4VLiEg9779Ce8lKO1NZmqo1Qc.auP1/kyGetXl5hNN/2R3K', '', '', 1, 3, 0, '2020-04-26 11:52:59', '2020-04-26 11:52:59', '151.225.83.250', '151.225.83.250', 0, 0, 0),
	(73, '870202004271259001608', 'gordon', 'wilson', 'gordy1971@gmail.com', '07889737118', '$2y$10$nhOUPQFeRKantJEJ5SswauVODw2u0UM3orskpshffVvvfsDJUwy6C', '', '', 1, 3, 1, '2020-04-27 12:59:38', '2020-04-27 12:59:00', '92.40.186.5', '92.40.186.2', 0, 1, 0),
	(74, '848202004281209374756', 'John', 'Greenhalgh', 'johng0612@yahoo.com', '07540072126', '$2y$10$0Q9nfshYEvhOFe4KTMBYH.4PWrOFAQ.fdw9gpXf3Iswf6Xcx/sRSO', '', '', 1, 3, 1, '2020-05-01 00:25:27', '2020-04-28 12:09:37', '82.132.238.148', '82.23.204.227', 0, 1, 1),
	(75, '948202004281403092136', 'Barry', 'Douglas', 'barry7toy@hotmail.com', '07709321020', '$2y$10$vPF6Bov4dpbh/zvOYCeoEe4kT62tO.5cYpcx6hKc5jBdN5HovOVoe', '', '', 1, 3, 0, '2020-04-28 17:31:40', '2020-04-28 14:03:09', '78.86.153.148', '78.86.153.148', 0, 1, 0),
	(76, '341202004301926347046', 'James', 'O Hare ', 'james.hare1@gmail.com', '00353877821131', '$2y$10$lMcXQXzp2w.IlcUJ1uKXkOBGXd4UICu3oDj2s6ostKkq6RnxKKoWW', '', '', 1, 3, 1, '2020-04-30 19:27:04', '2020-04-30 19:26:34', '89.19.67.70', '89.19.67.53', 0, 1, 0);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

-- Dumping structure for table pm_portal.users_recovery
CREATE TABLE IF NOT EXISTS `users_recovery` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Code` varchar(50) NOT NULL,
  `User_Ref` varchar(50) NOT NULL,
  `EmailAddress` varchar(169) NOT NULL,
  `Expiry` datetime NOT NULL,
  `Status` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dumping data for table pm_portal.users_recovery: ~0 rows (approximately)
/*!40000 ALTER TABLE `users_recovery` DISABLE KEYS */;
/*!40000 ALTER TABLE `users_recovery` ENABLE KEYS */;

-- Dumping structure for table pm_portal.vehicles
CREATE TABLE IF NOT EXISTS `vehicles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Uniqueref` varchar(68) NOT NULL,
  `Plate` varchar(68) NOT NULL,
  `Name` varchar(68) NOT NULL,
  `Assigned_Account` varchar(68) DEFAULT NULL,
  `Date` datetime NOT NULL,
  `Last_Updated` datetime NOT NULL,
  `Owner` varchar(50) NOT NULL,
  `Status` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table pm_portal.vehicles: ~46 rows (approximately)
/*!40000 ALTER TABLE `vehicles` DISABLE KEYS */;
INSERT INTO `vehicles` (`id`, `Uniqueref`, `Plate`, `Name`, `Assigned_Account`, `Date`, `Last_Updated`, `Owner`, `Status`) VALUES
	(1, '7694202003221826011966', 'HHJHH', 'jj', '', '2020-03-22 18:26:01', '2020-03-22 18:26:01', '149202003200957158900', 1),
	(2, '3690202003242226586588', 'CY15GHX', 'Ryan\'s Car', '', '2020-03-24 22:26:58', '2020-03-24 22:26:58', '149202003200957158900', 0),
	(3, '9005202003242236464185', 'BOO B135', 'Tittymobile', '', '2020-03-24 22:36:46', '2020-03-24 22:36:46', '766202003242227209510', 0),
	(4, '7619202003251133223079', 'YC59UNV', 'Nicks', '', '2020-03-25 11:33:22', '2020-03-25 11:33:22', '149202003200957158900', 1),
	(5, '7310202003261242506335', 'YC59UNV', 'BMW', '', '2020-03-26 12:42:50', '2020-03-26 12:42:50', '363202003261233104568', 0),
	(6, '2252202003271643512781', 'YP11RNK', 'Kerrys Car', '', '2020-03-27 16:43:51', '2020-03-27 16:43:51', '149202003200957158900', 1),
	(7, '6043202003301215194633', 'YP11RNO', 'Kerrys Car', '', '2020-03-30 12:15:19', '2020-03-30 12:15:19', '149202003200957158900', 0),
	(8, '6634202004011521467363', 'MGZ6359', 'Hannon', '', '2020-04-01 15:21:46', '2020-04-01 15:21:46', '149202003200957158900', 1),
	(9, '6405202004021831069129', 'TESTING', 'Test', '', '2020-04-02 18:31:06', '2020-04-02 18:31:06', '149202003200957158900', 1),
	(10, '7238202004071859542031', 'TEST', 'test', '', '2020-04-07 18:59:54', '2020-04-07 18:59:54', '149202003200957158900', 1),
	(11, '7214202004081202094865', 'TESTREG1', 'Spare', '', '2020-04-08 12:02:09', '2020-04-08 12:02:09', '363202003261233104568', 0),
	(12, '1242202004081542288580', 'CY15GHX', 'My Car', '', '2020-04-08 15:42:28', '2020-04-08 15:42:28', '351202004071739026454', 0),
	(13, '9074202004091357255825', 'GH64UVH', 'My DAF', '', '2020-04-09 13:57:25', '2020-04-09 13:57:25', '143202004091355445030', 0),
	(14, '2604202004091756142972', 'K444ACC', 'My Mercedes Actros', '', '2020-04-09 17:56:14', '2020-04-09 17:56:14', '782202004091753072870', 0),
	(15, '4756202004091830493481', 'KU68MZX', 'Prs distribution ', '', '2020-04-09 18:30:49', '2020-04-09 18:30:49', '812202004091829245648', 0),
	(16, '1810202004091921047661', 'ER09RAW', 'Mercesdes ', '', '2020-04-09 19:21:04', '2020-04-09 19:21:04', '272202004091919149317', 0),
	(17, '9404202004091929431585', 'GF63YRM', 'My Volvo', '', '2020-04-09 19:29:43', '2020-04-09 19:29:43', '565202004091923188277', 0),
	(18, '4916202004091937567877', 'PN69AOH', 'My daf ', '', '2020-04-09 19:37:56', '2020-04-09 19:37:56', '223202004091928547522', 0),
	(19, '8742202004091938058498', 'WP65XZZ', 'Sparks ', '', '2020-04-09 19:38:05', '2020-04-09 19:38:05', '681202004091935187420', 0),
	(20, '1626202004092011101849', 'KU69XFE', 'My scania ', '', '2020-04-09 20:11:10', '2020-04-09 20:11:10', '321202004092009235860', 0),
	(21, '9450202004092219014152', 'AY18JXC', 'Sean Brennan', '', '2020-04-09 22:19:01', '2020-04-09 22:19:01', '283202004092217045854', 0),
	(22, '2065202004100054362585', 'SJ12XTP', 'My Daf', '', '2020-04-10 00:54:36', '2020-04-10 00:54:36', '474202004100053132281', 0),
	(23, '9424202004100606176725', '89BHN9', 'Daf', '', '2020-04-10 06:06:17', '2020-04-10 06:06:17', '912202004100603528930', 0),
	(24, '5698202004100722281258', 'MF63NWT', 'MAN', '', '2020-04-10 07:22:28', '2020-04-10 07:22:28', '208202004100720544137', 0),
	(25, '6535202004101136361603', 'GF63YRO', 'Paul’s truck', '', '2020-04-10 11:36:36', '2020-04-10 11:36:36', '407202004101130151685', 0),
	(26, '8192202004101429456103', 'HX66ODS', 'My DAF', '', '2020-04-10 14:29:45', '2020-04-10 14:29:45', '630202004101427312884', 0),
	(27, '6497202004112137104205', 'WX65XDB', 'Glen   r t keedwell', '', '2020-04-11 21:37:10', '2020-04-11 21:37:10', '672202004112134457680', 0),
	(28, '5306202004112219549943', 'GF63YRL', 'Volvo ', '', '2020-04-11 22:19:54', '2020-04-11 22:19:54', '424202004101459316153', 0),
	(29, '3376202004112253365179', 'VX20YWB', 'My daf', '', '2020-04-11 22:53:36', '2020-04-11 22:53:36', '620202004091747382506', 0),
	(30, '8898202004120950275828', 'YJ62DD0', 'My Scania', '', '2020-04-12 09:50:27', '2020-04-12 09:50:27', '746202004120948214479', 0),
	(31, '4149202004121548443517', 'GF18ZUA', 'Big V', '', '2020-04-12 15:48:44', '2020-04-12 15:48:44', '554202004121547433635', 0),
	(32, '8100202004141717093491', 'DK63PWF', 'A.S', '', '2020-04-14 17:17:09', '2020-04-14 17:17:09', '382202004141553003048', 0),
	(33, '6636202004151821147878', 'PJ62CWZ', 'My Scania ', '', '2020-04-15 18:21:14', '2020-04-15 18:21:14', '754202004151819108186', 0),
	(34, '4498202004161134196837', '5M82803', 'MB', '', '2020-04-16 11:34:19', '2020-04-16 11:34:19', '901202004161131583738', 0),
	(35, '8388202004211453281526', 'GJ13KYC', 'Tony\'s Truck', '', '2020-04-21 14:53:28', '2020-04-21 14:53:28', '204202004211452093556', 0),
	(36, '8459202004211650137005', 'YJ17KYK', 'Volvo', '', '2020-04-21 16:50:13', '2020-04-21 16:50:13', '807202004211648043981', 0),
	(37, '4793202004221205599912', 'DS13HCP', 'Crafter', '', '2020-04-22 12:05:59', '2020-04-22 12:05:59', '137202004221203363143', 0),
	(38, '6486202004221250014512', 'V500EFE', 'Volvo', '', '2020-04-22 12:50:01', '2020-04-22 12:50:01', '176202004221215022828', 0),
	(39, '9834202004221505457549', 'EY65FDN', 'Man tgx', '', '2020-04-22 15:05:45', '2020-04-22 15:05:45', '907202004211959186418', 0),
	(40, '1250202004221735125038', 'EJ14ZFZ', 'Scania p320', '', '2020-04-22 17:35:12', '2020-04-22 17:35:12', '907202004211959186418', 0),
	(41, '4425202004231348483125', 'MX62KZV', 'DAF LF ', '', '2020-04-23 13:48:48', '2020-04-23 13:48:48', '975202004231346488943', 0),
	(42, '9844202004261112304147', 'GK69BND', 'my daf', '', '2020-04-26 11:12:30', '2020-04-26 11:12:30', '268202004261109253755', 0),
	(43, '3366202004261924343716', 'PF68JVH', 'Kev Wall', '', '2020-04-26 19:24:34', '2020-04-26 19:24:34', '524202004091733397562', 0),
	(44, '2162202004271305368212', 'YK16WZE', 'Gordon\'s DAF', '', '2020-04-27 13:05:36', '2020-04-27 13:05:36', '870202004271259001608', 0),
	(45, '2604202004281212552612', 'YR63OHX', 'JOHN NRP VOLVO', '', '2020-04-28 12:12:55', '2020-04-28 12:12:55', '848202004281209374756', 0),
	(46, '6027202004281412161389', 'DK17KVP', 'Man', '', '2020-04-28 14:12:16', '2020-04-28 14:12:16', '948202004281403092136', 0);
/*!40000 ALTER TABLE `vehicles` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
