<?php
// addTicket.php
include 'classes.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize user input
    $name = htmlspecialchars(trim($_POST['name']));
    $description = htmlspecialchars(trim($_POST['description']));
    $price = floatval($_POST['price']);
    $status = intval($_POST['status']);

    // Instantiate the TicketService
    $ticketService = new TicketService();

    // Add the ticket
    $ticketService->addTicket($name, $description, $price, $status);

    // Confirm the addition
    echo "<h1>Ticket Added Successfully</h1>";
    echo "<p>Ticket Name: " . htmlspecialchars($name) . "</p>";
    echo "<p>Description: " . htmlspecialchars($description) . "</p>";
    echo "<p>Price: $" . htmlspecialchars($price) . "</p>";
    echo "<p>Status: " . ($status ? 'Active' : 'Inactive') . "</p>";
} else {
    // If the form has not been submitted, redirect to the form
    header('Location: addTicketForm.html');
    exit();
}
?>
