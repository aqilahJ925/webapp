<?php
require 'admin/connection.php';
session_start();

$booking_id = (int)($_POST['booking_id'] ?? 0);
$method     = $_POST['method'] ?? '';

if ($booking_id <= 0) die("Invalid booking.");
if ($method !== 'cash' && $method !== 'online') die("Method not received.");

$newStatus = ($method === 'online') ? 'paid' : 'pending_payment';

$stmt = $con->prepare("UPDATE booking SET booking_status = ? WHERE bookingID = ?");
$stmt->bind_param("si", $newStatus, $booking_id);
$stmt->execute();

header("Location: payment_success.php?booking_id=" . $booking_id);
exit;
