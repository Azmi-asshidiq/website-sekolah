<?php
/**
 * Create User Manual - Fix Login Issue
 */

echo "<h2>🔧 Create User Manual - Fix Login</h2>";

try {
    $pdo = new PDO("mysql:host=127.0.0.1;dbname=sekolah_db", 'root', 'root');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Clear existing users to avoid conflicts
    $pdo->exec("DELETE FROM users");
    echo "<div style='color: orange;'>✅ Cleared existing users</div>";
    
    // Create admin user with correct password hash
    $password = 'password123';
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
    $sql = "INSERT INTO users (name, email, password, email_verified_at, role, created_at, updated_at) VALUES 
            ('Administrator', 'admin@eduspace.com', :password, NOW(), 'admin', NOW(), NOW())";
    
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':password', $hashed_password);
    $stmt->execute();
    
    echo "<div style='color: green;'>✅ Admin user created</div>";
    
    // Create guru user
    $sql = "INSERT INTO users (name, email, password, email_verified_at, role, created_at, updated_at) VALUES 
            ('Ahmad Susanto', 'guru@eduspace.com', :password, NOW(), 'guru', NOW(), NOW())";
    
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':password', $hashed_password);
    $stmt->execute();
    
    echo "<div style='color: green;'>✅ Guru user created</div>";
    
    // Create kepsek user
    $sql = "INSERT INTO users (name, email, password, email_verified_at, role, created_at, updated_at) VALUES 
            ('Dr. Budi Santoso', 'kepsek@eduspace.com', :password, NOW(), 'kepsek', NOW(), NOW())";
    
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':password', $hashed_password);
    $stmt->execute();
    
    echo "<div style='color: green;'>✅ Kepsek user created</div>";
    
    // Verify users
    $users = $pdo->query("SELECT name, email, role FROM users")->fetchAll(PDO::FETCH_ASSOC);
    
    echo "<h3>👤 Users Created:</h3>";
    echo "<div style='background: #e8f5e8; padding: 15px;'>";
    
    foreach ($users as $user) {
        echo "<div style='margin: 10px 0; padding: 10px; background: white; border-radius: 5px;'>";
        echo "<strong>{$user['name']}</strong> ({$user['role']})<br>";
        echo "<code>Email: {$user['email']}</code><br>";
        echo "<code>Password: password123</code>";
        echo "</div>";
    }
    echo "</div>";
    
    // Test password verification
    echo "<h3>🧪 Password Test:</h3>";
    $test_user = $pdo->query("SELECT password FROM users WHERE email = 'admin@eduspace.com'")->fetchColumn();
    
    if (password_verify('password123', $test_user)) {
        echo "<div style='color: green; background: #e8f5e8; padding: 15px;'>";
        echo "✅ Password verification PASSED!";
        echo "</div>";
    } else {
        echo "<div style='color: red; background: #ffe6e6; padding: 15px;'>";
        echo "❌ Password verification FAILED!";
        echo "</div>";
    }
    
    echo "<h3>🌐 Login Now:</h3>";
    echo "<div style='background: #e3f2fd; padding: 15px;'>";
    echo "<p><strong>Go to:</strong> <a href='http://127.0.0.1:8000/login' target='_blank'>http://127.0.0.1:8000/login</a></p>";
    echo "<p><strong>Use any of these credentials:</strong></p>";
    echo "<ul>";
    echo "<li>admin@eduspace.com / password123</li>";
    echo "<li>guru@eduspace.com / password123</li>";
    echo "<li>kepsek@eduspace.com / password123</li>";
    echo "</ul>";
    echo "</div>";
    
} catch(PDOException $e) {
    echo "<div style='color: red; background: #ffe6e6; padding: 15px;'>";
    echo "❌ Error: " . $e->getMessage();
    echo "</div>";
}
?>
