<?php
// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page if not logged in
    header("Location: login.php");
    exit;
}

// Get the logged-in user's data from the session
$user_email = $_SESSION['email'];
$user_role = $_SESSION['role'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - FindHire</title>
</head>
<body>

    <header>
        <h1>Welcome to Your Dashboard, <?php echo htmlspecialchars($user_email); ?>!</h1>
        <p>Your role: <?php echo htmlspecialchars($user_role); ?></p>
        <p><a href="logout.php">Logout</a></p>
    </header>

    <main>
        <h2>Dashboard Content</h2>
        <!-- You can add the content for HR or Applicant here based on the role -->
        <?php if ($user_role == 'hr'): ?>
            <p>HR Dashboard: Manage Job Posts and Applicants</p>
            <!-- HR-specific content -->
        <?php elseif ($user_role == 'applicant'): ?>
            <p>Applicant Dashboard: View and Apply for Jobs</p>
            <!-- Applicant-specific content -->
        <?php endif; ?>
    </main>

</body>
</html>
