<?php
include 'db_connection.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch quiz questions
$questionsQuery = "SELECT * FROM quiz_questions ORDER BY RAND() LIMIT 15";
$questionsResult = $conn->query($questionsQuery);

if (!$questionsResult) {
    die("Query failed: " . $conn->error);
}

$questions = $questionsResult->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hugyaw Quiz</title>
    <link rel="stylesheet" href="css/quiz_style.css">
    <script>
        let questions = <?php echo json_encode($questions); ?>;
        let currentQuestionIndex = 0;
        let score = 0;

        function showQuestion(index) {
            const questionElement = document.getElementById('question');
            const optionsElement = document.getElementById('options');
            questionElement.textContent = questions[index].question;
            optionsElement.innerHTML = '';
            for (let i = 1; i <= 4; i++) {
                const optionElement = document.createElement('button');
                optionElement.textContent = questions[index]['option' + i];
                optionElement.className = 'option';
                optionElement.onclick = () => selectOption(i - 1);
                optionsElement.appendChild(optionElement);
            }
        }

        function selectOption(selectedOptionIndex) {
            const correctOptionIndex = questions[currentQuestionIndex].correct_option - 1;
            if (selectedOptionIndex === correctOptionIndex) {
                score++;
            }
            currentQuestionIndex++;
            if (currentQuestionIndex < questions.length) {
                showQuestion(currentQuestionIndex);
            } else {
                document.getElementById('score').value = score;
                document.getElementById('quiz-form').submit();
            }
        }

        function restartQuiz() {
            location.reload(); // Reload the page to fetch new random questions
        }

        window.onload = function() {
            showQuestion(currentQuestionIndex);
        }
    </script>
</head>
<body>
    <header>
        <nav>
            <ul class="nav-links">
                <li><a href="Festival.php">Home</a></li>
                <li><a href="feedback.php">Feedbacks</a></li>
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
        <form id="quiz-form" action="quiz_result.php" method="POST">
            <div id="question-container">
                <h2 id="question"></h2>
                <div id="options"></div>
            </div>
            <input type="hidden" id="score" name="score">
        </form>
        <button onclick="restartQuiz()" class="restart-button">Restart Quiz</button>
    </main>
    <footer>
        <p>© 2024 Hugyaw | All rights reserved.</p>
    </footer>
</body>
</html>