<?php
require_once ('koneksi.php');
$query1 = "select * from tbQay ";
$result = mysqli_query($conn, $query1);

$no = 1;
while ($data = mysqli_fetch_array($result)) {
  echo "<tr>"; // Start a new table row
  echo "<td>" . htmlspecialchars($data['waktu']) . "
  <input type=\"hidden\" name=\"timestamp[]\" value=\"" . htmlspecialchars($data['waktu']) . "\" />
</td>"; // Menampilkan 'Waktu Tempuh' dalam tabel dan menyimpan nilai untuk form submission

  echo "</tr>"; // End the table row
}
?>