<?php
session_start(); // Initialize the session to access current session data

// Requirement: Destroy the session by clearing or deleting user’s session data [cite: 118]
$_SESSION = array(); // Clear all session variables
session_destroy();   // Destroy the session itself

// Requirement: Redirect the user back to the login page [cite: 119]
header("Location: login-form.php");
exit;
?>