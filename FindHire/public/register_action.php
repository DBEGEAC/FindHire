<?php
// Include the database connection
include('db.php');

// Check if form data is submitted via POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Sanitize and validate the form data
    $name = htmlspecialchars($_POST['name']);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];
    $role = $_POST['role'];

    // Check if email is valid
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format.";
        exit();
    }

    // Optionally hash the password for security
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    try {
        // Prepare SQL query to insert data into the database
        $sql = "INSERT INTO users (name, email, password, role) VALUES (:name, :email, :password, :role)";
        
        // Prepare the statement
        $stmt = $pdo->prepare($sql);
        
        // Bind parameters to prevent SQL injection
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashed_password);
        $stmt->bindParam(':role', $role);
        
        // Execute the query
        if ($stmt->execute()) {
            echo "Registration successful!";
            // Redirect user to login page or other page after registration
            header("Location: login.php");
            exit();
        } else {
            echo "Error: Could not register the user.";
        }
    } catch (PDOException $e) {
        // Handle any SQL exceptions (e.g., duplicate email)
        echo "Error: " . $e->getMessage();
    }
}
?>
