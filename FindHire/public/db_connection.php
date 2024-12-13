<?php
// Ensure there are no unnecessary infinite loops or excessive memory usage here

// Database credentials
$host = 'localhost';  // Database host
$user = 'root';       // Database username
$password = '';       // Database password
$dbname = 'findhire'; // Database name

// Create a connection to the database
$conn = new mysqli($host, $user, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
