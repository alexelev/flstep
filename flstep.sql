-- phpMyAdmin SQL Dump
-- version 4.0.10.6
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1:3306
-- Время создания: Дек 15 2014 г., 16:30
-- Версия сервера: 5.5.41-log
-- Версия PHP: 5.3.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `flstep`
--
CREATE DATABASE IF NOT EXISTS `flstep` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `flstep`;

-- --------------------------------------------------------

--
-- Структура таблицы `authorization`
--

CREATE TABLE IF NOT EXISTS `authorization` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL COMMENT 'id пользователя',
  `pswd` varchar(255) NOT NULL COMMENT 'пароль пользователя в md5',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='авторизация' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `contest`
--

CREATE TABLE IF NOT EXISTS `contest` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL COMMENT 'заголовок конкурса',
  `descr` text NOT NULL COMMENT 'описание конкурса',
  `id_customer` int(10) unsigned NOT NULL COMMENT 'id заказчика',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='конкурсы' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `contest_task`
--

CREATE TABLE IF NOT EXISTS `contest_task` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_contest` int(11) NOT NULL COMMENT 'id конкурса',
  `id_task` int(11) NOT NULL COMMENT 'id работы',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='связь конкурса с работой' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `customers`
--

CREATE TABLE IF NOT EXISTS `customers` (
  `id` int(10) unsigned NOT NULL,
  `login` varchar(255) DEFAULT NULL COMMENT 'login заказчика',
  `email` varchar(255) DEFAULT NULL COMMENT 'email заказчика',
  `tel` varchar(255) DEFAULT NULL COMMENT 'tel заказчика',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='заказчики (заполняется из табл. пользователей по типу)';

-- --------------------------------------------------------

--
-- Структура таблицы `devs`
--

CREATE TABLE IF NOT EXISTS `devs` (
  `id` int(10) unsigned NOT NULL,
  `tel` varchar(255) DEFAULT NULL COMMENT 'телефонный номер',
  `email` varchar(255) DEFAULT NULL COMMENT 'email для связи',
  `login` varchar(255) DEFAULT NULL COMMENT 'login на сервисе',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='исполнители (заполняется из таблицы пользователей по типу)';

-- --------------------------------------------------------

--
-- Структура таблицы `fieldTypes`
--

CREATE TABLE IF NOT EXISTS `fieldTypes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(255) NOT NULL COMMENT 'имя поля',
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `fieldValues`
--

CREATE TABLE IF NOT EXISTS `fieldValues` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_task` int(10) unsigned NOT NULL COMMENT 'id работы',
  `id_fieldType` int(10) unsigned NOT NULL COMMENT 'id типа поля',
  `value` text NOT NULL COMMENT 'текст значения',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='таблица значений полей' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `messages`
--

CREATE TABLE IF NOT EXISTS `messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_sender` int(11) NOT NULL COMMENT 'id отправителя',
  `text` text NOT NULL,
  `id_recepient` int(11) NOT NULL COMMENT 'id получателя',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='сообщения в системе' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `portfolio`
--

CREATE TABLE IF NOT EXISTS `portfolio` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_task` int(10) unsigned NOT NULL COMMENT 'id работы',
  `id_dev` int(11) NOT NULL COMMENT 'id разработчика',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='портфолио' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `tasks`
--

CREATE TABLE IF NOT EXISTS `tasks` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL COMMENT 'название работы',
  `id_dev` int(11) NOT NULL COMMENT 'id исполнителя',
  `type` varchar(255) NOT NULL COMMENT 'тип работы',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='общая таблица всех работ' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `task_fields`
--

CREATE TABLE IF NOT EXISTS `task_fields` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_task` int(10) unsigned NOT NULL COMMENT 'id работы',
  `id_field` int(10) unsigned NOT NULL COMMENT 'id поля',
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(255) NOT NULL COMMENT 'тип пользователя (заказчик/разработчик)',
  `login` varchar(255) DEFAULT NULL COMMENT 'login пользователя',
  `email` varchar(255) DEFAULT NULL COMMENT 'email пользователя',
  `tel` varchar(255) DEFAULT NULL COMMENT 'tel number пользователя',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='описание пользователя' AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
