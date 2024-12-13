<?php
session_start();
session_unset(); // Clear existing session data

// If the user is already logged in, redirect them to their dashboard
if (isset($_SESSION['user_id'])) {
    if ($_SESSION['user_role'] === 'hr') {
        header('Location: /FindHire/public/hr_dashboard.php');
        exit;
    } elseif ($_SESSION['user_role'] === 'applicant') {
        header('Location: /FindHire/public/applicant_dashboard.php');
        exit;
    }
}

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>

<!-- Include the header -->
<?php include('../layout/header.php'); ?>

<h1>Login to FindHire</h1>

<?php
// Display error message if login fails
if (isset($_GET['error']) && $_GET['error'] === 'invalid') {
    echo "<p style='color: red;'>Invalid email or password.</p>";
}
?>

<form method="POST" action="login_action.php">
    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required>

    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required>

    <button type="submit">Login</button>
</form>

<p>Don't have an account? <a href="register.php">Register Here</a></p>

<!-- Include the footer -->
<?php include('../layout/footer.php'); ?>
