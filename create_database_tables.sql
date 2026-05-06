-- =====================================================
-- Database Schema for Website Sekolah (Laravel Application)
-- Created based on existing Laravel migrations and features
-- =====================================================

-- Drop existing tables if they exist (for fresh installation)
SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE IF EXISTS user_sessions;
DROP TABLE IF EXISTS pelanggaran;
DROP TABLE IF EXISTS jadwal_piket;
DROP TABLE IF EXISTS izin_keluar;
DROP TABLE IF EXISTS keterlambatan;
DROP TABLE IF EXISTS piket;
DROP TABLE IF EXISTS siswa;
DROP TABLE IF EXISTS guru;
DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS cache;
DROP TABLE IF EXISTS jobs;
DROP TABLE IF EXISTS failed_jobs;
SET FOREIGN_KEY_CHECKS = 1;

-- =====================================================
-- 1. USERS TABLE (Authentication)
-- =====================================================
CREATE TABLE users (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    email_verified_at TIMESTAMP NULL,
    password VARCHAR(255) NOT NULL,
    role VARCHAR(20) DEFAULT 'user',
    remember_token VARCHAR(100) NULL,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- =====================================================
-- 2. CACHE TABLE
-- =====================================================
CREATE TABLE cache (
    key VARCHAR(255) PRIMARY KEY,
    value LONGTEXT NOT NULL,
    expiration INT NOT NULL
);

-- =====================================================
-- 3. JOBS TABLE
-- =====================================================
CREATE TABLE jobs (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    queue VARCHAR(255) NOT NULL,
    payload LONGTEXT NOT NULL,
    attempts TINYINT UNSIGNED NOT NULL,
    reserved_at INT UNSIGNED NULL,
    available_at INT UNSIGNED NOT NULL,
    created_at INT UNSIGNED NOT NULL
);

-- =====================================================
-- 4. FAILED_JOBS TABLE
-- =====================================================
CREATE TABLE failed_jobs (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    uuid VARCHAR(255) UNIQUE NOT NULL,
    connection TEXT NOT NULL,
    queue TEXT NOT NULL,
    payload LONGTEXT NOT NULL,
    exception LONGTEXT NOT NULL,
    failed_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);

-- =====================================================
-- 5. SISWA TABLE (Students)
-- =====================================================
CREATE TABLE siswa (
    id_siswa BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nis VARCHAR(20) UNIQUE NOT NULL,
    nama VARCHAR(100) NOT NULL,
    kelas VARCHAR(20) NOT NULL,
    jenis_kelamin VARCHAR(20) NULL,
    jurusan VARCHAR(50) NULL,
    qr_code VARCHAR(255) UNIQUE NULL,
    qr_code_data TEXT NULL,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- =====================================================
-- 6. GURU TABLE (Teachers)
-- =====================================================
CREATE TABLE guru (
    id_guru BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nip VARCHAR(255) UNIQUE NOT NULL,
    nama VARCHAR(100) NOT NULL,
    jabatan VARCHAR(50) NOT NULL,
    jenis_kelamin VARCHAR(20) NULL,
    email VARCHAR(255) UNIQUE NULL,
    telepon VARCHAR(20) NULL,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- =====================================================
-- 7. PIKET TABLE (Duty Schedule)
-- =====================================================
CREATE TABLE piket (
    id_piket BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_guru BIGINT UNSIGNED NOT NULL,
    tanggal DATE NOT NULL,
    hari VARCHAR(20) NULL,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_guru) REFERENCES guru(id_guru) ON DELETE CASCADE
);

-- =====================================================
-- 8. IZIN_KELUAR TABLE (Exit Permits)
-- =====================================================
CREATE TABLE izin_keluar (
    id_izin BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_siswa BIGINT UNSIGNED NOT NULL,
    id_guru BIGINT UNSIGNED NOT NULL,
    alasan TEXT NOT NULL,
    waktu_keluar DATETIME NOT NULL,
    waktu_kembali DATETIME NULL,
    status VARCHAR(20) DEFAULT 'pending',
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_siswa) REFERENCES siswa(id_siswa) ON DELETE CASCADE,
    FOREIGN KEY (id_guru) REFERENCES guru(id_guru) ON DELETE CASCADE
);

-- =====================================================
-- 9. KETERLAMBATAN TABLE (Late Arrivals)
-- =====================================================
CREATE TABLE keterlambatan (
    id_telat BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_siswa BIGINT UNSIGNED NOT NULL,
    id_guru BIGINT UNSIGNED NOT NULL,
    waktu_datang DATETIME NOT NULL,
    keterangan TEXT NULL,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_siswa) REFERENCES siswa(id_siswa) ON DELETE CASCADE,
    FOREIGN KEY (id_guru) REFERENCES guru(id_guru) ON DELETE CASCADE
);

-- =====================================================
-- 10. PELANGGARAN TABLE (Violations)
-- =====================================================
CREATE TABLE pelanggaran (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_siswa BIGINT UNSIGNED NOT NULL,
    id_guru BIGINT UNSIGNED NULL,
    tanggal DATE NOT NULL,
    jenis_pelanggaran VARCHAR(100) NOT NULL,
    keterangan TEXT NULL,
    sanksi TEXT NULL,
    poin INT DEFAULT 0,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_siswa) REFERENCES siswa(id_siswa) ON DELETE CASCADE,
    FOREIGN KEY (id_guru) REFERENCES guru(id_guru) ON DELETE SET NULL
);

-- =====================================================
-- 11. JADWAL_PIKET TABLE (Duty Schedule Template)
-- =====================================================
CREATE TABLE jadwal_piket (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_guru BIGINT UNSIGNED NOT NULL,
    hari VARCHAR(20) NOT NULL,
    jam_mulai TIME NOT NULL,
    jam_selesai TIME NOT NULL,
    semester VARCHAR(20) NOT NULL,
    tahun_ajaran YEAR NOT NULL,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_guru) REFERENCES guru(id_guru) ON DELETE CASCADE
);

-- =====================================================
-- 12. USER_SESSIONS TABLE (for custom authentication)
-- =====================================================
CREATE TABLE user_sessions (
    id VARCHAR(255) PRIMARY KEY,
    user_id BIGINT UNSIGNED NULL,
    ip_address VARCHAR(45) NULL,
    user_agent TEXT NULL,
    payload LONGTEXT NOT NULL,
    last_activity INT NOT NULL
);

-- =====================================================
-- INDEXES FOR PERFORMANCE
-- =====================================================

-- Users table indexes
CREATE INDEX idx_users_email ON users(email);
CREATE INDEX idx_users_role ON users(role);

-- Siswa table indexes
CREATE INDEX idx_siswa_nis ON siswa(nis);
CREATE INDEX idx_siswa_kelas ON siswa(kelas);
CREATE INDEX idx_siswa_nama ON siswa(nama);

-- Guru table indexes
CREATE INDEX idx_guru_nip ON guru(nip);
CREATE INDEX idx_guru_nama ON guru(nama);
CREATE INDEX idx_guru_jabatan ON guru(jabatan);

-- Pelanggaran table indexes
CREATE INDEX idx_pelanggaran_siswa ON pelanggaran(id_siswa);
CREATE INDEX idx_pelanggaran_guru ON pelanggaran(id_guru);
CREATE INDEX idx_pelanggaran_tanggal ON pelanggaran(tanggal);
CREATE INDEX idx_pelanggaran_jenis ON pelanggaran(jenis_pelanggaran);

-- Izin Keluar table indexes
CREATE INDEX idx_izin_siswa ON izin_keluar(id_siswa);
CREATE INDEX idx_izin_guru ON izin_keluar(id_guru);
CREATE INDEX idx_izin_status ON izin_keluar(status);
CREATE INDEX idx_izin_tanggal ON izin_keluar(waktu_keluar);

-- Keterlambatan table indexes
CREATE INDEX idx_telat_siswa ON keterlambatan(id_siswa);
CREATE INDEX idx_telat_guru ON keterlambatan(id_guru);
CREATE INDEX idx_telat_waktu ON keterlambatan(waktu_datang);

-- Piket table indexes
CREATE INDEX idx_piket_guru ON piket(id_guru);
CREATE INDEX idx_piket_tanggal ON piket(tanggal);

-- Jadwal Piket table indexes
CREATE INDEX idx_jadwal_guru ON jadwal_piket(id_guru);
CREATE INDEX idx_jadwal_hari ON jadwal_piket(hari);
CREATE INDEX idx_jadwal_semester ON jadwal_piket(semester);
CREATE INDEX idx_jadwal_tahun ON jadwal_piket(tahun_ajaran);

-- =====================================================
-- SAMPLE DATA INSERTION
-- =====================================================

-- Insert sample users
INSERT INTO users (name, email, password, role) VALUES
('Administrator', 'admin@eduspace.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin'),
('Ahmad Susanto', 'guru@eduspace.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'guru'),
('Dr. Budi Santoso', 'kepsek@eduspace.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'kepsek');

-- Insert sample guru data
INSERT INTO guru (nip, nama, jabatan, jenis_kelamin, email, telepon) VALUES
('198001012001121001', 'Ahmad Susanto, S.Pd', 'Guru BK', 'Laki-laki', 'ahmad.susanto@sekolah.sch.id', '081234567890'),
('197503152000032001', 'Siti Nurhaliza, S.Pd', 'Wali Kelas X', 'Perempuan', 'siti.nurhaliza@sekolah.sch.id', '081234567891'),
('198005012005011001', 'Dr. Budi Santoso, M.Pd', 'Kepala Sekolah', 'Laki-laki', 'budi.santoso@sekolah.sch.id', '081234567892'),
('198508152010011001', 'Dewi Kartika, S.Pd', 'Wali Kelas XI', 'Perempuan', 'dewi.kartika@sekolah.sch.id', '081234567893'),
('199001012015021001', 'Rudi Hartono, S.Kom', 'Guru TIK', 'Laki-laki', 'rudi.hartono@sekolah.sch.id', '081234567894');

-- Insert sample siswa data
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

-- Insert sample jadwal piket
INSERT INTO jadwal_piket (id_guru, hari, jam_mulai, jam_selesai, semester, tahun_ajaran, is_active) VALUES
(2, 'Senin', '07:00:00', '14:00:00', 'Ganjil', 2024, TRUE),
(3, 'Selasa', '07:00:00', '14:00:00', 'Ganjil', 2024, TRUE),
(4, 'Rabu', '07:00:00', '14:00:00', 'Ganjil', 2024, TRUE),
(5, 'Kamis', '07:00:00', '14:00:00', 'Ganjil', 2024, TRUE),
(2, 'Jumat', '07:00:00', '14:00:00', 'Ganjil', 2024, TRUE);

-- Insert sample pelanggaran data
INSERT INTO pelanggaran (id_siswa, id_guru, tanggal, jenis_pelanggaran, keterangan, sanksi, poin) VALUES
(1, 2, '2024-05-01', 'Terlambat', 'Terlambat 15 menit masuk kelas', 'Membersihkan kelas', 5),
(2, 2, '2024-05-02', 'Tidak Memakai Seragam', 'Tidak menggunakan seragam lengkap', 'Surat peringatan', 10),
(3, 3, '2024-05-03', 'Menggunakan HP di Kelas', 'Main HP saat pelajaran berlangsung', 'HP disita selama seminggu', 15),
(4, 4, '2024-05-01', 'Tidak Masuk Tanpa Keterangan', 'Tidak hadir tanpa informasi', 'Panggilan orang tua', 20),
(5, 5, '2024-05-02', 'Bertengkar', 'Bertengkar dengan teman', 'Konseling BK', 10);

-- Insert sample izin keluar
INSERT INTO izin_keluar (id_siswa, id_guru, alasan, waktu_keluar, waktu_kembali, status) VALUES
(1, 2, 'Sakit', '2024-05-01 10:00:00', '2024-05-01 11:30:00', 'approved'),
(2, 3, 'Keperluan keluarga', '2024-05-02 09:30:00', NULL, 'pending'),
(3, 4, 'Sakit', '2024-05-03 08:00:00', '2024-05-03 12:00:00', 'approved');

-- Insert sample keterlambatan
INSERT INTO keterlambatan (id_siswa, id_guru, waktu_datang, keterangan) VALUES
(1, 2, '2024-05-01 07:15:00', 'Macet'),
(2, 3, '2024-05-02 07:30:00', 'Bangun kesiangan'),
(3, 4, '2024-05-03 07:10:00', 'Hujan'),
(4, 5, '2024-05-01 07:45:00', 'Sakit'),
(5, 2, '2024-05-02 07:20:00', 'Kendaraan rusak');

-- Insert sample piket
INSERT INTO piket (id_guru, tanggal, hari) VALUES
(2, '2024-05-06', 'Senin'),
(3, '2024-05-07', 'Selasa'),
(4, '2024-05-08', 'Rabu'),
(5, '2024-05-09', 'Kamis'),
(2, '2024-05-10', 'Jumat');

-- =====================================================
-- FINAL SETUP
-- =====================================================

-- Display summary
SELECT 'Database tables created successfully!' as status;
SELECT COUNT(*) as total_tables FROM information_schema.tables WHERE table_schema = DATABASE();

-- Show table counts
SELECT 'siswa' as table_name, COUNT(*) as record_count FROM siswa
UNION ALL
SELECT 'guru' as table_name, COUNT(*) as record_count FROM guru
UNION ALL
SELECT 'pelanggaran' as table_name, COUNT(*) as record_count FROM pelanggaran
UNION ALL
SELECT 'izin_keluar' as table_name, COUNT(*) as record_count FROM izin_keluar
UNION ALL
SELECT 'keterlambatan' as table_name, COUNT(*) as record_count FROM keterlambatan
UNION ALL
SELECT 'piket' as table_name, COUNT(*) as record_count FROM piket
UNION ALL
SELECT 'jadwal_piket' as table_name, COUNT(*) as record_count FROM jadwal_piket
UNION ALL
SELECT 'users' as table_name, COUNT(*) as record_count FROM users;
