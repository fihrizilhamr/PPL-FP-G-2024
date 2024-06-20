<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Payment Service</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="styles.css">
  </head>
  <body>
    <div class="container">
      <h1 class="my-4">Create Payment</h1>
      <form method="post" action="create_payment.php">
        <div class="form-group">
          <label for="payment_date">Payment Date:</label>
          <input type="date" class="form-control" name="payment_date" id="payment_date" required>
        </div>
        <div class="form-group">
          <label for="amount">Amount:</label>
          <input type="number" step="0.01" class="form-control" name="amount" id="amount" required>
        </div>
          <button type="submit" class="btn btn-primary">Submit</button>
      </form>

      <h1 class="my-4">Payments</h1>
      <?php
        include 'read_payments.php';
      ?>

      <h1 class="my-4">Search Payments</h1>
      <form method="post" action="search_payments.php">
          <div class="form-group">
            <label for="keyword">Keyword:</label>
            <input type="text" class="form-control" name="keyword" id="keyword" required>
          </div>
          <button type="submit" class="btn btn-primary">Search</button>
      </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
  </body>
</html>