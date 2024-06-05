-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 20, 2024 at 09:20 PM
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
-- Database: `legends`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `email`, `password`) VALUES
(1, 'user1@example.com', 'password1'),
(2, 'user2@example.com', 'password2'),
(3, 'svbala1920@gmail.com', 'Loveyou*2000');

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `id` int(11) NOT NULL,
  `staff_name` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL,
  `student_name` varchar(255) NOT NULL,
  `attendance` varchar(50) NOT NULL,
  `date` date NOT NULL,
  `session` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`id`, `staff_name`, `role`, `student_name`, `attendance`, `date`, `session`) VALUES
(1, 'Santro', 'training', 'Deepak', 'Present', '2024-05-20', 'Afternoon'),
(2, 'Santro', 'internship', 'Marudha', 'Present', '2024-05-20', 'Afternoon'),
(3, 'Santro', 'internship', 'Marudha', 'Present', '2024-05-20', 'Afternoon'),
(4, 'Santro', 'training', 'Deepak', 'Absent', '2024-05-20', 'Afternoon'),
(5, 'Santro', 'training', 'Deepak', 'Absent', '2024-05-20', 'Afternoon'),
(6, 'Santro', 'internship', 'Marudha', 'Absent', '2024-05-09', 'Morning'),
(7, 'Santro', 'internship', 'Marudha', 'Present', '2024-05-18', 'Afternoon'),
(8, 'Santro', 'internship', 'Marudha', 'Present', '2024-05-18', 'Afternoon'),
(9, 'Santro', 'internship', 'Marudha', 'Present', '2024-05-18', 'Afternoon'),
(10, 'Santro', 'internship', 'Marudha', 'Present', '2024-05-18', 'Afternoon'),
(11, 'Santro', 'internship', 'Marudha', 'Present', '2024-05-14', 'Afternoon'),
(12, 'Santro', 'internship', 'Marudha', 'Present', '2024-05-14', 'Morning'),
(13, 'Santro', 'internship', '0', 'Absent', '2024-05-14', 'Morning'),
(14, 'Santro', 'internship', '0', 'Absent', '2024-05-14', 'Morning'),
(15, 'Santro', 'internship', '0', 'Absent', '2024-05-14', 'Morning'),
(16, 'Santro', 'internship', '0', 'Absent', '2024-05-14', 'Morning'),
(17, 'Santro', 'internship', '0', 'Absent', '2024-05-14', 'Morning'),
(18, 'Santro', 'internship', '0', 'Absent', '2024-05-14', 'Morning'),
(19, 'Santro', 'internship', '0', 'Absent', '2024-05-14', 'Morning'),
(20, 'Santro', 'internship', '0', 'Absent', '2024-05-14', 'Morning'),
(21, 'Santro', 'internship', '0', 'Absent', '2024-05-14', 'Morning'),
(22, 'Santro', 'internship', '0', 'Absent', '2024-05-14', 'Morning'),
(23, 'Santro', 'internship', '0', 'Absent', '2024-05-14', 'Morning'),
(24, 'Santro', 'internship', '0', 'Absent', '2024-05-14', 'Morning'),
(25, 'Santro', 'internship', '0', 'Absent', '2024-05-14', 'Morning'),
(26, 'Santro', 'internship', '0', 'Absent', '2024-05-04', 'Morning'),
(27, 'Santro', 'internship', '0', 'Absent', '2024-05-04', 'Morning'),
(28, 'Santro', 'internship', '0', 'Absent', '2024-05-03', 'Afternoon'),
(29, 'Santro', 'internship', '0', 'Absent', '2024-05-03', 'Afternoon'),
(30, 'Santro', 'internship', '0', 'Absent', '2024-05-10', 'Evening'),
(31, 'Mubarak', 'training', '0', 'Absent', '2024-05-20', 'Evening'),
(32, 'Mubarak', 'training', '0', 'Absent', '2024-05-20', 'Evening'),
(33, 'Mubarak', 'internship', '0', 'Absent', '2024-05-21', 'Evening'),
(34, 'Mubarak', 'internship', '0', 'Absent', '2024-05-21', 'Evening'),
(35, 'Mubarak', 'training', '0', 'Absent', '2024-05-14', 'Afternoon'),
(36, 'Mubarak', 'training', '0', 'Absent', '2024-05-14', 'Afternoon'),
(37, 'Mubarak', 'training', '0', 'Absent', '2024-05-14', 'Afternoon'),
(38, 'Mubarak', 'training', '0', 'Absent', '2024-05-14', 'Afternoon'),
(39, 'Mubarak', 'training', '0', 'Absent', '2024-05-14', 'Afternoon'),
(40, 'Santro', 'internship', 'Marudha', 'Present', '2024-05-21', 'Morning'),
(41, 'Santro', 'internship', 'Marudha', 'Present', '2024-05-05', 'Evening'),
(42, 'Mubarak', 'internship', 'Marudha', 'Present', '2024-05-10', 'Morning'),
(43, 'Mubarak', 'internship', 'Marudha', 'Present', '2024-05-14', 'Morning'),
(44, 'Mubarak', 'internship', 'Ragul', 'Present', '2024-05-14', 'Morning'),
(45, 'Mubarak', 'internship', 'Aravind', 'Present', '2024-05-14', 'Morning'),
(46, 'Santro', 'training', 'bala', 'Present', '2024-05-17', 'Evening'),
(47, 'Santro', 'training', 'Shanmu', 'Present', '2024-05-17', 'Evening'),
(48, 'Mubarak', 'internship', 'Ragul', 'Present', '2024-05-31', 'Afternoon'),
(49, 'Mubarak', 'internship', 'Aravind', 'Present', '2024-05-31', 'Afternoon'),
(50, 'Balamurugan', 'internship', 'Prem', 'Present', '2024-05-10', 'Afternoon'),
(51, 'Balamurugan', 'internship', 'Ragul', 'Present', '2024-05-10', 'Afternoon');

-- --------------------------------------------------------

--
-- Table structure for table `dailyactivity`
--

CREATE TABLE `dailyactivity` (
  `id` int(11) NOT NULL,
  `activity` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `login_user` varchar(100) NOT NULL,
  `user_role` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dailyactivity`
--

INSERT INTO `dailyactivity` (`id`, `activity`, `date`, `login_user`, `user_role`) VALUES
(1, 'nothing', '2024-05-19', '', NULL),
(2, 'hi', '2024-05-19', '', NULL),
(3, 'sleeping', '2024-05-19', '', NULL),
(4, 'coding', '2024-05-19', '', NULL),
(5, 'weak', '2024-05-19', 'santro@gmail.com', NULL),
(6, 'Boooooring', '2024-05-19', 'Santro', 'staff'),
(7, 'died', '2024-05-19', 'Marudha', 'student'),
(8, 'Mern Developed', '2024-05-20', 'Santro', 'staff');

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

CREATE TABLE `notification` (
  `id` int(11) NOT NULL,
  `notification` text NOT NULL,
  `to_role` varchar(50) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notification`
--

INSERT INTO `notification` (`id`, `notification`, `to_role`, `created_at`) VALUES
(1, 'Tomorrow is holiday', 'staff and student', '2024-05-19 20:26:52'),
(2, 'Tomorrow all of you Compulsory come', 'staff', '2024-05-19 20:28:55'),
(3, 'today is the last day to submit the assignment', 'student', '2024-05-19 20:29:56'),
(4, 'Today is the last day', 'student', '2024-05-20 08:06:21');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `content` text DEFAULT NULL,
  `role` varchar(50) NOT NULL DEFAULT 'all'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `project_id` int(11) NOT NULL,
  `project_name` varchar(100) NOT NULL,
  `project_tl` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`project_id`, `project_name`, `project_tl`) VALUES
(1, 'Mern', 1),
(3, 'UI/UX', 4),
(4, 'PHP', 3),
(5, 'Hotel Table Booking Management System', 5);

-- --------------------------------------------------------

--
-- Table structure for table `queries`
--

CREATE TABLE `queries` (
  `id` int(11) NOT NULL,
  `query` text DEFAULT NULL,
  `date` date DEFAULT NULL,
  `login_user` varchar(255) DEFAULT NULL,
  `user_role` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `queries`
--

INSERT INTO `queries` (`id`, `query`, `date`, `login_user`, `user_role`) VALUES
(1, 'internet not working', '2024-05-19', 'Santro', 'staff'),
(2, 'sleeeeping', '2024-05-19', 'Marudha', 'student');

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`id`, `name`, `email`, `role`) VALUES
(1, 'Santhosh', 'santro@gmail.com', 'Project'),
(3, 'Mubarak', 'mubarak@gmail.com', 'HR'),
(4, 'Balamurugan', 'svbala@gmail.com', 'Managing Director'),
(5, 'Ramkumar', 'ram@gmail.com', 'Project Manager');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `role` enum('training','internship') NOT NULL,
  `college_name` varchar(255) DEFAULT NULL,
  `project_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `name`, `email`, `role`, `college_name`, `project_name`) VALUES
(3, 'Keerthi', 'keerthi@gmail.com', 'training', '', 'frontend'),
(4, 'Pandiyan', 'pandiyan@gmail.com', 'training', '', 'web'),
(5, 'Bala', 'bala@gmail.com', 'training', '', 'model'),
(6, 'Bhuvanesh', 'bhuvanesh@gmail.com', 'training', '', 'model'),
(7, 'Yogi', 'yogi@gmail.com', 'training', '', 'page'),
(8, 'Kiruba', 'kiruba@gmail.com', 'training', '', 'MERN'),
(9, 'Shanmu', 'Shanmu@gmail.com', 'training', '', 'MERN'),
(10, 'Ragul', 'ragul@gmail.com', 'internship', 'PU', 'UI/UX'),
(12, 'Naren', 'naren@gmail.com', 'training', '', 'MERN'),
(13, 'Prem', 'prem@gmail.com', 'internship', '', 'UI/UX'),
(14, 'Karthick', 'karthick@gmail.com', 'internship', 'Pondicherry University', 'PHP');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','staff','student') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `role`) VALUES
(1, 'admin@gmail.com', 'admin', 'admin'),
(2, 'staff@gmail.com', 'staff', 'staff'),
(3, 'student@gmail.com', 'student', 'student');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dailyactivity`
--
ALTER TABLE `dailyactivity`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`project_id`),
  ADD KEY `project_tl` (`project_tl`);

--
-- Indexes for table `queries`
--
ALTER TABLE `queries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
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
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `dailyactivity`
--
ALTER TABLE `dailyactivity`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `notification`
--
ALTER TABLE `notification`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `project_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `queries`
--
ALTER TABLE `queries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `projects`
--
ALTER TABLE `projects`
  ADD CONSTRAINT `projects_ibfk_1` FOREIGN KEY (`project_tl`) REFERENCES `staff` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
