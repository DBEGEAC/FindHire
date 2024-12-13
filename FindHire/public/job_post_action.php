<?php
session_start();

// Check if the user is logged in and has HR role
if (!isset($_SESSION['user_role']) || strtolower($_SESSION['user_role']) !== 'hr') {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the form data
    $job_title = $_POST['job_title'];
    $job_description = $_POST['job_description'];
    $job_location = $_POST['job_location'];
    $job_type = $_POST['job_type'];

    // Database connection
    $conn = new mysqli('localhost', 'root', '', 'findhire');
    
    // Check for connection error
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and bind the SQL statement
    $stmt = $conn->prepare("INSERT INTO job_posts (user_id, job_title, job_description, job_location, job_type) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("issss", $_SESSION['user_id'], $job_title, $job_description, $job_location, $job_type);

    // Execute the query
    if ($stmt->execute()) {
        echo "Job post created successfully!";
        // Redirect to HR Dashboard or Job Post List Page
        header("Location: hr_dashboard.php");
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the connection
    $stmt->close();
    $conn->close();
}
?>
