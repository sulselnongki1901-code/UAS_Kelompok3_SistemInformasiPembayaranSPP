<?php
require "koneksi.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nis      = trim($_POST['nis']);
    $nama     = trim($_POST['nama']);
    $id_kelas = trim($_POST['id_kelas']);
    $alamat   = trim($_POST['alamat']);
    $no_hp    = trim($_POST['no_hp']);

    // Validasi input kosong (wajib diisi: NIS, nama, kelas)
    if ($nis === "" || $nama === "" || $id_kelas === "") {
        header("Location: tambah.php?error=" . urlencode("NIS, Nama, dan Kelas wajib diisi."));
        exit;
    }

    // Menggunakan prepared statement agar aman dari SQL Injection
    $stmt = mysqli_prepare($koneksi,
        "INSERT INTO siswa (nis, nama, id_kelas, alamat, no_hp) VALUES (?, ?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "ssiss", $nis, $nama, $id_kelas, $alamat, $no_hp);

    try {
        mysqli_stmt_execute($stmt);
        header("Location: index.php?pesan=" . urlencode("Data siswa berhasil ditambahkan."));
    } catch (mysqli_sql_exception $e) {
        // Terjadi jika NIS sudah terdaftar (unique constraint) atau kelas tidak valid
        header("Location: tambah.php?error=" . urlencode("Gagal menyimpan data. NIS mungkin sudah terdaftar."));
    }
    exit;
}
?>
