<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Qaytech</title>
  <link rel="stylesheet" href="../css/bootstrap.css">
  <link rel="stylesheet" href="../css/style.css">
  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"
    integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
  <div class="button-add-student">
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal"
      data-bs-whatever="@mdo">Tambah Data</button>
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Tambah Data</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form id="addStudentForm" method="POST" enctype="multipart/form-data">
              <div class="">
                <label for="recipient-name" class="col-form-label">Nama Anjing:</label>
                <input type="text" class="form-control" id="recipient-name" name="nama_anjing">
              </div>
              <div class="">
                <label for="recipient-name" class="col-form-label">Nama Pemilik:</label>
                <input type="text" class="form-control" id="recipient-name" name="nama_pemilik">
              </div>
              <div class="">
                <label for="recipient-name" class="col-form-label">Handler</label>
                <input type="text" class="form-control" id="recipient-name" name="handler">
              </div>
              <div class="mb-3">
                <label for="event-select" class="col-form-label">Pilih Event:</label>
                <select class="form-select" id="event-select" name="event">
                  <?php
                  // Koneksi ke database
                  $conn = new mysqli('localhost', 'root', '', 'qaytech');

                  // Periksa koneksi
                  if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                  }

                  // Ambil daftar tabel
                  $result = $conn->query("SHOW TABLES");

                  // Tampilkan setiap tabel di dalam dropdown
                  if ($result->num_rows > 0) {
                    while ($row = $result->fetch_array()) {
                      $table_name = $row[0];
                      if ($table_name !== 'login') { // Kecualikan tabel 'login'
                        echo "<option value=\"$table_name\">$table_name</option>";
                      }
                    }
                  } else {
                    echo "<option value=\"\">No tables found</option>";
                  }

                  // Tutup koneksi
                  $conn->close();
                  ?>
                </select>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" name="submit" class="btn btn-primary">Tambah Data</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

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
          <button type="button" class="btn btn-primary" id="okButton">Oke</button>
        </div>
      </div>
    </div>
  </div>

  <script>
    $(document).ready(function () {
      $('#addStudentForm').submit(function (e) {
        e.preventDefault(); // Mencegah pengiriman formulir secara default

        var formData = new FormData(this);

        $.ajax({
          type: 'POST',
          url: 'addstudent.php', // URL untuk addstudent.php
          data: formData,
          processData: false,
          contentType: false,
          dataType: 'json',
          success: function (response) {
            if (response.status === 'success') {
              // Tampilkan modal sukses
              $('#successModal').modal('show');
            } else {
              alert('Terjadi kesalahan saat menyimpan data: ' + response.message);
            }
          },
          error: function (xhr, status, error) {
            console.log(xhr.responseText); // Debug: log error response
            alert('Terjadi kesalahan saat menyimpan data: ' + error);
          }
        });
      });

      // Handle modal "Oke" button click
      $('#okButton').click(function () {
        $('#successModal').modal('hide');
        // Opsional: Refresh halaman atau melakukan tindakan lain setelah modal ditutup
        location.reload(); // Refresh halaman
      });
    });
  </script>

</body>

</html>