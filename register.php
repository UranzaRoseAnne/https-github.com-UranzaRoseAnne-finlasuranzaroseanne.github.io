<?php
// Function to check if an email already exists
function emailExists($email) {
    $xml = simplexml_load_file('data.xml');
    foreach ($xml->user as $user) {
        if ($user->email == $email) {
            return true;
        }
    }
    return false;
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $role = $_POST['role'];

    // Check if username already exists
    if (emailExists($email)) {
        echo "<script>alert('Email already exists!'); window.location.href='signup.php';</script>";
    } else {
        // Load XML file
        $xml = simplexml_load_file('data.xml');
        
        // Create new user node
        $newUser = $xml->addChild('user');
        $newUser->addChild('username', $username);
        $newUser->addChild('password', $password);
        $newUser->addChild('email', $email);
        $newUser->addChild('role', $role);

        // Save XML file
        $xml->asXML('data.xml');

        // Redirect to user home page
        header("Location: login.php");
        exit();
    }
}
?>
