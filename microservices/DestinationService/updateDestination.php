<?php
// getPicture.php
include 'Destination.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $picture = $_POST['picture'];
    $description = $_POST['description'];
    $address = $_POST['address'];
    

    $destinationService = new DestinationService(); 
 

    $destination = $destinationService->createDestination($id, $name, $description, $picture, $address);

    $result = $destinationService->updateDestination($destination);

    if (!empty($$destination)) {
        echo "<h1>Update Results</h1>";
        echo "{$result}";

    } else {
        echo "No destination found.";
    }
}
?>