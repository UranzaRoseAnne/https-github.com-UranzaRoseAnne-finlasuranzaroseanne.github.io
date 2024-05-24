<?php
// Check if form data is received
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['editPackageId'])) {
    // Get form data
    $editPackageId = $_POST['editPackageId'];
    $editPackageName = $_POST['editPackageName'];
    $editPackageDescription = $_POST['editPackageDescription'];

    // Load XML file
    $xml = simplexml_load_file('data.xml');

    // Find the package to edit
    foreach ($xml->package as $package) {
        if ($package->id == $editPackageId) {
            // Update package attributes
            $package->name = $editPackageName;
            $package->description = $editPackageDescription;
            // Check if a new image is uploaded
            if ($_FILES['editPackageImage']['name'] != '') {
                // File upload
                $targetDirectory = "uploads/"; // Relative path to directory where uploaded files will be saved
                $targetFileName = basename($_FILES["editPackageImage"]["name"]);
                $targetFile = $targetDirectory . $targetFileName;
                $uploadOk = 1;
                $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

                // Check if image file is a actual image or fake image
                $check = getimagesize($_FILES["editPackageImage"]["tmp_name"]);
                if ($check !== false) {
                    // File is an image
                    $uploadOk = 1;
                } else {
                    // File is not an image
                    echo "<script>alert('File is not an image.'); window.location.href='package.php';</script>";
                    $uploadOk = 0;
                }

                // Check if file already exists
                if (file_exists($targetFile)) {
                    echo "<script>alert('Sorry, file already exists.'); window.location.href='package.php';</script>";
                    $uploadOk = 0;
                }

                // Check file size
                if ($_FILES["editPackageImage"]["size"] > 500000) {
                    echo "<script>alert('Sorry, your file is too large.'); window.location.href='package.php';</script>";
                    $uploadOk = 0;
                }

                // Allow certain file formats
                if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
                    echo "<script>alert('Sorry, only JPG, JPEG, PNG & GIF files are allowed.'); window.location.href='package.php';</script>";
                    $uploadOk = 0;
                }

                // Check if $uploadOk is set to 0 by an error
                if ($uploadOk == 0) {
                    echo "<script>alert('Sorry, your file was not uploaded.'); window.location.href='package.php';</script>";
                } else {
                    // If everything is ok, try to upload file
                    if (move_uploaded_file($_FILES["editPackageImage"]["tmp_name"], $targetFile)) {
                        // File uploaded successfully, update image attribute
                        $package->image = $targetFileName;
                    } else {
                        echo "<script>alert('Sorry, there was an error uploading your file.'); window.location.href='package.php';</script>";
                    }
                }
            }
            // Save changes to XML file
            $xml->asXML('data.xml');
            echo "<script>alert('Package updated successfully.'); window.location.href='package.php';</script>";
            break; // Stop loop after updating the package
        }
    }
    // Package not found
    echo "<script>alert('Package not found.'); window.location.href='package.php';</script>";
} else {
    echo "<script>alert('Invalid request.'); window.location.href='package.php';</script>";
}
?>
