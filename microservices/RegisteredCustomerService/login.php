<?php
include 'classes.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $customer = new RegisteredCustomerService($username, $password, '', '', '', true, '');
    if ($customer->login($username, $password)) {
        echo "Login successful!";
    } else {
        echo "Invalid username or password.";
    }
}
?>
