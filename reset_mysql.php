<?php
/**
 * Reset Password Root MySQL Laragon
 * Jalankan ini untuk reset password root menjadi kosong
 */

echo "<h2>Reset Password MySQL Root</h2>";

// Coba koneksi dengan password yang mungkin
$passwords = ['', 'root', 'password', '123456', ''];
$host = '127.0.0.1';
$user = 'root';

foreach ($passwords as $pass) {
    try {
        $pdo = new PDO("mysql:host=$host", $user, $pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        echo "<div style='color: green;'>✅ Koneksi berhasil dengan password: '$pass'</div>";
        
        // Reset password root menjadi kosong
        try {
            $pdo->exec("ALTER USER 'root'@'localhost' IDENTIFIED BY ''");
            echo "<div style='color: green;'>✅ Password root berhasil direset menjadi kosong!</div>";
        } catch(Exception $e) {
            // Coba cara lama
            try {
                $pdo->exec("SET PASSWORD FOR 'root'@'localhost' = PASSWORD('')");
                echo "<div style='color: green;'>✅ Password root berhasil direset (cara lama)!</div>";
            } catch(Exception $e2) {
                echo "<div style='color: orange;'>⚠️ Tidak bisa reset password: " . $e2->getMessage() . "</div>";
            }
        }
        
        // Flush privileges
        $pdo->exec("FLUSH PRIVILEGES");
        echo "<div style='color: green;'>✅ Privileges di-flush</div>";
        
        break;
        
    } catch(PDOException $e) {
        echo "<div style='color: red;'>❌ Gagal dengan password '$pass': " . $e->getMessage() . "</div>";
    }
}

echo "<h3>Cara Manual Reset Password Root:</h3>";
echo "<ol>";
echo "<li>Buka Laragon</li>";
echo "<li>Klik Menu → MySQL → Root Password → (empty)</li>";
echo "<li>Restart MySQL (Stop All → Start All)</li>";
echo "</ol>";

echo "<h3>Setelah Reset:</h3>";
echo "<a href='create_db_manual.php'>Klik di sini untuk buat database otomatis</a>";

echo "<h3>Cara Manual via phpMyAdmin:</h3>";
echo "<ol>";
echo "<li>Buka Laragon → Database → phpMyAdmin</li>";
echo "<li>Buat database: website_sekolah</li>";
echo "<li>Copy kode dari database_no_error.sql</li>";
echo "<li>Paste di tab SQL → Go</li>";
echo "</ol>";
?>
