<?php
  $host = 'localhost';      // database host  
  $dbname = 'lecture_platform_db';    // database name
  $username = 'tamwood';       // MySQL user name
  $password = '1234';           // MySQL password (default is empty)

  try {
    // prepare database if not exists
    $pdo = new PDO("mysql:host=$host", $username, $password);
    $pdo->exec("CREATE DATABASE IF NOT EXISTS $dbname");
    
    // select database
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit;
}
?>