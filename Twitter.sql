-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 01, 2016 at 05:21 PM
-- Server version: 5.5.50-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `Twitter`
--

-- --------------------------------------------------------

--
-- Table structure for table `Comment`
--

CREATE TABLE IF NOT EXISTS `Comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_usera` int(11) NOT NULL,
  `id_postu` int(11) NOT NULL,
  `Creation_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `text` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_usera` (`id_usera`),
  KEY `id_postu` (`id_postu`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=22 ;

--
-- Dumping data for table `Comment`
--

INSERT INTO `Comment` (`id`, `id_usera`, `id_postu`, `Creation_date`, `text`) VALUES
(3, 2, 2, '0000-00-00 00:00:00', 'tekst'),
(7, 3, 16, '2016-10-30 08:06:25', 'komentarz55'),
(8, 3, 16, '2016-10-30 08:06:36', 'komentarz'),
(9, 3, 16, '2016-10-30 08:09:02', 'komentarz55'),
(10, 3, 16, '2016-10-30 08:09:40', 'koment'),
(11, 3, 17, '2016-10-30 12:00:50', 'komentarz555'),
(12, 3, 17, '2016-10-30 12:02:16', 'komentarz555'),
(13, 3, 17, '2016-10-30 12:05:19', 'komentarz test'),
(14, 3, 17, '2016-10-30 12:06:02', 'komentarz test'),
(15, 3, 17, '2016-10-30 12:06:19', 'komentarz test'),
(16, 3, 17, '2016-10-30 12:08:24', 'komentarz test'),
(17, 3, 17, '2016-10-30 12:09:21', 'komentarz test'),
(18, 3, 17, '2016-10-30 12:10:37', 'komentarz test'),
(19, 3, 25, '2016-10-31 19:04:34', 'test77'),
(20, 3, 25, '2016-10-31 19:05:49', 'test55'),
(21, 3, 25, '2016-10-31 19:55:33', 'komentarz77');

-- --------------------------------------------------------

--
-- Table structure for table `Message`
--

CREATE TABLE IF NOT EXISTS `Message` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_sender` int(11) NOT NULL,
  `id_receiver` int(11) NOT NULL,
  `creation_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `text` varchar(255) DEFAULT NULL,
  `unread` tinyint(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_sender` (`id_sender`),
  KEY `id_receiver` (`id_receiver`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `Message`
--

INSERT INTO `Message` (`id`, `id_sender`, `id_receiver`, `creation_date`, `text`, `unread`) VALUES
(1, 3, 1, '2016-10-31 15:46:09', 'test', 0),
(2, 3, 2, '2016-10-31 15:53:39', 'test5', 0),
(3, 2, 1, '2016-10-31 15:54:17', 'test6', 0),
(4, 3, 1, '2016-10-31 18:02:01', 'test6', 0);

-- --------------------------------------------------------

--
-- Table structure for table `Tweet`
--

CREATE TABLE IF NOT EXISTS `Tweet` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) NOT NULL,
  `text` varchar(140) DEFAULT NULL,
  `creationDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=26 ;

--
-- Dumping data for table `Tweet`
--

INSERT INTO `Tweet` (`id`, `userId`, `text`, `creationDate`) VALUES
(1, 2, 'post', '2016-10-28 22:00:00'),
(2, 2, 'post3', '2016-10-28 22:00:00'),
(3, 2, 'post5', '2016-10-28 22:00:00'),
(10, 100, 'test99', '2016-10-29 11:50:24'),
(11, 2, 'post6', '2016-10-29 11:50:57'),
(12, 2, 'tweet test99', '2016-10-29 11:52:41'),
(13, 2, 'post00', '2016-10-29 11:56:41'),
(14, 2, 'nowy post', '2016-10-29 18:14:29'),
(15, 2, 'post22', '2016-10-29 18:16:04'),
(16, 3, 'mÃ³j post', '2016-10-29 18:17:48'),
(17, 3, 'post55', '2016-10-29 18:25:21'),
(18, 3, 'post65', '2016-10-29 18:26:39'),
(19, 3, 'post nowy', '2016-10-29 19:10:57'),
(20, 1, 'post33', '2016-10-30 07:30:14'),
(21, 2, 'post77', '2016-10-30 07:36:22'),
(22, 3, 'post5555', '2016-10-30 07:45:20'),
(23, 3, 'post5666', '2016-10-30 12:00:37'),
(24, 2, 'test6666', '2016-10-30 12:52:05'),
(25, 3, 'postyyy', '2016-10-31 11:13:26');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) DEFAULT NULL,
  `hashed_password` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `hashed_password`, `email`) VALUES
(1, 'user3', '$2y$10$SEgV8Vjrf6I6Mo8DhNnytum76ctW58xXKuFil.iGxMvArq7RGQuP2', 'michal@gmail.com'),
(2, 'jan', '$2y$10$viiBq.1oyHW/y02q0ee1FeJquRDqJ6cQF9gV4Bcf0g8LPP5D7VdRa', 'jan@gmail.com'),
(3, 'user10', '$2y$10$.DCtXpKvJ8HKYjtnFwaw0.QopUKA37ai29rQEPQ2oPtWL2kSd7F/C', 'user10@gmail.com');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Comment`
--
ALTER TABLE `Comment`
  ADD CONSTRAINT `Comment_ibfk_1` FOREIGN KEY (`id_usera`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `Comment_ibfk_2` FOREIGN KEY (`id_postu`) REFERENCES `Tweet` (`id`);

--
-- Constraints for table `Message`
--
ALTER TABLE `Message`
  ADD CONSTRAINT `Message_ibfk_1` FOREIGN KEY (`id_sender`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `Message_ibfk_2` FOREIGN KEY (`id_receiver`) REFERENCES `users` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
