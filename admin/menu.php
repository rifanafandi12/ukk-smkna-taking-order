<?php
require_once '../config/koneksi.php';
if (!isset($_SESSION['admin_id'])) { header("Location: login.php"); exit; }
$judul = "Kelola Menu";
include '../includes/header.php';

$q = mysqli_query($koneksi, "SELECT * FROM menu ORDER BY kategori, nama_menu");
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
                <li class="nav-item"><a class="nav-link text-white active" href="menu.php"><i class="bi bi-cup-hot"></i> Kelola Menu</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="order.php"><i class="bi bi-receipt"></i> Data Order</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="laporan.php"><i class="bi bi-file-earmark-text"></i> Laporan</a></li>
            </ul>
        </div>
        <div class="col-md-10 p-4">
            <div class="d-flex justify-content-between mb-3">
                <h3 class="fw-bold">Kelola Menu</h3>
                <a href="menu_tambah.php" class="btn btn-warning"><i class="bi bi-plus-circle"></i> Tambah Menu</a>
            </div>

            <?php if (isset($_SESSION['pesan'])): ?>
                <div class="alert alert-success"><?= $_SESSION['pesan']; unset($_SESSION['pesan']); ?></div>
            <?php endif; ?>

            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-0">
                    <table class="table table-hover mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th>No</th><th>Nama</th><th>Kategori</th><th>Harga</th>
                                <th>Stok</th><th>Status</th><th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no=1; while ($m = mysqli_fetch_assoc($q)): ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><?= htmlspecialchars($m['nama_menu']); ?></td>
                                <td><span class="badge bg-secondary"><?= htmlspecialchars($m['kategori']); ?></span></td>
                                <td><?= rupiah($m['harga']); ?></td>
                                <td><?= $m['stok']; ?></td>
                                <td>
                                    <?php if ($m['status'] == 'tersedia'): ?>
                                        <span class="badge bg-success">Tersedia</span>
                                    <?php else: ?>
                                        <span class="badge bg-danger">Habis</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="menu_edit.php?id=<?= $m['id']; ?>" class="btn btn-sm btn-primary"><i class="bi bi-pencil"></i></a>
                                    <a href="menu_hapus.php?id=<?= $m['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Hapus menu ini?')"><i class="bi bi-trash"></i></a>
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