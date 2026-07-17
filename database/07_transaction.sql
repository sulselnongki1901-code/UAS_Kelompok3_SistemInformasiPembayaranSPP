-- ==========================================================
-- 07_transaction.sql
-- Contoh penggunaan TRANSACTION (COMMIT / ROLLBACK)
-- ==========================================================
USE db_pembayaran_spp;

-- ================== CONTOH DENGAN COMMIT ==================
-- Mencatat pembayaran baru. Jika semua query berhasil, data disimpan permanen.
START TRANSACTION;

INSERT INTO pembayaran (id_siswa, id_petugas, id_tarif, bulan_bayar, tanggal_bayar, jumlah_bayar, metode_bayar, keterangan)
VALUES (2, 1, 1, 'Agustus 2026', '2026-08-06', 250000.00, 'Tunai', 'Pembayaran lunas');

-- Jika tidak ada error, transaksi disimpan permanen
COMMIT;


-- ================== CONTOH DENGAN ROLLBACK ==================
-- Simulasi kegagalan: mencoba mencatat pembayaran untuk id_siswa
-- yang tidak ada di tabel siswa. Foreign key akan menolak insert
-- kedua, sehingga insert pertama pun dibatalkan agar data tetap konsisten.
START TRANSACTION;

INSERT INTO pembayaran (id_siswa, id_petugas, id_tarif, bulan_bayar, tanggal_bayar, jumlah_bayar, metode_bayar, keterangan)
VALUES (3, 1, 2, 'September 2026', '2026-09-05', 275000.00, 'Tunai', 'Pembayaran lunas');

-- Baris berikut akan GAGAL karena id_siswa = 999 tidak ada,
-- sehingga seluruh transaksi perlu dibatalkan
-- INSERT INTO pembayaran (id_siswa, id_petugas, id_tarif, bulan_bayar, tanggal_bayar, jumlah_bayar, metode_bayar)
-- VALUES (999, 1, 2, 'September 2026', '2026-09-05', 275000.00, 'Tunai');

-- Karena terjadi error pada baris di atas, batalkan semua perubahan:
ROLLBACK;

-- Catatan: pada aplikasi PHP, pola ini diimplementasikan dengan
-- mysqli->begin_transaction(), lalu commit()/rollback() tergantung
-- hasil query (lihat app/pembayaran_simpan.php).
