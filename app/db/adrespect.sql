-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 17 Cze 2023, 19:16
-- Wersja serwera: 10.4.27-MariaDB
-- Wersja PHP: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `adrespect`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `currency_conversions`
--

CREATE TABLE `currency_conversions` (
  `id` int(11) NOT NULL,
  `table_no` varchar(255) NOT NULL,
  `effective_date` date NOT NULL,
  `currency` varchar(255) NOT NULL,
  `currency_code` varchar(255) NOT NULL,
  `target_currency` varchar(255) NOT NULL,
  `target_currency_code` varchar(255) NOT NULL,
  `amount` decimal(16,2) NOT NULL,
  `target_amount` decimal(16,2) NOT NULL,
  `mid_ex_rate` double NOT NULL,
  `target_table_no` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Struktura tabeli dla tabeli `exchange_rates`
--

CREATE TABLE `exchange_rates` (
  `id` int(11) NOT NULL,
  `effective_date` date NOT NULL,
  `currency` varchar(50) NOT NULL,
  `currency_code` varchar(11) NOT NULL,
  `mid_ex_rate` double NOT NULL,
  `table_no` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


--
ALTER TABLE `currency_conversions`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `exchange_rates`
--
ALTER TABLE `exchange_rates`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT dla zrzuconych tabel
--

--
-- AUTO_INCREMENT dla tabeli `currency_conversions`
--
ALTER TABLE `currency_conversions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=98;

--
-- AUTO_INCREMENT dla tabeli `exchange_rates`
--
ALTER TABLE `exchange_rates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1044;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
