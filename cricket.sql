-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 13, 2020 at 01:00 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.2.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cricket`
--

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fixtures`
--

DROP TABLE IF EXISTS `fixtures`;
CREATE TABLE `fixtures` (
  `id` int(10) NOT NULL,
  `team_a` int(4) NOT NULL,
  `team_b` int(4) NOT NULL,
  `match_date` date DEFAULT NULL,
  `venue` varchar(45) NOT NULL,
  `status` tinyint(2) NOT NULL DEFAULT 1 COMMENT '1:pending;2:draw;3:complete',
  `winner` int(10) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `comments` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `fixtures`
--

INSERT INTO `fixtures` VALUES
(2, 3, 5, '2020-07-17', 'Hyerabad', 3, 3, '2020-07-12 18:05:22', '2020-07-13 15:35:12', ''),
(3, 4, 6, '2020-07-18', 'Bangalore', 3, 4, '2020-07-13 09:36:04', '2020-07-13 15:22:52', ''),
(4, 4, 5, '2020-07-19', 'Chennai', 3, 5, '2020-07-13 09:53:57', '2020-07-13 09:54:21', ''),
(5, 6, 3, '2020-07-20', 'Delhi', 3, 6, '2020-07-13 09:54:52', '2020-07-13 09:55:36', '');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `players`
--

DROP TABLE IF EXISTS `players`;
CREATE TABLE `players` (
  `id` int(10) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `image_uri` varchar(255) NOT NULL,
  `jersey_number` varchar(20) NOT NULL,
  `country` varchar(255) DEFAULT NULL,
  `matches` int(10) DEFAULT NULL,
  `runs` int(10) DEFAULT NULL,
  `highest_score` int(10) DEFAULT NULL,
  `fifties` int(10) DEFAULT NULL,
  `hundreds` int(10) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `players`
--

INSERT INTO `players` VALUES
(2, 'Shikhar', 'Dhawan', 'uploads/players/images.jpeg', 'DS123', 'IND', NULL, NULL, NULL, NULL, NULL, '2020-07-12 15:49:31', '2020-07-12 15:49:31'),
(3, 'Ishant', 'Sharma', 'uploads/players/255px-Ishant_Sharma_2.jpeg', 'SI123', 'IND', NULL, NULL, NULL, NULL, NULL, '2020-07-12 15:51:00', '2020-07-12 15:51:00'),
(4, 'Virat', 'Kohli', 'uploads/players/390px-thumbnail.jpeg', 'KV123', 'IND', NULL, NULL, NULL, NULL, NULL, '2020-07-12 15:52:38', '2020-07-12 15:52:38'),
(5, 'Dhoni', 'MS', 'uploads/players/Mahendra_Singh_Dhoni_January_2016_(cropped).jpeg', 'MSD123', 'IND', NULL, NULL, NULL, NULL, NULL, '2020-07-12 15:55:00', '2020-07-12 15:55:00'),
(6, 'Rohit Gurunath', 'Sharma', 'uploads/players/390px-Rohit_Sharma_November_2016_(cropped).jpeg', 'SR123', 'IND', NULL, NULL, NULL, NULL, NULL, '2020-07-12 15:56:11', '2020-07-12 15:56:11'),
(7, 'Babar Azam', 'Mohammad', 'uploads/players/390px-Babar_Azam.png', 'MBA123', 'PAK', NULL, NULL, NULL, NULL, NULL, '2020-07-12 15:58:12', '2020-07-12 15:58:12'),
(8, 'Mohammad', 'Amir', 'uploads/players/390px-Mohammad_Amir.jpeg', 'AM123', 'PAK', NULL, NULL, NULL, NULL, NULL, '2020-07-12 15:59:06', '2020-07-12 15:59:06'),
(9, 'Malik', 'Shoaibb', 'uploads/players/390px-Shoaib_Malik_answering_RAPID_FIRE_questions_(PCB)_01.jpeg', 'SM123', 'PAK', NULL, NULL, NULL, NULL, NULL, '2020-07-12 16:00:12', '2020-07-13 10:59:26');

-- --------------------------------------------------------

--
-- Table structure for table `teams`
--

DROP TABLE IF EXISTS `teams`;
CREATE TABLE `teams` (
  `id` int(10) NOT NULL,
  `name` varchar(255) NOT NULL,
  `logo_uri` varchar(255) NOT NULL,
  `club_state` tinyint(1) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `teams`
--

INSERT INTO `teams` VALUES
(3, 'Kings eleven punjab', 'uploads/teams/2ff3e9f8b4c2099d70c582085705b745.jpeg', 1, '2020-07-12 01:29:19', '2020-07-12 16:07:05'),
(4, 'Hyderabad Deccan Chargers', 'uploads/teams/Dcharges.jpeg', 1, '2020-07-12 16:08:26', '2020-07-12 16:08:26'),
(5, 'Chennai Super Kings', 'uploads/teams/cskings.png', 1, '2020-07-12 16:09:13', '2020-07-12 16:09:13'),
(6, 'Kolkata Knight Riders', 'uploads/teams/kkr.png', 1, '2020-07-12 16:09:51', '2020-07-12 16:09:51');

-- --------------------------------------------------------

--
-- Table structure for table `team_player_mappings`
--

DROP TABLE IF EXISTS `team_player_mappings`;
CREATE TABLE `team_player_mappings` (
  `id` int(10) NOT NULL,
  `team_id` int(10) NOT NULL,
  `player_id` int(10) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `team_player_mappings`
--

INSERT INTO `team_player_mappings` VALUES
(10, 6, 3, '2020-07-12 17:18:29', '2020-07-12 17:18:29'),
(11, 6, 4, '2020-07-12 17:18:29', '2020-07-12 17:18:29'),
(12, 5, 2, '2020-07-13 10:35:20', '2020-07-13 10:35:20'),
(13, 5, 5, '2020-07-13 10:35:20', '2020-07-13 10:35:20');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fixtures`
--
ALTER TABLE `fixtures`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `players`
--
ALTER TABLE `players`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `teams`
--
ALTER TABLE `teams`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `team_player_mappings`
--
ALTER TABLE `team_player_mappings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fixtures`
--
ALTER TABLE `fixtures`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `players`
--
ALTER TABLE `players`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `teams`
--
ALTER TABLE `teams`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `team_player_mappings`
--
ALTER TABLE `team_player_mappings`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
