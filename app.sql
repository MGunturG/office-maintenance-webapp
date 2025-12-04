-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 02, 2025 at 08:36 AM
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
(5, 'gudang', 'gudang guding', '1', 'admin', '2025-11-19 02:57:21'),
(6, 'toilet', '', '2', 'admin', '2025-11-20 06:14:13'),
(7, 'ruang online', '', '1', 'admin', '2025-11-20 06:14:25'),
(8, 'parkiran basement', '', '0', 'admin', '2025-11-20 06:14:36'),
(9, 'smoking room', 'please adain', '3', 'admin', '2025-11-24 06:29:06'),
(10, 'mushola', 'tempat tidur', '3', 'admin', '2025-11-24 06:34:02'),
(11, 'dassadas', '7tyjtj', '4', 'admin', '2025-11-24 06:37:43'),
(12, 'kamar tidur', 'buat istirahat atuh', '3', 'admin', '2025-11-25 04:47:12'),
(13, 'sadjhd', 'daskjhqdw', '21', 'admin', '2025-11-28 09:25:31');

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
(49, '10', '2', '0', 'admin', '2025-11-23 06:12:00'),
(95, '14', '4', '0', 'andara', '2025-11-28 10:17:04'),
(96, '14', '6', '0', 'andara', '2025-11-28 10:17:04'),
(97, '14', '8', '0', 'andara', '2025-11-28 10:17:04'),
(98, '14', '15', '0', 'andara', '2025-11-28 10:17:04'),
(99, '14', '20', '0', 'andara', '2025-11-28 10:17:04'),
(100, '9', '4', '0', 'admin', '2025-11-28 10:30:02'),
(101, '9', '14', '0', 'admin', '2025-11-28 10:30:02');

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
(9, '2025-11-22', '8', 'pengecekan harian', '0', 'admin', '2025-11-28 10:31:06'),
(10, '2025-11-23', '6', '', '1', 'admin', '2025-11-28 09:57:05'),
(11, '2025-11-28', '', '', '0', 'admin', '2025-11-28 04:34:03'),
(12, '2025-11-28', '5', 'asddada', '0', 'admin', '2025-11-28 04:34:56'),
(13, '2025-11-28', '13', 'asdadadsda', '0', 'admin', '2025-11-28 09:26:10'),
(14, '2025-11-28', '8', 'Pengecekan mingguan', '0', 'andara', '2025-11-28 10:20:56');

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
(1, '5', 'kipas angin', 'listrik', '1', 'coba', '2025-11-20 07:10:18'),
(2, '6', 'hand dryer', 'listrik', '1', 'admin', '2025-11-20 07:12:55'),
(3, '7', 'blower', 'listrik', '1', 'admin', '2025-11-20 07:31:01'),
(4, '8', 'panel listrik', 'listrik', '1', 'admin', '2025-11-20 08:24:40'),
(5, '8', 'pompa air', 'plumbing', '1', 'admin', '2025-11-21 09:48:15'),
(6, '8', 'rrwerr32', 'plumbing', '1', 'admin', '2025-11-22 04:24:05'),
(7, '8', 'fddfwfg4', 'plumbing', '1', 'admin', '2025-11-22 04:24:15'),
(8, '8', 'dfsfsfnnrete', 'plumbing', '1', 'admin', '2025-11-22 04:24:24'),
(9, '12', 'kipas angin', 'listrik', '1', 'admin', '2025-11-25 04:48:14'),
(10, '12', 'ac', 'listrik', '1', 'admin', '2025-11-25 04:48:30'),
(11, '6', 'qwjdsadoiwq', 'listrik', '1', 'admin', '2025-11-25 08:05:28'),
(12, '11', 'dsiauiqwq', 'plumbing', '1', 'admin', '2025-11-25 08:07:59'),
(13, '12', 'hp', 'listrik', '1', 'admin', '2025-11-25 08:19:47'),
(14, '8', 'hwiuhshaj', '', '1', 'admin', '2025-11-25 08:46:21'),
(15, '8', 'iooii', 'plumbing', '1', 'admin', '2025-11-27 09:21:18'),
(16, '11', 'uuuu', 'listrik', '1', 'admin', '2025-11-27 09:23:28'),
(17, '13', 'sadas', 'plumbing', '1', 'admin', '2025-11-28 09:25:45'),
(18, '8', 'asdaa', 'listrik', '1', 'admin', '2025-11-28 09:43:16'),
(19, '5', 'tyuio', 'listrik', '1', 'admin', '2025-11-28 09:43:41'),
(20, '8', 'zfdijccc', 'plumbing', '1', 'andara', '2025-11-28 10:05:31'),
(21, '8', 'dasdada', 'listrik', '1', 'admin', '2025-11-28 10:28:47'),
(22, '8', 'lkqwlkwq', 'listrik', '1', 'admin', '2025-11-28 10:28:58'),
(23, '8', 'sdadewqe', 'listrik', '1', 'admin', '2025-11-28 10:29:09');

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
(24, 'andara', '$2y$10$uYU4a1qA8PKi7ZRtE//X2eWfTxmjb29cokY6TO6pYLBR6M93uww8O', 'admin', 'admin', '2025-11-24 10:30:47'),
(25, 'salma', '$2y$10$0SS.1jVWCiVSzFgzIlkoQuICzlVY4l4EQYXw4Ke/8EpIa97sUDxt.', 'user', 'admin', '2025-11-24 10:30:58'),
(26, 'rifandha', '$2y$10$Ea8/Uh7TYJRhLbbg4s6jAeramy7SavXrhUMRjlGwHiWEy1YH35LuS', 'user', 'admin', '2025-11-24 10:31:13'),
(27, 'guntur', '$2y$10$WoWYKuLWmrWTE89GHgtnsukMOygFVLyBKqpxVzF0v/y6/acdUOakS', 'admin', 'admin', '2025-11-24 10:31:31');

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
-- Indexes for table `item_master`
--
ALTER TABLE `item_master`
  ADD PRIMARY KEY (`item_master_id`);

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
  MODIFY `area_master_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `checkingform_detail`
--
ALTER TABLE `checkingform_detail`
  MODIFY `checkingform_detail_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102;

--
-- AUTO_INCREMENT for table `checkingform_master`
--
ALTER TABLE `checkingform_master`
  MODIFY `checkingform_master_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `item_master`
--
ALTER TABLE `item_master`
  MODIFY `item_master_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `user_master`
--
ALTER TABLE `user_master`
  MODIFY `user_master_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
