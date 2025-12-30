<?php
require 'admin/connection.php';
session_start();

$booking_id = (int)($_GET['booking_id'] ?? 0);
if ($booking_id <= 0) die("Invalid booking.");

$stmt = $con->prepare("SELECT booking_status FROM booking WHERE bookingID = ? LIMIT 1");
$stmt->bind_param("i", $booking_id);
$stmt->execute();
$res = $stmt->get_result();
$row = $res->fetch_assoc();

if (!$row) die("Booking not found.");
$status = $row['booking_status'];
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Payment Result</title>
</head>
<body>

<h2>Payment Result ✅</h2>
<p><b>Booking ID:</b> <?= $booking_id ?></p>
<p><b>Status:</b> <?= htmlspecialchars($status) ?></p>

<?php if ($status === 'paid'): ?>
  <p>✅ Online banking confirmed.</p>
<?php else: ?>
  <p>⏳ Cash payment pending (pay at counter / pickup).</p>
<?php endif; ?>

<a href="index.php">Back to Home</a>

</body>
</html>
