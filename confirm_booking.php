<?php
require __DIR__ . "/config/db.php";
session_start();


$packageID = isset($_POST['packageID']) ? (int)$_POST['packageID'] : 0;
$duration_id = isset($_POST['duration_id']) ? (int)$_POST['duration_id'] : 0;
$pickup_address = trim($_POST['pickup_address'] ?? '');
$pickup_date = $_POST['pickup_date'] ?? '';
$return_date = $_POST['return_date'] ?? '';


$customer_id = $_SESSION['customer_id'] ?? 0;
if ($customer_id <= 0) {
  die("Please login first.");
}


if ($customer_id <= 0) {
  $tmp = $pdo->query("SELECT customer_id FROM customers ORDER BY customer_id ASC LIMIT 1")->fetch();
  $customer_id = $tmp ? (int)$tmp['customer_id'] : 0;
}

if ($customer_id <= 0) {
  die("No customer found. Please create a customer in table customers first.");
}


if ($packageID <= 0 || $duration_id <= 0 || $pickup_address === '' || $pickup_date === '' || $return_date === '') {
  die("Missing booking info. Please go back.");
}

$stmt = $pdo->prepare("SELECT duration_type, price, packageID FROM package_durations WHERE duration_id = ? LIMIT 1");
$stmt->execute([$duration_id]);
$dur = $stmt->fetch();

if (!$dur) die("Invalid duration selected.");
if ((int)$dur['packageID'] !== $packageID) die("Duration doesn't match package.");

$stmt2 = $pdo->prepare("
  INSERT INTO bookings (customer_id, packageID, duration_type, start_date, status, total_amount)
  VALUES (?, ?, ?, ?, 'pending', ?)
");
$stmt2->execute([
  $customer_id,
  $packageID,
  $dur['duration_type'],
  $pickup_date,          
  $dur['price']
]);

$booking_id = $pdo->lastInsertId();


header("Location: payment.php?booking_id=" . urlencode($booking_id));
exit;


