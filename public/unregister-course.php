<?php
session_start(); // Start the session

// Database connection
require_once('../src/database/DataBaseConnection.php');
$conn = DatabaseConnection::getInstance();

// Check connection
// if ($conn->connect_error) {
//     die("Connection failed: " . $conn->connect_error);
// }

// Get student_course_id from POST request
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['student_course_id'])) {
    $student_course_id = $_POST['student_course_id'];

    // Prepare the unregister query
    $stmt = $conn->prepare("DELETE FROM student_courses WHERE id = ?");
    // $stmt->bind_param("i", $student_course_id); // Bind student_course_id as an integer
    $stmt->bindValue(1, $student_course_id);

    // Execute the query
    if ($stmt->execute()) {
        echo "Course unregistered successfully.";
        file_put_contents('unregister-course.log', "Unregistered [student_course_id='$student_course_id'] on " . date('Y-m-d H:i:s') . "\n", FILE_APPEND);
    } else {
        echo "Error: " . $stmt->errorInfo()[2];
        file_put_contents('unregister-course.log', "Failed to unregister course [student_course_id='$student_course_id'] on " . date('Y-m-d H:i:s') . "\n", FILE_APPEND);
    }

    // Close the statement
    $stmt->closeCursor();
} else {
    echo "Invalid request.";
}

// Close the database connection
// $conn->close();

// Redirect or move to another page
header("Location: student-main.php");
exit();
?>