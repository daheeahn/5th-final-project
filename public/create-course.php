<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_SESSION['role'] === 'teacher') {
    $title = $_POST['title'];
    $capacity = intval($_POST['capacity']);
    $instructor_id = $_SESSION['user_id'];
    $image = $_FILES['image'];

    // Database connection
    // $conn = new mysqli('localhost', 'tamwood', '1234', 'lecture_platform_db');
    require_once('../src/database/DataBaseConnection.php');
    $conn = DatabaseConnection::getInstance();

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
            // $stmt->bind_param("sisi", $title, $instructor_id, $targetFile, $capacity);
            $stmt->bindValue(1, $title);
            $stmt->bindValue(2, $instructor_id);
            $stmt->bindValue(3, $targetFile);
            $stmt->bindValue(4, $capacity);

            if ($stmt->execute()) {
                echo "The course has been registered.";
                // HERE STORE DATA IF
                // Log the successful course creation
                file_put_contents('create-course.log', "Course '$title' created by instructor ID $instructor_id on " . date('Y-m-d H:i:s') . "\n", FILE_APPEND);
            } else {
                echo "Failed to register the course: " . $stmt->errorInfo()[2];
                // Log the error
                file_put_contents('create-course.log', "Error registering course '$title': " . $stmt->error . " on " . date('Y-m-d H:i:s') . "\n", FILE_APPEND);
            }
            $stmt->closeCursor();
            echo "The course has been registered.";
            header("Location: teacher-main.php");

            // HERE STORE DATA IF 
        } else {
            echo "Fail to move file: " . print_r(error_get_last(), true);
            echo "An error occurred during file upload.";
            // STORE DATA THAT THE ACTION HAS FAILED
            file_put_contents('create-course.log', "Failed to move uploaded file for course '$title' on " . date('Y-m-d H:i:s') . "\n", FILE_APPEND);
        }
    } else {
        echo "File upload failed.";
        // HERE
        // Provide feedback to the user about the upload failure
        $_SESSION['upload_error'] = "File upload failed due to invalid file type or size.";
        header("Location: teacher-main.php"); // Redirect back to the main page
        exit();
    }
} else {
    echo "Invalid request.";
    // HERE
    // Redirect to an error page or the main page
    header("Location: login.php"); // Redirect to login if not authorized
    exit();
}

?>