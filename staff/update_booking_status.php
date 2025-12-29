<?php
session_start();
require_once __DIR__ . '/../admin/connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $bookingID = (int)$_POST['bookingID'];
    $booking_status = $_POST['booking_status'];

    $stmt = $con->prepare("UPDATE booking SET booking_status=? WHERE bookingID=?");
    $stmt->bind_param("si", $booking_status, $bookingID);
    $stmt->execute();
    $stmt->close();

    header("Location: bookitem.php");
    exit();
}
