-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 19, 2024 at 09:24 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `journal`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_article`
--

CREATE TABLE `admin_article` (
  `id` varchar(50) NOT NULL,
  `category` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `abstract` text NOT NULL,
  `file_upload` varchar(255) DEFAULT NULL,
  `keywords` varchar(255) DEFAULT NULL,
  `cover_upload` varchar(255) DEFAULT NULL,
  `author_name` varchar(255) NOT NULL,
  `author_email` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_article`
--

INSERT INTO `admin_article` (`id`, `category`, `title`, `abstract`, `file_upload`, `keywords`, `cover_upload`, `author_name`, `author_email`, `created_at`) VALUES
('adm_1', 'we', 'we', 'we', '../../uploads/document/67593820926af_Abstract (1).pdf', 'we', NULL, 'we', 'we', '2024-12-11 06:58:40'),
('adm_4', 'a', 'a', 'a', 'C:/xampp/htdocs/final/uploads/document/67592ecfb1663_Abstract (1).pdf', 'a', NULL, 'a', 'a', '2024-12-11 06:18:55'),
('adm_5', 'a', 'a', 'a', 'C:/xampp/htdocs/final/uploads/document/Abstract (1).pdf', 'a', '../uploads/cover/675945597c103_White and Green Simple Business Report Cover Page A4 Document.png', 'a', 'a', '2024-12-11 07:55:05');

-- --------------------------------------------------------

--
-- Table structure for table `admin_articles`
--

CREATE TABLE `admin_articles` (
  `id` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `abstract` text NOT NULL,
  `file_upload` varchar(255) NOT NULL,
  `keywords` varchar(255) NOT NULL,
  `cover_upload` varchar(255) NOT NULL,
  `author_name` varchar(255) NOT NULL,
  `volume` varchar(255) DEFAULT NULL,
  `issue_number` varchar(255) DEFAULT NULL,
  `doi` varchar(255) DEFAULT NULL,
  `is_published` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `published_at` timestamp NULL DEFAULT NULL,
  `unpublished_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_articles`
--

INSERT INTO `admin_articles` (`id`, `category`, `title`, `abstract`, `file_upload`, `keywords`, `cover_upload`, `author_name`, `volume`, `issue_number`, `doi`, `is_published`, `created_at`, `published_at`, `unpublished_at`) VALUES
('67633da34ccce', 'Mathematics', 'aa', 'a', 'C:/xampp/htdocs/final/uploads/document/Literature-Reviews (1) (1) (3).pdf', 'a', 'C:/xampp/htdocs/final/uploads/cover/b920a4ae0571005ecf10518762fd01d9.png', 'a', 'a', 'a', 'a', 1, '2024-12-18 21:24:51', '2024-12-18 21:24:55', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `announcements`
--

CREATE TABLE `announcements` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `announcements`
--

INSERT INTO `announcements` (`id`, `title`, `content`, `created_at`) VALUES
(5, 'ganda', 'nikki', '2024-11-28 09:07:44'),
(22, 'as', 'as', '2024-12-18 14:49:58'),
(23, 'new announcement', 'mew', '2024-12-18 21:22:07');

-- --------------------------------------------------------

--
-- Table structure for table `article`
--

CREATE TABLE `article` (
  `article_id` varchar(20) NOT NULL,
  `title` varchar(255) NOT NULL,
  `category` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `author` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `articles`
--

CREATE TABLE `articles` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `authors`
--

CREATE TABLE `authors` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `affiliation` varchar(50) NOT NULL,
  `verification_code` varchar(6) DEFAULT NULL,
  `verified` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `authors`
--

INSERT INTO `authors` (`id`, `username`, `last_name`, `first_name`, `email`, `password`, `affiliation`, `verification_code`, `verified`) VALUES
(70, 'Nikki', 'Manuel', 'Nikki', 'nikkimanuel263@gmail.com', '$2y$10$f.b.BH4h3FzYz9VBDlcgaeJ0fLaPtIkgqUVJbDcY8CfjOkzTFUe2y', 'author', NULL, 1),
(71, 'admin', 'Manuel', 'Nikki', 'iphonesnap.01@gmail.com', '$2y$10$HFdRIL7oH/oOVbn624ohGO8M.vgrvtFQ1PT2r.CizVGIxQSn6x35.', 'author', '918893', 0),
(72, 'a', 'a', 'aa', 'nikkiellamanuel.2022@gmail.com', '$2y$10$Jobrj4CCssGqozU3.NA7quPW9PN/yF0HbBsKU20fMofAGimBtFlIS', 'author', '843157', 0),
(74, 'daniel', 'Bantog', 'Daniel', 'bantog.daniel@colm.edu.ph', '$2y$10$pCQd.PVf43EEVPqjU8pbBOksIwy8FAJ72T9HZhU7T3Ha1650KsRzq', 'author', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `author_articles`
--

CREATE TABLE `author_articles` (
  `id` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `abstract` text DEFAULT NULL,
  `file_upload` varchar(255) DEFAULT NULL,
  `keywords` varchar(255) DEFAULT NULL,
  `cover_upload` varchar(255) DEFAULT NULL,
  `author_name` varchar(255) DEFAULT NULL,
  `volume` varchar(255) DEFAULT NULL,
  `issue_number` varchar(255) DEFAULT NULL,
  `doi` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_id` int(11) DEFAULT NULL,
  `reviewed` tinyint(1) DEFAULT 0,
  `accepted` tinyint(4) DEFAULT NULL,
  `is_published` tinyint(1) NOT NULL DEFAULT 0,
  `unpublished_at` timestamp NULL DEFAULT NULL,
  `published_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `author_articles`
--

INSERT INTO `author_articles` (`id`, `category`, `title`, `abstract`, `file_upload`, `keywords`, `cover_upload`, `author_name`, `volume`, `issue_number`, `doi`, `created_at`, `user_id`, `reviewed`, `accepted`, `is_published`, `unpublished_at`, `published_at`) VALUES
('67633b9b23966', 'Mathematics', 'new title', 'djksjd', 'C:/xampp/htdocs/final/uploads/document/Literature-Reviews (1) (1) (3).pdf', 'sdds', NULL, 'sds', 'sss', 'sd', 'sd', '2024-12-18 21:16:11', 74, NULL, 1, 1, NULL, '2024-12-18 21:18:56'),
('67633cdb8b371', 'Engineering', 'jshdjs', 'sjdhskj', 'C:/xampp/htdocs/final/uploads/document/Literature-Reviews (1) (1) (3) (2).pdf', 'ww', 'C:/xampp/htdocs/final/uploads/cover/DSC00967.JPG', 'kjhdkjsa', 'kjdk', 'ksjd', 'sd', '2024-12-18 21:21:31', 74, 0, NULL, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(9, 'Engineering'),
(10, 'Mathematics'),
(11, 'Biology'),
(12, 'Technology'),
(13, 'Physics');

-- --------------------------------------------------------

--
-- Table structure for table `editor_reviewer_applications`
--

CREATE TABLE `editor_reviewer_applications` (
  `id` int(11) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `affiliation` enum('editor','reviewer') NOT NULL,
  `email` varchar(255) NOT NULL,
  `resume_path` varchar(255) NOT NULL,
  `date_submitted` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('pending','accepted','rejected') DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `editor_reviewer_applications`
--

INSERT INTO `editor_reviewer_applications` (`id`, `last_name`, `first_name`, `username`, `affiliation`, `email`, `resume_path`, `date_submitted`, `status`) VALUES
(1, 'a', 'a', 'a', 'editor', 'a@s', 'uploads/resumes/674599eaa6715-online_ordering_user_diagram.pdf', '2024-11-26 09:50:34', 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `readers`
--

CREATE TABLE `readers` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `affiliation` varchar(50) NOT NULL,
  `verification_code` int(6) DEFAULT NULL,
  `verified` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `readers`
--

INSERT INTO `readers` (`id`, `username`, `last_name`, `first_name`, `email`, `password`, `affiliation`, `verification_code`, `verified`) VALUES
(1, 'ubeng', 'Simbulan', 'Christben', 'christbensimbulan021@gmail.com', '$2y$10$bzlSbu5rxrdZZvgP37z0G.CAjU44EpA2l.jw2kjpuLWA2Hz/K6aYK', 'reader', 162959, 0),
(3, 'nikkiella', 'Manuel', 'Nikki', 'nikkimanuel263@gmail.com', '$2y$10$if8F557TFHsSYhyCP1b62O.gQBoCIEcNVJ5T24yuGgSGXFU7Vw.KW', 'reader', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `session_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `session_token` varchar(255) NOT NULL,
  `login_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `logout_time` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`session_id`, `user_id`, `session_token`, `login_time`, `logout_time`) VALUES
(62, 70, 'd97fbfab86f8aad2d4ebc45c40361afb', '2024-12-18 13:24:04', NULL),
(63, 70, '28d1b34c6688f77c2fb434062b90264f', '2024-12-18 14:39:17', NULL),
(64, 70, 'b9d6c16932c1e9dbc7c27102a242f51d', '2024-12-18 15:15:44', NULL),
(65, 70, 'bfbffcd6e4c431cad79b125c49450de4', '2024-12-18 15:19:16', NULL),
(66, 70, '239c8d85668bdf63bd207d5d3219fd9a', '2024-12-18 15:47:38', NULL),
(67, 70, 'f8e459948e0378d7803cfb6d8ac677e4', '2024-12-18 16:17:02', NULL),
(68, 74, '783bffe2919a4598919a6874ddfe4015', '2024-12-18 21:15:05', NULL),
(69, 74, '5a5363edd8070e4e733359148eaae5ac', '2024-12-18 21:19:49', NULL),
(70, 74, '59e289fb400204e256787774fbb7e235', '2024-12-18 21:20:44', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_article`
--
ALTER TABLE `admin_article`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_articles`
--
ALTER TABLE `admin_articles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `announcements`
--
ALTER TABLE `announcements`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `article`
--
ALTER TABLE `article`
  ADD PRIMARY KEY (`article_id`);

--
-- Indexes for table `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `authors`
--
ALTER TABLE `authors`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `author_articles`
--
ALTER TABLE `author_articles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_id` (`user_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `editor_reviewer_applications`
--
ALTER TABLE `editor_reviewer_applications`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `readers`
--
ALTER TABLE `readers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`session_id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `announcements`
--
ALTER TABLE `announcements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `articles`
--
ALTER TABLE `articles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `authors`
--
ALTER TABLE `authors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `editor_reviewer_applications`
--
ALTER TABLE `editor_reviewer_applications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `readers`
--
ALTER TABLE `readers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `sessions`
--
ALTER TABLE `sessions`
  MODIFY `session_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `articles`
--
ALTER TABLE `articles`
  ADD CONSTRAINT `articles_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `authors` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `author_articles`
--
ALTER TABLE `author_articles`
  ADD CONSTRAINT `fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `authors` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sessions`
--
ALTER TABLE `sessions`
  ADD CONSTRAINT `sessions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `authors` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
