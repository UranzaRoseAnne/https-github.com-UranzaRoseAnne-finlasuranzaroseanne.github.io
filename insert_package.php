<?php
// Check if form data is received
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES['packageImage'])) {
    // Get form data
    $packageName = $_POST['packageName'];
    $packageDescription = $_POST['packageDescription'];

    // File upload
    $targetDirectory = "uploads/"; // Relative path to directory where uploaded files will be saved
    $targetFileName = basename($_FILES["packageImage"]["name"]);
    $targetFile = $targetDirectory . $targetFileName;
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["packageImage"]["tmp_name"]);
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
    if ($_FILES["packageImage"]["size"] > 500000) {
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
        if (move_uploaded_file($_FILES["packageImage"]["tmp_name"], $targetFile)) {
            // File uploaded successfully, now add data to XML file
            $xml = simplexml_load_file('data.xml');

            // Find the last ID and increment by 1
            $lastPackage = $xml->xpath("//package[last()]");
            $lastId = isset($lastPackage[0]->id) ? intval($lastPackage[0]->id) : 0;
            $newId = $lastId + 1;

            $package = $xml->addChild('package');
            $package->addChild('id', $newId); // Add the new ID
            $package->addChild('name', $packageName);
            $package->addChild('description', $packageDescription);
            $package->addChild('image', $targetFileName); // Only store the filename
            $xml->asXML('data.xml');
            echo "<script>alert('Package added successfully.'); window.location.href='package.php';</script>";
        } else {
            echo "<script>alert('Sorry, there was an error uploading your file.'); window.location.href='package.php';</script>";
        }
    }
} else {
    echo "<script>alert('Invalid request.'); window.location.href='package.php';</script>";
}
?>
