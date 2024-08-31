<?php
header('Content-Type: application/json');
include '../db.php';

// Menentukan metode HTTP yang digunakan
$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        // MENGIRIM DATA
        $sql = "SELECT * FROM reply";
        $result = mysqli_query($conn, $sql);
        $data = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }
        echo json_encode($data);
        break;
}

// Mengatur zona waktu
date_default_timezone_set('Asia/Jakarta');

mysqli_close($conn);
?>
