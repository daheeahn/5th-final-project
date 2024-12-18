<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user_id'])) {
    $course_id = $_POST['course_id'];
    $student_id = $_SESSION['user_id'];

    // Database connection
    $conn = new mysqli('localhost', 'tamwood', '1234', 'lecture_platform_db');

    // Course registration processing
    $stmt = $conn->prepare("INSERT INTO student_courses (student_id, course_id) VALUES (?, ?)");
    $stmt->bind_param("ii", $student_id, $course_id);

    if ($stmt->execute()) {
        echo "The course has been successfully registered.";
        file_put_contents('register-course.log', "Registered course [student_id='$student_id', course_id='$course_id'] on " . date('Y-m-d H:i:s') . "\n", FILE_APPEND);
        header("Location: student-main.php");
    } else {
        echo "Failed to register the course: " . $stmt->error;
        file_put_contents('register-course.log', "Failed to register course [student_id='$student_id', course_id='$course_id'] on " . date('Y-m-d H:i:s') . "\n", FILE_APPEND);
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request.";
}
?>