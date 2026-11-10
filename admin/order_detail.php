<?php
require_once '../config/koneksi.php';
if (!isset($_SESSION['admin_id'])) { header("Location: login.php"); exit; }
$id = (int)$_GET['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $status = $_POST['status'];
    $st = mysqli_real_escape_string($koneksi, $status);
    mysqli_query($koneksi, "UPDATE orders SET status='$st' WHERE id=$id");
    $_SESSION['pesan'] = "Status order berhasil diperbarui.";
    header("Location: order_detail.php?id=$id");
    exit;
}

$judul = "Detail Order";
include '../includes/header.php';

$q = mysqli_query($koneksi, "SELECT o.*, p.nama, p.no_hp FROM orders o
                             JOIN pelanggan p ON o.pelanggan_id = p.id
                             WHERE o.id = $id");
$o = mysqli_fetch_assoc($q);
if (!$o) { header("Location: order.php"); exit; }

$qd = mysqli_query($koneksi, "SELECT * FROM order_detail WHERE order_id = $id");
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
    <a href="order.php" class="btn btn-outline-dark btn-sm mb-3"><i class="bi bi-arrow-left"></i> Kembali</a>
    <h3 class="fw-bold mb-4">Detail Order <?= $o['kode_order']; ?></h3>

    <?php if (isset($_SESSION['pesan'])): ?>
        <div class="alert alert-success"><?= $_SESSION['pesan']; unset($_SESSION['pesan']); ?></div>
    <?php endif; ?>

    <div class="row">
        <div class="col-md-5">
            <div class="card border-0 shadow-sm rounded-4 mb-3">
                <div class="card-header bg-dark text-white">Informasi Pelanggan</div>
                <div class="card-body">
                    <p><strong>Nama:</strong> <?= htmlspecialchars($o['nama']); ?></p>
                    <p><strong>No. HP:</strong> <?= htmlspecialchars($o['no_hp'] ?: '-'); ?></p>
                    <p><strong>No. Meja:</strong> <?= htmlspecialchars($o['no_meja']); ?></p>
                    <p><strong>Waktu:</strong> <?= date('d/m/Y H:i', strtotime($o['waktu_order'])); ?></p>
                    <p><strong>Catatan:</strong> <?= htmlspecialchars($o['catatan'] ?: '-'); ?></p>
                </div>
            </div>
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-dark text-white">Update Status</div>
                <div class="card-body">
                    <form method="POST">
                        <select name="status" class="form-select mb-3">
                            <option value="pending" <?= $o['status']=='pending'?'selected':''; ?>>Pending</option>
                            <option value="diproses" <?= $o['status']=='diproses'?'selected':''; ?>>Diproses</option>
                            <option value="selesai" <?= $o['status']=='selesai'?'selected':''; ?>>Selesai</option>
                            <option value="dibatalkan" <?= $o['status']=='dibatalkan'?'selected':''; ?>>Dibatalkan</option>
                        </select>
                        <button class="btn btn-warning w-100 fw-bold"><i class="bi bi-save"></i> Update Status</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-7">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-dark text-white">Rincian Item</div>
                <div class="card-body p-0">
                    <table class="table mb-0">
                        <thead class="table-light">
                            <tr><th>Menu</th><th>Harga</th><th>Jumlah</th><th class="text-end">Subtotal</th></tr>
                        </thead>
                        <tbody>
                            <?php while ($d = mysqli_fetch_assoc($qd)): ?>
                            <tr>
                                <td><?= htmlspecialchars($d['nama_menu']); ?></td>
                                <td><?= rupiah($d['harga']); ?></td>
                                <td><?= $d['jumlah']; ?></td>
                                <td class="text-end"><?= rupiah($d['subtotal']); ?></td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                        <tfoot class="table-light">
                            <tr>
                                <th colspan="3" class="text-end">Total</th>
                                <th class="text-end text-warning"><?= rupiah($o['total_harga']); ?></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include '../includes/footer.php'; ?>