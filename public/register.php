<?php


if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $email = $_POST['email'];
  $password = $_POST['password'];
  $hashed_password = password_hash($password, PASSWORD_DEFAULT);

  $role = $_POST['role'];
  
  try {
    require_once('../src/database/DataBaseConnection.php'); // Include the DatabaseConnection class
    $pdo = DatabaseConnection::getInstance(); 
    
    $stmt = $pdo->prepare("INSERT INTO users (email, password, role) VALUES (?, ?, ?)");
    $stmt->execute([$email, $hashed_password, $role]);
    
    echo "<p style='color: green;'>Registration successful!</p>";
  } catch(PDOException $e) {
    echo "<p style='color: red;'>Registration failed: " . $e->getMessage() . "</p>";
  }
}

require_once('../src/views/register.view.php');

?>