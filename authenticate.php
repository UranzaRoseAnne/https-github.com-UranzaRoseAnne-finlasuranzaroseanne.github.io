<?php
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
        // Start session
        session_start();

        // Store email and role (you can add a role attribute in the XML)
        $_SESSION['email'] = $user->email;
        // For demonstration, let's assume admin email is "admin@example.com"
        $_SESSION['role'] = ($user->email == 'admin@example.com') ? 'admin' : 'user';

        // Redirect to respective home page
        if ($_SESSION['role'] == 'admin') {
            header("Location: admin_home.php");
            exit();
        } else {
            header("Location: user_home.php");
            exit();
        }
    } else {
        // Redirect back to login page with error message
        header("Location: login.php?error=1");
        exit();
    }
}
?>
