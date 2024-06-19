<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $payer_name = $_POST['payer_name'];
    $amount = $_POST['amount'];
    $payment_date = $_POST['payment_date'];

    $sql = "UPDATE payments SET payer_name='$payer_name', amount='$amount', payment_date='$payment_date' WHERE id='$id'";

    if ($conn->query($sql) === TRUE) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $conn->error;
    }

    $conn->close();
} else {
    $id = $_GET['id'];
    $sql = "SELECT * FROM payments WHERE id=$id";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    ?>

    <form method="post" action="update_payment.php">
        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
        Name: <input type="text" name="payer_name" value="<?php echo $row['payer_name']; ?>"><br>
        Amount: <input type="text" name="amount" value="<?php echo $row['amount']; ?>"><br>
        Payment Date: <input type="date" name="payment_date" value="<?php echo $row['payment_date']; ?>"><br>
        <input type="submit" value="Submit">
    </form>

    <?php
}
?>
