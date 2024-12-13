<?php
// db.php - Database connection

// Create a connection to the database
$conn = new mysqli('localhost', 'root', '', 'findhire');

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Database credentials (you can put these in a .env file for better security)
$host = '127.0.0.1';  // Database host (localhost)
$dbname = 'findhire';  // Database name
$username = 'root';     // Database username
$password = '';         // Database password (empty for default XAMPP setup)

// Set the DSN (Data Source Name)
$dsn = "mysql:host=$host;dbname=$dbname;charset=utf8";

try {
    // Create a PDO instance (this is your database connection)
    $pdo = new PDO($dsn, $username, $password);
    
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Handle connection errors
    echo "Connection failed: " . $e->getMessage();
    exit();
}
?>
