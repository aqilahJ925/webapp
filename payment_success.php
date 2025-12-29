<?php
$booking_id = $_GET['booking_id'] ?? '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Payment Success</title>
</head>
<body>

  <h2>Payment Successful ✅</h2>

  <p>Your booking ID: <b><?= htmlspecialchars($booking_id) ?></b></p>

  <a href="index.php">Back to Home</a>

</body>
</html>
