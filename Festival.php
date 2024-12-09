<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Festivals</title>
    <link rel="stylesheet" href="css/hugyaw_style.css">
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
    </header>
    <section class="head">
        <div class="head-content">
            <h1>Hugyaw</h1>
            <h2>Pagpabugal sang Kultura kag Tradisyon Padulong sa Ka-uswagan</h2>
        </div>
    </section>
    <section class="content">
        <div class="explanation">
            <h2>Hugyaw</h2>
            <p>Emphasizes the importance of showcasing and taking pride in one's culture and traditions as a pathway to progress.
            By preserving and celebrating heritage, communities can foster unity, inspire innovation, and attract opportunities
            for development. This approach highlights how cultural identity can drive growth while ensuring that the richness of
            history and values is passed on to future generations.</p>
        </div>
        <section class="content">
        <div class="explanation">
            <h2>Experience the Vibrant Festivals That Bring Municipalities to Life</h2>
            <p>Embark on a journey to discover the vibrant culture and rich traditions of various municipalities,
            where every festival tells a unique story of heritage, unity, and joy.</p>
        </div>

        <div class="image-container">
            <div class="image-box">
                <a href="html/Barotac Nuevo.html">
                    <img src="images/Barotac Nuevo/Barotac Nuevo.jpg" alt=" Barotac Nuevo">
                    <p class="text">Barotac Nuevo, Iloilo</p>
                </a>
            </div>
            <div class="image-box">
                <a href="html/Barotac Viejo.html">
                    <img src="images/Barotac Viejo/Barotac Viejo.jpg" alt="Barotac Viejo">
                    <p class="text">Barotac Viejo, Iloilo</p>
                </a>
            </div>
            <div class="image-box">
                <a href="html/Cabatuan.html">
                    <img src="images/Cabatuan/Cabatuan.jpg" alt="Cabatuan">
                    <p class="text">Cabatuan, Iloilo</p>
                </a>
            </div>
            <div class="image-box">
                <a href="html/Leon.html">
                    <img src="images/Leon/Leon.jpg" alt="Leon">
                    <p class="text">Leon, Iloilo</p>
                </a>
            </div>
        </div>
    </section>
    <footer>
        <p>© 2024 Hugyaw | All rights reserved.</p>
    </footer>
</body>
</html>
