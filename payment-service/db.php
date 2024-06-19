<?php
    $servername = "localhost";
    $username = "root";
    $password = "ilham120903";
    $dbname = "payment_service";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
?>
