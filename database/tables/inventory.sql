-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 10, 2025 at 12:36 AM
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
-- Database: `gamestoredb`
--

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `InventoryID` int(11) NOT NULL,
  `GameID` int(11) NOT NULL,
  `Quantity` int(11) NOT NULL,
  `LastUpdated` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`InventoryID`, `GameID`, `Quantity`, `LastUpdated`) VALUES
(4, 4, 30, '2025-05-09 22:24:46'),
(5, 5, -2, '2025-05-09 22:05:31'),
(6, 6, 41, '2025-05-09 22:24:00'),
(7, 7, 96, '2025-05-07 23:28:12'),
(8, 8, 36, '2025-05-07 23:28:12'),
(9, 9, 94, '2025-05-08 00:51:54'),
(10, 10, 20, '2025-05-04 19:09:00'),
(11, 11, 72, '2025-05-09 20:37:29'),
(12, 12, 78, '2025-05-07 23:28:12'),
(13, 13, 60, '2025-05-04 19:09:00'),
(14, 14, 50, '2025-05-04 19:09:00'),
(15, 15, 70, '2025-05-04 19:09:00'),
(16, 16, 30, '2025-05-04 19:09:00'),
(17, 17, 40, '2025-05-04 19:09:00'),
(18, 18, 70, '2025-05-04 19:09:00'),
(19, 19, 45, '2025-05-04 19:09:00'),
(20, 20, 35, '2025-05-04 19:09:00'),
(21, 21, 25, '2025-05-04 19:09:00'),
(22, 22, 50, '2025-05-04 19:09:00'),
(23, 23, 28, '2025-05-09 22:05:31'),
(24, 24, 60, '2025-05-04 19:09:00'),
(25, 25, 30, '2025-05-04 19:09:00'),
(26, 26, 48, '2025-05-07 23:28:49'),
(27, 27, 20, '2025-05-04 19:09:00'),
(29, 29, 80, '2025-05-04 19:09:00'),
(30, 30, 45, '2025-05-04 19:09:00'),
(31, 31, 65, '2025-05-04 19:09:00'),
(32, 32, 55, '2025-05-04 19:09:00'),
(33, 33, 30, '2025-05-04 19:09:00'),
(34, 34, 996, '2025-05-07 23:28:49'),
(35, 35, 40, '2025-05-04 19:09:00'),
(36, 36, 35, '2025-05-04 19:09:00'),
(37, 37, 50, '2025-05-04 19:09:00'),
(38, 38, 45, '2025-05-04 19:09:00'),
(39, 39, 30, '2025-05-04 19:09:00'),
(40, 40, 25, '2025-05-04 19:09:00'),
(41, 41, 60, '2025-05-04 19:09:00'),
(42, 42, 40, '2025-05-04 19:09:00'),
(43, 43, 35, '2025-05-04 19:09:00'),
(44, 44, 50, '2025-05-04 19:09:00'),
(45, 45, 30, '2025-05-04 19:09:00'),
(46, 46, 20, '2025-05-04 19:09:00'),
(47, 47, 45, '2025-05-04 19:09:00'),
(48, 48, 30, '2025-05-04 19:09:00'),
(49, 49, 100, '2025-05-04 19:09:00'),
(50, 50, 40, '2025-05-04 19:09:00'),
(51, 51, 25, '2025-05-04 19:09:00'),
(52, 52, 30, '2025-05-04 19:09:00'),
(53, 53, 50, '2025-05-04 19:09:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`InventoryID`),
  ADD KEY `GameID` (`GameID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `InventoryID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `inventory`
--
ALTER TABLE `inventory`
  ADD CONSTRAINT `inventory_ibfk_1` FOREIGN KEY (`GameID`) REFERENCES `games` (`GameID`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
