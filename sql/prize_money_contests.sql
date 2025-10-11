-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 11, 2025 at 10:47 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.1.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bznesshub`
--

-- --------------------------------------------------------

--
-- Table structure for table `prize_money_contests`
--

CREATE TABLE `prize_money_contests` (
  `id` int(11) NOT NULL,
  `reward_type` int(11) NOT NULL DEFAULT 0 COMMENT '1 Referral Winner\r\n2 Daily Prize Money Winner\r\n3 Festival Winner',
  `title` varchar(255) NOT NULL,
  `type` int(11) NOT NULL DEFAULT 0 COMMENT '1 cash\r\n2: New User Bonus',
  `value` decimal(10,2) NOT NULL,
  `winners` int(11) NOT NULL,
  `schedule_date` date NOT NULL,
  `status` int(11) DEFAULT 0 COMMENT '0 pending,1completed\r\n',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `prize_money_contests`
--

INSERT INTO `prize_money_contests` (`id`, `reward_type`, `title`, `type`, `value`, `winners`, `schedule_date`, `status`, `created_at`, `updated_at`) VALUES
(3, 1, 'Referral', 1, 500.00, 2, '2024-10-14', 0, '2025-10-11 02:48:21', '2025-10-11 04:09:38'),
(6, 1, 'Referral', 2, 500.00, 3, '2024-10-16', 0, '2025-10-11 02:48:21', '2025-10-11 08:46:34');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `prize_money_contests`
--
ALTER TABLE `prize_money_contests`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `prize_money_contests`
--
ALTER TABLE `prize_money_contests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
