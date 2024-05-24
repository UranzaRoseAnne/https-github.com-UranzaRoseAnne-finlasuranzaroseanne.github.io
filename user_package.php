
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

// Find the user node based on the email
$userNode = $xml->xpath("//user[email='$email']");

// Get the username
$username = (string)$userNode[0]->username;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Package</title>
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
      <li>
      <a href="user_home.php">
          <i class="bx bx-folder"></i>
          <span class="link_name">Booked</span>
        </a>
      </li>
      <li>
      <li class="active">
        <a href="user_package.php">
        <i class="bx bx-package"></i>
          <span class="link_name">Packages</span>
        </a>
      </li>
      <li class="profile">
        <div class="profile_details">
          <img src="images/profile.png" alt="profile image">
          <div class="profile_content">
          <div class="name"><?php echo $username; ?></div>
            <div class="designation">User</div>
          </div>
        </div>
        <div  class="logout-icon">
            <a href="logout.php"  id="log_out">
            <i class="bx bx-log-out"  id="log_out"></i></a>
        </div>
      </li>
    </ul>
  </div>
  <section class="home-section">
    <div class="dashboard-container">
        <div class="text bx bx-home">&nbsp;Home <div class=' bx bx-chevron-right'></div> Packages</div>
    </div>
    <div class="content-container">
        <div class="dashboard-name">
            <h3>Packages</h3>
        </div>
        <div class="table-responsive">
            <table class="table table-striped">
                <colgroup>
                    <col style="width: 20%;">
                    <col style="width: 20%;">
                    <col style="width: 40%;">
                </colgroup>
                <thead>
                    <tr>
                        <th scope="col" class="text-center">Package</th>
                        <th scope="col" class="text-center">Image</th>
                        <th scope="col" class="text-center">Description</th>
                    </tr>
                </thead>
                <tbody>
                <?php
// Load XML file
$xml = simplexml_load_file('data.xml');

// Loop through each package
foreach ($xml->package as $index => $package) {
    echo "<tr>";
    echo "<td>{$package->name}</td>";
    // Assuming 'uploads' is the directory where images are stored
    echo "<td  class='text-center'><img src='uploads/{$package->image}' alt='{$package->name}' style='width: 100px; height: 100px;'></td>";
    echo "<td>{$package->description}</td>";
    echo "</tr>";
}
?>

                </tbody>
            </table>
        </div>
</section>
        </div>
    </div>
</div>
    <!-- Bootstrap JavaScript and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
