<?php
session_start();

// Load PHPMailer
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php';

// Function to send email
function sendStatusUpdateEmail($email, $clientName, $packageName, $eventDate, $status) {
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
    if ($status === 'Pending') {
        $body .= "Thank you for booking again! Your booking request for the package: $packageName on $eventDate is currently pending.\n\n";
    }
    $body .= "Best regards,\nRRC";

    $mail->Body = $body;

    if (!$mail->send()) {
        return false; // Error sending email
    } else {
        return true; // Email sent successfully
    }
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $editBookingId = $_POST['editBookingId'];
    $editClientName = $_POST['editClientName'];
    $selectedPackage = $_POST['set'];
    $eventDate = $_POST['eventDate'];
    $startTime = $_POST['startTime'];
    $endTime = $_POST['endTime'];
    $motif = $_POST['motif'];
    $venue = $_POST['venue'];
    $address = $_POST['address'];
    $phoneNumber = $_POST['phoneNumber'];
    $status = $_POST['status'];
    $remarks = $_POST['remarks'];

    // Assume $loggedInEmail contains the email submitted via the form
    $loggedInEmail = $_POST['email'];

    // Load XML file
    $xml = simplexml_load_file('data.xml');

    // Find the user with the given email
    foreach ($xml->user as $user) {
        // Check if the email matches the logged-in user's email
        if ($user->email == $loggedInEmail) {
            // Iterate through the user's bookings
            foreach ($user->booking as $booking) {
                if ($booking->id == $editBookingId) {
                    // Update booking details
                    $booking->clientName = $editClientName;
                    $booking->packageName = $selectedPackage;
                    $booking->eventDate = $eventDate;
                    $booking->startTime = $startTime;
                    $booking->endTime = $endTime;
                    $booking->motif = $motif;
                    $booking->venue = $venue;
                    $booking->address = $address;
                    $booking->phoneNumber = $phoneNumber;
                    $booking->status = $status;
                    $booking->remarks = $remarks;

                    // Send email notification if the status is Pending
                    if ($status === 'Pending') {
                        if (!sendStatusUpdateEmail($loggedInEmail, $editClientName, $selectedPackage, $eventDate, $status)) {
                            echo "<script>alert('Failed to send email notification!');</script>";
                        }
                    }

                    break 2; // Exit both loops once the booking is found and updated
                }
            }
        }
    }

    // Save the changes back to the XML file
    $xml->asXML('data.xml');

    // Redirect back to the page where the form was submitted from
    header("Location: ".$_SERVER['HTTP_REFERER']);
    exit();
}
?>
