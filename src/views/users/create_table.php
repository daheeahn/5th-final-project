<?php
require_once __DIR__ . '/../config/database.php';

function createUsersTable() {
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

        // create student-course connection table 
        $sql = "CREATE TABLE IF NOT EXISTS student_courses (
            student_id INT,
            course_id INT,
            enrollment_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (student_id, course_id),
            FOREIGN KEY (student_id) REFERENCES users(id) ON DELETE CASCADE,
            FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE
        )";
        $pdo->exec($sql);

        // create teacher-course connection table   
        $sql = "CREATE TABLE IF NOT EXISTS teacher_courses (
            teacher_id INT,
            course_id INT,
            registration_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (teacher_id, course_id),
            FOREIGN KEY (teacher_id) REFERENCES users(id) ON DELETE CASCADE,
            FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE
        )";
        $pdo->exec($sql);

        return true;
    } catch(PDOException $e) {
        echo "Table creation failed: " . $e->getMessage();
        return false;
    }
}

// execute create users table
createUsersTable();
?> 