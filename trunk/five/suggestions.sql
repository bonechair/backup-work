-- phpMyAdmin SQL Dump
-- version 3.3.2deb1ubuntu1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 08, 2013 at 04:27 AM
-- Server version: 5.1.72
-- PHP Version: 5.3.2-1ubuntu4.21

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `five`
--

-- --------------------------------------------------------

--
-- Table structure for table `suggestions`
--

CREATE TABLE IF NOT EXISTS `suggestions` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `text` varchar(255) NOT NULL,
  `postdate` varchar(20) NOT NULL,
  `active` tinyint(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `suggestions`
--

INSERT INTO `suggestions` (`id`, `username`, `text`, `postdate`, `active`) VALUES
(1, 'bonechair', 'Someone that can help with SEO of website', '8, 11, 2013', 1),
(2, 'bonechair', 'test', '8, 11, 2013', 0),
(3, 'bonechair', 'test', '8, 11, 2013', 0),
(4, 'bonechair', 'test', '8, 11, 2013', 0);
