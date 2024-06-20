<?php
include 'db.php';

$sql = "SELECT pm_id, pm_datetime, pm_totlaprice FROM payment";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo 
        "ID: ". $row["pm_id"]. 
        " - Payment Date: ". $row["pm_datetime"]. 
        " - Amount: ". $row["pm_totlaprice"]. 
        " - <a href='delete_payment.php?pm_id=". $row["pm_id"]. "'>Delete</a> 
        | <a href='update_payment.php?pm_id=". $row["pm_id"]. "'>Update</a><br>";
    }
} else {
    echo "0 results";
}
$conn->close();
?>