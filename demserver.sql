-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Хост: MySQL-8.2
-- Время создания: Июн 23 2025 г., 06:07
-- Версия сервера: 8.2.0
-- Версия PHP: 8.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `demserver`
--

-- --------------------------------------------------------

--
-- Структура таблицы `admins`
--

CREATE TABLE `admins` (
  `user_id` bigint UNSIGNED NOT NULL,
  `FIO` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `admins`
--

INSERT INTO `admins` (`user_id`, `FIO`) VALUES
(1, 'Иванов Иван Иванович');

-- --------------------------------------------------------

--
-- Структура таблицы `examiners`
--

CREATE TABLE `examiners` (
  `user_id` bigint UNSIGNED NOT NULL,
  `FIO` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `examiners`
--

INSERT INTO `examiners` (`user_id`, `FIO`) VALUES
(10, 'Кузнецов Михаил Владимирович'),
(14, 'Иванов Артём Сергеевич'),
(25, 'sdf');

-- --------------------------------------------------------

--
-- Структура таблицы `examiner_groups`
--

CREATE TABLE `examiner_groups` (
  `examiner_id` bigint UNSIGNED NOT NULL COMMENT 'ID экзаменатора',
  `group_id` bigint UNSIGNED NOT NULL COMMENT 'ID группы'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `examiner_groups`
--

INSERT INTO `examiner_groups` (`examiner_id`, `group_id`) VALUES
(10, 1),
(10, 2),
(25, 2),
(14, 3),
(14, 4),
(10, 6);

-- --------------------------------------------------------

--
-- Структура таблицы `exams`
--

CREATE TABLE `exams` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `exam_date` datetime NOT NULL,
  `folder_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `exams`
--

INSERT INTO `exams` (`id`, `name`, `exam_date`, `folder_path`) VALUES
(10, 'Программировани', '2025-06-24 00:23:00', 'exames\\programmirovani'),
(11, 'ВЕБ', '2025-06-25 04:09:00', 'exames\\veb');

-- --------------------------------------------------------

--
-- Структура таблицы `exam_groups`
--

CREATE TABLE `exam_groups` (
  `exam_id` bigint UNSIGNED NOT NULL,
  `group_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `exam_groups`
--

INSERT INTO `exam_groups` (`exam_id`, `group_id`) VALUES
(10, 1),
(11, 1),
(10, 2),
(11, 2),
(11, 6);

-- --------------------------------------------------------

--
-- Структура таблицы `groups`
--

CREATE TABLE `groups` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `groups`
--

INSERT INTO `groups` (`id`, `name`) VALUES
(1, 'ИТ-101'),
(2, 'ИТ-102'),
(3, 'ИТ-201'),
(4, 'РП-41'),
(5, 'ПБ-32'),
(6, 'РП-42');

-- --------------------------------------------------------

--
-- Структура таблицы `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('pG1j95APscbBpeRbaAq0LrKEjKvSJOWQNzNlHrLe', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 YaBrowser/25.4.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiM0tRT3Y0cFlwVFlLYlJ2VkVwYkpSTzI5Sno1WDRwenhxekFlYU9RbyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzY6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9zdHVkZW50cyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6MzoidXJsIjthOjE6e3M6ODoiaW50ZW5kZWQiO3M6MzE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9kYXNoYm9hcmQiO31zOjQ6InVzZXIiO086ODoic3RkQ2xhc3MiOjQ6e3M6MjoiaWQiO2k6MTtzOjU6ImxvZ2luIjtzOjU6ImFkbWluIjtzOjg6InBhc3N3b3JkIjtzOjYwOiIkMnkkMTAkOTJJWFVOcGtqTzByT1E1YnlNaS5ZZTRvS29FYTNSbzlsbEMvLm9nL2F0Mi51aGVXRy9pZ2kiO3M6NDoicm9sZSI7czo1OiJhZG1pbiI7fX0=', 1750642618);

-- --------------------------------------------------------

--
-- Структура таблицы `streams`
--

CREATE TABLE `streams` (
  `id` bigint UNSIGNED NOT NULL,
  `folder_path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Путь к папке потока',
  `exam_id` bigint UNSIGNED NOT NULL COMMENT 'Связь с экзаменом',
  `stream_number` int UNSIGNED NOT NULL COMMENT 'Номер потока'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `students`
--

CREATE TABLE `students` (
  `user_id` bigint UNSIGNED NOT NULL,
  `FIO` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `group_id` bigint UNSIGNED DEFAULT NULL,
  `stream_id` bigint UNSIGNED DEFAULT NULL,
  `folder_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `students`
--

INSERT INTO `students` (`user_id`, `FIO`, `group_id`, `stream_id`, `folder_path`) VALUES
(5, 'Кузнецова Елена Сергеевна', 1, NULL, 'exams/programmirovani/it-101/student2/asd.zip'),
(6, 'Васильев Дмитрий Александрович', 2, NULL, 'exams/programmirovani/it-101/student2/sdfsdfsdf.zip'),
(9, 'Мария Олеговна Лебедева', 1, NULL, ''),
(16, 'Stupa spupa', 1, NULL, ''),
(21, 'sd', 1, NULL, ''),
(22, 'df', 1, NULL, ''),
(26, 'sdf', 1, NULL, ''),
(27, 'g', 2, NULL, '');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `login` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('admin','examiner','student') COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `login`, `password`, `role`) VALUES
(1, 'admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin'),
(5, 'student2', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'student'),
(6, 'student3', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'student'),
(9, 'Mariaф', '$2y$12$aJh5xFCf7ylF.srA98EeOOFnamc1g.Sn8btczhSKG8Ba2MdjipW0y', 'student'),
(10, 'Examiner1', '$2y$12$DkQK4aORQxDjEyDKcawKpeTW0/GtN1432xQIl1Bmjtc8/8PcDXW36', 'examiner'),
(14, 'Examiner3', '$2y$12$Ocxdy9Rk.38QcDoe5FIPY.CIcx9iRqHwkoSGZF/KO6/DrIwWDg2z2', 'examiner'),
(16, 'adminпп', '$2y$12$KLBwSCiP8oXcxXF.Tc8RxebXIxZftJZI5pF1M4Upy4Kl4/5TSMxhe', 'student'),
(21, 'ss', '$2y$12$ianSKrKt.dZIqoXt0AHx/e2Cc0CDBwtXQJ6NhbR12hwOYE/epl54i', 'student'),
(22, 'sd', '$2y$12$mX823kn/Ob4imP2dKwM8I.9qkfd9yMgUvs7KerTIe/o/ofBaVPW2q', 'student'),
(25, 'exam', '$2y$12$De7aCxzldUeRPpNBL9EGPOJWUVP0R7Y4E1akV41m1zWHXw9YpIzfi', 'examiner'),
(26, 'sssss', '$2y$12$5dHRPbefIMAt.SnHH16KTuHxaAvRxhzzgDiDNC4fAMzI9dccd/Wu2', 'student'),
(27, 'sdg', '$2y$12$E5yYp8EPt4zB4OkxJCbzJeySLcfSqf73xAaj2xP1F.Jbo3AnIgOJe', 'student');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`user_id`);

--
-- Индексы таблицы `examiners`
--
ALTER TABLE `examiners`
  ADD PRIMARY KEY (`user_id`);

--
-- Индексы таблицы `examiner_groups`
--
ALTER TABLE `examiner_groups`
  ADD PRIMARY KEY (`examiner_id`,`group_id`),
  ADD KEY `fk_examiner_groups_group` (`group_id`);

--
-- Индексы таблицы `exams`
--
ALTER TABLE `exams`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `exam_groups`
--
ALTER TABLE `exam_groups`
  ADD PRIMARY KEY (`exam_id`,`group_id`),
  ADD KEY `fk_exam_groups_groups` (`group_id`);

--
-- Индексы таблицы `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Индексы таблицы `streams`
--
ALTER TABLE `streams`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_stream` (`exam_id`,`stream_number`),
  ADD KEY `fk_streams_exam` (`exam_id`);

--
-- Индексы таблицы `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `students_group_fk` (`group_id`),
  ADD KEY `students_stream_fk` (`stream_id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `exams`
--
ALTER TABLE `exams`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT для таблицы `groups`
--
ALTER TABLE `groups`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `streams`
--
ALTER TABLE `streams`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `admins`
--
ALTER TABLE `admins`
  ADD CONSTRAINT `admins_user_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `examiners`
--
ALTER TABLE `examiners`
  ADD CONSTRAINT `examiners_user_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `examiner_groups`
--
ALTER TABLE `examiner_groups`
  ADD CONSTRAINT `fk_examiner_groups_examiner` FOREIGN KEY (`examiner_id`) REFERENCES `examiners` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_examiner_groups_group` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `exam_groups`
--
ALTER TABLE `exam_groups`
  ADD CONSTRAINT `fk_exam_groups_exams` FOREIGN KEY (`exam_id`) REFERENCES `exams` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_exam_groups_groups` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `streams`
--
ALTER TABLE `streams`
  ADD CONSTRAINT `fk_streams_exam` FOREIGN KEY (`exam_id`) REFERENCES `exams` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `students_group_fk` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `students_stream_fk` FOREIGN KEY (`stream_id`) REFERENCES `streams` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `students_user_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
