<?php
// koneksi.php
// File koneksi PHP ke database MySQL/MariaDB menggunakan mysqli

$host     = "localhost";
$username = "root";
$password = "";
$database = "db_pembayaran_spp";

$koneksi = mysqli_connect($host, $username, $password, $database);

if (!$koneksi) {
    die("Koneksi ke database gagal: " . mysqli_connect_error());
}

// Set charset agar teks (nama siswa, dll) tidak error
mysqli_set_charset($koneksi, "utf8mb4");
?>
