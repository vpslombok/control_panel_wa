<?php
// Koneksi database mysql online
$host = 'bdeaoblcrmhzuzixz9lu-mysql.services.clever-cloud.com'; // Ganti dengan IP server MySQL
$user = 'uaihieeeuy2yjzsi'; // Ganti dengan username MySQL Anda
$password = 'aVw6FpQ2JcmOlbvLGWgt'; // Ganti dengan password MySQL Anda
$dbname = 'bdeaoblcrmhzuzixz9lu';

// koneksi database localhost
// $host = 'localhost'; // Ganti dengan IP server MySQL
// $user = 'root'; // Ganti dengan username MySQL Anda
// $password = '123'; // Ganti dengan password MySQL Anda
// $dbname = 'whatsapp';

// koneksi database hosting
// $host = 'sql106.infinityfree.com'; // Ganti dengan IP server MySQL
// $user = 'if0_37178437'; // Ganti dengan username MySQL Anda
// $password = 'jvKcB2Xh8iZC'; // Ganti dengan password MySQL Anda
// $dbname = 'if0_37178437_whatsapp';



// Membuat koneksi
$conn = new mysqli($host, $user, $password, $dbname);

// Mengatur zona waktu
date_default_timezone_set('Asia/Jakarta');

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
