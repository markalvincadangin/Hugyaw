<?php
include 'db_connection.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$score = $_POST['score'];

// Insert score into the database
$stmt = $conn->prepare("INSERT INTO quiz_scores (user_id, score) VALUES (?, ?)");
$stmt->bind_param("ii", $user_id, $score);
$stmt->execute();
$stmt->close();

// Get top scores from database for leaderboard
$leaderboardQuery = "SELECT users.username, quiz_scores.score FROM quiz_scores JOIN users ON quiz_scores.user_id = users.id ORDER BY quiz_scores.score DESC, quiz_scores.created_at ASC LIMIT 10";
$leaderboardResult = $conn->query($leaderboardQuery);

if (!$leaderboardResult) {
    die("Query failed: " . $conn->error);
}

$leaderboard = $leaderboardResult->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz Result</title>
    <link rel="stylesheet" href="css/quiz_result_style.css">
</head>
<body>
    <header>
        <nav>
            <ul class="nav-links">
                <li><a href="Festival.php">Home</a></li>
                <li><a href="feedback.php">Feedbacks</a></li>
                <li><a href="quiz.php">Quiz</a></li>
                <?php if ($_SESSION['role'] == 'admin'): ?>
                    <li><a href="admin_dashboard.php">Admin</a></li>
                <?php endif; ?>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
        <h1 class="logo">Hugyaw</h1>
        <h3 class="display-user">Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h3>
    </header>
    <main>
        <section class="result-section">
            <h1>Quiz Result</h1>
            <p>Your Score: <?php echo $score; ?>/15</p>
            <h2>Leaderboard</h2>
            <table>
                <tr>
                    <th>Username</th>
                    <th>Score</th>
                </tr>
                <?php foreach ($leaderboard as $entry): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($entry['username']); ?></td>
                        <td><?php echo $entry['score']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </section>
    </main>
    <footer>
        <p>© 2024 Hugyaw | All rights reserved.</p>
    </footer>
</body>
</html>