<?php
session_start(); // Avvia la sessione

// Simulazione di un login
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Supponiamo che tu abbia già verificato le credenziali dell'utente
    $_SESSION['user_id'] = 1; // ID dell'utente
    $_SESSION['email'] = 'user@example.com';
    $_SESSION['role'] = 'teacher';
    header('Location: teacher-main.php'); // Reindirizza alla pagina principale
    exit();
}

// Controllo dell'accesso
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); // Reindirizza se non è loggato
    exit();
}

// Mostra informazioni utente
echo "Welcome, " . htmlspecialchars($_SESSION['email']);
?>

<a href="logout.php">Logout</a>

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

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    echo "Connected successfully to the database.";
}

// Esegui una query di test
$stmt = $pdo->query("SELECT * FROM users LIMIT 1");
if ($stmt) {
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($user) {
        echo "User found: " . htmlspecialchars($user['email']);
    } else {
        echo "No users found.";
    }
} else {
    echo "Error executing query: " . $pdo->errorInfo();
}
?> 