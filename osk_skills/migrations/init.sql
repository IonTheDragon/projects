-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Май 19 2020 г., 16:58
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
-- База данных: `yii2basic_2`
--

-- --------------------------------------------------------

--
-- Структура таблицы `city`
--

CREATE TABLE `city` (
  `cid` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `city`
--

INSERT INTO `city` (`cid`, `name`) VALUES
(1, 'Москва'),
(2, 'Санкт-Петербург'),
(3, 'Новосибирск'),
(4, 'Екатеринбург'),
(5, 'Казань'),
(6, 'Ставрополь');

-- --------------------------------------------------------

--
-- Структура таблицы `names_collection`
--

CREATE TABLE `names_collection` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `names_collection`
--

INSERT INTO `names_collection` (`id`, `name`) VALUES
(1, 'Иван'),
(2, 'Олег'),
(3, 'Женя'),
(4, 'Стас'),
(5, 'Евгений'),
(6, 'Дарья'),
(7, 'Тарас'),
(8, 'Мария'),
(9, 'Ольга'),
(10, 'Жанна'),
(11, 'Маруся'),
(12, 'Инна'),
(13, 'Богдан'),
(14, 'Ашот'),
(15, 'Алексей'),
(16, 'Михаил'),
(17, 'Екатерина'),
(18, 'Николай'),
(19, 'Наталья'),
(20, 'Евгения');

-- --------------------------------------------------------

--
-- Структура таблицы `skills`
--

CREATE TABLE `skills` (
  `sid` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `skills`
--

INSERT INTO `skills` (`sid`, `name`) VALUES
(1, 'Веб-разработчик'),
(2, 'Менеджер по проектам'),
(3, 'Специалист по продажам'),
(4, 'Логист'),
(5, 'Водитель'),
(6, 'HR менеджер'),
(7, 'Тестировщик'),
(8, 'Пиар-менеджер'),
(9, 'Менеджер по перевозкам'),
(10, 'Охранник');

-- --------------------------------------------------------

--
-- Структура таблицы `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(512) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `auth_key` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `password_reset_token` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `auth_key`, `password_reset_token`) VALUES
(1, 'admin', '$2y$13$Kjaby6QthIBgWzRHM8daOOiSRODOkLN8zi6s9ZQCCzy.DiGzZkW3i', '', '');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `city_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `name`, `city_id`) VALUES
(1, 'Иван', 1),
(2, 'Олег', 2),
(3, 'Женя', 3),
(4, 'Стас', 4),
(5, 'Евгений', 5),
(6, 'Дарья', 6),
(7, 'Тарас', 1),
(8, 'Мария', 2),
(9, 'Ольга', 4),
(10, 'Жанна', 5),
(12, 'Маруся', 3),
(13, 'Инна', 6),
(14, 'Богдан', 3),
(15, 'Ашот', 4),
(17, 'Стас', 3),
(18, 'Евгений', 5),
(19, 'Евгения', 2),
(20, 'Дарья', 2),
(21, 'Олег', 2),
(22, 'Евгений', 1),
(23, 'Наталья', 3),
(25, 'Тарас', 3),
(30, 'Тарас', 3),
(31, 'Алексей', 3),
(32, 'Мария', 1),
(33, 'Николай', 1),
(34, 'Женя', 3),
(35, 'Богдан', 6),
(36, 'Наталья', 3),
(37, 'Стас', 2),
(38, 'Наталья', 3),
(40, 'Евгений', 1),
(41, 'Екатерина', 4),
(42, 'Наталья', 4),
(43, 'Ашот', 3),
(44, 'Иван', 1),
(46, 'Екатерина', 6),
(47, 'Стас', 1),
(48, 'Михаил', 5),
(49, 'Тест', 1),
(50, 'Тест2', 6);

-- --------------------------------------------------------

--
-- Структура таблицы `user_skills`
--

CREATE TABLE `user_skills` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `skill_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `user_skills`
--

INSERT INTO `user_skills` (`id`, `user_id`, `skill_id`) VALUES
(1, 1, 1),
(2, 1, 7),
(3, 2, 2),
(4, 2, 8),
(5, 3, 3),
(6, 4, 5),
(7, 4, 9),
(8, 5, 4),
(9, 6, 2),
(10, 6, 6),
(11, 9, 6),
(12, 10, 7),
(13, 10, 1),
(14, 10, 2),
(15, 13, 5),
(16, 14, 9),
(17, 15, 10),
(20, 17, 2),
(21, 17, 3),
(22, 20, 3),
(23, 22, 2),
(24, 23, 7),
(26, 25, 4),
(27, 25, 7),
(32, 30, 5),
(33, 30, 6),
(34, 30, 10),
(35, 31, 1),
(36, 31, 9),
(37, 32, 3),
(38, 32, 7),
(39, 32, 9),
(40, 34, 6),
(41, 34, 9),
(42, 34, 10),
(43, 35, 2),
(44, 35, 4),
(45, 36, 4),
(46, 36, 8),
(47, 36, 9),
(48, 37, 5),
(49, 37, 6),
(50, 37, 10),
(51, 38, 1),
(52, 38, 5),
(53, 38, 9),
(54, 41, 9),
(55, 41, 10),
(56, 42, 8),
(57, 42, 10),
(58, 44, 2),
(59, 44, 3),
(60, 44, 9),
(63, 47, 2),
(64, 47, 5),
(65, 47, 10),
(66, 48, 7),
(67, 50, 2),
(68, 50, 3);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `city`
--
ALTER TABLE `city`
  ADD PRIMARY KEY (`cid`);

--
-- Индексы таблицы `names_collection`
--
ALTER TABLE `names_collection`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `skills`
--
ALTER TABLE `skills`
  ADD PRIMARY KEY (`sid`);

--
-- Индексы таблицы `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `user_skills`
--
ALTER TABLE `user_skills`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `city`
--
ALTER TABLE `city`
  MODIFY `cid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `names_collection`
--
ALTER TABLE `names_collection`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT для таблицы `skills`
--
ALTER TABLE `skills`
  MODIFY `sid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT для таблицы `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT для таблицы `user_skills`
--
ALTER TABLE `user_skills`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
