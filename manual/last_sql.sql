-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1
-- Время создания: Май 11 2016 г., 00:07
-- Версия сервера: 5.5.25
-- Версия PHP: 5.3.13

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- База данных: `crm`
--

-- --------------------------------------------------------

--
-- Структура таблицы `cache_stats`
--

CREATE TABLE IF NOT EXISTS `cache_stats` (
  `cache_name` varchar(255) NOT NULL,
  `cache_value` text,
  PRIMARY KEY (`cache_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `callback`
--

CREATE TABLE IF NOT EXISTS `callback` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `id_client` int(10) NOT NULL,
  `id_user` int(10) NOT NULL,
  `added` int(10) NOT NULL,
  `id_result` tinyint(1) NOT NULL,
  `next_call` int(10) DEFAULT NULL,
  `comment` text NOT NULL,
  `id_product` varchar(20) NOT NULL,
  `type_contact` tinyint(1) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `card_callback`
--

CREATE TABLE IF NOT EXISTS `card_callback` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `id_client` int(10) NOT NULL,
  `manager` int(10) NOT NULL,
  `added` int(10) NOT NULL,
  `next_call` int(10) DEFAULT NULL,
  `result` tinyint(1) NOT NULL,
  `comment` text,
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `card_client`
--

CREATE TABLE IF NOT EXISTS `card_client` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `manager` int(10) NOT NULL,
  `department` int(10) NOT NULL,
  `name` varchar(255) NOT NULL,
  `equid` varchar(10) NOT NULL,
  `added` int(10) DEFAULT NULL,
  `comment` text NOT NULL,
  `last_call` int(10) DEFAULT NULL,
  `next_call` int(10) DEFAULT NULL,
  `mobile` bigint(11) DEFAULT NULL,
  `id_cobrand` int(10) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `id_callback` int(10) NOT NULL,
  `delete` tinyint(1) NOT NULL DEFAULT '0',
  `vip` tinyint(1) NOT NULL DEFAULT '0',
  `last_update` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `card_cobrand`
--

CREATE TABLE IF NOT EXISTS `card_cobrand` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `type` tinyint(1) NOT NULL DEFAULT '0',
  `added` int(10) NOT NULL,
  `disable` smallint(1) NOT NULL DEFAULT '0',
  `edited` int(10) NOT NULL,
  UNIQUE KEY `id_3` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `changelog`
--

CREATE TABLE IF NOT EXISTS `changelog` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `added` int(10) NOT NULL,
  `date` int(10) NOT NULL,
  `rev` varchar(10) NOT NULL,
  `text` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `client`
--

CREATE TABLE IF NOT EXISTS `client` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `department` tinyint(1) NOT NULL,
  `manager` tinyint(1) NOT NULL,
  `mobile` bigint(11) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `birthday` int(10) NOT NULL,
  `added` int(10) NOT NULL,
  `who_added` int(10) NOT NULL,
  `status` int(10) NOT NULL DEFAULT '0',
  `comment` text NOT NULL,
  `last_update` int(10) DEFAULT NULL,
  `gender` tinyint(4) NOT NULL DEFAULT '0',
  `equid` varchar(20) NOT NULL,
  `delete` tinyint(1) NOT NULL DEFAULT '0',
  `vip` tinyint(1) NOT NULL DEFAULT '0',
  `id_callback` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `department`
--

CREATE TABLE IF NOT EXISTS `department` (
  `id` tinyint(2) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `parent` mediumint(4) NOT NULL DEFAULT '0',
  `disable` tinyint(1) NOT NULL DEFAULT '0',
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `faq`
--

CREATE TABLE IF NOT EXISTS `faq` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `text` text NOT NULL,
  `title` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `added` int(10) DEFAULT NULL,
  `edited` int(10) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `history_client`
--

CREATE TABLE IF NOT EXISTS `history_client` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `id_client` int(10) NOT NULL,
  `id_user` int(10) NOT NULL,
  `text` text NOT NULL,
  `time` int(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `messages`
--

CREATE TABLE IF NOT EXISTS `messages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sender` int(10) unsigned NOT NULL DEFAULT '0',
  `receiver` int(10) unsigned NOT NULL DEFAULT '0',
  `added` int(10) DEFAULT NULL,
  `subject` varchar(255) NOT NULL,
  `msg` text,
  `unread` tinyint(1) NOT NULL DEFAULT '1',
  `poster` int(10) unsigned NOT NULL DEFAULT '0',
  `location` tinyint(1) NOT NULL DEFAULT '1',
  `saved` tinyint(1) NOT NULL DEFAULT '0',
  `archived` tinyint(1) NOT NULL DEFAULT '0',
  `archived_receiver` tinyint(1) NOT NULL DEFAULT '0',
  `spamid` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `receiver` (`receiver`),
  KEY `sender` (`sender`),
  KEY `poster` (`poster`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `news`
--

CREATE TABLE IF NOT EXISTS `news` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL DEFAULT '0',
  `added` int(10) NOT NULL,
  `body` text NOT NULL,
  `subject` varchar(300) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `added` (`added`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `orbital_blocks`
--

CREATE TABLE IF NOT EXISTS `orbital_blocks` (
  `bid` int(10) NOT NULL AUTO_INCREMENT,
  `title` varchar(60) NOT NULL,
  `content` text NOT NULL,
  `bposition` char(1) NOT NULL,
  `weight` int(10) NOT NULL DEFAULT '1',
  `active` int(1) NOT NULL DEFAULT '1',
  `blockfile` varchar(255) NOT NULL,
  `view` varchar(20) DEFAULT NULL,
  `expire` int(10) NOT NULL DEFAULT '0',
  `which` varchar(255) NOT NULL,
  `custom_tpl` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`bid`),
  KEY `title` (`title`),
  KEY `weight` (`weight`),
  KEY `active` (`active`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `polls`
--

CREATE TABLE IF NOT EXISTS `polls` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `question` varchar(255) NOT NULL,
  `start` int(10) NOT NULL,
  `exp` int(10) DEFAULT NULL,
  `public` tinyint(1) NOT NULL DEFAULT '0',
  `comments` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `polls_structure`
--

CREATE TABLE IF NOT EXISTS `polls_structure` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pollid` int(10) NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `poll_answer`
--

CREATE TABLE IF NOT EXISTS `poll_answer` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `id_poll` int(10) NOT NULL,
  `id_question` int(10) NOT NULL,
  `answer` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `poll_index`
--

CREATE TABLE IF NOT EXISTS `poll_index` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `added` int(10) NOT NULL,
  `end_date` int(10) NOT NULL,
  `enable` tinyint(1) NOT NULL DEFAULT '0',
  `comment` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `poll_question`
--

CREATE TABLE IF NOT EXISTS `poll_question` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `id_poll` int(10) NOT NULL,
  `question` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `poll_result`
--

CREATE TABLE IF NOT EXISTS `poll_result` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `id_poll` int(10) NOT NULL,
  `id_question` int(10) NOT NULL,
  `id_answer` int(10) NOT NULL,
  `user` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `poll_users`
--

CREATE TABLE IF NOT EXISTS `poll_users` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `ip` varchar(15) NOT NULL,
  `cookies` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `product`
--

CREATE TABLE IF NOT EXISTS `product` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `type` tinyint(1) NOT NULL DEFAULT '0',
  `added` int(10) NOT NULL,
  `disable` smallint(1) NOT NULL DEFAULT '0',
  `edited` int(10) NOT NULL,
  KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `result_call`
--

CREATE TABLE IF NOT EXISTS `result_call` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `text` varchar(255) NOT NULL,
  `disable` tinyint(1) NOT NULL DEFAULT '0',
  `type_contact` tinyint(1) NOT NULL DEFAULT '0',
  `sale` tinyint(1) NOT NULL DEFAULT '0',
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `seorules`
--

CREATE TABLE IF NOT EXISTS `seorules` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `script` varchar(255) DEFAULT NULL,
  `parameter` varchar(255) DEFAULT NULL,
  `repl` varchar(255) DEFAULT NULL,
  `unset_params` varchar(255) DEFAULT NULL,
  `sort` int(2) NOT NULL DEFAULT '0',
  `enabled` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `script` (`script`,`parameter`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `sessions`
--

CREATE TABLE IF NOT EXISTS `sessions` (
  `sid` varchar(32) NOT NULL,
  `uid` int(10) NOT NULL DEFAULT '0',
  `username` varchar(40) NOT NULL,
  `class` tinyint(4) NOT NULL DEFAULT '0',
  `ip` varchar(40) NOT NULL,
  `time` bigint(30) NOT NULL DEFAULT '0',
  `url` varchar(150) NOT NULL,
  `useragent` text,
  PRIMARY KEY (`sid`),
  KEY `time` (`time`),
  KEY `uid` (`uid`),
  KEY `url` (`url`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `sitelog`
--

CREATE TABLE IF NOT EXISTS `sitelog` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `added` int(10) DEFAULT NULL,
  `userid` int(10) NOT NULL DEFAULT '0',
  `txt` text,
  `module` varchar(80) NOT NULL DEFAULT 'site',
  `action` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `added` (`added`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `sys_fix_base`
--

CREATE TABLE IF NOT EXISTS `sys_fix_base` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `text` text NOT NULL,
  `last_update` int(10) NOT NULL,
  `comment` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `type_contact`
--

CREATE TABLE IF NOT EXISTS `type_contact` (
  `id` smallint(2) NOT NULL AUTO_INCREMENT,
  `text` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `login` varchar(9) NOT NULL,
  `passhash` varchar(32) NOT NULL,
  `secret` varchar(20) NOT NULL,
  `added` int(10) NOT NULL DEFAULT '0',
  `who_added` int(10) NOT NULL DEFAULT '0',
  `add_user` tinyint(1) NOT NULL DEFAULT '0',
  `ip` varchar(15) NOT NULL,
  `class` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `banned` tinyint(1) NOT NULL DEFAULT '0',
  `last_access` int(10) NOT NULL DEFAULT '0',
  `dis_reason` text NOT NULL,
  `department` tinyint(2) NOT NULL DEFAULT '0',
  `last_login` int(10) NOT NULL,
  `name` varchar(255) NOT NULL,
  `enable` tinyint(1) NOT NULL DEFAULT '1',
  `add_client` tinyint(1) NOT NULL DEFAULT '0',
  `last_update` int(10) NOT NULL,
  `notifs` varchar(100) NOT NULL,
  `use_card` tinyint(1) NOT NULL DEFAULT '0',
  `only_view` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`login`),
  KEY `status_added` (`added`),
  KEY `ip` (`ip`),
  KEY `last_access` (`add_user`),
  KEY `user` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=1 ;
