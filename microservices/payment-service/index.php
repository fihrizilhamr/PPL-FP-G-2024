<!DOCTYPE html>
<html>
<head>
    <title>Payment Service</title>
</head>
<body>

<h1>Create Payment</h1>
<form method="post" action="create_payment.php">
    Name: <input type="text" name="payer_name"><br>
    Amount: <input type="text" name="amount"><br>
    Payment Date: <input type="date" name="payment_date"><br>
    <input type="submit" value="Submit">
</form>

<h1>Payments</h1>
<?php
include 'read_payments.php';
?>

<h1>Search Payments</h1>
<form method="post" action="search_payments.php">
    Keyword: <input type="text" name="keyword"><br>
    <input type="submit" value="Search">
</form>

</body>
</html>
