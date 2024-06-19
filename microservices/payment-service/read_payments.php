<?php
include 'db.php';

$sql = "SELECT id, payer_name, amount, payment_date FROM payments";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "ID: " . $row["id"]. " - Name: " . $row["payer_name"]. " - Amount: " . $row["amount"]. " - Payment Date: " . $row["payment_date"]. "<br>";
    }
} else {
    echo "0 results";
}
$conn->close();
?>
