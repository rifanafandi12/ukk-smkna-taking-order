<?php
require_once '../config/koneksi.php';
if (isset($_SESSION['admin_id'])) {
    header("Location: dashboard.php");
    exit;
}
$judul = "Login Admin";
include '../includes/header.php';
?>

<div class="bg-dark d-flex align-items-center" style="min-height: 100vh;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card shadow-lg border-0 rounded-4">
                    <div class="card-body p-5">
                        <div class="text-center mb-4">
                            <i class="bi bi-shield-lock-fill text-warning" style="font-size: 3rem;"></i>
                            <h4 class="fw-bold mt-2">Login Admin</h4>
                        </div>
                        <?php if (isset($_SESSION['error'])): ?>
                            <div class="alert alert-danger"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
                        <?php endif; ?>
                        <form action="proses_login.php" method="POST">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Username</label>
                                <input type="text" name="username" class="form-control" required>
                            </div>
                            <div class="mb-4">
                                <label class="form-label fw-semibold">Password</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-warning w-100 fw-bold">Login</button>
                        </form>
                        <div class="text-center mt-3">
                            <a href="../index.php" class="small text-muted">Kembali ke Halaman Pelanggan</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>