<?php
require_once '../config/koneksi.php';
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

$tgl_awal  = $_GET['tgl_awal']  ?? date('Y-m-01');
$tgl_akhir = $_GET['tgl_akhir'] ?? date('Y-m-d');

$ta = mysqli_real_escape_string($koneksi, $tgl_awal);
$tk = mysqli_real_escape_string($koneksi, $tgl_akhir);

$q = mysqli_query($koneksi, "SELECT o.*, p.nama FROM orders o
                             JOIN pelanggan p ON o.pelanggan_id = p.id
                             WHERE DATE(o.waktu_order) BETWEEN '$ta' AND '$tk'
                             ORDER BY o.waktu_order ASC");

$total_pendapatan = 0;
$data = [];
while ($row = mysqli_fetch_assoc($q)) {
    $data[] = $row;
    if ($row['status'] == 'selesai') $total_pendapatan += $row['total_harga'];
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cetak Laporan Order - Taking Order Cafe</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding: 20px;
            background-color: #fff;
        }
        .header-laporan {
            text-align: center;
            border-bottom: 3px double #000;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }
        .header-laporan h2 {
            margin: 0;
            font-weight: bold;
            letter-spacing: 2px;
        }
        .header-laporan p {
            margin: 3px 0;
            font-size: 14px;
            color: #333;
        }
        .info-cetak {
            font-size: 13px;
            margin-bottom: 15px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
        }
        table th, table td {
            border: 1px solid #333;
            padding: 6px 8px;
        }
        table th {
            background-color: #f0f0f0;
            text-align: center;
            font-weight: bold;
        }
        .text-end {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .total-box {
            margin-top: 15px;
            font-size: 14px;
            font-weight: bold;
            text-align: right;
        }
        .ttd {
            margin-top: 50px;
            text-align: right;
            font-size: 13px;
        }
        .ttd p {
            margin: 0;
        }
        .ttd .nama-ttd {
            margin-top: 70px;
            border-top: 1px solid #000;
            display: inline-block;
            padding-top: 3px;
            min-width: 180px;
            text-align: center;
        }
        @media print {
            body {
                padding: 0;
                margin: 10mm;
            }
            .no-print {
                display: none !important;
            }
            @page {
                size: A4;
                margin: 15mm;
            }
        }
    </style>
</head>
<body>

<div class="header-laporan">
    <h2>TAKING ORDER CAFE</h2>
    <p>Jl. Contoh Alamat No. 123, Kota Anda</p>
    <p>Telp: 021-1234567 | Email: info@takingordercafe.com</p>
</div>

<h4 class="text-center mb-3" style="margin-top: 10px;">LAPORAN ORDER</h4>

<div class="info-cetak">
    <table style="border: none; width: auto;">
        <tr>
            <td style="border: none; padding: 2px 5px;">Periode</td>
            <td style="border: none; padding: 2px 5px;">:</td>
            <td style="border: none; padding: 2px 5px;">
                <?= date('d/m/Y', strtotime($tgl_awal)); ?> s/d <?= date('d/m/Y', strtotime($tgl_akhir)); ?>
            </td>
        </tr>
        <tr>
            <td style="border: none; padding: 2px 5px;">Tanggal Cetak</td>
            <td style="border: none; padding: 2px 5px;">:</td>
            <td style="border: none; padding: 2px 5px;"><?= date('d/m/Y H:i'); ?></td>
        </tr>
    </table>
</div>

<table>
    <thead>
        <tr>
            <th style="width: 30px;">No</th>
            <th style="width: 130px;">Kode Order</th>
            <th>Nama Pelanggan</th>
            <th style="width: 50px;">Meja</th>
            <th style="width: 100px;">Total</th>
            <th style="width: 80px;">Status</th>
            <th style="width: 110px;">Waktu</th>
        </tr>
    </thead>
    <tbody>
        <?php if (empty($data)): ?>
            <tr>
                <td colspan="7" class="text-center">Tidak ada data pada periode ini.</td>
            </tr>
        <?php else: ?>
            <?php $no = 1; foreach ($data as $o): ?>
            <tr>
                <td class="text-center"><?= $no++; ?></td>
                <td><?= htmlspecialchars($o['kode_order']); ?></td>
                <td><?= htmlspecialchars($o['nama']); ?></td>
                <td class="text-center"><?= htmlspecialchars($o['no_meja']); ?></td>
                <td class="text-end"><?= rupiah($o['total_harga']); ?></td>
                <td class="text-center"><?= ucfirst($o['status']); ?></td>
                <td class="text-center"><?= date('d/m/Y H:i', strtotime($o['waktu_order'])); ?></td>
            </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>

<div class="total-box">
    Total Pendapatan (Order Selesai): <?= rupiah($total_pendapatan); ?>
</div>

<div class="ttd">
    <p>Kota Anda, <?= date('d/m/Y'); ?></p>
    <p>Administrator,</p>
    <p class="nama-ttd"><?= htmlspecialchars($_SESSION['admin_nama']); ?></p>
</div>

<script>
    window.onload = function() {
        window.print();
    };
    window.onafterprint = function() {
        window.close();
    };
</script>

</body>
</html>