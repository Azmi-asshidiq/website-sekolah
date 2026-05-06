<?php
/**
 * Create missing cache table for Laravel
 */

echo "<h2>🔧 Create Missing Cache Table</h2>";

try {
    $pdo = new PDO("mysql:host=127.0.0.1;dbname=sekolah_db", 'root', 'root');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Create cache table
    $sql = "CREATE TABLE IF NOT EXISTS cache (
        key VARCHAR(255) PRIMARY KEY,
        value LONGTEXT NOT NULL,
        expiration INT NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
    
    $pdo->exec($sql);
    echo "<div style='color: green;'>✅ Cache table created successfully</div>";
    
    // Create jobs table
    $sql = "CREATE TABLE IF NOT EXISTS jobs (
        id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        queue VARCHAR(255) NOT NULL,
        payload LONGTEXT NOT NULL,
        attempts TINYINT UNSIGNED NOT NULL,
        reserved_at INT UNSIGNED NULL,
        available_at INT UNSIGNED NOT NULL,
        created_at INT UNSIGNED NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
    
    $pdo->exec($sql);
    echo "<div style='color: green;'>✅ Jobs table created successfully</div>";
    
    // Create failed_jobs table
    $sql = "CREATE TABLE IF NOT EXISTS failed_jobs (
        id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        uuid VARCHAR(255) UNIQUE NOT NULL,
        connection TEXT NOT NULL,
        queue TEXT NOT NULL,
        payload LONGTEXT NOT NULL,
        exception LONGTEXT NOT NULL,
        failed_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
    
    $pdo->exec($sql);
    echo "<div style='color: green;'>✅ Failed jobs table created successfully</div>";
    
    // Create user_sessions table
    $sql = "CREATE TABLE IF NOT EXISTS user_sessions (
        id VARCHAR(255) PRIMARY KEY,
        user_id BIGINT UNSIGNED NULL,
        ip_address VARCHAR(45) NULL,
        user_agent TEXT NULL,
        payload LONGTEXT NOT NULL,
        last_activity INT NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
    
    $pdo->exec($sql);
    echo "<div style='color: green;'>✅ User sessions table created successfully</div>";
    
    echo "<h3>🎉 All missing tables created!</h3>";
    
    // Test Laravel cache
    echo "<h3>🧪 Test Laravel Cache:</h3>";
    try {
        // Test cache set
        \Illuminate\Support\Facades\Cache::put('test_key', 'test_value', 60);
        $value = \Illuminate\Support\Facades\Cache::get('test_key');
        
        if ($value === 'test_value') {
            echo "<div style='color: green;'>✅ Laravel Cache working!</div>";
        } else {
            echo "<div style='color: orange;'>⚠️ Cache test failed</div>";
        }
        
        // Clean up
        \Illuminate\Support\Facades\Cache::forget('test_key');
        
    } catch(Exception $e) {
        echo "<div style='color: red;'>❌ Cache test failed: " . $e->getMessage() . "</div>";
    }
    
    echo "<h3>🌐 Next Steps:</h3>";
    echo "<ol>";
    echo "<li>Restart Laravel server (stop/start)</li>";
    echo "<li>Open: <a href='http://127.0.0.1:8000' target='_blank'>http://127.0.0.1:8000</a></li>";
    echo "<li>Login: admin@eduspace.com / password123</li>";
    echo "<li>Go to Siswa menu</li>";
    echo "</ol>";
    
} catch(PDOException $e) {
    echo "<div style='color: red;'>❌ Error: " . $e->getMessage() . "</div>";
}
?>
