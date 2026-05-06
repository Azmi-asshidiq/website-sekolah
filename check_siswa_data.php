<?php
/**
 * Check Siswa Data - Debug untuk melihat semua data siswa
 */

echo "<h2>🔍 Debug Data Siswa</h2>";

// Database connection
$host = '127.0.0.1';
$user = 'root';
$pass = 'root';
$db = 'sekolah_db';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "<div style='color: green;'>✅ Connected to database</div>";
    
    // Query semua data siswa
    $stmt = $pdo->query("SELECT * FROM siswa ORDER BY kelas, nama");
    $siswa = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "<h3>📊 Total Data Siswa: " . count($siswa) . "</h3>";
    
    // Group by kelas
    $by_kelas = [];
    foreach ($siswa as $s) {
        $by_kelas[$s['kelas']][] = $s;
    }
    
    // Tampilkan per kelas
    foreach ($by_kelas as $kelas => $data) {
        echo "<div style='margin: 20px 0; border: 1px solid #ddd; padding: 15px; border-radius: 5px;'>";
        echo "<h4 style='color: #2c3e50;'>📚 Kelas $kelas (" . count($data) . " siswa)</h4>";
        
        echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
        echo "<tr><th>No</th><th>NIS</th><th>Nama</th><th>Jenis Kelamin</th><th>Jurusan</th></tr>";
        
        foreach ($data as $index => $s) {
            echo "<tr>";
            echo "<td>" . ($index + 1) . "</td>";
            echo "<td>{$s['nis']}</td>";
            echo "<td>{$s['nama']}</td>";
            echo "<td>{$s['jenis_kelamin']}</td>";
            echo "<td>{$s['jurusan']}</td>";
            echo "</tr>";
        }
        echo "</table>";
        echo "</div>";
    }
    
    // Cek apakah ada masalah dengan Laravel query
    echo "<h3>🔧 Laravel Debug Info</h3>";
    echo "<div style='background: #f0f0f0; padding: 15px;'>";
    echo "<p><strong>SiswaController.php:</strong> paginate(50) - seharusnya muncul semua</p>";
    echo "<p><strong>View file:</strong> siswa/index.blade.php - ada pagination links</p>";
    echo "<p><strong>Possible issues:</strong></p>";
    echo "<ul>";
    echo "<li>Filter aktif (search/kelas filter)</li>";
    echo "<li>Pagination tidak menampilkan semua halaman</li>";
    echo "<li>CSS hiding some rows</li>";
    echo "</ul>";
    echo "</div>";
    
    // Cara fix
    echo "<h3>🛠️ Cara Fix:</h3>";
    echo "<div style='background: #fff3cd; padding: 15px;'>";
    echo "<ol>";
    echo "<li><strong>Refresh website:</strong> http://127.0.0.1:8000/siswa</li>";
    echo "<li><strong>Cek pagination:</strong> Lihat apakah ada link halaman di bawah tabel</li>";
    echo "<li><strong>Reset filter:</strong> Kosongkan search dan pilih 'Semua Kelas'</li>";
    echo "<li><strong>Hard refresh:</strong> Ctrl+F5 di browser</li>";
    echo "</ol>";
    echo "</div>";
    
    // Tampilkan link langsung ke website
    echo "<h3>🌐 Akses Langsung:</h3>";
    echo "<ul>";
    echo "<li><a href='http://127.0.0.1:8000/siswa' target='_blank'>📋 Daftar Siswa</a></li>";
    echo "<li><a href='http://127.0.0.1:8000/login' target='_blank'>🔐 Login</a> (admin@eduspace.com / password123)</li>";
    echo "</ul>";
    
} catch(PDOException $e) {
    echo "<div style='color: red;'>❌ Error: " . $e->getMessage() . "</div>";
}
?>
