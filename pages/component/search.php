<?php
include '../conixion.php';

$response = array();
$table_name = isset($_GET['table_name']) ? $_GET['table_name'] : '';
$nama_anjing = isset($_GET['nama_anjing']) ? $_GET['nama_anjing'] : '';

if (!empty($table_name) && !empty($nama_anjing)) {
    try {
        // Sanitasi nama tabel untuk mencegah SQL Injection
        $table_name = preg_replace('/[^a-zA-Z0-9_]/', '', $table_name);

        // Cek tabel di database
        $checkTable = $conn->prepare("SHOW TABLES LIKE ?");
        $checkTable->execute([$table_name]);
        if ($checkTable->rowCount() == 0) {
            throw new Exception('Tabel tidak ditemukan');
        }

        // Cek kolom dalam tabel
        $checkColumns = $conn->prepare("SHOW COLUMNS FROM `$table_name` LIKE 'nama_anjing'");
        $checkColumns->execute();
        if ($checkColumns->rowCount() == 0) {
            throw new Exception('Kolom "nama_anjing" tidak ditemukan di tabel ' . htmlspecialchars($table_name));
        }

        // Query untuk mencari berdasarkan nama_anjing
        $stmt = $conn->prepare("SELECT * FROM `$table_name` WHERE nama_anjing = ?");
        $stmt->execute([$nama_anjing]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            // Jika data ditemukan, buat tabel hasil pencarian
            $response['status'] = 'success';
            ob_start(); // Mulai output buffering
            ?>
            <h3>Hasil Pencarian</h3>
            <form method="POST" action="">
                <div class="table-container">
                    <table class="table student_list table-borderless">
                        <thead>
                            <tr class="align-middle">
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
                                <th>Pilihan</th>
                                <th>Aksi</th>
                                <th class="opacity-0">list</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="bg-white align-middle">
                                <td><?php echo htmlspecialchars($result['no_peserta']); ?></td>
                                <td><?php echo htmlspecialchars($result['timestamp']); ?></td>
                                <td><?php echo htmlspecialchars($result['nama_anjing']); ?></td>
                                <td><?php echo htmlspecialchars($result['nama_pemilik']); ?></td>
                                <td><?php echo htmlspecialchars($result['handler']); ?></td>
                                <td><?php echo htmlspecialchars($result['size']); ?></td>
                                <td><?php echo htmlspecialchars($result['kelas']); ?></td>
                                <td><?php echo htmlspecialchars($result['status']); ?></td>
                                <td>
                                    <?php echo htmlspecialchars(number_format((float) $result['waktu_tempuh'], 2)); ?>
                                </td>
                                <td><?php echo htmlspecialchars($result['fault']); ?></td>
                                <td><?php echo htmlspecialchars($result['refusal']); ?></td>
                                <td><?php
                                $fault = floatval($result['fault']); // Menggunakan floatval untuk memastikan tipe float
                                $refusal = floatval($result['refusal']); // Menggunakan floatval untuk memastikan tipe float
                    
                                $calculated_result = (($fault + $refusal) * 5) + $result['waktu_tempuh'];
                                ?><?php echo htmlspecialchars(number_format($calculated_result, 2)); ?>
                                </td>
                                <td><?php echo htmlspecialchars($result['rangking']); ?></td>
                                <td><input type="radio" name="selected_items"
                                        value="<?php echo htmlspecialchars($result['no_peserta']); ?>"></td>
                                <td class="d-md-flex gap-3 mt-3">
                                    <a
                                        href="modifier.php?no_peserta=<?php echo htmlspecialchars($result['no_peserta']); ?>&table_name=<?php echo htmlspecialchars($table_name); ?>"><i
                                            class="far fa-pen"></i></a>
                                    <a
                                        href="remove.php?table_name=<?php echo htmlspecialchars($table_name); ?>&no_peserta=<?php echo htmlspecialchars($result['no_peserta']); ?>"><i
                                            class="far fa-trash"></i></a>
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>
                <button type="submit" name="submit" class="btn btn-primary">Submit</button>
            </form>
            <?php
            $response['html'] = ob_get_clean(); // Simpan output buffered ke dalam respons HTML
        } else {
            // Jika data tidak ditemukan
            $response['status'] = 'error';
            $response['message'] = 'Data tidak ditemukan';
        }
    } catch (PDOException $e) {
        $response['status'] = 'error';
        $response['message'] = 'Terjadi kesalahan: ' . $e->getMessage();
    } catch (Exception $e) {
        $response['status'] = 'error';
        $response['message'] = $e->getMessage();
    }
    $conn = null;
} else {
    $response['status'] = 'error';
    $response['message'] = 'Nama tabel atau Nama Anjing tidak diberikan';
}

// Jika ada HTML dalam respons, kirimkan HTML tersebut
if (isset($response['html'])) {
    echo $response['html'];
} else {
    // Jika ada pesan error, kirimkan pesan error dalam format HTML
    echo '<div class="alert alert-warning">' . htmlspecialchars($response['message']) . '</div>';
}
?>