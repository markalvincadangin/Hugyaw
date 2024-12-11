# Hugyaw

The Hugyaw project is a website designed to celebrate and preserve the rich cultural heritage of the respective municipalities of the creators. This platform enables users to engage with the festival by selecting a municipality, submitting their feedback, and viewing feedback from others. Additionally, users can have fun by answering a quiz about the festivals. The application also features an admin dashboard that allows administrators to efficiently manage quiz questions, feedback, users, and scores, ensuring a seamless and interactive experience for all users.

## Features

- Submit feedback for a selected municipality.
- View feedback for a selected municipality.
- Delete feedback entries.
- Admin dashboard for managing:
  - Quiz questions
  - Feedback
  - Users
  - Scores

## Technologies Used

- HTML
- CSS
- PHP
- MySQL
- XAMPP

## Setup Instructions

### Prerequisites

- XAMPP (or any other local server environment with PHP and MySQL)
- Web browser
- Git
- GitHub Desktop

### Installation Steps

1. **Clone the Repository**:
    - Open GitHub Desktop.
    - Click on `File` > `Clone repository`.
    - In the `URL` tab, paste the repository URL: `https://github.com/markalvincadangin/Hugyaw.git`.
    - Choose the local path where you want to clone the repository.
    - Click on `Clone`.

2. **Start XAMPP**:
   - Open the XAMPP Control Panel.
   - Start the Apache and MySQL services.

3. **Set Up the Database**:
   - Open your web browser and go to `http://localhost/phpmyadmin`.
   - Create a new database named `hugyaw`.
   - Click on the "SQL" tab and run the following SQL queries to create the necessary tables:
     ```sql
     CREATE TABLE municipalities (
         id INT AUTO_INCREMENT PRIMARY KEY,
         name VARCHAR(255) NOT NULL
     );

     CREATE TABLE feedback (
         id INT AUTO_INCREMENT PRIMARY KEY,
         municipality_id INT NOT NULL,
         user_id INT NOT NULL,
         comment TEXT NOT NULL,
         created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
         FOREIGN KEY (municipality_id) REFERENCES municipalities(id),
         FOREIGN KEY (user_id) REFERENCES users(id)
     );

     CREATE TABLE quiz_questions (
         id INT AUTO_INCREMENT PRIMARY KEY,
         question TEXT NOT NULL,
         option1 VARCHAR(255) NOT NULL,
         option2 VARCHAR(255) NOT NULL,
         option3 VARCHAR(255) NOT NULL,
         option4 VARCHAR(255) NOT NULL,
         correct_option INT NOT NULL
     );

     CREATE TABLE quiz_scores (
         id INT AUTO_INCREMENT PRIMARY KEY,
         user_id INT NOT NULL,
         score INT NOT NULL,
         created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
         FOREIGN KEY (user_id) REFERENCES users(id)
     );

     CREATE TABLE users (
         id INT AUTO_INCREMENT PRIMARY KEY,
         username VARCHAR(255) NOT NULL,
         password VARCHAR(255) NOT NULL,
         role VARCHAR(50) NOT NULL
     );
     ```
   - **Note**: Before clicking "Go", uncheck the "Enable foreign key checks" option.
   - Click "Go" to execute the queries.

5. **Insert Data**:
   - Insert the following data into the `municipalities`, `users`, and `quiz_questions` tables.
   - Click on the "SQL" tab and enter the following SQL queries:

     **Insert Municipalities:**
     ```sql
     INSERT INTO municipalities (name) VALUES ('Barotac Nuevo'), ('Barotac Viejo'), ('Cabatuan'), ('Leon');
     ```

     **Insert Admin User:**
     ```sql
     INSERT INTO users (username, password, role) VALUES ('admin', '$2y$10$Z/x7EYFFCZUucEmdIjPvQ.bjW0Hf.TeCz3KYWa9SV9Eju5TLuU76a', 'admin');
     ```

     **Insert Quiz Questions:**
     ```sql
     INSERT INTO quiz_questions (question, option1, option2, option3, option4, correct_option) VALUES
     ('What is Leon, Iloilo, popularly known as?', 'Summer Capital of Iloilo', 'Vegetable Basket of Iloilo', 'Agricultural Hub of the Philippines', 'Historical Town of Iloilo', 1),
     ('What does the Kaing Festival in Leon primarily celebrate?', 'The cultural heritage of Leon', 'The bravery of the town’s ancestors', 'The agricultural abundance and farmers of Leon', 'The history of Bucari as a tourist destination', 3),
     ('What is the main focus of the Handuraw Festival in Leon?', 'Showcasing eco-tourism and farming practices', 'Reflecting on Leon’s history and cultural traditions', 'Promoting the town local produce', 'Celebrating modern progress in the town', 2),
     ('What popular eco-tourism destination in Leon is often visited during festivals?', 'Bucari', 'Camando', 'Iloilo River', 'Pavia Highlands', 1),
     ('What is Barotac Nuevo known for?', 'Its love of football', 'Its historical landmarks', 'Its agricultural productivity', 'Its modern technology', 1),
     ('What does the Tamasak Festival in Barotac Nuevo celebrate?', 'The town’s rich history and heritage', 'The bravery of the town’s ancestors', 'The agricultural abundance and farmers of Barotac Nuevo', 'The history of Bucari as a tourist destination', 1),
     ('What is the Hili-usa Festival in Barotac Nuevo known for?', 'Showcasing eco-tourism and farming practices', 'Reflecting on Barotac Nuevo’s history and cultural traditions', 'Promoting the town local produce', 'Celebrating the unity and collective spirit of its people', 4),
     ('What is Cabatuan historically known for?', 'Its famous dish, Tinuom', 'The "Sinulugans" and their art of sword fighting', 'Being the agricultural center of Iloilo and Visayas', 'The production of banana leaves and tobacco', 1),
     ('When is the Tinuom Festival in Cabatuan celebrated?', 'Every April 9', 'During the Christmas season', 'The first Sunday of September, lasting for 10 days', 'Every November', 3),
     ('What does the Tinuom Festival in Cabatuan primarily honor?', 'The art of sword fighting and dragon dance', 'The agricultural and economic productivity of Cabatuan', 'The patron saint, San Nicolas de Tolentino, and the Tinuom dish', 'The foundation of Cabatuan', 3),
     ('What is Tinuom, as celebrated in the Tinuom Festival in Cabatuan?', 'A witch craft ritual', 'A native chicken soup with spices, wrapped in banana leaves', 'A form of traditional dance', 'A sword-fighting performance', 2),
     ('What significant event marked the establishment of Cabatuan in 1732?', 'The first Tinuom Festival', 'The arrival of Spanish settlers', 'The placement of a molave cross on Pamul-ogan Hill', 'The time when Romeo and Juliet was produced', 3),
     ('What does the Patubas Festival in Barotac Viejo celebrate?', 'The town’s rich history and heritage', 'The bravery of the town’s ancestors', 'The agricultural abundance and farmers of Barotac Viejo', 'The history of Bucari as a tourist destination', 3),
     ('What does the term "Patubas" mean in Hiligaynon?', 'Unity', 'Harvest', 'Culture', 'Diversity', 2),
     ('Which of the following activities is NOT a highlight of the Patubas Festival in Barotac Viejo?', 'Street Dancing and Float Parade', 'Agro-Industrial Fair', 'Musical Band Competition', 'Cultural Performance', 3);
     ```

5. **Update Database Connection**:
   - Open the [`db_connection.php`](db_connection.php ) file in your project.
   - Ensure the database connection details are correct:
     ```php
     <?php
     $servername = "localhost";
     $username = "root";
     $password = "";
     $dbname = "hugyaw";

     // Create connection
     $conn = new mysqli($servername, $username, $password, $dbname);

     // Check connection
     if ($conn->connect_error) {
         die("Connection failed: " . $conn->connect_error);
     }
     ?>
     ```

6. **Run the Project**:
   - Place the project folder in the `htdocs` directory of your XAMPP installation (usually located at `C:\xampp\htdocs` on Windows).
   - Open your browser and go to `http://localhost/Hugyaw` to view the project.

## Usage

- **Submit Feedback**: Navigate to the feedback page, select a municipality, and submit your feedback.
- **View Feedback**: View feedback submitted by others on the festival page.
- **Participate in Quiz**: Navigate to the quiz page and answer the quiz questions.
- **Admin Dashboard**: Administrators can log in to the admin dashboard to manage quiz questions, feedback, users, and scores.