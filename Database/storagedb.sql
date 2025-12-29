-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 28, 2025 at 07:36 PM
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
-- Table structure for table `assignedtask`
--

CREATE TABLE `assignedtask` (
  `taskID` int(11) NOT NULL,
  `staffID` int(11) NOT NULL,
  `bookingID` int(11) NOT NULL,
  `task_type` varchar(100) DEFAULT NULL,
  `task_status` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `booking`
--

CREATE TABLE `booking` (
  `bookingID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `packageID` int(11) NOT NULL,
  `pickup_date` varchar(20) DEFAULT NULL,
  `return_date` varchar(20) DEFAULT NULL,
  `booking_status` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `paymentID` int(11) NOT NULL,
  `bookingID` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_method` varchar(50) DEFAULT NULL,
  `payment_date` varchar(20) DEFAULT NULL,
  `payment_status` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `staffID` int(11) NOT NULL,
  `staff_name` varchar(100) NOT NULL,
  `staff_email` varchar(100) NOT NULL,
  `staff_phone` varchar(20) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `shift` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `storageitem`
--

CREATE TABLE `storageitem` (
  `itemID` int(11) NOT NULL,
  `bookingID` int(11) NOT NULL,
  `item_name` varchar(100) DEFAULT NULL,
  `item_status` varchar(50) DEFAULT NULL,
  `storage_location` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `storagepackage`
--

CREATE TABLE `storagepackage` (
  `packageID` int(5) NOT NULL,
  `package_name` varchar(15) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `item_limit` int(10) NOT NULL,
  `duration` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `storagepackage`
--

INSERT INTO `storagepackage` (`packageID`, `package_name`, `price`, `item_limit`, `duration`) VALUES
(1, 'Starter', 30.00, 3, ''),
(2, 'Standard Pack', 45.00, 5, ''),
(3, 'Max Pack', 60.00, 7, '');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `userID` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `address` text NOT NULL,
  `phone_number` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`userID`, `name`, `email`, `address`, `phone_number`, `password`) VALUES
(1, '', '', '', '', ''),
(2, 'try', 'try@example.com', 'try test jak', '0123456789', '81dc9bdb52d04dc20036dbd8313ed055');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_cred`
--
ALTER TABLE `admin_cred`
  ADD PRIMARY KEY (`sr_no`);

--
-- Indexes for table `assignedtask`
--
ALTER TABLE `assignedtask`
  ADD PRIMARY KEY (`taskID`),
  ADD KEY `staffID` (`staffID`),
  ADD KEY `bookingID` (`bookingID`);

--
-- Indexes for table `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`bookingID`),
  ADD KEY `userID` (`userID`),
  ADD KEY `packageID` (`packageID`);

--
-- Indexes for table `package_durations`
--
ALTER TABLE `package_durations`
  ADD PRIMARY KEY (`duration_id`),
  ADD KEY `packageID` (`packageID`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`paymentID`),
  ADD KEY `bookingID` (`bookingID`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`staffID`),
  ADD UNIQUE KEY `staff_email` (`staff_email`);

--
-- Indexes for table `storageitem`
--
ALTER TABLE `storageitem`
  ADD PRIMARY KEY (`itemID`),
  ADD KEY `bookingID` (`bookingID`);

--
-- Indexes for table `storagepackage`
--
ALTER TABLE `storagepackage`
  ADD PRIMARY KEY (`packageID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`userID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `assignedtask`
--
ALTER TABLE `assignedtask`
  MODIFY `taskID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `booking`
--
ALTER TABLE `booking`
  MODIFY `bookingID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `package_durations`
--
ALTER TABLE `package_durations`
  MODIFY `duration_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `paymentID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `staffID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `storageitem`
--
ALTER TABLE `storageitem`
  MODIFY `itemID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `assignedtask`
--
ALTER TABLE `assignedtask`
  ADD CONSTRAINT `assignedtask_ibfk_1` FOREIGN KEY (`staffID`) REFERENCES `staff` (`staffID`) ON DELETE CASCADE,
  ADD CONSTRAINT `assignedtask_ibfk_2` FOREIGN KEY (`bookingID`) REFERENCES `booking` (`bookingID`) ON DELETE CASCADE;

--
-- Constraints for table `booking`
--
ALTER TABLE `booking`
  ADD CONSTRAINT `booking_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `user` (`userID`) ON DELETE CASCADE,
  ADD CONSTRAINT `booking_ibfk_2` FOREIGN KEY (`packageID`) REFERENCES `storagepackage` (`packageID`) ON DELETE CASCADE;

--
-- Constraints for table `package_durations`
--
ALTER TABLE `package_durations`
  ADD CONSTRAINT `package_durations_ibfk_1` FOREIGN KEY (`packageID`) REFERENCES `storagepackage` (`packageID`);

--
-- Constraints for table `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `payment_ibfk_1` FOREIGN KEY (`bookingID`) REFERENCES `booking` (`bookingID`) ON DELETE CASCADE;

--
-- Constraints for table `storageitem`
--
ALTER TABLE `storageitem`
  ADD CONSTRAINT `storageitem_ibfk_1` FOREIGN KEY (`bookingID`) REFERENCES `booking` (`bookingID`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
