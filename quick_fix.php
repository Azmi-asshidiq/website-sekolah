<?php
/**
 * Quick Fix for All Issues
 */

echo "<h2>🚀 Quick Fix All Issues</h2>";

// Step 1: Check Laragon services
echo "<h3>🔍 Checking Services...</h3>";

// Check if MySQL is running
$mysql_running = false;
try {
    $pdo = new PDO("mysql:host=127.0.0.1", 'root', 'root');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $mysql_running = true;
    echo "<div style='color: green;'>✅ MySQL is running</div>";
} catch(PDOException $e) {
    echo "<div style='color: red;'>❌ MySQL not running: " . $e->getMessage() . "</div>";
}

// Check if database exists
if ($mysql_running) {
    try {
        $pdo = new PDO("mysql:host=127.0.0.1;dbname=sekolah_db", 'root', 'root');
        echo "<div style='color: green;'>✅ Database sekolah_db exists</div>";
        
        // Check tables
        $tables = $pdo->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
        echo "<div style='color: green;'>✅ Tables found: " . implode(", ", $tables) . "</div>";
        
    } catch(PDOException $e) {
        echo "<div style='color: orange;'>⚠️ Database issue: " . $e->getMessage() . "</div>";
    }
}

// Step 2: Fix Laravel .env
echo "<h3>🔧 Fixing Laravel Configuration...</h3>";

$env_file = '.env';
if (file_exists($env_file)) {
    $env_content = file_get_contents($env_file);
    
    // Fix database connection
    $env_content = preg_replace('/DB_CONNECTION=.*/', 'DB_CONNECTION=mysql', $env_content);
    $env_content = preg_replace('/DB_DATABASE=.*/', 'DB_DATABASE=sekolah_db', $env_content);
    $env_content = preg_replace('/DB_USERNAME=.*/', 'DB_USERNAME=root', $env_content);
    $env_content = preg_replace('/DB_PASSWORD=.*/', 'DB_PASSWORD=root', $env_content);
    
    // Fix session and cache
    $env_content = preg_replace('/SESSION_DRIVER=.*/', 'SESSION_DRIVER=file', $env_content);
    $env_content = preg_replace('/CACHE_DRIVER=.*/', 'CACHE_DRIVER=file', $env_content);
    
    file_put_contents($env_file, $env_content);
    echo "<div style='color: green;'>✅ .env file fixed</div>";
} else {
    echo "<div style='color: red;'>❌ .env file not found</div>";
}

// Step 3: Clear caches
echo "<h3>🧹 Clearing Caches...</h3>";

$caches = [
    'storage/framework/cache/*',
    'storage/framework/views/*',
    'bootstrap/cache/*'
];

foreach ($caches as $cache) {
    if (file_exists($cache)) {
        $files = glob($cache);
        foreach ($files as $file) {
            if (is_file($file)) {
                unlink($file);
            }
        }
        echo "<div style='color: green;'>✅ Cleared: $cache</div>";
    }
}

// Step 4: Create missing tables if needed
if ($mysql_running) {
    echo "<h3>🏗️ Creating Missing Tables...</h3>";
    
    try {
        $pdo = new PDO("mysql:host=127.0.0.1;dbname=sekolah_db", 'root', 'root');
        
        // Create cache table
        $pdo->exec("CREATE TABLE IF NOT EXISTS cache (
            key VARCHAR(255) PRIMARY KEY,
            value LONGTEXT NOT NULL,
            expiration INT NOT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
        
        echo "<div style='color: green;'>✅ Cache table ready</div>";
        
    } catch(PDOException $e) {
        echo "<div style='color: orange;'>⚠️ Table creation issue: " . $e->getMessage() . "</div>";
    }
}

// Step 5: Final instructions
echo "<h3>🎯 Final Instructions:</h3>";
echo "<div style='background: #e8f5e8; padding: 15px; border-left: 4px solid #4caf50;'>";
echo "<h4>🔧 Manual Steps Required:</h4>";
echo "<ol>";
echo "<li><strong>Restart Laragon:</strong><br>";
echo "   - Open Laragon<br>";
echo "   - Click 'Stop All'<br>";
echo "   - Wait 10 seconds<br>";
echo "   - Click 'Start All'<br>";
echo "   - Wait for all services to turn GREEN</li>";
echo "<li><strong>Test Connection:</strong><br>";
echo "   - Open: <a href='show_db_simple.php' target='_blank'>show_db_simple.php</a><br>";
echo "   - Should show database info</li>";
echo "<li><strong>Test Laravel:</strong><br>";
echo "   - Open: <a href='http://127.0.0.1:8000' target='_blank'>http://127.0.0.1:8000</a><br>";
echo "   - Login: admin@eduspace.com / password123</li>";
echo "</ol>";

echo "<h4>⚠️ If Still Error:</h4>";
echo "<ul>";
echo "<li>Check Laragon - MySQL must be GREEN</li>";
echo "<li>Try different MySQL port (3306 vs 3307)</li>";
echo "<li>Check Windows firewall blocking port 3306</li>";
echo "<li>Restart computer if needed</li>";
echo "</ul>";
echo "</div>";

// Status summary
echo "<h3>📊 Status Summary:</h3>";
echo "<div style='background: #f8f9fa; padding: 15px;'>";
echo "<p><strong>MySQL:</strong> " . ($mysql_running ? "✅ Running" : "❌ Stopped") . "</p>";
echo "<p><strong>Database:</strong> sekolah_db</p>";
echo "<p><strong>Session:</strong> file driver</p>";
echo "<p><strong>Cache:</strong> file driver</p>";
echo "<p><strong>Next Step:</strong> Restart Laragon</p>";
echo "</div>";
?>
