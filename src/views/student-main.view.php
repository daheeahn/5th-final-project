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

    <p><a href="logout.php">Logout</a></p>
</body>
</html>