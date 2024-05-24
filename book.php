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
            <li>
                <a href="admin_home.php">
                    <i class="bx bx-grid-alt"></i>
                    <span class="link_name">Dashboard</span>
                </a>
            </li>
            <li class="active">
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
                <div  class="logout-icon">
                <a href="logout.php"  id="log_out">
                    <i class="bx bx-log-out"  id="log_out"></i></a>
                </div>
            </li>
        </ul>
    </div>

    <!-- Main content -->
    <section class="home-section">
        <div class="dashboard-container">
            <div class="text bx bx-home">&nbsp;Home <div class=' bx bx-chevron-right'></div> Booked</div>
        </div>
        <div class="content-container">
            <div class="dashboard-name">
                <h3>Booked</h3>
            </div>
            <div class="table-responsive">
                <table class="table table-striped">
                    <colgroup>
                        <col style="width: 11%;">
                        <col style="width: 11%;">
                        <col style="width: 11%;">
                        <col style="width: 12%;">
                        <col style="width: 11%;">
                        <col style="width: 11%;">
                        <col style="width: 11%;">
                        <col style="width: 11%;">
                        <col style="width: 11%;">
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
                            <th scope="col" class="text-center">Actions</th>
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

                        // Loop through each booking
                        foreach ($xml->user as $user) {
                            foreach ($user->booking as $booking) {
                                // Check if the status is not "Accept" or "Reject"
                                if ($booking->status != "Accept" && $booking->status != "Reject") {
                                    $anyVisibleBookings = true;
                                    echo "<tr>";
                                    echo "<td class='text-center'>{$booking->clientName}</td>";
                                    echo "<td class='text-center'>{$booking->packageName}</td>";
                                    echo "<td class='text-center'>{$booking->eventDate}</td>";
                                    echo "<td class='text-center'>{$booking->startTime} to {$booking->endTime}</td>";
                                    echo "<td class='text-center'>{$booking->motif}</td>";
                                    echo "<td class='text-center'>{$booking->venue}</td>";
                                    echo "<td class='text-center'>{$booking->address}</td>";
                                    echo "<td class='text-center'>{$booking->phoneNumber}</td>";
                                    echo "<td class='text-center'>";
                                    echo "<button type='button' class='btn btn-primary btn-sm' data-toggle='modal' data-target='#acceptModal{$booking->id}'>Accept</button>&nbsp;";
                                    echo "<button type='button' class='btn btn-danger btn-sm' style='margin-top: 10px; padding-left: 12px; padding-right: 12px; margin-left: 4px; margin-right: 4px;' data-toggle='modal' data-target='#rejectModal{$booking->id}'>Reject</button>";
                                    echo "</td>";
                                    echo "</tr>";
                                }
                            }
                        }
                        ?>

                        <?php if (!$anyVisibleBookings): ?>
                            <tr>
                                <td colspan="9" class="text-center">No bookings</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <!-- Accept Modal -->
    <?php foreach ($xml->user as $user): ?>
        <?php foreach ($user->booking as $booking): ?>
            <?php if ($booking->status != "Accept" && $booking->status != "Reject"): ?>
                <div class="modal fade" id="acceptModal<?= $booking->id ?>" tabindex="-1" role="dialog" aria-labelledby="acceptModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="acceptModalLabel">Accept Booking</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p>Are you sure you want to accept booking?</p>
                                <form action="update_accept.php" method="post">
                                    <input type="hidden" name="email" value="<?= $user->email ?>">
                                    <input type="hidden" name="booking_id" value="<?= $booking->id ?>">
                                    <div class="form-group">
                                        <input type="hidden" id="status" name="status" value="Accept">
                                    </div>
                                    <button type="submit" class="btn btn-primary">Yes</button>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    <?php endforeach; ?>

    <!-- Reject Modal -->
    <?php foreach ($xml->user as $user): ?>
        <?php foreach ($user->booking as $booking): ?>
            <?php if ($booking->status != "Accept" && $booking->status != "Reject"): ?>
                <div class="modal fade" id="rejectModal<?= $booking->id ?>" tabindex="-1" role="dialog" aria-labelledby="rejectModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="rejectModalLabel">Reject Booking</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="update_reject.php" method="post">
                                    <input type="hidden" name="email" value="<?= $user->email ?>">
                                    <input type="hidden" name="booking_id" value="<?= $booking->id ?>">
                                    <div class="form-group">
                                        <input type="hidden" id="status" name="status" value="Reject">
                                    </div>
                                    <div class="form-group">
                                        <label for="remarks">Reason for rejection:</label>
                                        <textarea class="form-control" id="remarks" name="remarks" rows="3" required></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Reject</button>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    <?php endforeach; ?>

    <!-- Bootstrap JavaScript and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
