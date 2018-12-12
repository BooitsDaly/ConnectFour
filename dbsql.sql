SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `games`;
CREATE TABLE `games` (
  `gameid` int(11) NOT NULL AUTO_INCREMENT,
  `turn` tinyint(4) DEFAULT NULL,
  `board` varchar(256) DEFAULT NULL,
  `player1` int(11) DEFAULT NULL,
  `player2` int(11) DEFAULT NULL,
  `last_move` varchar(10) DEFAULT NULL,
  `win` int(11) DEFAULT NULL,
  PRIMARY KEY (`gameid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `messages`;
CREATE TABLE `messages` (
  `messageid` int(11) NOT NULL AUTO_INCREMENT,
  `gameid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `message` varchar(100) NOT NULL,
  PRIMARY KEY (`messageid`,`gameid`,`userid`),
  KEY `fk_messages_games_idx` (`gameid`),
  KEY `fk_messages_users1_idx` (`userid`),
  CONSTRAINT `fk_messages_games` FOREIGN KEY (`gameid`) REFERENCES `games` (`gameid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_messages_users1` FOREIGN KEY (`userid`) REFERENCES `users` (`userid`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `userid` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(45) DEFAULT NULL,
  `password` varchar(256) DEFAULT NULL,
  `gameid` int(11) NOT NULL,
  `isAuthenticated` tinyint(4) DEFAULT NULL,
  `wasChallenged` int(11) DEFAULT NULL,
  `responseChallenge` int(11) DEFAULT '0',
  PRIMARY KEY (`userid`,`gameid`),
  KEY `fk_users_games1_idx` (`gameid`),
  CONSTRAINT `fk_users_games1` FOREIGN KEY (`gameid`) REFERENCES `games` (`gameid`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `users` (`userid`, `username`, `password`, `gameid`, `isAuthenticated`, `wasChallenged`, `responseChallenge`) VALUES
(1,	'test',	'9F86D081884C7D659A2FEAA0C55AD015A3BF4F1B2B0B822CD15D6C15B0F00A08',	0,	1,	0,	0),
(2,	'testing',	'CF80CD8AED482D5D1527D7DC72FCEFF84E6326592848447D2DC0B0E87DFC9A90',	0,	1,	0,	0),
(3,	'caitlyn',	'F26182189435F47CBD150DA72EB4239514421090C379E8EC94B4DFC124286D3D',	0,	1,	0,	0),
(4,	'jake',	'CDF30C6B345276278BEDC7BCEDD9D5582F5B8E0C1DD858F46EF4EA231F92731D',	46,	0,	0,	0),
(5,	'star',	'525ECA1D5089DBDCBB6700D910C5E0BC23FBAA23EE026C0E224C2B45490E5F29',	46,	0,	0,	0),
(8,	'me',	'2744ccd10c7533bd736ad890f9dd5cab2adb27b07d500b9493f29cdc420cb2e0',	0,	0,	0,	0);