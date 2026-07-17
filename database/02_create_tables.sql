-- ==========================================================
-- 02_create_tables.sql
-- DDL: CREATE TABLE untuk seluruh entitas
-- ==========================================================
USE db_pembayaran_spp;

-- 1. Tabel Kelas
CREATE TABLE kelas (
    id_kelas INT AUTO_INCREMENT PRIMARY KEY,
    nama_kelas VARCHAR(20) NOT NULL,
    tingkat VARCHAR(20) NOT NULL
) ENGINE=InnoDB;

-- 2. Tabel Tahun Ajaran
CREATE TABLE tahun_ajaran (
    id_tahun_ajaran INT AUTO_INCREMENT PRIMARY KEY,
    tahun VARCHAR(20) NOT NULL,
    semester ENUM('Ganjil','Genap') NOT NULL
) ENGINE=InnoDB;

-- 3. Tabel Petugas (admin/tata usaha)
CREATE TABLE petugas (
    id_petugas INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role VARCHAR(20) NOT NULL DEFAULT 'staff'
) ENGINE=InnoDB;

-- 4. Tabel Siswa (FK ke kelas)
CREATE TABLE siswa (
    id_siswa INT AUTO_INCREMENT PRIMARY KEY,
    nis VARCHAR(20) NOT NULL UNIQUE,
    nama VARCHAR(100) NOT NULL,
    id_kelas INT NOT NULL,
    alamat VARCHAR(200),
    no_hp VARCHAR(20),
    CONSTRAINT fk_siswa_kelas FOREIGN KEY (id_kelas)
        REFERENCES kelas(id_kelas)
        ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB;

-- 5. Tabel Tarif SPP (FK ke kelas dan tahun_ajaran)
CREATE TABLE tarif_spp (
    id_tarif INT AUTO_INCREMENT PRIMARY KEY,
    id_kelas INT NOT NULL,
    id_tahun_ajaran INT NOT NULL,
    nominal DECIMAL(10,2) NOT NULL,
    CONSTRAINT fk_tarif_kelas FOREIGN KEY (id_kelas)
        REFERENCES kelas(id_kelas)
        ON UPDATE CASCADE ON DELETE RESTRICT,
    CONSTRAINT fk_tarif_tahun FOREIGN KEY (id_tahun_ajaran)
        REFERENCES tahun_ajaran(id_tahun_ajaran)
        ON UPDATE CASCADE ON DELETE RESTRICT,
    UNIQUE KEY uq_tarif (id_kelas, id_tahun_ajaran)
) ENGINE=InnoDB;

-- 6. Tabel Pembayaran (FK ke siswa, petugas, tarif_spp)
CREATE TABLE pembayaran (
    id_pembayaran INT AUTO_INCREMENT PRIMARY KEY,
    id_siswa INT NOT NULL,
    id_petugas INT NOT NULL,
    id_tarif INT NOT NULL,
    bulan_bayar VARCHAR(20) NOT NULL,
    tanggal_bayar DATE NOT NULL,
    jumlah_bayar DECIMAL(10,2) NOT NULL,
    metode_bayar ENUM('Tunai','Transfer','QRIS') NOT NULL DEFAULT 'Tunai',
    keterangan VARCHAR(200),
    CONSTRAINT fk_bayar_siswa FOREIGN KEY (id_siswa)
        REFERENCES siswa(id_siswa)
        ON UPDATE CASCADE ON DELETE RESTRICT,
    CONSTRAINT fk_bayar_petugas FOREIGN KEY (id_petugas)
        REFERENCES petugas(id_petugas)
        ON UPDATE CASCADE ON DELETE RESTRICT,
    CONSTRAINT fk_bayar_tarif FOREIGN KEY (id_tarif)
        REFERENCES tarif_spp(id_tarif)
        ON UPDATE CASCADE ON DELETE RESTRICT,
    CONSTRAINT uq_bayar_bulan UNIQUE (id_siswa, bulan_bayar)
) ENGINE=InnoDB;
