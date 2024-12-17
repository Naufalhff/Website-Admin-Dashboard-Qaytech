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
      <!-- start student list table -->
      <div class="student-list-header d-flex justify-content-between align-items-center py-2">
        <div class="title h6 fw-bold">Kategori</div>
        <div class="btn-add d-flex gap-3 align-items-center">
          <div class="d-flex justify-content-end mt-3">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal"
              data-bs-whatever="@mdo">Tambah Kategori</button>
          </div>
        </div>
      </div>
      <div class="button-add-student">

        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Kategori</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <form method="POST" action="" enctype="multipart/form-data">

                  <div class="">
                    <label for="event_name">Nama Kategori:</label>
                    <input type="text" id="event_name" name="event_name" required>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" name="create_event" class="btn btn-primary">Tambah Kategori</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="courses">
        <table class="table table-responsive">
          <tbody>
            <?php
            if (isset($_POST['create_event'])) {
              $event_name = $_POST['event_name'];

              // Koneksi ke database
              include 'conixion.php';

              // Buat nama tabel yang aman dengan menghapus karakter yang tidak diizinkan
              $event_name_safe = preg_replace("/[^a-zA-Z0-9_]/", "", $event_name);

              try {
                // Buat tabel dengan kolom AUTO_INCREMENT
                $sql = "CREATE TABLE IF NOT EXISTS `$event_name_safe` (
                no_peserta INT AUTO_INCREMENT PRIMARY KEY,
                timestamp TIME NULL DEFAULT NULL,
                nama_anjing VARCHAR(255) NOT NULL,
                nama_pemilik VARCHAR(255) NOT NULL,
                handler VARCHAR(255) NOT NULL,
                size VARCHAR(255) NOT NULL,
                kelas VARCHAR(255) NOT NULL,
                status VARCHAR(255) NOT NULL,
                waktu_tempuh DECIMAL(10, 2) NOT NULL,
                fault INT NOT NULL,
                refusal INT NOT NULL,
                result DECIMAL(10, 2) NOT NULL,
                rangking INT NOT NULL
                )";
                $conn->exec($sql);

              } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
              }

              // Tutup koneksi
              $conn = null;
            }
            ?>


          </tbody>
        </table>


        <div class="container mt-2">
          <h2 class="mb-4">Daftar Kategori</h2>
          <table class="table table-striped table-bordered table-hover">
            <thead class="thead-dark">
              <tr>
                <th>Nama Kategori</th>
              </tr>
            </thead>
            <tbody>
              <?php
              include "conixion.php"; // Pastikan koneksi database sudah benar
              
              // Query untuk mendapatkan nama tabel
              $sql = "SHOW TABLES";
              $result = $conn->query($sql);

              if ($result) {
                $tables = $result->fetchAll(PDO::FETCH_COLUMN);

                if (count($tables) > 0) {
                  foreach ($tables as $table_name) {
                    if ($table_name !== 'login') { // Ganti 'login' dengan nama tabel yang ingin Anda kecualikan
                      echo "<tr><td>" . htmlspecialchars($table_name) . "</td></tr>";
                    }
                  }
                } else {
                  echo "<tr><td colspan='1' class='text-center'>Tidak ada tabel ditemukan</td></tr>";
                }
              } else {
                echo "<tr><td colspan='1' class='text-center'>Terjadi kesalahan saat mengambil data</td></tr>";
              }
              ?>
            </tbody>
          </table>
        </div>

      </div>

    </div>

    </div>
    <!-- end content page -->
  </main>

  <script src="../js/script.js"></script>
  <script src="../js/bootstrap.bundle.js"></script>
</body>

</html>