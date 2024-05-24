<?php
session_start();

// Function to update password in XML file
function updatePassword($email, $newPassword) {
    $xml = simplexml_load_file('data.xml');
    foreach ($xml->user as $user) {
        if ($user->email == $email) {
            $user->password = $newPassword;
            $xml->asXML('data.xml');
            return true;
        }
    }
    return false;
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['code']) && isset($_POST['new_password'])) {
        $code = $_POST['code'];
        $newPassword = $_POST['new_password'];

        // Verify reset code if session variable is set
        if (isset($_SESSION['reset_code']) && $code == $_SESSION['reset_code']) {
            // Update password
            if (updatePassword($_SESSION['reset_email'], $newPassword)) {
                // Password reset successful, redirect to user home
                header("Location: user_home.php");
                exit();
            } else {
                // Error resetting password, display alert
                echo "<script>alert('Error resetting password!'); window.location.href='reset_password_form.php';</script>";
            }
            
            // Clear reset code from session
            unset($_SESSION['reset_code']);
            unset($_SESSION['reset_email']);
        } else {
            // Invalid reset code, display alert
            echo "<script>alert('Invalid reset code!'); window.location.href='reset_password_form.php';</script>";
        }
    } else {
        echo "Form fields not set!";
    }
} else {
    // Redirect if form is not submitted
    header("Location: forgot_password.php");
    exit();
}
?>
