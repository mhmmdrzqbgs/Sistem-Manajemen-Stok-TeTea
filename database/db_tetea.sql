-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Waktu pembuatan: 15 Des 2024 pada 04.48
-- Versi server: 8.0.30
-- Versi PHP: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_tetea`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `barang`
--

CREATE TABLE `barang` (
  `id_barang` int NOT NULL,
  `nama_barang` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `merek` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `kategori` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `jumlah` int NOT NULL DEFAULT '0',
  `satuan` varchar(10) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `barang`
--

INSERT INTO `barang` (`id_barang`, `nama_barang`, `merek`, `kategori`, `jumlah`, `satuan`) VALUES
(1, 'Teh Hijau', 'Merek A', 'Teh', 25, 'pcs'),
(4, 'Gula Pasir', 'Merek D', 'Bahan Tambahan', 45, 'pcs'),
(11, 'Gula Batu', 'Gulaku', 'Gula', 60, 'pcs'),
(12, 'Selasih', 'Merk F', 'Varian', 20, 'pcs');

-- --------------------------------------------------------

--
-- Struktur dari tabel `stok`
--

CREATE TABLE `stok` (
  `id_stok` int NOT NULL,
  `nama_barang` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `tgl` datetime NOT NULL,
  `stok_masuk` int NOT NULL,
  `stok_keluar` int NOT NULL,
  `jenis_transaksi` enum('Masuk','Keluar','Opname') COLLATE utf8mb4_general_ci NOT NULL,
  `keterangan` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `stok_akhir` int NOT NULL,
  `id_barang` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `stok`
--

INSERT INTO `stok` (`id_stok`, `nama_barang`, `tgl`, `stok_masuk`, `stok_keluar`, `jenis_transaksi`, `keterangan`, `stok_akhir`, `id_barang`) VALUES
(1, 'Teh Hijau', '2024-12-13 10:00:00', 20, 0, 'Masuk', 'Barang baru masuk', 20, 1),
(4, 'Gula Pasir', '2024-12-13 13:00:00', 50, 0, 'Masuk', 'Tambahan stok dari supplier', 50, 4),
(24, 'Gula Batu', '2024-11-06 00:41:00', 50, 0, 'Masuk', 'Penambahan Bahan Baku', 50, 11),
(27, 'Teh Hijau', '2024-12-15 01:50:00', 5, 0, 'Masuk', 'Penambahan Stok', 25, 1),
(28, 'Gula Pasir', '2024-12-15 01:51:00', 0, 5, 'Keluar', 'Stok digunakan', 45, 4),
(29, 'Selasih', '2024-11-17 01:54:00', 20, 0, 'Masuk', 'Barang Masuk', 20, 12),
(30, 'Gula Batu', '2024-11-26 11:07:00', 10, 0, 'Masuk', 'Restok', 60, 11);

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id_user` int NOT NULL,
  `nama` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL COMMENT 'Menyimpan hash password',
  `role` enum('Admin','StaffGudang') COLLATE utf8mb4_general_ci NOT NULL,
  `status` enum('Aktif','Nonaktif') COLLATE utf8mb4_general_ci DEFAULT 'Aktif',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `last_login` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id_user`, `nama`, `email`, `password`, `role`, `status`, `created_at`, `updated_at`, `last_login`) VALUES
(1, 'Owner', 'admin@owner.com', '$2y$10$LfOt0AZqTd1wlvK7EhoOeux7CSjY6KJ3VnqXRRdeuDmNZBKCvuAzW', 'Admin', 'Aktif', '2024-12-13 22:05:29', '2024-12-13 22:21:19', NULL),
(2, 'Ahmad Dwi', 'staff@ahmad.com', '$2y$10$LfOt0AZqTd1wlvK7EhoOeux7CSjY6KJ3VnqXRRdeuDmNZBKCvuAzW', 'StaffGudang', 'Aktif', '2024-12-13 22:05:29', '2024-12-13 22:20:52', NULL),
(5, 'Muh. Rizqi', 'staff@rizqi.com', '$2y$10$Eds8oIgzyvWapjY52LAi8.rFEbQh8o9S9R2fE3THpgTjLV23j/fK.', 'StaffGudang', 'Aktif', '2024-12-15 01:55:56', NULL, NULL),
(6, 'Bangga Aditya', 'staff@bangga.com', '$2y$10$Zo1A3Uct0mwbU1o1I5k.r.RDdkqCrNI4tQ4WqeoaiNGscEAu1.6DK', 'StaffGudang', 'Aktif', '2024-12-15 11:42:32', NULL, NULL),
(7, 'Reza Satria', 'staff@reza.com', '$2y$10$fr9UkNlKRyFRh7y9a0QJ.e9C9aJ1JBu58tgSLrbzXbb6bT9GJJ56G', 'StaffGudang', 'Aktif', '2024-12-15 11:43:08', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`id_barang`);

--
-- Indeks untuk tabel `stok`
--
ALTER TABLE `stok`
  ADD PRIMARY KEY (`id_stok`),
  ADD KEY `fk_stok_barang` (`id_barang`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `barang`
--
ALTER TABLE `barang`
  MODIFY `id_barang` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `stok`
--
ALTER TABLE `stok`
  MODIFY `id_stok` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `stok`
--
ALTER TABLE `stok`
  ADD CONSTRAINT `fk_stok_barang` FOREIGN KEY (`id_barang`) REFERENCES `barang` (`id_barang`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
