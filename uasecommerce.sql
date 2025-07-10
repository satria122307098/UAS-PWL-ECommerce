-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 10, 2025 at 05:41 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `uasecommerce`
--

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

CREATE TABLE `produk` (
  `idproduk` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `kategori` varchar(100) DEFAULT NULL,
  `shortdesc` varchar(255) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `harga` decimal(10,2) NOT NULL,
  `berat` float NOT NULL,
  `gambar` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `produk`
--

INSERT INTO `produk` (`idproduk`, `nama`, `kategori`, `shortdesc`, `deskripsi`, `harga`, `berat`, `gambar`) VALUES
(4, 'Apel', 'buah', 'Apel segar dari Malang', 'Apel merah manis segar, kaya akan serat dan vitamin C. Cocok untuk dikonsumsi langsung atau dibuat jus.', '25000.00', 1000, 'apel.jpg'),
(5, 'Pisang', 'buah', 'Pisang matang berkualitas', 'Pisang cavendish matang alami, manis dan bergizi. Cocok untuk sarapan atau camilan sehat.', '18000.00', 1000, 'pisang.jpg'),
(6, 'Raspberry', 'buah', 'Buah raspberry segar impor', 'Raspberry merah kaya antioksidan, rasa asam manis menyegarkan. Cocok untuk salad atau topping dessert.', '90000.00', 500, 'raspberry.jpg'),
(7, 'Jeruk', 'buah', 'Jeruk manis lokal', 'Jeruk sunkist lokal dengan rasa manis segar dan kaya vitamin C. Cocok dimakan langsung atau dibuat jus.', '22000.00', 1000, 'jeruk.jpg'),
(8, 'Anggur', 'buah', 'Anggur hijau manis', 'Anggur hijau seedless, manis alami dan segar. Cocok untuk dikonsumsi langsung atau garnish.', '60000.00', 1000, 'anggur.jpg'),
(9, 'Tomat', 'sayuran', 'Tomat segar organik', 'Tomat merah bulat, cocok untuk sambal, masakan, atau jus. Kaya vitamin A dan C.', '12000.00', 1000, 'tomat.jpg'),
(10, 'Paprika', 'sayuran', 'Paprika merah besar', 'Paprika merah segar ukuran jumbo, rasa manis ringan. Cocok untuk salad dan stir fry.', '45000.00', 500, 'paprika.jpg'),
(11, 'Kentang', 'sayuran', 'Kentang kualitas ekspor', 'Kentang kuning lokal, cocok untuk goreng, rebus, dan sup. Rendah air dan tidak cepat hancur.', '15000.00', 1000, 'kentang.jpg'),
(12, 'Seledri', 'sayuran', 'Seledri daun segar dan sehat', 'Daun seledri segar untuk pelengkap sup dan masakan. Kaya antioksidan dan anti-inflamasi.', '8000.00', 250, 'seledri.jpg'),
(13, 'Brokoli', 'sayuran', 'Brokoli hijau organik', 'Brokoli hijau padat, segar, dan bebas pestisida. Cocok untuk dikukus, sup, dan tumisan.', '28000.00', 500, 'brokoli.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `idtransaksi` int(11) NOT NULL,
  `iduser` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `alamat` text NOT NULL,
  `total` int(11) NOT NULL,
  `snap_token` varchar(100) NOT NULL,
  `status` enum('pending','paid','failed') DEFAULT 'pending',
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`idtransaksi`, `iduser`, `nama`, `alamat`, `total`, `snap_token`, `status`, `created_at`) VALUES
(23, 3, 'satria', 'Semarang', 69000, 'b8170c87-8a23-49cb-af65-ca2336c1370c', 'paid', '2025-07-10 17:32:06'),
(24, 8, 'satriafiandika', 'semarang', 116000, '96c250e3-c561-4990-8e82-de116ccd02f1', 'paid', '2025-07-10 21:20:00'),
(25, 8, 'satriafiandika', 'semarang', 28000, 'dcc89428-3bd8-453b-aded-e31b7160d36b', 'pending', '2025-07-10 21:36:05');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi_detail`
--

CREATE TABLE `transaksi_detail` (
  `id` int(11) NOT NULL,
  `idtransaksi` int(11) NOT NULL,
  `idproduk` int(11) NOT NULL,
  `nama_produk` varchar(100) NOT NULL,
  `harga` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `subtotal` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transaksi_detail`
--

INSERT INTO `transaksi_detail` (`id`, `idtransaksi`, `idproduk`, `nama_produk`, `harga`, `qty`, `subtotal`) VALUES
(28, 23, 13, 'Brokoli', 28000, 1, 28000),
(29, 23, 12, 'Seledri', 8000, 2, 16000),
(30, 23, 4, 'Apel', 25000, 1, 25000),
(31, 24, 13, 'Brokoli', 28000, 2, 56000),
(32, 24, 8, 'Anggur', 60000, 1, 60000),
(33, 25, 13, 'Brokoli', 28000, 1, 28000);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `iduser` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`iduser`, `username`, `nama`, `password`, `role`) VALUES
(2, 'admin', 'Admin', '$2y$10$tqJ4wRzzAfh6XLfjz3e0YeWWgX0g8QrzvfAui9PwKYIzNUBK4yvIS', 'admin'),
(3, 'satria', 'satria', '$2y$10$zOWbJa55XsS9uK8t7i.WBO7R5BiCHgR71T0qiUplfp17Lq9xca3em', 'user'),
(8, 'satriafiandika', 'satriafiandika', '$2y$10$fPFyraNakPnHYUy6adSS.e1f25YgKIpKpS32Gj4zK1QFATPoSbbC6', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`idproduk`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`idtransaksi`),
  ADD KEY `iduser` (`iduser`);

--
-- Indexes for table `transaksi_detail`
--
ALTER TABLE `transaksi_detail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idtransaksi` (`idtransaksi`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`iduser`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `produk`
--
ALTER TABLE `produk`
  MODIFY `idproduk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `idtransaksi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `transaksi_detail`
--
ALTER TABLE `transaksi_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `iduser` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `transaksi_ibfk_1` FOREIGN KEY (`iduser`) REFERENCES `users` (`iduser`) ON DELETE CASCADE;

--
-- Constraints for table `transaksi_detail`
--
ALTER TABLE `transaksi_detail`
  ADD CONSTRAINT `transaksi_detail_ibfk_1` FOREIGN KEY (`idtransaksi`) REFERENCES `transaksi` (`idtransaksi`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
