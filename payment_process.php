<?php
require 'admin/connection.php';

$booking_id = isset($_GET['booking_id']) ? (int)$_GET['booking_id'] : 0;
if ($booking_id <= 0) die("Invalid booking.");

$stmt = $con->prepare("
  UPDATE booking
  SET booking_status = 'paid'
  WHERE bookingID = ?
");
$stmt->bind_param("i", $booking_id);
$stmt->execute();

header("Location: payment_success.php?booking_id=" . $booking_id);
exit;
