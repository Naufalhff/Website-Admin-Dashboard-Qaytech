<?php
include 'conixion.php';

$table_name = isset($_GET['table_name']) ? $_GET['table_name'] : '';
$no_peserta = isset($_GET['no_peserta']) ? $_GET['no_peserta'] : '';

if (!empty($table_name) && !empty($no_peserta)) {
    try {
        $stmt = $conn->prepare("DELETE FROM `$table_name` WHERE no_peserta = :no_peserta");
        $stmt->bindParam(':no_peserta', $no_peserta, PDO::PARAM_STR);
        $stmt->execute();

        header('Location: detailtabel.php?table_name=' . urlencode($table_name));
        exit;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Table name or no_peserta not specified.";
}
?>