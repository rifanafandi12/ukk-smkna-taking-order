<?php
require_once '../config/koneksi.php';
if (!isset($_SESSION['pelanggan_id']) || !isset($_SESSION['last_order_id'])) {
    header("Location: ../index.php");
    exit;
}

$oid = (int)$_SESSION['last_order_id'];

$q_order = mysqli_query($koneksi, "SELECT o.*, p.nama, p.no_hp FROM orders o
                                   JOIN pelanggan p ON o.pelanggan_id = p.id
                                   WHERE o.id = $oid");
$order = mysqli_fetch_assoc($q_order);

if (!$order) {
    header("Location: ../index.php");
    exit;
}

$q_detail = mysqli_query($koneksi, "SELECT * FROM order_detail WHERE order_id = $oid");
$detail = [];
while ($d = mysqli_fetch_assoc($q_detail)) {
    $detail[] = $d;
}

$judul = "Struk Pesanan - Taking Order Cafe";
include '../includes/header.php';
?>

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-5">

            <div class="text-center mb-3 no-print">
                <i class="bi bi-check-circle-fill text-success" style="font-size: 3rem;"></i>
                <h4 class="fw-bold mt-2 mb-1">Pesanan Berhasil</h4>
                <p class="text-muted small mb-0">Silakan tunjukkan struk ini ke kasir atau pelayan</p>
            </div>

            <div class="struk-wrapper bg-danger-subtle p-5 rounded-5" id="strukArea">
                <div class="struk">
                    <div class="struk-header text-center">
                        <h5 class="mb-0 fw-bold">TAKING ORDER CAFE</h5>
                        <p class="mb-0 small">Jl. Contoh Alamat No. 123, Kota Anda</p>
                        <p class="mb-0 small">Telp: 021-1234567</p>
                    </div>

                    <div class="struk-divider">================================</div>

                    <div class="struk-info">
                        <div class="row-line">
                            <span>Kode Order :</span>
                            <span> <?= htmlspecialchars($order['kode_order']); ?></span>
                        </div>
                        <div class="row-line">
                            <span>Tanggal :</span>
                            <span> <?= date('d/m/Y H:i', strtotime($order['waktu_order'])); ?></span>
                        </div>
                        <div class="row-line">
                            <span>Nama :</span>
                            <span> <?= htmlspecialchars($order['nama']); ?></span>
                        </div>
                        <div class="row-line">
                            <span>No. Meja :</span>
                            <span><?= htmlspecialchars($order['no_meja']); ?></span>
                        </div>
                        <?php if (!empty($order['no_hp'])): ?>
                        <div class="row-line">
                            <span>No. HP :</span>
                            <span><?= htmlspecialchars($order['no_hp']); ?></span>
                        </div>
                        <?php endif; ?>
                    </div>

                    <div class="struk-divider">================================</div>

                    <div class="struk-items">
                        <?php foreach ($detail as $d): ?>
                            <div class="item-nama"><?= htmlspecialchars($d['nama_menu']); ?>:</div>
                            <div class="row-line item-detail">
                                <span><?= $d['jumlah']; ?> x <?= number_format($d['harga'], 0, ',', '.'); ?></span>
                                <span><?= number_format($d['subtotal'], 0, ',', '.'); ?></span>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <div class="struk-divider">================================</div>

                    <div class="row-line total-line">
                        <span>TOTAL :</span>
                        <span><?= rupiah($order['total_harga']); ?></span>
                    </div>

                    <div class="row-line">
                        <span>Status :</span>
                        <span> <?= ucfirst($order['status']); ?></span>
                    </div>

                    <?php if (!empty($order['catatan'])): ?>
                    <div class="struk-divider">--------------------------------</div>
                    <div class="catatan">
                        <div class="fw-bold">Catatan:</div>
                        <div><?= nl2br(htmlspecialchars($order['catatan'])); ?></div>
                    </div>
                    <?php endif; ?>

                    <div class="struk-divider">================================</div>

                    <div class="struk-footer text-center">
                        <p class="mb-1">Terima kasih atas kunjungan Anda</p>
                        <p class="mb-0">Selamat menikmati</p>
                    </div>
                </div>
            </div>

            <div class="text-center mt-4 no-print">
                <a href="menu.php" class="btn btn-outline-dark me-2">
                    <i class="bi bi-plus-circle"></i> Order Lagi
                </a>
                <a href="../pelanggan/logout_pelanggan.php" class="btn btn-dark">
                    <i class="bi bi-box-arrow-right"></i> Selesai
                </a>
            </div>

        </div>
    </div>
</div>

<style>
    .row-line{
        padding: 5px 0;
        display: flex;
        justify-content: space-between;
    }
</style>

<?php include '../includes/footer.php'; ?>