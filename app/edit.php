<?php
require "koneksi.php";

$id = intval($_GET['id']);

$stmt = mysqli_prepare($koneksi, "SELECT * FROM siswa WHERE id_siswa = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$siswa = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

$kelas = mysqli_query($koneksi, "SELECT id_kelas, nama_kelas FROM kelas ORDER BY nama_kelas");
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Edit Data Siswa</title>
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
    <h2>Edit Data Siswa</h2>

    <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-error"><?= htmlspecialchars($_GET['error'] === "1" ? "NIS, Nama, dan Kelas wajib diisi." : $_GET['error']) ?></div>
    <?php endif; ?>

    <?php if (!$siswa): ?>
        <p>Data siswa tidak ditemukan.</p>
    <?php else: ?>
        <form action="update.php" method="POST">
            <input type="hidden" name="id_siswa" value="<?= $siswa['id_siswa'] ?>">
            <div class="form-group">
                <label>NIS</label>
                <input type="text" name="nis" value="<?= htmlspecialchars($siswa['nis']) ?>" required>
            </div>
            <div class="form-group">
                <label>Nama Lengkap</label>
                <input type="text" name="nama" value="<?= htmlspecialchars($siswa['nama']) ?>" required>
            </div>
            <div class="form-group">
                <label>Kelas</label>
                <select name="id_kelas" required>
                    <?php while ($k = mysqli_fetch_assoc($kelas)): ?>
                        <option value="<?= $k['id_kelas'] ?>" <?= $k['id_kelas'] == $siswa['id_kelas'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($k['nama_kelas']) ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="form-group">
                <label>Alamat</label>
                <input type="text" name="alamat" value="<?= htmlspecialchars($siswa['alamat']) ?>">
            </div>
            <div class="form-group">
                <label>No. HP</label>
                <input type="text" name="no_hp" value="<?= htmlspecialchars($siswa['no_hp']) ?>">
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="index.php" class="btn btn-batal">Batal</a>
        </form>
    <?php endif; ?>
</div>
</div>
</body>
</html>
