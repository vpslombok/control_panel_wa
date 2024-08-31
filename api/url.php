<?php
header('Content-Type: application/json');
include '../db.php';

// Menentukan metode HTTP yang digunakan
$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        // MENGIRIM DATA
        $sql = "SELECT * FROM webhook_urls";
        $result = mysqli_query($conn, $sql);
        $data = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }
        echo json_encode($data);
        break;

    case 'POST':
        // INPUT DATA
        $data = json_decode(file_get_contents('php://input'), true);
        if (!isset($data['url']) || !isset($data['web_url'])) {
            echo json_encode(['message' => 'Data tidak lengkap'], JSON_PRETTY_PRINT);
            http_response_code(400); // Bad Request
            break;
        }
        $sql = "INSERT INTO webhook_urls (url, web_url, updated_at) VALUES (?, ?, NOW()) ON DUPLICATE KEY UPDATE url = VALUES(url), web_url = VALUES(web_url), updated_at = VALUES(updated_at)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ss", $data['url'], $data['web_url']);
        if (!mysqli_stmt_execute($stmt)) {
            echo json_encode(['message' => 'Gagal menambahkan data'], JSON_PRETTY_PRINT);
            http_response_code(500); // Internal Server Error
            break;
        }
        echo json_encode(['message' => 'Data berhasil ditambahkan'], JSON_PRETTY_PRINT);
        http_response_code(201); // Created
        break;

    default:
        echo json_encode(['message' => 'Metode tidak diizinkan'], JSON_PRETTY_PRINT);
        http_response_code(405); // Method Not Allowed
        break;
}

// Mengatur zona waktu
date_default_timezone_set('Asia/Jakarta');

mysqli_close($conn);
?>
