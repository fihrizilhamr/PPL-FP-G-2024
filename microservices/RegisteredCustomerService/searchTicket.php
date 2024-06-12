<?php
// searchTicket.php
include 'classes.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    // $registeredCustomer = new TicketService("username", "password", "email", "name", "birthdate", "gender", "phonenumber"); // Replace with actual user data
    $registeredCustomer = new TicketService(); 

    $tickets = $registeredCustomer->searchTicket($name);

    if (!empty($tickets)) {
        echo "<h1>Search Results</h1><ul>";
        foreach ($tickets as $ticket) {
            echo "<li>{$ticket['name']}: \${$ticket['price']}</li>";
        }
        echo "</ul>";
    } else {
        echo "No tickets found.";
    }
}
?>
