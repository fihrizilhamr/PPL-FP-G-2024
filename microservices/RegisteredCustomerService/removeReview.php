<?php
// removeReview.php
include 'classes.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $review_id = $_POST['review_id'];
    // $registeredCustomer = new RegisteredCustomer("username", "password", "email", "name", "birthdate", "gender", "phonenumber"); // Replace with actual user data
    $registeredCustomer = new ReviewService(); 
    $observer = new ReviewObserver();
    $registeredCustomer->attach($observer);
    $registeredCustomer->removeReview($review_id);

    echo "Review removed.";
}
?>
