<?php
/**
 * Fix Memory and Performance Issues
 */

echo "<h2>🔧 Fix Memory & Performance Issues</h2>";

// Check current PHP settings
echo "<h3>📊 Current PHP Configuration:</h3>";
echo "<div style='background: #f8f9fa; padding: 15px;'>";
echo "PHP Version: " . PHP_VERSION . "<br>";
echo "Memory Limit: " . ini_get('memory_limit') . "<br>";
echo "Max Execution Time: " . ini_get('max_execution_time') . "s<br>";
echo "Post Max Size: " . ini_get('post_max_size') . "<br>";
echo "Upload Max Filesize: " . ini_get('upload_max_filesize') . "<br>";
echo "</div>";

// Recommendations
echo "<h3>⚠️ Issues Found:</h3>";
echo "<div style='background: #fff3cd; padding: 15px; border-left: 4px solid #ffc107;'>";
echo "<h4>Memory Issues:</h4>";
echo "<ul>";
echo "<li><strong>Out of memory:</strong> PHP kehabisan memory saat menjalankan Laravel</li>";
echo "<li><strong>Paging file too small:</strong> Windows virtual memory tidak cukup</li>";
echo "<li><strong>Execution timeout:</strong> Script berjalan >30 detik</li>";
echo "</ul>";

echo "<h4>🔧 Solutions:</h4>";
echo "<ol>";
echo "<li><strong>Restart Laragon:</strong> Stop All → Start All</li>";
echo "<li><strong>Clear Laravel cache:</strong><br>";
echo "<code>php artisan cache:clear</code><br>";
echo "<code>php artisan config:clear</code><br>";
echo "<code>php artisan view:clear</code></li>";
echo "<li><strong>Optimize Laravel:</strong><br>";
echo "<code>php artisan optimize:clear</code></li>";
echo "<li><strong>Check disk space:</strong> Pastikan drive C punya ruang cukup</li>";
echo "</ol>";
echo "</div>";

// Test simple database connection
echo "<h3>🔍 Quick Database Test:</h3>";
try {
    $pdo = new PDO("mysql:host=127.0.0.1;dbname=sekolah_db", 'root', 'root');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $siswa_count = $pdo->query("SELECT COUNT(*) FROM siswa")->fetchColumn();
    $user_count = $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();
    
    echo "<div style='color: green; background: #e8f5e8; padding: 15px;'>";
    echo "✅ Database connected successfully!<br>";
    echo "📊 Siswa: $siswa_count records<br>";
    echo "👤 Users: $user_count records";
    echo "</div>";
    
} catch(PDOException $e) {
    echo "<div style='color: red; background: #ffe6e6; padding: 15px;'>";
    echo "❌ Database error: " . $e->getMessage();
    echo "</div>";
}

// Laravel status check
echo "<h3>🚀 Laravel Status:</h3>";
echo "<div style='background: #e3f2fd; padding: 15px;'>";
echo "<h4>🌐 Next Steps:</h4>";
echo "<ol>";
echo "<li><strong>Restart Laragon completely:</strong><br>";
echo "   - Stop all services<br>";
echo "   - Tunggu 10 detik<br>";
echo "   - Start all services</li>";
echo "<li><strong>Clear all caches:</strong><br>";
echo "   - Delete storage/framework/cache/*<br>";
echo "   - Delete storage/framework/views/*<br>";
echo "   - Delete bootstrap/cache/*</li>";
echo "<li><strong>Test simple page:</strong><br>";
echo "   <a href='http://127.0.0.1:8000' target='_blank'>http://127.0.0.1:8000</a></li>";
echo "<li><strong>If still error:</strong><br>";
echo "   - Coba database viewer: <a href='show_db_simple.php' target='_blank'>show_db_simple.php</a></li>";
echo "</ol>";
echo "</div>";

// Memory optimization tips
echo "<h3>💡 Memory Optimization Tips:</h3>";
echo "<div style='background: #f0f0f0; padding: 15px;'>";
echo "<h4>Untuk Laragon:</h4>";
echo "<ul>";
echo "<li>Restart MySQL service</li>";
echo "<li>Restart Apache/Nginx service</li>";
echo "<li>Check available RAM di Task Manager</li>";
echo "<li>Close unnecessary applications</li>";
echo "</ul>";

echo "<h4>Untuk Windows:</h4>";
echo "<ul>";
echo "<li>Increase virtual memory (page file)</li>";
echo "<li>Clean up temp files</li>";
echo "<li>Restart computer jika perlu</li>";
echo "</ul>";
echo "</div>";

echo "<h3>🔗 Quick Links:</h3>";
echo "<ul>";
echo "<li><a href='show_db_simple.php' target='_blank'>📊 Database Viewer</a></li>";
echo "<li><a href='verify_login.php' target='_blank'>🔐 Login Verification</a></li>";
echo "<li><a href='create_user_manual.php' target='_blank'>👤 Create Users</a></li>";
echo "</ul>";
?>
