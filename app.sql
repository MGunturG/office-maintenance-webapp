-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 08, 2026 at 10:46 AM
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
(1, 'Area', 1, 'Add new area: Parkiran', 'admin', '2026-01-05 06:23:29'),
(2, 'Item', 1, 'Add new item: Lampu', 'admin', '2026-01-05 06:23:47'),
(3, 'Item', 2, 'Add new item: CCTV', 'admin', '2026-01-05 06:23:59'),
(4, 'Item', 3, 'Add new item: Mesin Air', 'admin', '2026-01-05 06:24:18'),
(5, 'Item', 4, 'Add new item: Toren PAM', 'admin', '2026-01-05 06:24:32'),
(6, 'Area', 2, 'Add new area: Area Luar Gedung', 'admin', '2026-01-05 06:25:17'),
(7, 'Item', 5, 'Add new item: Lampu Lobby Luar', 'admin', '2026-01-05 06:26:18'),
(8, 'Item', 6, 'Add new item: Lampu Depan Gudang', 'admin', '2026-01-05 06:26:33'),
(9, 'Item', 7, 'Add new item: Lampu Dinding Luar', 'admin', '2026-01-05 06:26:47'),
(10, 'Item', 7, 'Updated item category to kelistrikan', 'admin', '2026-01-05 06:26:58'),
(11, 'Item', 8, 'Add new item: CCTV Lobby Luar', 'admin', '2026-01-05 06:27:20'),
(12, 'Area', 3, 'Add new area: Resepsionist & Lobby', 'admin', '2026-01-05 06:28:06'),
(13, 'Item', 9, 'Add new item: Lampu', 'admin', '2026-01-05 06:28:28'),
(14, 'Item', 10, 'Add new item: AC', 'admin', '2026-01-05 06:28:37'),
(15, 'Item', 11, 'Add new item: CCTV', 'admin', '2026-01-05 06:28:52'),
(16, 'Area', 4, 'Add new area: Toilet', 'admin', '2026-01-05 06:29:50'),
(17, 'Item', 12, 'Add new item: Lampu Toilet Urinoir', 'admin', '2026-01-05 06:30:40'),
(18, 'Item', 13, 'Add new item: Lampu Toilet Pria', 'admin', '2026-01-05 06:30:55'),
(19, 'Item', 14, 'Add new item: Lampu Toilet Perempuan', 'admin', '2026-01-05 06:31:09'),
(20, 'Item', 15, 'Add new item: Lampu Kamar Mandi', 'admin', '2026-01-05 06:31:25'),
(21, 'Item', 16, 'Add new item: Lampu Wastafel', 'admin', '2026-01-05 06:31:45'),
(22, 'Item', 17, 'Add new item: Hand Dryer', 'admin', '2026-01-05 06:32:33'),
(23, 'Area', 5, 'Add new area: Pantry', 'admin', '2026-01-05 06:33:11'),
(24, 'Item', 18, 'Add new item: Lampu', 'admin', '2026-01-05 06:33:23'),
(25, 'Item', 19, 'Add new item: Microwave', 'admin', '2026-01-05 06:33:34'),
(26, 'Item', 20, 'Add new item: Dispenser Galon', 'admin', '2026-01-05 06:33:49'),
(27, 'Area', 6, 'Add new area: Ruang Meeting', 'admin', '2026-01-05 06:34:40'),
(28, 'Item', 21, 'Add new item: Lampu', 'admin', '2026-01-05 06:34:51'),
(29, 'Item', 22, 'Add new item: AC', 'admin', '2026-01-05 06:35:03'),
(30, 'Area', 7, 'Add new area: Ruang Makan', 'admin', '2026-01-05 06:35:27'),
(31, 'Item', 23, 'Add new item: Lampu', 'admin', '2026-01-05 06:35:37'),
(32, 'Item', 24, 'Add new item: AC', 'admin', '2026-01-05 06:35:47'),
(33, 'Item', 25, 'Add new item: CCTV', 'admin', '2026-01-05 06:35:59'),
(34, 'Area', 8, 'Add new area: Gudang', 'admin', '2026-01-05 06:36:22'),
(35, 'Item', 26, 'Add new item: Lampu', 'admin', '2026-01-05 06:36:30'),
(36, 'Item', 27, 'Add new item: AC', 'admin', '2026-01-05 06:36:38'),
(37, 'Item', 28, 'Add new item: CCTV', 'admin', '2026-01-05 06:36:46'),
(38, 'Item', 27, 'Updated item status to Tidak Aktif', 'admin', '2026-01-05 06:37:05'),
(39, 'Item', 27, 'Updated item status to Aktif', 'admin', '2026-01-05 06:37:14'),
(40, 'Item', 27, 'Updated item name from AC to AC Mushola Lantai 1', 'admin', '2026-01-05 06:37:31'),
(41, 'Area', 9, 'Add new area: Teras Belakang', 'admin', '2026-01-05 06:38:10'),
(42, 'Item', 29, 'Add new item: Lampu', 'admin', '2026-01-05 06:38:20'),
(43, 'Item', 30, 'Add new item: Gerbang Harmonika', 'admin', '2026-01-05 06:38:57'),
(44, 'Item', 31, 'Add new item: Meteran Listrik PLN', 'admin', '2026-01-05 06:39:37'),
(45, 'Item', 32, 'Add new item: Kran Air', 'admin', '2026-01-05 06:39:52'),
(46, 'Item', 33, 'Add new item: Kran Cuci Tangan', 'admin', '2026-01-05 06:40:05'),
(47, 'Item', 34, 'Add new item: Meteran PAM', 'admin', '2026-01-05 06:40:15'),
(48, 'Item', 35, 'Add new item: Kran', 'admin', '2026-01-05 06:40:37'),
(49, 'Item', 36, 'Add new item: Kulkas', 'admin', '2026-01-05 06:41:20'),
(50, 'Checking Form', 1, 'Created new checking form', 'admin', '2026-01-05 06:45:21'),
(51, 'Ticket', 1, 'Created new ticket and assign ticket to user', 'admin', '2026-01-05 06:47:55'),
(52, 'Checking Form', 1, 'Submitted the form', 'admin', '2026-01-05 06:48:55'),
(53, 'Checking Form', 2, 'Created new checking form', 'admin', '2026-01-05 06:49:32'),
(54, 'Ticket', 1, 'Ticket status changed to Dalam Pengerjaan', 'user', '2026-01-05 07:27:02'),
(55, 'Ticket', 1, 'Ticket status changed to Ditunda Sementara', 'guntur', '2026-01-05 08:12:49'),
(56, 'Ticket', 1, 'Ticket status changed to Dalam Pengerjaan', 'guntur', '2026-01-05 08:13:03'),
(57, 'Item', 37, 'Add new item: ', 'admin', '2026-01-05 11:45:00'),
(58, 'Item', 38, 'Add new item: aasa', 'admin', '2026-01-05 11:48:27'),
(59, 'Item', 39, 'Add new item: sajdad', 'admin', '2026-01-05 11:50:28'),
(60, 'Checking Form', 2, 'Submitted the form', 'admin', '2026-01-05 12:12:34'),
(61, 'Ticket', 1, 'Ticket status changed to Pengerjaan Selesai', 'admin', '2026-01-05 12:22:07'),
(62, 'Ticket', 1, 'Ticket closed', 'admin', '2026-01-05 12:22:31'),
(63, 'Checking Form', 3, 'Created new checking form', 'admin', '2026-01-06 02:32:58'),
(64, 'Checking Form', 3, 'Submitted the form', 'admin', '2026-01-06 02:33:08'),
(65, 'Checking Form', 3, 'Redraft the form', 'admin', '2026-01-06 03:10:55'),
(66, 'Item', 27, 'Item has been inspected', 'admin', '2026-01-06 03:11:02'),
(67, 'Item', 28, 'Item has been inspected', 'admin', '2026-01-06 03:11:02'),
(68, 'Item', 26, 'Item has been inspected', 'admin', '2026-01-06 03:11:02'),
(69, 'Checking Form', 3, 'Submitted the form', 'admin', '2026-01-06 03:11:02'),
(70, 'Checking Form', 3, 'Redraft the form', 'admin', '2026-01-06 03:34:06'),
(71, 'Item', 27, 'Item has been inspected', 'admin', '2026-01-06 03:34:23'),
(72, 'Item', 28, 'Item has been inspected', 'admin', '2026-01-06 03:34:23'),
(73, 'Item', 26, 'Item has been inspected', 'admin', '2026-01-06 03:34:23'),
(74, 'Checking Form', 3, 'Submitted the form', 'admin', '2026-01-06 03:34:23'),
(75, 'Ticket', 2, 'Created new ticket and assign ticket to dara', 'admin', '2026-01-06 03:45:22'),
(76, 'Area', 10, 'Add new area: Rooftop', 'user', '2026-01-06 03:45:51'),
(77, 'Item', 40, 'Add new item: Toren air', 'user', '2026-01-06 03:47:24'),
(78, 'Item', 41, 'Add new item: Jemuran', 'user', '2026-01-06 03:48:30'),
(79, 'Checking Form', 4, 'Created new checking form', 'user', '2026-01-06 03:48:52'),
(80, 'Item', 41, 'Item has been inspected', 'user', '2026-01-06 03:49:50'),
(81, 'Item', 40, 'Item has been inspected', 'user', '2026-01-06 03:49:50'),
(82, 'Checking Form', 4, 'Submitted the form', 'user', '2026-01-06 03:49:50'),
(83, 'Ticket', 3, 'Created new ticket and assign ticket to user', 'user', '2026-01-06 03:50:23'),
(84, 'Ticket', 3, 'Ticket status changed to Dalam Pengerjaan', 'user', '2026-01-06 03:51:14'),
(85, 'Ticket', 3, 'Ticket status changed to Pengerjaan Selesai', 'user', '2026-01-06 03:53:32'),
(86, 'Ticket', 3, 'Ticket closed', 'user', '2026-01-06 03:53:51'),
(87, 'Checking Form', 5, 'Created new checking form', 'user', '2026-01-06 04:12:29'),
(88, 'Item', 2, 'Item has been inspected', 'user', '2026-01-06 04:12:58'),
(89, 'Item', 30, 'Item has been inspected', 'user', '2026-01-06 04:12:58'),
(90, 'Item', 1, 'Item has been inspected', 'user', '2026-01-06 04:12:58'),
(91, 'Checking Form', 5, 'Submitted the form', 'user', '2026-01-06 04:12:58'),
(92, 'Ticket', 4, 'Created new ticket and assign ticket to user', 'user', '2026-01-06 04:13:39'),
(93, 'Ticket', 4, 'Ticket status changed to Ditunda Sementara', 'user', '2026-01-06 04:14:11'),
(94, 'Ticket', 4, 'Ticket status changed to Pengerjaan Selesai', 'user', '2026-01-06 04:15:19'),
(95, 'Checking Form', 6, 'Created new checking form', 'Admin', '2026-01-06 04:18:50'),
(96, 'Checking Form', 2, 'Redraft the form', 'admin', '2026-01-07 08:46:57'),
(97, 'Item', 30, 'Item has been inspected', 'admin', '2026-01-07 08:47:09'),
(98, 'Item', 3, 'Item has been inspected', 'admin', '2026-01-07 08:47:09'),
(99, 'Item', 2, 'Item has been inspected', 'admin', '2026-01-07 08:47:09'),
(100, 'Item', 1, 'Item has been inspected', 'admin', '2026-01-07 08:47:09'),
(101, 'Item', 4, 'Item has been inspected', 'admin', '2026-01-07 08:47:09'),
(102, 'Checking Form', 2, 'Submitted the form', 'admin', '2026-01-07 08:47:09'),
(103, 'Checking Form', 2, 'Redraft the form', 'admin', '2026-01-07 08:48:24'),
(104, 'Item', 27, 'Item has been inspected', 'admin', '2026-01-07 08:54:50'),
(105, 'Checking Form', 6, 'Submitted the form', 'admin', '2026-01-07 08:54:50'),
(106, 'Ticket', 2, 'Ticket status changed to Dalam Pengerjaan', 'admin', '2026-01-07 08:55:26'),
(107, 'Area', 11, 'Add new area: Workspace', 'admin', '2026-01-07 08:56:05'),
(108, 'Item', 42, 'Add new item: AC', 'admin', '2026-01-07 08:56:22'),
(109, 'Item', 43, 'Add new item: Pintu Kaca', 'admin', '2026-01-07 09:03:56'),
(110, 'Item', 44, 'Add new item: Pintu Kaca', 'admin', '2026-01-07 09:12:34'),
(111, 'Item', 45, 'Add new item: Loker', 'admin', '2026-01-07 09:18:32'),
(112, 'Item', 46, 'Add new item: Lampu', 'admin', '2026-01-07 09:19:03'),
(113, 'Item', 47, 'Add new item: Test', 'admin', '2026-01-07 09:24:55'),
(114, 'Item', 48, 'Add new item: sa', 'admin', '2026-01-07 09:26:52'),
(115, 'Item', 49, 'Add new item: sad', 'admin', '2026-01-07 09:27:01'),
(116, 'Item', 50, 'Add new item: jikaaa', 'admin', '2026-01-07 09:40:59'),
(117, 'Item', 51, 'Add new item: dsadads', 'admin', '2026-01-07 09:50:28'),
(118, 'Item', 52, 'Add new item: dsfkjfshd', 'admin', '2026-01-07 09:52:58'),
(119, 'Item', 53, 'Add new item: dd', 'admin', '2026-01-07 09:53:49'),
(120, 'Item', 54, 'Add new item: ddddd', 'admin', '2026-01-07 09:54:20'),
(121, 'Item', 55, 'Add new item: oasijd', 'admin', '2026-01-07 09:54:50'),
(122, 'Item', 56, 'Add new item: 53', 'admin', '2026-01-07 09:55:16'),
(123, 'Checking Form', 7, 'Created new checking form', 'admin', '2026-01-08 02:23:02'),
(124, 'Checking Form', 8, 'Created new checking form', 'admin', '2026-01-08 02:23:56'),
(125, 'Item', 10, 'Item has been inspected', 'admin', '2026-01-08 02:34:20'),
(126, 'Item', 9, 'Item has been inspected', 'admin', '2026-01-08 02:34:20'),
(127, 'Checking Form', 7, 'Submitted the form', 'admin', '2026-01-08 02:34:20'),
(128, 'Item', 20, 'Item has been inspected', 'admin', '2026-01-08 02:34:23'),
(129, 'Item', 35, 'Item has been inspected', 'admin', '2026-01-08 02:34:23'),
(130, 'Item', 18, 'Item has been inspected', 'admin', '2026-01-08 02:34:23'),
(131, 'Item', 19, 'Item has been inspected', 'admin', '2026-01-08 02:34:23'),
(132, 'Checking Form', 8, 'Submitted the form', 'admin', '2026-01-08 02:34:23'),
(133, 'Item', 30, 'Item has been inspected', 'admin', '2026-01-08 02:34:26'),
(134, 'Item', 3, 'Item has been inspected', 'admin', '2026-01-08 02:34:26'),
(135, 'Item', 2, 'Item has been inspected', 'admin', '2026-01-08 02:34:26'),
(136, 'Item', 1, 'Item has been inspected', 'admin', '2026-01-08 02:34:26'),
(137, 'Item', 4, 'Item has been inspected', 'admin', '2026-01-08 02:34:26'),
(138, 'Checking Form', 2, 'Submitted the form', 'admin', '2026-01-08 02:34:26'),
(139, 'Checking Form', 9, 'Created new checking form', 'admin', '2026-01-08 02:34:44');

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
(1, 'Parkiran', 'Area parkiran basement', '0', 'admin', '2026-01-05 06:23:29'),
(2, 'Area Luar Gedung', 'Area luar ruangan gedung', '1', 'admin', '2026-01-05 06:25:17'),
(3, 'Resepsionist & Lobby', '', '1', 'admin', '2026-01-05 06:28:06'),
(4, 'Toilet', 'Toilet lantai 1', '1', 'admin', '2026-01-05 06:29:50'),
(5, 'Pantry', 'Pantry lantai 1', '1', 'admin', '2026-01-05 06:33:11'),
(6, 'Ruang Meeting', '', '1', 'admin', '2026-01-05 06:34:40'),
(7, 'Ruang Makan', '', '1', 'admin', '2026-01-05 06:35:27'),
(8, 'Gudang', '', '1', 'admin', '2026-01-05 06:36:22'),
(9, 'Teras Belakang', '', '1', 'admin', '2026-01-05 06:38:10'),
(10, 'Rooftop', 'Area rooftop', '4', 'user', '2026-01-06 03:45:51'),
(11, 'Workspace', 'Ruang kerja lantai 3', '3', 'admin', '2026-01-07 08:56:05');

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
(1, '1', '8', '0', 'admin', '2026-01-05 06:45:41'),
(2, '1', '33', '0', 'admin', '2026-01-05 06:45:41'),
(3, '1', '7', '0', 'admin', '2026-01-05 06:45:41'),
(4, '1', '34', '0', 'admin', '2026-01-05 06:45:41'),
(5, '1', '32', '0', 'admin', '2026-01-05 06:48:38'),
(6, '1', '6', '0', 'admin', '2026-01-05 06:48:38'),
(7, '1', '5', '0', 'admin', '2026-01-05 06:48:38'),
(8, '1', '31', '0', 'admin', '2026-01-05 06:48:38'),
(9, '2', '30', '0', 'admin', '2026-01-05 06:49:43'),
(10, '2', '3', '0', 'admin', '2026-01-05 06:49:43'),
(11, '2', '2', '0', 'admin', '2026-01-05 12:12:30'),
(12, '3', '27', '0', 'admin', '2026-01-06 02:33:06'),
(13, '3', '28', '0', 'admin', '2026-01-06 02:33:06'),
(14, '3', '26', '0', 'admin', '2026-01-06 02:33:06'),
(15, '4', '41', '0', 'user', '2026-01-06 03:49:41'),
(16, '4', '40', '0', 'user', '2026-01-06 03:49:48'),
(17, '5', '2', '0', 'user', '2026-01-06 04:12:53'),
(18, '5', '30', '0', 'user', '2026-01-06 04:12:53'),
(19, '5', '1', '0', 'user', '2026-01-06 04:12:53'),
(20, '2', '1', '0', 'admin', '2026-01-07 08:47:07'),
(21, '2', '4', '0', 'admin', '2026-01-07 08:47:07'),
(22, '6', '27', '0', 'admin', '2026-01-07 08:54:36'),
(25, '8', '20', '0', 'admin', '2026-01-08 02:26:11'),
(26, '8', '35', '0', 'admin', '2026-01-08 02:26:11'),
(27, '8', '18', '0', 'admin', '2026-01-08 02:26:11'),
(28, '8', '19', '0', 'admin', '2026-01-08 02:26:11'),
(29, '7', '10', '0', 'admin', '2026-01-08 02:34:14'),
(30, '7', '9', '0', 'admin', '2026-01-08 02:34:14');

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
(1, '2026-01-05', '2', 'Pengecekan rutin harian', '1', 'admin', '2026-01-05 06:48:55'),
(2, '2026-01-05', '1', 'pengecekan mingguan: minggu pertama bulan Januari', '1', 'admin', '2026-01-08 02:34:26'),
(3, '2026-01-06', '8', 'test', '1', 'admin', '2026-01-06 03:34:23'),
(4, '2026-01-06', '10', 'Rutinitas rooftop', '1', 'user', '2026-01-06 03:49:50'),
(5, '2026-01-06', '1', 'jhgc', '1', 'user', '2026-01-06 04:12:58'),
(6, '2026-01-06', '8', '', '1', 'Admin', '2026-01-07 08:54:50'),
(7, '2026-01-08', '3', 'ddd', '1', 'admin', '2026-01-08 02:34:19'),
(8, '2026-01-08', '5', 'vvs', '1', 'admin', '2026-01-08 02:34:23'),
(9, '2026-01-08', '1', 'jjj', '0', 'admin', '2026-01-08 02:34:44');

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
(1, '1', 'Lampu', 'kelistrikan', '1', NULL, 'admin', '2026-01-05 06:23:47'),
(2, '1', 'CCTV', 'keamanan', '1', NULL, 'admin', '2026-01-05 06:23:59'),
(3, '1', 'Mesin Air', 'perpipaan', '3', NULL, 'admin', '2026-01-06 04:13:39'),
(4, '1', 'Toren PAM', 'perpipaan', '1', NULL, 'admin', '2026-01-05 06:24:32'),
(5, '2', 'Lampu Lobby Luar', 'kelistrikan', '1', NULL, 'admin', '2026-01-05 06:26:18'),
(6, '2', 'Lampu Depan Gudang', 'kelistrikan', '1', NULL, 'admin', '2026-01-05 06:26:33'),
(7, '2', 'Lampu Dinding Luar', 'kelistrikan', '1', NULL, 'admin', '2026-01-05 06:26:58'),
(8, '2', 'CCTV Lobby Luar', 'keamanan', '1', NULL, 'admin', '2026-01-05 06:27:20'),
(9, '3', 'Lampu', 'kelistrikan', '1', NULL, 'admin', '2026-01-05 06:28:28'),
(10, '3', 'AC', 'kelistrikan', '1', NULL, 'admin', '2026-01-05 12:22:31'),
(11, '3', 'CCTV', 'keamanan', '1', NULL, 'admin', '2026-01-05 06:28:52'),
(12, '4', 'Lampu Toilet Urinoir', 'kelistrikan', '1', NULL, 'admin', '2026-01-05 06:30:40'),
(13, '4', 'Lampu Toilet Pria', 'kelistrikan', '1', NULL, 'admin', '2026-01-05 06:30:55'),
(14, '4', 'Lampu Toilet Perempuan', 'kelistrikan', '1', NULL, 'admin', '2026-01-05 06:31:09'),
(15, '4', 'Lampu Kamar Mandi', 'kelistrikan', '1', NULL, 'admin', '2026-01-05 06:31:25'),
(16, '4', 'Lampu Wastafel', 'kelistrikan', '1', NULL, 'admin', '2026-01-05 06:31:45'),
(17, '4', 'Hand Dryer', 'layanan_umum', '1', NULL, 'admin', '2026-01-05 06:32:33'),
(18, '5', 'Lampu', 'kelistrikan', '1', NULL, 'admin', '2026-01-05 06:33:23'),
(19, '5', 'Microwave', 'elektronik_pantri', '1', NULL, 'admin', '2026-01-05 06:33:34'),
(20, '5', 'Dispenser Galon', 'elektronik_pantri', '1', NULL, 'admin', '2026-01-05 06:33:49'),
(21, '6', 'Lampu', 'kelistrikan', '1', NULL, 'admin', '2026-01-05 06:34:51'),
(22, '6', 'AC', 'kelistrikan', '3', NULL, 'admin', '2026-01-06 03:45:22'),
(23, '7', 'Lampu', 'kelistrikan', '1', NULL, 'admin', '2026-01-05 06:35:37'),
(24, '7', 'AC', 'kelistrikan', '1', NULL, 'admin', '2026-01-05 06:35:47'),
(25, '7', 'CCTV', 'keamanan', '1', NULL, 'admin', '2026-01-05 06:35:59'),
(26, '8', 'Lampu', 'kelistrikan', '1', NULL, 'admin', '2026-01-05 06:36:30'),
(27, '8', 'AC Mushola Lantai 1', 'kelistrikan', '1', NULL, 'admin', '2026-01-05 06:37:31'),
(28, '8', 'CCTV', 'keamanan', '1', NULL, 'admin', '2026-01-05 06:36:46'),
(29, '9', 'Lampu', 'kelistrikan', '1', NULL, 'admin', '2026-01-05 06:38:20'),
(30, '1', 'Gerbang Harmonika', 'bangunan', '1', NULL, 'admin', '2026-01-05 06:38:57'),
(31, '2', 'Meteran Listrik PLN', 'kelistrikan', '1', NULL, 'admin', '2026-01-05 06:39:37'),
(32, '2', 'Kran Air', 'perpipaan', '1', NULL, 'admin', '2026-01-05 06:39:52'),
(33, '2', 'Kran Cuci Tangan', 'perpipaan', '1', NULL, 'admin', '2026-01-05 06:40:05'),
(34, '2', 'Meteran PAM', 'perpipaan', '1', NULL, 'admin', '2026-01-05 06:40:15'),
(35, '5', 'Kran', 'perpipaan', '1', NULL, 'admin', '2026-01-05 06:40:37'),
(36, '7', 'Kulkas', 'elektronik_pantri', '1', NULL, 'admin', '2026-01-05 06:41:20'),
(40, '10', 'Toren air', 'perpipaan', '1', NULL, 'user', '2026-01-06 03:47:24'),
(41, '10', 'Jemuran', 'layanan_umum', '1', NULL, 'user', '2026-01-06 03:53:51'),
(42, '11', 'AC', 'kelistrikan', '1', NULL, 'admin', '2026-01-07 08:56:22'),
(43, '', 'Pintu Kaca', 'bangunan', '1', NULL, 'admin', '2026-01-07 09:03:56'),
(44, '11', 'Pintu Kaca', 'bangunan', '1', NULL, 'admin', '2026-01-07 09:12:34'),
(45, '11', 'Loker', 'mebel', '1', NULL, 'admin', '2026-01-07 09:18:32'),
(46, '11', 'Lampu', 'kelistrikan', '1', NULL, 'admin', '2026-01-07 09:19:03'),
(47, '11', 'Test', 'keamanan', '1', NULL, 'admin', '2026-01-07 09:24:55'),
(48, '11', 'sa', 'infra_it', '1', NULL, 'admin', '2026-01-07 09:26:52'),
(49, '11', 'sad', 'keamanan', '1', NULL, 'admin', '2026-01-07 09:27:01'),
(50, '11', 'jikaaa', 'infra_it', '1', NULL, 'admin', '2026-01-07 09:40:59'),
(51, '11', 'dsadads', 'kelistrikan', '1', NULL, 'admin', '2026-01-07 09:50:28'),
(52, '11', 'dsfkjfshd', 'infra_it', '1', NULL, 'admin', '2026-01-07 09:52:58'),
(53, '11', 'dd', 'infra_it', '1', NULL, 'admin', '2026-01-07 09:53:49'),
(54, '11', 'ddddd', 'kelistrikan', '1', NULL, 'admin', '2026-01-07 09:54:20'),
(55, '11', 'oasijd', 'kelistrikan', '1', NULL, 'admin', '2026-01-07 09:54:50'),
(56, '11', '53', 'infra_it', '1', NULL, 'admin', '2026-01-07 09:55:16');

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
(1, 1, 'User mengubah status tiket menjadi <b>Dalam Pengerjaan</b> dengan remarks: oke', 'user', '2026-01-05 07:27:02'),
(2, 1, '<p>test comment</p>', 'guntur', '2026-01-05 08:09:38'),
(3, 1, 'Guntur mengubah status tiket menjadi <b>Ditunda Sementara</b> dengan remarks: lack of fund', 'guntur', '2026-01-05 08:12:49'),
(4, 1, 'Guntur mengubah status tiket menjadi <b>Dalam Pengerjaan</b> dengan remarks: gas lanjut lagi, cairrrrr', 'guntur', '2026-01-05 08:13:03'),
(5, 1, 'Admin mengubah status tiket menjadi <b>Pengerjaan Selesai</b> dengan remarks: udah ya', 'admin', '2026-01-05 12:22:07'),
(6, 1, 'Tiket <b>Closed</b> dengan remaks: sudah dicek, dan ac sudah hidup lagi', 'admin', '2026-01-05 12:22:31'),
(7, 3, '<img src=\"/app/assets/uploads/images/17676714301681802583188269411529.jpg\" class=\"card-img-top img-fluid\" style=\"max-width: 50%; height: auto\">', 'user', '2026-01-06 03:50:41'),
(8, 3, 'User mengubah status tiket menjadi <b>Dalam Pengerjaan</b> dengan remarks: Sedang di lem', 'user', '2026-01-06 03:51:14'),
(9, 3, '<p>Test</p>', 'user', '2026-01-06 03:51:30'),
(10, 3, 'User mengubah status tiket menjadi <b>Pengerjaan Selesai</b> dengan remarks: Sudah diperbaiki', 'user', '2026-01-06 03:53:32'),
(11, 3, 'Tiket <b>Closed</b> dengan remaks: Finish', 'user', '2026-01-06 03:53:51'),
(12, 4, '<p>fddfdf</p>', 'user', '2026-01-06 04:13:57'),
(13, 4, 'User mengubah status tiket menjadi <b>Ditunda Sementara</b> dengan remarks: sdsds', 'user', '2026-01-06 04:14:11'),
(14, 4, 'User mengubah status tiket menjadi <b>Pengerjaan Selesai</b> dengan remarks: hds', 'user', '2026-01-06 04:15:19'),
(15, 2, '<p>test</p>', 'admin', '2026-01-07 08:55:13'),
(16, 2, 'Admin mengubah status tiket menjadi <b>Dalam Pengerjaan</b> dengan remarks: oke', 'admin', '2026-01-07 08:55:26'),
(17, 4, '<p>aaaa</p>', 'admin', '2026-01-08 02:20:49'),
(18, 4, '<p>kkkj</p>', 'admin', '2026-01-08 02:33:57'),
(19, 4, '<p>dfsfs</p>', 'admin', '2026-01-08 02:35:42'),
(20, 4, '<p>ddd</p>', 'admin', '2026-01-08 02:40:17'),
(21, 4, '<p>dasdwsdd</p>', 'admin', '2026-01-08 02:40:35'),
(22, 4, '<p>adaasdws</p>', 'admin', '2026-01-08 02:43:44'),
(23, 4, '<p>das</p>', 'admin', '2026-01-08 02:43:58'),
(24, 4, '<p>dasda</p>', 'admin', '2026-01-08 02:51:44');

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
(1, 'AC tidak mau hidup', 'AC di reseptionis depan pintu masuk lobby', 10, '2026-01-05', '4', 'user', 'admin', '2026-01-05 12:22:31'),
(2, 'apa yah', 'coba dulu', 22, '2026-01-06', '1', 'dara', 'admin', '2026-01-07 08:55:26'),
(3, 'Patah', 'Patah perlu di lem', 41, '2026-01-06', '4', 'user', 'user', '2026-01-06 03:53:51'),
(4, 'aabb', 'gf', 3, '2026-01-06', '3', 'user', 'user', '2026-01-06 04:15:19');

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
(1, 'admin', '$2y$10$tq5Ry7BywiBbo7ycialzHe9TMyYYz4rToOMrz7CRQHWdrXrEHi5WW', 'admin', NULL, NULL),
(2, 'user', '$2y$10$K7QuO3wFj3F5LtiA.wvN4eednMvcUDCZlGtb8mTDxuWMwbKieno4K', 'user', 'admin', '2025-12-20 06:33:54'),

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
  MODIFY `activity_log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=140;

--
-- AUTO_INCREMENT for table `area_master`
--
ALTER TABLE `area_master`
  MODIFY `area_master_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `checkingform_detail`
--
ALTER TABLE `checkingform_detail`
  MODIFY `checkingform_detail_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `checkingform_master`
--
ALTER TABLE `checkingform_master`
  MODIFY `checkingform_master_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `code_master`
--
ALTER TABLE `code_master`
  MODIFY `code_master_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `item_master`
--
ALTER TABLE `item_master`
  MODIFY `item_master_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `ticket_detail`
--
ALTER TABLE `ticket_detail`
  MODIFY `ticket_detail_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `ticket_master`
--
ALTER TABLE `ticket_master`
  MODIFY `ticket_master_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `user_master`
--
ALTER TABLE `user_master`
  MODIFY `user_master_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
