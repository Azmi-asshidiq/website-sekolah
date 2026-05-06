<?php
/**
 * Check and Fix Users Table
 */

echo "<h2>🔍 Check Users Database</h2>";

try {
    $pdo = new PDO("mysql:host=127.0.0.1;dbname=sekolah_db", 'root', 'root');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Check users table
    $count = $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();
    echo "<div style='color: green;'>✅ Connected to database</div>";
    echo "<div style='background: #f0f0f0; padding: 15px; margin: 10px 0;'>";
    echo "📊 Total users in database: $count";
    echo "</div>";
    
    // Show all users
    $users = $pdo->query("SELECT id, name, email, role FROM users")->fetchAll(PDO::FETCH_ASSOC);
    
    echo "<h3>👤 Current Users:</h3>";
    echo "<table border='1' style='border-collapse: collapse; margin: 10px 0;'>";
    echo "<tr><th>ID</th><th>Name</th><th>Email</th><th>Role</th></tr>";
    
    foreach ($users as $user) {
        echo "<tr>";
        echo "<td>{$user['id']}</td>";
        echo "<td>{$user['name']}</td>";
        echo "<td><strong>{$user['email']}</strong></td>";
        echo "<td>{$user['role']}</td>";
        echo "</tr>";
    }
    echo "</table>";
    
    // Check if admin user exists
    $admin_exists = $pdo->query("SELECT COUNT(*) FROM users WHERE email = 'admin@eduspace.com'")->fetchColumn();
    
    if ($admin_exists == 0) {
        echo "<h3>⚠️ Admin User Not Found - Creating...</h3>";
        
        // Insert admin user
        $sql = "INSERT INTO users (name, email, password, role) VALUES 
                ('Administrator', 'admin@eduspace.com', '\$2y\$10\$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin')";
        
        $pdo->exec($sql);
        echo "<div style='color: green; background: #e8f5e8; padding: 15px;'>";
        echo "✅ Admin user created successfully!";
        echo "</div>";
    }
    
    // Check guru user
    $guru_exists = $pdo->query("SELECT COUNT(*) FROM users WHERE email = 'guru@eduspace.com'")->fetchColumn();
    
    if ($guru_exists == 0) {
        echo "<h3>⚠️ Guru User Not Found - Creating...</h3>";
        
        $sql = "INSERT INTO users (name, email, password, role) VALUES 
                ('Ahmad Susanto', 'guru@eduspace.com', '\$2y\$10\$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'guru')";
        
        $pdo->exec($sql);
        echo "<div style='color: green; background: #e8f5e8; padding: 15px;'>";
        echo "✅ Guru user created successfully!";
        echo "</div>";
    }
    
    // Check kepsek user
    $kepsek_exists = $pdo->query("SELECT COUNT(*) FROM users WHERE email = 'kepsek@eduspace.com'")->fetchColumn();
    
    if ($kepsek_exists == 0) {
        echo "<h3>⚠️ Kepsek User Not Found - Creating...</h3>";
        
        $sql = "INSERT INTO users (name, email, password, role) VALUES 
                ('Dr. Budi Santoso', 'kepsek@eduspace.com', '\$2y\$10\$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'kepsek')";
        
        $pdo->exec($sql);
        echo "<div style='color: green; background: #e8f5e8; padding: 15px;'>";
        echo "✅ Kepsek user created successfully!";
        echo "</div>";
    }
    
    // Show final users list
    echo "<h3>🎉 Final Users List:</h3>";
    $final_users = $pdo->query("SELECT name, email, role FROM users ORDER BY role")->fetchAll(PDO::FETCH_ASSOC);
    
    echo "<div style='background: #e3f2fd; padding: 15px;'>";
    foreach ($final_users as $user) {
        echo "<div style='margin: 5px 0;'>";
        echo "<strong>{$user['name']}</strong> ({$user['role']})<br>";
        echo "<code>Email: {$user['email']}</code><br>";
        echo "<code>Password: password123</code>";
        echo "</div>";
        echo "<hr>";
    }
    echo "</div>";
    
    echo "<h3>🌐 Login Test:</h3>";
    echo "<ol>";
    echo "<li><a href='http://127.0.0.1:8000/login' target='_blank'>🔐 Go to Login Page</a></li>";
    echo "<li>Use any of the credentials above</li>";
    echo "<li>Password for all: <strong>password123</strong></li>";
    echo "</ol>";
    
} catch(PDOException $e) {
    echo "<div style='color: red; background: #ffe6e6; padding: 15px;'>";
    echo "❌ Error: " . $e->getMessage();
    echo "</div>";
}
?>
