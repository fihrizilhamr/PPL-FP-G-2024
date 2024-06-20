<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pm_datetime = $_POST['pm_datetime'];
    $pm_totalprice = $_POST['pm_totlaprice'];

    $sql = "INSERT INTO payment (pm_datetime, pm_totlaprice) VALUES ('$pm_datetime', '$pm_totalprice')";

    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
