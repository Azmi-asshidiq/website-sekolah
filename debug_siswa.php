<?php
/**
 * Debug Siswa Data - Cek perbedaan database vs website
 */

echo "<h2>🔍 Debug: Database vs Website</h2>";

// Cek database sekolah_db
$connections = [
    ['host' => '127.0.0.1', 'pass' => 'root', 'db' => 'sekolah_db'],
    ['host' => '127.0.0.1', 'pass' => 'root', 'db' => 'website_sekolah'],
    ['host' => '127.0.0.1', 'pass' => '', 'db' => 'sekolah_db'],
];

foreach ($connections as $conn) {
    try {
        $pdo = new PDO("mysql:host={$conn['host']};dbname={$conn['db']}", 'root', $conn['pass']);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        echo "<div style='color: green; background: #f0fff0; padding: 10px; margin: 10px 0;'>";
        echo "✅ Connected to: <strong>{$conn['db']}</strong> (password: '{$conn['pass']}')";
        
        // Cek jumlah siswa
        $count = $pdo->query("SELECT COUNT(*) FROM siswa")->fetchColumn();
        echo "<br>📊 Total siswa: <strong>$count</strong>";
        
        if ($count > 0) {
            // Tampilkan semua data
            $siswa = $pdo->query("SELECT * FROM siswa ORDER BY kelas, nama")->fetchAll(PDO::FETCH_ASSOC);
            echo "<table border='1' style='border-collapse: collapse; margin: 10px 0; width: 100%;'>";
            echo "<tr><th>No</th><th>NIS</th><th>Nama</th><th>Kelas</th><th>Jurusan</th></tr>";
            
            foreach ($siswa as $index => $s) {
                echo "<tr>";
                echo "<td>" . ($index + 1) . "</td>";
                echo "<td>{$s['nis']}</td>";
                echo "<td><strong>{$s['nama']}</strong></td>";
                echo "<td><span style='background: #e3f2fd; padding: 2px 8px; border-radius: 3px;'>{$s['kelas']}</span></td>";
                echo "<td>{$s['jurusan']}</td>";
                echo "</tr>";
            }
            echo "</table>";
        }
        
        echo "</div>";
        
    } catch(PDOException $e) {
        echo "<div style='color: orange; background: #fff3cd; padding: 10px; margin: 10px 0;'>";
        echo "❌ Gagal konek ke {$conn['db']}: " . $e->getMessage();
        echo "</div>";
    }
}

// Cek .env file Laravel
echo "<h3>🔧 Laravel .env Configuration</h3>";
echo "<div style='background: #f8f9fa; padding: 15px;'>";
echo "<p><strong>Database yang digunakan Laravel:</strong></p>";

$env_file = 'c:\laragon\www\website-sekolah\.env';
if (file_exists($env_file)) {
    $env_content = file_get_contents($env_file);
    $lines = explode("\n", $env_content);
    
    foreach ($lines as $line) {
        if (strpos($line, 'DB_DATABASE=') !== false || 
            strpos($line, 'DB_USERNAME=') !== false || 
            strpos($line, 'DB_PASSWORD=') !== false) {
            echo "<code>$line</code><br>";
        }
    }
} else {
    echo "File .env tidak ditemukan";
}
echo "</div>";

// Solusi
echo "<h3>🛠️ Solusi</h3>";
echo "<div style='background: #e8f5e8; padding: 15px; border-left: 4px solid #4caf50;'>";
echo "<h4>📋 Masalah yang Mungkin Terjadi:</h4>";
echo "<ol>";
echo "<li><strong>Database berbeda:</strong> Laravel pakai database lain, bukan sekolah_db</li>";
echo "<li><strong>Data belum di-import:</strong> SQL belum dijalankan di database yang benar</li>";
echo "<li><strong>Cache Laravel:</strong> Laravel cache data lama</li>";
echo "</ol>";

echo "<h4>🔧 Cara Fix:</h4>";
echo "<ol>";
echo "<li><strong>Cek .env:</strong> Pastikan DB_DATABASE=sekolah_db</li>";
echo "<li><strong>Import SQL:</strong> Jalankan database_sekolah_baru.sql di phpMyAdmin</li>";
echo "<li><strong>Clear cache:</strong> php artisan cache:clear</li>";
echo "<li><strong>Restart server:</strong> Stop/start Laravel server</li>";
echo "</ol>";

echo "<h4>🌐 Test Login:</h4>";
echo "<ul>";
echo "<li><a href='http://127.0.0.1:8000/login' target='_blank'>🔐 Login Admin</a> (admin@eduspace.com / password123)</li>";
echo "<li><a href='http://127.0.0.1:8000/siswa' target='_blank'>📋 Daftar Siswa</a></li>";
echo "</ul>";
echo "</div>";
?>
