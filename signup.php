<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Sign Up</h2>
        <form action="register.php" method="post">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" placeholder="Enter Username" required>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" placeholder="Enter Password" required>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" placeholder="Enter Email" required>
            <input type="hidden" id="role" name="role" value="User">
            <input type="submit" value="Sign Up">
        </form>
        <p style="text-align: center;margin-bottom: 10px;">Have an account? <a href="login.php">Login</a></p>
    </div>
</body>
</html>
