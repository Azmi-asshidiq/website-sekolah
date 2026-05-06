<?php
/**
 * Fix .env file untuk MySQL connection
 */

echo "<h2>🔧 Fix Laravel .env Configuration</h2>";

$env_file = 'c:\laragon\www\website-sekolah\.env';
$backup_file = 'c:\laragon\www\website-sekolah\.env.backup';

// Backup dulu
if (file_exists($env_file)) {
    copy($env_file, $backup_file);
    echo "<div style='color: green;'>✅ Backup .env created</div>";
}

// Baca file .env
$env_content = file_get_contents($env_file);

// Replace DB_CONNECTION dari sqlite ke mysql
$env_content = preg_replace('/DB_CONNECTION=sqlite/', 'DB_CONNECTION=mysql', $env_content);

// Simpan kembali
file_put_contents($env_file, $env_content);

echo "<div style='color: green; background: #f0fff0; padding: 15px; margin: 10px 0;'>";
echo "✅ DB_CONNECTION changed from sqlite to mysql";
echo "</div>";

// Tampilkan konfigurasi baru
echo "<h3>📋 New Database Configuration:</h3>";
echo "<div style='background: #f8f9fa; padding: 15px;'>";
$lines = explode("\n", $env_content);
foreach ($lines as $line) {
    if (strpos($line, 'DB_') === 0) {
        echo "<code style='color: #007bff;'>$line</code><br>";
    }
}
echo "</div>";

// Clear Laravel cache
echo "<h3>🔄 Clear Laravel Cache:</h3>";
echo "<div style='background: #fff3cd; padding: 15px;'>";
echo "<p>Run these commands in terminal:</p>";
echo "<code>php artisan config:clear</code><br>";
echo "<code>php artisan cache:clear</code><br>";
echo "<code>php artisan session:clear</code>";
echo "</div>";

// Test connection
echo "<h3>🔍 Test Database Connection:</h3>";
try {
    $pdo = new PDO("mysql:host=127.0.0.1;dbname=sekolah_db", 'root', 'root');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $count = $pdo->query("SELECT COUNT(*) FROM siswa")->fetchColumn();
    echo "<div style='color: green; background: #e8f5e8; padding: 15px;'>";
    echo "✅ Database connection successful!<br>";
    echo "📊 Total siswa in database: $count";
    echo "</div>";
    
} catch(PDOException $e) {
    echo "<div style='color: red; background: #ffe6e6; padding: 15px;'>";
    echo "❌ Database connection failed: " . $e->getMessage();
    echo "</div>";
}

echo "<h3>🌐 Next Steps:</h3>";
echo "<ol>";
echo "<li>Restart Laravel server (stop/start)</li>";
echo "<li>Open: <a href='http://127.0.0.1:8000' target='_blank'>http://127.0.0.1:8000</a></li>";
echo "<li>Login: admin@eduspace.com / password123</li>";
echo "<li>Go to Siswa menu to see all data</li>";
echo "</ol>";

echo "<p><small>If something goes wrong, backup is saved as .env.backup</small></p>";
?>
