<?php
/**
 * FORCE FIX - Session Driver & MySQL Connection
 */

echo "<h1>🚨 FORCE FIX - Session & MySQL Issues</h1>";

// Step 1: Force fix session driver
echo "<h2>🔧 Step 1: Force Fix Session Driver</h2>";

$env_file = '.env';
if (file_exists($env_file)) {
    $env_content = file_get_contents($env_file);
    
    // Force session to file (NOT database)
    $env_content = preg_replace('/SESSION_DRIVER=.*/', 'SESSION_DRIVER=file', $env_content);
    $env_content = preg_replace('/CACHE_DRIVER=.*/', 'CACHE_DRIVER=file', $env_content);
    
    // Force database connection settings
    $env_content = preg_replace('/DB_CONNECTION=.*/', 'DB_CONNECTION=mysql', $env_content);
    $env_content = preg_replace('/DB_HOST=.*/', 'DB_HOST=127.0.0.1', $env_content);
    $env_content = preg_replace('/DB_PORT=.*/', 'DB_PORT=3306', $env_content);
    $env_content = preg_replace('/DB_DATABASE=.*/', 'DB_DATABASE=sekolah_db', $env_content);
    $env_content = preg_replace('/DB_USERNAME=.*/', 'DB_USERNAME=root', $env_content);
    $env_content = preg_replace('/DB_PASSWORD=.*/', 'DB_PASSWORD=root', $env_content);
    
    file_put_contents($env_file, $env_content);
    echo "<div style='color: green; font-size: 18px;'>✅ Session forced to file driver</div>";
    echo "<div style='color: green; font-size: 18px;'>✅ Database connection fixed</div>";
} else {
    echo "<div style='color: red;'>❌ .env file not found</div>";
}

// Step 2: Clear all Laravel caches
echo "<h2>🧹 Step 2: Clear All Caches</h2>";

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

// Step 3: Test MySQL connection
echo "<h2>🔍 Step 3: Test MySQL Connection</h2>";

$mysql_working = false;
try {
    $pdo = new PDO("mysql:host=127.0.0.1", 'root', 'root');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $mysql_working = true;
    echo "<div style='color: green; font-size: 18px;'>✅ MySQL connection successful</div>";
    
    // Test database
    try {
        $pdo = new PDO("mysql:host=127.0.0.1;dbname=sekolah_db", 'root', 'root');
        echo "<div style='color: green; font-size: 18px;'>✅ Database sekolah_db accessible</div>";
    } catch(PDOException $e) {
        echo "<div style='color: orange; font-size: 18px;'>⚠️ Database issue: " . $e->getMessage() . "</div>";
    }
    
} catch(PDOException $e) {
    echo "<div style='color: red; font-size: 18px;'>❌ MySQL connection failed: " . $e->getMessage() . "</div>";
}

// Step 4: Critical instructions
echo "<h2>🚨 CRITICAL INSTRUCTIONS</h2>";

if (!$mysql_working) {
    echo "<div style='background: #ffebee; border: 2px solid #f44336; padding: 20px; border-radius: 8px; margin: 20px 0;'>";
    echo "<h3 style='color: #d32f2f;'>🔥 MYSQL SERVICE IS DOWN</h3>";
    echo "<h4>🛠️ IMMEDIATE ACTION REQUIRED:</h4>";
    echo "<ol style='font-size: 16px;'>";
    echo "<li><strong>Open Laragon Application</strong></li>";
    echo "<li><strong>Click 'Stop All' button</strong></li>";
    echo "<li><strong>Wait 20 seconds</strong> (count slowly: 1-20)</li>";
    echo "<li><strong>Click 'Start All' button</strong></li>";
    echo "<li><strong>Wait for GREEN indicators</strong> on all services</li>";
    echo "<li><strong>Refresh this page</strong> to verify MySQL is working</li>";
    echo "</ol>";
    echo "</div>";
} else {
    echo "<div style='background: #e8f5e8; border: 2px solid #4caf50; padding: 20px; border-radius: 8px; margin: 20px 0;'>";
    echo "<h3 style='color: #2e7d32;'>✅ MYSQL IS WORKING</h3>";
    echo "<h4>🎯 NEXT STEPS:</h4>";
    echo "<ol style='font-size: 16px;'>";
    echo "<li><strong>Test Laravel:</strong> <a href='http://127.0.0.1:8000' target='_blank'>Open Website</a></li>";
    echo "<li><strong>Should work now!</strong> (Session uses file, not database)</li>";
    echo "<li><strong>Login:</strong> admin@eduspace.com / password123</li>";
    echo "</ol>";
    echo "</div>";
}

// Step 5: Alternative solutions
echo "<h2>🔄 Alternative Solutions (If Still Broken)</h2>";

echo "<div style='background: #fff3cd; padding: 15px; margin: 10px 0;'>";
echo "<h3>🔧 Try These in Order:</h3>";
echo "<ol>";
echo "<li><strong>Restart Computer</strong> (if Laragon restart doesn't work)</li>";
echo "<li><strong>Check Task Manager:</strong> Look for mysqld.exe process</li>";
echo "<li><strong>Check Port 3306:</strong> Command Prompt → netstat -an | findstr :3306</li>";
echo "<li><strong>Reinstall Laragon:</strong> Last resort option</li>";
echo "</ol>";
echo "</div>";

// Step 6: Status summary
echo "<h2>📊 Current Status</h2>";

echo "<div style='background: #f0f0f0; padding: 15px; border-radius: 8px;'>";
echo "<table style='width: 100%; border-collapse: collapse;'>";
echo "<tr style='background: #333; color: white;'><th style='padding: 10px;'>Component</th><th style='padding: 10px;'>Status</th><th style='padding: 10px;'>Action</th></tr>";
echo "<tr><td style='padding: 10px; border: 1px solid #ddd;'>Session Driver</td><td style='padding: 10px; border: 1px solid #ddd;'>✅ File (Fixed)</td><td style='padding: 10px; border: 1px solid #ddd;'>No database needed</td></tr>";
echo "<tr><td style='padding: 10px; border: 1px solid #ddd;'>Cache Driver</td><td style='padding: 10px; border: 1px solid #ddd;'>✅ File (Fixed)</td><td style='padding: 10px; border: 1px solid #ddd;'>No database needed</td></tr>";
echo "<tr><td style='padding: 10px; border: 1px solid #ddd;'>MySQL Connection</td><td style='padding: 10px; border: 1px solid #ddd;'>" . ($mysql_working ? "✅ Working" : "❌ DOWN") . "</td><td style='padding: 10px; border: 1px solid #ddd;'>" . ($mysql_working ? "None needed" : "Restart Laragon") . "</td></tr>";
echo "</table>";
echo "</div>";

echo "<hr>";
echo "<p><strong>Refresh this page after restarting Laragon to see updated status.</strong></p>";
echo "<p><strong>After MySQL is fixed, the website should work normally!</strong></p>";
?>
