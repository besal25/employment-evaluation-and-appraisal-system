-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 05, 2023 at 05:08 AM
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
-- Database: `epes_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `appraisal`
--

CREATE TABLE `appraisal` (
  `employee_id` int(100) NOT NULL,
  `date_from` date NOT NULL,
  `date_to` date NOT NULL,
  `prediction` varchar(100) NOT NULL,
  `appraisal_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appraisal`
--

INSERT INTO `appraisal` (`employee_id`, `date_from`, `date_to`, `prediction`, `appraisal_date`) VALUES
(20, '2023-10-01', '2023-10-03', 'Good', '2023-10-01'),
(20, '2023-10-01', '2023-10-03', 'Good', '2023-10-01'),
(20, '2023-10-01', '2023-10-03', 'Good', '2023-10-01'),
(20, '2023-10-01', '2023-10-04', 'Good', '2023-10-02'),
(20, '2023-10-01', '2023-10-03', 'Good', '2023-10-02'),
(20, '2023-10-01', '2023-10-04', 'No improvement', '2023-10-02'),
(20, '2023-10-01', '2023-10-04', 'Excellent', '2023-10-02'),
(20, '2023-10-01', '2023-10-04', 'Good', '2023-10-02');

-- --------------------------------------------------------

--
-- Table structure for table `department_list`
--

CREATE TABLE `department_list` (
  `id` int(30) NOT NULL,
  `department` varchar(200) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `department_list`
--

INSERT INTO `department_list` (`id`, `department`, `description`) VALUES
(1, 'IT Department', 'Information Technology Department'),
(3, 'Cs department', 'computer science');

-- --------------------------------------------------------

--
-- Table structure for table `designation_list`
--

CREATE TABLE `designation_list` (
  `id` int(30) NOT NULL,
  `designation` varchar(200) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `designation_list`
--

INSERT INTO `designation_list` (`id`, `designation`, `description`) VALUES
(1, 'Sr. Programmer', 'Senior Programmer'),
(3, 'Project Manager', 'Project Manager'),
(4, 'QA/QC Analyst', 'Quality Assurance and Quality Control Analyst');

-- --------------------------------------------------------

--
-- Table structure for table `employee_list`
--

CREATE TABLE `employee_list` (
  `id` int(30) NOT NULL,
  `employee_id` int(100) DEFAULT NULL,
  `firstname` varchar(200) NOT NULL,
  `middlename` varchar(200) NOT NULL,
  `lastname` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` text NOT NULL,
  `department_id` int(30) NOT NULL,
  `designation_id` int(30) NOT NULL,
  `evaluator_id` int(30) NOT NULL,
  `avatar` text DEFAULT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employee_list`
--

INSERT INTO `employee_list` (`id`, `employee_id`, `firstname`, `middlename`, `lastname`, `email`, `password`, `department_id`, `designation_id`, `evaluator_id`, `avatar`, `date_created`) VALUES
(20, NULL, 'bishal', '', 'khatiwada', 'bishalkhatiwad@nistschool.edu.np', '331ebd582d369b535917a1fef122f1b3', 1, 4, 5, 'no-image-available.png', '2023-10-01 21:34:02');

-- --------------------------------------------------------

--
-- Table structure for table `evaluator_list`
--

CREATE TABLE `evaluator_list` (
  `id` int(30) NOT NULL,
  `employee_id` varchar(50) NOT NULL,
  `firstname` varchar(200) NOT NULL,
  `middlename` varchar(200) NOT NULL,
  `lastname` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` text NOT NULL,
  `avatar` text DEFAULT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `evaluator_list`
--

INSERT INTO `evaluator_list` (`id`, `employee_id`, `firstname`, `middlename`, `lastname`, `email`, `password`, `avatar`, `date_created`) VALUES
(5, '', 'prawesh', '', 'dhungana', 'prawesh@gmail.com', '62a6a2577510ffffbb84ee501d34d0f0', 'no-image-available.png', '2023-08-19 16:35:24'),
(8, '', 'amit', '', 'ghimire', 'amit@gmail.com', 'f039eb446cc0bd7c5ad12b7a0e2a1dae', 'no-image-available.png', '2023-09-27 09:50:15'),
(9, '', 'Bhupendra ', '', 'Saud', 'bhupendra.saud@yahoo.com', '67fa181a9b236095d67029c439381978', 'no-image-available.png', '2023-09-28 09:39:09');

-- --------------------------------------------------------

--
-- Table structure for table `ratings`
--

CREATE TABLE `ratings` (
  `id` int(30) NOT NULL,
  `employee_id` int(30) NOT NULL,
  `task_id` int(30) NOT NULL,
  `evaluator_id` int(30) NOT NULL,
  `efficiency` int(11) NOT NULL,
  `timeliness` int(11) NOT NULL,
  `quality` int(11) NOT NULL,
  `accuracy` int(11) NOT NULL,
  `remarks` text NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ratings`
--

INSERT INTO `ratings` (`id`, `employee_id`, `task_id`, `evaluator_id`, `efficiency`, `timeliness`, `quality`, `accuracy`, `remarks`, `date_created`) VALUES
(23, 16, 26, 7, 5, 2, 3, 5, 'ok fine next time aru pani', '2023-09-27 09:37:04'),
(26, 18, 28, 9, 5, 2, 3, 2, 'avergae', '2023-09-28 09:46:56'),
(28, 20, 30, 5, 3, 0, 3, 5, 'done', '2023-10-01 21:54:24'),
(29, 20, 31, 5, 3, 5, 4, 5, 'done', '2023-10-01 21:59:01');

-- --------------------------------------------------------

--
-- Table structure for table `system_settings`
--

CREATE TABLE `system_settings` (
  `id` int(30) NOT NULL,
  `name` text NOT NULL,
  `email` varchar(200) NOT NULL,
  `contact` varchar(20) NOT NULL,
  `address` text NOT NULL,
  `cover_img` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `system_settings`
--

INSERT INTO `system_settings` (`id`, `name`, `email`, `contact`, `address`, `cover_img`) VALUES
(1, 'Bishal', 'bkhatiwada383@gmail.com', '9828710054', 'sanothimi', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `task_list`
--

CREATE TABLE `task_list` (
  `id` int(30) NOT NULL,
  `task` varchar(200) NOT NULL,
  `description` text NOT NULL,
  `employee_id` int(30) NOT NULL,
  `due_date` date NOT NULL,
  `completed` date NOT NULL,
  `status` int(1) NOT NULL COMMENT '0=pending, 1=on-progress,3=Completed',
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `task_list`
--

INSERT INTO `task_list` (`id`, `task`, `description`, `employee_id`, `due_date`, `completed`, `status`, `date_created`) VALUES
(20, 'project 1', '							done						', 14, '2023-08-19', '0000-00-00', 2, '2023-08-19 16:47:25'),
(22, 'project 3', 'ok', 14, '2023-08-19', '0000-00-00', 0, '2023-08-19 17:24:36'),
(26, 'bhola task', 'please comple today', 16, '2023-09-27', '0000-00-00', 2, '2023-09-27 09:34:45'),
(27, 'amit sir ko kaam', 'ramro sangha gara&amp;nbsp;', 17, '2023-09-27', '0000-00-00', 2, '2023-09-27 09:52:11'),
(28, 'final defense', '&lt;div style=&quot;text-align: justify;&quot;&gt;&lt;span style=&quot;font-size: 1rem;&quot;&gt;complete on time gjsvcghssb vbbcbbcvcbgcvhchgvhdhgdbbgvddbdbbvdgggbvbv&lt;/span&gt;&lt;/div&gt;', 18, '2023-09-29', '0000-00-00', 2, '2023-09-28 09:42:15'),
(30, 'project 1', '							complete in time						', 20, '2023-10-02', '0000-00-00', 2, '2023-10-01 21:52:00'),
(31, 'project 2', 'do by today', 20, '2023-10-02', '0000-00-00', 2, '2023-10-01 21:57:27');

-- --------------------------------------------------------

--
-- Table structure for table `task_progress`
--

CREATE TABLE `task_progress` (
  `id` int(11) NOT NULL,
  `task_id` int(30) NOT NULL,
  `progress` text NOT NULL,
  `is_complete` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0=no,1=Yes',
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `task_progress`
--

INSERT INTO `task_progress` (`id`, `task_id`, `progress`, `is_complete`, `date_created`) VALUES
(26, 20, '&lt;p&gt;done&lt;/p&gt;', 1, '2023-08-19 16:54:34'),
(27, 21, '&lt;p&gt;done&lt;/p&gt;', 1, '2023-08-19 16:55:48'),
(28, 23, '&lt;p&gt;done&lt;/p&gt;', 1, '2023-08-20 23:14:14'),
(29, 24, '&lt;p&gt;i am doing bt i am having some issues&lt;/p&gt;', 0, '2023-08-24 11:11:34'),
(30, 24, '&lt;p&gt;i need some time please.&lt;/p&gt;', 0, '2023-08-24 11:11:49'),
(31, 24, '&lt;p&gt;sdone&lt;/p&gt;', 1, '2023-08-24 11:15:10'),
(32, 26, 'ok done&amp;nbsp;', 1, '2023-09-27 09:36:05'),
(33, 27, '&lt;p&gt;vayo&lt;/p&gt;', 1, '2023-09-27 09:52:36'),
(34, 25, '&lt;p&gt;ok late vayo tara gare sABAI&lt;/p&gt;', 1, '2023-09-27 21:29:42'),
(35, 28, '&lt;p&gt;completed&lt;/p&gt;', 1, '2023-09-28 09:44:01'),
(36, 29, '&lt;p&gt;done&lt;/p&gt;', 1, '2023-09-28 09:53:12'),
(37, 30, '&lt;p&gt;done&lt;/p&gt;', 1, '2023-10-01 21:53:20'),
(38, 31, '&lt;p&gt;ok done&lt;/p&gt;', 1, '2023-10-01 21:58:08');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(30) NOT NULL,
  `firstname` varchar(200) NOT NULL,
  `lastname` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` text NOT NULL,
  `avatar` text DEFAULT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `email`, `password`, `avatar`, `date_created`) VALUES
(1, 'Admin', 'Admin', 'admin@gmail.com', '0e7517141fb53f21ee439b355b5a1d0a', '1607135820_avatar.jpg', '2020-11-26 10:57:04');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appraisal`
--
ALTER TABLE `appraisal`
  ADD KEY `idx_fk_employee_id` (`employee_id`);

--
-- Indexes for table `department_list`
--
ALTER TABLE `department_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `designation_list`
--
ALTER TABLE `designation_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employee_list`
--
ALTER TABLE `employee_list`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_employee_id` (`employee_id`);

--
-- Indexes for table `evaluator_list`
--
ALTER TABLE `evaluator_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ratings`
--
ALTER TABLE `ratings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `system_settings`
--
ALTER TABLE `system_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `task_list`
--
ALTER TABLE `task_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `task_progress`
--
ALTER TABLE `task_progress`
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
-- AUTO_INCREMENT for table `department_list`
--
ALTER TABLE `department_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `designation_list`
--
ALTER TABLE `designation_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `employee_list`
--
ALTER TABLE `employee_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `evaluator_list`
--
ALTER TABLE `evaluator_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `ratings`
--
ALTER TABLE `ratings`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `system_settings`
--
ALTER TABLE `system_settings`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `task_list`
--
ALTER TABLE `task_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `task_progress`
--
ALTER TABLE `task_progress`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appraisal`
--
ALTER TABLE `appraisal`
  ADD CONSTRAINT `appraisal_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `employee_list` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_employee_id` FOREIGN KEY (`employee_id`) REFERENCES `employee_list` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
