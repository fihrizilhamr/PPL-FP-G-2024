<?php
require 'classes.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $purchase_id = $_POST['purchase_id'];
    $ticket_id = $_POST['ticket_id'];
    $amount = $_POST['amount'];
    $datetime = $_POST['datetime'];
    
    $observer = new CartObserver();
    $cartService = new CartService();
    $cartService->attach($observer);
    $cartService->editTicketInCart($purchase_id, $ticket_id, $amount, $datetime);
    echo "Ticket in cart updated successfully.";
} else {
    echo "Invalid request.";
}
?>
