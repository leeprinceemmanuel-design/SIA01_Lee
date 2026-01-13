<?php
require 'db.php'; // Include the database connection [cite: 71]

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect data from the form [cite: 80]
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    try {
        // Validation: Check if email or username already exists [cite: 83, 84, 85]
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE email = ? OR username = ?");
        $stmt->execute([$email, $username]);
        
        if ($stmt->fetchColumn() > 0) {
            // Failure: Duplicate entry
            echo "Error: Email or Username already exists. <a href='registration-form.php'>Try again</a>";
        } else {
            // Hash the password for security 
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Insert the new user into the database [cite: 81]
            $sql = "INSERT INTO users (fullname, email, username, passwd) VALUES (?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$fullname, $email, $username, $hashed_password]);

            // Part 7 Requirement: Log successful registration 
            error_log("REGISTRATION_SUCCESS: User '$username' registered successfully.");

            // Redirect to login page upon success [cite: 82]
            header("Location: login-form.php");
            exit;
        }
    } catch (PDOException $e) {
        // Part 8 Requirement: Error Handling & Logging [cite: 136, 140]
        error_log("REGISTRATION_ERROR: " . $e->getMessage());
        echo "An error occurred during registration. Please try again later.";
    }
}
?>