<?php
date_default_timezone_set('Asia/Jakarta');

$db_host = "192.168.200.100";
$db_user = "yuda";
$db_pass = "Siswa#123";
$db_name = "yuda";

$conn = @mysqli_connect($db_host, $db_user, $db_pass, $db_name);

if (!$conn) {
    die("Koneksi Database Gagal: " . mysqli_connect_error());
}

function getBaseUrl() {
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
    $host = $_SERVER['HTTP_HOST'];
    return $protocol . "://" . $host . "/YouKantin/";
}
?>