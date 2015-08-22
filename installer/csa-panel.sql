SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO" ;

--
-- Database: `csa_panel`
--
-- --------------------------------------------------------

--
-- Table structure for table `clients_pending`
--

CREATE TABLE IF NOT EXISTS `clients_pending` (
  `uid` int(10) NOT NULL auto_increment,
  `email` varchar(256) NOT NULL,
  `userid` varchar(256) NOT NULL,
  `realname` varchar(255) NOT NULL,
  `phone` text NOT NULL,
  `proof` text NOT NULL,
  `details` text NOT NULL,
  `status` int(1) NOT NULL,
  `time` varchar(45) NOT NULL
  PRIMARY KEY  (`uid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 ;

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE IF NOT EXISTS `clients` (
  `uid` int(10) NOT NULL auto_increment,
  `email` varchar(256) NOT NULL,
  `userid` varchar(256) NOT NULL,
  `realname` varchar(255) NOT NULL,
  `phone` text NOT NULL,
  `proof` text NOT NULL,
  `details` text NOT NULL,
  `status` int(1) NOT NULL,
  `time` int(45) NOT NULL
  PRIMARY KEY  (`uid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 ;


-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE IF NOT EXISTS `events` (
  `eventid` int(10) NOT NULL auto_increment,
  `message` text NOT NULL,
  `userid` int(10) NOT NULL,
  `runbyid` int(10) NOT NULL,
  `ugid` int(10) NOT NULL,
  `type` varchar(32) NOT NULL,
  `time` varchar(16) NOT NULL,
  PRIMARY KEY  (`eventid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 ;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE IF NOT EXISTS `settings` (
  `name` varchar(32) NOT NULL,
  `value` text NOT NULL,
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `uid` int(10) NOT NULL auto_increment,
  `email` varchar(256) NOT NULL,
  `password` varchar(256) NOT NULL,
  `userlevel` tinyint(1) NOT NULL default '0',
  `permission` text NOT NULL,
  `mainadmin` int(1) NOT NULL default '0',
  `status` int(1) NOT NULL default '1',
  `allowedips` TEXT NOT NULL,
  `session` VARCHAR(256) NOT NULL,
  `lastip` VARCHAR(45) NOT NULL,
  PRIMARY KEY  (`uid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 ;

-- --------------------------------------------------------

--
-- Table structure for table `users_profile`
--

CREATE TABLE IF NOT EXISTS `users_profile` (
  `uid` int(10) NOT NULL auto_increment,
  `firstname` varchar(128) NOT NULL,
  `lastname` varchar(128) NOT NULL,
  `phone` varchar(32) NOT NULL,
  `address` varchar(128) NOT NULL,
  `city` varchar(128) NOT NULL,
  `state` varchar(128) NOT NULL,
  `country` varchar(128) NOT NULL,
  `zipcode` varchar(32) NOT NULL,
  `notes` text NOT NULL,
  PRIMARY KEY  (`uid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 ;


--
-- Main settings for csa-panel
--

INSERT IGNORE INTO `settings` (`name`, `value`) VALUES ('title', 'CSA-Panel Project') ;
INSERT IGNORE INTO `settings` (`name`, `value`) VALUES ('template', 'csapanel') ;
INSERT IGNORE INTO `settings` (`name`, `value`) VALUES ('language', 'english') ;
INSERT IGNORE INTO `settings` (`name`, `value`) VALUES ('debugging', '0') ;
INSERT IGNORE INTO `settings` (`name`, `value`) VALUES ('smartydebug', '0') ;
INSERT IGNORE INTO `settings` (`name`, `value`) VALUES ('version', '') ;
INSERT IGNORE INTO `settings` (`name`, `value`) VALUES ('redirectlogout', '') ;
INSERT IGNORE INTO `settings` (`name`, `value`) VALUES ('forcehttps', '0') ;
INSERT IGNORE INTO `settings` (`name`, `value`) VALUES ('baseurl', '') ;

--
-- Event Logs Settings
--

INSERT IGNORE INTO `settings` (`name`, `value`) VALUES ('eventlog_login', '1') ;
INSERT IGNORE INTO `settings` (`name`, `value`) VALUES ('eventlog_addadministrator', '1') ;
INSERT IGNORE INTO `settings` (`name`, `value`) VALUES ('eventlog_deleteadministrator', '1') ;
INSERT IGNORE INTO `settings` (`name`, `value`) VALUES ('eventlog_editadministrator', '1') ;
INSERT IGNORE INTO `settings` (`name`, `value`) VALUES ('eventlog_adduser', '1') ;
INSERT IGNORE INTO `settings` (`name`, `value`) VALUES ('eventlog_edituser', '1') ;
INSERT IGNORE INTO `settings` (`name`, `value`) VALUES ('eventlog_deleteuser', '1') ;
INSERT IGNORE INTO `settings` (`name`, `value`) VALUES ('eventlog_approveuser', '1') ;

--
-- Links Settings
--

INSERT IGNORE INTO `settings` (`name`, `value`) VALUES ('linkprofile', 'csa-panel.ro') ;

--
-- Add administrator
--
INSERT INTO `users` (`uid`, `email`, `password`, `userlevel`, `permission`, `mainadmin`, `status`, `allowedips`, `session`, `lastip`) VALUES ('1', 'admin@csa-panel.ro', '200ceb26807d6bf99fd6f4f0d1ca54d4', '1', '', '1', '1', '', '', '') ;
INSERT INTO `users_profile` (`uid`, `firstname`, `lastname`, `phone`, `address`, `city`, `state`, `country`, `zipcode`, `notes`) VALUES ('6', 'Cristian G.', 'Danasel', '-', '-', 'Leeds', '-', 'United Kingdom', 'LS', 'User default') ;
