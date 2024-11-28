
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

require_once('../src/views/users/create_table.php');
require_once('../src/views/courses/create_table.php');

// Check if logged in
if (!isset($_SESSION['user'])) {
    // If not logged in, redirect to login.php
    header('Location: login.php');
    exit();
}

// Main Page for logged in user
require_once('../src/views/main.view.php');
?>