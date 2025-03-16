-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Waktu pembuatan: 13 Mar 2025 pada 08.24
-- Versi server: 8.0.30
-- Versi PHP: 8.2.21

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `reply`
--

INSERT INTO `reply` (`id`, `pesan_masuk`, `pesan_keluar`, `update_at`) VALUES
(17, 'hallo', 'Hai *${namaPengirim}* ', '2025-03-13 13:31:13'),
(18, 'tanggal', 'tanggal sekarang ${tanggalSekarang}', '2024-08-17 22:49:54'),
(19, 'jam', 'Sekarang Jam, ${waktuSekarang}', '2024-08-17 23:14:39'),
(20, 'member', ' Hai  Kak ${namaPengirim} Berikut Command Fitur Daftar Dan Cek Member Via Bot Whatsapp:\r\n- *!daftar*\r\n- *!member*', '2025-02-28 23:32:20');

-- --------------------------------------------------------

--
-- Struktur dari tabel `sent_messages`
--

CREATE TABLE `sent_messages` (
  `id` int NOT NULL,
  `number` varchar(225) DEFAULT NULL,
  `message_in` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `message` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `tanggal` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `sent_messages`
--

INSERT INTO `sent_messages` (`id`, `number`, `message_in`, `message`, `tanggal`) VALUES
(298, '6281918408597', 'hallo', 'Hai *BAYU* , ada yang bisa di bantu', '2025-03-13 13:24:42'),
(299, '6281918408597', 'p', 'Selamat Siang *BAYU*, di WhatsApp Bot Pintar ketik *INFO* untuk Menggunakan Fitur Bot', '2025-03-13 13:24:54'),
(300, '6281918408597', 'hallo', 'Hai *BAYU* , ada yang bisa di bantu', '2025-03-13 13:28:47'),
(301, '6281918408597', 'member', ' Hai  Kak BAYU Berikut Command Fitur Daftar Dan Cek Member Via Bot Whatsapp:\r\n- *!daftar*\r\n- *!member*', '2025-03-13 13:30:39'),
(302, '6281918408597', 'hallo', 'Hai *BAYU* ', '2025-03-13 13:31:16'),
(303, '6285333640674', 'cek status', 'Selamat Siang *DEVELOPER*, di WhatsApp Bot Pintar ketik *INFO* untuk Menggunakan Fitur Bot', '2025-03-13 14:30:32'),
(304, '6285333640674', 'cek status', 'Selamat Siang *DEVELOPER*, di WhatsApp Bot Pintar ketik *INFO* untuk Menggunakan Fitur Bot', '2025-03-13 14:32:16'),
(305, '6285333640674', 'cek status', 'Selamat Siang *DEVELOPER*, di WhatsApp Bot Pintar ketik *INFO* untuk Menggunakan Fitur Bot', '2025-03-13 14:36:03'),
(306, '6285333640674', 'list laundry', 'Selamat Siang *DEVELOPER*, di WhatsApp Bot Pintar ketik *INFO* untuk Menggunakan Fitur Bot', '2025-03-13 14:37:58'),
(307, '6285333640674', 'list laundry', 'Selamat Siang *DEVELOPER*, di WhatsApp Bot Pintar ketik *INFO* untuk Menggunakan Fitur Bot', '2025-03-13 14:39:08'),
(308, '6281918408597', 'cek status', 'Selamat Siang *BAYU*, di WhatsApp Bot Pintar ketik *INFO* untuk Menggunakan Fitur Bot', '2025-03-13 14:48:14'),
(309, '6281918408597', 'cek status', 'Input Nomor Resi Untuk Cek Status Laundry Anda...', '2025-03-13 14:51:23'),
(310, '6281918408597', 'list laundry', '*Saat ini, tidak ada laundry yang sedang diproses atas nama* *Admin*.', '2025-03-13 14:51:44'),
(311, '6281918408597', 'list laundry', '*Saat ini, tidak ada laundry yang sedang diproses atas nama* *Admin*.', '2025-03-13 14:54:59'),
(312, '6285333640674', 'list laundry', '*Daftar List Laundry Anda*\n👤 *Nama:* tirta\n-------------------------------------------------------------\n📝 *No resi:* 671322025\n📅 *Tanggal:* 11-03-2025\n🕰️ *Jam:* 22:38:51\n💰 *Status Pembayaran:* Lunas\n🔄 *Status:* Selesai\n-------------------------------------------------------------\nℹ️ *Untuk cek detail laundry, silakan kirim nomor Resi.*', '2025-03-13 14:55:15'),
(313, '6285333640674', '671322025', 'Halo Kak *tirta* 😊\n\nlaundry Kakak dengan *Nomor Resi 671322025* Berikut detail pesanan:\n\n📅 *Tanggal*: 11-03-2025 \n🕰️ *Jam*: 22:38:51 \n🔄 *Status:* DiTerima\n\n🚚 *Tgl Diterima*: 12-03-2025 20:13:34\n\nTerima kasih sudah menggunakan layanan kami!\n', '2025-03-13 14:55:31'),
(314, '6281918408597', 'list laundry', '*Saat ini, tidak ada laundry yang sedang diproses atas nama* *Admin*.', '2025-03-13 15:01:52'),
(315, '6281918408597', 'cek status', 'Input Nomor Resi Untuk Cek Status Laundry Anda...', '2025-03-13 15:04:36'),
(316, '6281918408597', 'list laundry', '*Saat ini, tidak ada laundry yang sedang diproses atas nama* *Admin*.', '2025-03-13 15:06:29'),
(317, '6281918408597', 'list laundry', '*Saat ini, tidak ada laundry yang sedang diproses atas nama* *Admin*.', '2025-03-13 15:11:36'),
(318, '6281918408597', 'p', 'Selamat Sore *BAYU*, di WhatsApp Bot Pintar ketik *INFO* untuk Menggunakan Fitur Bot', '2025-03-13 15:13:12'),
(319, '6281918408597', 'list laundry', '*Saat ini, tidak ada laundry yang sedang diproses atas nama* *Admin*.', '2025-03-13 15:13:23'),
(320, '6281918408597', 'p', 'Selamat Sore *BAYU*, di WhatsApp Bot Pintar ketik *INFO* untuk Menggunakan Fitur Bot', '2025-03-13 15:15:11'),
(321, '6281918408597', 'p', 'Selamat Sore *BAYU*, di WhatsApp Bot Pintar ketik *INFO* untuk Menggunakan Fitur Bot', '2025-03-13 15:15:41'),
(322, '6281918408597', 'p', 'Selamat Sore *BAYU*, untuk mengetahui laundry yang sedang dalam proses, ketik *list laundry*. Untuk detail status laundry, ketik *cek status*.', '2025-03-13 15:19:40'),
(323, '6281918408597', 'p', 'Selamat Sore *BAYU*, untuk mengetahui laundry yang sedang dalam proses, silakan ketik *list laundry*. Jika ingin detail status laundry, silakan ketik *cek status*.', '2025-03-13 15:20:11'),
(324, '6281918408597', 'cek status', 'Input Nomor Resi Untuk Cek Status Laundry Anda...', '2025-03-13 15:20:25'),
(325, '6281918408597', 'list laundry', '*Saat ini, tidak ada laundry yang sedang diproses atas nama* *Admin*.', '2025-03-13 15:20:48'),
(326, '6281918408597', 'list laundry', '*Saat ini, tidak ada laundry yang sedang diproses atas nama* *Admin*.', '2025-03-13 15:32:34'),
(327, '6281918408597', 'p', 'Selamat Sore *BAYU*, untuk mengetahui laundry yang sedang dalam proses, silakan ketik *list laundry*. Jika ingin detail status laundry, silakan ketik *cek status*.', '2025-03-13 15:32:42'),
(328, '6281918408597', 'cek status', 'Input Nomor Resi Untuk Cek Status Laundry Anda...', '2025-03-13 15:33:02');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `username` varchar(225) NOT NULL,
  `password` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `username`, `password`) VALUES
(1, 'bayu', '12345');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user_access`
--

CREATE TABLE `user_access` (
  `id` int NOT NULL,
  `ip` varchar(225) DEFAULT NULL,
  `latitude` varchar(225) DEFAULT NULL,
  `longitude` varchar(225) DEFAULT NULL,
  `location` varchar(225) DEFAULT NULL,
  `update_at` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `user_access`
--

INSERT INTO `user_access` (`id`, `ip`, `latitude`, `longitude`, `location`, `update_at`) VALUES
(11, '::1', '1.3142556', '103.7093099', 'Jalan Buroh, Boon Lay, Southwest, Singapura, 619175, Singapura', '2025-02-21 23:34:28');

-- --------------------------------------------------------

--
-- Struktur dari tabel `webhook_urls`
--

CREATE TABLE `webhook_urls` (
  `id` int NOT NULL,
  `url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `web_url` varchar(255) DEFAULT NULL,
  `url_api` varchar(225) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `webhook_urls`
--

INSERT INTO `webhook_urls` (`id`, `url`, `web_url`, `url_api`, `updated_at`) VALUES
(26, 'http://localhost/laundry/public/api/webhook', 'http://localhost:3100', 'http://localhost/control_panel_wa', '2025-03-13 07:01:44');

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
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
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
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=329;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `user_access`
--
ALTER TABLE `user_access`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `webhook_urls`
--
ALTER TABLE `webhook_urls`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
