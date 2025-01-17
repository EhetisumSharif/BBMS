-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 15, 2025 at 08:07 AM
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
-- Database: `bbms`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `u_name` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `u_name`, `password`) VALUES
(1, 'admin', '11223344');

-- --------------------------------------------------------

--
-- Table structure for table `blood_stock`
--

CREATE TABLE `blood_stock` (
  `id` int(11) NOT NULL,
  `bgroup` varchar(10) NOT NULL,
  `quantity` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `blood_stock`
--

INSERT INTO `blood_stock` (`id`, `bgroup`, `quantity`) VALUES
(42, 'A+', -6),
(43, 'A-', 1),
(44, 'B+', 1),
(45, 'B-', 1),
(46, 'O+', 2),
(47, 'O-', 1),
(48, 'AB+', 1),
(49, 'AB-', 1);

-- --------------------------------------------------------

--
-- Table structure for table `donor_recipient_assignment`
--

CREATE TABLE `donor_recipient_assignment` (
  `id` int(11) NOT NULL,
  `donor_id` int(11) NOT NULL,
  `recipient_id` int(11) NOT NULL,
  `assigned_quantity` int(11) NOT NULL,
  `assignment_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('pending','completed','canceled') DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `donor_recipient_assignment`
--

INSERT INTO `donor_recipient_assignment` (`id`, `donor_id`, `recipient_id`, `assigned_quantity`, `assignment_date`, `status`) VALUES
(58, 67, 41, 1, '2025-01-07 09:14:20', 'completed'),
(59, 75, 41, 1, '2025-01-07 09:15:27', 'canceled'),
(60, 75, 41, 1, '2025-01-07 09:15:57', 'completed');

-- --------------------------------------------------------

--
-- Table structure for table `donor_registration`
--

CREATE TABLE `donor_registration` (
  `id` int(50) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `fname` varchar(50) DEFAULT NULL,
  `address` varchar(250) DEFAULT NULL,
  `gender` varchar(50) DEFAULT NULL,
  `age` varchar(25) DEFAULT NULL,
  `bgroup` varchar(20) DEFAULT NULL,
  `email` varchar(200) DEFAULT NULL,
  `pno` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `donor_registration`
--

INSERT INTO `donor_registration` (`id`, `name`, `fname`, `address`, `gender`, `age`, `bgroup`, `email`, `pno`) VALUES
(67, 'Aminul Islam', 'Abdul Kader', '123, Kazi Nazrul Islam Avenue, Dhaka', 'Male', '30', 'A+', 'aminul.islam@example.com', '0171-1234567'),
(68, 'Fatima Begum', 'Mohammad Ali', '456, Shere-e-Bangla Nagar, Dhaka', 'Female', '25', 'B-', 'fatima.begum@example.com', '0171-2345678'),
(69, 'Rashida Akter', 'Abdul Rahim', '789, Mirpur Road, Dhaka', 'Female', '28', 'O+', 'rashida.akter@example.com', '0171-3456789'),
(70, 'Saidur Rahman', 'Mohammad Shamsul', '101, New Eskaton, Dhaka', 'Male', '35', 'AB+', 'saidur.rahman@example.com', '0171-4567890'),
(71, 'Sharmin Sultana', 'Gazi Mohammad', '202, Uttara, Dhaka', 'Female', '22', 'A-', 'sharmin.sultana@example.com', '0171-5678901'),
(72, 'Tareq Zaman', 'Abdul Gafur', '303, Banani, Dhaka', 'Male', '27', 'O-', 'tareq.zaman@example.com', '0171-6789012'),
(73, 'Khatija Akter', 'Lutfur Rahman', '404, Moghbazar, Dhaka', 'Female', '40', 'B+', 'khatija.akter@example.com', '0171-7890123'),
(74, 'Shamim Hossain', 'Nasir Uddin', '505, Puran Dhaka, Dhaka', 'Male', '31', 'AB-', 'shamim.hossain@example.com', '0171-8901234'),
(75, 'Marium Binte Aslam', 'Sayedul Islam', '606, South Banasree, Dhaka', 'Female', '33', 'A+', 'marium.aslam@example.com', '0171-9012345'),
(76, 'Rifat Ahmed', 'Mohammad Rafique', '707, Shyamoli, Dhaka', 'Male', '24', 'O+', 'rifat.ahmed@example.com', '0171-0123456');

-- --------------------------------------------------------

--
-- Table structure for table `recipent_registration`
--

CREATE TABLE `recipent_registration` (
  `id` int(50) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `age` varchar(25) DEFAULT NULL,
  `problems` varchar(200) DEFAULT NULL,
  `bgroup` varchar(50) DEFAULT NULL,
  `quantity` int(25) DEFAULT NULL,
  `place` varchar(250) DEFAULT NULL,
  `time` varchar(50) DEFAULT NULL,
  `pno` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `recipent_registration`
--

INSERT INTO `recipent_registration` (`id`, `name`, `age`, `problems`, `bgroup`, `quantity`, `place`, `time`, `pno`) VALUES
(41, 'Mohammad Ali', '45', 'Anemia', 'A+', 2, 'Dhaka', '2025-01-06', '0181-1234567'),
(42, 'Shama Parveen', '34', 'Heart Disease', 'B-', 3, 'Chittagong', '2025-01-07', '0181-2345678'),
(43, 'Rashidul Islam', '50', 'Cancer', 'O+', 1, 'Rajshahi', '2025-01-08', '0181-3456789'),
(44, 'Fariha Begum', '28', 'Liver Cirrhosis', 'AB+', 2, 'Khulna', '2025-01-09', '0181-4567890'),
(45, 'Mizanur Rahman', '40', 'Kidney Failure', 'A-', 5, 'Sylhet', '2025-01-10', '0181-5678901'),
(46, 'Tariq Zaman', '38', 'Severe Bleeding', 'O-', 1, 'Barisal', '2025-01-11', '0181-6789012'),
(47, 'Sabrina Sultana', '55', 'Tuberculosis', 'B+', 2, 'Mymensingh', '2025-01-12', '0181-7890123'),
(48, 'Shahidul Alam', '60', 'Respiratory Issues', 'AB-', 4, 'Rajbari', '2025-01-13', '0181-8901234'),
(49, 'Nasreen Akter', '31', 'Pneumonia', 'A+', 3, 'Comilla', '2025-01-14', '0181-9012345'),
(50, 'Jahangir Alam', '48', 'Leukemia', 'O+', 2, 'Khulna', '2025-01-15', '0181-0123456');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blood_stock`
--
ALTER TABLE `blood_stock`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `bgroup` (`bgroup`),
  ADD UNIQUE KEY `unique_bgroup` (`bgroup`);

--
-- Indexes for table `donor_recipient_assignment`
--
ALTER TABLE `donor_recipient_assignment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `donor_id` (`donor_id`),
  ADD KEY `recipient_id` (`recipient_id`);

--
-- Indexes for table `donor_registration`
--
ALTER TABLE `donor_registration`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `recipent_registration`
--
ALTER TABLE `recipent_registration`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `blood_stock`
--
ALTER TABLE `blood_stock`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `donor_recipient_assignment`
--
ALTER TABLE `donor_recipient_assignment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `donor_registration`
--
ALTER TABLE `donor_registration`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- AUTO_INCREMENT for table `recipent_registration`
--
ALTER TABLE `recipent_registration`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `donor_recipient_assignment`
--
ALTER TABLE `donor_recipient_assignment`
  ADD CONSTRAINT `donor_recipient_assignment_ibfk_1` FOREIGN KEY (`donor_id`) REFERENCES `donor_registration` (`id`),
  ADD CONSTRAINT `donor_recipient_assignment_ibfk_2` FOREIGN KEY (`recipient_id`) REFERENCES `recipent_registration` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
