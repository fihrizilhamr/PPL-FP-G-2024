<?php
// deleteTicketFromCart.php
include 'classes.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $purchase_id = $_POST['purchase_id'];
    $registeredCustomer = new CartService(); 
    $observer = new CartObserver();
    $registeredCustomer->attach($observer);
    $registeredCustomer->deleteTicketFromCart($purchase_id);

    echo "Ticket deleted from cart.";
} else if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['purchase_id'])) {
    $purchase_id = $_GET['purchase_id'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Ticket From Cart</title>
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
        <h1 class="text-center">Delete Ticket From Cart</h1>
        <p class="text-center">Are you sure you want to delete this ticket from your cart?</p>
        <form action="deleteTicketFromCart.php" method="POST">
            <input type="hidden" name="purchase_id" value="<?php echo htmlspecialchars($purchase_id); ?>">
            <div class="text-center">
                <button type="submit" class="btn btn-danger">Delete</button>
                <a href="view_cart.php" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</body>
</html>
<?php
} else {
    echo "Invalid request.";
}
?>
