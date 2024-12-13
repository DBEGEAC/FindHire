<?php
// Include db.php with the correct relative path
require_once __DIR__ . '/../config/db.php';

class User {
    private $db;
    private $id;
    private $username;
    private $role;

    // Constructor accepts the database connection
    public function __construct($db) {
        $this->db = $db;
    }

    // Login method
    public function login($username, $password) {
        // Correct the query to use the 'name' column for the username
        $query = "SELECT user_id, name, password, role FROM users WHERE name = :username LIMIT 1"; // 'name' is the actual column name

        // Prepare and execute the query
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        // Check if a user was found and validate the password
        if ($stmt->rowCount() > 0) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            if (password_verify($password, $user['password'])) {
                // Set the user properties
                $this->id = $user['user_id'];  // Primary key
                $this->username = $user['name'];  // The username column is 'name'
                $this->role = $user['role'];  // User role
                return true;
            }
        }
        return false;
    }

    // Getter for user ID
    public function getId() {
        return $this->id;
    }

    // Getter for username
    public function getUsername() {
        return $this->username;
    }

    // Getter for user role
    public function getRole() {
        return $this->role;
    }
}
