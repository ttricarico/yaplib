-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 16, 2013 at 07:28 PM
-- Server version: 5.6.12-log
-- PHP Version: 5.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `test`
--
CREATE DATABASE IF NOT EXISTS `test` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `test`;

-- --------------------------------------------------------

--
-- Table structure for table `testtable1`
--

CREATE TABLE IF NOT EXISTS `testtable1` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `data` varchar(25) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=40 ;

--
-- Dumping data for table `testtable1`
--

INSERT INTO `testtable1` (`id`, `data`) VALUES
(1, 'gfrasdfgerger'),
(2, 'ggfegrerghetnhr'),
(3, 'eghethryhjry'),
(4, 'jerjet5unmjtdnh'),
(5, 'rj5yej5k5m7k5mk'),
(6, 'mk56m,e56myke5jyk'),
(7, 'w56j57kerjy'),
(8, 'rjne45je45hu'),
(9, 'gsdfghju567jk468uk57kl9kl'),
(10, 'mk76kl6u8ke4ki64rftmuhu5y'),
(11, 'asdfasdgasgsg'),
(12, 'sdgfgagr4'),
(13, '43563tegfsdv'),
(14, '34wrsfgq34tyq3'),
(15, 'q34gtq3gft4a34ftq34t'),
(16, '34tq343gfta3qt'),
(17, 'q3gq3gerathjujk57ju'),
(18, 'q3tq3t4q34tq3t4q3t4q3gt4q'),
(19, '3aqg5y35y35ye5hye5hywe'),
(20, 'argargtetr45y3t453t'),
(21, 'awgrtrhju46u345y34t6q3wtg'),
(22, 'asgherthethet5hq5yhq35yq3'),
(23, 'asdfasdfasdfasdfasdfasdf'),
(24, 'asfasdfasdfasfasdf'),
(25, '4576347567856j5d'),
(26, 'drjyr5ju65u4wshyuw46uw4'),
(27, '4yuj5j7srthse45y'),
(28, '5y7346y74h5etsy'),
(29, 'afkjhsdgklasg'),
(30, 'afkjhsdgklasg'),
(31, 'afkjhsdgklasg'),
(32, 'afkjhsdgklasg'),
(33, 'afkjhsdgklasg'),
(34, 'afkjhsdgklasg'),
(35, 'afkjhsdgklasg'),
(36, 'afkjhsdgklasg'),
(37, 'Insert DATA'),
(38, 'Insert DATA'),
(39, 'Insert DATA');
--
-- Database: `test2`
--
CREATE DATABASE IF NOT EXISTS `test2` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `test2`;

-- --------------------------------------------------------

--
-- Table structure for table `testingtothemax`
--

CREATE TABLE IF NOT EXISTS `testingtothemax` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `data` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `testingtothemax`
--

INSERT INTO `testingtothemax` (`id`, `data`) VALUES
(1, 'data'),
(2, 'data2'),
(3, 'data3'),
(4, 'data4'),
(5, 'data5'),
(6, 'data6'),
(7, 'data7'),
(8, 'data8'),
(9, 'data9'),
(10, 'data10');
