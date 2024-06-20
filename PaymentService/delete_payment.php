<?php
include 'db.php';

$pm_id = $_GET['pm_id'];

$sql = "DELETE FROM payment WHERE pm_id=$pm_id";

if ($conn->query($sql) === TRUE) {
    echo "Record deleted successfully";
} else {
    echo "Error deleting record: " . $conn->error;
}

$conn->close();
?>
