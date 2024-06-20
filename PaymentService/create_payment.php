<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the form fields are set and not empty
    if (isset($_POST['payment_date']) && isset($_POST['amount']) && !empty($_POST['payment_date']) && !empty($_POST['amount'])) {
        // Get the values from the form
        $pm_datetime = $_POST['payment_date'];
        $pm_totalprice = $_POST['amount'];

        // Prepare the SQL statement to prevent SQL injection
        $stmt = $conn->prepare("INSERT INTO payment (pm_datetime, pm_totlaprice) VALUES (?, ?)");
        $stmt->bind_param("sd", $pm_datetime, $pm_totalprice);

        // Execute the statement and check for errors
        if ($stmt->execute()) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $stmt->error;
        }

        // Close the statement and connection
        $stmt->close();
        $conn->close();
    } else {
        echo "Please fill in all fields.";
    }
}
?>
