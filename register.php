<?php
include 'db_connection.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $role = isset($_POST['role']) ? $_POST['role'] : 'user';

    $checkQuery = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($checkQuery);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $error = "Username already exists.";
    } else {
        $insertQuery = "INSERT INTO users (username, password, role) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($insertQuery);
        $stmt->bind_param("sss", $username, $password, $role);
        if ($stmt->execute()) {
            $success = "Registration successful. You can now <a href='/Hugyaw/login.php'>login</a>.";
        } else {
            $error = "Error registering user: " . $conn->error;
        }
    }
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale="1.0">
    <title>Register</title>
    <link rel="stylesheet" href="css/log_style.css">
</head>
<body>
    <div class="container">
        <h2>Register</h2>
        <?php if (isset($error)): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>
        <?php if (isset($success)): ?>
            <p class="success"><?php echo $success; ?></p>
        <?php endif; ?>
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