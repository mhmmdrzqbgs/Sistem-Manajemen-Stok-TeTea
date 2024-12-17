<?php
// Konfigurasi database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_tetea";

// Membuat koneksi
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Cek koneksi
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

mysqli_set_charset($conn, "utf8mb4");

?>
