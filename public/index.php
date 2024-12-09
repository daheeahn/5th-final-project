
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

require_once('../src/views/database/create_table.php');

// Check if logged in
if (!isset($_SESSION['email'])) {
    // If not logged in, redirect to login.php
    header('Location: login.php');
    exit();
}

// Main Page for logged in user

if ($_SESSION['role'] = 'student') {
    require_once('../src/views/student-main.view.php');
} else if ($_SESSION['role'] = 'teacher') {
    require_once('../src/views/teacher-main.view.php');
}

?>