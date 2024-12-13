<?php
require_once 'app/config/db.php';
require_once 'app/models/User.php';

class AuthController {

    // Login method
    public function login($email, $password) {
        $user = User::getUserByEmail($email);
        
        if ($user && password_verify($password, $user['password'])) {
            session_start();
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['role'] = $user['role'];
            header("Location: index.php");
        } else {
            echo "Invalid credentials!";
        }
    }

    // Logout method
    public function logout() {
        session_start();
        session_unset();
        session_destroy();
        header("Location: login.php");
    }
}
?>
