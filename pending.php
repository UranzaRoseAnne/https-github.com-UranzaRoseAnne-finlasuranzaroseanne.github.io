<?php
session_start(); // Start session

// Check if user is not logged in
if (!isset($_SESSION['email']) || !isset($_SESSION['password'])) {
    header("Location: login.php"); // Redirect to login page
    exit();
}

$email = $_SESSION['email'];
$password = $_SESSION['password'];

// Load XML file
$xml = simplexml_load_file('data.xml');

$username = (string) $xml->user->username;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Booked</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" type="text/css" href="style1.css">
</head>
<body>
    <!-- Navigation bar -->
    <nav class="navbar">
        <div class="logo-section">
            <div class="logo-details">
                <h3>SOUND & LIGHT BOOKING SYSTEM</h3>
            </div>
        </div>
    </nav>
    
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="logo_details">
            <i class="bx bx-menu-alt-right" id="btn"></i>
        </div>
        <ul class="nav-list">
            <li class="active">
                <a href="admin_home.php">
                    <i class="bx bx-grid-alt"></i>
                    <span class="link_name">Dashboard</span>
                </a>
            </li>
            <li>
                <a href="book.php">
                    <i class="bx bx-folder"></i>
                    <span class="link_name">Booked</span>
                </a>
            </li>
            <li>
                <a href="package.php">
                    <i class="bx bx-package"></i>
                    <span class="link_name">Packages</span>
                </a>
            </li>
            <li class="profile">
                <div class="profile_details">
                    <img src="images/profile.png" alt="profile image">
                    <div class="profile_content">
                        <div class="name"><?php echo $username; ?></div>
                        <div class="designation">Admin</div>
                    </div>
                </div>
                <div class="logout-icon">
                    <a href="logout.php" id="log_out">
                        <i class="bx bx-log-out" id="log_out"></i>
                    </a>
                </div>
            </li>
        </ul>
    </div>

    <!-- Main content -->
    <section class="home-section">
        <div class="dashboard-container">
            <div class="text bx bx-home">&nbsp;Home <div class='bx bx-chevron-right'></div> Dashboard <div class='bx bx-chevron-right'></div> Pending</div>
        </div>
        <div class="content-container">
            <div class="dashboard-name">
                <h3>Pending</h3>
            </div>
            <div class="table-responsive">
                <table class="table table-striped">
                    <colgroup>
                        <col style="width: 12%;">
                        <col style="width: 12%;">
                        <col style="width: 12%;">
                        <col style="width: 14%;">
                        <col style="width: 12%;">
                        <col style="width: 12%;">
                        <col style="width: 14%;">
                        <col style="width: 12%;">
                    </colgroup>
                    <thead>
                        <tr>
                            <th scope="col" class="text-center">Client Name</th>
                            <th scope="col" class="text-center">Package</th>
                            <th scope="col" class="text-center">Event Date</th>
                            <th scope="col" class="text-center">Time</th>
                            <th scope="col" class="text-center">Occasions/Events</th>
                            <th scope="col" class="text-center">Venue</th>
                            <th scope="col" class="text-center">Address</th>
                            <th scope="col" class="text-center">Contact</th>
                        </tr>
                    </thead>
                    <!-- Table body -->
                    <tbody>
                        <!-- Loop through bookings -->
                        <?php
                        // Load XML file
                        $xml = simplexml_load_file('data.xml');

                        // Variable to track if any bookings are visible
                        $anyVisibleBookings = false;

                        // Loop through each user
                        foreach ($xml->user as $user) {
                            // Loop through each booking of the user
                            foreach ($user->booking as $booking) {
                                // Check if the status is "Pending"
                                if ($booking->status == "Pending") {
                                    $anyVisibleBookings = true;
                                    // Convert start and end times to 12-hour format
                                    $startTime = date("h:i A", strtotime($booking->startTime));
                                    $endTime = date("h:i A", strtotime($booking->endTime));
                                    echo "<tr>";
                                    echo "<td class='text-center'>{$booking->clientName}</td>";
                                    echo "<td class='text-center'>{$booking->packageName}</td>";
                                    echo "<td class='text-center'>{$booking->eventDate}</td>";
                                    echo "<td class='text-center'>{$startTime} to {$endTime}</td>";
                                    echo "<td class='text-center'>{$booking->motif}</td>";
                                    echo "<td class='text-center'>{$booking->venue}</td>";
                                    echo "<td class='text-center'>{$booking->address}</td>";
                                    echo "<td class='text-center'>{$booking->phoneNumber}</td>";
                                    echo "</tr>";
                                }
                            }
                        }
                        ?>

                        <?php if (!$anyVisibleBookings): ?>
                            <tr>
                                <td colspan="8" class="text-center">No Pending Bookings</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <!-- Bootstrap JavaScript and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap
