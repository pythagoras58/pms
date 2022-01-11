-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 23, 2021 at 10:44 PM
-- Server version: 10.4.8-MariaDB
-- PHP Version: 7.3.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `carparking`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `indexnumber` varchar(10) NOT NULL,
  `password` text NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `indexnumber`, `password`, `name`) VALUES
(1, 'ADM/001', '$2y$10$STE2fhADBcN//9KOovjeduS/imXVLEv.jFJvB0m/c4j3cTvHcX73S', 'Mr. Pepsi 2');

-- --------------------------------------------------------

--
-- Table structure for table `authentication`
--

CREATE TABLE `authentication` (
  `id` int(11) NOT NULL,
  `indexnumber` varchar(10) NOT NULL,
  `password` text NOT NULL,
  `usertype` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `authentication`
--

INSERT INTO `authentication` (`id`, `indexnumber`, `password`, `usertype`) VALUES
(1, 'Sec/001', '$2y$10$.DeECwm45pLBMr0rwG0EBeo7IURp2yRK3k.AUsOeobeI5qFif.Fza', 'Security'),
(2, 'Sec/002', '$2y$10$M/zdiu/isO7E4h.4bSQKe.wVeDe1feOplyRhlKCbTPEUEln0zKlJO', 'Security'),
(3, 'Sec/003', '$2y$10$XQrjxg30AQw6rG7isqxRcuejD/IkkxBTTqxfqTSpednvLoUAoOVQa', 'Security'),
(4, 'Sec/004', '$2y$10$fV0X.p0m3VyylgjArni5CeOmh138gdP8T8TstBtUdK7W22/cjUw5C', 'Security'),
(5, 'Sec/005', '$2y$10$H8lK6RwVVDIIH.SDUAzeb.o6ZoGnCIARvitHxUQgqFgKBIxKEuoMq', 'Security'),
(6, 'LEC/001', '$2y$10$ZnrPQpaEp7le4/oIzKeW0eTjrkbudAnXmKsrtPTotFw9.6C1Cbim6', 'Staff'),
(8, 'ADM/001', '$2y$10$STE2fhADBcN//9KOovjeduS/imXVLEv.jFJvB0m/c4j3cTvHcX73S', 'Admin'),
(9, 'PUC/170012', '$2y$10$OBZM4CynDcQVwviR/P5QI.mmN6JXr3eJKRA9HDnGARnV/TkBbwpoy', 'Student'),
(10, 'LEC/002', '$2y$10$tUrcKSfJZRHtdDJgKKBmceE/jRwtCpn3HBoALBVOhQ5kphhqRvkmu', 'Staff');

-- --------------------------------------------------------

--
-- Table structure for table `booking`
--

CREATE TABLE `booking` (
  `id` int(11) NOT NULL,
  `indexnumber` varchar(50) NOT NULL,
  `carnumber` varchar(50) NOT NULL,
  `parking_lot` varchar(200) NOT NULL,
  `contact` varchar(20) NOT NULL,
  `status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `faculty` varchar(200) NOT NULL,
  `status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`id`, `name`, `faculty`, `status`) VALUES
(1, 'BSc. Psychology', 'FBA', 'Active'),
(2, 'BSc. Banking And Finance', 'default', 'Active'),
(3, 'BSc. Information Security', '', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `faculty`
--

CREATE TABLE `faculty` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `faculty`
--

INSERT INTO `faculty` (`id`, `name`, `status`) VALUES
(3, 'FBA', 'Active'),
(4, 'FESAC', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `parking_lot`
--

CREATE TABLE `parking_lot` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `location` text NOT NULL,
  `type` varchar(50) NOT NULL,
  `status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `parking_lot`
--

INSERT INTO `parking_lot` (`id`, `name`, `location`, `type`, `status`) VALUES
(1, 'AUD001', 'JM Auditorium', 'lecturer', 'Active'),
(2, 'AUD002', 'JM Auditorium', 'student', 'Active'),
(3, 'AN001', 'Arnan Hall', 'student', 'Active'),
(4, 'AN002', 'Arnan Hall', 'lecturer', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `security`
--

CREATE TABLE `security` (
  `id` int(11) NOT NULL,
  `indexnumber` varchar(50) NOT NULL,
  `name` varchar(200) NOT NULL,
  `contact` varchar(15) NOT NULL,
  `password` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `security`
--

INSERT INTO `security` (`id`, `indexnumber`, `name`, `contact`, `password`) VALUES
(1, 'Sec/001', 'Mr. Kwaku Menu Raymond', '0243896532', '$2y$10$.DeECwm45pLBMr0rwG0EBeo7IURp2yRK3k.AUsOeobeI5qFif.Fza'),
(2, 'Sec/002', 'Mr. Kwesi', '0558963347', '$2y$10$M/zdiu/isO7E4h.4bSQKe.wVeDe1feOplyRhlKCbTPEUEln0zKlJO'),
(3, 'Sec/003', 'Mrs Akosua', '023654589', '$2y$10$XQrjxg30AQw6rG7isqxRcuejD/IkkxBTTqxfqTSpednvLoUAoOVQa'),
(4, 'Sec/004', 'Mrs. Owusu', '030548796', '$2y$10$fV0X.p0m3VyylgjArni5CeOmh138gdP8T8TstBtUdK7W22/cjUw5C'),
(5, 'Sec/005', 'Mr. Ofori', '030365894', '$2y$10$H8lK6RwVVDIIH.SDUAzeb.o6ZoGnCIARvitHxUQgqFgKBIxKEuoMq');

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `id` int(11) NOT NULL,
  `indexnumber` varchar(10) NOT NULL,
  `name` varchar(200) NOT NULL,
  `faculty` varchar(100) NOT NULL,
  `department` varchar(100) NOT NULL,
  `password` text NOT NULL,
  `contact` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`id`, `indexnumber`, `name`, `faculty`, `department`, `password`, `contact`) VALUES
(1, 'LEC/001', 'Mr. Agbeko', 'FESAC', 'BSc. Information Security', '$2y$10$ZnrPQpaEp7le4/oIzKeW0eTjrkbudAnXmKsrtPTotFw9.6C1Cbim6', '0243896532'),
(2, 'LEC/002', 'Prof Mary', 'FESAC', 'BSc. Information Security', '$2y$10$tUrcKSfJZRHtdDJgKKBmceE/jRwtCpn3HBoALBVOhQ5kphhqRvkmu', '0548796326');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `id` int(11) NOT NULL,
  `indexnumber` varchar(10) NOT NULL,
  `name` varchar(200) NOT NULL,
  `faculty` varchar(100) NOT NULL,
  `department` varchar(100) NOT NULL,
  `contact` varchar(15) NOT NULL,
  `password` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`id`, `indexnumber`, `name`, `faculty`, `department`, `contact`, `password`) VALUES
(1, 'PUC/170012', 'Raymond', 'FESAC', 'BSc. Information Security', '0243896532', '$2y$10$OBZM4CynDcQVwviR/P5QI.mmN6JXr3eJKRA9HDnGARnV/TkBbwpoy');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `authentication`
--
ALTER TABLE `authentication`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `indexnumber` (`indexnumber`);

--
-- Indexes for table `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `indexnumber` (`indexnumber`),
  ADD UNIQUE KEY `carnumber` (`carnumber`);

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `faculty`
--
ALTER TABLE `faculty`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `parking_lot`
--
ALTER TABLE `parking_lot`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `security`
--
ALTER TABLE `security`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `indexnumber` (`indexnumber`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `indexnumber` (`indexnumber`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `authentication`
--
ALTER TABLE `authentication`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `booking`
--
ALTER TABLE `booking`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `department`
--
ALTER TABLE `department`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `faculty`
--
ALTER TABLE `faculty`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `parking_lot`
--
ALTER TABLE `parking_lot`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `security`
--
ALTER TABLE `security`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
