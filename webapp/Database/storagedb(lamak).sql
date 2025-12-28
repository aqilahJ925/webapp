-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 23, 2025 at 09:01 PM
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
-- Database: `storagedb`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_cred`
--

CREATE TABLE `admin_cred` (
  `sr_no` int(5) NOT NULL,
  `admin_name` varchar(30) NOT NULL,
  `admin_pass` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_cred`
--

INSERT INTO `admin_cred` (`sr_no`, `admin_name`, `admin_pass`) VALUES
(1, 'kiki', '12345');

-- --------------------------------------------------------

--
-- Table structure for table `package_durations`
--

CREATE TABLE `package_durations` (
  `duration_id` int(11) NOT NULL,
  `packageID` int(11) NOT NULL,
  `duration_type` enum('Short-term','Mid-Semester Break','Full Semester Break') NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `package_durations`
--

INSERT INTO `package_durations` (`duration_id`, `packageID`, `duration_type`, `price`) VALUES
(1, 1, 'Short-term', 30.00),
(2, 1, 'Mid-Semester Break', 45.00),
(3, 1, 'Full Semester Break', 60.00),
(4, 2, 'Short-term', 45.00),
(5, 2, 'Mid-Semester Break', 65.00),
(6, 2, 'Full Semester Break', 85.00),
(7, 3, 'Short-term', 60.00),
(8, 3, 'Mid-Semester Break', 85.00),
(9, 3, 'Full Semester Break', 110.00);

-- --------------------------------------------------------

--
-- Table structure for table `storagepackage`
--

CREATE TABLE `storagepackage` (
  `packageID` int(5) NOT NULL,
  `package_name` varchar(15) NOT NULL,
  `base_price` decimal(10,2) NOT NULL,
  `item_limit` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `storagepackage`
--

INSERT INTO `storagepackage` (`packageID`, `package_name`, `base_price`, `item_limit`) VALUES
(1, 'Starter', 30.00, 3),
(2, 'Standard Pack', 45.00, 5),
(3, 'Max Pack', 60.00, 7);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_cred`
--
ALTER TABLE `admin_cred`
  ADD PRIMARY KEY (`sr_no`);

--
-- Indexes for table `package_durations`
--
ALTER TABLE `package_durations`
  ADD PRIMARY KEY (`duration_id`),
  ADD KEY `packageID` (`packageID`);

--
-- Indexes for table `storagepackage`
--
ALTER TABLE `storagepackage`
  ADD PRIMARY KEY (`packageID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `package_durations`
--
ALTER TABLE `package_durations`
  MODIFY `duration_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `package_durations`
--
ALTER TABLE `package_durations`
  ADD CONSTRAINT `package_durations_ibfk_1` FOREIGN KEY (`packageID`) REFERENCES `storagepackage` (`packageID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
