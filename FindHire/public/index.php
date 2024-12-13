<?php
session_start();  // Ensure session is started at the top

// Check if user is logged in and role is set in the session
if (isset($_SESSION['user_id']) && isset($_SESSION['user_role'])) {
    $role = $_SESSION['user_role'];
    echo "Welcome, " . $_SESSION['user_name'] . "!";
} else {
    // If not logged in or session data is missing, you can show a default message
    echo "Welcome, Guest!";
}
?>
