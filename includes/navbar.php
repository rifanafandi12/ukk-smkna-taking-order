<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand fw-bold" href="index.php">
            <i class="bi bi-cup-hot-fill me-2"></i>Taking Order Cafe
        </a>
        <div class="ms-auto">
            <?php if (isset($_SESSION['pelanggan_id'])): ?>
                <span class="navbar-text text-white me-3">
                    <i class="bi bi-person-circle me-1"></i>
                    <?= htmlspecialchars($_SESSION['pelanggan_nama']); ?>
                    | Meja: <?= htmlspecialchars($_SESSION['pelanggan_meja']); ?>
                </span>
                <a href="keranjang.php" class="btn btn-warning btn-sm me-2">
                    <i class="bi bi-cart-fill"></i> Keranjang
                    (<?= isset($_SESSION['keranjang']) ? count($_SESSION['keranjang']) : 0; ?>)
                </a>
                <a href="logout_pelanggan.php" class="btn btn-outline-light btn-sm">Selesai</a>
            <?php endif; ?>
        </div>
    </div>
</nav>

