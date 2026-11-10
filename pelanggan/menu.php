<?php
require_once '../config/koneksi.php';
if (!isset($_SESSION['pelanggan_id'])) {
    header("Location: ../index.php");
    exit;
}
$judul = "Menu - Taking Order Cafe";
include '../includes/header.php';
include '../includes/navbar.php';

$kategori_filter = isset($_GET['kategori']) ? $_GET['kategori'] : '';
$where = "WHERE status = 'tersedia'";
if ($kategori_filter != '') {
    $kf = mysqli_real_escape_string($koneksi, $kategori_filter);
    $where .= " AND kategori = '$kf'";
}
$query = mysqli_query($koneksi, "SELECT * FROM menu $where ORDER BY kategori, nama_menu");
$kategori_list = mysqli_query($koneksi, "SELECT DISTINCT kategori FROM menu ORDER BY kategori");
?>

<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-1">Menu Cafe</h3>
            <p class="text-muted mb-0">Pilih menu favorit Anda</p>
        </div>
        <a href="keranjang.php" class="btn btn-warning">
            <i class="bi bi-cart-fill"></i> Lihat Keranjang
        </a>
    </div>

    <?php if (isset($_SESSION['pesan'])): ?>
        <div class="alert alert-success alert-dismissible fade show">
            <?= $_SESSION['pesan']; unset($_SESSION['pesan']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="mb-4">
        <a href="menu.php" class="btn btn-sm <?= $kategori_filter == '' ? 'btn-dark' : 'btn-outline-dark'; ?> me-2">Semua</a>
        <?php while ($k = mysqli_fetch_assoc($kategori_list)): ?>
            <a href="menu.php?kategori=<?= urlencode($k['kategori']); ?>"
               class="btn btn-sm <?= $kategori_filter == $k['kategori'] ? 'btn-dark' : 'btn-outline-dark'; ?> me-2">
                <?= htmlspecialchars($k['kategori']); ?>
            </a>
        <?php endwhile; ?>
    </div>

    <div class="row g-4">
        <?php if (mysqli_num_rows($query) == 0): ?>
            <div class="col-12"><div class="alert alert-info">Belum ada menu tersedia.</div></div>
        <?php endif; ?>
        <?php while ($m = mysqli_fetch_assoc($query)): ?>
            <div class="col-md-4 col-sm-6">
                <div class="card h-100 shadow-sm border-0 rounded-4">
                    <div class="card-body">
                        <span class="badge bg-secondary mb-2"><?= htmlspecialchars($m['kategori']); ?></span>
                        <h5 class="card-title fw-bold"><?= htmlspecialchars($m['nama_menu']); ?></h5>
                        <p class="card-text text-muted small"><?= htmlspecialchars($m['deskripsi']); ?></p>
                        <p class="fw-bold text-warning mb-1"><?= rupiah($m['harga']); ?></p>
                        <p class="small text-muted mb-3">Stok: <?= $m['stok']; ?></p>
                        <form action="../proses/tambah_keranjang.php" method="POST" class="d-flex gap-2">
                            <input type="hidden" name="menu_id" value="<?= $m['id']; ?>">
                            <input type="number" name="jumlah" value="1" min="1" max="<?= $m['stok']; ?>"
                                   class="form-control form-control-sm" style="width: 80px;">
                            <button type="submit" class="btn btn-warning btn-sm flex-grow-1">
                                <i class="bi bi-plus-circle"></i> Tambah
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</div>

<?php include '../includes/footer.php'; ?>