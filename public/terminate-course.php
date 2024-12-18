<?php
session_start(); // Start the session

// Database connection
// $conn = new mysqli('localhost', 'tamwood', '1234', 'lecture_platform_db');

require_once('../src/database/DataBaseConnection.php');
$conn = DatabaseConnection::getInstance();

// Check connection
// if ($conn->connect_error) {
//     die("Connection failed: " . $conn->connect_error);
// }

// Get student_course_id from POST request
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['course_id'])) {
    $course_id = $_POST['course_id'];

    // Prepare the unregister query
    $stmt = $conn->prepare("DELETE FROM courses WHERE id = ?");
    $stmt->bindValue(1, $course_id);

    // Execute the query
    if ($stmt->execute()) {
        echo "Course termination successfully.";
        file_put_contents('terminate-course.log', "Course [id='$course_id'] removed on " . date('Y-m-d H:i:s') . "\n", FILE_APPEND);
    } else {
        echo "Error: " . $stmt->errorInfo()[2];
        file_put_contents('terminate-course.log', "Failed to terminate course [id='$course_id'] on " . date('Y-m-d H:i:s') . "\n", FILE_APPEND);
    }

    // Close the statement
    $stmt->closeCursor();
} else {
    echo "Invalid request.";
}

// Close the database connection
// $conn->close();

// Redirect or move to another page
header("Location: teacher-main.php");
exit();
?>