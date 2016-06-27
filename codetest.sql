-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 26, 2016 at 11:37 PM
-- Server version: 5.5.49-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `codetest`
--

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE IF NOT EXISTS `contacts` (
  `contactId` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) NOT NULL,
  `acId` int(11) DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `surname` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `phone` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
  `custom1` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `custom2` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `custom3` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `custom4` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `custom5` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `synced` tinyint(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`contactId`),
  UNIQUE KEY `search` (`surname`,`email`,`phone`) COMMENT 'Used for search'
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=138 ;

--
-- Dumping data for table `contacts`
--

INSERT INTO `contacts` (`contactId`, `userId`, `acId`, `created`, `name`, `surname`, `email`, `phone`, `custom1`, `custom2`, `custom3`, `custom4`, `custom5`, `synced`) VALUES
(128, 16, 27, '2016-06-27 02:01:34', 'Clark', 'Kent', 'clarkkent@cosminpascu.com', '111-111-1111', 'Superman', NULL, NULL, NULL, NULL, 1),
(133, 16, 28, '2016-06-27 02:19:17', 'Bruce', 'Wayne', 'brucewayne@cosminpascu.com', '222-222-2222', NULL, NULL, NULL, NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `userId` int(11) NOT NULL AUTO_INCREMENT,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `username` varchar(15) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `password` char(60) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL COMMENT 'Holds a bcrypt password',
  `type` enum('site','facebook','github') NOT NULL,
  PRIMARY KEY (`userId`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=17 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userId`, `created`, `username`, `email`, `password`, `type`) VALUES
(15, '2016-06-27 01:06:05', NULL, 'cpascu.web@gmail.com', NULL, 'github'),
(16, '2016-06-27 01:06:09', NULL, 'pascutube@gmail.com', NULL, '');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
