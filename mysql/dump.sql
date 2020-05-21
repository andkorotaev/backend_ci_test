-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 21, 2020 at 08:52 PM
-- Server version: 5.7.30-0ubuntu0.18.04.1
-- PHP Version: 7.3.16-1+ubuntu18.04.1+deb.sury.org+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `test_task`
--

-- --------------------------------------------------------

--
-- Table structure for table `boosterinfo`
--

CREATE TABLE `boosterinfo` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `boosterpack_id` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `likes` int(11) NOT NULL,
  `time_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `time_updated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `boosterinfo`
--

INSERT INTO `boosterinfo` (`id`, `user_id`, `boosterpack_id`, `price`, `likes`, `time_created`, `time_updated`) VALUES
(1, 2, 2, '20.00', 13, '2020-05-21 20:48:53', '2020-05-21 20:48:53'),
(2, 2, 3, '50.00', 13, '2020-05-21 20:48:55', '2020-05-21 20:48:55'),
(3, 2, 1, '5.00', 8, '2020-05-21 20:49:35', '2020-05-21 20:49:35'),
(4, 2, 1, '5.00', 6, '2020-05-21 20:49:38', '2020-05-21 20:49:38'),
(5, 2, 1, '5.00', 7, '2020-05-21 20:50:11', '2020-05-21 20:50:11'),
(6, 2, 1, '5.00', 1, '2020-05-21 20:50:19', '2020-05-21 20:50:19');

-- --------------------------------------------------------

--
-- Table structure for table `boosterpack`
--

CREATE TABLE `boosterpack` (
  `id` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `bank` decimal(10,2) NOT NULL DEFAULT '0.00',
  `time_created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `time_updated` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `boosterpack`
--

INSERT INTO `boosterpack` (`id`, `price`, `bank`, `time_created`, `time_updated`) VALUES
(1, '5.00', '5.00', '2020-03-30 00:17:28', '2020-05-21 17:50:19'),
(2, '20.00', '29.00', '2020-03-30 00:17:28', '2020-05-21 17:48:53'),
(3, '50.00', '84.00', '2020-03-30 00:17:28', '2020-05-21 17:48:55');

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE `comment` (
  `id` int(11) NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `assign_id` int(10) UNSIGNED NOT NULL,
  `reply_id` int(11) DEFAULT NULL,
  `text` text NOT NULL,
  `time_created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `time_updated` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `comment`
--

INSERT INTO `comment` (`id`, `user_id`, `assign_id`, `reply_id`, `text`, `time_created`, `time_updated`) VALUES
(1, 1, 1, NULL, 'Ну чо ассигн проверим', '2020-03-27 21:39:44', '2020-05-21 11:17:42'),
(2, 1, 1, NULL, 'Второй коммент', '2020-03-27 21:39:55', '2020-05-20 21:15:58'),
(3, 2, 1, 1, 'Второй коммент от второго человека', '2020-03-27 21:40:22', '2020-05-21 11:17:38'),
(4, 2, 1, NULL, 'test', '2020-05-21 12:37:14', '2020-05-21 12:37:14'),
(5, 2, 1, NULL, 'test2', '2020-05-21 12:41:47', '2020-05-21 12:41:47'),
(6, 2, 1, NULL, 'test3', '2020-05-21 12:42:20', '2020-05-21 12:42:20'),
(7, 2, 1, NULL, 'sdfsdfsd', '2020-05-21 12:44:01', '2020-05-21 12:44:01'),
(8, 2, 1, 7, 'sfsf', '2020-05-21 12:51:14', '2020-05-21 12:51:14'),
(9, 2, 1, NULL, 'dfgdfg', '2020-05-21 12:51:25', '2020-05-21 12:51:25'),
(10, 2, 1, 1, 'Hi! How are you?', '2020-05-21 12:51:43', '2020-05-21 12:51:43'),
(11, 2, 2, NULL, 'First', '2020-05-21 12:53:41', '2020-05-21 12:53:41'),
(12, 2, 2, 11, 'Secont', '2020-05-21 12:53:49', '2020-05-21 12:53:49'),
(13, 2, 2, 11, 'kyky', '2020-05-21 12:53:59', '2020-05-21 12:53:59'),
(14, 2, 2, 13, 'nice work)', '2020-05-21 12:54:10', '2020-05-21 12:54:10'),
(15, 1, 1, 10, 'Fine', '2020-05-21 12:55:48', '2020-05-21 12:55:48'),
(16, 1, 1, 1, '1212121', '2020-05-21 12:56:22', '2020-05-21 12:56:22'),
(17, 2, 2, 11, '23423423', '2020-05-21 16:31:49', '2020-05-21 16:31:49');

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE `likes` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `assign_id` int(11) NOT NULL,
  `type` varchar(225) NOT NULL,
  `time_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `time_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `likes`
--

INSERT INTO `likes` (`id`, `user_id`, `assign_id`, `type`, `time_created`, `time_updated`) VALUES
(1, 2, 6, 'comment', '2020-05-21 17:49:22', '2020-05-21 17:49:22'),
(2, 2, 5, 'comment', '2020-05-21 17:49:23', '2020-05-21 17:49:23'),
(3, 2, 5, 'comment', '2020-05-21 17:49:23', '2020-05-21 17:49:23'),
(4, 2, 5, 'comment', '2020-05-21 17:49:23', '2020-05-21 17:49:23'),
(5, 2, 1, 'post', '2020-05-21 17:49:26', '2020-05-21 17:49:26'),
(6, 2, 1, 'post', '2020-05-21 17:49:27', '2020-05-21 17:49:27'),
(7, 2, 1, 'post', '2020-05-21 17:49:27', '2020-05-21 17:49:27'),
(8, 2, 1, 'comment', '2020-05-21 17:49:28', '2020-05-21 17:49:28');

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

CREATE TABLE `post` (
  `id` int(11) NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `text` text NOT NULL,
  `img` varchar(1024) DEFAULT NULL,
  `time_created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `time_updated` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `post`
--

INSERT INTO `post` (`id`, `user_id`, `text`, `img`, `time_created`, `time_updated`) VALUES
(1, 1, 'Тестовый постик 1', '/images/posts/1.png', '2018-08-30 13:31:14', '2020-05-20 21:15:58'),
(2, 1, 'Печальный пост', '/images/posts/2.png', '2018-10-11 01:33:27', '2020-05-20 21:15:58');

-- --------------------------------------------------------

--
-- Table structure for table `transaction`
--

CREATE TABLE `transaction` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `type` varchar(255) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `time_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `time_updated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `transaction`
--

INSERT INTO `transaction` (`id`, `user_id`, `type`, `amount`, `time_created`, `time_updated`) VALUES
(1, 2, 'add_money', '100.00', '2020-05-21 20:48:48', '2020-05-21 20:48:48'),
(2, 2, 'buy_boosterpack', '20.00', '2020-05-21 20:48:53', '2020-05-21 20:48:53'),
(3, 2, 'buy_boosterpack', '50.00', '2020-05-21 20:48:55', '2020-05-21 20:48:55'),
(4, 2, 'buy_boosterpack', '5.00', '2020-05-21 20:49:35', '2020-05-21 20:49:35'),
(5, 2, 'buy_boosterpack', '5.00', '2020-05-21 20:49:38', '2020-05-21 20:49:38'),
(6, 2, 'buy_boosterpack', '5.00', '2020-05-21 20:50:11', '2020-05-21 20:50:11'),
(7, 2, 'buy_boosterpack', '5.00', '2020-05-21 20:50:19', '2020-05-21 20:50:19'),
(8, 2, 'add_money', '50.00', '2020-05-21 20:50:37', '2020-05-21 20:50:37');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) UNSIGNED NOT NULL,
  `email` varchar(60) DEFAULT NULL,
  `password` varchar(32) DEFAULT NULL,
  `personaname` varchar(50) NOT NULL DEFAULT '',
  `avatarfull` varchar(150) NOT NULL DEFAULT '',
  `rights` tinyint(4) NOT NULL DEFAULT '0',
  `wallet_balance` decimal(10,2) NOT NULL DEFAULT '0.00',
  `wallet_total_refilled` decimal(10,2) NOT NULL DEFAULT '0.00',
  `wallet_total_withdrawn` decimal(10,2) NOT NULL DEFAULT '0.00',
  `likes` int(11) NOT NULL DEFAULT '0',
  `time_created` datetime NOT NULL,
  `time_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `email`, `password`, `personaname`, `avatarfull`, `rights`, `wallet_balance`, `wallet_total_refilled`, `wallet_total_withdrawn`, `likes`, `time_created`, `time_updated`) VALUES
(1, 'admin@niceadminmail.pl', '123456', 'AdminProGod', 'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/96/967871835afdb29f131325125d4395d55386c07a_full.jpg', 0, '0.00', '0.00', '0.00', 0, '2019-07-26 01:53:54', '2020-05-20 22:48:32'),
(2, 'simpleuser@niceadminmail.pl', 'test', 'simpleuser', 'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/86/86a0c845038332896455a566a1f805660a13609b_full.jpg', 0, '60.00', '150.00', '90.00', 40, '2019-07-26 01:53:54', '2020-05-21 17:50:37');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `boosterinfo`
--
ALTER TABLE `boosterinfo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `boosterpack`
--
ALTER TABLE `boosterpack`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `transaction`
--
ALTER TABLE `transaction`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `time_created` (`time_created`),
  ADD KEY `time_updated` (`time_updated`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `boosterinfo`
--
ALTER TABLE `boosterinfo`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `boosterpack`
--
ALTER TABLE `boosterpack`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `comment`
--
ALTER TABLE `comment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `likes`
--
ALTER TABLE `likes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `post`
--
ALTER TABLE `post`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `transaction`
--
ALTER TABLE `transaction`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
