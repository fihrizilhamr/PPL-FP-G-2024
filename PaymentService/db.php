<?php
    $hostname = "blvf95dkmybpm8s1nymz-mysql.services.clever-cloud.com";
    $database = "blvf95dkmybpm8s1nymz";
    $username = "uzlllwhy5esuidlb";
    $password = "AyrN643IyXluK9TffnNn";
    $port = 3306; 

    $conn = new mysqli($hostname, $username, $password, $database, $port);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }else{
        echo "Connected succes";
    }
?>
