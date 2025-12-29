<?php
require __DIR__ . "/config/db.php";

$booking_id = isset($_GET['booking_id']) ? (int)$_GET['booking_id'] : 0;
if ($booking_id <= 0) die("Invalid booking.");

$stmt = $pdo->prepare("SELECT booking_id, total_amount FROM bookings WHERE booking_id = ?");
$stmt->execute([$booking_id]);
$booking = $stmt->fetch();

if (!$booking) die("Booking not found.");
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Payment</title>
</head>
<body>
  <h2>Payment</h2>
  <p>Booking ID: <b><?= $booking_id ?></b></p>
  <p>Total Amount: <b>RM <?= number_format((float)$booking['total_amount'], 2) ?></b></p>

  <a href="payment_process.php?booking_id=<?= $booking_id ?>">
    <button>Pay Now</button>
  </a>

  <p><a href="index.php">Back to Home</a></p>
</body>
</html>
