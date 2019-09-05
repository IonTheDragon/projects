-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Сен 05 2019 г., 10:19
-- Версия сервера: 10.1.37-MariaDB
-- Версия PHP: 7.3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `stock_exchange`
--

-- --------------------------------------------------------

--
-- Структура таблицы `stock_kwh`
--

CREATE TABLE `stock_kwh` (
  `id` int(11) NOT NULL,
  `account_id` varchar(16) NOT NULL,
  `name` varchar(64) NOT NULL,
  `sname` varchar(64) NOT NULL,
  `count` float NOT NULL,
  `password` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Дамп данных таблицы `stock_kwh`
--

INSERT INTO `stock_kwh` (`id`, `account_id`, `name`, `sname`, `count`, `password`) VALUES
(1, '5ebe9cb352e0ea7a', 'Ð˜Ð²Ð°Ð½', 'Ð’Ð¾Ð·Ð½ÑŽÐº', 2, '$2y$10$MbsmvjyfvA0StKTEe1nGneZnKkDMrt2kkw6CLpqOSrJlgBrD3aG0i'),
(6, '0e4c17de11eaf99b', 'Ivan', 'Kornilov', 1.16, '$2y$10$N0DkLV6DXlx4z7aJkZBD7esXLUfjka5jVIDe3QN4TkiYlZcNjh/qy'),
(15, '7ae4255f77153b70', 'Stan', 'Gecko-Green', 1, '$2y$10$bX71cBBsrH9qM/JC4/uQOu.fvfE9I2d56msdGsbQ4it.cNVHLrzeO'),
(16, '85911b657523df8c', 'Karl', 'Linkoln', 1, '$2y$10$mD3LbByDFDXiAGOr8SbZF.ST3NoCveIWQpdpMJrLjBk.lYGKCVIGG');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `stock_kwh`
--
ALTER TABLE `stock_kwh`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `stock_kwh`
--
ALTER TABLE `stock_kwh`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
