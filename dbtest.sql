-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 23, 2017 at 12:15 PM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `dbtest`
--

-- --------------------------------------------------------

--
-- Table structure for table `microposts`
--

CREATE TABLE IF NOT EXISTS `microposts` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) NOT NULL,
  `content` text NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`Id`),
  KEY `Foreign Key` (`userId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=57 ;

--
-- Dumping data for table `microposts`
--

INSERT INTO `microposts` (`Id`, `userId`, `content`, `created_at`) VALUES
(10, 4, 'new one.lol', '2017-01-02 01:21:13'),
(11, 8, 'from priyesh2', '2017-01-02 19:29:55'),
(20, 4, 'My name is Priyesh...', '2017-01-09 00:18:17'),
(21, 4, 'My name is Priyesh...What is your name?', '2017-01-09 00:18:32'),
(22, 4, 'My name is Priyesh...What is your name? You know what?', '2017-01-09 00:18:52'),
(25, 4, 'My name is Priyesh...What is your name? You know what? I just don''t care....Hahaha..', '2017-01-09 00:27:12'),
(26, 4, ':)', '2017-01-09 00:27:26'),
(36, 54, 'hi', '2017-01-20 16:10:28'),
(37, 54, 'Helllo on 23-01-2017', '2017-01-23 11:32:22'),
(38, 54, '2nd hello', '2017-01-23 11:35:01'),
(39, 54, '3rd hello', '2017-01-23 11:36:30'),
(41, 54, '4th hello', '2017-01-23 15:38:18'),
(42, 54, '5th hello', '2017-01-23 16:00:22'),
(56, 55, 'Hello', '2017-01-23 16:19:26');

-- --------------------------------------------------------

--
-- Table structure for table `relationships`
--

CREATE TABLE IF NOT EXISTS `relationships` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `follower_id` int(11) NOT NULL,
  `followed_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `Follower_Foreign` (`follower_id`),
  KEY `Followed_Foreign` (`followed_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=32 ;

--
-- Dumping data for table `relationships`
--

INSERT INTO `relationships` (`id`, `follower_id`, `followed_id`) VALUES
(2, 8, 4),
(17, 4, 8),
(24, 54, 4),
(25, 4, 54),
(26, 54, 8);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `userId` int(11) NOT NULL AUTO_INCREMENT,
  `userName` varchar(30) NOT NULL,
  `userEmail` varchar(60) NOT NULL,
  `userPass` varchar(255) NOT NULL,
  `admin` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`userId`),
  UNIQUE KEY `userEmail` (`userEmail`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=63 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userId`, `userName`, `userEmail`, `userPass`, `admin`) VALUES
(4, 'Priyesh', 'priyesh99@outlook.com', 'fe228a6aba6770880098ab424961cc5b', 1),
(8, 'Priyesh2', 'priyeshdoshi61@gmail.com', 'fe228a6aba6770880098ab424961cc5b', 0),
(45, 'Priyesh5', 'p@g5.com', 'c4ca4238a0b923820dcc509a6f75849b', 0),
(46, 'Priyesh6', 'p@g6.com', 'c4ca4238a0b923820dcc509a6f75849b', 0),
(53, 'Yuvi', 'png625@gmail.com', 'b24331b1a138cde62aa1f679164fc62f', 0),
(54, 'Priyu', 'p@p.com', '123', 1),
(55, 'Hae', 'a@A.com', '1', 0),
(62, 'Harshit', 'harshit09doshi@gmail.com', '123', 0);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `microposts`
--
ALTER TABLE `microposts`
  ADD CONSTRAINT `Foreign Key Constraint` FOREIGN KEY (`userId`) REFERENCES `users` (`userId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `relationships`
--
ALTER TABLE `relationships`
  ADD CONSTRAINT `followed_cnst` FOREIGN KEY (`followed_id`) REFERENCES `users` (`userId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `follower_cnst` FOREIGN KEY (`follower_id`) REFERENCES `users` (`userId`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
