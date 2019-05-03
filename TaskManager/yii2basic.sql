-- phpMyAdmin SQL Dump
-- version 4.0.10deb1ubuntu0.1
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Май 03 2019 г., 22:17
-- Версия сервера: 5.5.62-0ubuntu0.14.04.1
-- Версия PHP: 5.5.9-1ubuntu4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `yii2basic`
--

-- --------------------------------------------------------

--
-- Структура таблицы `person`
--

CREATE TABLE IF NOT EXISTS `person` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` char(32) COLLATE cp1250_bin NOT NULL,
  `occupation` char(32) COLLATE cp1250_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=cp1250 COLLATE=cp1250_bin AUTO_INCREMENT=15 ;

--
-- Дамп данных таблицы `person`
--

INSERT INTO `person` (`id`, `name`, `occupation`) VALUES
(1, 'Ivan Voznyuk', 'Web developer (Junior)'),
(2, 'Ivan Ozerov', 'Engineer');

-- --------------------------------------------------------

--
-- Структура таблицы `task`
--

CREATE TABLE IF NOT EXISTS `task` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` char(64) COLLATE cp1250_bin NOT NULL,
  `user` char(32) COLLATE cp1250_bin NOT NULL,
  `status` char(24) COLLATE cp1250_bin NOT NULL,
  `description` char(64) COLLATE cp1250_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=cp1250 COLLATE=cp1250_bin AUTO_INCREMENT=40 ;

--
-- Дамп данных таблицы `task`
--

INSERT INTO `task` (`id`, `title`, `user`, `status`, `description`) VALUES
(1, 'Task manager', 'Ivan Voznyuk', '1.0 version', 'Make Task manager using php framework (Yii2)'),
(3, 'Repair car', 'Ivan Ozerov', 'Completed', 'Repair car engine');

-- --------------------------------------------------------

--
-- Структура таблицы `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` char(10) COLLATE cp1250_bin NOT NULL,
  `password` char(50) COLLATE cp1250_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=cp1250 COLLATE=cp1250_bin AUTO_INCREMENT=2 ;

--
-- Дамп данных таблицы `user`
--

INSERT INTO `user` (`id`, `username`, `password`) VALUES
(1, 'admin', 'admin');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
