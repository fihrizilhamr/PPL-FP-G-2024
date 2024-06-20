<?php
// addTicketToCart.php
session_start();
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
    $registeredCustomer->addTicketToCart($ticket_id, $_SESSION['user_id'], $amount, $datetime);

    echo "Ticket added to cart.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Ticket to Cart</title>
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
        <h1 class="text-center">Add Ticket to Cart</h1>
        <form action="addTicketToCart.php" method="POST">
            <div class="form-group">
                <label for="ticket_id">Ticket ID:</label>
                <input type="text" id="ticket_id" name="ticket_id" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="amount">Amount:</label>
                <input type="number" id="amount" name="amount" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="datetime">Date and Time:</label>
                <input type="datetime-local" id="datetime" name="datetime" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Add to Cart</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>