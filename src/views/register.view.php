<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
</head>
<body>
    <h2>Register</h2>
    <form action="" method="POST">
        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" required><br><br>
        
        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password" required><br><br>
        
        <label for="role">Role:</label><br>
        <select id="role" name="role">
            <option value="student">Student</option>
            <option value="teacher">Teacher</option>
        </select><br><br>

        <button type="submit">Register</button>

        <p><a href="login.php">Go to Login</a></p>
    </form>
</body>
</html>