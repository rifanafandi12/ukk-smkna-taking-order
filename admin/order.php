<?php
require_once '../config/koneksi.php';
if (!isset($_SESSION['admin_id'])) { header("Location: login.php"); exit; }
$judul = "Data Order";
include '../includes/header.php';

$filter = $_GET['status'] ?? '';
$where = "";
if ($filter != '') {
    $f = mysqli_real_escape_string($koneksi, $filter);
    $where = "WHERE o.status = '$f'";
}
$q = mysqli_query($koneksi, "SELECT o.*, p.nama FROM orders o
                             JOIN pelanggan p ON o.pelanggan_id = p.id
                             $where ORDER BY o.waktu_order DESC");
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
                <li class="nav-item"><a class="nav-link text-white active" href="order.php"><i class="bi bi-receipt"></i> Data Order</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="laporan.php"><i class="bi bi-file-earmark-text"></i> Laporan</a></li>
            </ul>
        </div>
        <div class="col-md-10 p-4">
            <h3 class="fw-bold mb-3">Data Order</h3>
            <div class="mb-3">
                <a href="order.php" class="btn btn-sm <?= $filter==''?'btn-dark':'btn-outline-dark'; ?>">Semua</a>
                <a href="order.php?status=pending" class="btn btn-sm <?= $filter=='pending'?'btn-warning':'btn-outline-warning'; ?>">Pending</a>
                <a href="order.php?status=diproses" class="btn btn-sm <?= $filter=='diproses'?'btn-primary':'btn-outline-primary'; ?>">Diproses</a>
                <a href="order.php?status=selesai" class="btn btn-sm <?= $filter=='selesai'?'btn-success':'btn-outline-success'; ?>">Selesai</a>
                <a href="order.php?status=dibatalkan" class="btn btn-sm <?= $filter=='dibatalkan'?'btn-danger':'btn-outline-danger'; ?>">Dibatalkan</a>
            </div>
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-0">
                    <table class="table table-hover mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th>Kode</th><th>Nama</th><th>Meja</th><th>Total</th>
                                <th>Status</th><th>Waktu</th><th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($o = mysqli_fetch_assoc($q)): ?>
                            <tr>
                                <td><code><?= $o['kode_order']; ?></code></td>
                                <td><?= htmlspecialchars($o['nama']); ?></td>
                                <td><?= htmlspecialchars($o['no_meja']); ?></td>
                                <td><?= rupiah($o['total_harga']); ?></td>
                                <td>
                                    <?php
                                    $badge = 'secondary';
                                    if ($o['status']=='pending') $badge='warning';
                                    elseif ($o['status']=='diproses') $badge='primary';
                                    elseif ($o['status']=='selesai') $badge='success';
                                    elseif ($o['status']=='dibatalkan') $badge='danger';
                                    ?>
                                    <span class="badge bg-<?= $badge; ?>"><?= ucfirst($o['status']); ?></span>
                                </td>
                                <td><?= date('d/m/Y H:i', strtotime($o['waktu_order'])); ?></td>
                                <td>
                                    <a href="order_detail.php?id=<?= $o['id']; ?>" class="btn btn-sm btn-info text-white"><i class="bi bi-eye"></i></a>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include '../includes/footer.php'; ?>