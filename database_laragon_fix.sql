-- =====================================================
-- DATABASE UNTUK WEBSITE SEKOLAH - LARAGON (FIX VERSION)
-- Copy dan paste ini di phpMyAdmin Laragon
-- =====================================================

-- Buat database jika belum ada
CREATE DATABASE IF NOT EXISTS website_sekolah;
USE website_sekolah;

-- Hapus tabel yang ada (untuk fresh install)
SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE IF EXISTS pelanggaran;
DROP TABLE IF EXISTS jadwal_piket;
DROP TABLE IF EXISTS izin_keluar;
DROP TABLE IF EXISTS keterlambatan;
DROP TABLE IF EXISTS piket;
DROP TABLE IF EXISTS siswa;
DROP TABLE IF EXISTS guru;
DROP TABLE IF EXISTS users;
SET FOREIGN_KEY_CHECKS = 1;

-- =====================================================
-- 1. TABEL USERS (untuk login)
-- =====================================================
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role VARCHAR(20) DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- =====================================================
-- 2. TABEL GURU
-- =====================================================
CREATE TABLE guru (
    id_guru INT AUTO_INCREMENT PRIMARY KEY,
    nip VARCHAR(50) UNIQUE NOT NULL,
    nama VARCHAR(100) NOT NULL,
    jabatan VARCHAR(50) NOT NULL,
    jenis_kelamin VARCHAR(20),
    email VARCHAR(100),
    telepon VARCHAR(20),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- =====================================================
-- 3. TABEL SISWA
-- =====================================================
CREATE TABLE siswa (
    id_siswa INT AUTO_INCREMENT PRIMARY KEY,
    nis VARCHAR(20) UNIQUE NOT NULL,
    nama VARCHAR(100) NOT NULL,
    kelas VARCHAR(20) NOT NULL,
    jenis_kelamin VARCHAR(20),
    jurusan VARCHAR(50),
    qr_code VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- =====================================================
-- 4. TABEL PELANGGARAN
-- =====================================================
CREATE TABLE pelanggaran (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_siswa INT NOT NULL,
    id_guru INT NULL,
    tanggal DATE NOT NULL,
    jenis_pelanggaran VARCHAR(100) NOT NULL,
    keterangan TEXT,
    sanksi TEXT,
    poin INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_siswa) REFERENCES siswa(id_siswa) ON DELETE CASCADE,
    FOREIGN KEY (id_guru) REFERENCES guru(id_guru) ON DELETE SET NULL
);

-- =====================================================
-- 5. TABEL IZIN_KELUAR
-- =====================================================
CREATE TABLE izin_keluar (
    id_izin INT AUTO_INCREMENT PRIMARY KEY,
    id_siswa INT NOT NULL,
    id_guru INT NOT NULL,
    alasan TEXT NOT NULL,
    waktu_keluar DATETIME NOT NULL,
    waktu_kembali DATETIME,
    status VARCHAR(20) DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_siswa) REFERENCES siswa(id_siswa) ON DELETE CASCADE,
    FOREIGN KEY (id_guru) REFERENCES guru(id_guru) ON DELETE CASCADE
);

-- =====================================================
-- 6. TABEL KETERLAMBATAN
-- =====================================================
CREATE TABLE keterlambatan (
    id_telat INT AUTO_INCREMENT PRIMARY KEY,
    id_siswa INT NOT NULL,
    id_guru INT NOT NULL,
    waktu_datang DATETIME NOT NULL,
    keterangan TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_siswa) REFERENCES siswa(id_siswa) ON DELETE CASCADE,
    FOREIGN KEY (id_guru) REFERENCES guru(id_guru) ON DELETE CASCADE
);

-- =====================================================
-- 7. TABEL PIKET
-- =====================================================
CREATE TABLE piket (
    id_piket INT AUTO_INCREMENT PRIMARY KEY,
    id_guru INT NOT NULL,
    tanggal DATE NOT NULL,
    hari VARCHAR(20),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_guru) REFERENCES guru(id_guru) ON DELETE CASCADE
);

-- =====================================================
-- 8. TABEL JADWAL_PIKET
-- =====================================================
CREATE TABLE jadwal_piket (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_guru INT NOT NULL,
    hari VARCHAR(20) NOT NULL,
    jam_mulai TIME NOT NULL,
    jam_selesai TIME NOT NULL,
    semester VARCHAR(20) NOT NULL,
    tahun_ajaran YEAR NOT NULL,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_guru) REFERENCES guru(id_guru) ON DELETE CASCADE
);

-- =====================================================
-- INSERT DATA CONTOH
-- =====================================================

-- Users untuk login
INSERT INTO users (name, email, password, role) VALUES
('Administrator', 'admin@eduspace.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin'),
('Ahmad Susanto', 'guru@eduspace.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'guru'),
('Dr. Budi Santoso', 'kepsek@eduspace.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'kepsek');

-- Data Guru
INSERT INTO guru (nip, nama, jabatan, jenis_kelamin, email, telepon) VALUES
('198001012001121001', 'Ahmad Susanto, S.Pd', 'Guru BK', 'Laki-laki', 'ahmad@sekolah.sch.id', '081234567890'),
('197503152000032001', 'Siti Nurhaliza, S.Pd', 'Wali Kelas X', 'Perempuan', 'siti@sekolah.sch.id', '081234567891'),
('198005012005011001', 'Dr. Budi Santoso, M.Pd', 'Kepala Sekolah', 'Laki-laki', 'budi@sekolah.sch.id', '081234567892'),
('198508152010011001', 'Dewi Kartika, S.Pd', 'Wali Kelas XI', 'Perempuan', 'dewi@sekolah.sch.id', '081234567893'),
('199001012015021001', 'Rudi Hartono, S.Kom', 'Guru TIK', 'Laki-laki', 'rudi@sekolah.sch.id', '081234567894');

-- Data Siswa
INSERT INTO siswa (nis, nama, kelas, jenis_kelamin, jurusan) VALUES
('2021001', 'Andi Pratama', 'X RPL 1', 'Laki-laki', 'Rekayasa Perangkat Lunak'),
('2021002', 'Siti Aisyah', 'X RPL 1', 'Perempuan', 'Rekayasa Perangkat Lunak'),
('2021003', 'Budi Santoso', 'X RPL 2', 'Laki-laki', 'Rekayasa Perangkat Lunak'),
('2021004', 'Dewi Lestari', 'X TKJ 1', 'Perempuan', 'Teknik Komputer Jaringan'),
('2021005', 'Rudi Hermawan', 'X TKJ 1', 'Laki-laki', 'Teknik Komputer Jaringan'),
('2021006', 'Maya Sari', 'XI RPL 1', 'Perempuan', 'Rekayasa Perangkat Lunak'),
('2021007', 'Eko Prasetyo', 'XI RPL 2', 'Laki-laki', 'Rekayasa Perangkat Lunak'),
('2021008', 'Fitri Handayani', 'XI TKJ 1', 'Perempuan', 'Teknik Komputer Jaringan'),
('2021009', 'Hendro Wijaya', 'XII RPL 1', 'Laki-laki', 'Rekayasa Perangkat Lunak'),
('2021010', 'Indah Permata', 'XII TKJ 1', 'Perempuan', 'Teknik Komputer Jaringan');

-- Jadwal Piket
INSERT INTO jadwal_piket (id_guru, hari, jam_mulai, jam_selesai, semester, tahun_ajaran) VALUES
(2, 'Senin', '07:00:00', '14:00:00', 'Ganjil', 2024),
(3, 'Selasa', '07:00:00', '14:00:00', 'Ganjil', 2024),
(4, 'Rabu', '07:00:00', '14:00:00', 'Ganjil', 2024),
(5, 'Kamis', '07:00:00', '14:00:00', 'Ganjil', 2024),
(2, 'Jumat', '07:00:00', '14:00:00', 'Ganjil', 2024);

-- Contoh Pelanggaran
INSERT INTO pelanggaran (id_siswa, id_guru, tanggal, jenis_pelanggaran, keterangan, sanksi, poin) VALUES
(1, 2, '2024-05-01', 'Terlambat', 'Terlambat 15 menit', 'Membersihkan kelas', 5),
(2, 2, '2024-05-02', 'Tidak Pakai Seragam', 'Seragam tidak lengkap', 'Surat peringatan', 10),
(3, 3, '2024-05-03', 'Main HP', 'HP saat pelajaran', 'HP disita 1 minggu', 15),
(4, 4, '2024-05-01', 'Tidak Masuk', 'Tanpa keterangan', 'Panggil orang tua', 20),
(5, 5, '2024-05-02', 'Bertengkar', 'Dengan teman', 'Konseling BK', 10);

-- Contoh Izin Keluar
INSERT INTO izin_keluar (id_siswa, id_guru, alasan, waktu_keluar, status) VALUES
(1, 2, 'Sakit', '2024-05-01 10:00:00', 'approved'),
(2, 3, 'Keperluan keluarga', '2024-05-02 09:30:00', 'pending'),
(3, 4, 'Sakit', '2024-05-03 08:00:00', 'approved');

-- Contoh Keterlambatan
INSERT INTO keterlambatan (id_siswa, id_guru, waktu_datang, keterangan) VALUES
(1, 2, '2024-05-01 07:15:00', 'Macet'),
(2, 3, '2024-05-02 07:30:00', 'Bangun kesiangan'),
(3, 4, '2024-05-03 07:10:00', 'Hujan'),
(4, 5, '2024-05-01 07:45:00', 'Sakit'),
(5, 2, '2024-05-02 07:20:00', 'Kendaraan rusak');

-- Data Piket
INSERT INTO piket (id_guru, tanggal, hari) VALUES
(2, '2024-05-06', 'Senin'),
(3, '2024-05-07', 'Selasa'),
(4, '2024-05-08', 'Rabu'),
(5, '2024-05-09', 'Kamis'),
(2, '2024-05-10', 'Jumat');

-- =====================================================
-- SELESAI! Database sudah siap digunakan
-- =====================================================

SELECT 'Database berhasil dibuat!' as status;
SELECT COUNT(*) as total_tables FROM information_schema.tables WHERE table_schema = 'website_sekolah';
