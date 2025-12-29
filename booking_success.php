<?php
$booking_id = $_GET['booking_id'] ?? '';
?>
<h2>Booking Success ✅</h2>
<p>Your booking id: <b><?= htmlspecialchars($booking_id) ?></b></p>
<a href="index.php">Back to home</a>
