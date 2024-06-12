<?php
// deleteTicketFromCart.php
include 'classes.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $purchase_id = $_POST['purchase_id'];
    $registeredCustomer = new RegisteredCustomer("username", "password", "email", "name", "birthdate", "gender", "phonenumber"); 
    $observer = new CustomerObserver();
    $registeredCustomer->attach($observer);
    $registeredCustomer->deleteTicketFromCart($purchase_id);

    echo "Ticket deleted from cart.";
}
?>
