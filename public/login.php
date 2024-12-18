<?php

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $email = $_POST['email'];
  $password = $_POST['password'];
  $role = $_POST['role'];

  try {
      require_once('../src/database/DataBaseConnection.php');
      $pdo = DatabaseConnection::getInstance();
      
      // find user by email and role
      $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ? AND role = ?");
      $stmt->execute([$email, $role]);
      $user = $stmt->fetch();

      $hashed_password = password_hash($password, PASSWORD_DEFAULT);
      if ($user && password_verify($password, $hashed_password)) {
          // success login
          $_SESSION['user_id'] = $user['id'];
          $_SESSION['email'] = $user['email'];
          $_SESSION['role'] = $user['role'];

          // redirect to main page by role
          if ($role === 'student') {
              header("Location: student-main.php");
          } else {
              header("Location: teacher-main.php");
          }
          exit();
      } else {
          $error_message = "Invalid email, password, or role";
          echo $error_message;
      }
  } catch(PDOException $e) {
      $error_message = "Login failed: " . $e->getMessage();
      echo $error_message;
    }
}

require_once('../src/views/login.view.php');

?>