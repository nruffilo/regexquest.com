-- phpMyAdmin SQL Dump
-- version 3.3.10.4
-- http://www.phpmyadmin.net
--
-- Host: db.regexherogame.com
-- Generation Time: Nov 12, 2012 at 12:12 PM
-- Server version: 5.1.39
-- PHP Version: 5.2.17

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `regexhero`
--

-- --------------------------------------------------------

--
-- Table structure for table `quests`
--

CREATE TABLE IF NOT EXISTS `quests` (
  `quest_id` int(11) NOT NULL AUTO_INCREMENT,
  `safe_name` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `difficulty` enum('tutorial','easy','medium','hard','insane') NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `creator_user_id` int(11) NOT NULL,
  PRIMARY KEY (`quest_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

--
-- Table structure for table `quest_questions`
--

CREATE TABLE IF NOT EXISTS `quest_questions` (
  `question_id` int(11) NOT NULL AUTO_INCREMENT,
  `quest_id` int(11) NOT NULL,
  `question_number` int(11) NOT NULL,
  `options` int(11) NOT NULL DEFAULT '1',
  `type` enum('find','replace') NOT NULL,
  `hint` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `answer` varchar(255) NOT NULL,
  PRIMARY KEY (`question_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `first_name` varchar(200) NOT NULL,
  `last_name` varchar(200) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `display_name` varchar(200) NOT NULL,
  `problems_solved` int(11) NOT NULL,
  `points` int(11) NOT NULL,
  `title` varchar(255) NOT NULL DEFAULT 'Apprentice',
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Table structure for table `user_quest_status`
--

CREATE TABLE IF NOT EXISTS `user_quest_status` (
  `user_id` int(11) NOT NULL,
  `quest_name` varchar(200) NOT NULL,
  `current_question` int(11) NOT NULL DEFAULT '0',
  `completed` tinyint(4) NOT NULL DEFAULT '0',
  UNIQUE KEY `user_id` (`user_id`,`quest_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `user_titles`
--

CREATE TABLE IF NOT EXISTS `user_titles` (
  `user_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  UNIQUE KEY `user_id` (`user_id`,`title`),
  KEY `user_id_2` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;