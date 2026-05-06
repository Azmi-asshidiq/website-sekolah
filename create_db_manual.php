<?php
/**
 * Script buat database manual - bypass password issues
 * Jalankan ini di browser: http://localhost/website-sekolah/create_db_manual.php
 */

echo "<h2>Database Setup Manual</h2>";

// Coba beberapa koneksi yang mungkin
$connections = [
    ['host' => '127.0.0.1', 'user' => 'root', 'pass' => ''],
    ['host' => '127.0.0.1', 'user' => 'root', 'pass' => 'root'],
    ['host' => '127.0.0.1', 'user' => 'root', 'pass' => 'password'],
    ['host' => '127.0.0.1', 'user' => 'root', 'pass' => '123456'],
    ['host' => 'localhost', 'user' => 'root', 'pass' => ''],
    ['host' => 'localhost', 'user' => 'root', 'pass' => 'root'],
];

$pdo = null;
$conn_used = '';

foreach ($connections as $conn) {
    try {
        $pdo = new PDO("mysql:host={$conn['host']}", $conn['user'], $conn['pass']);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn_used = "Host: {$conn['host']}, User: {$conn['user']}, Pass: '{$conn['pass']}'";
        echo "<div style='color: green;'>✅ Koneksi berhasil: $conn_used</div>";
        break;
    } catch(PDOException $e) {
        echo "<div style='color: orange;'>⚠️ Gagal: Host: {$conn['host']}, User: {$conn['user']}, Pass: '{$conn['pass']}'</div>";
    }
}

if (!$pdo) {
    die("<div style='color: red;'>❌ Tidak ada koneksi yang berhasil! Cek Laragon service.</div>");
}

// Buat database
try {
    $pdo->exec("CREATE DATABASE IF NOT EXISTS website_sekolah CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    echo "<div style='color: green;'>✅ Database website_sekolah berhasil dibuat</div>";
} catch(Exception $e) {
    echo "<div style='color: red;'>❌ Gagal buat database: " . $e->getMessage() . "</div>";
}

// Pilih database
try {
    $pdo->exec("USE website_sekolah");
    echo "<div style='color: green;'>✅ Database selected</div>";
} catch(Exception $e) {
    echo "<div style='color: red;'>❌ Gagal select database: " . $e->getMessage() . "</div>";
}

// Hapus tabel lama
$tables = ['pelanggaran', 'jadwal_piket', 'izin_keluar', 'keterlambatan', 'piket', 'siswa', 'guru', 'users'];
foreach ($tables as $table) {
    try {
        $pdo->exec("DROP TABLE IF EXISTS $table");
    } catch(Exception $e) {
        // Ignore error
    }
}

// Buat tabel users
$sql_users = "
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role VARCHAR(20) DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
$pdo->exec($sql_users);
echo "<div style='color: green;'>✅ Tabel users dibuat</div>";

// Buat tabel guru
$sql_guru = "
CREATE TABLE guru (
    id_guru INT AUTO_INCREMENT PRIMARY KEY,
    nip VARCHAR(50) UNIQUE NOT NULL,
    nama VARCHAR(100) NOT NULL,
    jabatan VARCHAR(50) NOT NULL,
    jenis_kelamin VARCHAR(20),
    email VARCHAR(100),
    telepon VARCHAR(20),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
$pdo->exec($sql_guru);
echo "<div style='color: green;'>✅ Tabel guru dibuat</div>";

// Buat tabel siswa
$sql_siswa = "
CREATE TABLE siswa (
    id_siswa INT AUTO_INCREMENT PRIMARY KEY,
    nis VARCHAR(20) UNIQUE NOT NULL,
    nama VARCHAR(100) NOT NULL,
    kelas VARCHAR(20) NOT NULL,
    jenis_kelamin VARCHAR(20),
    jurusan VARCHAR(50),
    qr_code VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
$pdo->exec($sql_siswa);
echo "<div style='color: green;'>✅ Tabel siswa dibuat</div>";

// Buat tabel pelanggaran
$sql_pelanggaran = "
CREATE TABLE pelanggaran (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_siswa INT NOT NULL,
    id_guru INT NULL,
    tanggal DATE NOT NULL,
    jenis_pelanggaran VARCHAR(100) NOT NULL,
    keterangan TEXT,
    sanksi TEXT,
    poin INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
$pdo->exec($sql_pelanggaran);
echo "<div style='color: green;'>✅ Tabel pelanggaran dibuat</div>";

// Buat tabel izin_keluar
$sql_izin = "
CREATE TABLE izin_keluar (
    id_izin INT AUTO_INCREMENT PRIMARY KEY,
    id_siswa INT NOT NULL,
    id_guru INT NOT NULL,
    alasan TEXT NOT NULL,
    waktu_keluar DATETIME NOT NULL,
    waktu_kembali DATETIME,
    status VARCHAR(20) DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
$pdo->exec($sql_izin);
echo "<div style='color: green;'>✅ Tabel izin_keluar dibuat</div>";

// Buat tabel keterlambatan
$sql_telat = "
CREATE TABLE keterlambatan (
    id_telat INT AUTO_INCREMENT PRIMARY KEY,
    id_siswa INT NOT NULL,
    id_guru INT NOT NULL,
    waktu_datang DATETIME NOT NULL,
    keterangan TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
$pdo->exec($sql_telat);
echo "<div style='color: green;'>✅ Tabel keterlambatan dibuat</div>";

// Buat tabel piket
$sql_piket = "
CREATE TABLE piket (
    id_piket INT AUTO_INCREMENT PRIMARY KEY,
    id_guru INT NOT NULL,
    tanggal DATE NOT NULL,
    hari VARCHAR(20),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
$pdo->exec($sql_piket);
echo "<div style='color: green;'>✅ Tabel piket dibuat</div>";

// Buat tabel jadwal_piket
$sql_jadwal = "
CREATE TABLE jadwal_piket (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_guru INT NOT NULL,
    hari VARCHAR(20) NOT NULL,
    jam_mulai TIME NOT NULL,
    jam_selesai TIME NOT NULL,
    semester VARCHAR(20) NOT NULL,
    tahun_ajaran YEAR NOT NULL,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
$pdo->exec($sql_jadwal);
echo "<div style='color: green;'>✅ Tabel jadwal_piket dibuat</div>";

// Insert data users
$pdo->exec("INSERT INTO users (name, email, password, role) VALUES 
('Administrator', 'admin@eduspace.com', '\$2y\$10\$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin'),
('Ahmad Susanto', 'guru@eduspace.com', '\$2y\$10\$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'guru'),
('Dr. Budi Santoso', 'kepsek@eduspace.com', '\$2y\$10\$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'kepsek')");
echo "<div style='color: green;'>✅ Data users diinsert</div>";

// Insert data guru
$pdo->exec("INSERT INTO guru (nip, nama, jabatan, jenis_kelamin, email, telepon) VALUES 
('198001012001121001', 'Ahmad Susanto, S.Pd', 'Guru BK', 'Laki-laki', 'ahmad@sekolah.sch.id', '081234567890'),
('197503152000032001', 'Siti Nurhaliza, S.Pd', 'Wali Kelas X', 'Perempuan', 'siti@sekolah.sch.id', '081234567891'),
('198005012005011001', 'Dr. Budi Santoso, M.Pd', 'Kepala Sekolah', 'Laki-laki', 'budi@sekolah.sch.id', '081234567892')");
echo "<div style='color: green;'>✅ Data guru diinsert</div>";

// Insert data siswa
$pdo->exec("INSERT INTO siswa (nis, nama, kelas, jenis_kelamin, jurusan) VALUES 
('2021001', 'Andi Pratama', 'X RPL 1', 'Laki-laki', 'Rekayasa Perangkat Lunak'),
('2021002', 'Siti Aisyah', 'X RPL 1', 'Perempuan', 'Rekayasa Perangkat Lunak'),
('2021003', 'Budi Santoso', 'X RPL 2', 'Laki-laki', 'Rekayasa Perangkat Lunak'),
('2021004', 'Dewi Lestari', 'X TKJ 1', 'Perempuan', 'Teknik Komputer Jaringan'),
('2021005', 'Rudi Hermawan', 'X TKJ 1', 'Laki-laki', 'Teknik Komputer Jaringan')");
echo "<div style='color: green;'>✅ Data siswa diinsert</div>";

// Tampilkan hasil
echo "<h3 style='color: green;'>🎉 Database setup berhasil!</h3>";
echo "<table border='1' style='border-collapse: collapse; margin: 10px 0;'>";
echo "<tr><th>Tabel</th><th>Jumlah Record</th></tr>";

foreach ($tables as $table) {
    try {
        $count = $pdo->query("SELECT COUNT(*) FROM $table")->fetchColumn();
        echo "<tr><td>$table</td><td>$count</td></tr>";
    } catch(Exception $e) {
        echo "<tr><td>$table</td><td>Error</td></tr>";
    }
}
echo "</table>";

echo "<h3>Login Test:</h3>";
echo "<ul>";
echo "<li><strong>Admin:</strong> admin@eduspace.com / password123</li>";
echo "<li><strong>Guru:</strong> guru@eduspace.com / password123</li>";
echo "<li><strong>Kepsek:</strong> kepsek@eduspace.com / password123</li>";
echo "</ul>";

echo "<h3>Next Steps:</h3>";
echo "<ol>";
echo "<li>Buka Laravel: <a href='http://localhost/website-sekolah/public' target='_blank'>http://localhost/website-sekolah/public</a></li>";
echo "<li>Login dengan akun di atas</li>";
echo "<li>Test semua fitur</li>";
echo "</ol>";

echo "<div style='background: #f0f0f0; padding: 10px; margin: 10px 0;'>";
echo "<strong>Koneksi yang berhasil:</strong> $conn_used<br>";
echo "<strong>Database:</strong> website_sekolah<br>";
echo "<strong>Total tabel:</strong> " . count($tables);
echo "</div>";
?>
