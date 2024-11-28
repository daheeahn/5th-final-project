<?php
require_once __DIR__ . '/../config/database.php';

// create courses table
function createCoursesTable() {
  global $pdo;
  try {
      $sql = "CREATE TABLE IF NOT EXISTS courses (
          id INT PRIMARY KEY AUTO_INCREMENT,
          title VARCHAR(255) NOT NULL,
          instructor VARCHAR(100) NOT NULL,
          created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
      )";
      $pdo->exec($sql);
      return true;
  } catch(PDOException $e) {
      return false;
  }
}

// execute create courses table
createCoursesTable();

?>