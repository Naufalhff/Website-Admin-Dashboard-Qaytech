-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 27, 2024 at 01:01 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `qaytech`
--

-- --------------------------------------------------------

--
-- Table structure for table `event_cimahi`
--

CREATE TABLE `event_cimahi` (
  `no_peserta` int(11) NOT NULL,
  `Timestamp` timestamp NULL DEFAULT NULL,
  `nama_anjing` varchar(255) NOT NULL,
  `nama_pemilik` varchar(255) NOT NULL,
  `handler` varchar(255) NOT NULL,
  `size` varchar(255) NOT NULL,
  `kelas` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `waktu_tempuh` decimal(10,2) NOT NULL,
  `fault` int(11) NOT NULL,
  `refusal` int(11) NOT NULL,
  `result` decimal(10,2) NOT NULL,
  `rangking` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `event_cimahi`
--

INSERT INTO `event_cimahi` (`no_peserta`, `Timestamp`, `nama_anjing`, `nama_pemilik`, `handler`, `size`, `kelas`, `status`, `waktu_tempuh`, `fault`, `refusal`, `result`, `rangking`) VALUES
(8, NULL, 'blacki', 'dono', 'sutono', 'medium', 'FA1', 'finish', '90.80', 0, 13, '155.80', 0),
(9, NULL, 'white', 'dono', 'jono', 'small', 'FA1', 'finish', '90.00', 1, 4, '115.00', 1),
(10, NULL, 'orange', 'dono', 'sutono', 'small', 'FA1', 'finish', '90.00', 6, 2, '130.00', 0),
(11, NULL, 'idoy', 'dono', 'sutono', '', '', '', '0.00', 0, 0, '0.00', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `event_cimahi`
--
ALTER TABLE `event_cimahi`
  ADD PRIMARY KEY (`no_peserta`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `event_cimahi`
--
ALTER TABLE `event_cimahi`
  MODIFY `no_peserta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
