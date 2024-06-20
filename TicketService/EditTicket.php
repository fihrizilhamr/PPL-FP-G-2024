<?php
// editTicket.php
include 'db.php';
include 'classes.php';

// Function to handle ticket editing
function editTicket($ticket_id, $name, $price, $status, $description) {
    // Sanitize user input
    $ticket_id = intval($ticket_id);
    $name = htmlspecialchars($name);
    $price = floatval($price);
    $status = intval($status);
    $description = htmlspecialchars($description);

    // Instantiate the TicketService
    $ticketService = new TicketService();

    // Update the ticket
    $ticketService->editTicket($ticket_id, $name, $price, $status, $description);

    // Return a response
    return [
        'success' => true,
        'message' => 'Ticket updated successfully.',
        'ticket_id' => $ticket_id
    ];
}

// Check if it's a POST request
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve ticket data from POST data
    $ticket_id = isset($_POST['ticket_id']) ? $_POST['ticket_id'] : null;
    $name = isset($_POST['name']) ? $_POST['name'] : null;
    $price = isset($_POST['price']) ? $_POST['price'] : null;
    $status = isset($_POST['status']) ? $_POST['status'] : null;
    $description = isset($_POST['description']) ? $_POST['description'] : null;

    // Attempt to edit the ticket
    if ($ticket_id !== null && $name !== null && $price !== null && $status !== null && $description !== null) {
        $result = editTicket($ticket_id, $name, $price, $status, $description);
        // Output JSON response
        header('Content-Type: application/json');
        echo json_encode($result);
        exit;
    } else {
        // Handle invalid request or missing parameters
        $error = [
            'success' => false,
            'message' => 'All fields (ticket_id, name, price, status, description) are required.'
        ];
        header('Content-Type: application/json');
        http_response_code(400); // Bad Request
        echo json_encode($error);
        exit;
    }
} else {
    // Handle other HTTP methods (e.g., GET, PUT, DELETE)
    $error = [
        'success' => false,
        'message' => 'Only POST method is allowed for this endpoint.'
    ];
    header('Content-Type: application/json');
    http_response_code(405); // Method Not Allowed
    echo json_encode($error);
    exit;
}
?>
