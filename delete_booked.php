<?php
session_start(); // Start session

// Check if user is not logged in
if (!isset($_SESSION['email']) || !isset($_SESSION['password'])) {
    header("Location: login.php"); // Redirect to login page
    exit();
}

// Get the ID of the booking to delete
$id = $_REQUEST['id'];

// Load the XML file
$xml = simplexml_load_file('data.xml');

// Get the user's email from the session
$email = $_SESSION['email'];

// Initialize a flag to check if booking was found
$bookingFound = false;

// Find the user node based on the email
$userNode = $xml->xpath("//user[email='$email']")[0];

// Loop through the bookings of the user
for ($i = 0; $i < count($userNode->booking); $i++) {
    if ($userNode->booking[$i]->id == $id) {
        unset($userNode->booking[$i]);
        $bookingFound = true;
        break;
    }
}

if ($bookingFound) {
    // Save changes to the XML file
    $xml->asXML('data.xml');
    header("Location: user_home.php");
} else {
    header("Location: user_home.php?error=Booking not found.");
}
exit();
?>
