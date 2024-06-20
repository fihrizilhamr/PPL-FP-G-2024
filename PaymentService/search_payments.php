<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $keyword = $_POST['keyword'];

    $sql = "SELECT * FROM payment WHERE pm_id LIKE '%$keyword%' OR pm_totlaprice LIKE '%$keyword%' OR pm_datetime LIKE '%$keyword%'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "ID: " . $row["pm_id"]. " - Amount: " . $row["pm_totlaprice"]. " - Payment Date: " . $row["pm_datetime"]. "<br>";
        }
    } else {
        echo "0 results";
    }

    $conn->close();
}
?>
