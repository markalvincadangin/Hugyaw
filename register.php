<?php
include 'db_connection.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register'])) {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = 'user'; // Default role

    // Only allow admin to set roles
    if (isset($_SESSION['user_id']) && $_SESSION['role'] == 'admin' && isset($_POST['role'])) {
        $role = $_POST['role'];
    }

    $stmt = $conn->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $password, $role);
    $stmt->execute();
    $stmt->close();

    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="css/log_style.css">
</head>
<body>
    <div class="container">
        <h2>Register</h2>
        <form action="register.php" method="POST">
            <label for="username">Username:</label>
            <input type="text" name="username" id="username" required><br><br>
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required><br><br>
            <?php if (isset($_SESSION['user_id']) && $_SESSION['role'] == 'admin'): ?>
                <label for="role">Role:</label>
                <select name="role" id="role">
                    <option value="user">User</option>
                    <option value="admin">Admin</option>
                </select><br><br>
            <?php endif; ?>
            <input type="submit" name="register" value="Register">
        </form>
        <p>Already have an account? <a href="/Hugyaw/login.php">Login here</a></p>
    </div>
</body>
</html>