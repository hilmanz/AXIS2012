-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 19, 2012 at 01:00 PM
-- Server version: 5.5.16
-- PHP Version: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `axis_kakao_2012`
--

-- --------------------------------------------------------

--
-- Table structure for table `axis_kakao_emoticon`
--

CREATE TABLE IF NOT EXISTS `axis_kakao_emoticon` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `image` varchar(200) NOT NULL,
  `created_date` datetime NOT NULL,
  `publish_date` datetime NOT NULL,
  `expired_date` datetime NOT NULL,
  `n_status` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `axis_kakao_emoticon`
--

INSERT INTO `axis_kakao_emoticon` (`id`, `name`, `image`, `created_date`, `publish_date`, `expired_date`, `n_status`) VALUES
(1, 'nervouse', 'http://png-1.findicons.com/files/icons/1700/2d/512/emoticon_nervous.png', '2012-11-19 00:00:00', '2012-11-19 00:00:00', '2012-11-19 00:00:00', 1),
(2, 'darkboo', 'http://images2.wikia.nocookie.net/__cb20100422230423/fantendo/images/f/fd/Dark_Boo_NSMBDIY.png', '2012-11-19 00:00:00', '2012-11-19 00:00:00', '2012-11-19 00:00:00', 1),
(3, 'anger', 'http://icons-search.com/img/icons-land/IconsLandVistaStyleEmoticonsDemo.zip/IconsLandVistaStyleEmoticonsDemo-PNG-256x256-Furious.png-256x256.png', '2012-11-19 00:00:00', '2012-11-19 00:00:00', '2012-11-19 00:00:00', 1),
(4, 'kribo', 'http://icons-search.com/img/fasticon/BlackPower_Emoticons_Lnx.zip/BlackPower_Emoticons_Lnx-Icons-undecided_256x256.png-256x256.png', '2012-11-19 00:00:00', '2012-11-19 00:00:00', '2012-11-19 00:00:00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `axis_kakao_vote`
--

CREATE TABLE IF NOT EXISTS `axis_kakao_vote` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `description` text NOT NULL,
  `shareon` varchar(200) NOT NULL,
  `created_date` datetime NOT NULL,
  `n_status` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `shareon` (`shareon`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `gm_activity_log`
--

CREATE TABLE IF NOT EXISTS `gm_activity_log` (
  `id` bigint(21) NOT NULL AUTO_INCREMENT,
  `admin_id` bigint(21) NOT NULL,
  `date_ts` int(11) DEFAULT '0',
  `date_time` datetime DEFAULT NULL,
  `action` varchar(200) DEFAULT '0',
  `description` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_log_id` (`admin_id`,`date_ts`,`date_time`),
  KEY `user_id` (`admin_id`),
  KEY `actions` (`action`,`description`),
  KEY `date_ts` (`date_ts`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `gm_dashboard`
--

CREATE TABLE IF NOT EXISTS `gm_dashboard` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `class` varchar(255) NOT NULL,
  `invoker` varchar(255) NOT NULL,
  `status` tinyint(3) NOT NULL DEFAULT '1',
  `slot` tinyint(3) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `gm_level`
--

CREATE TABLE IF NOT EXISTS `gm_level` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `level` varchar(100) NOT NULL,
  `type` varchar(100) NOT NULL,
  `specified_role` int(11) NOT NULL DEFAULT '1',
  `n_status` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `n_status` (`n_status`),
  KEY `specified_role` (`specified_role`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `gm_level`
--

INSERT INTO `gm_level` (`id`, `level`, `type`, `specified_role`, `n_status`) VALUES
(1, 'admin', 'admin,manager,approver,creator', 0, 1),
(2, 'manager', 'approver,creator', 0, 1),
(3, 'approver', 'approver', 0, 1),
(4, 'creator', 'creator', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `gm_member`
--

CREATE TABLE IF NOT EXISTS `gm_member` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `company` varchar(100) DEFAULT NULL,
  `username` varchar(10) NOT NULL DEFAULT '',
  `password` varchar(32) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `gm_member`
--

INSERT INTO `gm_member` (`id`, `name`, `email`, `company`, `username`, `password`) VALUES
(1, 'Hapsoro Renaldy N', 'hapsoro.renaldy@winixmedia.com', 'winixmedia', 'duf', '45f7f94a2916f9719327b90d70302498');

-- --------------------------------------------------------

--
-- Table structure for table `gm_module_registry`
--

CREATE TABLE IF NOT EXISTS `gm_module_registry` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `requestID` varchar(24) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=81 ;

--
-- Dumping data for table `gm_module_registry`
--

INSERT INTO `gm_module_registry` (`id`, `requestID`, `description`) VALUES
(1, 'static', 'Static Page Management'),
(3, 'home', 'Homepage Settings'),
(8, 'admin', 'Administrative Functions'),
(14, 'builder', 'Application Builder'),
(41, 'system', 'System-Wide Configuration'),
(56, 'user', 'User Management'),
(61, 'user_management', 'user_management'),
(62, 'news', 'news'),
(63, 'barcode', 'barcode management'),
(64, 'article', 'Article Management'),
(65, 'master', 'Master Management'),
(66, 'message', 'Messaging'),
(67, 'banner', 'Banner Management'),
(68, 'product', 'product management'),
(69, 'coorporate_blog', 'coorporate blog management'),
(70, 'coorporate_news', 'coorporate berita management'),
(71, 'coorporate_career', 'coorporate karir management'),
(72, 'mcp', 'mcp content management'),
(73, 'coverage', 'coverage content management'),
(74, 'isi_pulsa', 'isi pulsa content management'),
(75, 'distributor_resmi', 'distributor resmi content management'),
(76, 'product_article', 'product_article content management'),
(77, 'mediasiaran', 'mediasiaran content management'),
(78, 'kualitaslayanan', 'kualitas layanan content management'),
(79, 'galeri', 'Gallery content management'),
(80, 'division', 'Division Management');

-- --------------------------------------------------------

--
-- Table structure for table `gm_options`
--

CREATE TABLE IF NOT EXISTS `gm_options` (
  `name` varchar(32) NOT NULL DEFAULT '',
  `val` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `gm_options`
--

INSERT INTO `gm_options` (`name`, `val`) VALUES
('banner_delay', '10'),
('contact_email', ''),
('maintenance_mode', '0'),
('broadcast_message', ''),
('show_broadcast', '0');

-- --------------------------------------------------------

--
-- Table structure for table `gm_permission`
--

CREATE TABLE IF NOT EXISTS `gm_permission` (
  `userID` int(10) NOT NULL DEFAULT '0',
  `reqID` varchar(32) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `gm_permission`
--

INSERT INTO `gm_permission` (`userID`, `reqID`) VALUES
(3, 'product_article'),
(3, 'product'),
(3, 'message'),
(3, 'mcp'),
(3, 'isi_pulsa'),
(4, 'product_article'),
(4, 'product'),
(4, 'message'),
(4, 'mcp'),
(4, 'isi_pulsa'),
(1, 'product'),
(1, 'news'),
(1, 'message'),
(1, 'mediasiaran'),
(1, 'mcp'),
(1, 'master'),
(1, 'kualitaslayanan'),
(1, 'isi_pulsa'),
(1, 'home'),
(1, 'galeri'),
(1, 'distributor_resmi'),
(1, 'coverage'),
(1, 'coorporate_news'),
(1, 'coorporate_career'),
(1, 'coorporate_blog'),
(1, 'builder'),
(1, 'barcode'),
(1, 'banner'),
(2, 'article'),
(8, 'article'),
(1, 'article'),
(1, 'admin'),
(3, 'distributor_resmi'),
(3, 'coverage'),
(3, 'coorporate_news'),
(3, 'coorporate_career'),
(3, 'coorporate_blog'),
(3, 'banner'),
(3, 'article'),
(4, 'distributor_resmi'),
(4, 'coverage'),
(4, 'coorporate_news'),
(4, 'coorporate_career'),
(4, 'coorporate_blog'),
(4, 'banner'),
(4, 'article'),
(2, 'banner'),
(2, 'coorporate_blog'),
(2, 'coorporate_career'),
(2, 'coorporate_news'),
(2, 'coverage'),
(2, 'distributor_resmi'),
(2, 'isi_pulsa'),
(2, 'mcp'),
(2, 'product'),
(2, 'product_article'),
(1, 'product_article'),
(1, 'static'),
(1, 'system'),
(1, 'user'),
(1, 'division'),
(5, 'coorporate_blog');

-- --------------------------------------------------------

--
-- Table structure for table `gm_plugin`
--

CREATE TABLE IF NOT EXISTS `gm_plugin` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `plugin_name` varchar(50) NOT NULL,
  `plugin_path` text NOT NULL,
  `requestID` varchar(50) NOT NULL,
  `className` varchar(50) NOT NULL,
  `is_enabled` tinyint(2) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `className` (`className`),
  KEY `requestID` (`requestID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=64 ;

--
-- Dumping data for table `gm_plugin`
--

INSERT INTO `gm_plugin` (`id`, `plugin_name`, `plugin_path`, `requestID`, `className`, `is_enabled`) VALUES
(2, 'pluginBuilder', 'Admin/', 'pluginBuilder', 'pluginBuilder', 1),
(3, 'PluginViewer', 'PluginViewer/', 'plugin', 'PluginViewer', 1),
(24, 'System', 'System/', 'system', 'SystemApp', 1),
(45, 'barcode', 'barcode', 'barcode', 'barcode', 1),
(46, 'article', 'application/admin/', 'article', 'article', 1),
(47, 'axisuser', 'application/admin/', 'axisuser', 'axisuser', 1),
(48, 'master', 'application/admin/', 'master', 'master', 1),
(49, 'message', 'application/admin/', 'message', 'message', 1),
(50, 'banner', 'application/admin/', 'banner', 'banner', 1),
(51, 'product', 'application/admin/', 'product', 'product', 1),
(52, 'coorporate_blog', 'application/admin/', 'coorporate_blog', 'coorporate_blog', 1),
(53, 'coorporate_news', 'application/admin/', 'coorporate_news', 'coorporate_news', 1),
(54, 'coorporate_career', 'application/admin/', 'coorporate_career', 'coorporate_career', 1),
(55, 'mcp', 'application/admin/', 'mcp', 'mcp', 1),
(56, 'coverage', 'application/admin/', 'coverage', 'coverage', 1),
(57, 'isi_pulsa', 'application/admin/', 'isi_pulsa', 'isi_pulsa', 1),
(58, 'distributor_resmi', 'application/admin/', 'distributor_resmi', 'distributor_resmi', 1),
(59, 'product_article', 'application/admin/', 'product_article', 'product_article', 1),
(60, 'mediasiaran', 'application/admin/', 'mediasiaran', 'mediasiaran', 1),
(61, 'kualitaslayanan', 'application/admin/', 'kualitaslayanan', 'kualitaslayanan', 1),
(62, 'galeri', 'application/admin/', 'galeri', 'galeri', 1),
(63, 'division', 'application/admin/', 'division', 'division', 1);

-- --------------------------------------------------------

--
-- Table structure for table `gm_specified_role`
--

CREATE TABLE IF NOT EXISTS `gm_specified_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `level` int(11) NOT NULL,
  `aid` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  `category` int(11) NOT NULL,
  `n_status` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_data` (`aid`,`category`,`type`),
  KEY `category` (`category`),
  KEY `aid` (`aid`),
  KEY `level` (`level`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `gm_specified_role`
--

INSERT INTO `gm_specified_role` (`id`, `level`, `aid`, `type`, `category`, `n_status`) VALUES
(8, 4, 2, 2, 5, 1),
(9, 3, 3, 2, 0, 1),
(10, 3, 4, 2, 0, 1),
(11, 2, 5, 2, 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `gm_splash`
--

CREATE TABLE IF NOT EXISTS `gm_splash` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `file` varchar(100) NOT NULL,
  `type` enum('swf','img') NOT NULL,
  `upload_date` datetime DEFAULT NULL,
  `path` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

--
-- Table structure for table `gm_static_page`
--

CREATE TABLE IF NOT EXISTS `gm_static_page` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL DEFAULT '',
  `brief` text,
  `detail` longtext,
  `posted` datetime DEFAULT NULL,
  `tag` varchar(255) DEFAULT NULL,
  `groupID` int(11) DEFAULT NULL,
  `parentID` int(10) DEFAULT '0',
  `status` int(3) DEFAULT '0',
  `img` varchar(60) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

-- --------------------------------------------------------

--
-- Table structure for table `gm_static_page_group`
--

CREATE TABLE IF NOT EXISTS `gm_static_page_group` (
  `groupID` int(10) NOT NULL AUTO_INCREMENT,
  `groupName` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`groupID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `gm_tags`
--

CREATE TABLE IF NOT EXISTS `gm_tags` (
  `tag` varchar(100) NOT NULL DEFAULT '',
  UNIQUE KEY `tag` (`tag`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `gm_user`
--

CREATE TABLE IF NOT EXISTS `gm_user` (
  `userID` int(11) NOT NULL AUTO_INCREMENT,
  `level` int(11) NOT NULL DEFAULT '0',
  `position` varchar(200) NOT NULL,
  `name` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `username` varchar(20) NOT NULL DEFAULT '',
  `password` varchar(32) NOT NULL DEFAULT '',
  `enc_key` varchar(32) NOT NULL DEFAULT '',
  PRIMARY KEY (`userID`),
  UNIQUE KEY `username` (`username`),
  KEY `name` (`name`),
  KEY `email` (`email`),
  KEY `position` (`position`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `gm_user`
--

INSERT INTO `gm_user` (`userID`, `level`, `position`, `name`, `email`, `username`, `password`, `enc_key`) VALUES
(1, 1, 'super admin', 'administrator', '', 'admin', '21232f297a57a5a743894a0e4a801fc3', 'f91863fd71ac9a130d88e65244ecf688'),
(2, 4, 'creator', 'bummi dwi putera', 'bummi@kana.co.id', 'bummi', '21232f297a57a5a743894a0e4a801fc3', 'dbf3bb57f3bc57cfe519b51fd05801fe'),
(3, 3, 'CRAP', 'farah', 'farah@gmail.com', 'farah', '21232f297a57a5a743894a0e4a801fc3', '22cfc4e4b9853acee133c57894d1c381'),
(4, 3, 'CRAP', 'bianca utaya', 'bianca@gmail.com', 'bianca', '21232f297a57a5a743894a0e4a801fc3', '5c12fb45bab3f038f21bc5e4f5277516'),
(5, 2, 'CMO', 'Daniel Horan', 'sigit@kana.co.id', 'sigit123', 'd6916d248b949bb73ee7066f567151f2', 'dd59293c82aaf1171168a59688d490e4');

-- --------------------------------------------------------

--
-- Table structure for table `social_member`
--

CREATE TABLE IF NOT EXISTS `social_member` (
  `id` int(15) NOT NULL AUTO_INCREMENT,
  `name` varchar(46) DEFAULT NULL,
  `nickname` varchar(50) DEFAULT NULL,
  `email` varchar(200) DEFAULT NULL,
  `register_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `img` text,
  `small_img` text,
  `username` varchar(46) DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `city` int(11) DEFAULT NULL,
  `sex` varchar(11) DEFAULT NULL,
  `birthday` datetime DEFAULT NULL,
  `description` text,
  `last_name` varchar(46) DEFAULT NULL,
  `StreetName` varchar(150) DEFAULT NULL,
  `phone_number` bigint(15) DEFAULT NULL,
  `n_status` int(3) NOT NULL DEFAULT '0',
  `fb_id` varchar(200) NOT NULL,
  `twitter_id` varchar(200) NOT NULL,
  `gplus_id` varchar(200) NOT NULL,
  `login_count` int(11) NOT NULL DEFAULT '0',
  `verified` tinyint(3) DEFAULT '0' COMMENT '0->no hp blm verified, 1->sudah verified.',
  `salt` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `fb_id` (`fb_id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_activity_actions`
--

CREATE TABLE IF NOT EXISTS `tbl_activity_actions` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `activityName` varchar(64) DEFAULT NULL,
  `type` varchar(200) NOT NULL,
  `point` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `activityName` (`activityName`),
  KEY `point` (`point`),
  KEY `type` (`type`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

--
-- Dumping data for table `tbl_activity_actions`
--

INSERT INTO `tbl_activity_actions` (`id`, `activityName`, `type`, `point`) VALUES
(1, 'login', '', 5),
(2, 'article', '', 5),
(3, 'customPage', '', 0),
(4, 'globalAction', '', 0),
(5, 'updateStatus', '', 0),
(6, 'search', '', 0),
(7, 'logout', '', 0),
(8, 'changeProfile', '', 5),
(9, 'rankUp', '', 0),
(10, 'changeMSIDN', '', 0),
(11, 'share', '', 0),
(12, 'rating', '', 5),
(13, 'like', '', 5),
(14, 'buycontent', '', 5),
(15, 'submit', '', 1),
(16, 'comment', '', 5);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_activity_log`
--

CREATE TABLE IF NOT EXISTS `tbl_activity_log` (
  `id` bigint(21) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(21) NOT NULL,
  `date_ts` int(11) DEFAULT '0',
  `date_time` datetime DEFAULT NULL,
  `action_id` int(4) DEFAULT '0',
  `action_value` varchar(140) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_log_id` (`user_id`,`date_ts`,`date_time`),
  KEY `user_id` (`user_id`),
  KEY `actions` (`action_id`,`action_value`),
  KEY `date_ts` (`date_ts`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_exp_point`
--

CREATE TABLE IF NOT EXISTS `tbl_exp_point` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `date_time_ts` int(11) NOT NULL,
  `date_time` datetime NOT NULL,
  `activity_id` int(11) NOT NULL,
  `score` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_data` (`user_id`,`date_time_ts`),
  KEY `user_id` (`user_id`),
  KEY `date_time_ts` (`date_time_ts`),
  KEY `date_time` (`date_time`),
  KEY `activity_id` (`activity_id`),
  KEY `score` (`score`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
