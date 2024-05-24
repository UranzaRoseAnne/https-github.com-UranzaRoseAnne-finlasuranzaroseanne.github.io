<?php
session_start(); // Start session

// Check if user is not logged in
if (!isset($_SESSION['email']) || !isset($_SESSION['password'])) {
    header("Location: login.php"); // Redirect to login page
    exit();
}

$email = $_SESSION['email'];
$password = $_SESSION['password'];


// Display user home page
// Load XML file
$xml = simplexml_load_file('data.xml');

$username = (string) $xml->user->username;


/// Load XML file
$xml = simplexml_load_file('data.xml');

// Initialize variables for counting
$totalPending = 0;
$totalApprove = 0;
$totalReject = 0;
$totalPackage = 0;

// Loop through each user
foreach ($xml->user as $user) {
    // Loop through each booking of the user
    foreach ($user->booking as $booking) {
        switch ($booking->status) {
            case "Pending":
                $totalPending++;
                break;
            case "Accept":
                $totalApprove++;
                break;
            case "Reject":
                $totalReject++;
                break;
        }
    }

    // Count the number of <id> elements within each <package> for this user
    foreach ($user->package as $package) {
        $totalPackage += count($package->id);
    }
}
?>
<?php
// Load XML file
$xml = simplexml_load_file('data.xml');

// Initialize variable for counting ids
$totalIds = 0;

// Loop through each package and count ids
foreach ($xml->package as $package) {
    // Count the number of <id> elements within each <package>
    $totalIds += count($package->id);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Home</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" type="text/css" href="style1.css">
</head>
<body>
    <nav class="navbar">
        <div class="logo-section">
            <div class="logo-details">
                <h3>SOUND & LIGHT BOOKING SYSTEM</h3>
            </div>
        </div>
    </nav>
    <!-- Sticky Sidebar -->
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

    <section class="home-section">
        <div class="dashboard-container">
            <div class="text bx bx-home">&nbsp;Home <div class='bx bx-chevron-right'></div> Dashboard</div>
        </div>
        <div class="content-container">
            <div class="dashboard-name">
                <h3>Dashboard Overview</h3>
            </div>
            <div class="dashboard-columns">
                <a href="pending.php" class="dashboard-column pending" style="background-color: #f5e836; text-decoration: none; color: inherit;">
                    <div class="icon">
                        <i class="bx bx-time-five"></i>
                    </div>
                    <div class="number"><?php echo $totalPending; ?></div>
                    <div class="name">Pending</div>
                </a>
                <a href="approve.php" class="dashboard-column approve" style="text-decoration: none; color: inherit;">
                    <div class="icon">
                        <i class="bx bx-check"></i>
                    </div>
                    <div class="number"><?php echo $totalApprove; ?></div>
                    <div class="name">Approve</div>
                </a>
                <a href="rejected.php" class="dashboard-column reject" style="text-decoration: none; color: inherit;">
                    <div class="icon">
                        <i class="bx bx-x"></i>
                    </div>
                    <div class="number"><?php echo $totalReject; ?></div>
                    <div class="name">Reject</div>
                </a>
                <a href="package.php" class="dashboard-column package" style="text-decoration: none; color: inherit;">
                    <div class="icon">
                        <i class="bx bx-package"></i>
                    </div>
                    <div class="number"><?php echo $totalIds; ?></div>
                    <div class="name">Package</div>
                </a>
            </div>
        </div>
    </section>

    <!-- Bootstrap JavaScript and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
