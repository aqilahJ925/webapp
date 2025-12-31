<?php
require 'admin/connection.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: logincustomer.php");
    exit;
}

$packageID = (int)($_POST['packageID'] ?? 0);
$duration_id = (int)($_POST['duration_id'] ?? 0);
$pickup_address = $_POST['pickup_address'] ?? '';
$pickup_date = $_POST['pickup_date'] ?? '';
$return_date = $_POST['return_date'] ?? '';

if (!$packageID || !$duration_id || !$pickup_address || !$pickup_date || !$return_date) {
    die("Please fill in all required fields.");
}

// Insert booking
$stmt = $con->prepare("
    INSERT INTO booking (userID, packageID, pickup_date, return_date, booking_status)
    VALUES (?, ?, ?, ?, ' ')
");
$stmt->bind_param("iiss", $_SESSION['user_id'], $packageID, $pickup_date, $return_date);
$stmt->execute();

// Get last booking ID
$booking_id = $stmt->insert_id;

header("Location: payment.php?booking_id=" . $booking_id . "&duration_id=" . $duration_id);
exit;
