<?php
require 'admin/connection.php';

$booking_id = isset($_GET['booking_id']) ? (int)$_GET['booking_id'] : 0;
if ($booking_id <= 0) die("Invalid booking.");

// ambil amount
$stmt = $con->prepare("SELECT total_amount FROM bookings WHERE booking_id = ?");
$stmt->bind_param("i", $booking_id);
$stmt->execute();
$result = $stmt->get_result();
$booking = $result->fetch_assoc();

if (!$booking) die("Booking not found.");

// insert payment ikut table ktk
$stmt2 = $con->prepare("
  INSERT INTO payments (booking_id, amount, method, status)
  VALUES (?, ?, 'manual', 'paid')
");
$stmt2->bind_param("id", $booking_id, $booking['total_amount']);
$stmt2->execute();

// update booking status
$stmt3 = $con->prepare("UPDATE bookings SET status = 'paid' WHERE booking_id = ?");
$stmt3->bind_param("i", $booking_id);
$stmt3->execute();

header("Location: payment_success.php?booking_id=".$booking_id);
exit;
