<?php
require __DIR__ . "/config/db.php";

$booking_id = isset($_GET['booking_id']) ? (int)$_GET['booking_id'] : 0;
if ($booking_id <= 0) die("Invalid booking.");

// ambil amount
$stmt = $pdo->prepare("SELECT total_amount FROM bookings WHERE booking_id = ?");
$stmt->execute([$booking_id]);
$booking = $stmt->fetch();

if (!$booking) die("Booking not found.");

// insert payment ikut table ktk
$stmt2 = $pdo->prepare("
  INSERT INTO payments (booking_id, amount, method, status)
  VALUES (?, ?, 'manual', 'paid')
");
$stmt2->execute([$booking_id, $booking['total_amount']]);

// update booking status
$stmt3 = $pdo->prepare("UPDATE bookings SET status = 'paid' WHERE booking_id = ?");
$stmt3->execute([$booking_id]);

header("Location: payment_success.php?booking_id=".$booking_id);
exit;
