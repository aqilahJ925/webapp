<?php
require 'admin/connection.php';
session_start();

$booking_id = isset($_GET['booking_id']) ? (int)$_GET['booking_id'] : 0;
if ($booking_id <= 0) die("Invalid booking.");

// ambik booking info
$stmt = $con->prepare("SELECT booking_id, total_amount, status FROM bookings WHERE booking_id = ? LIMIT 1");
$stmt->bind_param("i", $booking_id);
$stmt->execute();
$res = $stmt->get_result();
$booking = $res->fetch_assoc();

if (!$booking) die("Booking not found.");

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Payment</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>

<h2>Payment</h2>
<p>Booking ID: <b><?= (int)$booking['booking_id'] ?></b></p>
<p>Status: <b><?= htmlspecialchars($booking['status']) ?></b></p>
<p>Total Amount: <b>RM <?= number_format((float)$booking['total_amount'], 2) ?></b></p>

<a href="payment_process.php?booking_id=<?= (int)$booking['booking_id'] ?>">
  <button class="btn">Pay Now</button>
</a>

</body>
</html>

