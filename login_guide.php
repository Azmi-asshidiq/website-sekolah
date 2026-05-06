<?php
/**
 * Panduan Login phpMyAdmin dengan Password Root
 */

echo "<h2>🔑 Cara Login phpMyAdmin dengan Password Root</h2>";

echo "<h3>❌ Yang TIDAK BOLEH Dilakukan:</h3>";
echo "<ul>";
echo "<li>Klik phpMyAdmin langsung dari Laragon (akan error 'Access denied')</li>";
echo "<li>Menggunakan script PHP yang konek tanpa password</li>";
echo "</ul>";

echo "<h3>✅ Cara yang BENAR:</h3>";
echo "<ol>";
echo "<li><strong>Buka browser manual:</strong> http://localhost/phpmyadmin</li>";
echo "<li><strong>Login dengan:</strong><br>";
echo "   - Username: root<br>";
echo "   - Password: root</li>";
echo "<li><strong>Setelah login berhasil:</strong><br>";
echo "   - Buat database: website_sekolah<br>";
echo "   - Copy kode dari database_no_error.sql<br>";
echo "   - Paste di tab SQL → Go</li>";
echo "</ol>";

echo "<h3>🔧 Alternative: Reset Password ke Kosong</h3>";
echo "<p>Jika ingin password kosong (lebih mudah):</p>";
echo "<ol>";
echo "<li>Buka Laragon Menu → MySQL → Root Password → Set Password</li>";
echo "<li>Masukkan password: <strong>laragon</strong></li>";
echo "<li>Restart MySQL</li>";
echo "<li>Login phpMyAdmin dengan: root / laragon</li>";
echo "</ol>";

echo "<h3>📱 Langkah-langkah Detail:</h3>";
echo "<div style='background: #f0f0f0; padding: 10px; margin: 10px 0;'>";
echo "1. Buka browser Chrome/Firefox<br>";
echo "2. Ketik: <strong>http://localhost/phpmyadmin</strong><br>";
echo "3. Akan muncul halaman login phpMyAdmin<br>";
echo "4. Masukkan:<br>";
echo "   &nbsp;&nbsp;&nbsp;Username: <strong>root</strong><br>";
echo "   &nbsp;&nbsp;&nbsp;Password: <strong>root</strong><br>";
echo "5. Klik 'Go' atau 'Execute'<br>";
echo "6. Setelah masuk, buat database 'website_sekolah'<br>";
echo "7. Copy-paste SQL code dari database_no_error.sql";
echo "</div>";

echo "<h3>🚨 Jika Masih Error:</h3>";
echo "<p>Coba password lain yang umum di Laragon:</p>";
echo "<ul>";
echo "<li>Password: <strong>laragon</strong></li>";
echo "<li>Password: <strong>password</strong></li>";
echo "<li>Password: <strong>123456</strong></li>";
echo "<li>Password: <strong>(kosong)</strong></li>";
echo "</ul>";

echo "<p><strong>Saran:</strong> Gunakan cara manual di browser, jangan klik langsung dari Laragon menu.</p>";
?>
