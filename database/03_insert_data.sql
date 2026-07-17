-- ==========================================================
-- 03_insert_data.sql
-- DML: INSERT data contoh
-- ==========================================================
USE db_pembayaran_spp;

-- Data kelas
INSERT INTO kelas (nama_kelas, tingkat) VALUES
('VII A', 'VII'),
('VIII A', 'VIII'),
('IX A', 'IX');

-- Data tahun ajaran
INSERT INTO tahun_ajaran (tahun, semester) VALUES
('2025/2026', 'Ganjil'),
('2025/2026', 'Genap');

-- Data petugas
-- password contoh sudah di-hash dengan password_hash() PHP (nilai asli: "admin123")
INSERT INTO petugas (nama, username, password, role) VALUES
('Siti Rahma', 'siti.tu', '$2y$10$examplehashvalueforadminaccount1234567890abcdefghij', 'admin'),
('Budi Santoso', 'budi.tu', '$2y$10$examplehashvalueforstaffaccount01234567890abcdefghij', 'staff');

-- Data siswa
INSERT INTO siswa (nis, nama, id_kelas, alamat, no_hp) VALUES
('2025001', 'Andi Pratama', 1, 'Jl. Merdeka No. 10', '081234567001'),
('2025002', 'Bella Aulia', 1, 'Jl. Sudirman No. 5', '081234567002'),
('2024011', 'Citra Dewi', 2, 'Jl. Diponegoro No. 22', '081234567003'),
('2024012', 'Dimas Arya', 2, 'Jl. Ahmad Yani No. 8', '081234567004'),
('2023005', 'Eka Wulandari', 3, 'Jl. Gatot Subroto No. 15', '081234567005');

-- Data tarif SPP per kelas per tahun ajaran (semester ganjil)
INSERT INTO tarif_spp (id_kelas, id_tahun_ajaran, nominal) VALUES
(1, 1, 250000.00),
(2, 1, 275000.00),
(3, 1, 300000.00);

-- Data pembayaran
INSERT INTO pembayaran (id_siswa, id_petugas, id_tarif, bulan_bayar, tanggal_bayar, jumlah_bayar, metode_bayar, keterangan) VALUES
(1, 2, 1, 'Juli 2026', '2026-07-05', 250000.00, 'Tunai', 'Pembayaran lunas'),
(2, 2, 1, 'Juli 2026', '2026-07-05', 250000.00, 'Transfer', 'Pembayaran lunas'),
(3, 1, 2, 'Juli 2026', '2026-07-06', 275000.00, 'QRIS', 'Pembayaran lunas'),
(4, 1, 2, 'Juli 2026', '2026-07-07', 275000.00, 'Tunai', 'Pembayaran lunas'),
(5, 2, 3, 'Juli 2026', '2026-07-08', 300000.00, 'Transfer', 'Pembayaran lunas'),
(1, 2, 1, 'Agustus 2026', '2026-08-05', 250000.00, 'Tunai', 'Pembayaran lunas');
