<?php
session_start(); // Start the session

// Database connection
$conn = new mysqli('localhost', 'tamwood', '1234', 'lecture_platform_db');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get student_course_id from POST request
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['course_id'])) {
    $course_id = $_POST['course_id'];

    // Prepare the unregister query
    $stmt = $conn->prepare("DELETE FROM courses WHERE id = ?");
    $stmt->bind_param("i", $course_id); // Bind student_course_id as an integer

    // Execute the query
    if ($stmt->execute()) {
        echo "Course termination successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
} else {
    echo "Invalid request.";
}

// Close the database connection
$conn->close();

// Redirect or move to another page
header("Location: teacher-main.php");
exit();
?>