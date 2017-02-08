-- phpMyAdmin SQL Dump
-- version 4.3.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Feb 08, 2017 at 04:49 AM
-- Server version: 5.6.24
-- PHP Version: 5.5.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `shaiful_arm_ems`
--

-- --------------------------------------------------------

--
-- Table structure for table `ems_setup_fsetup_leading_farmer`
--

CREATE TABLE IF NOT EXISTS `ems_setup_fsetup_leading_farmer` (
  `id` int(11) NOT NULL,
  `upazilla_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `address` text,
  `phone_no` varchar(255) NOT NULL,
  `ordering` int(11) NOT NULL DEFAULT '999',
  `status` varchar(11) NOT NULL DEFAULT 'Active',
  `date_created` int(11) NOT NULL DEFAULT '0',
  `date_updated` int(11) NOT NULL DEFAULT '0',
  `user_created` int(11) DEFAULT NULL,
  `user_updated` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ems_setup_fsetup_leading_farmer`
--

INSERT INTO `ems_setup_fsetup_leading_farmer` (`id`, `upazilla_id`, `name`, `address`, `phone_no`, `ordering`, `status`, `date_created`, `date_updated`, `user_created`, `user_updated`) VALUES
(1, 51, 'MD. Siraj', '', '01923882333', 1, 'Active', 1485149464, 1485228700, 1, 1),
(2, 23, 'Sakib-Al-Hasan', '', '01922014343', 3, 'Active', 1485150473, 1485224480, 1, 1),
(3, 260, 'Branden Mccullam', '', '01748200058', 4, 'Active', 1485150967, 1485224497, 1, 1),
(4, 123, 'Ramij Raja', 'Aftabnagar', '01944426907', 2, 'Active', 1485151047, 1486520089, 1, 1),
(5, 56, 'Mehedi Hasan', '', '01943735444', 5, 'Active', 1485224551, 1485224561, 1, 1),
(6, 52, 'Tareq Adnan', '', '01974564556', 6, 'Active', 1485224603, 0, 1, NULL),
(7, 55, 'Rejaul Karim', '', '01756656565', 7, 'Active', 1485224650, 0, 1, NULL),
(8, 54, 'Tamim Iqbal', '', '01677895439', 8, 'Active', 1485224742, 0, 1, NULL),
(9, 54, 'Sujan Biswas', '', '01822348657', 9, 'Active', 1485224781, 0, 1, NULL),
(10, 22, 'Kishan Dutta', '', '01554607980', 10, 'Active', 1485224838, 0, 1, NULL),
(11, 24, 'Sheikh Jamal', '', '01926005916', 11, 'Active', 1485224882, 0, 1, NULL),
(12, 53, 'Abul Basar', '', '01784654655', 12, 'Active', 1485225011, 0, 1, NULL),
(13, 51, 'Yuvraj Singh', '', '01944876532', 13, 'Active', 1485228490, 0, 1, NULL),
(14, 51, 'Shahed Rajib', '', '01887367329', 14, 'Active', 1485228539, 1485247275, 1, 1),
(15, 51, 'Molla Nijam', '', '01787367329', 15, 'Active', 1485228570, 0, 1, NULL),
(16, 51, 'Noren Paji', '', '01987367629', 16, 'Active', 1485228613, 0, 1, NULL),
(17, 51, 'Gias uddin', '', '01749220598', 17, 'Active', 1485228649, 0, 1, NULL),
(18, 93, 'Sattar Ali', '', '01725783490', 18, 'Active', 1485246099, 1485246110, 1, 1),
(19, 104, 'Md. Sajjad', '', '01887571290', 19, 'Active', 1485680797, 1485681858, 1, 1),
(20, 123, 'Munsur Ali', '', '017854324590', 20, 'Active', 1486520020, 1486520032, 1, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ems_setup_fsetup_leading_farmer`
--
ALTER TABLE `ems_setup_fsetup_leading_farmer`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ems_setup_fsetup_leading_farmer`
--
ALTER TABLE `ems_setup_fsetup_leading_farmer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=21;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
