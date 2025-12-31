<?php
session_start();
require_once __DIR__ . '/../admin/connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $bookingID = (int)$_POST['bookingID'];
    $booking_status = $_POST['booking_status'];

    // 1. Update the booking status
    $stmt = $con->prepare("UPDATE booking SET booking_status=? WHERE bookingID=?");
    $stmt->bind_param("si", $booking_status, $bookingID);
    $stmt->execute();
    $stmt->close();

    // 2. If booking status is 'Stored', update payment status to 'paid'
    if ($booking_status === 'Stored') {
        $stmt = $con->prepare("UPDATE payment SET payment_status='paid' WHERE bookingID=? AND payment_status='pending'");
        $stmt->bind_param("i", $bookingID);
        $stmt->execute();
        $stmt->close();
    }

    header("Location: bookitem.php");
    exit();
}
