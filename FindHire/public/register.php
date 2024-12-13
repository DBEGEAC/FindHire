<?php
// Include the database connection (adjust the path if necessary)
include('../includes/db.php');  // Correct path based on your file structure

// Check if form data is submitted via POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Sanitize and validate form data
    $user_name = htmlspecialchars($_POST['username']);
    $user_email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $user_password = $_POST['password'];
    $user_role = $_POST['role'];  // Capture role from the form

    // Validate the email
    if (!filter_var($user_email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format.";
        exit();
    }

    // Optionally hash the password for security
    $hashed_password = password_hash($user_password, PASSWORD_DEFAULT);
    
    try {
        // Prepare SQL query to insert data
        $sql = "INSERT INTO users (name, email, password, role) VALUES (:name, :email, :password, :role)";
        
        // Prepare statement
        $stmt = $pdo->prepare($sql);
        
        // Bind parameters to prevent SQL injection
        $stmt->bindParam(':name', $user_name);
        $stmt->bindParam(':email', $user_email);
        $stmt->bindParam(':password', $hashed_password);
        $stmt->bindParam(':role', $user_role);  // Bind role to the query
        
        // Execute the query
        if ($stmt->execute()) {
            echo "Registration successful!";
            // Redirect user to the login page or elsewhere
            header("Location: login.php");  // Optional redirection
            exit();
        } else {
            echo "Error: Could not register the user.";
        }
    } catch (PDOException $e) {
        // Handle any exceptions or database errors
        echo "Error: " . $e->getMessage();
    }
}
?>

<!-- HTML Form for Registration -->
<h1>Register to FindHire</h1>

<form method="POST" action="register.php">
    <label for="username">Name:</label>
    <input type="text" name="username" id="username" required>

    <label for="email">Email:</label>
    <input type="email" name="email" id="email" required>

    <label for="password">Password:</label>
    <input type="password" name="password" id="password" required>

    <label for="role">Role:</label>
    <select name="role" id="role" required>
        <option value="hr">HR</option>
        <option value="applicant">Applicant</option>
    </select>

    <button type="submit">Register</button>
</form>

<p>Already have an account? <a href="login.php">Login Here</a></p>
