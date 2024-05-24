<?php
session_start();

// Load PHPMailer
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php';

// Function to send email
function sendBookingEmail($email, $clientName, $packageName, $eventDate, $status) {
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
    $mail->Subject = 'Booking Request Received';
    
    $body = "Dear $clientName,\n\n";
    $body .= "Thank you for your booking request for the package: $packageName.\n";
    $body .= "Event Date: $eventDate\n";
    if ($status === 'Pending') {
        $body .= "Your booking status is currently pending. We will confirm your booking shortly.\n\n";
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
    // Get form data
    $userEmail = $_POST['email']; // Assuming you have a way to get the user's email
    $clientName = $_POST['clientName'];
    $packageName = $_POST['set'];
    $eventDate = $_POST['eventDate'];
    $startTime = $_POST['startTime'];
    $endTime = $_POST['endTime'];
    $motif = $_POST['motif'];
    $venue = $_POST['venue'];
    $address = $_POST['address'];
    $phoneNumber = $_POST['phoneNumber'];
    $status = $_POST['status'];
    $remarks = $_POST['remarks'];

    // Load XML file
    $xml = simplexml_load_file('data.xml');

    // Find the user node by email
    $userNode = $xml->xpath("//user[email='$userEmail']")[0];

    // Find the last ID in the user's bookings and increment it for the new entry
    $lastId = (int)$userNode->booking[count($userNode->booking) - 1]->id;
    $newId = $lastId + 1;

    // Add new booking entry with auto-incremented ID inside the user node
    $booking = $userNode->addChild('booking');
    $booking->addChild('id', $newId); // Add the auto-incremented ID
    $booking->addChild('clientName', $clientName);
    $booking->addChild('packageName', $packageName);
    $booking->addChild('eventDate', $eventDate);
    $booking->addChild('startTime', $startTime);
    $booking->addChild('endTime', $endTime);
    $booking->addChild('motif', $motif);
    $booking->addChild('venue', $venue);
    $booking->addChild('address', $address);
    $booking->addChild('phoneNumber', $phoneNumber);
    $booking->addChild('status', $status);
    $booking->addChild('remarks', $remarks);

    // Save XML file
    $xml->asXML('data.xml');
    
    // Send email notification if the status is pending
    if ($status === 'Pending') {
        if (!sendBookingEmail($userEmail, $clientName, $packageName, $eventDate, $status)) {
            echo "Failed to send email notification!";
        }
    }
    
    echo "<script>alert('Thank you for requesting a booking. Please wait for confirmation.'); window.location.href = 'user_home.php';</script>";
    exit();
} else {
    // If the request method is not POST, redirect to the appropriate page
    header("Location: user_home.php");
    exit();
}
?>
