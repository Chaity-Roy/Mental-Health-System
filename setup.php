<?php
/**
 * Database Setup Script
 * Run this file once to create the database and tables
 */

// Database configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'mental_health_db');

try {
    // Connect to MySQL (without database)
    $pdo = new PDO("mysql:host=" . DB_HOST, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "<h2>Mental Health System - Database Setup</h2>";
    echo "<hr>";

    // Create database
    echo "<p>Creating database '" . DB_NAME . "'...</p>";
    $pdo->exec("CREATE DATABASE IF NOT EXISTS " . DB_NAME);
    echo "<p style='color: green;'>✓ Database created successfully!</p>";

    // Select the database
    $pdo->exec("USE " . DB_NAME);

    // Read and execute schema.sql
    $schemaFile = __DIR__ . '/database/schema.sql';

    if (!file_exists($schemaFile)) {
        throw new Exception("Schema file not found at: $schemaFile");
    }

    echo "<p>Reading schema file...</p>";
    $sql = file_get_contents($schemaFile);

    // Split into individual statements
    $statements = array_filter(array_map('trim', explode(';', $sql)));

    echo "<p>Executing " . count($statements) . " SQL statements...</p>";

    foreach ($statements as $statement) {
        if (!empty($statement)) {
            try {
                $pdo->exec($statement);
            } catch (PDOException $e) {
                // Ignore "table already exists" errors
                if (strpos($e->getMessage(), 'already exists') === false) {
                    throw $e;
                }
            }
        }
    }

    echo "<p style='color: green;'>✓ Database schema created successfully!</p>";

    // Verify tables
    echo "<p>Verifying tables...</p>";
    $stmt = $pdo->query("SHOW TABLES");
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);

    echo "<ul>";
    foreach ($tables as $table) {
        echo "<li style='color: green;'>✓ $table</li>";
    }
    echo "</ul>";

    echo "<hr>";
    echo "<h3 style='color: green;'>Setup Complete!</h3>";
    echo "<p><strong>Default Admin Account:</strong></p>";
    echo "<ul>";
    echo "<li>Email: admin@mentalhealth.com</li>";
    echo "<li>Password: admin123</li>";
    echo "</ul>";
    echo "<p><a href='/' style='background: linear-gradient(to right, #10b981, #059669); color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; display: inline-block;'>Go to Application →</a></p>";

    // Delete this setup file for security
    echo "<p style='color: #f59e0b; background: #fef3c7; padding: 10px; border-radius: 5px;'><strong>Security Note:</strong> For security, you should delete this setup.php file after setup is complete.</p>";

} catch (PDOException $e) {
    echo "<p style='color: red;'>Database Error: " . $e->getMessage() . "</p>";
    echo "<p>Please make sure:</p>";
    echo "<ul>";
    echo "<li>XAMPP MySQL is running</li>";
    echo "<li>Database credentials are correct</li>";
    echo "<li>You have permission to create databases</li>";
    echo "</ul>";
} catch (Exception $e) {
    echo "<p style='color: red;'>Error: " . $e->getMessage() . "</p>";
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Database Setup</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background: #f9fafb;
        }

        h2 {
            color: #059669;
        }
    </style>
</head>

<body>
</body>

</html>