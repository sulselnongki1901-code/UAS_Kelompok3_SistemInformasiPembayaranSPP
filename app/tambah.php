<?php
require "koneksi.php";
$kelas = mysqli_query($koneksi, "SELECT id_kelas, nama_kelas FROM kelas ORDER BY nama_kelas");
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Tambah Data Siswa</title>
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
    <h2>Tambah Data Siswa</h2>

    <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-error"><?= htmlspecialchars($_GET['error']) ?></div>
    <?php endif; ?>

    <form action="simpan.php" method="POST">
        <div class="form-group">
            <label>NIS</label>
            <input type="text" name="nis" required>
        </div>
        <div class="form-group">
            <label>Nama Lengkap</label>
            <input type="text" name="nama" required>
        </div>
        <div class="form-group">
            <label>Kelas</label>
            <select name="id_kelas" required>
                <option value="">-- Pilih Kelas --</option>
                <?php while ($k = mysqli_fetch_assoc($kelas)): ?>
                    <option value="<?= $k['id_kelas'] ?>"><?= htmlspecialchars($k['nama_kelas']) ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="form-group">
            <label>Alamat</label>
            <input type="text" name="alamat">
        </div>
        <div class="form-group">
            <label>No. HP</label>
            <input type="text" name="no_hp">
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="index.php" class="btn btn-batal">Batal</a>
    </form>
</div>
</div>
</body>
</html>
