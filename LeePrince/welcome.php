<?php
session_start(); // Resume the session
require 'db.php'; // Include DB connection to list all users

// Requirement: Access Control
// Check if the user is logged in. If not, redirect to the login form.
if (!isset($_SESSION['is_logged_in']) || $_SESSION['is_logged_in'] !== true) {
    header("Location: login-form.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Welcome</title>
    <style>
        table { border-collapse: collapse; width: 50%; }
        th, td { border: 1px solid black; padding: 8px; text-align: left; }
    </style>
</head>
<body>
    <h2>Login Successful!</h2>
    
    <p><strong>Welcome, <?php echo htmlspecialchars($_SESSION['fullname']); ?>!</strong></p>
    
    <h3>Your Account Details:</h3>
    <ul>
        <li><strong>Username:</strong> <?php echo htmlspecialchars($_SESSION['username']); ?></li>
        <li><strong>Email:</strong> <?php echo htmlspecialchars($_SESSION['email']); ?></li>
        <li><strong>Login Time:</strong> <?php echo date("Y-m-d H:i:s"); ?></li>
    </ul>

    <form action="logout.php" method="POST">
        <button type="submit">Logout</button>
    </form>

    <hr>

    <h3>All Registered Users</h3>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Full Name</th>
                <th>Email</th>
            </tr>
        </thead>
        <tbody>
            <?php
            try {
                // Fetch all users from the database
                $stmt = $pdo->query("SELECT id, fullname, email FROM users");
                
                // Loop through each record and display it in a table row
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['fullname']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                    echo "</tr>";
                }
            } catch (PDOException $e) {
                // Part 8: Error Handling
                error_log("FETCH_USERS_ERROR: " . $e->getMessage());
                echo "<tr><td colspan='3'>Error retrieving user list.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</body>
</html>