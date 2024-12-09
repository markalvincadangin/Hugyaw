<?php
include 'db_connection.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch municipalities for the dropdown
$municipalitiesQuery = "SELECT id, name FROM municipalities";
$municipalitiesResult = $conn->query($municipalitiesQuery);

if (!$municipalitiesResult) {
    die("Query failed: " . $conn->error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_feedback'])) {
    $municipality_id = $_POST['municipality_id'];
    $comment = $_POST['comment'];
    $username = $_SESSION['username'];

    // Insert feedback into the database
    $stmt = $conn->prepare("INSERT INTO feedback (municipality_id, comment, username) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $municipality_id, $comment, $username);
    $stmt->execute();
    $stmt->close();
}

// Handle edit feedback
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit_feedback'])) {
    $feedback_id = $_POST['feedback_id'];
    $comment = $_POST['comment'];

    // Update feedback in the database
    $stmt = $conn->prepare("UPDATE feedback SET comment = ? WHERE id = ? AND username = ?");
    $stmt->bind_param("sis", $comment, $feedback_id, $_SESSION['username']);
    $stmt->execute();
    $stmt->close();
}

// Handle delete feedback
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_feedback'])) {
    $feedback_id = $_POST['feedback_id'];

    // Delete feedback from the database
    $stmt = $conn->prepare("DELETE FROM feedback WHERE id = ? AND username = ?");
    $stmt->bind_param("is", $feedback_id, $_SESSION['username']);
    $stmt->execute();
    $stmt->close();
}

// Get feedback for the selected municipality
$feedback = [];
if (isset($_GET['municipality_id'])) {
    $municipality_id = $_GET['municipality_id'];
    $feedbackQuery = "SELECT * FROM feedback WHERE municipality_id = ? ORDER BY created_at DESC";
    $stmt = $conn->prepare($feedbackQuery);
    $stmt->bind_param("i", $municipality_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $feedback = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
}

// Fetch municipalities again for the view feedback dropdown
$municipalitiesResultView = $conn->query($municipalitiesQuery);

if (!$municipalitiesResultView) {
    die("Query failed: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback - Hugyaw</title>
    <link rel="stylesheet" href="css/feedback_style.css">
</head>
<body>
    <header>
        <nav>
            <ul class="nav-links">
                <li><a href="/Hugyaw/Festival.php">Home</a></li>
                <li><a href="/Hugyaw/feedback.php">Feedbacks</a></li>
                <li><a href="/Hugyaw/quiz.php">Quiz</a></li>
                <li><a href="/Hugyaw/logout.php">Logout</a></li>
            </ul>
        </nav>
        <h1 class="logo">Hugyaw</h1>
    </header>
    <main>
        <section class="feedback-section">
            <h1>Festival Feedback</h1>

            <!-- Feedback Form -->
            <form action="feedback.php" method="POST" class="feedback-form">
                <label for="municipality_id">Select Municipality:</label>
                <select name="municipality_id" id="municipality_id" required>
                    <option value="">--Select Municipality--</option>
                    <?php while ($row = $municipalitiesResult->fetch_assoc()) { ?>
                        <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                    <?php } ?>
                </select><br><br>

                <label for="comment">Your Feedback:</label><br>
                <textarea name="comment" id="comment" rows="4" cols="50" required></textarea><br><br>
                <input type="submit" name="submit_feedback" value="Submit Feedback">
            </form>

            <!-- View Feedback Section -->
            <h2>View Feedback</h2>
            <form action="feedback.php" method="GET" class="view-feedback-form">
                <label for="municipality_id_view">Select Municipality:</label>
                <select name="municipality_id" id="municipality_id_view" required>
                    <option value="">--Select Municipality--</option>
                    <?php while ($row = $municipalitiesResultView->fetch_assoc()) { ?>
                        <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                    <?php } ?>
                </select><br><br>
                <input type="submit" value="View Feedback">
            </form>

            <!-- Feedback Display Section -->
            <?php if (isset($feedback) && count($feedback) > 0): ?>
                <h2>Feedback for Selected Municipality</h2>
                <div id="feedbackList">
                    <?php foreach ($feedback as $comment): ?>
                        <div class="feedback">
                            <p><strong><?php echo htmlspecialchars($comment['username']); ?>:</strong> <?php echo htmlspecialchars($comment['comment']); ?></p>
                            <p><small>Posted on: <?php echo $comment['created_at']; ?></small></p>
                            <?php if ($comment['username'] == $_SESSION['username']): ?>
                                <form action="feedback.php" method="POST" class="edit-feedback-form">
                                    <input type="hidden" name="feedback_id" value="<?php echo $comment['id']; ?>">
                                    <textarea name="comment" rows="2" cols="50" required><?php echo htmlspecialchars($comment['comment']); ?></textarea><br><br>
                                    <input type="submit" name="edit_feedback" value="Edit">
                                </form>
                                <form action="feedback.php" method="POST" class="delete-feedback-form">
                                    <input type="hidden" name="feedback_id" value="<?php echo $comment['id']; ?>">
                                    <input type="submit" name="delete_feedback" value="Delete">
                                </form>
                            <?php endif; ?>
                        </div>
                        <hr>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p>No feedback available for this municipality. Please select a municipality and submit your feedback!</p>
            <?php endif; ?>
        </section>
    </main>
    <footer>
        <p>© 2024 Hugyaw | All rights reserved.</p>
    </footer>
</body>
</html>
