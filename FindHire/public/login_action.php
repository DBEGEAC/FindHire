<?php
session_start(); // Ensure session is started at the top of the script

// Database connection
$conn = new mysqli('localhost', 'root', '', 'findhire');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if email and password are provided
if (isset($_POST['email']) && isset($_POST['password'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Prepare the query to fetch user data by email
    $stmt = $conn->prepare('SELECT user_id, name, email, password, role FROM users WHERE email = ?');
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if a user with the provided email exists
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Ensure that 'user_id' is available in the $user array
        if (isset($user['user_id'])) {
            // Verify the password
            if (password_verify($password, $user['password'])) {
                // If password is correct, set session data

                // Regenerate session ID for security
                session_regenerate_id(true);

                // Set session variables
                $_SESSION['user_id'] = $user['user_id'];  // Correct user_id from the database
                $_SESSION['user_role'] = $user['role'];
                $_SESSION['user_name'] = $user['name'];  // Add name to session for HR dashboard

                // Redirect to the appropriate dashboard based on user role
                if ($_SESSION['user_role'] === 'hr') {
                    header('Location: /FindHire/public/hr_dashboard.php');  // Ensure this path is correct
                    exit;
                } elseif ($_SESSION['user_role'] === 'applicant') {
                    header('Location: /FindHire/public/applicant_dashboard.php');
                    exit;
                }
            } else {
                // Invalid password
                header('Location: login.php?error=invalid');
                exit;
            }
        } else {
            // 'user_id' is missing from the user data, which is unexpected
            echo "Error: 'user_id' is missing from the user data.<br>";
            echo '<pre>';
            var_dump($user); // Print user data to debug
            echo '</pre>';
            exit;
        }
    } else {
        // No user found with this email
        header('Location: login.php?error=invalid');
        exit;
    }
} else {
    // Missing email or password
    header('Location: login.php?error=invalid');
    exit;
}
?>
