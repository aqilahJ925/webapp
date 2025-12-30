<?php
session_start();
require "connection.php";

// Check admin login
if (!(isset($_SESSION['adminLogin']) && $_SESSION['adminLogin'] == true)) {
    header("Location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $bookingID = $_POST['bookingID'];
    $staffID   = $_POST['staffID'];
    $task_type = $_POST['task_type'];

    // Insert assignment into assignedtask table with default status = Pending
    $stmt = $con->prepare("
        INSERT INTO assignedtask (staffID, bookingID, task_type, task_status)
        VALUES (?, ?, ?, 'Pending')
    ");
    $stmt->bind_param("iis", $staffID, $bookingID, $task_type);

    if ($stmt->execute()) {
        // Redirect back to staff page
        header("Location: staff.php");
        exit();
    } else {
        echo "Error assigning task: " . $stmt->error;
    }
} else {
    header("Location: staff.php");
    exit();
}
?>
