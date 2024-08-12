-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 12, 2024 at 06:15 AM
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
-- Database: `bta`
--

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `date` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `instructor_id` int(11) DEFAULT NULL,
  `assignment_id` int(11) DEFAULT NULL,
  `coordinator_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`id`, `class_id`, `student_id`, `status`, `date`, `created_at`, `updated_at`, `instructor_id`, `assignment_id`, `coordinator_id`) VALUES
(50, 12, 1, 0, '2024-08-12', '2024-08-12 02:45:09', '2024-08-12 02:45:09', 29, 25, NULL),
(51, 12, 2, 1, '2024-08-12', '2024-08-12 02:45:09', '2024-08-12 02:45:09', 29, 25, NULL),
(52, 12, 3, 0, '2024-08-12', '2024-08-12 02:45:10', '2024-08-12 02:45:10', 29, 25, NULL),
(53, 12, 4, 0, '2024-08-12', '2024-08-12 02:45:10', '2024-08-12 02:45:10', 29, 25, NULL),
(54, 12, 5, 0, '2024-08-12', '2024-08-12 02:45:10', '2024-08-12 02:45:10', 29, 25, NULL),
(55, 12, 12, 0, '2024-08-12', '2024-08-12 02:45:10', '2024-08-12 02:45:10', 29, 25, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `batches`
--

CREATE TABLE `batches` (
  `id` int(11) NOT NULL,
  `course_name` varchar(255) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `capacity` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `batches`
--

INSERT INTO `batches` (`id`, `course_name`, `start_date`, `end_date`, `capacity`, `created_at`, `updated_at`) VALUES
(12, 'React JS Course Batch', '2024-08-11', '2024-08-31', 500, '2024-08-11 10:33:11', '2024-08-11 10:33:11'),
(13, 'Node JS Course Batch', '2024-08-11', '2024-08-31', 300, '2024-08-11 15:09:13', '2024-08-11 15:09:13'),
(14, 'PHP Course Batch', '2024-07-28', '2024-08-31', 607, '2024-08-11 15:09:36', '2024-08-11 15:10:15'),
(15, 'DevOps Batch', '2024-08-21', '2024-09-20', 200, '2024-08-11 15:10:00', '2024-08-11 15:10:00');

-- --------------------------------------------------------

--
-- Table structure for table `classes`
--

CREATE TABLE `classes` (
  `id` int(11) NOT NULL,
  `batch_id` int(11) NOT NULL,
  `class_name` varchar(255) NOT NULL,
  `start_time` datetime NOT NULL,
  `end_time` datetime NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `classes`
--

INSERT INTO `classes` (`id`, `batch_id`, `class_name`, `start_time`, `end_time`, `created_at`, `updated_at`) VALUES
(12, 12, 'React Class - 16', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2024-08-11 12:06:50', '2024-08-11 12:06:50'),
(13, 14, 'PHP Class - 2', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2024-08-11 15:10:36', '2024-08-11 15:10:47'),
(14, 12, 'React Class - 17', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2024-08-11 23:55:21', '2024-08-11 23:55:21'),
(15, 12, 'React Class 10', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2024-08-11 23:55:34', '2024-08-11 23:55:34'),
(16, 12, 'React Class 12', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2024-08-11 23:55:45', '2024-08-11 23:55:45');

-- --------------------------------------------------------

--
-- Table structure for table `class_assignments`
--

CREATE TABLE `class_assignments` (
  `id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `instructor_id` int(11) DEFAULT NULL,
  `resource_id` int(11) DEFAULT NULL,
  `coordinator_id` int(11) DEFAULT NULL,
  `assigned_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `start_time` datetime NOT NULL,
  `end_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `class_assignments`
--

INSERT INTO `class_assignments` (`id`, `class_id`, `instructor_id`, `resource_id`, `coordinator_id`, `assigned_at`, `start_time`, `end_time`) VALUES
(25, 12, 29, 3, 23, '2024-08-12 01:34:08', '2024-08-12 07:04:00', '2024-08-14 07:04:00'),
(26, 12, 29, 3, 23, '2024-08-12 01:34:59', '2024-08-14 19:04:00', '2024-08-16 07:04:00');

-- --------------------------------------------------------

--
-- Table structure for table `enrollments`
--

CREATE TABLE `enrollments` (
  `student_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `enrollments`
--

INSERT INTO `enrollments` (`student_id`, `class_id`) VALUES
(1, 12),
(2, 12),
(2, 14),
(3, 12),
(4, 12),
(5, 12),
(12, 12);

-- --------------------------------------------------------

--
-- Table structure for table `resources`
--

CREATE TABLE `resources` (
  `id` int(11) NOT NULL,
  `resource_name` varchar(255) NOT NULL,
  `type` enum('class','equipment') NOT NULL,
  `availability` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `resources`
--

INSERT INTO `resources` (`id`, `resource_name`, `type`, `availability`, `created_at`, `updated_at`) VALUES
(3, 'Room No. 13', 'class', 1, '2024-08-11 11:41:52', '2024-08-11 12:01:32'),
(4, 'Room No. 15', 'class', 1, '2024-08-11 12:01:43', '2024-08-11 12:01:43'),
(5, 'Room No. 16', 'class', 1, '2024-08-11 12:01:50', '2024-08-11 12:01:50');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `name`) VALUES
(1, 'Jaymin'),
(2, 'Jay'),
(3, 'Jaime'),
(4, 'James'),
(5, 'John'),
(6, 'Anie'),
(7, 'Anaya'),
(8, 'Ankita'),
(9, 'Akasha'),
(10, 'Amit'),
(11, 'Biren'),
(12, 'Bhavesh'),
(13, 'Bhaktesh'),
(14, 'Bhajan'),
(15, 'Chandu'),
(16, 'Chandresh'),
(17, 'Chakki'),
(18, 'Chinku'),
(19, 'Dinesh'),
(20, 'Daksha'),
(21, 'Damor');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','instructor','coordinator') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `created_at`, `updated_at`) VALUES
(17, 'Jaymin', 'Jaymin@gmail.com', '$2y$10$ZdVkmHBEri1ZEROfVGHHOeT8rX99ujcJZU6HmaxrTh9y0WO.YcmGO', 'admin', '2024-08-11 10:47:38', '2024-08-11 10:47:38'),
(19, 'Jimmy', 'Jaymsin@gmail.com', '$2y$10$C91jmMPBeW3OxZqdgMsOyuZE61n2eYQ9AmhxUKeSozyQyqklfcFOe', 'admin', '2024-08-11 10:54:31', '2024-08-11 10:58:00'),
(20, 'Kamini - Instructor', 'Kamini@gmail.com', '$2y$10$JGxM1ryXxnlSdtB6CbgJCepfyAXi1K/jS221KSAiLv9VwWaVIFIOG', 'instructor', '2024-08-11 11:59:48', '2024-08-11 11:59:48'),
(21, 'Dev - Instructor', 'Dev@gmail.com', '$2y$10$RGZlgKqbG.mDaH9KSnR83uqAyh6fKahJYe78kSAKRmZp4rNGEbC1a', 'instructor', '2024-08-11 12:00:09', '2024-08-11 15:01:30'),
(23, 'Mital - Coordinator ', 'Mital@gmail.com', '$2y$10$mvngBOTtB5xP4mguluhECuX4dsCTZHVJXRHb5Q.1WDFPW.L524nZK', 'coordinator', '2024-08-11 12:01:09', '2024-08-11 12:01:09'),
(25, 'Chandani', 'Chandani@gmail.com', '$2y$10$u0zvm//ECi8P1dBuY5bs2O8EQ4nfsbPMuFEuojPwcS1zJluZBl2QG', 'instructor', '2024-08-11 14:57:36', '2024-08-11 14:57:36'),
(26, 'Zinzhhi - Instructor ', 'Zinzhhi@gmail.com', '$2y$10$/8ja/Tc1R0fuHEEmYkcuLeCSoBwEoA6lOb7DOlZq4Zc813xRriupS', 'instructor', '2024-08-11 15:06:19', '2024-08-11 15:06:19'),
(27, 'Malhar - Instructor ', 'malhar@gmail.com', '$2y$10$KGc8AsTapwsePcOcdXnXJ.Akon.1sm6cY5r.FxHQi.dN4j/JTU..K', 'instructor', '2024-08-11 15:06:41', '2024-08-11 15:06:41'),
(28, 'mukesh - Instructor ', 'mukesh@gmail.com', '$2y$10$kkl7F8cVL1rnKfgTUGONauYHXEySqXOwLmFQVkz6XGS3528P94BUi', 'instructor', '2024-08-11 15:07:02', '2024-08-11 15:07:02'),
(29, 'anil - Instructor ', 'anil@gmail.com', '$2y$10$NOSgDAAsQO.kDX5m.Re2HO7xqkGaoFpqryiKoxOt1GEY/iWLv/DyW', 'instructor', '2024-08-11 15:07:17', '2024-08-11 15:07:17'),
(30, 'kanchan - Coordinator ', 'kanchii@gmail.com', '$2y$10$WFJJR9loy00qfQj5DGXKqO3FvBruVl90nStKB4jipheuCuw7ktvSW', 'coordinator', '2024-08-11 15:07:41', '2024-08-11 15:07:41'),
(31, 'ranjan - Coordinator ', 'ranjan@gmail.com', '$2y$10$xtAcnZTY/SwcV7rn7IzXG.1e9g.v5Pb7A2rsMUlLnZU0tkOOFUMgS', 'coordinator', '2024-08-11 15:07:54', '2024-08-11 15:07:54'),
(32, 'vimal - Coordinator ', 'vimal@gmail.com', '$2y$10$hEUn5NL4g.b9MSBsszSLfO/6btLqk60s8Vds/5uGzRwZPkBo27xWW', 'coordinator', '2024-08-11 15:08:10', '2024-08-11 15:08:10'),
(33, 'yogesh - Coordinator ', 'yogesh@gmail.com', '$2y$10$c2Qgdtmipm/sNZIW.vto4eTkFOERVCifL/S.CODx33v4sqYcWC2J2', 'coordinator', '2024-08-11 15:08:24', '2024-08-11 15:08:24'),
(34, 'param  - Coordinator ', 'param@gmail.com', '$2y$10$iMwjiw9j2b2oq047JPc7geHZkrFBCWunExswePgavetEvSrIO/JIC', 'coordinator', '2024-08-11 15:08:40', '2024-08-11 15:08:40');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `fk_class_id` (`class_id`),
  ADD KEY `fk_assignment` (`assignment_id`),
  ADD KEY `fk_coordinator_id` (`coordinator_id`),
  ADD KEY `attendance_ibfk_3` (`instructor_id`);

--
-- Indexes for table `batches`
--
ALTER TABLE `batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `classes`
--
ALTER TABLE `classes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `batch_id` (`batch_id`);

--
-- Indexes for table `class_assignments`
--
ALTER TABLE `class_assignments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `class_id` (`class_id`),
  ADD KEY `instructor_id` (`instructor_id`),
  ADD KEY `resource_id` (`resource_id`),
  ADD KEY `class_assignments_ibfk_4` (`coordinator_id`);

--
-- Indexes for table `enrollments`
--
ALTER TABLE `enrollments`
  ADD PRIMARY KEY (`student_id`,`class_id`),
  ADD KEY `class_id` (`class_id`);

--
-- Indexes for table `resources`
--
ALTER TABLE `resources`
  ADD PRIMARY KEY (`id`);

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
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `batches`
--
ALTER TABLE `batches`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `classes`
--
ALTER TABLE `classes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `class_assignments`
--
ALTER TABLE `class_assignments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `resources`
--
ALTER TABLE `resources`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attendance`
--
ALTER TABLE `attendance`
  ADD CONSTRAINT `attendance_ibfk_2` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `attendance_ibfk_3` FOREIGN KEY (`instructor_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_assignment` FOREIGN KEY (`assignment_id`) REFERENCES `class_assignments` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_class_id` FOREIGN KEY (`class_id`) REFERENCES `classes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_coordinator_id` FOREIGN KEY (`coordinator_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `classes`
--
ALTER TABLE `classes`
  ADD CONSTRAINT `classes_ibfk_1` FOREIGN KEY (`batch_id`) REFERENCES `batches` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `class_assignments`
--
ALTER TABLE `class_assignments`
  ADD CONSTRAINT `class_assignments_ibfk_1` FOREIGN KEY (`class_id`) REFERENCES `classes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `class_assignments_ibfk_2` FOREIGN KEY (`instructor_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `class_assignments_ibfk_3` FOREIGN KEY (`resource_id`) REFERENCES `resources` (`id`),
  ADD CONSTRAINT `class_assignments_ibfk_4` FOREIGN KEY (`coordinator_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `enrollments`
--
ALTER TABLE `enrollments`
  ADD CONSTRAINT `enrollments_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `enrollments_ibfk_2` FOREIGN KEY (`class_id`) REFERENCES `classes` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
