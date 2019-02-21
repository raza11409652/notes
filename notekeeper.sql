-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Feb 21, 2019 at 04:49 PM
-- Server version: 10.1.36-MariaDB
-- PHP Version: 7.0.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `notekeeper`
--

-- --------------------------------------------------------

--
-- Table structure for table `forget_otp`
--

CREATE TABLE `forget_otp` (
  `forget_otp_id` int(11) NOT NULL,
  `forget_otp_token` text NOT NULL,
  `forget_otp_ref` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `forget_otp`
--

INSERT INTO `forget_otp` (`forget_otp_id`, `forget_otp_token`, `forget_otp_ref`) VALUES
(3, '$2y$11$./bgbi4vx1RpES2YTsgkjOFZWTsijAiLIa.xw2.PlFsT2cEDn2KGG', 2);

-- --------------------------------------------------------

--
-- Table structure for table `notes`
--

CREATE TABLE `notes` (
  `notes_id` int(11) NOT NULL,
  `notes_value` text,
  `notes_posted_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `notes_alert_status` varchar(6) NOT NULL,
  `notes_posted_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `notes_alert`
--

CREATE TABLE `notes_alert` (
  `notes_alert_id` int(11) NOT NULL,
  `notes_alert_date` date NOT NULL,
  `notes_alert_time` datetime NOT NULL,
  `notes_alert_ref` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `temp_otp`
--

CREATE TABLE `temp_otp` (
  `temp_otp_id` int(11) NOT NULL,
  `temp_otp_value` text NOT NULL,
  `temp_otp_ref` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `temp_otp`
--

INSERT INTO `temp_otp` (`temp_otp_id`, `temp_otp_value`, `temp_otp_ref`) VALUES
(3, '$2y$11$qWL/7HrPzc.g3NPdqMBH5uSM8uORrZjq/Dy15RjxJQWFcjWhjD416', 3);

-- --------------------------------------------------------

--
-- Table structure for table `temp_user`
--

CREATE TABLE `temp_user` (
  `temp_user_id` int(11) NOT NULL,
  `temp_user_name` varchar(128) NOT NULL,
  `temp_user_email` varchar(256) NOT NULL,
  `temp_user_password` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `temp_user`
--

INSERT INTO `temp_user` (`temp_user_id`, `temp_user_name`, `temp_user_email`, `temp_user_password`) VALUES
(1, 'Khalid', 'raza.11409652@lpu.in', 'b58bca26ea42759f499479322f17f978d4a64a07fbcb484b5a4c2fe1c6abe1c7fcdead07ab3770990341ceb501fdcef8caa8e335faf16514c7f372688fad7687'),
(3, 'khalid', 'mokhalidrazakhan@gmail.com', 'b58bca26ea42759f499479322f17f978d4a64a07fbcb484b5a4c2fe1c6abe1c7fcdead07ab3770990341ceb501fdcef8caa8e335faf16514c7f372688fad7687');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(128) NOT NULL,
  `user_email` varchar(256) NOT NULL,
  `user_password` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `user_name`, `user_email`, `user_password`) VALUES
(2, 'khalid', 'hackdroidbykhan@gmail.com', 'b58bca26ea42759f499479322f17f978d4a64a07fbcb484b5a4c2fe1c6abe1c7fcdead07ab3770990341ceb501fdcef8caa8e335faf16514c7f372688fad7687');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `forget_otp`
--
ALTER TABLE `forget_otp`
  ADD PRIMARY KEY (`forget_otp_id`),
  ADD KEY `forget_otp_ref` (`forget_otp_ref`);

--
-- Indexes for table `notes`
--
ALTER TABLE `notes`
  ADD PRIMARY KEY (`notes_id`),
  ADD KEY `notes_posted_by` (`notes_posted_by`);

--
-- Indexes for table `notes_alert`
--
ALTER TABLE `notes_alert`
  ADD PRIMARY KEY (`notes_alert_id`),
  ADD KEY `notes_alert_ref` (`notes_alert_ref`);

--
-- Indexes for table `temp_otp`
--
ALTER TABLE `temp_otp`
  ADD PRIMARY KEY (`temp_otp_id`),
  ADD KEY `temp_otp_ref` (`temp_otp_ref`);

--
-- Indexes for table `temp_user`
--
ALTER TABLE `temp_user`
  ADD PRIMARY KEY (`temp_user_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `forget_otp`
--
ALTER TABLE `forget_otp`
  MODIFY `forget_otp_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `notes`
--
ALTER TABLE `notes`
  MODIFY `notes_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notes_alert`
--
ALTER TABLE `notes_alert`
  MODIFY `notes_alert_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `temp_otp`
--
ALTER TABLE `temp_otp`
  MODIFY `temp_otp_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `temp_user`
--
ALTER TABLE `temp_user`
  MODIFY `temp_user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `forget_otp`
--
ALTER TABLE `forget_otp`
  ADD CONSTRAINT `forget_otp_ibfk_1` FOREIGN KEY (`forget_otp_ref`) REFERENCES `user` (`user_id`);

--
-- Constraints for table `notes`
--
ALTER TABLE `notes`
  ADD CONSTRAINT `notes_ibfk_1` FOREIGN KEY (`notes_posted_by`) REFERENCES `user` (`user_id`);

--
-- Constraints for table `notes_alert`
--
ALTER TABLE `notes_alert`
  ADD CONSTRAINT `notes_alert_ibfk_1` FOREIGN KEY (`notes_alert_ref`) REFERENCES `notes` (`notes_id`);

--
-- Constraints for table `temp_otp`
--
ALTER TABLE `temp_otp`
  ADD CONSTRAINT `temp_otp_ibfk_1` FOREIGN KEY (`temp_otp_ref`) REFERENCES `temp_user` (`temp_user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
