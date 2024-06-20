<?php
include 'db.php';

if (isset($_GET['pm_id']) && !empty($_GET['pm_id'])) {
    // Sanitize the pm_id parameter
    $pm_id = intval($_GET['pm_id']);

    // Prepare the SQL statement to prevent SQL injection
    $stmt = $conn->prepare("DELETE FROM payment WHERE pm_id = ?");
    $stmt->bind_param("i", $pm_id);

    // Execute the statement and check for errors
    if ($stmt->execute()) {
        echo "Record deleted successfully";
    } else {
        echo "Error deleting record: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request: pm_id parameter is missing or empty.";
}
?>
