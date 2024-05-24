<?php 
$id = $_REQUEST['id'];

$packages = simplexml_load_file("data.xml");

// Check if XML file is loaded successfully
if ($packages) {
    // Create an iterator
    $index = 0;

    // Loop through each package
    foreach($packages->package as $package) {
        // Remove if the ID matches
        if ($package->id == $id) {
            unset($packages->package[$index]);
            // Save changes to XML file
            file_put_contents('data.xml', $packages->asXML());
            header("Location: package.php");
            exit(); // Exit the script after redirection
        }
        $index++;
    }
    // If the loop completes without finding the package, redirect with an error message
    header("Location: package.php?error=Package not found.");
} else {
    // If the XML file fails to load, redirect with an error message
    header("Location: package.php?error=Failed to load XML file.");
}
?>
