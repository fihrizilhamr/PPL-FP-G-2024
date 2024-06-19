<?php
session_start();
$loggedin = isset($_SESSION['loggedin']) && $_SESSION['loggedin'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv='cache-control' content='no-cache'> 
    <meta http-equiv='expires' content='0'> 
    <meta http-equiv='pragma' content='no-cache'>
    <title>Travel Booking System</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            margin: 20px;
        }
        #notifications {
            margin-top: 20px;
        }
    </style>
</head>
<body>

<div class="container">
    <h1 class="my-4">Simple Implementation of Travel Booking System</h1>
    <div id="notifications" style="color: red;"></div>

    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <?php if (!$loggedin): ?>
        <li class="nav-item">
            <a class="nav-link active" id="register-tab" data-toggle="tab" href="#register" role="tab" aria-controls="register" aria-selected="true">Register</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="login-tab" data-toggle="tab" href="#login" role="tab" aria-controls="login" aria-selected="false">Login</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="business-partner-tab" data-toggle="tab" href="#business-partner" role="tab" aria-controls="business-partner" aria-selected="false">Business Partner Service</a>
        </li>
        <?php endif; ?>

        <?php if ($loggedin): ?>
        <li class="nav-item">
            <a class="nav-link" id="edit-profile-tab" data-toggle="tab" href="#edit-profile" role="tab" aria-controls="edit-profile" aria-selected="false">Edit Profile</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="ticket-service-tab" data-toggle="tab" href="#ticket-service" role="tab" aria-controls="ticket-service" aria-selected="false">Ticket Service</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="cart-service-tab" data-toggle="tab" href="#cart-service" role="tab" aria-controls="cart-service" aria-selected="false">Cart Service</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="review-service-tab" data-toggle="tab" href="#review-service" role="tab" aria-controls="review-service" aria-selected="false">Review Service</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="destination-tab" data-toggle="tab" href="#destination" role="tab" aria-controls="destination" aria-selected="false">Destination Service</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="payment-tab" data-toggle="tab" href="#payment" role="tab" aria-controls="payment" aria-selected="false">Payment Service</a>
        </li>
        <?php endif; ?>
    </ul>
    

    <div class="tab-content" id="myTabContent">
        <!-- Register Form -->
        <div class="tab-pane fade show active" id="register" role="tabpanel" aria-labelledby="register-tab">
            <h2>Register</h2>
        <form action="RegisteredCustomerService/register.php" method="POST" class="mb-4">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" class="form-control" placeholder="Username" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" class="form-control" placeholder="Password" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" class="form-control" placeholder="Email" required>
            </div>
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" class="form-control" placeholder="Name" required>
            </div>
            <div class="form-group">
                <label for="birthdate">Birthdate:</label>
                <input type="date" id="birthdate" name="birthdate" class="form-control" placeholder="Birthdate" required>
            </div>
            <fieldset class="form-group">
                <legend>Gender:</legend>
                <div class="form-check form-check-inline">
                    <input type="radio" id="male" name="gender" value="M" class="form-check-input" required>
                    <label for="male" class="form-check-label">Male</label>
                </div>
                <div class="form-check form-check-inline">
                    <input type="radio" id="female" name="gender" value="F" class="form-check-input" required>
                    <label for="female" class="form-check-label">Female</label>
                </div>
            </fieldset>
            <div class="form-group">
                <label for="phonenumber">Phone Number:</label>
                <input type="text" id="phonenumber" name="phonenumber" class="form-control" placeholder="Phone Number" required>
            </div>
            <button type="submit" class="btn btn-primary">Register</button>
        </form>
        </div>

        <!-- Login Form -->
        <div class="tab-pane fade" id="login" role="tabpanel" aria-labelledby="login-tab">
            <h2>Login</h2>
        <form action="RegisteredCustomerService/login.php" method="POST" class="mb-4">
            <div class="form-group">
                <label for="login_username">Username:</label>
                <input type="text" id="login_username" name="username" class="form-control" placeholder="Username" required>
            </div>
            <div class="form-group">
                <label for="login_password">Password:</label>
                <input type="password" id="login_password" name="password" class="form-control" placeholder="Password" required>
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
        </form>
        </div>

        <!-- Edit Profile Form -->
        <div class="tab-pane fade" id="edit-profile" role="tabpanel" aria-labelledby="edit-profile-tab">
            <h2>Edit Profile</h2>
            <form action="RegisteredCustomerService/editProfile.php" method="post" class="mb-4">
                <div class="form-group">
                    <label for="edit_username">Username:</label>
                    <input type="text" id="edit_username" name="username" class="form-control" placeholder="Username" required>
                </div>
                <div class="form-group">
                    <label for="edit_password">Password:</label>
                    <input type="password" id="edit_password" name="password" class="form-control" placeholder="Password" required>
                </div>
                <div class="form-group">
                    <label for="edit_email">Email:</label>
                    <input type="email" id="edit_email" name="email" class="form-control" placeholder="Email" required>
                </div>
                <div class="form-group">
                    <label for="edit_name">Name:</label>
                    <input type="text" id="edit_name" name="name" class="form-control" placeholder="Name" required>
                </div>
                <div class="form-group">
                    <label for="edit_birthdate">Birthdate:</label>
                    <input type="date" id="edit_birthdate" name="birthdate" class="form-control" placeholder="Birthdate" required>
                </div>
                <fieldset class="form-group">
                    <legend>Gender:</legend>
                    <div class="form-check form-check-inline">
                        <input type="radio" id="edit_male" name="gender" value="M" class="form-check-input" required>
                        <label for="edit_male" class="form-check-label">Male</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input type="radio" id="edit_female" name="gender" value="F" class="form-check-input" required>
                        <label for="edit_female" class="form-check-label">Female</label>
                    </div>
                </fieldset>
                <div class="form-group">
                    <label for="edit_phonenumber">Phone Number:</label>
                    <input type="text" id="edit_phonenumber" name="phonenumber" class="form-control" placeholder="Phone Number" required>
                </div>
                <button type="submit" class="btn btn-primary">Update Profile</button>
            </form>
    
        </div>

        <!-- Ticket Service -->
        <div class="tab-pane fade" id="ticket-service" role="tabpanel" aria-labelledby="ticket-service-tab">
            <h2>Search Ticket</h2>
        <form action="TicketService/searchTicket.php" method="POST" class="mb-4">
            <div class="form-group">
                <label for="name">Ticket Name:</label>
                <input type="text" id="name" name="name" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Search</button>
        </form>
        </div>

        <!-- Cart Service -->
        <div class="tab-pane fade" id="cart-service" role="tabpanel" aria-labelledby="cart-service-tab">
            <h2>Add Ticket to Cart</h2>
        <form action="CartService/addTicketToCart.php" method="POST" class="mb-4">
            <div class="form-group">
                <label for="ticket_id">Ticket ID:</label>
                <input type="text" id="ticket_id" name="ticket_id" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="amount">Amount:</label>
                <input type="number" id="amount" name="amount" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="datetime">Datetime:</label>
                <input type="datetime-local" id="datetime" name="datetime" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Add to Cart</button>
        </form>

        <h2>Edit Ticket in Cart</h2>
        <form action="CartService/editTicketInCart.php" method="post" class="mb-4">
            <div class="form-group">
                <label for="purchase_id">Cart ID:</label>
                <input type="number" id="purchase_id" name="purchase_id" class="form-control" placeholder="Purchase ID" required>
            </div>
            <div class="form-group">
                <label for="ticket_id">Ticket ID:</label>
                <input type="number" id="ticket_id" name="ticket_id" class="form-control" placeholder="Ticket ID" required>
            </div>
            <div class="form-group">
                <label for="amount">Amount:</label>
                <input type="number" id="amount" name="amount" class="form-control" placeholder="Amount" required>
            </div>
            <div class="form-group">
                <label for="datetime">Datetime:</label>
                <input type="datetime-local" id="datetime" name="datetime" class="form-control" placeholder="Datetime" required>
            </div>
            <button type="submit" class="btn btn-primary">Edit Ticket</button>
        </form>

        <h2>Delete Ticket from Cart</h2>
        <form action="CartService/deleteTicketFromCart.php" method="POST" class="mb-4">
            <div class="form-group">
                <label for="purchase_id">Purchase ID:</label>
                <input type="number" id="purchase_id" name="purchase_id" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-danger">Delete Ticket</button>
        </form>
        </div>

        <!-- Review Service -->
        <div class="tab-pane fade" id="review-service" role="tabpanel" aria-labelledby="review-service-tab">
            <h2>Make a Review</h2>
            <form action="ReviewService/makeReview.php" method="POST" enctype="multipart/form-data" class="mb-4">
                <div class="form-group">
                    <label for="dest_id">Destination ID:</label>
                    <input type="text" id="dest_id" name="dest_id" class="form-control" placeholder="Destination ID" required>
                </div>
                <div class="form-group">
                    <label for="rating">Rating:</label>
                    <input type="number" id="rating" name="rating" class="form-control" placeholder="Rating" required>
                </div>
                <div class="form-group">
                    <label for="description">Description:</label>
                    <textarea id="description" name="description" class="form-control" placeholder="Description" required></textarea>
                </div>
                <div class="form-group">
                    <label for="image">Image:</label>
                    <input type="file" id="image" name="image" class="form-control-file" required>
                </div>
                <div class="form-group">
                    <label for="datetime">Date and Time:</label>
                    <input type="datetime-local" id="datetime" name="datetime" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary">Submit Review</button>
            </form>
    
            <h2>Edit Review</h2>
            <form action="ReviewService/editReview.php" method="post" enctype="multipart/form-data" class="mb-4">
                <div class="form-group">
                    <label for="review_id">Review ID:</label>
                    <input type="number" id="review_id" name="review_id" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="rating">Rating:</label>
                    <input type="number" id="rating" name="rating" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="description">Description:</label>
                    <input type="text" id="description" name="description" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="image">Image:</label>
                    <input type="file" id="image" name="image" class="form-control-file" required>
                </div>
                <div class="form-group">
                    <label for="datetime">Datetime:</label>
                    <input type="datetime-local" id="datetime" name="datetime" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary">Edit Review</button>
            </form>
    
            <h2>Remove Review</h2>
            <form action="ReviewService/removeReview.php" method="POST" class="mb-4">
                <div class="form-group">
                    <label for="review_id">Review ID:</label>
                    <input type="number" id="review_id" name="review_id" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-danger">Remove Review</button>
            </form>
    
            <h2>View Review</h2>
            <form action="ReviewService/viewReview.php" method="get" class="mb-4">
                <div class="form-group">
                    <label for="review_id">Review ID:</label>
                    <input type="number" id="review_id" name="review_id" class="form-control" placeholder="Review ID" required>
                </div>
                <button type="submit" class="btn btn-primary">View Review</button>
            </form>
        </div>
    <!-- Destination Service Content -->
    <div class="tab-pane fade" id="destination" role="tabpanel" aria-labelledby="destination-tab">
        <!-- <h2>Search Destination</h2>
        <form action="DestinationService/searchDestination.php" method="POST" class="mb-4">
            <div class="form-group">
                <label for="destination">Destination Name:</label>
                <input type="text" id="destination" name="destination" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Search</button>
        </form> -->
    </div>

    <!-- Business Partner Service Content -->
    <div class="tab-pane fade" id="business-partner" role="tabpanel" aria-labelledby="business-partner-tab">
        <h2>Login as Business Partner</h2>
        <form action="PaymentService/index.php" method="POST" class="mb-4">
            <button type="submit" class="btn btn-primary">Pay Now</button>
        </form>
    </div>

    <!-- Payment Service Content -->
    <div class="tab-pane fade" id="payment" role="tabpanel" aria-labelledby="payment-tab">
        <h2>Make Payment</h2>
        <form action="PaymentService/index.php" method="POST" class="mb-4">
            <div class="form-group">
                
            </div>
            <button type="submit" class="btn btn-primary">Pay Now</button>
        </form>
    </div>
    <div id="output"></div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    
<script>
    function displayNotification(message) {
        const notificationsDiv = document.getElementById('notifications');
        const newNotification = document.createElement('p');
        newNotification.textContent = message;
        notificationsDiv.appendChild(newNotification);
    }
</script>

</body>
</html>
