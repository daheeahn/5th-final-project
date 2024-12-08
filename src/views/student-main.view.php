<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Main Page</title>
</head>
<body>
    <h2>Student Main</h2>

    <?php 
        echo $_SESSION['email'] . "<br>";
        echo $_SESSION['role'] . "<br>";
    ?>

    <h2>Registered Course List</h2>
    <?php
    // Course list retrieval
    $conn = new mysqli('localhost', 'tamwood', '1234', 'lecture_platform_db');
    
    // Retrieve all courses
    $stmt = $conn->prepare("SELECT id, title, imagePath, capacity, (SELECT COUNT(*) FROM student_courses WHERE course_id = courses.id) AS student_count FROM courses");
    $stmt->execute();
    $registeredCoursesResult = $stmt->get_result();

    if ($registeredCoursesResult->num_rows > 0) {
        echo "<ul>";
        while ($row = $registeredCoursesResult->fetch_assoc()) {
            echo "<li>" . htmlspecialchars($row['title']) . " - " . htmlspecialchars($row['imagePath']) . " - Capacity: " . htmlspecialchars($row['capacity']) . " - Students Enrolled: " . htmlspecialchars($row['student_count']) . " 
            <form action='register-course.php' method='post' style='display:inline;'>
                <input type='hidden' name='course_id' value='" . $row['id'] . "'>
                <input type='submit' value='Register'>
            </form>
            </li>";
        }
        echo "</ul>";
    } else {
        echo "You have not registered any courses.";
    }
    ?>

    <h2>Your Registered Courses</h2>
    <?php
    // Retrieve courses registered by the user
    $student_id = $_SESSION['user_id'];
    $stmt = $conn->prepare("SELECT sc.id, c.title, c.imagePath FROM student_courses sc JOIN courses c ON sc.course_id = c.id WHERE sc.student_id = ?");
    $stmt->bind_param("i", $student_id); // Ensure to bind the parameter
    $stmt->execute();
    $registeredCoursesResult = $stmt->get_result();

    if ($registeredCoursesResult->num_rows > 0) {
        echo "<ul>";
        while ($row = $registeredCoursesResult->fetch_assoc()) {
            echo "<li>" . htmlspecialchars($row['title']) . " - " . htmlspecialchars($row['imagePath']) . " 
            <form action='unregister-course.php' method='post' style='display:inline;'>
                <input type='hidden' name='student_course_id' value='" . $row['id'] . "'>
                <input type='submit' value='Unregister'>
            </form>
            </li>";
        }
        echo "</ul>";
    } else {
        echo "You have not registered any courses.";
    }
    $conn->close();
    ?>

    <p><a href="logout.php">Logout</a></p>
</body>
</html>