<?php
session_start();
include 'conixion.php';

// Ambil table_name dari sesi atau GET
$table_name = isset($_SESSION['table_name']) ? $_SESSION['table_name'] : (isset($_GET['table_name']) ? $_GET['table_name'] : '');

// Pastikan table_name tidak kosong
if (empty($table_name)) {
    echo "<div class='alert alert-danger'>Table name not specified.</div>";
    exit;
}

// Pastikan no_peserta diset dalam sesi
if (!isset($_SESSION['no_peserta'])) {
    echo "<div class='alert alert-danger'>No Peserta not set in session.</div>";
    exit;
}

$no_peserta = $_SESSION['no_peserta'];

if (isset($_POST['submit'])) {
    $nama_anjing = $_POST['nama_anjing'];
    $nama_pemilik = $_POST['nama_pemilik'];
    $handler = $_POST['handler'];
    $waktu_tempuh = $_POST['waktu_tempuh'];
    $fault = $_POST['fault'];
    $refusal = $_POST['refusal'];

    // Gunakan parameter binding untuk mencegah SQL injection
    $requete = $conn->prepare("UPDATE `$table_name` 
        SET nama_anjing = :nama_anjing,
            nama_pemilik = :nama_pemilik,
            handler = :handler,
            waktu_tempuh = :waktu_tempuh,
            fault = :fault,
            refusal = :refusal
        WHERE no_peserta = :no_peserta");
    $requete->bindParam(':nama_anjing', $nama_anjing, PDO::PARAM_STR);
    $requete->bindParam(':nama_pemilik', $nama_pemilik, PDO::PARAM_STR);
    $requete->bindParam('handler', $handler, PDO::PARAM_STR);
    $requete->bindParam('waktu_tempuh', $waktu_tempuh, PDO::PARAM_STR);
    $requete->bindParam('fault', $fault, PDO::PARAM_INT);
    $requete->bindParam('refusal', $refusal, PDO::PARAM_INT);
    $requete->bindParam(':no_peserta', $no_peserta, PDO::PARAM_STR);

    try {
        if ($requete->execute()) {
            header("Location: detailtabel.php?table_name=" . urlencode($table_name));
            exit;
        } else {
            echo "<div class='alert alert-danger'>Failed to update record.</div>";
        }
    } catch (PDOException $e) {
        echo "<div class='alert alert-danger'>Database error: " . $e->getMessage() . "</div>";
    }
}
?>