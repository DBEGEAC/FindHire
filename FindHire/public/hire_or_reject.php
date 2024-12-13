<?php
session_start();

// Ensure the user is logged in and has 'hr' role
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'hr') {
    header("Location: login.php");
    exit();
}

require_once '../app/config/db.php';

// Get the applicant_id and job_id from the URL
$action = $_GET['action']; // "hire" or "reject"
$applicant_id = $_GET['applicant_id'];
$job_id = $_GET['job_id'];

// Check if action is either hire or reject
if ($action == 'hire') {
    $status = 'hired';
} elseif ($action == 'reject') {
    $status = 'rejected';
} else {
    die("Invalid action");
}

// Update the application status in the job_applications table
$stmt = $conn->prepare("UPDATE job_applications SET status = ? WHERE applicant_id = ? AND job_id = ?");
$stmt->bind_param("sii", $status, $applicant_id, $job_id);

if ($stmt->execute()) {
    echo "Application has been " . $status . "!";
} else {
    echo "Error updating application status!";
}

$stmt->close();

// Redirect back to manage applicants page
header("Location: manage_applicants.php?job_id=" . $job_id);
exit();
?>
