<?php
require "koneksi.php";

$id = intval($_GET['id']);

$stmt = mysqli_prepare($koneksi, "DELETE FROM siswa WHERE id_siswa = ?");
mysqli_stmt_bind_param($stmt, "i", $id);

try {
    mysqli_stmt_execute($stmt);
    header("Location: index.php?pesan=" . urlencode("Data siswa berhasil dihapus."));
} catch (mysqli_sql_exception $e) {
    // Terjadi jika siswa masih memiliki riwayat pembayaran (foreign key constraint)
    header("Location: index.php?pesan=" . urlencode("Gagal menghapus: siswa masih memiliki riwayat pembayaran."));
}
exit;
?>
