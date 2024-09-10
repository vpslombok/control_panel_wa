<?php
// Koneksi database mysql online
// $host = 'bdeaoblcrmhzuzixz9lu-mysql.services.clever-cloud.com'; // Ganti dengan IP server MySQL
// $user = 'uaihieeeuy2yjzsi'; // Ganti dengan username MySQL Anda
// $password = 'aVw6FpQ2JcmOlbvLGWgt'; // Ganti dengan password MySQL Anda
// $dbname = 'bdeaoblcrmhzuzixz9lu';

// koneksi database localhost
// $host = 'localhost'; // Ganti dengan IP server MySQL
// $user = 'root'; // Ganti dengan username MySQL Anda
// $password = '123'; // Ganti dengan password MySQL Anda
// $dbname = 'whatsapp';

// koneksi database hosting
$host = '127.0.0.1'; // Ganti dengan IP server MySQL
$user = 'sasak920_bayu'; // Ganti dengan username MySQL Anda
$password = 'b+4RL)Hiwh=Y'; // Ganti dengan password MySQL Anda
$dbname = 'sasak920_wa';



// Membuat koneksi
$conn = new mysqli($host, $user, $password, $dbname);

// Mengatur zona waktu
date_default_timezone_set('Asia/Singapore');

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
