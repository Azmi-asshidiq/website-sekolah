<?php
/**
 * Emergency Restart & Fix Script
 */

echo "<h1>🚨 EMERGENCY FIX - MySQL Connection Error</h1>";

// Check current status
echo "<h2>🔍 Current Status Check</h2>";

// Test MySQL connection
$mysql_status = "❌ OFFLINE";
try {
    $pdo = new PDO("mysql:host=127.0.0.1", 'root', 'root');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $mysql_status = "✅ ONLINE";
} catch(PDOException $e) {
    $mysql_status = "❌ OFFLINE - " . $e->getMessage();
}

echo "<div style='font-size: 18px; padding: 15px; background: #f8f9fa; margin: 10px 0;'>";
echo "<strong>MySQL Status:</strong> $mysql_status";
echo "</div>";

// Critical instructions
echo "<h2>🛠️ IMMEDIATE ACTIONS REQUIRED</h2>";

echo "<div style='background: #ffebee; border: 2px solid #f44336; padding: 20px; border-radius: 8px; margin: 20px 0;'>";
echo "<h3 style='color: #d32f2f;'>🚨 CRITICAL: MySQL Service is DOWN</h3>";
echo "<h4>🔧 STEP 1: Restart Laragon (MANDATORY)</h4>";
echo "<ol style='font-size: 16px;'>";
echo "<li><strong>Open Laragon Application</strong></li>";
echo "<li><strong>Click 'Stop All' button</strong></li>";
echo "<li><strong>Wait 15 seconds</strong> (count slowly)</li>";
echo "<li><strong>Click 'Start All' button</strong></li>";
echo "<li><strong>Wait for GREEN indicators</strong> on all services</li>";
echo "</ol>";

echo "<h4>🔍 STEP 2: Verify Services</h4>";
echo "<p style='font-size: 16px;'>In Laragon, ensure these are GREEN:</p>";
echo "<ul style='font-size: 16px;'>";
echo "<li>✅ Apache (or Nginx)</li>";
echo "<li>✅ MySQL</li>";
echo "<li>✅ Redis (if enabled)</li>";
echo "</ul>";
echo "</div>";

// Alternative solutions
echo "<h2>🔄 Alternative Solutions</h2>";

echo "<div style='background: #e3f2fd; padding: 15px; margin: 10px 0;'>";
echo "<h3>🔧 If Restart Doesn't Work:</h3>";
echo "<ol>";
echo "<li><strong>Check Task Manager:</strong><br>";
echo "   - Press Ctrl+Shift+Esc<br>";
echo "   - Look for mysqld.exe process<br>";
echo "   - If not running, MySQL is down</li>";
echo "<li><strong>Check Port Usage:</strong><br>";
echo "   - Open Command Prompt<br>";
echo "   - Run: netstat -an | findstr :3306<br>";
echo "   - Should show MySQL listening on port 3306</li>";
echo "<li><strong>Check Windows Firewall:</strong><br>";
echo "   - Windows Security → Firewall<br>";
echo "   - Allow MySQL (port 3306)</li>";
echo "<li><strong>Reinstall Laragon:</strong><br>";
echo "   - Last resort option</li>";
echo "</ol>";
echo "</div>";

// Quick test after restart
echo "<h2>🧪 Test After Restart</h2>";

echo "<div style='background: #e8f5e8; padding: 15px; margin: 10px 0;'>";
echo "<h3>📋 Follow These Steps EXACTLY:</h3>";
echo "<ol>";
echo "<li><strong>Complete Laragon restart</strong> (see above)</li>";
echo "<li><strong>Open this page again:</strong> <a href='emergency_restart.php'>emergency_restart.php</a></li>";
echo "<li><strong>Look for GREEN status:</strong> MySQL should show ✅ ONLINE</li>";
echo "<li><strong>Test database:</strong> <a href='show_db_simple.php' target='_blank'>show_db_simple.php</a></li>";
echo "<li><strong>Test Laravel:</strong> <a href='http://127.0.0.1:8000' target='_blank'>http://127.0.0.1:8000</a></li>";
echo "</ol>";
echo "</div>";

// Emergency commands
echo "<h2>🚀 Emergency Commands</h2>";

echo "<div style='background: #fff3cd; padding: 15px; margin: 10px 0;'>";
echo "<h3>💻 If you can access Command Prompt:</h3>";
echo "<code style='background: #f0f0f0; padding: 10px; display: block;'>";
echo "# Restart MySQL service<br>";
echo "net stop mysql<br>";
echo "net start mysql<br><br>";
echo "# Or restart all Laragon services<br>";
echo "# Use Laragon UI instead (recommended)";
echo "</code>";
echo "</div>";

// Status summary
echo "<h2>📊 Current Status Summary</h2>";

echo "<div style='background: #f0f0f0; padding: 15px; border-radius: 8px;'>";
echo "<table style='width: 100%; border-collapse: collapse;'>";
echo "<tr style='background: #333; color: white;'><th style='padding: 10px;'>Service</th><th style='padding: 10px;'>Status</th><th style='padding: 10px;'>Action</th></tr>";
echo "<tr><td style='padding: 10px; border: 1px solid #ddd;'>MySQL Database</td><td style='padding: 10px; border: 1px solid #ddd;'>$mysql_status</td><td style='padding: 10px; border: 1px solid #ddd;'>Restart Laragon</td></tr>";
echo "<tr><td style='padding: 10px; border: 1px solid #ddd;'>Laravel App</td><td style='padding: 10px; border: 1px solid #ddd;'>⚠️ Waiting for MySQL</td><td style='padding: 10px; border: 1px solid #ddd;'>Fix MySQL first</td></tr>";
echo "</table>";
echo "</div>";

// Final warning
echo "<div style='background: #ffeb3b; color: #333; padding: 15px; border-radius: 8px; margin: 20px 0; text-align: center;'>";
echo "<h3 style='margin: 0;'>⚠️ IMPORTANT: Laravel CANNOT work without MySQL</h3>";
echo "<p style='margin: 5px 0; font-size: 16px;'>You MUST restart Laragon before continuing!</p>";
echo "</div>";

echo "<hr>";
echo "<p><strong>Refresh this page after restarting Laragon to see updated status.</strong></p>";
?>
