<?php
require 'admin/connection.php';
session_start();

$userID = $_SESSION['user_id'] ?? 0;
if ($userID <= 0) {
  die("Please login first.");
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  header("Location: services.php");
  exit;
}

$packageID   = (int)($_POST['packageID'] ?? 0);
$pickup_date = $_POST['pickup_date'] ?? '';
$return_date = $_POST['return_date'] ?? '';

if ($packageID <= 0 || $pickup_date === '' || $return_date === '') {
  die("Missing booking data. Please go back.");
}

$stmt2 = $con->prepare("
  INSERT INTO booking (userID, packageID, pickup_date, return_date, booking_status)
  VALUES (?, ?, ?, ?, 'pending')
");
$stmt2->bind_param("iiss", $userID, $packageID, $pickup_date, $return_date);
$stmt2->execute();

$booking_id = $con->insert_id;

header("Location: payment_process.php?booking_id=" . $booking_id);
exit;


