-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 29, 2025 at 02:39 PM
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `activity_log`
--

INSERT INTO `activity_log` (`activity_log_id`, `activity_log_entity_type`, `activity_log_entity_id`, `activity_log_action`, `activity_log_user`, `activity_log_timestamp`) VALUES
(1, 'Area', 1, 'Add new area: Area 1', 'admin', '2025-12-26 10:35:36'),
(2, 'Item', 1, 'Add new item: Barang 1', 'admin', '2025-12-26 10:36:57'),
(3, 'Item', 2, 'Add new item: Barang 2', 'admin', '2025-12-26 10:37:34'),
(4, 'Area', 2, 'Add new area: Area 2', 'admin', '2025-12-26 10:38:05'),
(5, 'Item', 3, 'Add new item: Item 1', 'admin', '2025-12-26 10:38:19'),
(6, 'Item', 4, 'Add new item: Item 2', 'admin', '2025-12-26 10:39:05'),
(7, 'Item', 1, 'Updated item name to Barang 1 [Edit]', 'admin', '2025-12-26 10:39:43'),
(8, 'Item', 1, 'Updated item category to infra_it', 'admin', '2025-12-26 10:40:15'),
(9, 'Item', 1, 'Updated item name to Barang 1 [Updated]', 'admin', '2025-12-26 10:40:49'),
(10, 'Item', 1, 'Updated item category to layanan_umum', 'admin', '2025-12-26 10:40:49'),
(11, 'Item', 1, 'Updated item status to Array', 'admin', '2025-12-26 10:40:49'),
(12, 'Item', 1, 'Updated item status to Active', 'admin', '2025-12-26 10:41:53'),
(13, 'Item', 1, 'Moved item to Area 2', 'admin', '2025-12-26 10:42:20'),
(14, 'Item', 1, 'Moved item to Area 1', 'admin', '2025-12-26 10:47:27'),
(15, 'Checking Form', 1, 'Created new checking form', 'admin', '2025-12-26 10:48:35'),
(16, 'Checking Form', 1, 'Submitted the form.', 'admin', '2025-12-26 10:48:55'),
(17, 'Checking Form', 1, 'Redraft the form', 'admin', '2025-12-26 10:49:29'),
(18, 'Checking Form', 1, 'Submitted the form', 'admin', '2025-12-26 10:49:54'),
(19, 'Checking Form', 2, 'Created new checking form', 'admin', '2025-12-26 10:52:46'),
(20, 'Ticket', 1, 'Ticket status changed to In Progress', 'admin', '2025-12-29 02:05:18'),
(21, 'Ticket', 2, 'Created new ticket assigned to user', 'admin', '2025-12-29 02:10:00'),
(22, 'Ticket', 2, 'Ticket status changed to In Progress', 'user', '2025-12-29 02:10:56'),
(23, 'Ticket', 2, 'Ticket status changed to On Hold', 'user', '2025-12-29 02:11:59'),
(24, 'Item', 2, 'Moved item from Area 1 to Area 2', 'user', '2025-12-29 04:22:56'),
(25, 'Item', 2, 'Updated item name from Barang 2 to Barang 3', 'user', '2025-12-29 04:24:29'),
(26, 'Item', 2, 'Updated item name from Barang 3 to Barang 2', 'user', '2025-12-29 04:25:20'),
(27, 'Item', 2, 'Moved item from Area 2 to Area 1', 'user', '2025-12-29 04:25:20'),
(28, 'Ticket', 1, 'Ticket closed', 'user', '2025-12-29 06:22:33');

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

--
-- Dumping data for table `area_master`
--

INSERT INTO `area_master` (`area_master_id`, `area_master_name`, `area_master_description`, `area_master_floor`, `area_master_createby`, `area_master_createtime`) VALUES
(1, 'Area 1', 'Test Add Area 1', '1', 'admin', '2025-12-26 10:35:36'),
(2, 'Area 2', 'Test Add Area 2', '2', 'admin', '2025-12-26 10:38:05');

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

--
-- Dumping data for table `checkingform_detail`
--

INSERT INTO `checkingform_detail` (`checkingform_detail_id`, `checkingform_detail_master_id`, `checkingform_detail_item_id`, `checkingform_detail_item_status`, `checkingform_detail_createby`, `checkingform_detail_createtime`) VALUES
(1, '1', '1', '0', 'admin', '2025-12-26 10:48:53'),
(2, '1', '2', '0', 'admin', '2025-12-26 10:48:53');

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

--
-- Dumping data for table `checkingform_master`
--

INSERT INTO `checkingform_master` (`checkingform_master_id`, `checkingform_master_effdate`, `checkingform_master_area_id`, `checkingform_master_remark`, `checkingform_master_status`, `checkingform_master_createby`, `checkingform_master_createtime`) VALUES
(1, '2025-12-26', '1', 'Test Logs', '1', 'admin', '2025-12-26 10:49:54'),
(2, '2025-12-26', '2', 'test ', '0', 'admin', '2025-12-26 10:52:46');

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

--
-- Dumping data for table `item_master`
--

INSERT INTO `item_master` (`item_master_id`, `item_master_area_id`, `item_master_name`, `item_master_category`, `item_master_status`, `item_master_picture_path`, `item_master_createby`, `item_master_createtime`) VALUES
(1, '1', 'Barang 1 [Updated]', 'layanan_umum', '1', NULL, 'admin', '2025-12-29 06:22:33'),
(2, '1', 'Barang 2', 'kelistrikan', '1', NULL, 'admin', '2025-12-29 04:25:20'),
(3, '2', 'Item 1', 'keamanan', '1', NULL, 'admin', '2025-12-26 10:38:19'),
(4, '2', 'Item 2', 'kelistrikan', '3', NULL, 'admin', '2025-12-29 02:10:00');

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

--
-- Dumping data for table `ticket_detail`
--

INSERT INTO `ticket_detail` (`ticket_detail_id`, `ticket_detail_master_id`, `ticket_detail_comment`, `ticket_detail_commentby`, `ticket_detail_commenttime`) VALUES
(1, 1, 'Admin mengubah status tiket menjadi <b>In Progress</b> dengan remarks: logs 1', 'admin', '2025-12-29 02:05:18'),
(2, 2, 'User mengubah status tiket menjadi <b>In Progress</b> dengan remarks: ok', 'user', '2025-12-29 02:10:56'),
(3, 2, 'User mengubah status tiket menjadi <b>On Hold</b> dengan remarks: hold on!', 'user', '2025-12-29 02:11:59'),
(4, 1, 'Tiket <b>Closed</b> dengan remaks: nnnmnm', 'user', '2025-12-29 06:22:33');

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

--
-- Dumping data for table `ticket_master`
--

INSERT INTO `ticket_master` (`ticket_master_id`, `ticket_master_topic`, `ticket_master_description`, `ticket_master_item_id`, `ticket_master_effdate`, `ticket_master_status`, `ticket_master_currentholder`, `ticket_master_createby`, `ticket_master_createtime`) VALUES
(1, 'test', 'test', 1, '2025-12-26', '4', 'user', 'admin', '2025-12-29 06:22:33'),
(2, 'check logs', 'check logs', 4, '2025-12-29', '2', 'user', 'admin', '2025-12-29 02:11:59');

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
(1, 'admin', '$2y$10$5VMGR0.M1Qd2YZa2SGb8XuWM2uxghQGy5AphUae8cu0IqD1ZYfGHe', 'admin', NULL, NULL),
(2, 'user', '$2y$10$nL0dO6iSBBGLcYv.J7yT8.c9bpUTKyOMITOCLwt5ku2RCp8cN85JK', 'user', 'admin', '2025-12-20 06:33:54');

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
  MODIFY `activity_log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `area_master`
--
ALTER TABLE `area_master`
  MODIFY `area_master_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `checkingform_detail`
--
ALTER TABLE `checkingform_detail`
  MODIFY `checkingform_detail_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `checkingform_master`
--
ALTER TABLE `checkingform_master`
  MODIFY `checkingform_master_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `code_master`
--
ALTER TABLE `code_master`
  MODIFY `code_master_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `item_master`
--
ALTER TABLE `item_master`
  MODIFY `item_master_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `ticket_detail`
--
ALTER TABLE `ticket_detail`
  MODIFY `ticket_detail_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `ticket_master`
--
ALTER TABLE `ticket_master`
  MODIFY `ticket_master_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user_master`
--
ALTER TABLE `user_master`
  MODIFY `user_master_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
