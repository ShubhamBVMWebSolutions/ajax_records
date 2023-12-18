-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 18, 2023 at 12:28 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `student_data`
--

-- --------------------------------------------------------

--
-- Table structure for table `classes`
--

CREATE TABLE `classes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `classes` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `classes`
--

INSERT INTO `classes` (`id`, `classes`, `created_at`, `updated_at`) VALUES
(1, '1st', '2023-12-13 07:43:45', '2023-12-13 07:43:45'),
(2, '2nd', '2023-12-13 07:43:45', '2023-12-13 07:43:45'),
(3, '3rd', '2023-12-13 07:43:45', '2023-12-13 07:43:45'),
(4, '4th', '2023-12-13 07:43:45', '2023-12-13 07:43:45'),
(5, '5th', '2023-12-13 07:43:45', '2023-12-13 07:43:45'),
(6, '6th', '2023-12-13 07:43:45', '2023-12-13 07:43:45'),
(7, '7th', '2023-12-13 07:43:45', '2023-12-13 07:43:45'),
(8, '8th', '2023-12-13 07:43:45', '2023-12-13 07:43:45'),
(9, '9th', '2023-12-13 07:43:45', '2023-12-13 07:43:45'),
(10, '10th', '2023-12-13 07:43:45', '2023-12-13 07:43:45'),
(11, '11th', '2023-12-13 07:43:45', '2023-12-13 07:43:45'),
(12, '12th', '2023-12-13 07:43:45', '2023-12-13 07:43:45');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fees`
--

CREATE TABLE `fees` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `student_id` varchar(255) NOT NULL,
  `amount` varchar(255) NOT NULL,
  `due_date` varchar(255) NOT NULL,
  `deposit_date` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `fees`
--

INSERT INTO `fees` (`id`, `student_id`, `amount`, `due_date`, `deposit_date`, `status`, `created_at`, `updated_at`) VALUES
(2, '1', '500', '2024-01-01', '2024-01-03', '1', '2023-12-14 23:45:01', '2023-12-14 23:45:07'),
(3, '1', '500', '2024-02-01', '2024-02-02', '1', '2023-12-14 23:45:22', '2023-12-14 23:45:31'),
(4, '1', '500', '2024-03-01', '2024-03-04', '1', '2023-12-14 23:45:55', '2023-12-14 23:46:05'),
(5, '1', '500', '2024-04-01', '2024-04-05', '1', '2023-12-14 23:46:21', '2023-12-14 23:46:36'),
(6, '1', '500', '2024-05-01', '2024-05-11', '1', '2023-12-14 23:46:53', '2023-12-14 23:47:02'),
(7, '1', '500', '2024-06-01', '2024-06-06', '1', '2023-12-14 23:47:22', '2023-12-14 23:47:55'),
(8, '1', '500', '2024-07-01', '2024-07-12', '1', '2023-12-14 23:48:11', '2023-12-14 23:48:24'),
(9, '1', '500', '2024-08-01', '2024-08-09', '1', '2023-12-14 23:48:52', '2023-12-14 23:49:07'),
(10, '1', '500', '2024-09-01', NULL, NULL, '2023-12-14 23:56:36', '2023-12-14 23:56:36'),
(18, '4', '500', '2023-11-01', '2023-11-07', '1', '2023-12-18 03:22:16', '2023-12-18 03:22:27');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2023_12_13_071356_create_students_table', 1),
(6, '2023_12_13_074229_create_classes_table', 2),
(7, '2023_12_13_102716_create_fees_table', 3),
(8, '2023_12_15_054146_add_type_to_users_table', 4);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `age` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `name`, `age`, `class`, `created_at`, `updated_at`) VALUES
(1, 'Shubham', '21', '10th', '2023-12-13 03:28:41', '2023-12-13 03:28:41'),
(4, 'Admin', '12', '12th', '2023-12-13 06:33:41', '2023-12-13 06:33:41'),
(12, 'NARENDRA', '19', '12th', '2023-12-14 06:13:02', '2023-12-14 06:13:02'),
(13, 'pankaj', '15', '10th', '2023-12-14 06:36:07', '2023-12-14 06:36:07');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `type` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0=>User, 1=>Admin, 2=>Manager',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `type`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin User', 'admin@bvmwebsolutions.com', NULL, '$2y$12$LAK8d6dk9gU4T9XU3eAYxOI1Pw6B8fssX8HKSx9ugdaGXJq93.r6y', 1, NULL, '2023-12-15 00:29:59', '2023-12-15 00:29:59'),
(2, 'Manager User', 'manager@bvmwebsolutions.com', NULL, '$2y$12$/AVS6O1Mv/MIc9.lwrr7YusqX.gtiXqTa.v/c60cjdlLaN.NGMIIa', 2, NULL, '2023-12-15 00:29:59', '2023-12-15 00:29:59'),
(3, 'User', 'user@bvmwebsolutions.com', NULL, '$2y$12$d4m0yY86qY3qlNdyC70QV.LoVuFcAVTqQhD36Cpk86rRd9zUq4uRq', 0, NULL, '2023-12-15 00:29:59', '2023-12-15 00:29:59');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `classes`
--
ALTER TABLE `classes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `fees`
--
ALTER TABLE `fees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
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
-- AUTO_INCREMENT for table `classes`
--
ALTER TABLE `classes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fees`
--
ALTER TABLE `fees`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
