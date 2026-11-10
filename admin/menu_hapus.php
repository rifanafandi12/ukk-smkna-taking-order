<?php
require_once '../config/koneksi.php';
if (!isset($_SESSION['admin_id'])) { header("Location: login.php"); exit; }
$id = (int)$_GET['id'];
mysqli_query($koneksi, "DELETE FROM menu WHERE id = $id");
$_SESSION['pesan'] = "Menu berhasil dihapus.";
header("Location: menu.php");
?>