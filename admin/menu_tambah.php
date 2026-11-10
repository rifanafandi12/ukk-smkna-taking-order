<?php
require_once '../config/koneksi.php';
if (!isset($_SESSION['admin_id'])) { header("Location: login.php"); exit; }
$judul = "Tambah Menu";
include '../includes/header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama_menu']);
    $kat  = mysqli_real_escape_string($koneksi, $_POST['kategori']);
    $harga= (float)$_POST['harga'];
    $desc = mysqli_real_escape_string($koneksi, $_POST['deskripsi']);
    $stok = (int)$_POST['stok'];
    $status = $_POST['status'];

    $sql = "INSERT INTO menu (nama_menu, kategori, harga, deskripsi, stok, status)
            VALUES ('$nama', '$kat', $harga, '$desc', $stok, '$status')";
    if (mysqli_query($koneksi, $sql)) {
        $_SESSION['pesan'] = "Menu berhasil ditambahkan.";
        header("Location: menu.php");
        exit;
    }
}
?>
<nav class="navbar navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold" href="dashboard.php"><i class="bi bi-speedometer2"></i> Admin Cafe</a>
        <div class="ms-auto text-white">
            <span class="me-3"><?= htmlspecialchars($_SESSION['admin_nama']); ?></span>
            <a href="logout.php" class="btn btn-outline-light btn-sm">Logout</a>
        </div>
    </div>
</nav>

<div class="container py-4">
    <h3 class="fw-bold mb-4">Tambah Menu</h3>
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4">
            <form method="POST">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nama Menu</label>
                        <input type="text" name="nama_menu" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Kategori</label>
                        <input type="text" name="kategori" class="form-control" placeholder="Kopi / Non-Kopi / Makanan / Minuman" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Harga</label>
                        <input type="number" name="harga" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Stok</label>
                        <input type="number" name="stok" class="form-control" value="0" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="tersedia">Tersedia</option>
                            <option value="habis">Habis</option>
                        </select>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea name="deskripsi" class="form-control" rows="3"></textarea>
                    </div>
                </div>
                <button type="submit" class="btn btn-warning fw-bold"><i class="bi bi-save"></i> Simpan</button>
                <a href="menu.php" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
<?php include '../includes/footer.php'; ?>