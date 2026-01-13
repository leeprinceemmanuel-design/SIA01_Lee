<?php
session_start(); // Start the session to track login state [cite: 100]
require 'db.php'; // Include database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    try {
        // Retrieve the user record from the database [cite: 94]
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verify the password 
        if ($user && password_verify($password, $user['passwd'])) {
            // Success: Set session variables 
            $_SESSION['is_logged_in'] = true;
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['fullname'] = $user['fullname'];
            $_SESSION['email'] = $user['email'];
            
            // Part 7 Requirement: Log successful login [cite: 130]
            error_log("LOGIN_SUCCESS: User '$username' logged in.");

            // Display success message or redirect [cite: 98]
            // Note: The instruction says display message, but usually we redirect to welcome page
            // We will redirect as per Part 5 requirements
            header("Location: welcome.php");
            exit;
        } else {
            // Failure: Invalid credentials
            // Part 7 Requirement: Log failed login attempt [cite: 131]
            error_log("LOGIN_FAILED: Failed attempt for username '$username'.");
            
            // Display failure message [cite: 99]
            echo "Invalid username or password. <a href='login-form.php'>Try again</a>";
        }
    } catch (PDOException $e) {
        // Part 8 Requirement: Error Handling & Logging [cite: 136]
        error_log("LOGIN_DB_ERROR: " . $e->getMessage());
        echo "System error during login. Please try again later.";
    }
}
?>