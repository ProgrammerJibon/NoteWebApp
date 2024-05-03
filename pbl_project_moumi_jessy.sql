-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 03, 2024 at 09:41 PM
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
-- Database: `pbl_project_moumi_jessy`
--
CREATE DATABASE IF NOT EXISTS `pbl_project_moumi_jessy` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `pbl_project_moumi_jessy`;

-- --------------------------------------------------------

--
-- Table structure for table `admission_sessions`
--

CREATE TABLE IF NOT EXISTS `admission_sessions` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `session_name` varchar(16) NOT NULL,
  `session_year` varchar(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admission_sessions`
--

INSERT IGNORE INTO `admission_sessions` (`id`, `session_name`, `session_year`) VALUES
(1, 'SUMMER', '2024');

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE IF NOT EXISTS `department` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `dept_full_name` varchar(1024) NOT NULL,
  `dept_short_name` varchar(64) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `department`
--

INSERT IGNORE INTO `department` (`id`, `dept_full_name`, `dept_short_name`) VALUES
(1, 'Computer Science and Engineering', 'cse');

-- --------------------------------------------------------

--
-- Table structure for table `notes_post`
--

CREATE TABLE IF NOT EXISTS `notes_post` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `student_user_id` varchar(255) NOT NULL,
  `caption` longtext NOT NULL,
  `post_time` varchar(16) NOT NULL DEFAULT '0',
  `status` varchar(32) NOT NULL DEFAULT 'ACTIVE',
  `dept_id` varchar(255) NOT NULL,
  `semester` varchar(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notes_post`
--

INSERT IGNORE INTO `notes_post` (`id`, `student_user_id`, `caption`, `post_time`, `status`, `dept_id`, `semester`) VALUES
(1, '12311041', ' asfasdfasdf         ', '1714577393', 'ACTIVE', '1', '4'),
(3, '12311041', 'Look  ', '1714730531', 'ACTIVE', '1', '4'),
(6, '12311041', ' jhlkjhljlkj   ', '1714736049', 'ACTIVE', '1', '4'),
(9, '12221000', ' hiii ', '1714764729', 'ACTIVE', '1', '4');

-- --------------------------------------------------------

--
-- Table structure for table `post_comments`
--

CREATE TABLE IF NOT EXISTS `post_comments` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `notes_post_id` varchar(255) NOT NULL,
  `student_user_id` varchar(255) NOT NULL,
  `comment_text` longtext NOT NULL,
  `comment_file_path` longtext NOT NULL,
  `comment_time` varchar(16) NOT NULL DEFAULT '0',
  `reply_comment_id` varchar(255) NOT NULL,
  `status` varchar(32) NOT NULL DEFAULT 'ACTIVE',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `post_files`
--

CREATE TABLE IF NOT EXISTS `post_files` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `note_post_id` varchar(255) NOT NULL,
  `file_path` longtext NOT NULL,
  `file_name` longtext NOT NULL,
  `file_type` varchar(32) NOT NULL,
  `status` varchar(16) NOT NULL DEFAULT 'ACTIVE',
  `alt_text` longtext NOT NULL,
  `student_user_id` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `post_files`
--

INSERT IGNORE INTO `post_files` (`id`, `note_post_id`, `file_path`, `file_name`, `file_type`, `status`, `alt_text`, `student_user_id`) VALUES
(1, '1', 'uploads/2024/May/image-1714712422-785383158.jpeg', '328868278_716104050101917_3653638496551661556_n.jpg', 'image/jpeg', 'ACTIVE', 'This is moumi', '12311041'),
(2, '1', 'uploads/2024/May/application-1714717468-1760012856.pdf', 'UGV PC - AAD - Google Sheets.pdf', 'application/pdf', 'ACTIVE', 'example sheet', '12311041'),
(3, '3', 'uploads/2024/May/image-1714730570-676191348.jpeg', '624563580.0.jpeg', 'image/jpeg', 'ACTIVE', '', '12311041'),
(4, '5', 'uploads/2024/May/image-1714733240-785247543.jpeg', 'IMG_20240414_164950.jpg', 'image/jpeg', 'ACTIVE', 'showing bra', '12311041'),
(5, '6', 'uploads/2024/May/image-1714736114-42843777.png', 'qrcode_g.dev.png', 'image/png', 'ACTIVE', 'cp', '12311041'),
(6, '6', 'uploads/2024/May/application-1714736144-915560295.pdf', 'UGV PC - AAD - Google Sheets.pdf', 'application/pdf', 'ACTIVE', 'sample', '12311041'),
(7, '9', 'uploads/2024/May/image-1714764737-912970303.jpeg', '429824730_958999169109979_8765968834020378340_n.jpg', 'image/jpeg', 'ACTIVE', '', '12311041');

-- --------------------------------------------------------

--
-- Table structure for table `post_likes`
--

CREATE TABLE IF NOT EXISTS `post_likes` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `student_user_id` varchar(255) NOT NULL,
  `note_post_id` varchar(255) NOT NULL,
  `liked_time` varchar(16) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `saved_post`
--

CREATE TABLE IF NOT EXISTS `saved_post` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `student_user_id` varchar(255) NOT NULL,
  `note_post_id` varchar(255) NOT NULL,
  `saved_time` varchar(16) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE IF NOT EXISTS `students` (
  `id` int(255) NOT NULL AUTO_INCREMENT COMMENT 'student_id',
  `student_name` varchar(1024) NOT NULL,
  `dept_id` varchar(255) NOT NULL,
  `session_id` varchar(255) NOT NULL,
  `current_semester` varchar(32) NOT NULL,
  `account_creation_time` varchar(32) NOT NULL DEFAULT '0',
  `phone_number` varchar(16) NOT NULL,
  `password` varchar(2048) NOT NULL,
  `status` varchar(16) NOT NULL DEFAULT 'ACTIVE' COMMENT 'ACTIVE \r\nBANNED',
  `user_type` varchar(32) NOT NULL DEFAULT 'STUDENT' COMMENT 'ADMIN\r\nSTUDENT',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12311042 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT IGNORE INTO `students` (`id`, `student_name`, `dept_id`, `session_id`, `current_semester`, `account_creation_time`, `phone_number`, `password`, `status`, `user_type`) VALUES
(12221000, 'Moumi Dutto', '1', '1', '4', '0', '016002255', '700c8b805a3e2a265b01c77614cd8b21', 'ACTIVE', 'STUDENT'),
(12311041, 'Kazi Aysha Jessi', '1', '1', '4', '0', '1600301810', '700c8b805a3e2a265b01c77614cd8b21', 'ACTIVE', 'ADMIN');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
