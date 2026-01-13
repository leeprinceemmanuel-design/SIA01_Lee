<?php
// Part 2: Database Connection [cite: 67, 70]
$host = 'localhost';
$dbname = 'sia01_lee'; // Ensure this matches the database name you created in Part 1
$username = 'root';   // Default XAMPP username
$password = '';       // Default XAMPP password is usually empty

try {
    // We use PDO (PHP Data Objects) for a secure connection [cite: 70]
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    
    // Set error mode to exception to handle errors properly
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    // Part 8 Requirement: Error Handling & Logging [cite: 135, 136, 140]
    // Log the technical error to the PHP error log
    error_log("CONNECTION_ERROR: " . $e->getMessage());
    
    // Show a user-friendly message on the screen [cite: 137]
    die("<strong>Error:</strong> Could not connect to the database. Please try again later.");
}
?>