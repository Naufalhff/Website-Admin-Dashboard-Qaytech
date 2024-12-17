<?php
include "koneksi.php";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $database);
// Check connection
if ($conn->connect_error) {
    die("Database Connection failed: " . $conn->connect_error);
}

//Get current date and time
date_default_timezone_set('Asia/Jakarta');
$seminggu = array("Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu");
$hari = date("w");
$hari_ini = $seminggu[$hari];
//$d = date("Y-m-d");
$tgl_sekarang = date("ymd");
//echo " Date:".$d."<BR>";
$jam_sekarang = date("H:i:s");

if (!empty($_POST['status1']) && !empty($_POST['status2']) && !empty($_POST['nama'])) {
    $status1 = $_POST['status1'];
    $status2 = $_POST['status2'];
    $nama = $_POST['nama'];

    $sql = "UPDATE tbQay SET 
                tanggal = '" . $tgl_sekarang . "', 
                hari = '" . $hari_ini . "', 
                waktu = '" . $jam_sekarang . "', 
                data = '" . $status1 . "', 
                keterangan = '" . $status2 . "' 
                WHERE nama = '" . $nama . "'";

    if ($conn->query($sql) === TRUE) {
        echo "OK";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>