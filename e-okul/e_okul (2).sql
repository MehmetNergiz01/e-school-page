-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 21 Tem 2024, 15:55:05
-- Sunucu sürümü: 10.4.32-MariaDB
-- PHP Sürümü: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `e_okul`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `attendance`
--

CREATE TABLE `attendance` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `days_present` int(11) DEFAULT NULL,
  `days_absent` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `attendance`
--

INSERT INTO `attendance` (`id`, `student_id`, `days_present`, `days_absent`) VALUES
(1, 1, 30, 21),
(16, 1, 4, 4),
(17, 1, 4, 4),
(20, 1, 5, 5),
(21, 1, 5, 5),
(22, 1, 5, 5),
(23, 1, 5, 5),
(24, 6, 55, 5);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `grades`
--

CREATE TABLE `grades` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `grade` float NOT NULL,
  `verbal_grade` float NOT NULL,
  `teacher_id` int(11) DEFAULT NULL,
  `grade2` float NOT NULL,
  `verbal_grade2` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `grades`
--

INSERT INTO `grades` (`id`, `student_id`, `subject_id`, `grade`, `verbal_grade`, `teacher_id`, `grade2`, `verbal_grade2`) VALUES
(14, 1, 1, 55, 55, 1, 70, 80),
(15, 1, 2, 85, 55, 1, 55, 55),
(16, 1, 6, 85, 90, 1, 70, 90),
(17, 1, 9, 70, 70, 1, 70, 70),
(18, 1, 3, 100, 100, 1, 100, 100),
(25, 1, 9, 80, 80, 1, 80, 80),
(27, 22, 1, 100, 100, NULL, 0, 0),
(28, 21, 1, 44, 44, 1, 44, 44);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `parents`
--

CREATE TABLE `parents` (
  `id` int(11) NOT NULL,
  `school_id` varchar(20) NOT NULL,
  `tc_number` varchar(11) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `parents`
--

INSERT INTO `parents` (`id`, `school_id`, `tc_number`, `password`) VALUES
(10, '21', '12345678932', 'admin');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `parent_student`
--

CREATE TABLE `parent_student` (
  `id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `parent_student`
--

INSERT INTO `parent_student` (`id`, `parent_id`, `student_id`) VALUES
(11, 10, 1);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `schedule`
--

CREATE TABLE `schedule` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `day` varchar(10) DEFAULT NULL,
  `subject_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `schedule`
--

INSERT INTO `schedule` (`id`, `student_id`, `day`, `subject_id`) VALUES
(2, 1, 'Pazartesi', 1),
(4, 1, 'Pazartesi', 2),
(7, 1, 'Pazartesi', 6),
(11, 1, 'Pazartesi', 4),
(12, 1, 'Salı', 9),
(13, 1, 'Salı', 6),
(14, 1, 'Salı', 9),
(15, 1, 'Salı', 6),
(16, 1, 'Salı', 4),
(17, 1, 'Çarşamba', 1),
(19, 1, 'Çarşamba', 1),
(20, 1, 'Çarşamba', 2),
(21, 1, 'Çarşamba', 8),
(22, 1, 'Çarşamba', 2),
(26, 1, 'Perşembe', 1),
(27, 1, 'Perşembe', 4),
(28, 1, 'Perşembe', 1),
(29, 1, 'Perşembe', 4),
(31, 1, 'Cuma', 4),
(32, 1, 'Cuma', 6),
(33, 1, 'Cuma', 4),
(34, 1, 'Cuma', 6),
(38, 1, 'Perşembe', 2),
(39, 1, 'Cuma', 2),
(42, 1, 'Pazartesi', 6),
(43, 1, 'Pazartesi', 6),
(45, 1, 'Cumartesi', 3);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `school_id` varchar(20) NOT NULL,
  `tc_number` varchar(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `class` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `students`
--

INSERT INTO `students` (`id`, `school_id`, `tc_number`, `name`, `class`) VALUES
(1, '21', '12365478932', 'Mehmet Nergiz', '8/A'),
(6, '22', '12345678911', 'MELİKE YILDIZ', '7/A'),
(8, '22', '123456789', 'MELİKE YILDIZ', '7/A');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `subjects`
--

CREATE TABLE `subjects` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `subjects`
--

INSERT INTO `subjects` (`id`, `name`) VALUES
(1, 'Matematik'),
(2, 'Türkçe'),
(3, 'Resim'),
(4, 'Fen Bilimleri'),
(6, 'Sosyal Bilgileri'),
(8, 'Din Kültürü ve Ahlak Bilgisi'),
(9, 'Beden Eğitimi');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `teachers`
--

CREATE TABLE `teachers` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `teachers`
--

INSERT INTO `teachers` (`id`, `username`, `password`) VALUES
(1, 'admin', 'admin');

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`);

--
-- Tablo için indeksler `grades`
--
ALTER TABLE `grades`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subject_id` (`subject_id`);

--
-- Tablo için indeksler `parents`
--
ALTER TABLE `parents`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `parent_student`
--
ALTER TABLE `parent_student`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parent_id` (`parent_id`),
  ADD KEY `student_id` (`student_id`);

--
-- Tablo için indeksler `schedule`
--
ALTER TABLE `schedule`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `subject_id` (`subject_id`);

--
-- Tablo için indeksler `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `teachers`
--
ALTER TABLE `teachers`
  ADD PRIMARY KEY (`id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `attendance`
--
ALTER TABLE `attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- Tablo için AUTO_INCREMENT değeri `grades`
--
ALTER TABLE `grades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- Tablo için AUTO_INCREMENT değeri `parents`
--
ALTER TABLE `parents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Tablo için AUTO_INCREMENT değeri `parent_student`
--
ALTER TABLE `parent_student`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Tablo için AUTO_INCREMENT değeri `schedule`
--
ALTER TABLE `schedule`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- Tablo için AUTO_INCREMENT değeri `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Tablo için AUTO_INCREMENT değeri `subjects`
--
ALTER TABLE `subjects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Tablo için AUTO_INCREMENT değeri `teachers`
--
ALTER TABLE `teachers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Dökümü yapılmış tablolar için kısıtlamalar
--

--
-- Tablo kısıtlamaları `attendance`
--
ALTER TABLE `attendance`
  ADD CONSTRAINT `attendance_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE;

--
-- Tablo kısıtlamaları `grades`
--
ALTER TABLE `grades`
  ADD CONSTRAINT `grades_ibfk_1` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE CASCADE;

--
-- Tablo kısıtlamaları `parent_student`
--
ALTER TABLE `parent_student`
  ADD CONSTRAINT `parent_student_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `parents` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `parent_student_ibfk_2` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE;

--
-- Tablo kısıtlamaları `schedule`
--
ALTER TABLE `schedule`
  ADD CONSTRAINT `schedule_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `schedule_ibfk_2` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
