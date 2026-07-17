-- ==========================================================
-- 06_dcl.sql
-- DCL: Data Control Language (GRANT / REVOKE)
-- ==========================================================
USE db_pembayaran_spp;

-- Membuat user baru untuk staf tata usaha (hanya boleh input & lihat
-- pembayaran, tidak boleh menghapus data)
CREATE USER IF NOT EXISTS 'staff_spp'@'localhost' IDENTIFIED BY 'StaffSPP#2026';

-- Memberikan hak akses SELECT, INSERT, UPDATE pada tabel yang relevan
GRANT SELECT, INSERT, UPDATE ON db_pembayaran_spp.siswa TO 'staff_spp'@'localhost';
GRANT SELECT, INSERT, UPDATE ON db_pembayaran_spp.pembayaran TO 'staff_spp'@'localhost';
GRANT SELECT ON db_pembayaran_spp.kelas TO 'staff_spp'@'localhost';
GRANT SELECT ON db_pembayaran_spp.tarif_spp TO 'staff_spp'@'localhost';
GRANT SELECT ON db_pembayaran_spp.v_laporan_pembayaran TO 'staff_spp'@'localhost';

-- Staf tata usaha TIDAK diberi hak DELETE agar data transaksi tidak
-- bisa dihapus sembarangan (hanya admin yang boleh)
REVOKE DELETE ON db_pembayaran_spp.pembayaran FROM 'staff_spp'@'localhost';

FLUSH PRIVILEGES;

-- Cek hak akses user
-- SHOW GRANTS FOR 'staff_spp'@'localhost';
