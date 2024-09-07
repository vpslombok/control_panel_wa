<?php
include '../db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    if (isset($data['latitude']) && isset($data['longitude']) && isset($data['locationName']) && isset($data['update_at'])) {
        $latitude = $data['latitude'];
        $longitude = $data['longitude'];
        $userIP = $_SERVER['REMOTE_ADDR'];
        $location = $data['locationName'];
        $update_at = $data['update_at'];

        // Cek apakah userIP sudah ada dalam database
        $checkStmt = $conn->prepare("SELECT * FROM user_access WHERE ip = ?");
        $checkStmt->bind_param("s", $userIP);
        $checkStmt->execute();
        $result = $checkStmt->get_result();
        $checkStmt->close();

        if ($result->num_rows > 0) {
            // Jika userIP sudah ada, maka update latitude, longitude, dan location
            $updateStmt = $conn->prepare("UPDATE user_access SET latitude = ?, longitude = ?, location = ?, update_at = ? WHERE ip = ?");
            $updateStmt->bind_param("sssss", $latitude, $longitude, $location, $update_at, $userIP);
            $updateStmt->execute();
            $updateStmt->close();

            echo json_encode(['status' => 'success', 'message' => 'Lokasi berhasil diupdate']);
        } else {
            // Jika userIP belum ada, maka insert baru dengan locationName
            $insertStmt = $conn->prepare("INSERT INTO user_access (ip, latitude, longitude, location, update_at) VALUES (?, ?, ?, ?, ?)");
            $insertStmt->bind_param("sssss", $userIP, $latitude, $longitude, $location, $update_at);
            $insertStmt->execute();
            $insertStmt->close();

            echo json_encode(['status' => 'success', 'message' => 'Lokasi berhasil ditambahkan']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid data']);
    }
}
?>
