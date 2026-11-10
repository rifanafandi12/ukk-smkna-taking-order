<?php
require_once '../config/koneksi.php';
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}
$judul = "Laporan Order";
include '../includes/header.php';

$tgl_awal  = $_GET['tgl_awal']  ?? date('Y-m-01');
$tgl_akhir = $_GET['tgl_akhir'] ?? date('Y-m-d');

$ta = mysqli_real_escape_string($koneksi, $tgl_awal);
$tk = mysqli_real_escape_string($koneksi, $tgl_akhir);

$q = mysqli_query($koneksi, "SELECT o.*, p.nama FROM orders o
                             JOIN pelanggan p ON o.pelanggan_id = p.id
                             WHERE DATE(o.waktu_order) BETWEEN '$ta' AND '$tk'
                             ORDER BY o.waktu_order DESC");

$total_pendapatan = 0;
$data = [];
while ($row = mysqli_fetch_assoc($q)) {
    $data[] = $row;
    if ($row['status'] == 'selesai') $total_pendapatan += $row['total_harga'];
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

<div class="container-fluid">
    <div class="row">
        <div class="col-md-2 bg-dark text-white p-3" style="min-height: calc(100vh - 56px);">
            <ul class="nav flex-column">
                <li class="nav-item"><a class="nav-link text-white" href="dashboard.php"><i class="bi bi-house"></i> Dashboard</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="menu.php"><i class="bi bi-cup-hot"></i> Kelola Menu</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="order.php"><i class="bi bi-receipt"></i> Data Order</a></li>
                <li class="nav-item"><a class="nav-link text-white active" href="laporan.php"><i class="bi bi-file-earmark-text"></i> Laporan</a></li>
            </ul>
        </div>
        <div class="col-md-10 p-4">
            <h3 class="fw-bold mb-3">Laporan Order</h3>

            <form method="GET" class="row g-2 mb-3">
                <div class="col-md-3">
                    <label class="form-label small">Tanggal Awal</label>
                    <input type="date" name="tgl_awal" class="form-control" value="<?= $tgl_awal; ?>">
                </div>
                <div class="col-md-3">
                    <label class="form-label small">Tanggal Akhir</label>
                    <input type="date" name="tgl_akhir" class="form-control" value="<?= $tgl_akhir; ?>">
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button class="btn btn-warning w-100"><i class="bi bi-search"></i> Filter</button>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <a href="cetak_laporan.php?tgl_awal=<?= $tgl_awal; ?>&tgl_akhir=<?= $tgl_akhir; ?>"
                        target="_blank" class="btn btn-outline-dark w-100">
                        <i class="bi bi-printer"></i> Cetak
                    </a>
                </div>
            </form>

            <div class="alert alert-info">
                <strong>Total Pendapatan (order selesai):</strong> <?= rupiah($total_pendapatan); ?>
            </div>

            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-0">
                    <table class="table table-hover mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th>No</th>
                                <th>Kode</th>
                                <th>Nama</th>
                                <th>Meja</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Waktu</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1;
                            foreach ($data as $o): ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td><code><?= $o['kode_order']; ?></code></td>
                                    <td><?= htmlspecialchars($o['nama']); ?></td>
                                    <td><?= htmlspecialchars($o['no_meja']); ?></td>
                                    <td><?= rupiah($o['total_harga']); ?></td>
                                    <td><?= ucfirst($o['status']); ?></td>
                                    <td><?= date('d/m/Y H:i', strtotime($o['waktu_order'])); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include '../includes/footer.php'; ?>