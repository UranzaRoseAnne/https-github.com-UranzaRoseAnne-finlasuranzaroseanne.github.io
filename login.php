<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Login</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" placeholder="Enter Email" required>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" placeholder="Enter Password" required>
            <p style="text-align: center; font-size: 15px;"><a href="forgot_password.php">Forgot Password?</a></p>
            <input type="submit" value="Login">
        </form>
        <p style="text-align: center;margin-bottom: 10px;">Don't have an account? <a href="signup.php">Sign Up</a></p>
    </div>
    <?php
    // Start session
    session_start();

    // Function to authenticate user
    function authenticate($email, $password) {
        $xml = simplexml_load_file('data.xml');
        foreach ($xml->user as $user) {
            if ($user->email == $email && $user->password == $password) {
                return $user; // Return user data if authentication successful
            }
        }
        return false; // Authentication failed
    }

    // Check if form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = $_POST['email'];
        $password = $_POST['password'];

        $user = authenticate($email, $password);

        if ($user !== false) {
            // Store email and password in session
            $_SESSION['email'] = (string)$user->email;
            $_SESSION['password'] = (string)$user->password;

            // Redirect to respective home page
            if ((string)$user->role == 'admin') {
                header("Location: admin_home.php");
                exit();
            } else {
                header("Location: user_home.php");
                exit();
            }
        } else {
            // Display alert for incorrect email or password
            $error_message = "Incorrect email or password.";
            echo "<script>alert('$error_message');</script>";
        }
    }
    ?>

</body>
</html>
