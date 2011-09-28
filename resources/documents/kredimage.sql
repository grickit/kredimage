-- phpMyAdmin SQL Dump
-- version 3.3.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 28, 2011 at 06:42 PM
-- Server version: 5.1.54
-- PHP Version: 5.3.5-1ubuntu7.2

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `kredimage`
--

-- --------------------------------------------------------

--
-- Table structure for table `image_stats`
--

CREATE TABLE IF NOT EXISTS `image_stats` (
  `id` int(11) NOT NULL COMMENT 'image_upload.id',
  `name` varchar(300) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL COMMENT 'name of image',
  `description` text CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL COMMENT 'description of image',
  `views_soft` int(11) NOT NULL COMMENT 'views total',
  `views_real` int(11) NOT NULL COMMENT 'views on page'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `image_upload`
--

CREATE TABLE IF NOT EXISTS `image_upload` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `owner` varchar(300) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
  `uploadyear` int(5) NOT NULL,
  `uploadmonth` int(2) NOT NULL,
  `uploadday` int(2) NOT NULL,
  `uploadaddr` varchar(300) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `uploadtype` varchar(300) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

-- --------------------------------------------------------

--
-- Table structure for table `user_registration`
--

CREATE TABLE IF NOT EXISTS `user_registration` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'database key',
  `username` varchar(50) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL COMMENT 'string username',
  `hashedpass` varchar(300) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL COMMENT 'hashed and salted password',
  `email` varchar(300) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL COMMENT 'email address',
  `birthyear` int(5) NOT NULL COMMENT 'the year they were born',
  `regiyear` int(5) NOT NULL COMMENT 'the year they registered',
  `regimonth` int(2) NOT NULL COMMENT 'the month they registered',
  `regiday` int(2) NOT NULL COMMENT 'the day they registered',
  `regiaddr` varchar(300) NOT NULL COMMENT 'The IP address they registered from',
  `terms` int(3) NOT NULL COMMENT 'the latest version of our terms they agreed to',
  `validationcode` varchar(300) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
  `validated` int(1) NOT NULL COMMENT 'have they validated their email',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uid` (`username`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;
