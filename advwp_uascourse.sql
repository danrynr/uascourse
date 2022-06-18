-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 18, 2022 at 05:53 PM
-- Server version: 8.0.29-0ubuntu0.20.04.3
-- PHP Version: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `advwp_uascourse`
--

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE `course` (
  `id` int NOT NULL,
  `name` varchar(45) NOT NULL,
  `price` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`id`, `name`, `price`) VALUES
(1, 'phpsql', 120000),
(2, 'virtcloud', 110000),
(3, 'network', 100000),
(4, 'hardperi', 80000);

-- --------------------------------------------------------

--
-- Table structure for table `usercart`
--

CREATE TABLE `usercart` (
  `username` varchar(45) NOT NULL,
  `quantity_ps` int NOT NULL,
  `quantity_vc` int NOT NULL,
  `quantity_net` int NOT NULL,
  `quantity_hp` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `usercart`
--

INSERT INTO `usercart` (`username`, `quantity_ps`, `quantity_vc`, `quantity_net`, `quantity_hp`) VALUES
('danrynr', 0, 0, 1, 0),
('lenn3', 1, 1, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `usercre`
--

CREATE TABLE `usercre` (
  `id` int NOT NULL,
  `username` varchar(45) NOT NULL,
  `pass_hash` varchar(255) NOT NULL,
  `name` varchar(100) NOT NULL,
  `birthdate` date NOT NULL,
  `gender` varchar(1) NOT NULL,
  `education` varchar(11) NOT NULL,
  `address` varchar(100) NOT NULL,
  `hobby` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `usercre`
--

INSERT INTO `usercre` (`id`, `username`, `pass_hash`, `name`, `birthdate`, `gender`, `education`, `address`, `hobby`) VALUES
(1, 'danrynr', '$2y$10$BeZg6zuNT/y0rxjyzdbZ6u93X1jJP9siFpyZdn6ohMwBmZ627xKa2', 'Daniel Reynard Kurniawan', '2003-04-07', 'L', 'Sarjana', 'Puri Gading Alam Raya 1 Blok M1 No. 2', 'Ngoding'),
(2, 'lenn3', '$2y$10$2t.OYymUNJCAeU3A/z612uGhUrm/21hYwt8mjXEHplr8VjQgC6o6m', 'Lenn', '2004-06-22', 'P', 'Sarjana', 'Pondok Indah', 'Memasak');

-- --------------------------------------------------------

--
-- Table structure for table `userhistory`
--

CREATE TABLE `userhistory` (
  `order_id` int NOT NULL,
  `username` varchar(45) NOT NULL,
  `price_ps` int NOT NULL,
  `quantity_ps` int NOT NULL,
  `price_vc` int NOT NULL,
  `quantity_vc` int NOT NULL,
  `price_net` int NOT NULL,
  `quantity_net` int NOT NULL,
  `price_hp` int NOT NULL,
  `quantity_hp` int NOT NULL,
  `diskon` int NOT NULL,
  `diskon_tambahan` int NOT NULL,
  `subtotal` int NOT NULL,
  `total` int NOT NULL,
  `waktu_beli` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `userhistory`
--

INSERT INTO `userhistory` (`order_id`, `username`, `price_ps`, `quantity_ps`, `price_vc`, `quantity_vc`, `price_net`, `quantity_net`, `price_hp`, `quantity_hp`, `diskon`, `diskon_tambahan`, `subtotal`, `total`, `waktu_beli`) VALUES
(1, 'danrynr', 0, 0, 220000, 2, 200000, 2, 320000, 4, 14800, 37000, 740000, 688200, '2022-06-16 08:41:20'),
(2, 'danrynr', 120000, 1, 220000, 2, 0, 0, 0, 0, 0, 17000, 340000, 323000, '2022-06-16 08:41:27'),
(3, 'danrynr', 600000, 5, 2420000, 22, 300000, 3, 2400000, 30, 572000, 286000, 5720000, 4862000, '2022-06-16 08:41:43'),
(4, 'danrynr', 0, 0, 0, 0, 100000, 1, 0, 0, 0, 5000, 100000, 95000, '2022-06-16 08:41:55'),
(5, 'danrynr', 0, 0, 0, 0, 0, 0, 320000, 4, 0, 16000, 320000, 304000, '2022-06-16 08:41:59'),
(6, 'danrynr', 600000, 5, 0, 0, 0, 0, 0, 0, 0, 30000, 600000, 570000, '2022-06-16 08:42:08'),
(7, 'danrynr', 0, 0, 220000, 2, 0, 0, 0, 0, 0, 11000, 220000, 209000, '2022-06-16 08:42:12'),
(8, 'danrynr', 240000, 2, 440000, 4, 0, 0, 0, 0, 0, 34000, 680000, 646000, '2022-06-16 08:42:19'),
(9, 'danrynr', 0, 0, 4730000, 43, 0, 0, 160000, 2, 489000, 244500, 4890000, 4156500, '2022-06-16 08:42:29'),
(10, 'danrynr', 0, 0, 440000, 4, 300000, 3, 160000, 2, 18000, 45000, 900000, 837000, '2022-06-16 08:42:41'),
(11, 'danrynr', 240000, 2, 1100000, 10, 200000, 2, 560000, 7, 210000, 105000, 2100000, 1785000, '2022-06-16 09:21:50'),
(12, 'danrynr', 1440000, 12, 220000, 2, 3200000, 32, 0, 0, 486000, 243000, 4860000, 4131000, '2022-06-16 10:19:21'),
(13, 'danrynr', 120000, 1, 110000, 1, 100000, 1, 80000, 1, 20500, 20500, 410000, 369000, '2022-06-16 10:19:27'),
(14, 'danrynr', 240000, 2, 220000, 2, 500000, 5, 240000, 3, 60000, 60000, 1200000, 1080000, '2022-06-16 10:19:36'),
(15, 'danrynr', 120000, 1, 220000, 2, 300000, 3, 320000, 4, 48000, 48000, 960000, 864000, '2022-06-16 11:10:34'),
(16, 'lenn3', 120000, 1, 220000, 2, 0, 0, 0, 0, 0, 10200, 340000, 329800, '2022-06-16 11:12:26'),
(17, 'lenn3', 360000, 3, 0, 0, 0, 0, 160000, 2, 0, 15600, 520000, 504400, '2022-06-16 11:12:32'),
(18, 'danrynr', 240000, 2, 0, 0, 0, 0, 0, 0, 0, 12000, 240000, 228000, '2022-06-16 11:12:54'),
(20, 'danrynr', 120000, 1, 110000, 1, 100000, 1, 80000, 1, 20500, 20500, 410000, 369000, '2022-06-17 15:10:40'),
(23, 'lenn3', 120000, 1, 110000, 1, 100000, 1, 80000, 1, 20500, 12300, 410000, 377200, '2022-06-17 15:39:00'),
(25, 'lenn3', 480000, 4, 330000, 3, 0, 0, 0, 0, 0, 24300, 810000, 785700, '2022-06-18 09:26:34'),
(26, 'lenn3', 120000, 1, 0, 0, 0, 0, 80000, 1, 0, 6000, 200000, 194000, '2022-06-18 10:00:07'),
(27, 'lenn3', 0, 0, 220000, 2, 300000, 3, 80000, 1, 12000, 18000, 600000, 570000, '2022-06-18 10:00:27'),
(28, 'lenn3', 1440000, 12, 220000, 2, 400000, 4, 25840000, 323, 2790000, 837000, 27900000, 24273000, '2022-06-18 10:01:06'),
(29, 'lenn3', 120000, 1, 220000, 2, 0, 0, 0, 0, 0, 10200, 340000, 329800, '2022-06-18 10:01:15'),
(30, 'lenn3', 120000, 1, 110000, 1, 100000, 1, 80000, 1, 20500, 12300, 410000, 377200, '2022-06-18 10:01:48'),
(31, 'danrynr', 120000, 1, 110000, 1, 100000, 1, 80000, 1, 20500, 20500, 410000, 369000, '2022-06-18 10:03:23'),
(32, 'danrynr', 120000, 1, 110000, 1, 100000, 1, 0, 0, 6600, 16500, 330000, 306900, '2022-06-18 10:03:36');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `usercart`
--
ALTER TABLE `usercart`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `usercre`
--
ALTER TABLE `usercre`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `userhistory`
--
ALTER TABLE `userhistory`
  ADD PRIMARY KEY (`order_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `course`
--
ALTER TABLE `course`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `usercre`
--
ALTER TABLE `usercre`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `userhistory`
--
ALTER TABLE `userhistory`
  MODIFY `order_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
