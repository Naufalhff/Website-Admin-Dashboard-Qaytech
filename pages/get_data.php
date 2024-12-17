<?php
require_once ('koneksi.php');
$query1 = "select * from tbQay ";
$result = mysqli_query($conn, $query1);


$no = 1;
while ($data = mysqli_fetch_array($result)) {
    echo "<tr>"; // Start a new table row

    echo "<td><input type=\"text\" name=\"finish[]\" class=\"form-control\" rows=\"1\" 
        value=\"" . htmlspecialchars($data['data']) . "\" /></td>"; // Textbox untuk 'Waktu Tempuh'

    echo "</tr>"; // End the table row
}
?>