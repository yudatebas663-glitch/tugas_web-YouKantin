<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$host     = "192.168.200.100";
$username = "yuda";
$password = "Siswa#123";
$dbname   = "yuda_youkantin";

$conn = mysqli_connect($host, $username, $password, $dbname);

if (!$conn) {
    die("Koneksi ke database gagal: " . mysqli_connect_error());
}

mysqli_set_charset($conn, "utf8mb4");
?>
