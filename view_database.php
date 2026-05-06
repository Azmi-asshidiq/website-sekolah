<?php
/**
 * View Database Content - Alternative to phpMyAdmin
 * Buka di browser: http://localhost/website-sekolah/view_database.php
 */

echo "<h2>🗄️ Database Sekolah Viewer</h2>";

// Database connection
$host = '127.0.0.1';
$user = 'root';
$pass = 'root';
$db = 'sekolah_db';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "<div style='color: green; background: #f0fff0; padding: 10px; margin: 10px 0;'>";
    echo "✅ Connected to database: <strong>$db</strong>";
    echo "</div>";
    
    // Get all tables
    $tables = $pdo->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
    
    echo "<h3>📊 Database Tables (" . count($tables) . " tables)</h3>";
    
    foreach ($tables as $table) {
        echo "<div style='margin: 20px 0; border: 1px solid #ddd; padding: 15px; border-radius: 5px;'>";
        
        // Table info
        $count = $pdo->query("SELECT COUNT(*) FROM $table")->fetchColumn();
        echo "<h4 style='color: #2c3e50; margin: 0 0 10px 0;'>📋 $table ($count records)</h4>";
        
        // Show structure
        echo "<details><summary>🔍 Table Structure</summary>";
        $columns = $pdo->query("DESCRIBE $table")->fetchAll(PDO::FETCH_ASSOC);
        echo "<table border='1' style='border-collapse: collapse; margin: 10px 0;'>";
        echo "<tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th><th>Default</th></tr>";
        foreach ($columns as $col) {
            echo "<tr>";
            echo "<td>{$col['Field']}</td>";
            echo "<td>{$col['Type']}</td>";
            echo "<td>{$col['Null']}</td>";
            echo "<td>{$col['Key']}</td>";
            echo "<td>{$col['Default']}</td>";
            echo "</tr>";
        }
        echo "</table></details>";
        
        // Show sample data (max 5 records)
        if ($count > 0) {
            echo "<details><summary>📝 Sample Data (First 5 records)</summary>";
            
            try {
                $data = $pdo->query("SELECT * FROM $table LIMIT 5")->fetchAll(PDO::FETCH_ASSOC);
                if (!empty($data)) {
                    echo "<table border='1' style='border-collapse: collapse; margin: 10px 0; font-size: 12px;'>";
                    echo "<tr>";
                    foreach (array_keys($data[0]) as $col) {
                        echo "<th>$col</th>";
                    }
                    echo "</tr>";
                    foreach ($data as $row) {
                        echo "<tr>";
                        foreach ($row as $value) {
                            echo "<td>" . htmlspecialchars(substr($value, 0, 50)) . "</td>";
                        }
                        echo "</tr>";
                    }
                    echo "</table>";
                }
            } catch(Exception $e) {
                echo "<p style='color: orange;'>Error loading data: " . $e->getMessage() . "</p>";
            }
            echo "</details>";
        }
        
        echo "</div>";
    }
    
    // Summary
    echo "<div style='background: #e8f4fd; padding: 15px; margin: 20px 0; border-radius: 5px;'>";
    echo "<h3>📈 Database Summary</h3>";
    $totalRecords = 0;
    foreach ($tables as $table) {
        $count = $pdo->query("SELECT COUNT(*) FROM $table")->fetchColumn();
        $totalRecords += $count;
    }
    echo "<p><strong>Total Tables:</strong> " . count($tables) . "</p>";
    echo "<p><strong>Total Records:</strong> $totalRecords</p>";
    echo "<p><strong>Database Name:</strong> $db</p>";
    echo "</div>";
    
    // Login info
    echo "<div style='background: #fff3cd; padding: 15px; margin: 20px 0; border-radius: 5px;'>";
    echo "<h3>🔑 Login Information for Laravel App</h3>";
    echo "<table>";
    echo "<tr><td><strong>Email:</strong></td><td>admin@eduspace.com</td></tr>";
    echo "<tr><td><strong>Password:</strong></td><td>password123</td></tr>";
    echo "<tr><td><strong>Role:</strong></td><td>Admin</td></tr>";
    echo "</table>";
    echo "</div>";
    
} catch(PDOException $e) {
    echo "<div style='color: red; background: #ffe6e6; padding: 15px; margin: 10px 0;'>";
    echo "❌ Database connection failed: " . $e->getMessage();
    echo "</div>";
    
    echo "<h3>🔧 Troubleshooting:</h3>";
    echo "<ul>";
    echo "<li>Check if MySQL is running in Laragon</li>";
    echo "<li>Verify database name: sekolah_db</li>";
    echo "<li>Check MySQL password (should be 'root')</li>";
    echo "<li>Try creating database first with SQL script</li>";
    echo "</ul>";
}

echo "<hr>";
echo "<p><small>Database Viewer for Website Sekolah</small></p>";
?>
