-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 10, 2025 at 12:37 AM
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
-- Table structure for table `publishers`
--

CREATE TABLE `publishers` (
  `PublisherID` int(11) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `Website` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `publishers`
--

INSERT INTO `publishers` (`PublisherID`, `Name`, `Website`) VALUES
(1, 'Electronic Arts', 'https://www.ea.com'),
(2, 'Ubisoft', 'https://www.ubisoft.com'),
(3, 'Nintendo', 'https://www.nintendo.com'),
(4, 'Bethesda', 'https://www.bethesda.net'),
(5, 'Square Enix', 'https://www.square-enix.com'),
(6, 'Activision', 'https://www.activision.com'),
(7, 'Rockstar Games', 'https://www.rockstargames.com'),
(8, 'Capcom', 'https://www.capcom.com'),
(9, 'Sega', 'https://www.sega.com'),
(10, 'Konami', 'https://www.konami.com'),
(11, 'Bandai Namco', 'https://www.bandainamcoent.com'),
(12, 'Take-Two Interactive', 'https://www.take2games.com'),
(13, '2K Games', 'https://www.2k.com'),
(14, 'Warner Bros. Games', 'https://www.warnerbrosgames.com'),
(15, 'THQ Nordic', 'https://www.thqnordic.com'),
(16, 'Koch Media', 'https://www.kochmedia.com'),
(17, 'Paradox Interactive', 'https://www.paradoxplaza.com'),
(18, 'Deep Silver', 'https://www.deepsilver.com'),
(19, 'Codemasters', 'https://www.codemasters.com'),
(20, 'Atari', 'https://www.atari.com');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `publishers`
--
ALTER TABLE `publishers`
  ADD PRIMARY KEY (`PublisherID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `publishers`
--
ALTER TABLE `publishers`
  MODIFY `PublisherID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
