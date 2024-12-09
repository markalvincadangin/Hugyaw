<?php
include 'db_connection.php';
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

// Handle form submissions and fetch data (omitted for brevity)

// Fetch all quiz questions
$questionsQuery = "SELECT * FROM quiz_questions";
$questionsResult = $conn->query($questionsQuery);

if (!$questionsResult) {
    die("Query failed: " . $conn->error);
}

$questions = $questionsResult->fetch_all(MYSQLI_ASSOC);

// Fetch all feedback
$feedbackQuery = "SELECT * FROM feedback";
$feedbackResult = $conn->query($feedbackQuery);

if (!$feedbackResult) {
    die("Query failed: " . $conn->error);
}

$feedback = $feedbackResult->fetch_all(MYSQLI_ASSOC);

// Fetch all users
$usersQuery = "SELECT * FROM users";
$usersResult = $conn->query($usersQuery);

if (!$usersResult) {
    die("Query failed: " . $conn->error);
}

$users = $usersResult->fetch_all(MYSQLI_ASSOC);

// Fetch all scores
$scoresQuery = "SELECT quiz_scores.id, users.username, quiz_scores.score FROM quiz_scores JOIN users ON quiz_scores.user_id = users.id ORDER BY quiz_scores.score DESC, quiz_scores.created_at ASC";
$scoresResult = $conn->query($scoresQuery);

if (!$scoresResult) {
    die("Query failed: " . $conn->error);
}

$scores = $scoresResult->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="css/admin_style.css">
    <script>
        function showSection(sectionId) {
            const sections = document.querySelectorAll('.admin-section');
            sections.forEach(section => {
                section.style.display = 'none';
            });
            document.getElementById(sectionId).style.display = 'block';
        }
    </script>
</head>
<body>
    <header>
        <nav>
            <ul class="nav-links">
                <li><a href="Festival.php">Home</a></li>
                <li><a href="feedback.php">Feedbacks</a></li>
                <li><a href="quiz.php">Quiz</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
        <h1 class="logo">Hugyaw</h1>
    </header>
    <main>
        <section class="action-section">
            <h1>Admin Dashboard</h1>
            <p>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</p>
            <select class="action-select" onchange="showSection(this.value)">
                <option value="">Select an action</option>
                <option value="quiz-section">Manage Quiz Questions</option>
                <option value="feedback-section">Manage Feedback</option>
                <option value="user-section">Manage Users</option>
                <option value="score-section">Manage Scores</option>
            </select>
        </section>

        <!-- Manage Quiz Questions -->
        <section id="quiz-section" class="admin-section" style="display:none;">
            <h2>Manage Quiz Questions</h2>
            <form action="admin_dashboard.php" method="POST" class="admin-form">
                <label for="question">Question:</label>
                <textarea name="question" id="question" rows="4" required></textarea><br><br>
                <label for="option1">Option 1:</label>
                <input type="text" name="option1" id="option1" required><br><br>
                <label for="option2">Option 2:</label>
                <input type="text" name="option2" id="option2" required><br><br>
                <label for="option3">Option 3:</label>
                <input type="text" name="option3" id="option3" required><br><br>
                <label for="option4">Option 4:</label>
                <input type="text" name="option4" id="option4" required><br><br>
                <label for="correct_option">Correct Option (1-4):</label>
                <input type="number" name="correct_option" id="correct_option" min="1" max="4" required><br><br>
                <input type="submit" name="add_question" value="Add Question">
            </form>

            <?php foreach ($questions as $question): ?>
                <form action="admin_dashboard.php" method="POST" class="admin-form">
                    <input type="hidden" name="question_id" value="<?php echo $question['id']; ?>">
                    <label for="question">Question:</label>
                    <textarea name="question" rows="4" required><?php echo htmlspecialchars($question['question']); ?></textarea><br><br>
                    <label for="option1">Option 1:</label>
                    <input type="text" name="option1" value="<?php echo htmlspecialchars($question['option1']); ?>" required><br><br>
                    <label for="option2">Option 2:</label>
                    <input type="text" name="option2" value="<?php echo htmlspecialchars($question['option2']); ?>" required><br><br>
                    <label for="option3">Option 3:</label>
                    <input type="text" name="option3" value="<?php echo htmlspecialchars($question['option3']); ?>" required><br><br>
                    <label for="option4">Option 4:</label>
                    <input type="text" name="option4" value="<?php echo htmlspecialchars($question['option4']); ?>" required><br><br>
                    <label for="correct_option">Correct Option (1-4):</label>
                    <input type="number" name="correct_option" value="<?php echo $question['correct_option']; ?>" min="1" max="4" required><br><br>
                    <input type="submit" name="edit_question" value="Edit Question">
                    <input type="submit" name="delete_question" value="Delete Question">
                </form>
                <hr>
            <?php endforeach; ?>
        </section>

        <!-- Manage Feedback -->
        <section id="feedback-section" class="admin-section" style="display:none;">
            <h2>Manage Feedback</h2>
            <?php if (empty($feedback)): ?>
                <p>No feedback available.</p>
            <?php else: ?>
                <?php foreach ($feedback as $comment): ?>
                    <div class="feedback">
                        <p><strong><?php echo htmlspecialchars($comment['username']); ?>:</strong> <?php echo htmlspecialchars($comment['comment']); ?></p>
                        <p><small>Posted on: <?php echo $comment['created_at']; ?></small></p>
                        <form action="admin_dashboard.php" method="POST" class="edit-feedback-form">
                            <input type="hidden" name="feedback_id" value="<?php echo $comment['id']; ?>">
                            <textarea name="comment" rows="2" cols="50" required><?php echo htmlspecialchars($comment['comment']); ?></textarea><br><br>
                            <input type="submit" name="edit_feedback" value="Edit">
                        </form>
                        <form action="admin_dashboard.php" method="POST" class="delete-feedback-form">
                            <input type="hidden" name="feedback_id" value="<?php echo $comment['id']; ?>">
                            <input type="submit" name="delete_feedback" value="Delete">
                        </form>
                    </div>
                    <hr>
                <?php endforeach; ?>
            <?php endif; ?>
        </section>

        <!-- Manage Users -->
        <section id="user-section" class="admin-section" style="display:none;">
            <h2>Manage Users</h2>
            <?php foreach ($users as $user): ?>
                <div class="user">
                    <p><strong>Username:</strong> <?php echo htmlspecialchars($user['username']); ?></p>
                    <p><strong>Role:</strong> <?php echo htmlspecialchars($user['role']); ?></p>
                    <form action="admin_dashboard.php" method="POST" class="edit-user-form">
                        <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                        <label for="username">Username:</label>
                        <input type="text" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required><br><br>
                        <label for="role">Role:</label>
                        <select name="role" required>
                            <option value="user" <?php if ($user['role'] == 'user') echo 'selected'; ?>>User</option>
                            <option value="admin" <?php if ($user['role'] == 'admin') echo 'selected'; ?>>Admin</option>
                        </select><br><br>
                        <input type="submit" name="edit_user" value="Edit User">
                    </form>
                    <form action="admin_dashboard.php" method="POST" class="delete-user-form">
                        <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                        <input type="submit" name="delete_user" value="Delete User">
                    </form>
                </div>
                <hr>
            <?php endforeach; ?>
        </section>

        <!-- Manage Scores -->
        <section id="score-section" class="admin-section" style="display:none;">
            <h2>Manage Scores</h2>
            <?php if (empty($scores)): ?>
                <p>No scores available.</p>
            <?php else: ?>
                <?php foreach ($scores as $score): ?>
                    <div class="score">
                        <p><strong>Username:</strong> <?php echo htmlspecialchars($score['username']); ?></p>
                        <p><strong>Score:</strong> <?php echo htmlspecialchars($score['score']); ?></p>
                        <form action="admin_dashboard.php" method="POST" class="delete-score-form">
                            <input type="hidden" name="score_id" value="<?php echo $score['id']; ?>">
                            <input type="submit" name="delete_score" value="Delete Score">
                        </form>
                    </div>
                    <hr>
                <?php endforeach; ?>
            <?php endif; ?>
        </section>
    </main>
    <footer>
        <p>© 2024 Hugyaw | All rights reserved.</p>
    </footer>
</body>
</html>