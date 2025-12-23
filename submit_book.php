<?php
include 'db_connect.php'; // Make sure this connects to our MySQL database

$package = $_POST['package'];
$name = $_POST['name'];
$items = $_POST['items'];
$pickup_date = $_POST['pickup_date'];

$sql = "INSERT INTO bookings (user_name, package, items, booking_date, status)
        VALUES ('$name', '$package', '$items', '$pickup_date', 'Pending Pickup')";

if (mysqli_query($conn, $sql)) {
    header("Location: booking_success.php");
} else {
    echo "Error: " . mysqli_error($conn);
}
?>
