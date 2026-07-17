-- ==========================================================
-- 04_query_lanjutan.sql
-- Query JOIN dan Aggregate Function
-- ==========================================================
USE db_pembayaran_spp;

-- ==================== QUERY JOIN 1 ====================
-- Menampilkan riwayat pembayaran lengkap: nama siswa, kelas,
-- bulan bayar, nominal, dan petugas yang mencatat
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
JOIN siswa s   ON p.id_siswa = s.id_siswa
JOIN kelas k   ON s.id_kelas = k.id_kelas
JOIN petugas pt ON p.id_petugas = pt.id_petugas
ORDER BY p.tanggal_bayar DESC;

-- ==================== QUERY JOIN 2 ====================
-- Menampilkan daftar tarif SPP lengkap dengan nama kelas
-- dan tahun ajaran
SELECT
    ts.id_tarif,
    k.nama_kelas,
    ta.tahun,
    ta.semester,
    ts.nominal
FROM tarif_spp ts
JOIN kelas k         ON ts.id_kelas = k.id_kelas
JOIN tahun_ajaran ta ON ts.id_tahun_ajaran = ta.id_tahun_ajaran
ORDER BY k.nama_kelas;

-- ==================== AGGREGATE 1 ====================
-- Menghitung total pembayaran (SUM) dan jumlah transaksi (COUNT)
-- per siswa
SELECT
    s.nis,
    s.nama,
    COUNT(p.id_pembayaran) AS jumlah_transaksi,
    SUM(p.jumlah_bayar) AS total_dibayar
FROM siswa s
LEFT JOIN pembayaran p ON s.id_siswa = p.id_siswa
GROUP BY s.id_siswa, s.nis, s.nama
ORDER BY total_dibayar DESC;

-- ==================== AGGREGATE 2 ====================
-- Menghitung jumlah siswa per kelas dan rata-rata (AVG)
-- nominal SPP yang harus dibayar per kelas
SELECT
    k.nama_kelas,
    COUNT(s.id_siswa) AS jumlah_siswa,
    AVG(ts.nominal) AS rata_rata_tarif,
    MAX(ts.nominal) AS tarif_tertinggi,
    MIN(ts.nominal) AS tarif_terendah
FROM kelas k
LEFT JOIN siswa s ON k.id_kelas = s.id_kelas
LEFT JOIN tarif_spp ts ON k.id_kelas = ts.id_kelas
GROUP BY k.id_kelas, k.nama_kelas;
