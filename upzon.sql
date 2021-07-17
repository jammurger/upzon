-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 18 Tem 2021, 00:29:33
-- Sunucu sürümü: 10.4.18-MariaDB
-- PHP Sürümü: 8.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `upzon`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `analiysis`
--

CREATE TABLE `analiysis` (
  `analiysis_id` int(11) NOT NULL,
  `analiysis_url` varchar(600) NOT NULL,
  `analiysis_title` varchar(300) NOT NULL,
  `analiysis_canonical` varchar(300) NOT NULL,
  `analiysis_h1` int(11) NOT NULL,
  `analiysis_h2` int(11) NOT NULL,
  `analiysis_h3` int(11) NOT NULL,
  `analiysis_h4` int(11) NOT NULL,
  `analiysis_h5` int(11) NOT NULL,
  `analiysis_h6` int(11) NOT NULL,
  `analiysis_robots` text NOT NULL,
  `analiysis_mostwords` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`analiysis_mostwords`)),
  `analiysis_images` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`analiysis_images`)),
  `analiysis_imagesalt` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `analiysis_urls` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`analiysis_urls`)),
  `analiysis_time` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `analiysis`
--
ALTER TABLE `analiysis`
  ADD PRIMARY KEY (`analiysis_id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `analiysis`
--
ALTER TABLE `analiysis`
  MODIFY `analiysis_id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
