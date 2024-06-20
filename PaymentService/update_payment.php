<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the necessary fields are set and not empty
    if (isset($_POST['pm_id']) && isset($_POST['pm_totlaprice']) && isset($_POST['pm_datetime']) && !empty($_POST['pm_id']) && !empty($_POST['pm_totlaprice']) && !empty($_POST['pm_datetime'])) {
        // Get the values from the form
        $pm_id = $_POST['pm_id'];
        $pm_totalprice = $_POST['pm_totlaprice'];
        $pm_datetime = $_POST['pm_datetime'];

        // Prepare the SQL statement to prevent SQL injection
        $stmt = $conn->prepare("UPDATE payment SET pm_totlaprice = ?, pm_datetime = ? WHERE pm_id = ?");
        $stmt->bind_param("dsi", $pm_totalprice, $pm_datetime, $pm_id);

        // Execute the statement and check for errors
        if ($stmt->execute()) {
            echo "Record updated successfully";
        } else {
            echo "Error updating record: " . $stmt->error;
        }

        // Close the statement and connection
        $stmt->close();
        $conn->close();
    } else {
        echo "Please fill in all fields.";
    }
} else {
    if (isset($_GET['pm_id']) && !empty($_GET['pm_id'])) {
        $pm_id = $_GET['pm_id'];

        // Prepare the SQL statement to fetch the current values
        $stmt = $conn->prepare("SELECT * FROM payment WHERE pm_id = ?");
        $stmt->bind_param("i", $pm_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        if ($row) {
            ?>

            <form method="post" action="update_payment.php">
                <input type="hidden" name="pm_id" value="<?php echo $row['pm_id']; ?>">
                Amount: <input type="text" name="pm_totlaprice" value="<?php echo $row['pm_totlaprice']; ?>"><br>
                Payment Date: <input type="datetime-local" name="pm_datetime" value="<?php echo date('Y-m-d\TH:i', strtotime($row['pm_datetime'])); ?>"><br>
                <input type="submit" value="Submit">
            </form>

            <?php
        } else {
            echo "Record not found.";
        }

        // Close the statement and connection
        $stmt->close();
        $conn->close();
    } else {
        echo "Invalid request: pm_id parameter is missing or empty.";
    }
}
?>
