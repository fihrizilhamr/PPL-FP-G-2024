<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pm_id = $_POST['pm_id'];
    $pm_totalprice = $_POST['pm_totlaprice'];
    $pm_datetime = $_POST['pm_datetime'];

    $sql = "UPDATE payment SET pm_totlaprice='$pm_totalprice', pm_datetime='$pm_datetime' WHERE pm_id='$pm_id'";

    if ($conn->query($sql) === TRUE) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $conn->error;
    }

    $conn->close();
} else {
    $pm_id = $_GET['pm_id'];
    $sql = "SELECT * FROM payment WHERE pm_id=$pm_id";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    ?>

    <form method="post" action="update_payment.php">
        <input type="hidden" name="id" value="<?php echo $row['pm_id']; ?>">
        Amount: <input type="text" name="amount" value="<?php echo $row['pm_totlaprice']; ?>"><br>
        Payment Date: <input type="date" name="payment_date" value="<?php echo $row['pm_datetime']; ?>"><br>
        <input type="submit" value="Submit">
    </form>

    <?php
}
?>
