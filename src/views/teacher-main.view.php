<?php
session_start();
// 로그인 체크 및 교사 권한 확인
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'teacher') {
    header('Location: /login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Main Page</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body class="container">

<div class="text-center mt-4 rounded border p-4 bg-success text-white mb-4">
    <h2>Teacher view</h2>

    <?php 
        echo "<p>" . htmlspecialchars($_SESSION['email']) . "</p>";
        echo "<p>" . htmlspecialchars($_SESSION['role']) . "</p>";
    ?>
</div>

<section>
    <h2>Register New Course</h2>
    <form action="create-course.php" method="POST" enctype="multipart/form-data">
        <div>
            <label for="title">Course Name:</label>
            <input type="text" id="title" name="title" required>
        </div>
        <div>
            <label for="image">Course Image:</label>
            <input type="file" id="image" name="image" accept="image/*" required>
        </div>
        <div>
            <label for="capacity">Course Capacity:</label>
            <input type="number" id="capacity" name="capacity" min="1" required>
        </div>
        <button type="submit" class="bg-success">Register Course</button>
    </form>
    </section>



    <h2>Your Courses</h2>
    <?php
    $conn = new mysqli('localhost', 'tamwood', '1234', 'lecture_platform_db');

    // Retrieve courses registered by the teacher
    $teacher_id = $_SESSION['user_id'];
    $stmt = $conn->prepare("SELECT id, title, imagePath, capacity, (SELECT COUNT(*) FROM student_courses WHERE course_id = courses.id) AS student_count FROM courses WHERE instructor_id = ?");
    $stmt->bind_param("i", $teacher_id); // Ensure to bind the parameter
    $stmt->execute();
    $registeredCoursesResult = $stmt->get_result();

    if ($registeredCoursesResult->num_rows > 0) {
        echo "<ul>";
        while ($row = $registeredCoursesResult->fetch_assoc()) {
            // echo "<li>" . htmlspecialchars($row['title']) . " - " . htmlspecialchars($row['imagePath']) . " 
            // echo "<li>" . htmlspecialchars($row['title']) . " - " . htmlspecialchars($row['imagePath']) . " - Capacity: " . htmlspecialchars($row['capacity']) . " 
            echo "<li>" . htmlspecialchars($row['title']) . " - " . htmlspecialchars($row['imagePath']) . " - Capacity: " . htmlspecialchars($row['capacity']) . " - Students Enrolled: " . htmlspecialchars($row['student_count']) . " 
            <form action='terminate-course.php' method='post' style='display:inline;'>
                <input type='hidden' name='course_id' value='" . $row['id'] . "'>
                <input type='submit' value='Remove Course'>
            </form>
            </li>";
        }
        echo "</ul>";
    } else {
        echo "You have not registered any courses.";
    }

    $conn->close();

    ?>

    <p><a href="logout.php" class="btn btn-danger">Logout</a></p>

</body>
</html>