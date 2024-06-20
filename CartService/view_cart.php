<?php
session_start();
require 'classes.php'; 

if (!isset($_SESSION['loggedin']) || !$_SESSION['loggedin']) {
    header("Location: ../index.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$cartService = new CartService();
$cartItems = $cartService->viewMyCart($user_id);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Cart</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> <!-- Using CDN for Bootstrap -->
    <style>
        body {
            padding-top: 20px;
        }
        .container {
            max-width: 800px;
        }
        h1 {
            margin-bottom: 20px;
        }
        .table th, .table td {
            vertical-align: middle;
        }
        .add-ticket-btn {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="text-center">My Cart</h1>
        <div class="text-right add-ticket-btn">
            <a href="addTicketToCart.php" class="btn btn-success">Add Ticket to Cart</a>
        </div>
        <?php if (count($cartItems) > 0): ?>
            <table class="table table-striped table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th>Ticket ID</th>
                        <th>Amount</th>
                        <th>Date and Time</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cartItems as $item): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($item['c_ticketid']); ?></td>
                            <td><?php echo htmlspecialchars($item['c_ticketamount']); ?></td>
                            <td><?php echo htmlspecialchars($item['c_datetime']); ?></td>
                            <td>
                                <a href="editTicketInCart.php?purchase_id=<?php echo $item['c_id']; ?>" class="btn btn-primary btn-sm">Edit</a>
                                <a href="deleteTicketFromCart.php?purchase_id=<?php echo $item['c_id']; ?>" class="btn btn-danger btn-sm">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="alert alert-info text-center" role="alert">
                Your cart is empty.
            </div>
        <?php endif; ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>