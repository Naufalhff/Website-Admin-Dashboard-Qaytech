<?php
include 'conixion.php';
header('Content-Type: application/json');

$response = array();

if (isset($_POST['nama_anjing']) && isset($_POST['nama_pemilik']) && isset($_POST['handler']) && isset($_POST['event'])) {
    $nama_anjing = $_POST['nama_anjing'];
    $nama_pemilik = $_POST['nama_pemilik'];
    $handler = $_POST['handler'];
    $event = $_POST['event'];

    // Buat query dengan tabel yang sesuai
    $sql = "INSERT INTO `$event` (nama_anjing, nama_pemilik, handler) VALUES (:nama_anjing, :nama_pemilik, :handler)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':nama_anjing', $nama_anjing);
    $stmt->bindParam(':nama_pemilik', $nama_pemilik);
    $stmt->bindParam(':handler', $handler);

    if ($stmt->execute()) {
        $response['status'] = 'success';
        $response['message'] = "Data berhasil ditambahkan ke tabel $event";
    } else {
        $response['status'] = 'error';
        $response['message'] = "Error: " . $stmt->errorInfo()[2];
    }

    // Tutup koneksi
    $conn = null;
} else {
    $response['status'] = 'error';
    $response['message'] = 'Invalid request';
}

echo json_encode($response);
?>