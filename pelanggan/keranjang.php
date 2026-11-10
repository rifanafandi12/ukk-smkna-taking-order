<?php
require_once '../config/koneksi.php';
if (!isset($_SESSION['pelanggan_id'])) {
    header("Location: ../index.php");
    exit;
}
$judul = "Keranjang - Taking Order Cafe";
include '../includes/header.php';
include '../includes/navbar.php';

$keranjang = isset($_SESSION['keranjang']) ? $_SESSION['keranjang'] : [];
$total = 0;
?>

<div class="container py-4">
    <h3 class="fw-bold mb-4">Keranjang Pesanan</h3>

    <?php if (empty($keranjang)): ?>
        <div class="alert alert-warning">
            Keranjang masih kosong. <a href="menu.php">Lihat menu</a>
        </div>
    <?php else: ?>
        <div class="card shadow-sm border-0 rounded-4">
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>Menu</th>
                            <th class="text-end">Harga</th>
                            <th class="text-center">Jumlah</th>
                            <th class="text-end">Subtotal</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($keranjang as $mid => $jml):
                            $q = mysqli_query($koneksi, "SELECT * FROM menu WHERE id = $mid");
                            $m = mysqli_fetch_assoc($q);
                            if (!$m) continue;
                            $sub = $m['harga'] * $jml;
                            $total += $sub;
                        ?>
                        <tr>
                            <td><?= htmlspecialchars($m['nama_menu']); ?></td>
                            <td class="text-end"><?= rupiah($m['harga']); ?></td>
                            <td class="text-center" style="width: 150px;">
                                <form action="../proses/update_keranjang.php" method="POST" class="d-flex gap-1 justify-content-center">
                                    <input type="hidden" name="menu_id" value="<?= $mid; ?>">
                                    <input type="number" name="jumlah" value="<?= $jml; ?>" min="1" max="<?= $m['stok']; ?>"
                                           class="form-control form-control-sm" style="width: 70px;">
                                    <button class="btn btn-sm btn-outline-primary" type="submit"><i class="bi bi-arrow-repeat"></i></button>
                                </form>
                            </td>
                            <td class="text-end fw-bold"><?= rupiah($sub); ?></td>
                            <td class="text-center">
                                <a href="../proses/hapus_keranjang.php?id=<?= $mid; ?>" class="btn btn-sm btn-danger">
                                    <i class="bi bi-trash"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot class="table-light">
                        <tr>
                            <th colspan="3" class="text-end">Total</th>
                            <th class="text-end text-warning fs-5"><?= rupiah($total); ?></th>
                            <th></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <div class="d-flex justify-content-between mt-4">
            <a href="menu.php" class="btn btn-outline-dark">
                <i class="bi bi-arrow-left"></i> Lanjut Pesan
            </a>
            <a href="checkout.php" class="btn btn-warning fw-bold">
                <i class="bi bi-check-circle"></i> Checkout
            </a>
        </div>
    <?php endif; ?>
</div>

<?php include '../includes/footer.php'; ?>