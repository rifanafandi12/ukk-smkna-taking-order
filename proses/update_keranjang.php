<?php
// update_keranjang.php
require_once '../config/koneksi.php';
$menu_id = (int)$_POST['menu_id'];
$jumlah  = (int)$_POST['jumlah'];
if ($jumlah < 1) $jumlah = 1;
if (isset($_SESSION['keranjang'][$menu_id])) {
    $_SESSION['keranjang'][$menu_id] = $jumlah;
}
header("Location: ../pelanggan/keranjang.php");
?>