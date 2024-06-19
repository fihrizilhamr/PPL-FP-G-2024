
<?php
session_start();
include 'classes.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $customer = new RegisteredCustomerService($username, $password, '', '', '', true, '');
    if ($customer->login($username, $password)) {
        $userId = $customer->getUserId($username); 
        $_SESSION['user_id'] = $userId;
        echo "Login successful!";
    } else {
        echo "Invalid username or password.";
    }
}
?>
