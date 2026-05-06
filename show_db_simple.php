<?php
/**
 * Simple Database Viewer - No Authentication Required
 * Cara alternatif lihat database tanpa phpMyAdmin
 */

echo "<h2>🗄️ Database Sekolah - Simple Viewer</h2>";

// Coba beberapa koneksi database
$connections = [
    ['host' => '127.0.0.1', 'pass' => 'root'],
    ['host' => 'localhost', 'pass' => 'root'],
    ['host' => '127.0.0.1', 'pass' => ''],
    ['host' => 'localhost', 'pass' => ''],
];

$connected = false;
$pdo = null;

foreach ($connections as $conn) {
    try {
        $pdo = new PDO("mysql:host={$conn['host']};dbname=sekolah_db", 'root', $conn['pass']);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $connected = true;
        echo "<div style='color: green;'>✅ Connected: {$conn['host']} with password: '{$conn['pass']}'</div>";
        break;
    } catch(PDOException $e) {
        echo "<div style='color: orange;'>⚠️ Failed: {$conn['host']} with password: '{$conn['pass']}'</div>";
    }
}

if (!$connected) {
    echo "<div style='color: red; background: #ffe6e6; padding: 15px;'>";
    echo "❌ Tidak bisa konek ke database sekolah_db";
    echo "<h3>Solusi:</h3>";
    echo "<ol>";
    echo "<li>Buka phpMyAdmin: http://localhost/phpmyadmin</li>";
    echo "<li>Login root/root</li>";
    echo "<li>Buat database: sekolah_db</li>";
    echo "<li>Copy kode dari database_sekolah_baru.sql</li>";
    echo "<li>Paste di tab SQL → Go</li>";
    echo "</ol>";
    echo "</div>";
    exit;
}

// Tampilkan database info
echo "<div style='background: #e8f4fd; padding: 15px; margin: 10px 0;'>";
echo "<h3>📊 Database Information</h3>";

// List tables
$tables = $pdo->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
echo "<p><strong>Tables found:</strong> " . implode(", ", $tables) . "</p>";
echo "<p><strong>Total tables:</strong> " . count($tables) . "</p>";

// Show record counts
echo "<table border='1' style='border-collapse: collapse; margin: 10px 0;'>";
echo "<tr><th>Table</th><th>Records</th><th>Sample Data</th></tr>";

foreach ($tables as $table) {
    $count = $pdo->query("SELECT COUNT(*) FROM $table")->fetchColumn();
    echo "<tr>";
    echo "<td><strong>$table</strong></td>";
    echo "<td>$count</td>";
    
    // Show sample data
    if ($count > 0) {
        $sample = $pdo->query("SELECT * FROM $table LIMIT 1")->fetch(PDO::FETCH_ASSOC);
        $sample_str = "";
        foreach ($sample as $key => $value) {
            if (strlen($value) > 20) $value = substr($value, 0, 20) . "...";
            $sample_str .= "$key: $value<br>";
        }
        echo "<td style='font-size: 11px;'>$sample_str</td>";
    } else {
        echo "<td>No data</td>";
    }
    echo "</tr>";
}
echo "</table>";

// Show users table specifically
echo "<h3>👤 Users (Login Data)</h3>";
try {
    $users = $pdo->query("SELECT name, email, role FROM users")->fetchAll(PDO::FETCH_ASSOC);
    echo "<table border='1' style='border-collapse: collapse;'>";
    echo "<tr><th>Name</th><th>Email</th><th>Role</th></tr>";
    foreach ($users as $user) {
        echo "<tr>";
        echo "<td>{$user['name']}</td>";
        echo "<td>{$user['email']}</td>";
        echo "<td>{$user['role']}</td>";
        echo "</tr>";
    }
    echo "</table>";
    echo "<p><strong>Password untuk semua user:</strong> password123</p>";
} catch(Exception $e) {
    echo "<p style='color: red;'>Error loading users: " . $e->getMessage() . "</p>";
}

// Show guru table
echo "<h3>👨‍🏫 Data Guru</h3>";
try {
    $guru = $pdo->query("SELECT nip, nama, jabatan FROM guru LIMIT 5")->fetchAll(PDO::FETCH_ASSOC);
    echo "<table border='1' style='border-collapse: collapse;'>";
    echo "<tr><th>NIP</th><th>Nama</th><th>Jabatan</th></tr>";
    foreach ($guru as $g) {
        echo "<tr>";
        echo "<td>{$g['nip']}</td>";
        echo "<td>{$g['nama']}</td>";
        echo "<td>{$g['jabatan']}</td>";
        echo "</tr>";
    }
    echo "</table>";
} catch(Exception $e) {
    echo "<p style='color: red;'>Error loading guru: " . $e->getMessage() . "</p>";
}

// Show siswa table
echo "<h3>👨‍🎓 Data Siswa (5 pertama)</h3>";
try {
    $siswa = $pdo->query("SELECT nis, nama, kelas, jurusan FROM siswa LIMIT 5")->fetchAll(PDO::FETCH_ASSOC);
    echo "<table border='1' style='border-collapse: collapse;'>";
    echo "<tr><th>NIS</th><th>Nama</th><th>Kelas</th><th>Jurusan</th></tr>";
    foreach ($siswa as $s) {
        echo "<tr>";
        echo "<td>{$s['nis']}</td>";
        echo "<td>{$s['nama']}</td>";
        echo "<td>{$s['kelas']}</td>";
        echo "<td>{$s['jurusan']}</td>";
        echo "</tr>";
    }
    echo "</table>";
} catch(Exception $e) {
    echo "<p style='color: red;'>Error loading siswa: " . $e->getMessage() . "</p>";
}

echo "</div>";

echo "<h3>🔗 Cara Akses Database Lainnya:</h3>";
echo "<ul>";
echo "<li><strong>phpMyAdmin:</strong> http://localhost/phpmyadmin (root/root)</li>";
echo "<li><strong>Laragon Menu:</strong> Database → phpMyAdmin</li>";
echo "<li><strong>Command Line:</strong> mysql -u root -p sekolah_db</li>";
echo "</ul>";

echo "<h3>📱 Cara Jelaskan ke Pengguna:</h3>";
echo "<div style='background: #fff3cd; padding: 15px;'>";
echo "<p><strong>Untuk pengguna/ujian:</strong></p>";
echo "<ul>";
echo "<li>Sistem sudah punya 3 user: admin, guru, kepsek</li>";
echo "<li>Email: admin@eduspace.com, guru@eduspace.com, kepsek@eduspace.com</li>";
echo "<li>Password: password123 (untuk semua)</li>";
echo "<li>Data sudah ada: 5 guru, 10 siswa, sample pelanggaran, dll</li>";
echo "<li>Buka: http://127.0.0.1:8000 untuk login</li>";
echo "</ul>";
echo "</div>";
?>
