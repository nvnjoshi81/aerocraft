-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 23, 2024 at 10:34 PM
-- Server version: 10.4.13-MariaDB
-- PHP Version: 7.4.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `aerocraft`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(30) UNSIGNED NOT NULL,
  `name` varchar(250) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` text NOT NULL,
  `password` text NOT NULL,
  `country_code` varchar(5) NOT NULL,
  `mobile` varchar(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `type` tinyint(1) NOT NULL,
  `address` text DEFAULT NULL,
  `gender` varchar(7) DEFAULT NULL,
  `hobby` varchar(51) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `last_name`, `email`, `password`, `country_code`, `mobile`, `status`, `type`, `address`, `gender`, `hobby`, `image`, `created_at`, `updated_at`) VALUES
(1, 'Administrator', 'admin', 'admin@mail.com', '$2y$10$.Y3hjPVno73LQU6jpoFvSOOWYqfSWMaHcCWCr9TFmYWqkDcJuR672', '', '0', 1, 1, NULL, '0', NULL, '', '2024-03-22 14:47:04', '2024-03-22 19:51:18'),
(13, 'John', 'Michel', 'johnmichel@gmail.com', '$2y$10$zXBXlrFTI8hhLXH7s7zcCOV6112I9yUvQVim8MIFEQ/rXrvSJxXku', '971', '3243434564', 1, 0, 'Test address of johnmichel@gmail.com', 'Male', '1,3,4', '1711229522_7ef94f46d58ce2302db6.jpg', '2024-03-24 03:02:02', '2024-03-24 03:04:16');

-- --------------------------------------------------------

--
-- Table structure for table `userstest1`
--

CREATE TABLE `userstest1` (
  `id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `country_code` varchar(5) DEFAULT NULL,
  `mobile` mediumint(10) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `gender` varchar(2) DEFAULT NULL,
  `hobby` varchar(50) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `create_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `userstest1`
--
ALTER TABLE `userstest1`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(30) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `userstest1`
--
ALTER TABLE `userstest1`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
