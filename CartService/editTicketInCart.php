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
} else if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['purchase_id'])) {
    $purchase_id = $_GET['purchase_id'];
    
    // Fetch the current cart item details from the database
    $db = Database::getInstance()->getConnection();
    $stmt = $db->prepare("SELECT c_ticketid, c_ticketamount, c_datetime FROM cart WHERE c_id = ?");
    $stmt->bind_param("i", $purchase_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $cartItem = $result->fetch_assoc();
    $stmt->close();
    
    if ($cartItem):
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Ticket In Cart</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> <!-- Using CDN for Bootstrap -->
    <style>
        body {
            padding-top: 20px;
        }
        .container {
            max-width: 600px;
        }
        h1 {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="text-center">Edit Ticket In Cart</h1>
        <form action="editTicketInCart.php" method="POST">
            <input type="hidden" name="purchase_id" value="<?php echo htmlspecialchars($purchase_id); ?>">
            <div class="form-group">
                <label for="ticket_id">Ticket ID:</label>
                <input type="text" id="ticket_id" name="ticket_id" class="form-control" value="<?php echo htmlspecialchars($cartItem['c_ticketid']); ?>" required>
            </div>
            <div class="form-group">
                <label for="amount">Amount:</label>
                <input type="number" id="amount" name="amount" class="form-control" value="<?php echo htmlspecialchars($cartItem['c_ticketamount']); ?>" required>
            </div>
            <div class="form-group">
                <label for="datetime">Date and Time:</label>
                <input type="datetime-local" id="datetime" name="datetime" class="form-control" value="<?php echo htmlspecialchars($cartItem['c_datetime']); ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
</body>
</html>
<?php
    else:
        echo "Invalid cart item.";
    endif;
} else {
    echo "Invalid request.";
}
?>
