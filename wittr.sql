-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 28, 2016 at 12:54 PM
-- Server version: 5.5.16
-- PHP Version: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `wittr`
--

-- --------------------------------------------------------

--
-- Table structure for table `counter`
--

CREATE TABLE IF NOT EXISTS `counter` (
  `total` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `counter` (`total`) VALUES ( 0 );

-- --------------------------------------------------------

--
-- Table structure for table `wittee`
--

CREATE TABLE IF NOT EXISTS `wittee` (
  `uuid` varchar(100) NOT NULL,
  `device` varchar(512) NOT NULL,
  `user` varchar(512) NOT NULL,
  `latitude` double NOT NULL,
  `longitude` double NOT NULL,
  `when` datetime NOT NULL,
  `hash` varchar(512) NOT NULL,
  `pipe_smoker` tinyint(1) NOT NULL DEFAULT '0',
  `clergy_corner` tinyint(1) NOT NULL DEFAULT '0',
  `ltl` tinyint(1) NOT NULL DEFAULT '0',
  `ceramicists_corner` tinyint(1) NOT NULL DEFAULT '0',
  `norwegian_branch` tinyint(1) NOT NULL DEFAULT '0',
  `colonial_commoner` tinyint(1) NOT NULL DEFAULT '0',
  `cravateer` tinyint(1) NOT NULL DEFAULT '0',
  `diafls` tinyint(1) NOT NULL DEFAULT '0',
  `aals` tinyint(1) NOT NULL DEFAULT '0',
  `pils` tinyint(1) NOT NULL DEFAULT '0',
  `hils` tinyint(1) NOT NULL DEFAULT '0',
  `ncg` tinyint(1) NOT NULL DEFAULT '0',
  `iji` tinyint(1) NOT NULL DEFAULT '0',
  `niji` tinyint(1) NOT NULL DEFAULT '0',
  `battenberg` tinyint(1) NOT NULL DEFAULT '0',
  KEY `user` (`user`),
  KEY `device` (`device`),
  KEY `uuid` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
