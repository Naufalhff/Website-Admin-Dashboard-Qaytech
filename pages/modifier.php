<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PERKIN</title>
  <link rel="stylesheet" href="../css/bootstrap.css">
  <link rel="stylesheet" href="../css/style.css">
</head>

<body>
  <?php
  session_start();
  include 'conixion.php';

  // Ambil nilai table_name dan no_peserta dari query string
  $table_name = isset($_GET['table_name']) ? $_GET['table_name'] : '';
  $no_peserta = isset($_GET['no_peserta']) ? $_GET['no_peserta'] : '';

  if (!empty($table_name) && !empty($no_peserta)) {
    // Simpan nilai table_name dan no_peserta dalam sesi
    $_SESSION["table_name"] = $table_name;
    $_SESSION["no_peserta"] = $no_peserta;

    // Query untuk mengambil data berdasarkan no_peserta
    $statement = $conn->prepare("SELECT * FROM `$table_name` WHERE no_peserta = :no_peserta");
    $statement->bindParam(':no_peserta', $no_peserta, PDO::PARAM_STR);
    try {
      $statement->execute();
      $table = $statement->fetch();
    } catch (PDOException $e) {
      echo "<div class='alert alert-danger'>Database error: " . $e->getMessage() . "</div>";
      exit;
    }
  } else {
    echo "<div class='alert alert-danger'>Table name or no_peserta not specified.</div>";
    exit;
  }
  ?>

  <div class="container w-50">
    <form method="POST" action="update.php" enctype="multipart/form-data">
      <div class="">
        <label for="recipient-name" class="col-form-label">Nama Anjing</label>
        <input type="text" class="form-control" id="recipient-name" name="nama_anjing"
          value="<?php echo htmlspecialchars($table['nama_anjing']); ?>">
      </div>
      <div class="">
        <label for="recipient-name" class="col-form-label">Nama Pemilik</label>
        <input type="text" class="form-control" id="recipient-name" name="nama_pemilik"
          value="<?php echo htmlspecialchars($table['nama_pemilik']); ?>">
      </div>
      <div class="">
        <label for="recipient-name" class="col-form-label">Handler</label>
        <input type="text" class="form-control" id="recipient-name" name="handler"
          value="<?php echo htmlspecialchars($table['handler']); ?>">
      </div>
      <div class="">
        <label for="recipient-name" class="col-form-label">Waktu Tempuh</label>
        <input type="text" class="form-control" id="recipient-name" name="waktu_tempuh"
          value="<?php echo htmlspecialchars($table['waktu_tempuh']); ?>">
      </div>
      <div class="">
        <label for="recipient-name" class="col-form-label">Fault</label>
        <input type="text" class="form-control" id="recipient-name" name="fault"
          value="<?php echo htmlspecialchars($table['fault']); ?>">
      </div>
      <div class="">
        <label for="recipient-name" class="col-form-label">Refusal</label>
        <input type="text" class="form-control" id="recipient-name" name="refusal"
          value="<?php echo htmlspecialchars($table['refusal']); ?>">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary"
          onclick="window.location.href='detailtabel.php?table_name=<?php echo urlencode($table_name); ?>'">
          Close
        </button>

        <button type="submit" name="submit" class="btn btn-primary">Update Data</button>
      </div>
    </form>
  </div>

  <script src="../js/script.js"></script>
  <script src="../js/bootstrap.bundle.js"></script>
</body>

</html>