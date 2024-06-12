<?php
// makeReview.php
include 'classes.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $dest_id = $_POST['dest_id'];
    $rating = $_POST['rating'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $datetime = $_POST['datetime'];
    $user_id = 1;
    $registeredCustomer = new RegisteredCustomer("username", "password", "email", "name", "birthdate", "gender", "phonenumber"); // Replace with actual user data

    $registeredCustomer->makeReview($dest_id, $user_id, $rating, $title, $description, $datetime);

    echo "Review submitted.";
}
?>
