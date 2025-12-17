-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 17, 2025 at 11:43 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `app`
--

-- --------------------------------------------------------

--
-- Table structure for table `area_master`
--

CREATE TABLE `area_master` (
  `area_master_id` int(11) NOT NULL,
  `area_master_name` varchar(200) NOT NULL,
  `area_master_description` varchar(250) DEFAULT NULL,
  `area_master_floor` varchar(10) NOT NULL,
  `area_master_createby` varchar(150) DEFAULT NULL,
  `area_master_createtime` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `checkingform_detail`
--

CREATE TABLE `checkingform_detail` (
  `checkingform_detail_id` int(11) NOT NULL,
  `checkingform_detail_master_id` varchar(10) NOT NULL,
  `checkingform_detail_item_id` varchar(10) NOT NULL,
  `checkingform_detail_item_status` varchar(100) NOT NULL,
  `checkingform_detail_createby` varchar(150) NOT NULL,
  `checkingform_detail_createtime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `checkingform_master`
--

CREATE TABLE `checkingform_master` (
  `checkingform_master_id` int(11) NOT NULL,
  `checkingform_master_effdate` date NOT NULL,
  `checkingform_master_area_id` varchar(10) NOT NULL,
  `checkingform_master_remark` varchar(250) NOT NULL,
  `checkingform_master_status` varchar(10) NOT NULL,
  `checkingform_master_createby` varchar(150) NOT NULL,
  `checkingform_master_createtime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `code_master`
--

CREATE TABLE `code_master` (
  `code_master_id` int(11) NOT NULL,
  `code_master_category` varchar(200) NOT NULL,
  `code_master_code` varchar(100) NOT NULL,
  `code_master_label` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `code_master`
--

INSERT INTO `code_master` (`code_master_id`, `code_master_category`, `code_master_code`, `code_master_label`) VALUES
(1, 'form_status', '0', 'Draft'),
(2, 'form_status', '1', 'Submitted'),
(3, 'item_status', '0', 'In Active'),
(4, 'item_status', '1', 'Active'),
(5, 'item_status', '2', 'Disposed'),
(8, 'item_status', '3', 'Maintenance'),
(9, 'item_category', 'kelistrikan', 'Kelistrikan'),
(10, 'item_category', 'perpipaan', 'Perpipaan & Air'),
(11, 'item_category', 'keselamatan', 'Keselamatan & K3'),
(12, 'item_category', 'bangunan', 'Struktur Bangunan'),
(13, 'item_category', 'keamanan', 'Keamanan (Security)'),
(14, 'item_category', 'mebel', 'Mebel & Inventaris'),
(15, 'item_category', 'infra_it', 'Infrastruktur IT (Fisik)'),
(16, 'item_category', 'elektronik_pantri', 'Elektronik Pantri'),
(17, 'item_category', 'layanan_umum', 'Layanan Umum (Janitorial)'),
(18, 'ticket_status', '0', 'Open'),
(19, 'ticket_status', '1', 'In Progress'),
(20, 'ticket_status', '2', 'On Hold'),
(21, 'ticket_status', '3', 'Resolved'),
(22, 'ticket_status', '4', 'Closed');

-- --------------------------------------------------------

--
-- Table structure for table `item_master`
--

CREATE TABLE `item_master` (
  `item_master_id` int(11) NOT NULL,
  `item_master_area_id` varchar(10) NOT NULL,
  `item_master_name` varchar(200) NOT NULL,
  `item_master_category` varchar(200) NOT NULL,
  `item_master_status` varchar(10) NOT NULL,
  `item_master_picture_path` varchar(250) DEFAULT NULL,
  `item_master_createby` varchar(150) NOT NULL,
  `item_master_createtime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ticket_detail`
--

CREATE TABLE `ticket_detail` (
  `ticket_detail_id` int(11) NOT NULL,
  `ticket_detail_master_id` int(11) NOT NULL,
  `ticket_detail_comment` varchar(250) NOT NULL,
  `ticket_detail_commentby` varchar(150) NOT NULL,
  `ticket_detail_commenttime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ticket_master`
--

CREATE TABLE `ticket_master` (
  `ticket_master_id` int(11) NOT NULL,
  `ticket_master_topic` varchar(250) NOT NULL,
  `ticket_master_description` varchar(250) NOT NULL,
  `ticket_master_item_id` int(11) NOT NULL,
  `ticket_master_effdate` date NOT NULL,
  `ticket_master_status` varchar(10) NOT NULL,
  `ticket_master_currentholder` varchar(150) NOT NULL,
  `ticket_master_createby` varchar(150) NOT NULL,
  `ticket_master_createtime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_master`
--

CREATE TABLE `user_master` (
  `user_master_id` int(11) NOT NULL,
  `user_master_uname` varchar(150) NOT NULL,
  `user_master_passw` varchar(150) NOT NULL,
  `user_master_role` varchar(150) NOT NULL,
  `user_master_createby` varchar(150) DEFAULT NULL,
  `user_master_createtime` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_master`
--

INSERT INTO `user_master` (`user_master_id`, `user_master_uname`, `user_master_passw`, `user_master_role`, `user_master_createby`, `user_master_createtime`) VALUES
(1, 'admin', '$2y$10$5VMGR0.M1Qd2YZa2SGb8XuWM2uxghQGy5AphUae8cu0IqD1ZYfGHe', 'admin', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `area_master`
--
ALTER TABLE `area_master`
  ADD PRIMARY KEY (`area_master_id`);

--
-- Indexes for table `checkingform_detail`
--
ALTER TABLE `checkingform_detail`
  ADD PRIMARY KEY (`checkingform_detail_id`);

--
-- Indexes for table `checkingform_master`
--
ALTER TABLE `checkingform_master`
  ADD PRIMARY KEY (`checkingform_master_id`);

--
-- Indexes for table `code_master`
--
ALTER TABLE `code_master`
  ADD PRIMARY KEY (`code_master_id`);

--
-- Indexes for table `item_master`
--
ALTER TABLE `item_master`
  ADD PRIMARY KEY (`item_master_id`);

--
-- Indexes for table `ticket_detail`
--
ALTER TABLE `ticket_detail`
  ADD PRIMARY KEY (`ticket_detail_id`);

--
-- Indexes for table `ticket_master`
--
ALTER TABLE `ticket_master`
  ADD PRIMARY KEY (`ticket_master_id`);

--
-- Indexes for table `user_master`
--
ALTER TABLE `user_master`
  ADD PRIMARY KEY (`user_master_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `area_master`
--
ALTER TABLE `area_master`
  MODIFY `area_master_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `checkingform_detail`
--
ALTER TABLE `checkingform_detail`
  MODIFY `checkingform_detail_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `checkingform_master`
--
ALTER TABLE `checkingform_master`
  MODIFY `checkingform_master_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `code_master`
--
ALTER TABLE `code_master`
  MODIFY `code_master_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `item_master`
--
ALTER TABLE `item_master`
  MODIFY `item_master_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ticket_detail`
--
ALTER TABLE `ticket_detail`
  MODIFY `ticket_detail_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ticket_master`
--
ALTER TABLE `ticket_master`
  MODIFY `ticket_master_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_master`
--
ALTER TABLE `user_master`
  MODIFY `user_master_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
