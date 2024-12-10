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

### Step 1: Clone the Project from GitHub

1. **Clone the Repository**:
   - Copy the repository URL.
   - Open a terminal or Git Bash on your computer.
   - Navigate to the directory where you want to clone the repository.
   - Run the following command:
     ```bash
     git clone https://github.com/markalvincadangin/Hugyaw
     ```

2. **Navigate to the Project Directory**:
   - After cloning, navigate to the project directory:
     ```sh
     cd Hugyaw
     ```

### Step 2: Set Up the Database Using XAMPP

1. **Start XAMPP**:
   - Open the XAMPP Control Panel.
   - Start the Apache and MySQL services.

2. **Open phpMyAdmin**:
   - In your browser, go to `http://localhost/phpmyadmin`.

3. **Create a Database**:
   - Click on the "New" button in the left sidebar.
   - Enter a name for your database (`hugyaw`) and click "Create".

4. **Create the Tables**:
   - Click on the newly created database.
   - Click on the "SQL" tab to open the SQL query editor.
   - Paste the following SQL statements to create the necessary tables:
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

   - Click "Go" to execute the queries.

### Step 3: Configure the Project

1. **Update Database Connection**:
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

### Run the Project

1. **Place the project folder in the `htdocs` directory of your XAMPP installation (usually located at `C:\xampp\htdocs` on Windows).**

2. **Open your browser and go to `http://localhost/Hugyaw` to view the project.**

## Usage

1. **Submit Feedback:**
   - Select a municipality from the dropdown.
   - Enter your feedback in the textarea.
   - Click "Submit Feedback" to submit your feedback.

2. **View Feedback:**
   - Select a municipality from the dropdown in the "View Feedback" section.
   - Click "View Feedback" to see the feedback submitted for the selected municipality.

3. **Admin Dashboard:**
   - Log in as an admin to access the admin dashboard.
   - Manage quiz questions, feedback, users, and scores.

### Admin Credentials

- **Username:** admin
- **Password:** admin123

## Contributing

We welcome contributions to the Hugyaw project! To contribute, follow these steps:

1. **Fork the Repository**:
   - Click the "Fork" button at the top right of the repository page on GitHub.

2. **Clone Your Fork**:
   - Clone your forked repository to your local machine:
     ```bash
     git clone https://github.com/your-username/Hugyaw
     ```

3. **Create a Branch**:
   - Create a new branch for your feature or bug fix:
     ```bash
     git checkout -b feature-or-bugfix-name
     ```

4. **Make Your Changes**:
   - Make your changes to the codebase.

5. **Commit Your Changes**:
   - Commit your changes with a descriptive commit message:
     ```bash
     git commit -m "Description of the changes"
     ```

6. **Push to Your Fork**:
   - Push your changes to your forked repository:
     ```bash
     git push origin feature-or-bugfix-name
     ```

7. **Create a Pull Request**:
   - Open a pull request to the main repository with a description of your changes.

Thank you for contributing to Hugyaw!