<?php
session_start();

// Ensure the user is logged in and has 'hr' role
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'hr') {
    header("Location: login.php");
    exit();
}

require_once '../app/config/db.php';

// Get message ID from URL
$message_id = $_GET['message_id'];

// Mark message as read
$stmt = $conn->prepare("UPDATE messages SET status = 'read' WHERE id = ?");
$stmt->bind_param("i", $message_id);

if ($stmt->execute()) {
    echo "Message marked as read!";
} else {
    echo "Error marking message as read.";
}

$stmt->close();

// Redirect back to the HR messages page
header("Location: hr_dashboard.php");
exit();
?>
