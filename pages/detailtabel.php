<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PERKIN</title>
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"
        integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.5/xlsx.full.min.js"></script>
</head>

<body class="bg-content">
    <main class="dashboard d-flex">
        <!-- start sidebar -->
        <?php
        include "component/sidebar.php";

        ?>
        <!-- end sidebar -->

        <!-- start content page -->
        <div class="container-fluid px-4">
            <?php
            include "component/header.php";
            ?>


            <!-- start student list table -->
            <div class="student-list-header d-flex justify-content-between align-items-center py-2">
                <div class="title h6 fw-bold">Data</div>
                <div class="btn-add d-flex gap-3 align-items-center">
                    <div class="short">
                        <i class="far fa-sort"></i>
                    </div>

                    <?php include 'component/popupadd.php'; ?>

                </div>
            </div>
            <div class="table-responsive">
                <div id="searchResults" class="container mt-4">
                    <!-- Hasil pencarian akan muncul di sini -->
                </div>
                <!-- data tabel -->
                <div class="container mt-4">
                    <div class="table-responsive">

                        <?php
                        include 'conixion.php';

                        if (isset($_GET['table_name']) && !empty($_GET['table_name'])) {
                            $table_name = $_GET['table_name'];

                            try {
                                $result = $conn->query("SELECT * FROM `$table_name`");
                                if ($result->rowCount() > 0) {
                                    $data = $result->fetchAll(PDO::FETCH_ASSOC);

                                    if (count($data) > 1) {
                                        // Urutkan berdasarkan result dari terkecil ke terbesar untuk menentukan rangking
                                        usort($data, function ($a, $b) {
                                            return $a['result'] - $b['result'];
                                        });

                                        // Tetapkan rangking untuk semua peserta yang memiliki result > 0
                                        $rank = 1; // Inisialisasi peringkat awal
                                        foreach ($data as $key => $value) {
                                            if ($value['result'] > 0) {
                                                $data[$key]['rangking'] = $rank;
                                                $rank++;
                                            } else {
                                                $data[$key]['rangking'] = 'Belum ditetapkan';
                                            }
                                        }
                                    } else {
                                        // Tetapkan rangking untuk satu peserta jika result > 0
                                        if ($data[0]['result'] > 0) {
                                            $data[0]['rangking'] = 1;
                                        } else {
                                            $data[0]['rangking'] = 'Belum ditetapkan';
                                        }
                                    }

                                    ?>
                                    <form method="POST" action="">
                                        <button id="exportButton" class="btn btn-success">Export to Excel</button>
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
                                                    <?php foreach ($data as $value): ?>
                                                        <tr class="bg-white align-middle">
                                                            <td><?php echo htmlspecialchars($value['no_peserta']); ?></td>
                                                            <td><?php echo htmlspecialchars($value['timestamp']); ?></td>
                                                            <td><?php echo htmlspecialchars($value['nama_anjing']); ?></td>
                                                            <td><?php echo htmlspecialchars($value['nama_pemilik']); ?></td>
                                                            <td><?php echo htmlspecialchars($value['handler']); ?></td>
                                                            <td><?php echo htmlspecialchars($value['size']); ?></td>
                                                            <td><?php echo htmlspecialchars($value['kelas']); ?></td>
                                                            <td><?php echo htmlspecialchars($value['status']); ?></td>
                                                            <td>
                                                                <?php echo htmlspecialchars(number_format((float) $value['waktu_tempuh'], 2)); ?>
                                                            </td>
                                                            <td><?php echo htmlspecialchars($value['fault']); ?></td>
                                                            <td><?php echo htmlspecialchars($value['refusal']); ?></td>
                                                            <td><?php
                                                            $fault = floatval($value['fault']); // Menggunakan floatval untuk memastikan tipe float
                                                            $refusal = floatval($value['refusal']); // Menggunakan floatval untuk memastikan tipe float
                                            
                                                            $result = (($fault + $refusal) * 5) + $value['waktu_tempuh'];
                                                            ?><?php echo htmlspecialchars(number_format($result, 2)); ?>
                                                            </td>
                                                            <td><?php echo htmlspecialchars($value['rangking']); ?></td>
                                                            <td><input type="radio" name="selected_items"
                                                                    value="<?php echo htmlspecialchars($value['no_peserta']); ?>"></td>
                                                            <td class="d-md-flex gap-3 mt-3">
                                                                <a
                                                                    href="modifier.php?no_peserta=<?php echo htmlspecialchars($value['no_peserta']); ?>&table_name=<?php echo htmlspecialchars($table_name); ?>"><i
                                                                        class="far fa-pen"></i></a>
                                                                <a
                                                                    href="remove.php?table_name=<?php echo htmlspecialchars($table_name); ?>&no_peserta=<?php echo htmlspecialchars($value['no_peserta']); ?>"><i
                                                                        class="far fa-trash"></i></a>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                                    </form>
                                    <?php
                                } else {
                                    echo "<div class='alert alert-warning'>Tidak ada data di tabel $table_name.</div>";
                                }
                            } catch (PDOException $e) {
                                echo "<div class='alert alert-danger'>Tidak bisa mendapatkan data dari tabel $table_name: " . $e->getMessage() . "</div>";
                            }
                        }
                        ?>
                    </div>
                </div>

                <!-- List item yang dipilih -->
                <?php

                if (isset($_POST['submit'])) {
                    if (isset($_POST['selected_items']) && !empty($_POST['selected_items'])) {
                        $selected_ids = [$_POST['selected_items']]; // Wrap in an array
                        if (!empty($selected_ids)) {
                            // Query untuk mendapatkan detail item yang dipilih
                            $placeholders = implode(',', array_fill(0, count($selected_ids), '?'));
                            $stmt = $conn->prepare("SELECT * FROM `$table_name` WHERE no_peserta IN ($placeholders)");
                            $stmt->execute($selected_ids);
                            $selected_items = $stmt->fetchAll(PDO::FETCH_ASSOC);

                            if (!empty($selected_items)):
                                ?>
                                <div class="student-list-header d-flex justify-content-between align-items-center py-3">
                                    <div class="title h6 fw-bold">List Data yang Dipilih</div>
                                </div>

                                <form id="dataForm" action="save_data.php" method="POST">
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

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($selected_items as $item): ?>
                                                <tr class="bg-white align-middle">
                                                    <td>
                                                        <input type="hidden" name="no_peserta[]"
                                                            value="<?= htmlspecialchars($item['no_peserta']); ?>">
                                                        <input type="hidden" name="table_name"
                                                            value="<?= htmlspecialchars($table_name); ?>">
                                                        <?= htmlspecialchars($item['no_peserta']); ?>
                                                    </td>
                                                    <td id="c4ytable">
                                                        <?php
                                                        require_once ('koneksi.php');
                                                        $query1 = "SELECT waktu FROM tbQay"; // Adjust the query to select the 'waktu' column
                                                        $result = mysqli_query($conn, $query1);
                                                        $timestampValue = 100; // Default value
                                                        if ($row = mysqli_fetch_assoc($result)) {
                                                            $timestampValue = $row['waktu']; // Get the 'waktu' value from the database
                                                        }
                                                        ?>
                                                        <input type="hidden" name="timestamp[]"
                                                            value="<?= htmlspecialchars($timestampValue); ?>">
                                                        <?= htmlspecialchars($timestampValue); ?>
                                                    </td>
                                                    <td><?= htmlspecialchars($item['nama_anjing']); ?></td>
                                                    <td><?= htmlspecialchars($item['nama_pemilik']); ?></td>
                                                    <td><?= htmlspecialchars($item['handler']); ?></td>
                                                    <td>
                                                        <select name="size[]" class="form-control">
                                                            <option value="small" <?= $item['size'] == 'small' ? 'selected' : ''; ?>>Small
                                                            </option>
                                                            <option value="medium" <?= $item['size'] == 'medium' ? 'selected' : ''; ?>>
                                                                Medium
                                                            </option>
                                                            <option value="intermediate" <?= $item['size'] == 'intermediate' ? 'selected' : ''; ?>>Intermediate</option>
                                                            <option value="large" <?= $item['size'] == 'large' ? 'selected' : ''; ?>>Large
                                                            </option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <select name="kelas[]" class="form-control">
                                                            <option value="FA1" <?= $item['kelas'] == 'FA1' ? 'selected' : ''; ?>>FA1
                                                            </option>
                                                            <option value="FA2" <?= $item['kelas'] == 'FA2' ? 'selected' : ''; ?>>FA2
                                                            </option>
                                                            <option value="J1" <?= $item['kelas'] == 'J1' ? 'selected' : ''; ?>>J1</option>
                                                            <option value="J2" <?= $item['kelas'] == 'J2' ? 'selected' : ''; ?>>J2</option>
                                                            <option value="J3" <?= $item['kelas'] == 'J3' ? 'selected' : ''; ?>>J3</option>
                                                            <option value="A1" <?= $item['kelas'] == 'A1' ? 'selected' : ''; ?>>A1</option>
                                                            <option value="A2" <?= $item['kelas'] == 'A2' ? 'selected' : ''; ?>>A2</option>
                                                            <option value="A3" <?= $item['kelas'] == 'A3' ? 'selected' : ''; ?>>A3</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <select name="status[]" class="form-control">
                                                            <option value="finish" <?= $item['status'] == 'finish' ? 'selected' : ''; ?>>Finish
                                                            </option>
                                                            <option value="diskualifikasi" <?= $item['status'] == 'diskualifikasi' ? 'selected' : ''; ?>>Diskualifikasi</option>
                                                            <option value="eliminasi" <?= $item['status'] == 'eliminasi' ? 'selected' : ''; ?>>
                                                                Eliminasi</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <div id="c3ytable">
                                                            <?php
                                                            require_once ('koneksi.php');
                                                            $query1 = "SELECT data FROM tbQay"; // Adjust the query to select the 'data' column
                                                            $result = mysqli_query($conn, $query1);
                                                            $finishValue = 100; // Default value
                                                            if ($row = mysqli_fetch_assoc($result)) {
                                                                $finishValue = $row['data']; // Get the 'data' value from the database
                                                            } else {
                                                                // Jika tidak ada data, tetap gunakan nilai default
                                                                error_log('Tidak ada data untuk finishValue, menggunakan default: ' . $finishValue);
                                                            }
                                                            ?>
                                                            <input type="text" name="finish[]" class="form-control" rows="1"
                                                                value="<?= htmlspecialchars($finishValue); ?>">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <input type="number" name="fault[]" class="form-control"
                                                            value="<?= htmlspecialchars($item['fault']); ?>" min="0">
                                                    </td>
                                                    <td>
                                                        <input type="number" name="refusal[]" class="form-control"
                                                            value="<?= htmlspecialchars($item['refusal']); ?>" min="0">
                                                    </td>
                                                    <td>
                                                        <?php
                                                        $fault = floatval($item['fault']);
                                                        $refusal = floatval($item['refusal']);
                                                        $result = (($fault + $refusal) * 5) + $item['waktu_tempuh'];
                                                        ?>

                                                        <!-- Menyimpan waktu_tempuh -->
                                                        <input type="hidden" name="result[]"
                                                            value="<?= htmlspecialchars(number_format($result, 2)); ?>">
                                                        <?= htmlspecialchars(number_format($result, 2)); ?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                        $no_peserta = $item['no_peserta'];
                                                        $rankingValue = 'Belum ditetapkan';
                                                        foreach ($data as $dataItem) {
                                                            if ($dataItem['no_peserta'] === $no_peserta) {
                                                                $rankingValue = $dataItem['rangking'];
                                                                break;
                                                            }
                                                        }
                                                        ?>
                                                        <input type="hidden" name="rangking[]"
                                                            value="<?= htmlspecialchars($rankingValue); ?>">

                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                    <button type="submit" name="submit" class="btn btn-primary d-flex justify-content-end"
                                        style="margin-bottom: 5px;">Save Data</button>
                                </form>
                                <?php
                            endif;
                        }
                    } else {
                        echo "<div class='alert alert-warning'>Tidak ada item yang dipilih.</div>";
                    }
                }
                ?>

                <!-- end student list table -->
            </div>
            <!-- end content page -->

            <!-- Success Modal -->
            <div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="successModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="successModalLabel">Data Berhasil Disimpan!</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            Data Anda telah berhasil disimpan ke database.
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" onclick="history.back()">Close</button>
                            <button type="button" class="btn btn-primary" id="okButton">Oke</button>
                        </div>
                    </div>
                </div>
            </div>
    </main>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="../js/script.js"></script>
    <script src="../js/bootstrap.bundle.js"></script>
    <script>
        document.getElementById("exportButton").addEventListener("click", function () {
            var table = document.querySelector(".student_list");
            var rows = Array.from(table.rows);
            var csvContent = "data:text/csv;charset=utf-8,";

            rows.forEach(function (row) {
                var cols = Array.from(row.querySelectorAll("td, th"));
                var rowData = cols
                    .map(function (col) {
                        // Mengganti koma dengan kosong untuk menghindari masalah pemisahan
                        return '"' + col.innerText.replace(/"/g, '""') + '"'; // Menggunakan tanda kutip untuk menghindari masalah
                    })
                    .join(";"); // Menggunakan titik koma sebagai pemisah
                csvContent += rowData + "\r\n"; // Tambahkan baris ke konten CSV
            });

            var encodedUri = encodeURI(csvContent);
            var link = document.createElement("a");
            link.setAttribute("href", encodedUri);
            link.setAttribute("download", "data_export.csv"); // Tetap menggunakan .csv untuk kompatibilitas
            document.body.appendChild(link); // Dapatkan link ke dalam dokumen

            link.click(); // Klik link untuk mengunduh
            document.body.removeChild(link); // Hapus link setelah mengunduh
        });
    </script>


</body>

</html>