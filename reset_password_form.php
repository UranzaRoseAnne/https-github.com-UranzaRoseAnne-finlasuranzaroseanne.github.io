<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Reset Password</h2>
        <form action="process_reset_password.php" method="post">
            <label for="code">Reset Code:</label>
            <input type="text" id="code" name="code" placeholder="Enter reset code">
            <label for="new_password">New Password:</label>
            <input type="password" id="new_password" name="new_password" placeholder="Enter new password">
            <input type="submit" value="Reset Password">
        </form>
    </div>
</body>
</html>
