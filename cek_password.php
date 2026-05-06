<?php
// Cek password root Laragon
$host = 'localhost';
$user = 'root';

// Coba tanpa password
try {
    $pdo = new PDO("mysql:host=$host", $user, '');
    echo "✅ Root tanpa password berhasil!\n";
    
    // Tampilkan database yang ada
    $dbs = $pdo->query("SHOW DATABASES")->fetchAll(PDO::FETCH_COLUMN);
    echo "Database yang ada: " . implode(", ", $dbs) . "\n";
    
} catch(PDOException $e) {
    echo "❌ Root tanpa password gagal: " . $e->getMessage() . "\n";
    
    // Coba dengan password kosong
    try {
        $pdo = new PDO("mysql:host=$host", $user, 'root');
        echo "✅ Root dengan password 'root' berhasil!\n";
    } catch(PDOException $e2) {
        echo "❌ Password 'root' juga gagal\n";
        echo "💡 Coba password: '', 'root', 'password', atau '123456'\n";
    }
}

// Coba koneksi ke database website_sekolah
try {
    $pdo = new PDO("mysql:host=$host;dbname=website_sekolah", $user, '');
    echo "✅ Database website_sekolah bisa diakses!\n";
} catch(PDOException $e) {
    echo "❌ Database website_sekolah belum ada atau tidak bisa diakses\n";
}
?>
