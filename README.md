# Sistem Informasi Pembayaran SPP

## Deskripsi
Aplikasi web berbasis PHP dan MySQL/MariaDB untuk mengelola data siswa, tarif SPP per kelas dan tahun ajaran, serta pencatatan transaksi pembayaran SPP. Aplikasi ini dibangun sebagai proyek terintegrasi mata kuliah Sistem Database dan Pemrograman Web.

## Anggota Kelompok
1. Nama - NIM
2. Nama - NIM
3. Nama - NIM
4. Nama - NIM

## Fitur Aplikasi
- Dashboard ringkasan (jumlah siswa, transaksi, total pemasukan) sekaligus tampil data siswa
- Tambah data siswa (tambah.php, simpan.php)
- Edit data siswa (edit.php, update.php)
- Hapus data siswa (hapus.php)
- Laporan pembayaran dengan filter per bulan dan rekap per kelas (laporan.php)
- Validasi input kosong pada semua form
- Konfirmasi sebelum menghapus data

## Struktur File Aplikasi (app/)
- `index.php` — halaman utama: dashboard + tampil data siswa
- `koneksi.php` — koneksi PHP ke database
- `tambah.php` — form tambah data siswa
- `simpan.php` — proses simpan data siswa ke database
- `edit.php` — form edit data siswa
- `update.php` — proses update data siswa
- `hapus.php` — proses hapus data siswa
- `laporan.php` — halaman laporan pembayaran SPP
- `assets/` — file CSS/JS/gambar

## Teknologi yang Digunakan
- PHP (mysqli, prepared statement)
- MySQL/MariaDB
- HTML, CSS
- XAMPP
- GitHub

## Struktur Database
1. `kelas` — data kelas (nama kelas, tingkat)
2. `tahun_ajaran` — data tahun ajaran dan semester
3. `siswa` — data siswa (FK ke kelas)
4. `petugas` — data staf yang mencatat pembayaran
5. `tarif_spp` — nominal SPP per kelas per tahun ajaran (FK ke kelas dan tahun_ajaran)
6. `pembayaran` — transaksi pembayaran SPP (FK ke siswa, petugas, tarif_spp)

Dilengkapi 1 view (`v_laporan_pembayaran`), 3 index, DCL (GRANT/REVOKE untuk user `staff_spp`), serta contoh transaksi COMMIT/ROLLBACK. Lihat folder `database/` untuk script lengkap.

## Cara Menjalankan Aplikasi
1. Aktifkan Apache dan MySQL di XAMPP.
2. Buat database melalui phpMyAdmin, lalu jalankan script SQL secara berurutan dari folder `database/`:
   - `01_create_database.sql`
   - `02_create_tables.sql`
   - `03_insert_data.sql`
   - `04_query_lanjutan.sql` (opsional, untuk melihat hasil query)
   - `05_view_index.sql`
   - `06_dcl.sql`
   - `07_transaction.sql` (opsional, contoh transaksi)
3. Salin folder `app/` ke `htdocs` (misalnya `htdocs/spp/`).
4. Sesuaikan kredensial database di `app/koneksi.php` jika perlu.
5. Jalankan aplikasi melalui browser: `http://localhost/spp/`.

## Pembagian Tugas
| No | Nama Anggota | NIM | Tugas Utama |
|----|--------------|-----|-------------|
| 1  |              |     | Analisis kebutuhan dan ERD |
| 2  |              |     | Normalisasi dan SQL database |
| 3  |              |     | Koneksi database dan CRUD |
| 4  |              |     | Tampilan web dan validasi |
| 5  |              |     | Laporan, dokumentasi, dan presentasi |
