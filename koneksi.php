<?php
$host = "localhost";
$user = "root"; // Default Xampp
$pass = ""; // Default kosong
$db   = "stickmilk_db"; // GANTI sesuai nama database kamu

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi database gagal: " . mysqli_connect_error());
} 
?>
