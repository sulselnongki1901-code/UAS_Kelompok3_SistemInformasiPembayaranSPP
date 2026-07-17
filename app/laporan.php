<?php
require "koneksi.php";

$bulanFilter = isset($_GET['bulan']) ? trim($_GET['bulan']) : "";

if ($bulanFilter !== "") {
    $stmt = mysqli_prepare($koneksi, "SELECT * FROM v_laporan_pembayaran WHERE bulan_bayar = ? ORDER BY tanggal_bayar");
    mysqli_stmt_bind_param($stmt, "s", $bulanFilter);
    mysqli_stmt_execute($stmt);
    $hasil = mysqli_stmt_get_result($stmt);
} else {
    $hasil = mysqli_query($koneksi, "SELECT * FROM v_laporan_pembayaran ORDER BY tanggal_bayar");
}

// Simpan baris ke array supaya bisa dipakai 2x (tabel detail + hitung ringkasan)
$rows = mysqli_fetch_all($hasil, MYSQLI_ASSOC);
$totalLaporan = 0;
foreach ($rows as $r) { $totalLaporan += $r['jumlah_bayar']; }
$jumlahTransaksi = count($rows);
$rataRata = $jumlahTransaksi > 0 ? $totalLaporan / $jumlahTransaksi : 0;

// Aggregate: rekap total pembayaran per kelas (untuk grafik batang)
$rekapKelas = mysqli_query($koneksi, "
    SELECT k.nama_kelas, COUNT(p.id_pembayaran) AS jumlah_transaksi, SUM(p.jumlah_bayar) AS total
    FROM pembayaran p
    JOIN siswa s ON p.id_siswa = s.id_siswa
    JOIN kelas k ON s.id_kelas = k.id_kelas
    GROUP BY k.id_kelas, k.nama_kelas
    ORDER BY total DESC
");
$rekap = mysqli_fetch_all($rekapKelas, MYSQLI_ASSOC);
$maxTotal = 0;
foreach ($rekap as $r) { if ($r['total'] > $maxTotal) $maxTotal = $r['total']; }

// Badge warna sesuai metode pembayaran
function badgeMetode($metode) {
    $class = "badge-tunai";
    if ($metode === "Transfer") $class = "badge-transfer";
    if ($metode === "QRIS") $class = "badge-qris";
    return "<span class=\"badge $class\">$metode</span>";
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Laporan Pembayaran SPP</title>
<link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<div class="navbar">
    <h1>SI Pembayaran SPP</h1>
    <nav>
        <a href="index.php">Data Siswa</a>
        <a href="laporan.php">Laporan Pembayaran</a>
    </nav>
</div>

<div class="container">

    <div class="card">
        <h2>Ringkasan Laporan<?= $bulanFilter !== "" ? " - " . htmlspecialchars($bulanFilter) : "" ?></h2>
        <div class="stat-grid">
            <div class="stat-box">
                <div class="angka"><?= $jumlahTransaksi ?></div>
                <div class="label">Jumlah Transaksi</div>
            </div>
            <div class="stat-box">
                <div class="angka">Rp <?= number_format($totalLaporan, 0, ',', '.') ?></div>
                <div class="label">Total Pemasukan</div>
            </div>
            <div class="stat-box">
                <div class="angka">Rp <?= number_format($rataRata, 0, ',', '.') ?></div>
                <div class="label">Rata-rata per Transaksi</div>
            </div>
        </div>
    </div>

    <div class="card">
        <h2>Rekap Pemasukan per Kelas</h2>
        <?php if (count($rekap) === 0): ?>
            <p>Belum ada data pembayaran.</p>
        <?php else: ?>
            <?php foreach ($rekap as $r):
                $persen = $maxTotal > 0 ? round(($r['total'] / $maxTotal) * 100) : 0;
            ?>
            <div class="chart-row">
                <div class="chart-label"><?= htmlspecialchars($r['nama_kelas']) ?></div>
                <div class="chart-bar-track">
                    <div class="chart-bar-fill" style="width: <?= max($persen, 12) ?>%;">
                        Rp <?= number_format($r['total'], 0, ',', '.') ?>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <div class="card">
        <h2>Detail Transaksi Pembayaran</h2>

        <form method="GET" class="filter-bar" style="margin-bottom:20px;">
            <div class="form-group" style="max-width:260px;">
                <label>Filter Bulan</label>
                <input type="text" name="bulan" placeholder="contoh: Juli 2026" value="<?= htmlspecialchars($bulanFilter) ?>">
            </div>
            <button type="submit" class="btn btn-primary">Filter</button>
            <a href="laporan.php" class="btn btn-batal">Reset</a>
        </form>

        <table>
            <tr>
                <th>NIS</th>
                <th>Nama Siswa</th>
                <th>Kelas</th>
                <th>Bulan</th>
                <th>Tanggal</th>
                <th>Jumlah</th>
                <th>Metode</th>
                <th>Petugas</th>
            </tr>
            <?php if (count($rows) === 0): ?>
            <tr><td colspan="8" style="text-align:center;color:#888;">Tidak ada data untuk ditampilkan.</td></tr>
            <?php else: ?>
                <?php foreach ($rows as $row): ?>
                <tr>
                    <td><?= htmlspecialchars($row['nis']) ?></td>
                    <td><?= htmlspecialchars($row['nama_siswa']) ?></td>
                    <td><?= htmlspecialchars($row['nama_kelas']) ?></td>
                    <td><?= htmlspecialchars($row['bulan_bayar']) ?></td>
                    <td><?= htmlspecialchars($row['tanggal_bayar']) ?></td>
                    <td>Rp <?= number_format($row['jumlah_bayar'], 0, ',', '.') ?></td>
                    <td><?= badgeMetode($row['metode_bayar']) ?></td>
                    <td><?= htmlspecialchars($row['nama_petugas']) ?></td>
                </tr>
                <?php endforeach; ?>
                <tr class="total-row">
                    <td colspan="5" style="text-align:right;">Total</td>
                    <td>Rp <?= number_format($totalLaporan, 0, ',', '.') ?></td>
                    <td></td>
                    <td></td>
                </tr>
            <?php endif; ?>
        </table>
    </div>

</div>
</body>
</html>
