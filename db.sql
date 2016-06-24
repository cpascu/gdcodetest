-- phpMyAdmin SQL Dump
-- version 4.4.10
-- http://www.phpmyadmin.net
--
-- Host: localhost:8889
-- Generation Time: Jun 24, 2016 at 05:45 AM
-- Server version: 5.5.42
-- PHP Version: 5.6.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `codetest`
--

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `contactId` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `name` varchar(15) CHARACTER SET utf8 NOT NULL,
  `surname` varchar(15) CHARACTER SET utf8 DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `phone` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
  `custom1` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `custom2` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `custom3` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `custom4` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `custom5` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `synced` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `contacts`
--

INSERT INTO `contacts` (`contactId`, `userId`, `created`, `name`, `surname`, `email`, `phone`, `custom1`, `custom2`, `custom3`, `custom4`, `custom5`, `synced`) VALUES
(1, 0, '2016-06-23 05:13:26', 'Cosmin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(2, 0, '2016-06-23 05:19:35', 'Cosmin', NULL, 'cosmin@cosminpascu.com', NULL, NULL, NULL, NULL, NULL, NULL, 1),
(3, 0, '2016-06-23 05:22:03', 'Cosmin', NULL, 'cosmin@cosminpascu.com', NULL, NULL, NULL, NULL, NULL, NULL, 1),
(4, 0, '2016-06-23 05:22:16', 'Cosmin2', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(5, 0, '2016-06-23 05:37:18', 'Cosmin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(6, 0, '2016-06-23 05:47:33', 'Cosmin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(7, 0, '2016-06-23 05:50:57', 'Cosmin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(8, 0, '2016-06-23 05:51:09', 'Cosmin2', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(9, 0, '2016-06-23 05:51:11', 'Cosmin3', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(10, 0, '2016-06-24 02:15:38', 'Cosmin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(11, 0, '2016-06-24 02:15:39', 'Cosmin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(12, 0, '2016-06-24 02:15:42', 'Cosmin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(13, 0, '2016-06-24 02:15:42', 'Cosmin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(14, 0, '2016-06-24 02:15:42', 'Cosmin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(15, 0, '2016-06-24 02:15:58', 'Cosmin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userId` int(11) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `username` varchar(15) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `password` char(60) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL COMMENT 'Holds a bcrypt password',
  `type` enum('site','facebook','github') NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userId`, `created`, `username`, `email`, `password`, `type`) VALUES
(1, '0000-00-00 00:00:00', 'sdfasdf', 'asdfasfas@gmail.com', '$2y$10$6HOHtU3nVFSZPs0vxpC7l.19wo3y0MFDlNqYmPCpJwo181jXhPemu', ''),
(4, '0000-00-00 00:00:00', 'test1', 'test1@gdtest.com', '$2y$10$1qzenWPPvKq7bgoi.QfVTubVP300Y8Dh4vgcdytz8tAonbFZVMelO', ''),
(5, '0000-00-00 00:00:00', 'test2', 'test2@gdtest.com', '$2y$10$qSYQijUo9mUCEVRtT/0nqePvS6e5oVJ40KfFE0QH7Ju5LIMAWIzum', ''),
(6, '0000-00-00 00:00:00', 'test3', 'test3@gdtest.com', '$2y$10$OIqXwXOGmZrElD9FY3s7ge3dzvN1Z950.XcAv8ZAa9hIhi5cAcJQq', ''),
(7, '0000-00-00 00:00:00', 'test4', 'test4@gdtest.com', '$2y$10$xCUm4VnhAMsPPsL8WGLzle2bq0cZ6Y.WemdsVz7cWLOFYA3A4bS2u', ''),
(8, '0000-00-00 00:00:00', 'test5', 'test5@gdtest.com', '$2y$10$HvkS5qjOwFo5vzB0TajaNeMhLS.oorgveECwS/ddaiMC5eD1uBT1S', ''),
(9, '0000-00-00 00:00:00', 'test6', 'test6@gdtest.com', '$2y$10$Z9FavwTNkrqHtuhdaZaXN.1R9mW8hD7SzSwDd9RnRUHbKXhGq472W', ''),
(10, '0000-00-00 00:00:00', 'test01', 'test01@gdtest.com', '$2y$10$qRilogZWaw3qUgNQgHUxuOr2Zeb0g32o7.E2JmMmEGhmLSoLwSn8O', ''),
(11, '0000-00-00 00:00:00', NULL, 'cpascu.web@gmail.com', NULL, ''),
(13, '0000-00-00 00:00:00', NULL, 'pascutube@gmail.com', NULL, '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`contactId`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userId`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `contactId` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userId` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=14;