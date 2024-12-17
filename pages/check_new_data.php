<?php
require_once('koneksi.php');

$query = "SELECT COUNT(*) as count FROM tbQay";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);

$last_count = isset($_SESSION['last_count']) ? $_SESSION['last_count'] : 0;
$_SESSION['last_count'] = $row['count'];

if ($row['count'] > $last_count) {
    echo '1';
} else {
    echo '0';
}
?>