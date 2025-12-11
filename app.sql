-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 05, 2025 at 01:22 PM
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

--
-- Dumping data for table `area_master`
--

INSERT INTO `area_master` (`area_master_id`, `area_master_name`, `area_master_description`, `area_master_floor`, `area_master_createby`, `area_master_createtime`) VALUES
(1, 'Resepsionist', '', '1', 'admin', '2025-12-04 03:23:00'),
(2, 'Parkiran', 'Parkiran basement', '0', 'admin', '2025-12-04 06:01:24'),
(3, 'Ruang Live', 'Ruangan live streaming untuk avana', '1', 'admin', '2025-12-04 09:24:43'),
(4, 'Smoking Room', 'Area pelepas penat', '3', 'guntur', '2025-12-04 10:11:21');

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
(4, '3', '1', '0', 'admin', '2025-12-04 05:59:58'),
(5, '4', '3', '0', 'admin', '2025-12-04 06:03:39'),
(6, '4', '4', '0', 'admin', '2025-12-04 06:03:39'),
(8, '5', '8', '0', 'admin', '2025-12-04 10:26:52'),
(9, '5', '9', '0', 'admin', '2025-12-04 10:26:52'),
(10, '5', '10', '0', 'admin', '2025-12-04 10:27:01');

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
(3, '2025-12-04', '1', 'pengecekan harian', '0', 'admin', '2025-12-05 03:24:40'),
(4, '2025-12-04', '2', 'Pengecekan mingguan', '1', 'admin', '2025-12-05 03:26:03'),
(5, '2025-12-04', '3', '', '1', 'admin', '2025-12-05 02:29:50'),
(6, '2025-12-05', '3', 'test', '0', 'admin', '2025-12-05 04:30:46');

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
(1, 'form_status', '0', 'draft'),
(2, 'form_status', '1', 'submitted'),
(3, 'item_status', '0', 'inactive'),
(4, 'item_status', '1', 'active'),
(5, 'item_status', '2', 'disposed'),
(8, 'item_status', '3', 'maintenance'),
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
(19, 'ticket_status', '1', 'Closed');

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
  `item_master_createby` varchar(150) NOT NULL,
  `item_master_createtime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `item_master`
--

INSERT INTO `item_master` (`item_master_id`, `item_master_area_id`, `item_master_name`, `item_master_category`, `item_master_status`, `item_master_createby`, `item_master_createtime`) VALUES
(1, '1', 'Lampu', 'kelistrikan', '1', 'admin', '2025-12-04 05:09:02'),
(2, '1', 'AC', 'kelistrikan', '1', 'admin', '2025-12-04 06:00:34'),
(3, '2', 'Mesin Air', 'perpipaan', '3', 'admin', '2025-12-05 02:38:07'),
(4, '2', 'Toren PAM', 'perpipaan', '1', 'admin', '2025-12-04 06:02:34'),
(5, '2', 'CCTV', 'keamanan', '1', 'admin', '2025-12-04 06:02:50'),
(6, '2', 'Lampu', 'kelistrikan', '1', 'admin', '2025-12-04 06:03:06'),
(7, '3', 'PC Live Streaming', 'infra_it', '1', 'admin', '2025-12-04 09:25:11'),
(8, '3', 'AC', 'kelistrikan', '1', 'admin', '2025-12-04 09:25:27'),
(9, '3', 'Lampu', 'kelistrikan', '1', 'admin', '2025-12-04 09:25:50'),
(10, '3', 'Plafon', 'bangunan', '3', 'admin', '2025-12-05 02:37:13'),
(11, '4', 'Gudang Garam Signature', 'keselamatan', '1', 'guntur', '2025-12-04 10:12:02');

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
(1, 2, '<p>mohon dibantu untuk perbaikan plafon di ruang live pak, saat ini jika sedang hujan kadang bocor.</p>', 'guntur', '2025-12-04 09:45:56'),
(2, 2, '<p>saat ini jika sedang hujan, titik bocor yang menetes ditampung oleh tempat sampah kecil yang ada diruangan</p>', 'guntur', '2025-12-04 09:48:37'),
(3, 1, '<p>Saat ini lampu sudah benar lagi, solved dengan dilempar pakai sendal</p>', 'guntur', '2025-12-04 09:54:25'),
(4, 1, '<p>Tiket akan diclose</p>', 'guntur', '2025-12-04 09:54:41'),
(5, 3, 'Created new ticket!', 'guntur', '2025-12-04 10:12:46'),
(6, 3, '<p>mohon untuk bisa ada penambahan tempat untuk merokok di lantai 3</p>', 'guntur', '2025-12-04 10:13:56'),
(7, 3, '<p><strong>Urgent!!</strong><span class=\"ql-cursor\">ï»¿</span></p>', 'guntur', '2025-12-04 10:14:35'),
(8, 3, '<p>jangan ngadi-ngadi</p>', 'admin', '2025-12-04 10:15:43'),
(9, 3, '<p>tiket akan diclose ya</p>', 'admin', '2025-12-04 10:15:53'),
(10, 0, 'Created new ticket!', 'admin', '2025-12-05 02:38:07'),
(11, 4, '<p>untuk colokan tidak ada masalah, kabel sepertinya terbakar karena konsleting. sudah disambung ulang, tapi mesin tetap tidak mau hidup</p>', 'admin', '2025-12-05 02:40:23');

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
(1, 'lampu meja resepsionis mati hidup', 'lampu mati hidup, jika mendung atau menjelang gelap akan sangat mengganggu', 1, '2025-12-04', '1', 'admin', 'admin', '2025-12-04 10:02:05'),
(2, 'Plafon bocor', 'plafon ruang online sering bocor jika hujan, akan mengganggu kegiatan live stream, juga potensi komputer dan lampu rusak jika terkena air hujan', 10, '2025-12-04', '0', 'admin', 'admin', '2025-12-04 10:20:26'),
(3, 'Ruangan tidak tersedia', 'Ruangan tidak tersedia, error 404', 11, '2025-12-04', '1', 'guntur', 'guntur', '2025-12-04 10:16:09'),
(4, 'mesin tidak berfungsi', 'mesin pompa air tidak hidup, sebelumnya ada bau gosong', 3, '2025-12-05', '0', 'admin', 'admin', '2025-12-05 02:38:07');

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
(3, 'admin', '$2y$10$5VMGR0.M1Qd2YZa2SGb8XuWM2uxghQGy5AphUae8cu0IqD1ZYfGHe', 'admin', '', '2025-11-20 09:32:17'),
(29, 'guntur', '$2y$10$j6cT8DOhmQi00j8aeMw6UOHonlIZvfl3DoMI5L0lp0RjqVpAsr5PG', 'user', 'admin', '2025-12-04 07:13:43');

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
  MODIFY `area_master_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `checkingform_detail`
--
ALTER TABLE `checkingform_detail`
  MODIFY `checkingform_detail_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `checkingform_master`
--
ALTER TABLE `checkingform_master`
  MODIFY `checkingform_master_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `code_master`
--
ALTER TABLE `code_master`
  MODIFY `code_master_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `item_master`
--
ALTER TABLE `item_master`
  MODIFY `item_master_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `ticket_detail`
--
ALTER TABLE `ticket_detail`
  MODIFY `ticket_detail_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `ticket_master`
--
ALTER TABLE `ticket_master`
  MODIFY `ticket_master_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `user_master`
--
ALTER TABLE `user_master`
  MODIFY `user_master_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
