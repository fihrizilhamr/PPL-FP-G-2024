<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $payer_name = $_POST['payer_name'];
    $amount = $_POST['amount'];
    $payment_date = $_POST['payment_date'];

    $sql = "INSERT INTO payments (payer_name, amount, payment_date) VALUES ('$payer_name', '$amount', '$payment_date')";

    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>

<form method="post" action="create_payment.php">
    Name: <input type="text" name="payer_name"><br>
    Amount: <input type="text" name="amount"><br>
    Payment Date: <input type="date" name="payment_date"><br>
    <input type="submit" value="Submit">
</form>