-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 26, 2024 at 05:06 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `project_manage`
--

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `id` int(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `gender` varchar(50) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `profession` varchar(50) NOT NULL,
  `university_name` varchar(50) DEFAULT NULL,
  `university_id` varchar(50) DEFAULT NULL,
  `company_name` varchar(50) DEFAULT NULL,
  `created_at` varchar(50) NOT NULL,
  `user_id` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`id`, `name`, `gender`, `phone`, `profession`, `university_name`, `university_id`, `company_name`, `created_at`, `user_id`) VALUES
(1, 'Sudipta Kumar Das', 'Male', '+8801931117419', 'Student', 'American International University-Bangladesh', '00-00000-0', NULL, '2024-06-25 13:41:06', 1),
(3, 'Sam William', 'Male', '+8801931118429', 'Student', 'Dhaka College', '12-12345-1', NULL, '2024-06-26 13:27:10', 6);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` varchar(50) NOT NULL,
  `role` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `email`, `password`, `created_at`, `role`) VALUES
(1, 'test1@example.com', '$2y$10$gsFzxMqov4zaTO3cnfKVKeoa6FRqv9z.u2h/3qV6EdwSHWmS2zJ9q', '2024-06-25 13:41:06', 'Customer'),
(3, 'test2@example.com', '$2y$10$gsFzxMqov4zaTO3cnfKVKeoa6FRqv9z.u2h/3qV6EdwSHWmS2zJ9q', '2024-06-26 13:41:06', 'Customer'),
(6, 'test3@gmail.com', '$2y$10$W0PMWa96ME0xUBKAt/P2vOcmNUtjAMmvKF1INqCqZ6xmI0bDpO2ae', '2024-06-26 13:27:10', 'Customer');

-- --------------------------------------------------------

--
-- Table structure for table `verification`
--

CREATE TABLE `verification` (
  `id` int(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `token` varchar(50) NOT NULL,
  `verification_code` varchar(50) NOT NULL,
  `status` varchar(50) NOT NULL,
  `action` varchar(50) NOT NULL,
  `created_at` varchar(50) NOT NULL,
  `verified_at` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `verification`
--
ALTER TABLE `verification`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `verification`
--
ALTER TABLE `verification`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
