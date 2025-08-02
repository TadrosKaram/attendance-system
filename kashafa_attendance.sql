-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 02, 2025 at 06:57 PM
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
-- Database: `kashafa_attendance`
--

-- --------------------------------------------------------

--
-- Table structure for table `afrad`
--

CREATE TABLE `afrad` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `address` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `afrad`
--

INSERT INTO `afrad` (`id`, `name`, `phone`, `address`) VALUES
(0, 'Testing', '0000', 'mars'),
(1, 'John Doe', '01012345678', '123 Nile St, Cairo'),
(2, 'Sarah Ali', '01198765432', '45 Tahrir Square, Giza'),
(3, 'Michael Fady', '01234567890', '22 Smart Village, 6th October'),
(4, 'Amira Youssef', '01511223344', '78 Nasr City, Cairo'),
(5, 'Khaled Zaki', '01099887766', '13 El Maadi, Cairo'),
(1200, 'jlkajsdlk', '012', 'sudan');

-- --------------------------------------------------------

--
-- Table structure for table `attendance_days`
--

CREATE TABLE `attendance_days` (
  `id` int(11) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `attendance_days`
--

INSERT INTO `attendance_days` (`id`, `date`) VALUES
(4, '2025-08-02'),
(3, '2025-08-05'),
(5, '2025-08-06'),
(6, '2025-08-15'),
(9, '2025-08-18'),
(7, '2025-08-26'),
(8, '2025-08-30');

-- --------------------------------------------------------

--
-- Table structure for table `attendance_records`
--

CREATE TABLE `attendance_records` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `day_id` int(11) NOT NULL,
  `attended` enum('1','0') DEFAULT '0',
  `excuse` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `attendance_records`
--

INSERT INTO `attendance_records` (`id`, `user_id`, `day_id`, `attended`, `excuse`) VALUES
(11, 1, 3, '0', NULL),
(12, 2, 3, '0', NULL),
(13, 3, 3, '0', NULL),
(14, 4, 3, '0', NULL),
(15, 5, 3, '0', NULL),
(16, 1, 4, '0', NULL),
(17, 2, 4, '0', NULL),
(18, 3, 4, '0', NULL),
(19, 4, 4, '0', NULL),
(20, 5, 4, '0', NULL),
(21, 0, 5, '0', NULL),
(22, 1, 5, '0', NULL),
(23, 2, 5, '0', NULL),
(24, 3, 5, '0', NULL),
(25, 4, 5, '0', NULL),
(26, 5, 5, '0', NULL),
(27, 0, 6, '0', NULL),
(28, 1, 6, '0', NULL),
(29, 2, 6, '0', NULL),
(30, 3, 6, '0', NULL),
(31, 4, 6, '0', NULL),
(32, 5, 6, '0', NULL),
(33, 0, 7, '0', NULL),
(34, 1, 7, '0', NULL),
(35, 2, 7, '0', NULL),
(36, 3, 7, '0', NULL),
(37, 4, 7, '0', NULL),
(38, 5, 7, '0', NULL),
(39, 1200, 7, '0', NULL),
(40, 0, 8, '0', NULL),
(41, 1, 8, '0', NULL),
(42, 2, 8, '0', NULL),
(43, 3, 8, '0', NULL),
(44, 4, 8, '0', NULL),
(45, 5, 8, '0', NULL),
(46, 1200, 8, '0', NULL),
(47, 0, 9, '1', NULL),
(48, 1, 9, '1', NULL),
(49, 2, 9, '1', NULL),
(50, 3, 9, '0', NULL),
(51, 4, 9, '0', NULL),
(52, 5, 9, '0', NULL),
(53, 1200, 9, '0', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `kada`
--

CREATE TABLE `kada` (
  `username` varchar(20) DEFAULT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kada`
--

INSERT INTO `kada` (`username`, `password`) VALUES
('Tadros Maged', '123123');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `afrad`
--
ALTER TABLE `afrad`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `attendance_days`
--
ALTER TABLE `attendance_days`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `date` (`date`);

--
-- Indexes for table `attendance_records`
--
ALTER TABLE `attendance_records`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`,`day_id`),
  ADD KEY `day_id` (`day_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attendance_days`
--
ALTER TABLE `attendance_days`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `attendance_records`
--
ALTER TABLE `attendance_records`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attendance_records`
--
ALTER TABLE `attendance_records`
  ADD CONSTRAINT `attendance_records_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `afrad` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `attendance_records_ibfk_2` FOREIGN KEY (`day_id`) REFERENCES `attendance_days` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
