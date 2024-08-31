<?php
header('Content-Type: application/json');
include '../db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $number = $data['number'];
    $message = $data['message'];

    // Simpan data ke database
    $sql = "INSERT INTO sent_messages (number, message, tanggal) VALUES (?, ?, NOW())";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ss", $number, $message);
    if (!mysqli_stmt_execute($stmt)) {
        $response = array('status' => 'error', 'message' => 'Gagal mengirim pesan');
        echo json_encode($response);
    } else {
        $response = array('status' => 'success', 'message' => 'Pesan berhasil di simpan ke database');
        echo json_encode($response);
    }
} else {
    $response = array('status' => 'error', 'message' => 'Metode tidak diizinkan');
    echo json_encode($response);
}
