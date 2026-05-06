<?php
/**
 * Database Setup Script for Website Sekolah
 * This script helps create all necessary tables for the Laravel application
 */

// Database configuration (adjust according to your Laragon setup)
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'website_sekolah'; // Change this to your database name

try {
    // Connect to MySQL without selecting database first
    $pdo = new PDO("mysql:host=$host", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "✅ Connected to MySQL successfully!\n";
    
    // Create database if it doesn't exist
    $pdo->exec("CREATE DATABASE IF NOT EXISTS `$database` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    echo "✅ Database '$database' created or already exists!\n";
    
    // Select the database
    $pdo->exec("USE `$database`");
    echo "✅ Database selected!\n";
    
    // Read and execute the SQL script
    $sqlFile = __DIR__ . '/create_database_tables.sql';
    if (!file_exists($sqlFile)) {
        throw new Exception("SQL file not found: $sqlFile");
    }
    
    $sql = file_get_contents($sqlFile);
    
    // Split the SQL into individual statements
    $statements = array_filter(array_map('trim', explode(';', $sql)));
    
    echo "🔄 Executing SQL statements...\n";
    $executed = 0;
    $errors = 0;
    
    foreach ($statements as $statement) {
        if (empty($statement) || strpos(trim($statement), '--') === 0) {
            continue;
        }
        
        try {
            $pdo->exec($statement);
            $executed++;
            echo ".";
        } catch (PDOException $e) {
            $errors++;
            echo "\n❌ Error in statement: " . substr($statement, 0, 50) . "...\n";
            echo "   Error: " . $e->getMessage() . "\n";
        }
    }
    
    echo "\n\n✅ Setup completed!\n";
    echo "📊 Executed statements: $executed\n";
    echo "❌ Errors: $errors\n";
    
    // Display table information
    echo "\n📋 Created tables:\n";
    $tables = $pdo->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
    foreach ($tables as $table) {
        $count = $pdo->query("SELECT COUNT(*) FROM `$table`")->fetchColumn();
        echo "  - $table: $count records\n";
    }
    
    echo "\n🎉 Database setup completed successfully!\n";
    echo "🌐 You can now access your Laravel application!\n";
    
    // Test Laravel connection
    echo "\n🔍 Testing Laravel database connection...\n";
    try {
        $laravelConfig = include __DIR__ . '/config/database.php';
        echo "✅ Laravel config loaded\n";
    } catch (Exception $e) {
        echo "⚠️  Laravel config not accessible: " . $e->getMessage() . "\n";
    }
    
} catch (PDOException $e) {
    echo "❌ Database connection failed: " . $e->getMessage() . "\n";
    echo "Please check your MySQL credentials and ensure Laragon is running.\n";
} catch (Exception $e) {
    echo "❌ Setup failed: " . $e->getMessage() . "\n";
}

echo "\n" . str_repeat("=", 50) . "\n";
echo "Next steps:\n";
echo "1. Run 'php artisan migrate' to sync with Laravel migrations\n";
echo "2. Run 'php artisan serve' to start the application\n";
echo "3. Visit http://localhost:8000 in your browser\n";
echo "4. Login with: admin@eduspace.com / password123\n";
echo str_repeat("=", 50) . "\n";
?>
