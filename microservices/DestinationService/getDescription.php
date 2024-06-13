<?php
// getDescription.php
include 'Destination.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
  
    $destinationService = new DestinationService(); 

    $destination = $destinationService->getDestinationById($id);

    if (!empty($$destination)) {
        echo "<h1>Search Results</h1><ul>";
        echo "{$destination['description']}";

    } else {
        echo "No destination found.";
    }
}
?>