<?php
/**
 * Create user_sessions table directly
 */

echo "<h2>🔧 Create User Sessions Table</h2>";

try {
    $pdo = new PDO("mysql:host=127.0.0.1;dbname=sekolah_db", 'root', 'root');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
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
    echo "<div style='color: green; background: #e8f5e8; padding: 15px;'>";
    echo "✅ User sessions table created successfully!";
    echo "</div>";
    
    // Also create cache table if not exists
    $sql = "CREATE TABLE IF NOT EXISTS cache (
        key VARCHAR(255) PRIMARY KEY,
        value LONGTEXT NOT NULL,
        expiration INT NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
    
    $pdo->exec($sql);
    echo "<div style='color: green;'>✅ Cache table created/verified</div>";
    
    // Test session table
    $count = $pdo->query("SELECT COUNT(*) FROM user_sessions")->fetchColumn();
    echo "<div style='background: #f0f0f0; padding: 15px; margin: 10px 0;'>";
    echo "📊 Current sessions: $count";
    echo "</div>";
    
    echo "<h3>🎉 Setup Complete!</h3>";
    
    echo "<div style='background: #e3f2fd; padding: 15px; border-left: 4px solid #2196f3;'>";
    echo "<h4>🌐 Next Steps:</h4>";
    echo "<ol>";
    echo "<li><strong>Restart Laravel server:</strong> Stop current server and start again</li>";
    echo "<li><strong>Clear browser cache:</strong> Ctrl+F5</li>";
    echo "<li><strong>Open website:</strong> <a href='http://127.0.0.1:8000' target='_blank'>http://127.0.0.1:8000</a></li>";
    echo "<li><strong>Login:</strong> admin@eduspace.com / password123</li>";
    echo "<li><strong>Go to Siswa menu</strong> to see all 10 students</li>";
    echo "</ol>";
    echo "</div>";
    
    // Quick test database connection
    $siswa_count = $pdo->query("SELECT COUNT(*) FROM siswa")->fetchColumn();
    echo "<div style='background: #fff3cd; padding: 15px;'>";
    echo "<h4>📊 Database Status:</h4>";
    echo "<p><strong>Total Siswa:</strong> $siswa_count</p>";
    echo "<p><strong>Database:</strong> sekolah_db (MySQL)</p>";
    echo "<p><strong>Connection:</strong> ✅ Working</p>";
    echo "</div>";
    
} catch(PDOException $e) {
    echo "<div style='color: red; background: #ffe6e6; padding: 15px;'>";
    echo "❌ Error: " . $e->getMessage();
    echo "</div>";
    
    echo "<h3>🔧 Troubleshooting:</h3>";
    echo "<ul>";
    echo "<li>Check if MySQL is running in Laragon</li>";
    echo "<li>Verify database name: sekolah_db</li>";
    echo "<li>Check MySQL credentials: root/root</li>";
    echo "</ul>";
}
?>
