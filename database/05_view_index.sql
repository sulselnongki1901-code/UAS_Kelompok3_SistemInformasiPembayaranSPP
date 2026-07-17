-- ==========================================================
-- 05_view_index.sql
-- VIEW dan INDEX
-- ==========================================================
USE db_pembayaran_spp;

-- ==================== VIEW ====================
-- View laporan pembayaran: menggabungkan data pembayaran,
-- siswa, kelas, dan petugas agar mudah dipakai di halaman laporan.php
CREATE OR REPLACE VIEW v_laporan_pembayaran AS
SELECT
    p.id_pembayaran,
    s.nis,
    s.nama AS nama_siswa,
    k.nama_kelas,
    p.bulan_bayar,
    p.tanggal_bayar,
    p.jumlah_bayar,
    p.metode_bayar,
    pt.nama AS nama_petugas
FROM pembayaran p
JOIN siswa s    ON p.id_siswa = s.id_siswa
JOIN kelas k    ON s.id_kelas = k.id_kelas
JOIN petugas pt ON p.id_petugas = pt.id_petugas;

-- Contoh pemakaian view:
-- SELECT * FROM v_laporan_pembayaran WHERE bulan_bayar = 'Juli 2026';

-- ==================== INDEX ====================
-- Index pada NIS siswa untuk mempercepat pencarian data siswa
CREATE INDEX idx_siswa_nis ON siswa(nis);

-- Index pada tanggal_bayar untuk mempercepat filter laporan per tanggal
CREATE INDEX idx_pembayaran_tanggal ON pembayaran(tanggal_bayar);

-- Index pada bulan_bayar untuk mempercepat filter laporan per bulan
CREATE INDEX idx_pembayaran_bulan ON pembayaran(bulan_bayar);
