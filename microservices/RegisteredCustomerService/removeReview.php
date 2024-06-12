<?php
// removeReview.php
include 'classes.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $review_id = $_POST['review_id'];
    $registeredCustomer = new RegisteredCustomer("username", "password", "email", "name", "birthdate", "gender", "phonenumber"); // Replace with actual user data

    $registeredCustomer->removeReview($review_id);

    echo "Review removed.";
}
?>
