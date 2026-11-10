<?php
require_once '../config/koneksi.php';
if (!isset($_SESSION['pelanggan_id'])) {
    header("Location: ../index.php");
    exit;
}
$keranjang = isset($_SESSION['keranjang']) ? $_SESSION['keranjang'] : [];
if (empty($keranjang)) {
    header("Location: keranjang.php");
    exit;
}
$total = 0;
foreach ($keranjang as $mid => $jml) {
    $q = mysqli_query($koneksi, "SELECT harga FROM menu WHERE id = $mid");
    $m = mysqli_fetch_assoc($q);
    if ($m) $total += $m['harga'] * $jml;
}
$judul = "Checkout - Taking Order Cafe";
include '../includes/header.php';
include '../includes/navbar.php';
?>

<div class="container py-4">
    <h3 class="fw-bold mb-4">Konfirmasi Pesanan</h3>
    <div class="row">
        <div class="col-md-7">
            <div class="card shadow-sm border-0 rounded-4 mb-3">
                <div class="card-header bg-dark text-white">Data Pelanggan</div>
                <div class="card-body">
                    <p class="mb-1"><strong>Nama:</strong> <?= htmlspecialchars($_SESSION['pelanggan_nama']); ?></p>
                    <p class="mb-0"><strong>No. Meja:</strong> <?= htmlspecialchars($_SESSION['pelanggan_meja']); ?></p>
                </div>
            </div>
            <form action="../proses/simpan_order.php" method="POST">
                <div class="card shadow-sm border-0 rounded-4 mb-3">
                    <div class="card-header bg-dark text-white">Catatan Tambahan</div>
                    <div class="card-body">
                        <textarea name="catatan" class="form-control" rows="3" placeholder="Contoh: tanpa gula, extra shot, dll (opsional)"></textarea>
                    </div>
                </div>
                <button type="submit" class="btn btn-warning fw-bold w-100 py-2">
                    <i class="bi bi-send-check"></i> Kirim Pesanan
                </button>
            </form>
        </div>
        <div class="col-md-5">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-header bg-dark text-white">Rincian Pesanan</div>
                <div class="card-body">
                    <?php foreach ($keranjang as $mid => $jml):
                        $q = mysqli_query($koneksi, "SELECT * FROM menu WHERE id = $mid");
                        $m = mysqli_fetch_assoc($q);
                        if (!$m) continue;
                    ?>
                    <div class="d-flex justify-content-between mb-2">
                        <span><?= htmlspecialchars($m['nama_menu']); ?> x <?= $jml; ?></span>
                        <span><?= rupiah($m['harga'] * $jml); ?></span>
                    </div>
                    <?php endforeach; ?>
                    <hr>
                    <div class="d-flex justify-content-between fw-bold fs-5">
                        <span>Total</span>
                        <span class="text-warning"><?= rupiah($total); ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>