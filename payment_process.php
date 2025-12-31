<?php
require 'admin/connection.php';
session_start();

$booking_id = (int)($_POST['booking_id'] ?? 0);
$duration_id = (int)($_POST['duration_id'] ?? 0);
$method     = $_POST['method'] ?? '';

if ($booking_id <= 0) die("Invalid booking.");
if ($method !== 'cash' && $method !== 'online') die("Method not received.");

$stmt = $con->prepare("SELECT price FROM package_durations WHERE duration_id = ? LIMIT 1");
$stmt->bind_param("i", $duration_id);
$stmt->execute();
$duration = $stmt->get_result()->fetch_assoc();
if (!$duration) die("Duration not found.");

$amount = $duration['price'];
$status = ($method === 'online') ? 'paid' : 'pending';
$payment_date = date('Y-m-d H:i:s');

$ref_id = 'ES-' . strtoupper(uniqid());
// Insert payment
$stmt = $con->prepare("
    INSERT INTO payment (bookingID, amount, payment_method, payment_date, payment_status, ref_id)
    VALUES (?, ?, ?, ?, ?, ?)
");
$stmt->bind_param("idssss", $booking_id, $amount, $method, $payment_date, $status, $ref_id);
$stmt->execute();

header("Location: payment_success.php?booking_id=" . $booking_id);
exit;
