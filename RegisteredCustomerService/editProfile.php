<?php
require 'classes.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $observer = new CustomerObserver();
    $customerService = new RegisteredCustomerService($_POST['username'], $_POST['password'], $_POST['email'], $_POST['name'], $_POST['birthdate'], $_POST['gender'], $_POST['phonenumber']);
    $customerService->attach($observer);
    $customerService->editProfile($_POST['username'], $_POST['password'], $_POST['email'], $_POST['name'], $_POST['birthdate'], $_POST['gender'], $_POST['phonenumber']);
    echo "Profile updated successfully.";
} else {
    echo "Invalid request.";
}
?>
