-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Waktu pembuatan: 31 Agu 2024 pada 18.07
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
-- Database: `whatsapp`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `reply`
--

CREATE TABLE `reply` (
  `id` int NOT NULL,
  `pesan_masuk` varchar(255) DEFAULT NULL,
  `pesan_keluar` varchar(255) DEFAULT NULL,
  `update_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `reply`
--

INSERT INTO `reply` (`id`, `pesan_masuk`, `pesan_keluar`, `update_at`) VALUES
(17, 'hallo', 'Hai *${namaPengirim}* , ada yang bisa di bantu', '2024-08-18 02:19:47'),
(18, 'tanggal', 'tanggal sekarang ${tanggalSekarang}', '2024-08-17 22:49:54'),
(19, 'jam', 'Sekarang Jam, ${waktuSekarang}', '2024-08-17 23:14:39'),
(20, 'info', 'Berikut Kata Kunci Yang Dapat Dikirim:\r\n- *jam*\r\n- *tanggal*\r\n- *info*\r\n- *DLL*', '2024-08-17 23:23:20');

-- --------------------------------------------------------

--
-- Struktur dari tabel `sent_messages`
--

CREATE TABLE `sent_messages` (
  `id` int NOT NULL,
  `number` varchar(225) DEFAULT NULL,
  `message` varchar(225) DEFAULT NULL,
  `tanggal` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `sent_messages`
--

INSERT INTO `sent_messages` (`id`, `number`, `message`, `tanggal`) VALUES
(62, '6281918408597', 'Sekarang Jam, 01:52:29', '2024-09-01 01:52:29'),
(63, '081918408597', 'ppppp', '2024-09-01 01:52:55');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user_access`
--

CREATE TABLE `user_access` (
  `id` int NOT NULL,
  `ip` varchar(225) DEFAULT NULL,
  `latitude` varchar(225) DEFAULT NULL,
  `longitude` varchar(225) DEFAULT NULL,
  `location` varchar(225) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `webhook_urls`
--

CREATE TABLE `webhook_urls` (
  `id` int NOT NULL,
  `url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `web_url` varchar(255) DEFAULT NULL,
  `url_api` varchar(225) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `webhook_urls`
--

INSERT INTO `webhook_urls` (`id`, `url`, `web_url`, `url_api`, `updated_at`) VALUES
(26, 'https://script.google.com/macros/s/AKfycbyeGJUX0GQm5_cBtvQsycKO5l774wsnKgg-fMzr8JBNBnCbmzf3JBhaOQxP84LrXDvV/exec', 'http://localhost:3100', 'http://localhost/control_panel_wa', '2024-08-31 17:31:03');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `reply`
--
ALTER TABLE `reply`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `sent_messages`
--
ALTER TABLE `sent_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `user_access`
--
ALTER TABLE `user_access`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `webhook_urls`
--
ALTER TABLE `webhook_urls`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `reply`
--
ALTER TABLE `reply`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT untuk tabel `sent_messages`
--
ALTER TABLE `sent_messages`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT untuk tabel `user_access`
--
ALTER TABLE `user_access`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `webhook_urls`
--
ALTER TABLE `webhook_urls`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
