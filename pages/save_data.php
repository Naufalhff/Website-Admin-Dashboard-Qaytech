<?php
session_start(); // Pastikan ini adalah baris pertama
include 'conixion.php'; // Pastikan file ini menginisialisasi koneksi PDO
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $table_name = isset($_POST['table_name']) ? $_POST['table_name'] : '';
    $no_peserta = isset($_POST['no_peserta']) ? $_POST['no_peserta'] : [];
    $timestamp = isset($_POST['timestamp']) ? $_POST['timestamp'] : [];
    $status = isset($_POST['status']) ? $_POST['status'] : [];
    $waktu_tempuh = isset($_POST['finish']) ? $_POST['finish'] : [];
    $fault = isset($_POST['fault']) ? $_POST['fault'] : [];
    $refusal = isset($_POST['refusal']) ? $_POST['refusal'] : [];
    $size = isset($_POST['size']) ? $_POST['size'] : [];
    $kelas = isset($_POST['kelas']) ? $_POST['kelas'] : [];
    $result = isset($_POST['result']) ? $_POST['result'] : [];
    $rangking = isset($_POST['rangking']) ? $_POST['rangking'] : [];

    if (isset($_POST['finish'])) {
        foreach ($_POST['finish'] as &$waktuTempuh) {
            $waktuTempuh = number_format((float) $waktuTempuh, 2, '.', '');
        }
    }

    if (empty($table_name) || !preg_match('/^[a-zA-Z0-9_]+$/', $table_name)) {
        echo json_encode(['success' => false, 'message' => 'Nama tabel tidak valid.']);
        exit;
    }

    $count = count($no_peserta);
    if ($count !== count($status) || $count !== count($timestamp) || $count !== count($waktu_tempuh) || $count !== count($fault) || $count !== count($refusal) || $count !== count($size) || $count !== count($kelas) || $count !== count($rangking)) {
        echo json_encode(['success' => false, 'message' => 'Jumlah elemen dalam array tidak sama.']);
        exit;
    }

    $data = [];
    for ($i = 0; $i < $count; $i++) {
        if (isset($no_peserta[$i]) && isset($timestamp[$i]) && isset($status[$i]) && isset($waktu_tempuh[$i]) && isset($fault[$i]) && isset($refusal[$i]) && isset($size[$i]) && isset($kelas[$i]) && isset($rangking[$i])) {
            $result = number_format((($fault[$i] + $refusal[$i]) * 5) + floatval($waktu_tempuh[$i]), 2, '.', '');
            $data[] = [
                'no_peserta' => $no_peserta[$i],
                'timestamp' => $timestamp[$i],
                'status' => $status[$i],
                'waktu_tempuh' => number_format(floatval($waktu_tempuh[$i]), 2, '.', ''),
                'fault' => floatval($fault[$i]),
                'refusal' => floatval($refusal[$i]),
                'size' => $size[$i],
                'kelas' => $kelas[$i],
                'result' => $result,
                'rangking' => $rangking[$i]
            ];
        } else {
            echo json_encode(['success' => false, 'message' => 'Data tidak valid untuk indeks ' . $i]);
            exit;
        }
    }

    $conn->beginTransaction();

    try {
        foreach ($data as $entry) {
            $sql = "UPDATE `$table_name` SET 
                    timestamp = :timestamp,
                    status = :status,
                    waktu_tempuh = :waktu_tempuh,
                    fault = :fault,
                    refusal = :refusal,
                    result = :result,
                    rangking = :rangking,
                    size = :size,
                    kelas = :kelas
                    WHERE no_peserta = :no_peserta";

            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':timestamp', $entry['timestamp']);
            $stmt->bindParam(':status', $entry['status']);
            $stmt->bindParam(':waktu_tempuh', $entry['waktu_tempuh']);
            $stmt->bindParam(':fault', $entry['fault'], PDO::PARAM_INT);
            $stmt->bindParam(':refusal', $entry['refusal'], PDO::PARAM_INT);
            $stmt->bindParam(':result', $entry['result'], PDO::PARAM_STR);
            $stmt->bindParam(':rangking', $entry['rangking'], PDO::PARAM_INT);
            $stmt->bindParam(':size', $entry['size']);
            $stmt->bindParam(':kelas', $entry['kelas']);
            $stmt->bindParam(':no_peserta', $entry['no_peserta']);

            if (!$stmt->execute()) {
                echo 'SQL Error: ' . implode(', ', $stmt->errorInfo());
                $conn->rollBack();
                exit;
            }
        }
        $conn->commit();
        echo json_encode(['success' => true, 'message' => 'Data berhasil disimpan.']);
    } catch (Exception $e) {
        $conn->rollBack();
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }

    $conn = null;
    exit;

}
echo "Data saved successfully";
?>