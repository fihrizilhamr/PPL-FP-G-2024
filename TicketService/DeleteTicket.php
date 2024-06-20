<?php
// deleteTicket.php
include 'db.php';
include 'classes.php';

// Function to handle deletion
function deleteTicket($ticket_id) {
    // Sanitize user input
    $ticket_id = intval($ticket_id);

    // Instantiate the TicketService
    $ticketService = new TicketService();

    // Delete the ticket
    $ticketService->deleteTicket($ticket_id);

    // Return a response
    return [
        'success' => true,
        'message' => 'Ticket deleted successfully.',
        'ticket_id' => $ticket_id
    ];
}

// Check if it's a POST request
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve ticket ID from POST data
    $ticket_id = isset($_POST['ticket_id']) ? $_POST['ticket_id'] : null;

    // Attempt to delete the ticket
    if ($ticket_id !== null) {
        $result = deleteTicket($ticket_id);
        // Output JSON response
        header('Content-Type: application/json');
        echo json_encode($result);
        exit;
    } else {
        // Handle invalid request or missing parameters
        $error = [
            'success' => false,
            'message' => 'Ticket ID is required.'
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
