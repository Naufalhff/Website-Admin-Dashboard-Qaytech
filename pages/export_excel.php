<?php
include 'conixion.php'; // Pastikan ini menginisialisasi koneksi PDO

if (isset($_GET['table_name']) && !empty($_GET['table_name'])) {
    $table_name = $_GET['table_name'];

    // Mengambil data dari tabel
    $stmt = $conn->prepare("SELECT * FROM `$table_name`");
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Mengatur header untuk file Excel
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment; filename="data_export.xls"');

    // Menampilkan data dalam format tabel
    echo "<table border='1'>";
    echo "<tr>
            <th>No Peserta</th>
            <th>Timestamp</th>
            <th>Nama Anjing</th>
            <th>Nama Pemilik</th>
            <th>Handler</th>
            <th>Size</th>
            <th>Kelas</th>
            <th>Status</th>
            <th>Waktu Tempuh</th>
            <th>Fault</th>
            <th>Refusal</th>
            <th>Result</th>
            <th>Rangking</th>
          </tr>";

    foreach ($data as $row) {
        echo "<tr>
                <td>" . htmlspecialchars($row['no_peserta']) . "</td>
                <td>" . htmlspecialchars($row['timestamp']) . "</td>
                <td>" . htmlspecialchars($row['nama_anjing']) . "</td>
                <td>" . htmlspecialchars($row['nama_pemilik']) . "</td>
                <td>" . htmlspecialchars($row['handler']) . "</td>
                <td>" . htmlspecialchars($row['size']) . "</td>
                <td>" . htmlspecialchars($row['kelas']) . "</td>
                <td>" . htmlspecialchars($row['status']) . "</td>
                <td>" . htmlspecialchars(number_format((float) $row['waktu_tempuh'], 2)) . "</td>
                <td>" . htmlspecialchars($row['fault']) . "</td>
                <td>" . htmlspecialchars($row['refusal']) . "</td>
                <td>" . htmlspecialchars(number_format((($row['fault'] + $row['refusal']) * 5) + $row['waktu_tempuh'], 2)) . "</td>
                <td>" . htmlspecialchars($row['rangking']) . "</td>
              </tr>";
    }

    echo "</table>";
    exit;
}
?>