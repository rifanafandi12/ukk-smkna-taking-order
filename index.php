<?php
require_once 'config/koneksi.php';
$judul = "Selamat Datang - Taking Order Cafe";
include 'includes/header.php';
?>

<div class="bg-cafe-hero d-flex align-items-center" style="min-height: 100vh;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card shadow-lg border-0 rounded-4">
                    <div class="card-body p-5">
                        <div class="text-center mb-4">
                            <i class="bi bi-cup-hot-fill text-warning" style="font-size: 3rem;"></i>
                            <h3 class="fw-bold mt-2">Taking Order Cafe</h3>
                            <p class="text-muted">Silakan isi data diri Anda untuk memulai pemesanan</p>
                        </div>
                        <?php if (isset($_SESSION['error'])): ?>
                            <div class="alert alert-danger"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
                        <?php endif; ?>

                        <form action="proses/simpan_pelanggan.php" method="POST">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Nama Lengkap</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                                    <input type="text" name="nama" class="form-control" placeholder="Masukkan nama Anda" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Nomor Meja</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-grid-3x3-gap"></i></span>
                                    <input type="text" name="no_meja" class="form-control" placeholder="Contoh: A01" required>
                                </div>
                            </div>
                            <div class="mb-4">
                                <label class="form-label fw-semibold">No. HP (Opsional)</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-telephone"></i></span>
                                    <input type="text" name="no_hp" class="form-control" placeholder="08xxxxxxxxxx">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-warning w-100 fw-bold py-2">
                                <i class="bi bi-box-arrow-in-right me-2"></i>Mulai Pesan
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>