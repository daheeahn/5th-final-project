<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="./styles/login.css">   
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <h2 id="title">Login</h2>  
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="col-12 col-md-6 col-lg-4">
            <form action="" method="POST" class="p-4 bg-light rounded shadow">
                <div class="mb-3">
                    <label for="email" class="form-label">Email:</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                
                <div class="mb-3">
                    <label for="password" class="form-label">Password:</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                
                <div class="mb-3">
                    <label for="role" class="form-label">Role:</label>
                    <select class="form-select" id="role" name="role">
                        <option value="student">Student</option>
                        <option value="teacher">Teacher</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-warning w-100">Login</button>
                
                <p class="mt-3 text-center">Don't have an account? <a href="register.php">Register</a></p>
            </form>
        </div>
    </div>
</body>
</html>