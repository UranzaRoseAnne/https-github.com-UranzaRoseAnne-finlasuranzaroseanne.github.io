<?php
session_start();

// Load PHPMailer
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php';

// Function to send email
function sendStatusUpdateEmail($email, $clientName, $packageName, $eventDate, $remarks, $status) {
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
    $mail->Subject = 'Booking Status Updated';

    $body = "Dear $clientName,\n\n";
    if ($status === 'Reject') {
        $body .= "We regret to inform you that your booking request for the package: $packageName on $eventDate has been rejected.\n";
        $body .= "Reason: $remarks\n\n";
    }
    $body .= "Best regards,\nRRC";

    $mail->Body = $body;

    if (!$mail->send()) {
        return false; // Error sending email
    } else {
        return true; // Email sent successfully
    }
}

// Check if form data is received
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Load XML file
    $xml = simplexml_load_file('data.xml');

    // Assume $loggedInEmail contains the email submitted via the form
    $loggedInEmail = $_POST['email'];
    $bookingId = $_POST['booking_id'];
    $remarks = $_POST['remarks'];

    // Find the user with the given email
    foreach ($xml->user as $user) {
        // Check if the email matches the logged-in user's email
        if ($user->email == $loggedInEmail) {
            // Iterate through the bookings of this user
            foreach ($user->booking as $booking) {
                if ($booking->id == $bookingId) {
                    // Update the status of the booking and rejection reason
                    $booking->status = "Reject";
                    $booking->remarks = $remarks;

                    // Send email notification about the status update
                    $clientName = (string) $booking->clientName;
                    $packageName = (string) $booking->packageName;
                    $eventDate = (string) $booking->eventDate;

                    if (!sendStatusUpdateEmail($loggedInEmail, $clientName, $packageName, $eventDate, $remarks, "Reject")) {
                        echo "<script>alert('Failed to send email notification!');</script>";
                    }
                    
                    break; // Exit the loop once the booking is found and updated
                }
            }
            // No need to continue searching once the user is found
            break;
        }
    }

    // Save the updated XML back to the file
    $xml->asXML('data.xml');

    // Redirect back to the booking page
    header('Location: book.php');
    exit();
} else {
    // If the request method is not POST, redirect to the appropriate page
    header("Location: book.php");
    exit();
}
?>
