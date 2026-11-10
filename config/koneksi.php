<?php
session_start();

$host = "localhost";
$user = "root";
$pass = "";
$db   = "db_cafe";

$koneksi = mysqli_connect($host, $user, $pass, $db);

if (!$koneksi) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

date_default_timezone_set('Asia/Jakarta');

function rupiah($angka) {
    return "Rp " . number_format($angka, 0, ',', '.');
}

function generateKodeOrder() {
    return "ORD-" . date("YmdHis") . "-" . rand(100, 999);
}
?>