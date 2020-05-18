-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Май 18 2020 г., 16:14
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
-- База данных: `yii2basic`
--


-- --------------------------------------------------------

--
-- Структура таблицы `payment`
--

CREATE TABLE `payment` (
  `id` int(11) NOT NULL,
  `datetime` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `amount` decimal(12,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `payment`
--

INSERT INTO `payment` (`id`, `datetime`, `phone`, `amount`) VALUES
(5, '2020-05-18 19:40', '79231280714', '25.00'),
(6, '2020-05-18 19:50', '79231280721', '22.00'),
(10, '2020-05-18 20:45', '79231280721', '34.00'),
(11, '2020-05-18 20:50', '79231280718', '12.00'),
(12, '2020-05-18 20:50', '79231280727', '22.00');

-- --------------------------------------------------------

--
-- Структура таблицы `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(512) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `balance` decimal(12,2) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `is_admin` tinyint(4) DEFAULT NULL,
  `auth_key` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password_reset_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `name`, `phone`, `balance`, `status`, `is_admin`, `auth_key`, `password_reset_token`) VALUES
(1, 'admin', '$2y$13$Kjaby6QthIBgWzRHM8daOOiSRODOkLN8zi6s9ZQCCzy.DiGzZkW3i', 'Иван', '79231280714', '25.00', 1, 1, '', ''),
(2, 'Oleg', '$2y$13$PYqF8KprcIjgoxDxJooBF.VPW1Ls94R2kRkhALWj.eBtR9xSGzin2', 'Олег', '79231280715', '0.00', 1, 0, '', ''),
(3, 'Stas', '$2y$13$.14Zj0i69iY0EoGc7q0UI.sXLdbyYfLeTpI/G6onVhbhf3Gp0ruVO', 'Стас', '79231280716', '0.00', 1, 0, NULL, NULL),
(4, 'Eugen', '$2y$13$fJq5Ay96zZvG6.SiN4TctO6XWwaQQpb.Y5L9yHhlYbeV3r5kBHuH2', 'Евгений', '79231280717', '0.00', 0, 0, NULL, NULL),
(5, 'Dasha', '$2y$13$Z0EEzCDQsfaGNtZXda7ABuC5sFc0JfDRxi5E8q3kcSy3BmW8CI2pO', 'Дарья', '79231280718', '12.00', 1, 0, NULL, NULL),
(6, 'Sasha', '$2y$13$eGSvTfSO9ntmCnLjLc69MO/MbtInPK19sqN.xz75v7FwPvFH7gCSm', 'Саша', '79231280720', '2.00', 1, 0, NULL, NULL),
(7, 'Ilia', '$2y$13$WZTJYG3SKUTdfj6JQkYC6ec45ht388pPayxy9YX1o59o6Z1O9qyPy', 'Илья', '79231280721', '56.00', 1, 0, NULL, NULL),
(8, 'Janna', '$2y$13$fY1GDMExo8ZKCfOiP7Ps3O5QTUzMPLzGrzrQHjeZ1YVz1kTQQYexO', 'Жанна', '79231280722', '26.00', 0, 0, NULL, NULL),
(9, 'Ylja', '$2y$13$d2veVA4EHWrirVaTbZa8nudEangvAjAnbBeWW1EqVRQ6VSkp/6yM6', 'Юля', '79231280725', '19.00', 0, 0, NULL, NULL),
(10, 'Vasya', '$2y$13$/V.2IMOIDjjqbGM2E.UWAek9EPaqf1IIiw.ULiWZbFBVrHuNbECd6', 'Вася', '79231280727', '22.00', 1, 0, NULL, NULL);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `payment`
--
ALTER TABLE `payment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT для таблицы `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
