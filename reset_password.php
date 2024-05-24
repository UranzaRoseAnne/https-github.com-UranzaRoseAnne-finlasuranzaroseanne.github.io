<?php
session_start();

// Function to generate random 4-digit code
function generateCode() {
    return sprintf('%04d', rand(0, 9999));
}

// Function to update password and store reset code in XML file
function updatePasswordAndCode($email, $newPassword, $resetCode) {
    $xml = simplexml_load_file('data.xml');
    if ($xml === false) {
        return false; // Failed to load XML file
    }

    foreach ($xml->user as $user) {
        if ((string)$user->email == $email) {
            // Check if reset_code tag exists, if not, add it
            if (!isset($user->reset_code)) {
                $user->addChild('reset_code');
            }
            $user->password = $newPassword;
            $user->reset_code = $resetCode; // Add the reset code
            if ($xml->asXML('data.xml') !== false) {
                return true; // Update successful
            } else {
                return false; // Failed to save XML changes
            }
        }
    }
    return false; // Email not found
}

// Function to send email using PHPMailer
function sendEmail($email, $resetCode) {
    require 'PHPMailer/src/PHPMailer.php';
    require 'PHPMailer/src/SMTP.php';
    require 'PHPMailer/src/Exception.php';
    
    $mail = new PHPMailer\PHPMailer\PHPMailer();
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com'; // SMTP server address
    $mail->SMTPAuth = true;
    $mail->Username = 'reynanyap25@gmail.com'; // SMTP username
    $mail->Password = 'tfeayxjmcqyeojva'; // SMTP password
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;
    $mail->setFrom('reynanyap25@gmail.com', 'RRC');
    $mail->addAddress($email);
    $mail->Subject = 'Password Reset Code';
    $mail->Body = 'Your password reset code is: ' . $resetCode;
    
    if (!$mail->send()) {
        return false; // Error sending email
    } else {
        return true; // Email sent successfully
    }
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];

    // Load XML file
    $xml = simplexml_load_file('data.xml');
    if ($xml === false) {
        die('Failed to load XML file.'); // Exit if XML file loading fails
    }

    $emailFound = false;
    foreach ($xml->user as $user) {
        if ((string)$user->email == $email) {
            $emailFound = true;

            // Generate random 4-digit code
            $resetCode = generateCode();

            // Update XML with reset code
            if (updatePasswordAndCode((string)$user->email, (string)$user->password, $resetCode)) {
                // Send email with reset code
                if (sendEmail($email, $resetCode)) {
                    // Store reset code in session for verification
                    $_SESSION['reset_code'] = $resetCode;
                    $_SESSION['reset_email'] = (string)$user->email;
                    
                    // Redirect to reset password form
                    header("Location: reset_password_form.php");
                    exit();
                } else {
                    echo "Failed to send email!";
                }
            } else {
                echo "Failed to update reset code!";
            }
            break; // Stop loop once email is found
        }
    }

    if (!$emailFound) {
        echo "<script>alert('Email not found!'); window.location.href='forgot_password.php';</script>";
    }
}
?>
