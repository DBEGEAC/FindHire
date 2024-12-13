<?php
session_start();

// Ensure user is logged in and has 'hr' role
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'hr') {
    header("Location: login.php");
    exit();
}

// Include the database connection
require_once '../app/config/db.php';  // This includes the $conn variable

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Capture form data
    $job_title = $_POST['job_title'];
    $company = $_POST['company'];
    $location = $_POST['location'];
    $description = $_POST['description'];

    // Insert job post into database
    $stmt = $conn->prepare("INSERT INTO job_posts (user_id, job_title, company, location, description) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("issss", $_SESSION['user_id'], $job_title, $company, $location, $description);
    
    if ($stmt->execute()) {
        echo "Job post created successfully!";
    } else {
        echo "Error creating job post!";
    }

    // Close the statement
    $stmt->close();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create a Job Post</title>
</head>
<body>
    <h1>Create a New Job Post</h1>
    
    <form action="job_post.php" method="post">
        <label for="job_title">Job Title:</label>
        <input type="text" id="job_title" name="job_title" required><br>

        <label for="company">Company:</label>
        <input type="text" id="company" name="company" required><br>

        <label for="location">Location:</label>
        <input type="text" id="location" name="location" required><br>

        <label for="description">Description:</label>
        <textarea id="description" name="description" required></textarea><br>

        <button type="submit">Create Job Post</button>
    </form>

    <a href="hr_dashboard.php">Back to HR Dashboard</a>
</body>
</html>
