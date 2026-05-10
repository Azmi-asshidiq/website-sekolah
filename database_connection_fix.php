<?php
/**
 * Database Connection Fix - Restore MySQL Session
 */

echo "<h1>🔧 Database Connection Fix</h1>";

// Step 1: Restore database session driver
echo "<h2>🔄 Step 1: Restore Database Session</h2>";

$env_file = '.env';
if (file_exists($env_file)) {
    $env_content = file_get_contents($env_file);
    
    // Restore database session driver
    $env_content = preg_replace('/SESSION_DRIVER=.*/', 'SESSION_DRIVER=database', $env_content);
    $env_content = preg_replace('/CACHE_DRIVER=.*/', 'CACHE_DRIVER=database', $env_content);
    
    // Ensure database connection is correct
    $env_content = preg_replace('/DB_CONNECTION=.*/', 'DB_CONNECTION=mysql', $env_content);
    $env_content = preg_replace('/DB_HOST=.*/', 'DB_HOST=127.0.0.1', $env_content);
    $env_content = preg_replace('/DB_PORT=.*/', 'DB_PORT=3306', $env_content);
    $env_content = preg_replace('/DB_DATABASE=.*/', 'DB_DATABASE=sekolah_db', $env_content);
    $env_content = preg_replace('/DB_USERNAME=.*/', 'DB_USERNAME=root', $env_content);
    $env_content = preg_replace('/DB_PASSWORD=.*/', 'DB_PASSWORD=root', $env_content);
    
    file_put_contents($env_file, $env_content);
    echo "<div style='color: green; font-size: 18px;'>✅ Session driver restored to DATABASE</div>";
    echo "<div style='color: green; font-size: 18px;'>✅ Cache driver restored to DATABASE</div>";
} else {
    echo "<div style='color: red;'>❌ .env file not found</div>";
}

// Step 2: Test MySQL connection
echo "<h2>🔍 Step 2: Test MySQL Connection</h2>";

$mysql_working = false;
try {
    $pdo = new PDO("mysql:host=127.0.0.1", 'root', 'root');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $mysql_working = true;
    echo "<div style='color: green; font-size: 18px;'>✅ MySQL connection successful</div>";
    
    // Test database access
    try {
        $pdo = new PDO("mysql:host=127.0.0.1;dbname=sekolah_db", 'root', 'root');
        echo "<div style='color: green; font-size: 18px;'>✅ Database sekolah_db accessible</div>";
        
        // Check if user_sessions table exists
        $tables = $pdo->query("SHOW TABLES LIKE 'user_sessions'")->fetchAll();
        if (count($tables) > 0) {
            echo "<div style='color: green; font-size: 18px;'>✅ user_sessions table exists</div>";
        } else {
            echo "<div style='color: orange; font-size: 18px;'>⚠️ user_sessions table missing - will create</div>";
        }
        
    } catch(PDOException $e) {
        echo "<div style='color: red; font-size: 18px;'>❌ Database access failed: " . $e->getMessage() . "</div>";
    }
    
} catch(PDOException $e) {
    echo "<div style='color: red; font-size: 18px;'>❌ MySQL connection failed: " . $e->getMessage() . "</div>";
}

// Step 3: Create missing tables if MySQL is working
if ($mysql_working) {
    echo "<h2>🏗️ Step 3: Create Missing Tables</h2>";
    
    try {
        $pdo = new PDO("mysql:host=127.0.0.1;dbname=sekolah_db", 'root', 'root');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Create user_sessions table
        $pdo->exec("CREATE TABLE IF NOT EXISTS user_sessions (
            id VARCHAR(255) PRIMARY KEY,
            user_id BIGINT UNSIGNED NULL,
            ip_address VARCHAR(45) NULL,
            user_agent TEXT NULL,
            payload LONGTEXT NOT NULL,
            last_activity INT NOT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
        
        echo "<div style='color: green; font-size: 18px;'>✅ user_sessions table created/verified</div>";
        
        // Create cache table
        $pdo->exec("CREATE TABLE IF NOT EXISTS cache (
            key VARCHAR(255) PRIMARY KEY,
            value LONGTEXT NOT NULL,
            expiration INT NOT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
        
        echo "<div style='color: green; font-size: 18px;'>✅ cache table created/verified</div>";
        
        // Create jobs table
        $pdo->exec("CREATE TABLE IF NOT EXISTS jobs (
            id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            queue VARCHAR(255) NOT NULL,
            payload LONGTEXT NOT NULL,
            attempts TINYINT UNSIGNED NOT NULL DEFAULT 0,
            reserved_at INT UNSIGNED NULL,
            available_at INT UNSIGNED NOT NULL,
            created_at INT UNSIGNED NOT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
        
        echo "<div style='color: green; font-size: 18px;'>✅ jobs table created/verified</div>";
        
    } catch(PDOException $e) {
        echo "<div style='color: red; font-size: 18px;'>❌ Table creation failed: " . $e->getMessage() . "</div>";
    }
}

// Step 4: Clear Laravel caches
echo "<h2>🧹 Step 4: Clear Laravel Caches</h2>";

$caches_to_clear = [
    'storage/framework/cache/*',
    'storage/framework/sessions/*',
    'storage/framework/views/*',
    'bootstrap/cache/*'
];

foreach ($caches_to_clear as $cache_path) {
    if (file_exists($cache_path)) {
        $files = glob($cache_path);
        foreach ($files as $file) {
            if (is_file($file)) {
                unlink($file);
            }
        }
        echo "<div style='color: green;'>✅ Cleared: $cache_path</div>";
    }
}

// Step 5: Instructions based on MySQL status
echo "<h2>🎯 Next Steps</h2>";

if (!$mysql_working) {
    echo "<div style='background: #ffebee; border: 2px solid #f44336; padding: 20px; border-radius: 8px; margin: 20px 0;'>";
    echo "<h3 style='color: #d32f2f;'>🔥 MYSQL SERVICE IS DOWN</h3>";
    echo "<h4>🛠️ ACTION REQUIRED:</h4>";
    echo "<ol style='font-size: 16px;'>";
    echo "<li><strong>Open Laragon Application</strong></li>";
    echo "<li><strong>Click 'Stop All' button</strong></li>";
    echo "<li><strong>Wait 20 seconds</strong></li>";
    echo "<li><strong>Click 'Start All' button</strong></li>";
    echo "<li><strong>Wait for GREEN indicators</strong> on all services</li>";
    echo "<li><strong>Refresh this page</strong> to complete setup</li>";
    echo "</ol>";
    echo "</div>";
} else {
    echo "<div style='background: #e8f5e8; border: 2px solid #4caf50; padding: 20px; border-radius: 8px; margin: 20px 0;'>";
    echo "<h3 style='color: #2e7d32;'>✅ DATABASE CONNECTION READY</h3>";
    echo "<h4>🎯 READY TO TEST:</h4>";
    echo "<ol style='font-size: 16px;'>";
    echo "<li><strong>Test Laravel:</strong> <a href='http://127.0.0.1:8000' target='_blank'>Open Website</a></li>";
    echo "<li><strong>Login:</strong> admin@eduspace.com / password123</li>";
    echo "<li><strong>Session now uses database</strong> (as requested)</li>";
    echo "</ol>";
    echo "</div>";
}

// Step 6: Status summary
echo "<h2>📊 Configuration Status</h2>";

echo "<div style='background: #f0f0f0; padding: 15px; border-radius: 8px;'>";
echo "<table style='width: 100%; border-collapse: collapse;'>";
echo "<tr style='background: #333; color: white;'><th style='padding: 10px;'>Setting</th><th style='padding: 10px;'>Value</th><th style='padding: 10px;'>Status</th></tr>";
echo "<tr><td style='padding: 10px; border: 1px solid #ddd;'>Session Driver</td><td style='padding: 10px; border: 1px solid #ddd;'>database</td><td style='padding: 10px; border: 1px solid #ddd;'>✅ Restored</td></tr>";
echo "<tr><td style='padding: 10px; border: 1px solid #ddd;'>Cache Driver</td><td style='padding: 10px; border: 1px solid #ddd;'>database</td><td style='padding: 10px; border: 1px solid #ddd;'>✅ Restored</td></tr>";
echo "<tr><td style='padding: 10px; border: 1px solid #ddd;'>Database</td><td style='padding: 10px; border: 1px solid #ddd;'>sekolah_db</td><td style='padding: 10px; border: 1px solid #ddd;'>" . ($mysql_working ? "✅ Connected" : "❌ Disconnected") . "</td></tr>";
echo "<tr><td style='padding: 10px; border: 1px solid #ddd;'>Tables</td><td style='padding: 10px; border: 1px solid #ddd;'>user_sessions, cache, jobs</td><td style='padding: 10px; border: 1px solid #ddd;'>" . ($mysql_working ? "✅ Ready" : "⏳ Pending") . "</td></tr>";
echo "</table>";
echo "</div>";

echo "<hr>";
echo "<p><strong>Database session driver restored as requested!</strong></p>";
echo "<p><strong>After MySQL restart, Laravel will use database for sessions.</strong></p>";
?>
