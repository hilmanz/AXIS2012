-- phpMyAdmin SQL Dump
-- version 2.11.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 08, 2013 at 11:59 PM
-- Server version: 5.0.51
-- PHP Version: 5.2.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `axis_bb10`
--

-- --------------------------------------------------------

--
-- Table structure for table `axisbb10_color`
--

CREATE TABLE IF NOT EXISTS `axisbb10_color` (
  `color_white` varchar(10) default NULL,
  `color_black` varchar(10) default NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `axisbb10_color`
--

INSERT INTO `axisbb10_color` (`color_white`, `color_black`) VALUES
('20', '20');

-- --------------------------------------------------------

--
-- Table structure for table `axisbb10_counter`
--

CREATE TABLE IF NOT EXISTS `axisbb10_counter` (
  `axisbb10_counter` smallint(3) unsigned zerofill NOT NULL default '000'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `axisbb10_counter`
--

INSERT INTO `axisbb10_counter` (`axisbb10_counter`) VALUES
(001);

-- --------------------------------------------------------

--
-- Table structure for table `axisbb10_order`
--

CREATE TABLE IF NOT EXISTS `axisbb10_order` (
  `order_id` int(4) NOT NULL auto_increment,
  `order_code` varchar(50) default NULL,
  `order_axis_no` varchar(50) default NULL,
  `order_name` varchar(50) default NULL,
  `order_noktp` varchar(50) default NULL,
  `order_email` varchar(50) default NULL,
  `order_homeaddress` varchar(300) default NULL,
  `order_color` varchar(20) default NULL,
  `dateadd` datetime default NULL,
  PRIMARY KEY  (`order_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `axisbb10_order`
--

