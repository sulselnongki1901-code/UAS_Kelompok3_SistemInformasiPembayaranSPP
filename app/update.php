<?php
require "koneksi.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $id_siswa = intval($_POST['id_siswa']);
    $nis      = trim($_POST['nis']);
    $nama     = trim($_POST['nama']);
    $id_kelas = trim($_POST['id_kelas']);
    $alamat   = trim($_POST['alamat']);
    $no_hp    = trim($_POST['no_hp']);

    // Validasi input kosong
    if ($nis === "" || $nama === "" || $id_kelas === "") {
        header("Location: edit.php?id=" . $id_siswa . "&error=1");
        exit;
    }

    $stmt = mysqli_prepare($koneksi,
        "UPDATE siswa SET nis = ?, nama = ?, id_kelas = ?, alamat = ?, no_hp = ? WHERE id_siswa = ?");
    mysqli_stmt_bind_param($stmt, "ssissi", $nis, $nama, $id_kelas, $alamat, $no_hp, $id_siswa);

    try {
        mysqli_stmt_execute($stmt);
        header("Location: index.php?pesan=" . urlencode("Data siswa berhasil diperbarui."));
    } catch (mysqli_sql_exception $e) {
        // Terjadi jika NIS bentrok dengan siswa lain (unique constraint)
        header("Location: edit.php?id=" . $id_siswa . "&error=" . urlencode("Gagal update: NIS mungkin sudah dipakai siswa lain."));
    }
    exit;
}
?>
