<?php
require_once __DIR__ . '/../config/database.php';

function createTables() {

    global $pdo;
    try {
        // create users table 
        $sql = "CREATE TABLE IF NOT EXISTS users (
            id INT PRIMARY KEY AUTO_INCREMENT,
            email VARCHAR(255) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL,
            role ENUM('teacher', 'student') NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )";
        $pdo->exec($sql);

        // create courses table
        $sql = "CREATE TABLE IF NOT EXISTS courses (
            id INT PRIMARY KEY AUTO_INCREMENT,
            title VARCHAR(255) NOT NULL,
            imagePath VARCHAR(255),
            capacity INT NOT NULL,
            instructor_id INT NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (instructor_id) REFERENCES users(id) ON DELETE CASCADE
        )";
        $pdo->exec($sql);

        // create student-course connection table 
        $sql = "CREATE TABLE IF NOT EXISTS student_courses (
            id INT PRIMARY KEY AUTO_INCREMENT,
            student_id INT,
            course_id INT,
            FOREIGN KEY (student_id) REFERENCES users(id) ON DELETE CASCADE,
            FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE
        )";
        $pdo->exec($sql);

        //database to log

        return true;
    } catch(PDOException $e) {
        echo "Table creation failed: " . $e->getMessage();
        return false;
    }
}

// execute create table
createTables();
?> 