-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 28, 2019 at 09:04 AM
-- Server version: 10.1.39-MariaDB
-- PHP Version: 7.3.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `keabook-security`
--

-- --------------------------------------------------------

--
-- Table structure for table `ips`
--

CREATE TABLE `ips` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ip` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `email` varchar(20) NOT NULL,
  `attempts` tinyint(1) NOT NULL,
  `active` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ips`
--

INSERT INTO `ips` (`id`, `ip`, `email`, `attempts`, `active`) VALUES
(1, '::1', 'a@a.com', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `message` varchar(300) NOT NULL,
  `image` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `active` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `message`, `image`, `date`, `user_id`, `active`) VALUES
(1, 'Hellow worrrrrrrld', '', '2019-08-23 14:00:26', 1, 1),
(8, 'What up', '', '2019-08-15 09:40:13', 2, 1),
(10, 'Hi, it\'s me!', '', '2019-08-13 08:13:41', 5, 1),
(11, 'Such cool app', '', '2019-08-13 08:13:11', 2, 1),
(12, 'Yup', '', '2019-08-15 11:39:15', 1, 1),
(13, 'Hi, I\'m here to help you', '', '2019-08-15 07:41:13', 3, 1),
(14, 'I\'m admin', '', '2019-08-15 09:40:04', 3, 1),
(27, 'This is what I found', '5d541713c53ef.png', '2019-08-14 14:15:29', 1, 1),
(29, 'I\'m back!', '', '2019-08-15 09:22:27', 1, 1),
(30, '&lt;script&gt;alert()&lt;/script&gt;', '', '2019-08-21 07:50:43', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(20) NOT NULL,
  `last_name` varchar(20) NOT NULL,
  `email` varchar(20) NOT NULL,
  `password` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `salt` mediumint(6) UNSIGNED NOT NULL,
  `activation_key` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `active` tinyint(1) NOT NULL,
  `role` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `last_name`, `email`, `password`, `salt`, `activation_key`, `active`, `role`) VALUES
(1, 'aa', 'bb', 'a@a.com', '$2y$12$eyni.iiSgHNZkN.1j8EPOO9bwPoCozzszaSAVxv35FyjTZR3zdvwi', 142760, '$2y$10$xXQxyHLm47n4.h2sb/dlyOgksIpLFMvt3Es5Q8Tm8D0dsieVWo9P6', 1, 0),
(2, 'ww', 'ee', 'w@w.com', '$2y$12$S1U3ermxFAuTCM3MgsH3q.MR649h6qDlA2ULlEFLg5/sT3/40JF/S', 680158, '$2y$10$nUgQfzVcCSBChFt8P55a8uV.gQIPYjNm26zaN5Od9/UQbzCXC8dU6', 1, 0),
(3, 'admin', 'aa', 'admin@a.com', '$2y$12$gJ68Bc2v0IgxPfYIV.idH.pRMWRnqx5nQEhzXa0gjd/FO6iQpNV/O', 896657, '$2y$10$IPwVIboYglvNp9r57ArvUO0/Q2rcd3AqrPMCNXwZ66uOQRnp3sWIi', 1, 1),
(5, 'aa', 'bb', 'b@a.com', '$2y$12$oUabM0Khxd3Lc/JUbRKqI.wjLmeYu2GadLX4kJE.qEL4pT14ZbeYa', 731012, '$2y$10$q210CIHsNOsP9onMuFCFpOb7/giAdC0XW6nbUNHOUCNPESb75UlBK', 1, 0),
(6, 'aa', 'bb', 'q@q.com', '$2y$12$2jKLBXOj0OHqZBJeGlIuC.wbObbeno5lfa7xAr/e2zfiDw8ngxIue', 920764, '$2y$10$DR5eMGIIM3D3Up88JPCVWu0R4LXzwv6nPJQbGttU4KS49KxIq3LIu', 0, 0),
(7, 'aa', 'bb', '4@4.com', '$2y$12$LCUTZ.WhJn0oUUSUPhmf8.EMneCzkzd8HmWpleoM3sE23Byal7Sqe', 156284, '$2y$10$llRtsa4yJmPMobbH55lWsOfX55evX066mmguCuKvAVJlE/g.cEwOC', 1, 0),
(8, 'aa', 'bb', 'z@a.com', '$2y$12$dz1QshKETPaaAndQGN2ks.e.hN5tRAjS3pmI/ZDiNzzrajnY0h5c6', 485424, '$2y$10$qjAz.KZLi2THlRLxg.l6bu/fgiH7ETPeCoDZhwnQJBwRyYN05zOGe', 0, 0),
(10, 'aa', 'bb', 'z@z.com', '$2y$12$5ooBJ.t0WHceP4j9m.U7TulFjuCM/Cs97tKg1ChiJKlNi0Pfz2tQ6', 783054, '$2y$10$WgEmukJMWLxmEi9Ri.xAtexpAjwAgnuN/XpEAbuUtX9Rs9i5bchB6', 1, 0),
(11, 'aa', 'bb', 'pr@a.com', '$2y$12$jLnIjYNmn8ejXgzNTShgm.fKjosjYQ2wl1TI5rmnehA0rDwv3EdXm', 985983, '$2y$10$UHYImQ2YbYwPj6tZtP8cHuxt7mKMR8geL2h7668mIrjJJenFFsAQa', 0, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ips`
--
ALTER TABLE `ips`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `ip` (`ip`),
  ADD KEY `email` (`email`),
  ADD KEY `id_2` (`id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD UNIQUE KEY `email_2` (`email`),
  ADD KEY `name` (`name`),
  ADD KEY `last_name` (`last_name`),
  ADD KEY `email` (`email`),
  ADD KEY `password` (`password`),
  ADD KEY `active` (`active`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ips`
--
ALTER TABLE `ips`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
