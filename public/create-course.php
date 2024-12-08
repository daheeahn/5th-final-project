<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_SESSION['role'] === 'teacher') {
    $title = $_POST['title'];
    $capacity = intval($_POST['capacity']);
    $instructor_id = $_SESSION['user_id'];
    $image = $_FILES['image'];


    // $pdo = new PDO("mysql:host=localhost;dbname=lecture_platform_db", "tamwood", "1234");
    // $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // // find user by email and role
    // $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ? AND role = ?");
    // $stmt->execute([$email, $role]);
    // $user = $stmt->fetch();

    // Database connection
    $conn = new mysqli('localhost', 'tamwood', '1234', 'lecture_platform_db');

    // Image upload processing
    $targetDir = "uploads/"; // Directory to upload
    $targetFile = $targetDir . basename($image["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Check if the file is an actual image
    $check = getimagesize($image["tmp_name"]);
    if ($check === false) {
        echo "The file is not an image.";
        $uploadOk = 0;
    }

    // File size limit (e.g., 5MB)
    if ($image["size"] > 5000000) {
        echo "The file is too large.";
        $uploadOk = 0;
    }

    // Check file format
    if (!in_array($imageFileType, ['jpg', 'png', 'jpeg', 'gif'])) {
        echo "Unsupported file format.";
        $uploadOk = 0;
    }

    // If upload is allowed, move the file
    if ($uploadOk === 1) {
        if (move_uploaded_file($image["tmp_name"], $targetFile)) {
            // Add course to the database
            $stmt = $conn->prepare("INSERT INTO courses (title, instructor_id, imagePath, capacity) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("sisi", $title, $instructor_id, $targetFile, $capacity);
            $stmt->execute();
            $stmt->close();
            echo "The course has been registered.";
        } else {
            echo "Fail to move file: " . print_r(error_get_last(), true);
            echo "An error occurred during file upload.";
        }
    } else {
        echo "File upload failed.";
    }

    $conn->close();
} else {
    echo "Invalid request.";
}
// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//     if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'teacher') {
//         header('Location: /login.php');
//         exit();
//     }

//     $title = $_POST['title'];
//     $teacher_id = $_SESSION['user_id'];

//     try {
//         // start transaction
//         $pdo->beginTransaction();

//         // insert course into courses table
//         $sql = "INSERT INTO courses (title, instructor) VALUES (?, ?)";
//         $stmt = $pdo->prepare($sql);
//         $stmt->execute([$title, $teacher_id]);
        
//         // get the ID of the newly created course
//         $course_id = $pdo->lastInsertId();

//         // insert teacher-course relationship into teacher_courses table
//         $sql = "INSERT INTO teacher_courses (teacher_id, course_id) VALUES (?, ?)";
//         $stmt = $pdo->prepare($sql);
//         $stmt->execute([$teacher_id, $course_id]);

//         // commit transaction
//         $pdo->commit();

//         // redirect to teacher dashboard
//         // header('Location: /views/teacher/dashboard.php?success=1');
//         exit();

//     } catch(PDOException $e) {
//         // rollback transaction
//         $pdo->rollBack();
//         echo "Failed to create course: " . $e->getMessage();
//     }
// }
?>