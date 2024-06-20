<?php
// Ensure no whitespace or output before this point
session_start();
include 'classes.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $customer = new RegisteredCustomerService($username, $password, '', '', '', true, '');
    if ($customer->login($username, $password)) {
        $userId = $customer->getUserId($username); 
        $_SESSION['user_id'] = $userId;
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $username; 

        // Redirect to the main page
        header('Location: ../index.php');
        exit();        
    } else {
        echo "Invalid username or password.";
    }
}
?>
