<?php
require 'admin/connection.php';
session_start();

$booking_id = isset($_GET['booking_id']) ? (int)$_GET['booking_id'] : 0;
if ($booking_id <= 0) {
  die("Invalid booking.");
}

$stmt = $con->prepare("
  SELECT b.bookingID, b.booking_status,
         pd.duration_type, pd.price
  FROM booking b
  LEFT JOIN package_durations pd ON pd.duration_id = b.duration_id
  WHERE b.bookingID = ?
  LIMIT 1
");

$stmt->bind_param("i", $booking_id);
$stmt->execute();
$result = $stmt->get_result();
$booking = $result->fetch_assoc();

if (!$booking) {
  die("Booking not found.");
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Payment</title>
</head>
<body>

<h2>Payment</h2>

<p><b>Booking ID:</b> <?= (int)$booking['bookingID'] ?></p>
<p><b>Duration:</b> <?= htmlspecialchars($booking['duration_type']) ?></p>
<p><b>Amount:</b> RM <?= number_format($booking['price'], 2) ?></p>

<form method="POST" action="payment_process.php">
  <input type="hidden" name="booking_id" value="<?= (int)$booking['bookingID'] ?>">

  <select name="method" required>
    <option value="cash">Cash</option>
    <option value="online">Online Banking</option>
  </select>

  <button type="submit">Pay Now</button>
</form>


</body>
</html>

