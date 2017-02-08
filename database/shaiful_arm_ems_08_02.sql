-- phpMyAdmin SQL Dump
-- version 4.3.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Feb 08, 2017 at 04:02 AM
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
-- Table structure for table `ems_setup_fd_bud_expense_items`
--

CREATE TABLE IF NOT EXISTS `ems_setup_fd_bud_expense_items` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text,
  `status` varchar(11) NOT NULL DEFAULT 'Active',
  `ordering` tinyint(11) NOT NULL DEFAULT '99',
  `date_created` int(11) NOT NULL DEFAULT '0',
  `user_created` int(11) NOT NULL DEFAULT '0',
  `date_updated` int(11) DEFAULT NULL,
  `user_updated` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ems_setup_fd_bud_expense_items`
--

INSERT INTO `ems_setup_fd_bud_expense_items` (`id`, `name`, `description`, `status`, `ordering`, `date_created`, `user_created`, `date_updated`, `user_updated`) VALUES
(1, 'Decoration', 'Decoration', 'Active', 2, 1484802620, 1, 1484806540, 1),
(2, 'Farmers Gift', 'Farmers Gift', 'Active', 1, 1484802629, 1, 1484806549, 1),
(3, 'Entertainment', 'Entertainment', 'Active', 3, 1484806585, 1, 1485138215, 1),
(4, 'Conveyance', 'Conveyance', 'Active', 4, 1484975312, 1, 1485138557, 1),
(5, 'Misc.', 'Misc.', 'Active', 99, 1485138574, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ems_setup_fd_bud_picture_category`
--

CREATE TABLE IF NOT EXISTS `ems_setup_fd_bud_picture_category` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text,
  `status` varchar(11) NOT NULL DEFAULT 'Active',
  `ordering` tinyint(11) NOT NULL DEFAULT '99',
  `date_created` int(11) NOT NULL DEFAULT '0',
  `user_created` int(11) NOT NULL DEFAULT '0',
  `date_updated` int(11) DEFAULT NULL,
  `user_updated` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ems_setup_fd_bud_picture_category`
--

INSERT INTO `ems_setup_fd_bud_picture_category` (`id`, `name`, `description`, `status`, `ordering`, `date_created`, `user_created`, `date_updated`, `user_updated`) VALUES
(1, 'Fruit', 'Fruit', 'Active', 1, 1484804099, 1, 1485138647, 1),
(2, 'Plot', '', 'Active', 2, 1484804105, 1, 1485138639, 1),
(3, 'Cross-section', 'Cross-section', 'Active', 3, 1484975363, 1, 1485138634, 1),
(4, 'Top', 'Top', 'Active', 4, 1484991432, 1, 1485138629, 1);

-- --------------------------------------------------------

--
-- Table structure for table `ems_tm_fd_bud_budget`
--

CREATE TABLE IF NOT EXISTS `ems_tm_fd_bud_budget` (
  `id` int(11) NOT NULL,
  `date` int(11) NOT NULL,
  `remarks` text,
  `status_requested` varchar(20) NOT NULL DEFAULT 'Pending',
  `user_requested` int(11) DEFAULT NULL,
  `remarks_requested` text,
  `date_requested` int(11) DEFAULT NULL,
  `status_approved` varchar(20) NOT NULL DEFAULT 'Pending',
  `user_approved` int(11) DEFAULT NULL,
  `remarks_approved` text,
  `status_reporting` varchar(20) NOT NULL DEFAULT 'Pending',
  `date_approved` int(11) DEFAULT NULL,
  `date_created` int(11) NOT NULL DEFAULT '0',
  `user_created` int(11) NOT NULL DEFAULT '0',
  `date_updated` int(11) DEFAULT NULL,
  `user_updated` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ems_tm_fd_bud_budget`
--

INSERT INTO `ems_tm_fd_bud_budget` (`id`, `date`, `remarks`, `status_requested`, `user_requested`, `remarks_requested`, `date_requested`, `status_approved`, `user_approved`, `remarks_approved`, `status_reporting`, `date_approved`, `date_created`, `user_created`, `date_updated`, `user_updated`) VALUES
(1, 1486404000, 'good', 'Requested', 1, 'All is Well', 1486457193, 'Approved', 1, 'Yeah, Its a great job and now you can carry on.', 'Complete', 1486457278, 1486457009, 1, 1486457086, 1);

-- --------------------------------------------------------

--
-- Table structure for table `ems_tm_fd_bud_details_expense`
--

CREATE TABLE IF NOT EXISTS `ems_tm_fd_bud_details_expense` (
  `id` int(11) NOT NULL,
  `budget_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `amount` float(11,0) NOT NULL DEFAULT '0',
  `date_created` int(11) NOT NULL,
  `user_created` int(11) NOT NULL,
  `revision` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ems_tm_fd_bud_details_expense`
--

INSERT INTO `ems_tm_fd_bud_details_expense` (`id`, `budget_id`, `item_id`, `amount`, `date_created`, `user_created`, `revision`) VALUES
(1, 1, 1, 1000, 1486457009, 1, 2),
(2, 1, 2, 10000, 1486457009, 1, 2),
(3, 1, 3, 10000, 1486457009, 1, 2),
(4, 1, 4, 1000, 1486457009, 1, 2),
(5, 1, 5, 1000, 1486457009, 1, 2),
(6, 1, 1, 1000, 1486457086, 1, 1),
(7, 1, 2, 10000, 1486457086, 1, 1),
(8, 1, 3, 10000, 1486457086, 1, 1),
(9, 1, 4, 1000, 1486457086, 1, 1),
(10, 1, 5, 1000, 1486457086, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `ems_tm_fd_bud_details_participant`
--

CREATE TABLE IF NOT EXISTS `ems_tm_fd_bud_details_participant` (
  `id` int(11) NOT NULL,
  `budget_id` int(11) NOT NULL,
  `farmer_id` int(11) NOT NULL,
  `number` int(11) NOT NULL,
  `date_created` int(11) NOT NULL DEFAULT '0',
  `user_created` int(11) NOT NULL DEFAULT '0',
  `revision` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ems_tm_fd_bud_details_participant`
--

INSERT INTO `ems_tm_fd_bud_details_participant` (`id`, `budget_id`, `farmer_id`, `number`, `date_created`, `user_created`, `revision`) VALUES
(1, 1, 4, 50, 1486457009, 1, 2),
(2, 1, 4, 50, 1486457086, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `ems_tm_fd_bud_details_picture`
--

CREATE TABLE IF NOT EXISTS `ems_tm_fd_bud_details_picture` (
  `id` int(11) NOT NULL,
  `budget_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `arm_file_name` text,
  `arm_file_location` text,
  `arm_file_remarks` text,
  `competitor_file_name` text,
  `competitor_file_location` text,
  `competitor_file_remarks` text,
  `status` varchar(11) NOT NULL DEFAULT 'Active',
  `date_created` int(11) NOT NULL DEFAULT '0',
  `user_created` int(11) NOT NULL DEFAULT '0',
  `revision` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ems_tm_fd_bud_details_picture`
--

INSERT INTO `ems_tm_fd_bud_details_picture` (`id`, `budget_id`, `item_id`, `arm_file_name`, `arm_file_location`, `arm_file_remarks`, `competitor_file_name`, `competitor_file_location`, `competitor_file_remarks`, `status`, `date_created`, `user_created`, `revision`) VALUES
(1, 1, 1, 'Shomy4.JPG', 'images/field_day/1/Shomy4.JPG', 'Not Bad Also', 'Shanti4.JPG', 'images/field_day/1/Shanti4.JPG', 'Not Bad', 'Active', 1486457009, 1, 2),
(2, 1, 2, 'puspita.JPG', 'images/field_day/1/puspita.JPG', 'Brinjal', 'Sheela2.jpg', 'images/field_day/1/Sheela2.jpg', 'Sheela', 'Active', 1486457009, 1, 2),
(3, 1, 3, 'monica.JPG', 'images/field_day/1/monica.JPG', '1 pumpkin', 'black_stone.JPG', 'images/field_day/1/black_stone.JPG', 'Pumpkin', 'Active', 1486457009, 1, 2),
(4, 1, 4, 'Pritom.JPG', 'images/field_day/1/Pritom.JPG', 'Stop', 'lalita1.JPG', 'images/field_day/1/lalita1.JPG', 'Clicking', 'Active', 1486457009, 1, 2),
(5, 1, 1, 'Shomy4.JPG', 'images/field_day/1/Shomy4.JPG', 'Also Bad', 'Shanti4.JPG', 'images/field_day/1/Shanti4.JPG', 'Bad', 'Active', 1486457086, 1, 1),
(6, 1, 2, 'Pritom1.JPG', 'images/field_day/1/Pritom1.JPG', 'Brinjal', 'Sheela3.jpg', 'images/field_day/1/Sheela3.jpg', 'Sheela', 'Active', 1486457086, 1, 1),
(7, 1, 3, 'monica.JPG', 'images/field_day/1/monica.JPG', 'pumpkin', 'black_stone.JPG', 'images/field_day/1/black_stone.JPG', 'Pumpkin', 'Active', 1486457086, 1, 1),
(8, 1, 4, 'Pritom.JPG', 'images/field_day/1/Pritom.JPG', 'Stop', 'lalita1.JPG', 'images/field_day/1/lalita1.JPG', 'Clicking', 'Active', 1486457086, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `ems_tm_fd_bud_info_details`
--

CREATE TABLE IF NOT EXISTS `ems_tm_fd_bud_info_details` (
  `id` int(11) NOT NULL,
  `budget_id` int(11) NOT NULL,
  `variety_id` int(11) NOT NULL,
  `competitor_variety_id` int(11) DEFAULT NULL,
  `upazilla_id` int(11) NOT NULL,
  `address` text,
  `present_condition` text,
  `farmers_evaluation` text,
  `diff_wth_com` text,
  `no_of_participant` int(11) NOT NULL,
  `expected_date` int(11) NOT NULL,
  `total_budget` float(11,0) NOT NULL,
  `sales_target` int(11) NOT NULL,
  `date_created` int(11) NOT NULL DEFAULT '0',
  `user_created` int(11) NOT NULL DEFAULT '0',
  `revision` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ems_tm_fd_bud_info_details`
--

INSERT INTO `ems_tm_fd_bud_info_details` (`id`, `budget_id`, `variety_id`, `competitor_variety_id`, `upazilla_id`, `address`, `present_condition`, `farmers_evaluation`, `diff_wth_com`, `no_of_participant`, `expected_date`, `total_budget`, `sales_target`, `date_created`, `user_created`, `revision`) VALUES
(1, 1, 7, 118, 123, 'FULBARI', 'http://localhost/ems/images/field_day_re', 'http://localhost/ems/ing/5/demo', '/field_day_reporting/5/demo.mp4', 100, 1487872800, 23000, 1230, 1486457009, 1, 2),
(2, 1, 7, 118, 123, 'FULBARI', 'http://localhost/ems/images/field_day_re', 'http://localhost/ems/ing/5/demo', '/field_day_reporting/5/demo.mp4', 100, 1487872800, 23000, 1230, 1486457086, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `ems_tm_fd_bud_reporting`
--

CREATE TABLE IF NOT EXISTS `ems_tm_fd_bud_reporting` (
  `id` int(11) NOT NULL,
  `budget_id` int(11) NOT NULL,
  `date` int(11) NOT NULL,
  `date_of_fd` int(11) DEFAULT NULL,
  `recommendation` text,
  `date_created` int(11) NOT NULL DEFAULT '0',
  `user_created` int(11) NOT NULL DEFAULT '0',
  `date_updated` int(11) DEFAULT NULL,
  `user_updated` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ems_tm_fd_bud_reporting`
--

INSERT INTO `ems_tm_fd_bud_reporting` (`id`, `budget_id`, `date`, `date_of_fd`, `recommendation`, `date_created`, `user_created`, `date_updated`, `user_updated`) VALUES
(1, 5, 1486404000, 1486663200, 'dfgdgf', 1486456319, 1, 1486456481, 1),
(2, 1, 1486404000, 1487959200, 'Victory Sign.', 1486457634, 1, 1486520131, 1);

-- --------------------------------------------------------

--
-- Table structure for table `ems_tm_fd_rep_details_expense`
--

CREATE TABLE IF NOT EXISTS `ems_tm_fd_rep_details_expense` (
  `id` int(11) NOT NULL,
  `budget_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `date_created` int(11) NOT NULL DEFAULT '0',
  `user_created` int(11) NOT NULL DEFAULT '0',
  `revision` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ems_tm_fd_rep_details_expense`
--

INSERT INTO `ems_tm_fd_rep_details_expense` (`id`, `budget_id`, `item_id`, `amount`, `date_created`, `user_created`, `revision`) VALUES
(1, 5, 1, 34, 1486456319, 1, 2),
(2, 5, 2, 53345, 1486456319, 1, 2),
(3, 5, 3, 34, 1486456319, 1, 2),
(4, 5, 4, 3345, 1486456319, 1, 2),
(5, 5, 5, 345, 1486456319, 1, 2),
(6, 5, 1, 34, 1486456481, 1, 1),
(7, 5, 2, 53345, 1486456481, 1, 1),
(8, 5, 3, 34, 1486456481, 1, 1),
(9, 5, 4, 3345, 1486456481, 1, 1),
(10, 5, 5, 345, 1486456481, 1, 1),
(11, 1, 1, 1000, 1486457634, 1, 2),
(12, 1, 2, 10000, 1486457634, 1, 2),
(13, 1, 3, 8000, 1486457634, 1, 2),
(14, 1, 4, 2000, 1486457634, 1, 2),
(15, 1, 5, 4000, 1486457634, 1, 2),
(16, 1, 1, 1000, 1486520131, 1, 1),
(17, 1, 2, 10000, 1486520131, 1, 1),
(18, 1, 3, 8000, 1486520131, 1, 1),
(19, 1, 4, 2000, 1486520131, 1, 1),
(20, 1, 5, 4000, 1486520131, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `ems_tm_fd_rep_details_info`
--

CREATE TABLE IF NOT EXISTS `ems_tm_fd_rep_details_info` (
  `id` int(11) NOT NULL,
  `budget_id` int(11) NOT NULL,
  `total_expense` int(11) DEFAULT NULL,
  `no_of_participant` int(11) NOT NULL,
  `guest` int(11) NOT NULL,
  `participant_comment` text,
  `next_sales_target` int(11) NOT NULL,
  `date_created` int(11) NOT NULL DEFAULT '0',
  `user_created` int(11) NOT NULL DEFAULT '0',
  `revision` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ems_tm_fd_rep_details_info`
--

INSERT INTO `ems_tm_fd_rep_details_info` (`id`, `budget_id`, `total_expense`, `no_of_participant`, `guest`, `participant_comment`, `next_sales_target`, `date_created`, `user_created`, `revision`) VALUES
(1, 5, 57103, 345, 354, 'dfgdf', 54, 1486456319, 1, 2),
(2, 5, 57103, 345, 354, 'dfgdf', 54, 1486456481, 1, 1),
(3, 1, 25000, 110, 15, 'They are very impressed. Farmers say- "we are doing very well".', 1250, 1486457634, 1, 2),
(4, 1, 25000, 110, 15, 'They are very impressed. Farmers say- "we are doing very well".', 1250, 1486520131, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `ems_tm_fd_rep_details_participant`
--

CREATE TABLE IF NOT EXISTS `ems_tm_fd_rep_details_participant` (
  `id` int(11) NOT NULL,
  `budget_id` int(11) NOT NULL,
  `farmer_id` int(11) NOT NULL,
  `number` int(11) NOT NULL,
  `date_created` int(11) DEFAULT '0',
  `user_created` int(11) NOT NULL DEFAULT '0',
  `revision` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ems_tm_fd_rep_details_participant`
--

INSERT INTO `ems_tm_fd_rep_details_participant` (`id`, `budget_id`, `farmer_id`, `number`, `date_created`, `user_created`, `revision`) VALUES
(1, 5, 4, 34, 1486456319, 1, 2),
(2, 5, 4, 34, 1486456481, 1, 1),
(3, 1, 4, 60, 1486457634, 1, 2),
(4, 1, 4, 60, 1486520131, 1, 1),
(5, 1, 20, 30, 1486520131, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `ems_tm_fd_rep_details_picture`
--

CREATE TABLE IF NOT EXISTS `ems_tm_fd_rep_details_picture` (
  `id` int(11) NOT NULL,
  `budget_id` int(11) NOT NULL,
  `file_type` varchar(25) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_location` varchar(255) NOT NULL,
  `file_remarks` text,
  `date_created` int(11) NOT NULL DEFAULT '0',
  `user_created` int(11) NOT NULL DEFAULT '0',
  `revision` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=130 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ems_tm_fd_rep_details_picture`
--

INSERT INTO `ems_tm_fd_rep_details_picture` (`id`, `budget_id`, `file_type`, `file_name`, `file_location`, `file_remarks`, `date_created`, `user_created`, `revision`) VALUES
(18, 1, 'Image', 'icon6.JPG', 'images/field_day_reporting/1/icon6.JPG', 'icon', 1486175893, 1, 19),
(19, 1, 'Image', 'nun5.JPG', 'images/field_day_reporting/1/nun5.JPG', 'Sunny', 1486175893, 1, 19),
(20, 1, 'Image', 'atlas-70.JPG', 'images/field_day_reporting/1/atlas-70.JPG', 'Cabbage', 1486175893, 1, 19),
(21, 1, 'Video', 'demo2.mp4', 'images/field_day_reporting/1/demo2.mp4', NULL, 1486175893, 1, 19),
(22, 4, 'Image', 'quick_star.JPG', 'images/field_day_reporting/4/quick_star.JPG', 'How is it?', 1486176392, 1, 7),
(23, 4, 'Image', 'CHALLENGER.JPG', 'images/field_day_reporting/4/CHALLENGER.JPG', 'Best?', 1486176392, 1, 7),
(24, 4, 'Image', 'super_green.JPG', 'images/field_day_reporting/4/super_green.JPG', 'Awesome', 1486176392, 1, 7),
(25, 4, 'Video', 'Capture_20161228.wmv', 'images/field_day_reporting/4/Capture_20161228.wmv', NULL, 1486176392, 1, 7),
(28, 4, 'Image', 'quick_star.JPG', 'images/field_day_reporting/4/quick_star.JPG', 'How is it?', 1486199967, 1, 6),
(29, 4, 'Image', 'CHALLENGER.JPG', 'images/field_day_reporting/4/CHALLENGER.JPG', 'Best?', 1486199967, 1, 6),
(30, 4, 'Image', 'super_green.JPG', 'images/field_day_reporting/4/super_green.JPG', 'Awesome', 1486199967, 1, 6),
(31, 4, 'Video', 'Capture_20161228.wmv', 'images/field_day_reporting/4/Capture_20161228.wmv', NULL, 1486199967, 1, 6),
(32, 4, 'Image', 'quick_star.JPG', 'images/field_day_reporting/4/quick_star.JPG', 'How is it?', 1486200046, 1, 5),
(33, 4, 'Image', 'CHALLENGER.JPG', 'images/field_day_reporting/4/CHALLENGER.JPG', 'Best?', 1486200046, 1, 5),
(34, 4, 'Image', 'super_green.JPG', 'images/field_day_reporting/4/super_green.JPG', 'Awesome', 1486200046, 1, 5),
(35, 4, 'Video', 'Capture_20161228.wmv', 'images/field_day_reporting/4/Capture_20161228.wmv', NULL, 1486200046, 1, 5),
(36, 4, 'Image', 'quick_star.JPG', 'images/field_day_reporting/4/quick_star.JPG', 'How is it?', 1486200499, 1, 4),
(37, 4, 'Image', 'CHALLENGER.JPG', 'images/field_day_reporting/4/CHALLENGER.JPG', 'Best?', 1486200499, 1, 4),
(38, 4, 'Image', 'super_green.JPG', 'images/field_day_reporting/4/super_green.JPG', 'Awesome', 1486200499, 1, 4),
(39, 4, 'Video', 'Capture_20161228.wmv', 'images/field_day_reporting/4/Capture_20161228.wmv', NULL, 1486200499, 1, 4),
(40, 4, 'Image', 'quick_star.JPG', 'images/field_day_reporting/4/quick_star.JPG', 'How is it?', 1486200553, 1, 3),
(41, 4, 'Image', 'CHALLENGER.JPG', 'images/field_day_reporting/4/CHALLENGER.JPG', 'Best?', 1486200553, 1, 3),
(42, 4, 'Image', 'super_green.JPG', 'images/field_day_reporting/4/super_green.JPG', 'Awesome', 1486200553, 1, 3),
(43, 4, 'Video', 'Capture_20161228.wmv', 'images/field_day_reporting/4/Capture_20161228.wmv', NULL, 1486200553, 1, 3),
(44, 4, 'Image', 'quick_star.JPG', 'images/field_day_reporting/4/quick_star.JPG', 'How is it?', 1486200583, 1, 2),
(45, 4, 'Image', 'CHALLENGER.JPG', 'images/field_day_reporting/4/CHALLENGER.JPG', 'Best?', 1486200583, 1, 2),
(46, 4, 'Video', 'demo.mp4', 'images/field_day_reporting/4/demo.mp4', NULL, 1486200583, 1, 2),
(47, 4, 'Image', 'quick_star.JPG', 'images/field_day_reporting/4/quick_star.JPG', 'How is it?', 1486200659, 1, 1),
(48, 4, 'Image', 'CHALLENGER.JPG', 'images/field_day_reporting/4/CHALLENGER.JPG', 'Best?', 1486200659, 1, 1),
(49, 4, 'Video', 'demo.mp4', 'images/field_day_reporting/4/demo.mp4', NULL, 1486200659, 1, 1),
(55, 5, 'Image', 'icon.JPG', 'images/field_day_reporting/5/icon.JPG', 'ghfh', 1486281824, 1, 3),
(56, 5, 'Video', 'demo.mp4', 'images/field_day_reporting/5/demo.mp4', NULL, 1486281824, 1, 3),
(58, 1, 'Image', 'icon6.JPG', 'images/field_day_reporting/1/icon6.JPG', 'icon', 1486362341, 1, 17),
(59, 1, 'Image', 'nun5.JPG', 'images/field_day_reporting/1/nun5.JPG', 'Sunny', 1486362341, 1, 17),
(60, 1, 'Image', 'atlas-70.JPG', 'images/field_day_reporting/1/atlas-70.JPG', 'Cabbage', 1486362341, 1, 17),
(61, 1, 'Video', 'demo2.mp4', 'images/field_day_reporting/1/demo2.mp4', NULL, 1486362341, 1, 17),
(62, 1, 'Image', 'icon6.JPG', 'images/field_day_reporting/1/icon6.JPG', 'icon icon icon icon icon icon icon icon icon icon icon icon icon icon icon icon icon icon icon icon icon icon icon icon icon icon icon icon icon icon icon ', 1486437467, 1, 16),
(63, 1, 'Image', 'nun5.JPG', 'images/field_day_reporting/1/nun5.JPG', 'Sunny', 1486437467, 1, 16),
(64, 1, 'Image', 'atlas-70.JPG', 'images/field_day_reporting/1/atlas-70.JPG', 'Cabbage', 1486437467, 1, 16),
(65, 1, 'Video', 'demo2.mp4', 'images/field_day_reporting/1/demo2.mp4', NULL, 1486437467, 1, 16),
(66, 1, 'Image', 'icon6.JPG', 'images/field_day_reporting/1/icon6.JPG', 'Icon', 1486437522, 1, 15),
(67, 1, 'Image', 'nun5.JPG', 'images/field_day_reporting/1/nun5.JPG', 'Sunny', 1486437522, 1, 15),
(68, 1, 'Image', 'atlas-70.JPG', 'images/field_day_reporting/1/atlas-70.JPG', 'Cabbage', 1486437522, 1, 15),
(69, 1, 'Video', 'demo2.mp4', 'images/field_day_reporting/1/demo2.mp4', NULL, 1486437522, 1, 15),
(70, 1, 'Image', 'icon6.JPG', 'images/field_day_reporting/1/icon6.JPG', 'Hooray! Hooray! Hooray! Hooray! Hooray! Hooray! Hooray! Hooray! Hooray! Hooray! Hooray! Hooray! Hooray! Hooray! Hooray!', 1486438250, 1, 14),
(71, 1, 'Image', 'nun5.JPG', 'images/field_day_reporting/1/nun5.JPG', 'Sunny', 1486438250, 1, 14),
(72, 1, 'Image', 'atlas-70.JPG', 'images/field_day_reporting/1/atlas-70.JPG', 'Cabbage', 1486438250, 1, 14),
(73, 1, 'Video', 'demo2.mp4', 'images/field_day_reporting/1/demo2.mp4', NULL, 1486438250, 1, 14),
(74, 1, 'Image', 'icon6.JPG', 'images/field_day_reporting/1/icon6.JPG', 'Hooray! Hooray! Hooray! Hooray! Hooray! Hooray! Hooray! Hooray! Hooray! Hooray! Hooray! Hooray! Hooray! Hooray! Hooray! ', 1486438515, 1, 13),
(75, 1, 'Image', 'nun5.JPG', 'images/field_day_reporting/1/nun5.JPG', 'Sunny', 1486438515, 1, 13),
(76, 1, 'Image', 'atlas-70.JPG', 'images/field_day_reporting/1/atlas-70.JPG', 'Cabbage', 1486438515, 1, 13),
(77, 1, 'Video', 'demo2.mp4', 'images/field_day_reporting/1/demo2.mp4', NULL, 1486438515, 1, 13),
(78, 1, 'Image', 'icon6.JPG', 'images/field_day_reporting/1/icon6.JPG', 'Hooray! Hooray! Hooray! \r\nHooray! Hooray! Hooray! \r\nHooray! Hooray! Hooray! \r\nHooray! Hooray! Hooray!\r\n Hooray! Hooray! Hooray! ', 1486438706, 1, 12),
(79, 1, 'Image', 'nun5.JPG', 'images/field_day_reporting/1/nun5.JPG', 'Sunny', 1486438706, 1, 12),
(80, 1, 'Image', 'atlas-70.JPG', 'images/field_day_reporting/1/atlas-70.JPG', 'Cabbage', 1486438706, 1, 12),
(81, 1, 'Video', 'demo2.mp4', 'images/field_day_reporting/1/demo2.mp4', NULL, 1486438706, 1, 12),
(82, 1, 'Image', 'icon6.JPG', 'images/field_day_reporting/1/icon6.JPG', 'IconIconIconIcon\r\nIconIconIconIcon\r\nIconIconIconIcon', 1486440620, 1, 11),
(83, 1, 'Image', 'nun5.JPG', 'images/field_day_reporting/1/nun5.JPG', 'Sunny', 1486440620, 1, 11),
(84, 1, 'Image', 'atlas-70.JPG', 'images/field_day_reporting/1/atlas-70.JPG', 'Cabbage', 1486440620, 1, 11),
(85, 1, 'Video', 'demo2.mp4', 'images/field_day_reporting/1/demo2.mp4', NULL, 1486440620, 1, 11),
(86, 1, 'Image', 'icon6.JPG', 'images/field_day_reporting/1/icon6.JPG', 'IconIcon\r\nIconIconIcon\r\nIconIconIconIcon', 1486440723, 1, 10),
(87, 1, 'Image', 'nun5.JPG', 'images/field_day_reporting/1/nun5.JPG', 'Sunny', 1486440723, 1, 10),
(88, 1, 'Image', 'atlas-70.JPG', 'images/field_day_reporting/1/atlas-70.JPG', 'Cabbage', 1486440723, 1, 10),
(89, 1, 'Video', 'demo2.mp4', 'images/field_day_reporting/1/demo2.mp4', NULL, 1486440723, 1, 10),
(90, 1, 'Image', 'icon6.JPG', 'images/field_day_reporting/1/icon6.JPG', 'IconIconI conIconIconIco nIconIconIcon', 1486440752, 1, 9),
(91, 1, 'Image', 'nun5.JPG', 'images/field_day_reporting/1/nun5.JPG', 'Sunny', 1486440752, 1, 9),
(92, 1, 'Image', 'atlas-70.JPG', 'images/field_day_reporting/1/atlas-70.JPG', 'Cabbage', 1486440752, 1, 9),
(93, 1, 'Video', 'demo2.mp4', 'images/field_day_reporting/1/demo2.mp4', NULL, 1486440752, 1, 9),
(94, 1, 'Image', 'icon6.JPG', 'images/field_day_reporting/1/icon6.JPG', 'Thanks for your Program.', 1486440835, 1, 8),
(95, 1, 'Image', 'nun5.JPG', 'images/field_day_reporting/1/nun5.JPG', 'Sunny', 1486440835, 1, 8),
(96, 1, 'Image', 'atlas-70.JPG', 'images/field_day_reporting/1/atlas-70.JPG', 'Cabbage', 1486440835, 1, 8),
(97, 1, 'Video', 'demo2.mp4', 'images/field_day_reporting/1/demo2.mp4', NULL, 1486440835, 1, 8),
(98, 1, 'Image', 'icon6.JPG', 'images/field_day_reporting/1/icon6.JPG', 'Thanks for your Program. I''m happy about that Mr. X.', 1486440886, 1, 7),
(99, 1, 'Image', 'nun5.JPG', 'images/field_day_reporting/1/nun5.JPG', 'Sunny', 1486440886, 1, 7),
(100, 1, 'Image', 'atlas-70.JPG', 'images/field_day_reporting/1/atlas-70.JPG', 'Cabbage', 1486440886, 1, 7),
(101, 1, 'Video', 'demo2.mp4', 'images/field_day_reporting/1/demo2.mp4', NULL, 1486440886, 1, 7),
(102, 1, 'Image', 'icon6.JPG', 'images/field_day_reporting/1/icon6.JPG', 'This is some information for our tooltip.', 1486441822, 1, 6),
(103, 1, 'Image', 'nun5.JPG', 'images/field_day_reporting/1/nun5.JPG', 'Sunny', 1486441822, 1, 6),
(104, 1, 'Image', 'atlas-70.JPG', 'images/field_day_reporting/1/atlas-70.JPG', 'Cabbage', 1486441822, 1, 6),
(105, 1, 'Video', 'demo2.mp4', 'images/field_day_reporting/1/demo2.mp4', NULL, 1486441822, 1, 6),
(106, 1, 'Image', 'icon6.JPG', 'images/field_day_reporting/1/icon6.JPG', 'My name is S. M. Imtiaz Hasan. So this is all about me. Any question?.\r\n', 1486444340, 1, 5),
(107, 1, 'Image', 'nun5.JPG', 'images/field_day_reporting/1/nun5.JPG', 'Sunny', 1486444340, 1, 5),
(108, 1, 'Image', 'atlas-70.JPG', 'images/field_day_reporting/1/atlas-70.JPG', 'Cabbage', 1486444340, 1, 5),
(109, 1, 'Video', 'demo2.mp4', 'images/field_day_reporting/1/demo2.mp4', NULL, 1486444340, 1, 5),
(110, 1, 'Image', 'icon6.JPG', 'images/field_day_reporting/1/icon6.JPG', 'Thanks for Coming.\r\n', 1486444394, 1, 4),
(111, 1, 'Image', 'nun5.JPG', 'images/field_day_reporting/1/nun5.JPG', 'Sunny', 1486444394, 1, 4),
(112, 1, 'Image', 'atlas-70.JPG', 'images/field_day_reporting/1/atlas-70.JPG', 'Cabbage', 1486444394, 1, 4),
(113, 1, 'Video', 'demo2.mp4', 'images/field_day_reporting/1/demo2.mp4', NULL, 1486444394, 1, 4),
(114, 1, 'Image', 'icon6.JPG', 'images/field_day_reporting/1/icon6.JPG', 'Thanks for Coming.\r\n', 1486453132, 1, 3),
(115, 1, 'Image', 'nun5.JPG', 'images/field_day_reporting/1/nun5.JPG', 'Sunny', 1486453132, 1, 3),
(116, 1, 'Image', 'atlas-70.JPG', 'images/field_day_reporting/1/atlas-70.JPG', 'Cabbage', 1486453132, 1, 3),
(117, 1, 'Video', 'Capture_20161228.wmv', 'images/field_day_reporting/1/Capture_20161228.wmv', NULL, 1486453132, 1, 3),
(118, 5, 'Image', 'Shomy.JPG', 'images/field_day_reporting/5/Shomy.JPG', '', 1486456319, 1, 2),
(119, 5, 'Video', 'demo1.mp4', 'images/field_day_reporting/5/demo1.mp4', NULL, 1486456319, 1, 2),
(120, 5, 'Image', 'Shomy.JPG', 'images/field_day_reporting/5/Shomy.JPG', 'gogg', 1486456481, 1, 1),
(121, 5, 'Video', 'demo1.mp4', 'images/field_day_reporting/5/demo1.mp4', NULL, 1486456481, 1, 1),
(122, 1, 'Image', 'Aarti.JPG', 'images/field_day_reporting/1/Aarti.JPG', 'Okay', 1486457634, 1, 2),
(123, 1, 'Image', 'asha.JPG', 'images/field_day_reporting/1/asha.JPG', 'Not OKay?', 1486457634, 1, 2),
(124, 1, 'Image', 'suvra.JPG', 'images/field_day_reporting/1/suvra.JPG', 'Dismiss', 1486457634, 1, 2),
(125, 1, 'Video', 'demo.mp4', 'images/field_day_reporting/1/demo.mp4', NULL, 1486457634, 1, 2),
(126, 1, 'Image', 'Aarti.JPG', 'images/field_day_reporting/1/Aarti.JPG', 'Okay', 1486520131, 1, 1),
(127, 1, 'Image', 'asha.JPG', 'images/field_day_reporting/1/asha.JPG', 'Not OKay?', 1486520131, 1, 1),
(128, 1, 'Image', 'suvra.JPG', 'images/field_day_reporting/1/suvra.JPG', 'Dismiss', 1486520131, 1, 1),
(129, 1, 'Video', 'demo.mp4', 'images/field_day_reporting/1/demo.mp4', NULL, 1486520131, 1, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ems_setup_fd_bud_expense_items`
--
ALTER TABLE `ems_setup_fd_bud_expense_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ems_setup_fd_bud_picture_category`
--
ALTER TABLE `ems_setup_fd_bud_picture_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ems_tm_fd_bud_budget`
--
ALTER TABLE `ems_tm_fd_bud_budget`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ems_tm_fd_bud_details_expense`
--
ALTER TABLE `ems_tm_fd_bud_details_expense`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ems_tm_fd_bud_details_participant`
--
ALTER TABLE `ems_tm_fd_bud_details_participant`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ems_tm_fd_bud_details_picture`
--
ALTER TABLE `ems_tm_fd_bud_details_picture`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ems_tm_fd_bud_info_details`
--
ALTER TABLE `ems_tm_fd_bud_info_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ems_tm_fd_bud_reporting`
--
ALTER TABLE `ems_tm_fd_bud_reporting`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ems_tm_fd_rep_details_expense`
--
ALTER TABLE `ems_tm_fd_rep_details_expense`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ems_tm_fd_rep_details_info`
--
ALTER TABLE `ems_tm_fd_rep_details_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ems_tm_fd_rep_details_participant`
--
ALTER TABLE `ems_tm_fd_rep_details_participant`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ems_tm_fd_rep_details_picture`
--
ALTER TABLE `ems_tm_fd_rep_details_picture`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ems_setup_fd_bud_expense_items`
--
ALTER TABLE `ems_setup_fd_bud_expense_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `ems_setup_fd_bud_picture_category`
--
ALTER TABLE `ems_setup_fd_bud_picture_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `ems_tm_fd_bud_budget`
--
ALTER TABLE `ems_tm_fd_bud_budget`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `ems_tm_fd_bud_details_expense`
--
ALTER TABLE `ems_tm_fd_bud_details_expense`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `ems_tm_fd_bud_details_participant`
--
ALTER TABLE `ems_tm_fd_bud_details_participant`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `ems_tm_fd_bud_details_picture`
--
ALTER TABLE `ems_tm_fd_bud_details_picture`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `ems_tm_fd_bud_info_details`
--
ALTER TABLE `ems_tm_fd_bud_info_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `ems_tm_fd_bud_reporting`
--
ALTER TABLE `ems_tm_fd_bud_reporting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `ems_tm_fd_rep_details_expense`
--
ALTER TABLE `ems_tm_fd_rep_details_expense`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT for table `ems_tm_fd_rep_details_info`
--
ALTER TABLE `ems_tm_fd_rep_details_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `ems_tm_fd_rep_details_participant`
--
ALTER TABLE `ems_tm_fd_rep_details_participant`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `ems_tm_fd_rep_details_picture`
--
ALTER TABLE `ems_tm_fd_rep_details_picture`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=130;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
