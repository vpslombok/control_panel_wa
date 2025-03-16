<?php

// Pastikan file .env ada di direktori yang sama dengan db.php
$env = parse_ini_file(__DIR__ . '/.env');

$host = $env['DB_HOST']; // IP server MySQL dari .env
$user = $env['DB_USER']; // Username MySQL dari .env
$password = $env['DB_PASSWORD']; // Password MySQL dari .env
$dbname = $env['DB_NAME']; // Nama database dari .env

// Membuat koneksi
$conn = new mysqli($host, $user, $password, $dbname);

// Mengatur zona waktu dari .env
date_default_timezone_set($env['TIME_ZONE']);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}


