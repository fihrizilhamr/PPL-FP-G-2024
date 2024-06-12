<?php
include 'classes.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $name = $_POST['name'];
    $birthdate = $_POST['birthdate'];
    $gender = $_POST['gender'];
    $phonenumber = $_POST['phonenumber'];

    $customer = RegisteredCustomerFactory::createRegisteredCustomer($username, $password, $email, $name, $birthdate, $gender, $phonenumber);
    $customer->save();

    echo "Registration successful!";
}
?>
