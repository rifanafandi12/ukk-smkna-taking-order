<?php
require_once '../config/koneksi.php';
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}
$judul = "Dashboard Admin";

$total_menu   = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) as j FROM menu"))['j'];
$total_order  = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) as j FROM orders"))['j'];
$total_pending= mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) as j FROM orders WHERE status='pending'"))['j'];
$total_pendapatan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COALESCE(SUM(total_harga),0) as j FROM orders WHERE status='selesai'"))['j'];

include '../includes/header.php';
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold" href="dashboard.php"><i class="bi bi-speedometer2"></i> Admin Cafe</a>
        <div class="ms-auto text-white">
            <span class="me-3"><i class="bi bi-person-circle"></i> <?= htmlspecialchars($_SESSION['admin_nama']); ?></span>
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
                <li class="nav-item"><a class="nav-link text-white" href="laporan.php"><i class="bi bi-file-earmark-text"></i> Laporan</a></li>
            </ul>
        </div>
        <div class="col-md-10 p-4">
            <h3 class="fw-bold mb-4">Dashboard</h3>
            <div class="row g-3">
                <div class="col-md-3">
                    <div class="card bg-primary text-white border-0 rounded-4">
                        <div class="card-body">
                            <h6>Total Menu</h6>
                            <h2 class="fw-bold"><?= $total_menu; ?></h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-success text-white border-0 rounded-4">
                        <div class="card-body">
                            <h6>Total Order</h6>
                            <h2 class="fw-bold"><?= $total_order; ?></h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-warning text-white border-0 rounded-4">
                        <div class="card-body">
                            <h6>Order Pending</h6>
                            <h2 class="fw-bold"><?= $total_pending; ?></h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-danger text-white border-0 rounded-4">
                        <div class="card-body">
                            <h6>Pendapatan (Selesai)</h6>
                            <h5 class="fw-bold"><?= rupiah($total_pendapatan); ?></h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include '../includes/footer.php'; ?>