<?php
<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
?>

session_start();
$package = $_GET['package'] ?? 'starter';
$packageName = ucfirst($package) . ' Pack';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Book <?= $packageName ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">
  <h3 class="mb-4">Book: <?= $packageName ?></h3>
  <form action="submit_booking.php" method="POST">
    <input type="hidden" name="package" value="<?= $package ?>">

    <div class="mb-3">
      <label class="form-label">Full Name</label>
      <input type="text" name="name" class="form-control" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Number of Items</label>
      <input type="number" name="items" class="form-control" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Pickup Date</label>
      <input type="date" name="pickup_date" class="form-control" required>
    </div>

    <button type="submit" class="btn btn-primary">Confirm Booking</button>
  </form>
</div>

</body>
</html>
