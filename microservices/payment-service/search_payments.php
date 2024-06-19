<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $keyword = $_POST['keyword'];

    $sql = "SELECT * FROM payments WHERE payer_name LIKE '%$keyword%' OR amount LIKE '%$keyword%' OR payment_date LIKE '%$keyword%'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "ID: " . $row["id"]. " - Name: " . $row["payer_name"]. " - Amount: " . $row["amount"]. " - Payment Date: " . $row["payment_date"]. "<br>";
        }
    } else {
        echo "0 results";
    }

    $conn->close();
}
?>

<form method="post" action="search_payments.php">
    Keyword: <input type="text" name="keyword"><br>
    <input type="submit" value="Search">
</form>
