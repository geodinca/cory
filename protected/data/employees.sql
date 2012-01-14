-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 14, 2012 at 05:00 PM
-- Server version: 5.5.16
-- PHP Version: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `cory`
--

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE IF NOT EXISTS `employees` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `companies_id` int(11) NOT NULL,
  `instances_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `geographical_area` varchar(255) DEFAULT NULL,
  `contact_info` text,
  `email` varchar(255) DEFAULT NULL,
  `home_street` varchar(255) DEFAULT NULL,
  `home_city` varchar(255) DEFAULT NULL,
  `home_state_country` varchar(255) DEFAULT NULL,
  `home_zip` varchar(255) DEFAULT NULL,
  `home_phone` varchar(255) DEFAULT NULL,
  `actual_location_street` varchar(255) DEFAULT NULL,
  `actual_location_city` varchar(255) DEFAULT NULL,
  `actual_location_state` varchar(255) DEFAULT NULL,
  `profile` text NOT NULL,
  `date_entered` datetime NOT NULL,
  `date_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `misc_info` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  FULLTEXT KEY `geographical_area` (`geographical_area`),
  FULLTEXT KEY `contact_info` (`contact_info`),
  FULLTEXT KEY `profile` (`profile`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3165 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
