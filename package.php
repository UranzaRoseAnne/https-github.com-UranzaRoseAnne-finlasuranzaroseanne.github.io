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
    <title>Packages</title>
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
      <li class="active">
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
                    <col style="width: 15%;">
                    <col style="width: 20%;">
                    <col style="width: 45%;">
                    <col style="width: 20%;">
                </colgroup>
                <thead>
                    <tr>
                        <th scope="col" class="text-center">Package</th>
                        <th scope="col" class="text-center">Image</th>
                        <th scope="col" class="text-center">Description</th>
                        <th scope="col" class="text-center">Actions</th>
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
    echo "<td class='text-center'>";
    // Pass the package ID to the edit and delete modals
    echo "<button type='button' class='btn btn-primary btn-sm' data-toggle='modal' data-target='#editModal{$package->id}'>Edit</button>&nbsp;";
    echo "<button type='button' class='btn btn-danger btn-sm' data-toggle='modal' data-target='#deleteModal{$package->id}'>Delete</button>";
    echo "</td>";
    echo "</tr>";

    // Edit Modal
    echo "<div class='modal fade' id='editModal{$package->id}' tabindex='-1' role='dialog' aria-labelledby='editModalLabel{$package->id}' aria-hidden='true'>";
    echo "<div class='modal-dialog' role='document'>";
    echo "<div class='modal-content'>";
    echo "<div class='modal-header'>";
    echo "<h5 class='modal-title' id='editModalLabel{$index}'>Edit Package</h5>";
    echo "<button type='button' class='close' data-dismiss='modal' aria-label='Close'>";
    echo "<span aria-hidden='true'>&times;</span>";
    echo "</button>";
    echo "</div>";
    echo "<div class='modal-body'>";
    echo "<form action='edit_package.php' method='post' enctype='multipart/form-data'>";
    // Add a hidden input field to store the package ID
    echo "<input type='hidden' name='editPackageId' value='{$package->id}' />";
    echo "<img src='uploads/{$package->image}' alt='Current Image' style='max-width: 200px; display: block; margin-left: auto; margin-right: auto;'>";
    echo "<br>";
    echo "<br>";
    echo "<div class='form-group'>";
    echo "<label for='editPackageImage'>Package Image</label>";
    echo "<input type='file' class='form-control-file' id='editPackageImage' name='editPackageImage' accept='image/*'>";
    echo "</div>";
    echo "<div class='form-group'>";
    echo "<label for='editPackageName'>Package Name</label>";
    echo "<input type='text' class='form-control' id='editPackageName' name='editPackageName' value='{$package->name}'>";
    echo "</div>";
    echo "<div class='form-group'>";
    echo "<label for='editPackageDescription'>Package Description</label>";
    echo "<textarea class='form-control' id='editPackageDescription' name='editPackageDescription' rows='3'>{$package->description}</textarea>";
    echo "</div>";
    echo "<button type='submit' class='btn btn-primary'>Save Changes</button>";
    echo "</form>";
    echo "</div>";
    echo "</div>";
    echo "</div>";
    echo "</div>";

   // Delete Modal
echo "<div class='modal fade' id='deleteModal{$package->id}' tabindex='-1' role='dialog' aria-labelledby='deleteModalLabel{$package->id}' aria-hidden='true'>";
echo "<div class='modal-dialog' role='document'>";
echo "<div class='modal-content'>";
echo "<div class='modal-header'>";
echo "<h5 class='modal-title' id='deleteModalLabel{$index}'>Delete Package</h5>";
echo "<button type='button' class='close' data-dismiss='modal' aria-label='Close'>";
echo "<span aria-hidden='true'>&times;</span>";
echo "</button>";
echo "</div>";
echo "<div class='modal-body'>";
echo "<form>";
echo "<p>Are you sure you want to delete this package?</p>";
echo "<div class='text-start'>";
echo "<a href='delete_package.php?id={$package->id}' class='btn btn-danger mr-2'>Yes</a>";
echo "<button type='button' class='btn btn-secondary' data-dismiss='modal'>No</button>";
echo "</div>";
echo "</form>";
echo "</div>";
echo "</div>";
echo "</div>";
echo "</div>";
}
?>


                </tbody>
            </table>
        </div>
        <button type="button" class="btn btn-success mt-3" data-toggle="modal" data-target="#addPackageModal">
            <i class="bx bx-plus"></i> Add Package
        </button>
    </div>
</section>

<!-- Modal -->
<div class="modal fade" id="addPackageModal" tabindex="-1" role="dialog" aria-labelledby="addPackageModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addPackageModalLabel">Add Package</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Form for adding a new package -->
                <form action="insert_package.php" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="packageImage">Package Image</label>
        <input type="file" class="form-control-file" id="packageImage" name="packageImage" accept="image/*">
        <small id="packageImageHelp" class="form-text text-muted">Please upload an image file (jpg, png, or gif).</small>
    </div>
    <div class="form-group">
        <label for="packageName">Package Name</label>
        <input type="text" class="form-control" id="packageName" name="packageName">
    </div>
    <div class="form-group">
        <label for="packageDescription">Package Description</label>
        <textarea class="form-control" id="packageDescription" name="packageDescription" rows="3"></textarea>
    </div>
    <!-- Move the button inside the form -->
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</form>
            </div>
        </div>
    </div>
</div>
    <!-- Bootstrap JavaScript and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
