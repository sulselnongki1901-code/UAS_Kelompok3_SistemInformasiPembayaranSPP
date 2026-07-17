<?php
require "koneksi.php";

// Statistik ringkas untuk dashboard
$totalSiswa = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM siswa"))['total'];
$totalTransaksi = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM pembayaran"))['total'];
$totalPemasukan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COALESCE(SUM(jumlah_bayar),0) AS total FROM pembayaran"))['total'];

// Query JOIN: tampil data siswa lengkap dengan nama kelasnya
$query = "SELECT s.id_siswa, s.nis, s.nama, k.nama_kelas, s.alamat, s.no_hp
          FROM siswa s
          JOIN kelas k ON s.id_kelas = k.id_kelas
          ORDER BY s.nama ASC";
$hasil = mysqli_query($koneksi, $query);
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Sistem Informasi Pembayaran SPP</title>
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
        <h2>Dashboard</h2>
        <div class="stat-grid">
            <div class="stat-box">
                <div class="angka"><?= $totalSiswa ?></div>
                <div class="label">Total Siswa</div>
            </div>
            <div class="stat-box">
                <div class="angka"><?= $totalTransaksi ?></div>
                <div class="label">Total Transaksi Pembayaran</div>
            </div>
            <div class="stat-box">
                <div class="angka">Rp <?= number_format($totalPemasukan, 0, ',', '.') ?></div>
                <div class="label">Total Pemasukan SPP</div>
            </div>
        </div>
    </div>

    <div class="card">
        <h2>Data Siswa</h2>

        <?php if (isset($_GET['pesan'])): ?>
            <div class="alert alert-success"><?= htmlspecialchars($_GET['pesan']) ?></div>
        <?php endif; ?>

        <a class="btn btn-primary" href="tambah.php" style="margin-bottom:16px;display:inline-block;">+ Tambah Data Siswa</a>

        <table>
            <tr>
                <th>NIS</th>
                <th>Nama</th>
                <th>Kelas</th>
                <th>Alamat</th>
                <th>No. HP</th>
                <th>Aksi</th>
            </tr>
            <?php while ($row = mysqli_fetch_assoc($hasil)): ?>
            <tr>
                <td><?= htmlspecialchars($row['nis']) ?></td>
                <td><?= htmlspecialchars($row['nama']) ?></td>
                <td><?= htmlspecialchars($row['nama_kelas']) ?></td>
                <td><?= htmlspecialchars($row['alamat']) ?></td>
                <td><?= htmlspecialchars($row['no_hp']) ?></td>
                <td>
                    <a class="btn btn-edit" href="edit.php?id=<?= $row['id_siswa'] ?>">Edit</a>
                    <a class="btn btn-hapus" href="hapus.php?id=<?= $row['id_siswa'] ?>"
                       onclick="return confirmHapus();">Hapus</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>

</div>
<script src="assets/js/script.js"></script>
</body>
</html>
