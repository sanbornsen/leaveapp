-- phpMyAdmin SQL Dump
-- version 3.5.8.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 26, 2013 at 04:19 PM
-- Server version: 5.5.34-0ubuntu0.13.04.1
-- PHP Version: 5.4.9-4ubuntu2.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `leave`
--

-- --------------------------------------------------------

--
-- Table structure for table `leave`
--

CREATE TABLE IF NOT EXISTS `leave` (
  `leave_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(155) NOT NULL,
  `leave_from` date NOT NULL,
  `leave_to` date NOT NULL,
  `leave_reason` text NOT NULL,
  `approved_by` int(155) NOT NULL,
  `applied_on` date NOT NULL,
  `approved_on` date NOT NULL,
  `leave_way` text NOT NULL,
  `comment` text NOT NULL,
  `leave_type` int(10) NOT NULL,
  PRIMARY KEY (`leave_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

--
-- Dumping data for table `leave`
--

INSERT INTO `leave` (`leave_id`, `user_id`, `leave_from`, `leave_to`, `leave_reason`, `approved_by`, `applied_on`, `approved_on`, `leave_way`, `comment`, `leave_type`) VALUES
(10, 15, '2013-11-17', '2013-11-18', 'I want a leave.', 20, '2013-11-17', '0000-00-00', '{"14":"rejected","20":"accepted"}', '{"19":{"comment":"","user":"14"}}', 1),
(11, 15, '2013-11-21', '2013-11-27', 'I need another leave', 14, '2013-11-17', '0000-00-00', '{"14":"accepted"}', '{"20":{"comment":"You can approve him, no issue.<br>","user":"14"},"19":{"comment":"","user":"14"}}', 1),
(12, 14, '2013-11-17', '2013-11-20', 'I want a leave', 0, '2013-11-17', '0000-00-00', '{"20":"rejected"}', '', 1),
(13, 15, '2013-11-27', '2013-11-29', 'Want a Leave ', 20, '2013-11-17', '0000-00-00', '{"14":"rejected","20":"accepted"}', '{"20":{"comment":"No don''t give a shit<br>","user":"14"},"27":{"comment":"Don''t give <br>","user":"14"}}', 1),
(14, 27, '2013-11-18', '2013-11-19', 'I want a leave', 0, '2013-11-18', '0000-00-00', '{"20":"rejected"}', '{"15":{"comment":"Okay, give her the leave.","user":"20"}}', 1),
(15, 14, '2013-11-20', '2013-11-23', 'want a leave', 0, '2013-11-18', '0000-00-00', '{"20":"pending"}', '', 1),
(16, 15, '2013-11-22', '2013-11-25', 'I want some leave.', 0, '2013-11-19', '0000-00-00', '{"14":"rejected","20":"pending"}', '{"15":{"comment":"","user":"14"}}', 1),
(17, 15, '2013-11-22', '2013-11-22', 'I want a leave', 20, '2013-11-19', '0000-00-00', '{"14":"rejected","20":"accepted"}', '{"20":{"comment":"Okay give he leave hola<br>","user":"14"}}', 2);

-- --------------------------------------------------------

--
-- Table structure for table `leave_type`
--

CREATE TABLE IF NOT EXISTS `leave_type` (
  `leave_type_id` int(155) NOT NULL AUTO_INCREMENT,
  `leave_type_name` varchar(200) NOT NULL,
  PRIMARY KEY (`leave_type_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `leave_type`
--

INSERT INTO `leave_type` (`leave_type_id`, `leave_type_name`) VALUES
(1, 'casual leave'),
(2, 'sick leave');

-- --------------------------------------------------------

--
-- Table structure for table `position`
--

CREATE TABLE IF NOT EXISTS `position` (
  `pos_id` int(155) NOT NULL AUTO_INCREMENT,
  `pos_name` varchar(155) NOT NULL,
  `pos_parent` int(155) NOT NULL DEFAULT '0',
  PRIMARY KEY (`pos_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `position`
--

INSERT INTO `position` (`pos_id`, `pos_name`, `pos_parent`) VALUES
(1, 'Project Manager', 0),
(2, 'Software Engineer', 1),
(3, 'Assistant Software Engineer', 2);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(155) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `f_name` varchar(155) NOT NULL,
  `l_name` varchar(155) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `user_dob` date NOT NULL,
  `user_position` int(155) NOT NULL,
  `user_parent` int(155) NOT NULL,
  `user_status` int(1) NOT NULL,
  `user_salary` int(10) NOT NULL,
  `join_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `changepass` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=29 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `password`, `f_name`, `l_name`, `user_email`, `user_dob`, `user_position`, `user_parent`, `user_status`, `user_salary`, `join_date`, `changepass`) VALUES
(12, 'gairik', 'a04170b0514d3533cb60b3b20c02c511', 'Gairik', 'Aluni', 'pitonrok@gmail.com', '1981-10-23', 3, 8, 0, 20000, '2013-11-18 13:54:34', 1),
(13, 'Kshitij ', '1f52a2ec318a3d786f3f05f8c5348f1c', 'Kshitij ', 'Kesri', 'kshitijkesri@gmail.com', '1991-11-16', 1, 0, 0, 100000, '2013-11-17 03:40:56', 1),
(14, 'prachi.narayan', 'c055583668012da3afc06ace4b463262', 'Prachi', 'Narayan', 'prachi.narayan@hotmail.com', '1992-08-13', 2, 20, 0, 32000, '2013-11-18 13:54:34', 0),
(15, 'sanborn', '2fe064d797a60eca105ee44cfe9f9b06', 'Sudipta', 'Sen', 'sanborn.sen@gnmail.com', '1993-01-31', 3, 14, 0, 25000, '2013-11-18 13:54:34', 0),
(16, 'shreya', '731c381b9cf303949204983d3699af5d', 'Shreya', 'Banerjee', 'shreyabanerjee32@gmail.com', '1990-04-28', 3, 8, 0, 25000, '2013-11-17 03:40:56', 0),
(17, 'deepshikhavats9', 'f7ae2cb77397e3b14c2bee4925a6a9fb', 'Deepshikha', 'Jha', 'deepshikhavats9@gmail.com', '1990-03-09', 3, 14, 0, 32000, '2013-11-17 03:40:56', 1),
(18, 'indradhanush.gupta', '46f3408a61b2c75796d24cce371c65b7', 'Indradhanush', 'Gupta', 'indradhanush.gupta@gmail.com', '1991-05-15', 2, 7, 0, 32000, '2013-11-17 03:40:56', 1),
(19, 'varun', '149e200961ea52955bd55cb49a127935', 'varun', 'luhariwala', 'varunluhariwala@gmail.com', '1991-02-04', 1, 0, 0, 100000, '2013-11-17 03:40:56', 1),
(20, 'sohoum', '7eaaf6fa315a866e34e89decb9ebab4e', 'Sohoum', 'Rakshit', 'rakshitsohoum@gmail.com', '1989-07-31', 1, 0, 0, 32000, '2013-11-18 13:54:34', 0),
(21, 'nittnik', 'fe7dff80da4d7469e01e8d1a868935d8', 'Nitish', 'Jha', 'nittnik@gmail.com', '1990-05-30', 2, 19, 0, 32000, '2013-11-17 03:40:56', 1),
(22, 'parin', '4db70c246bc9680be03892a73158d183', 'Parin', 'Shah', 'parinshah16@gmail.com', '1991-08-08', 3, 18, 0, 25000, '2013-11-17 03:40:56', 1),
(23, 'danish', '5b119a961fcb523c81c25e8f79de2380', 'Danish', 'Saba', 'danish.saba@gmail.com', '1990-06-14', 3, 14, 0, 32000, '2013-11-17 03:40:56', 1),
(24, 'poulami', 'dd31cf7951afa4a2e7466899933e42d5', 'poulami', 'banerjee', 'poulamibanerjee91@gmail.com', '1991-06-03', 2, 20, 0, 32000, '2013-11-17 03:40:56', 1),
(25, 'aniket.chakraborty', '17d4ed0089ea2ce5188e11e7fe0bb047', 'aniket', 'chakraborty', 'aniket.chakraborty292@gmail.com', '1990-05-23', 1, 0, 0, 100000, '2013-11-17 03:40:56', 1),
(26, 'ankita261092@gmail.com', '6edfcf43c7820f16d8d4f72f33fcac06', 'ankita', 'Saha', 'ankita261092@gmail.com', '1991-09-24', 2, 19, 0, 32000, '2013-11-17 03:40:56', 1),
(27, 'sukanya', '7ead4940653128f28d3b5b50bd48051a', 'Sukanya', 'Bhattacharya', 'sukanyab09@gmail.com', '1991-10-09', 2, 20, 0, 32000, '2013-11-18 13:54:34', 0),
(28, 'dhanus', '8719e0b71ffd5a575600d063cc9850ee', 'Indtadhanush', 'Gupta', 'dhanush@gmail.com', '1992-01-31', 2, 19, 0, 32000, '2013-11-18 05:17:12', 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
