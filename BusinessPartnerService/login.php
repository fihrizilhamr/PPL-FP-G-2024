<?php
// Ensure no whitespace or output before this point
session_start();

// Check if logging in as a business partner
include 'classes.php'; // Ensure this path is correct

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Assuming BusinessPartnerService is defined in classes.php
    $businessPartner = new BusinessPartnerService($username, $password, '', '', '');

    if ($businessPartner->login($username, $password)) {
        $partnerId = $businessPartner->getUserId($username);
        $_SESSION['partner_id'] = $partnerId;
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
