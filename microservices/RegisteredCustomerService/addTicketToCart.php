<?php
// addTicketToCart.php
include 'classes.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ticket_id = $_POST['ticket_id'];
    $amount = $_POST['amount'];
    $datetime = $_POST['datetime'];
    $user_id = 1;
    // $registeredCustomer = new CartService("username", "password", "email", "name", "birthdate", "gender", "phonenumber"); // Replace with actual user data
    $registeredCustomer = new CartService();
    $observer = new CartObserver();
    $registeredCustomer->attach($observer);
    $registeredCustomer->addTicketToCart($ticket_id, $user_id, $amount, $datetime);

    echo "Ticket added to cart.";
}
?>
