<?php
require 'admin/connection.php';
session_start();

$customer_id = $_SESSION['customer_id'] ?? ($_SESSION['user_id'] ?? 0);
if ($customer_id <= 0) {
  die("Please login first.");
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  header("Location: services.php");
  exit;
}

$packageID      = isset($_POST['packageID']) ? (int)$_POST['packageID'] : 0;
$duration_id    = isset($_POST['duration_id']) ? (int)$_POST['duration_id'] : 0;
$pickup_date    = $_POST['pickup_date'] ?? '';   // ktk pakai ni sebagai start_date

if ($packageID <= 0 || $duration_id <= 0 || $pickup_date === '') {
  die("Missing booking data. Please go back.");
}

$stmt = $con->prepare("
  SELECT pd.duration_type, pd.price
  FROM package_durations pd
  WHERE pd.duration_id = ? AND pd.packageID = ?
  LIMIT 1
");
$stmt->bind_param("ii", $duration_id, $packageID);
$stmt->execute();
$res = $stmt->get_result();
$info = $res->fetch_assoc();

if (!$info) {
  die("Invalid package/duration selected.");
}

$duration_type = $info['duration_type'];
$total_amount  = (float)$info['price'];

$stmt2 = $con->prepare("
  INSERT INTO bookings (customer_id, packageID, duration_type, start_date, status, total_amount)
  VALUES (?, ?, ?, ?, 'pending', ?)
");
$stmt2->bind_param("iissd", $customer_id, $packageID, $duration_type, $pickup_date, $total_amount);
$stmt2->execute();

$booking_id = $con->insert_id;

header("Location: payment.php?booking_id=" . $booking_id);
exit;

