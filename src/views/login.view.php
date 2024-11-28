<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>
    <form action="login.php" method="POST">
        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" required><br><br>
        
        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password" required><br><br>
        
        <button type="submit">Login</button>
    </form>
    
    <p><a href="student-main.php">Go to Student Main</a></p>
    <p><a href="teacher-main.php">Go to Teacher Main</a></p>
    <p>Don't have an account? <a href="register.php">Register</a></p>
</body>
</html>