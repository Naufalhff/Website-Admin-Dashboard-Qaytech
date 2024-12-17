<?php
$server = "localhost"; // nama server
$username = "root"; // username 
$password = ""; // password standar kosong
$database = "qaytech"; // nama database 


$conn = new mysqli($server, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// ... existing code ...
?>