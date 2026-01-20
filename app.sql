-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 20, 2026 at 04:10 PM
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
-- Table structure for table `activity_log`
--

CREATE TABLE `activity_log` (
  `activity_log_id` int(11) NOT NULL,
  `activity_log_entity_type` varchar(50) NOT NULL,
  `activity_log_entity_id` int(11) NOT NULL,
  `activity_log_action` varchar(255) NOT NULL,
  `activity_log_user` varchar(100) NOT NULL,
  `activity_log_timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `code_master`
--

CREATE TABLE `code_master` (
  `code_master_id` int(11) NOT NULL,
  `code_master_category` varchar(200) NOT NULL,
  `code_master_code` varchar(100) NOT NULL,
  `code_master_label` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `code_master`
--

INSERT INTO `code_master` (`code_master_id`, `code_master_category`, `code_master_code`, `code_master_label`) VALUES
(1, 'form_status', '0', 'Draft'),
(2, 'form_status', '1', 'Submitted'),
(3, 'item_status', '0', 'Tidak Aktif'),
(4, 'item_status', '1', 'Aktif'),
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
(19, 'ticket_status', '1', 'Dalam Pengerjaan'),
(20, 'ticket_status', '2', 'Tertunda'),
(21, 'ticket_status', '3', 'Pengerjaan Selesai'),
(22, 'ticket_status', '4', 'Closed'),
(23, 'form_item_status', '0', 'OK'),
(24, 'form_item_status', '1', 'Rusak');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `user_master`
--

INSERT INTO `user_master` (`user_master_id`, `user_master_uname`, `user_master_passw`, `user_master_role`, `user_master_createby`, `user_master_createtime`) VALUES
(1, 'admin', '$2y$10$tq5Ry7BywiBbo7ycialzHe9TMyYYz4rToOMrz7CRQHWdrXrEHi5WW', 'admin', NULL, NULL),
(2, 'user', '$2y$10$9QHzFCnDMk/D6Sgj3hnBtucZ7.p9x7k6fV53kqZIzW2h2Prkxf6iK', 'user', 'admin', '2026-01-20 09:10:19');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_log`
--
ALTER TABLE `activity_log`
  ADD PRIMARY KEY (`activity_log_id`);

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
-- AUTO_INCREMENT for table `activity_log`
--
ALTER TABLE `activity_log`
  MODIFY `activity_log_id` int(11) NOT NULL AUTO_INCREMENT;

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
  MODIFY `code_master_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

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
  MODIFY `user_master_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
