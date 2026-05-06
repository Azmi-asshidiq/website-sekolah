<?php
/**
 * Verify Login Credentials
 */

echo "<h2>🔐 Verify Login Credentials</h2>";

try {
    $pdo = new PDO("mysql:host=127.0.0.1;dbname=sekolah_db", 'root', 'root');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Check users after seeding
    $users = $pdo->query("SELECT id, name, email, role, email_verified_at FROM users ORDER BY role")->fetchAll(PDO::FETCH_ASSOC);
    
    echo "<h3>👤 Users in Database:</h3>";
    echo "<table border='1' style='border-collapse: collapse; margin: 10px 0; width: 100%;'>";
    echo "<tr><th>ID</th><th>Name</th><th>Email</th><th>Role</th><th>Email Verified</th></tr>";
    
    foreach ($users as $user) {
        echo "<tr>";
        echo "<td>{$user['id']}</td>";
        echo "<td>{$user['name']}</td>";
        echo "<td><strong>{$user['email']}</strong></td>";
        echo "<td><span style='background: #e3f2fd; padding: 2px 8px; border-radius: 3px;'>{$user['role']}</span></td>";
        echo "<td>" . ($user['email_verified_at'] ? '✅ Yes' : '❌ No') . "</td>";
        echo "</tr>";
    }
    echo "</table>";
    
    // Test password hash
    echo "<h3>🧪 Password Verification Test:</h3>";
    
    $test_password = 'password123';
    foreach ($users as $user) {
        $stored_hash = $pdo->query("SELECT password FROM users WHERE email = '{$user['email']}'")->fetchColumn();
        
        if (password_verify($test_password, $stored_hash)) {
            echo "<div style='color: green; background: #e8f5e8; padding: 10px; margin: 5px 0;'>";
            echo "✅ {$user['email']} - Password OK";
            echo "</div>";
        } else {
            echo "<div style='color: red; background: #ffe6e6; padding: 10px; margin: 5px 0;'>";
            echo "❌ {$user['email']} - Password Mismatch";
            echo "</div>";
        }
    }
    
    echo "<h3>🎯 Login Instructions:</h3>";
    echo "<div style='background: #fff3cd; padding: 15px; border-left: 4px solid #ffc107;'>";
    echo "<h4>Use these credentials to login:</h4>";
    foreach ($users as $user) {
        echo "<div style='margin: 10px 0; padding: 10px; background: white; border-radius: 5px;'>";
        echo "<strong>{$user['name']} ({$user['role']})</strong><br>";
        echo "<code>Email: {$user['email']}</code><br>";
        echo "<code>Password: password123</code><br>";
        echo "<a href='http://127.0.0.1:8000/login' target='_blank' style='color: #007bff;'>🔐 Login Now</a>";
        echo "</div>";
    }
    echo "</div>";
    
    // Check if email verification is required
    echo "<h3>📧 Email Verification Status:</h3>";
    $unverified = $pdo->query("SELECT COUNT(*) FROM users WHERE email_verified_at IS NULL")->fetchColumn();
    
    if ($unverified > 0) {
        echo "<div style='color: orange; background: #fff3cd; padding: 15px;'>";
        echo "⚠️ $unverified users have unverified email. This might cause login issues.";
        echo "<br>Fixing this now...";
        
        // Update all users to have verified email
        $pdo->exec("UPDATE users SET email_verified_at = NOW() WHERE email_verified_at IS NULL");
        echo "<br>✅ All emails marked as verified!";
        echo "</div>";
    } else {
        echo "<div style='color: green; background: #e8f5e8; padding: 15px;'>";
        echo "✅ All users have verified emails!";
        echo "</div>";
    }
    
    echo "<h3>🌐 Next Steps:</h3>";
    echo "<ol>";
    echo "<li><strong>Clear browser cache:</strong> Ctrl+F5</li>";
    echo "<li><strong>Go to login:</strong> <a href='http://127.0.0.1:8000/login' target='_blank'>http://127.0.0.1:8000/login</a></li>";
    echo "<li><strong>Use any credentials above</strong></li>";
    echo "<li><strong>Password:</strong> password123 (for all users)</li>";
    echo "</ol>";
    
} catch(PDOException $e) {
    echo "<div style='color: red; background: #ffe6e6; padding: 15px;'>";
    echo "❌ Error: " . $e->getMessage();
    echo "</div>";
}
?>
