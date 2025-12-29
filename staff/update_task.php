<?php
session_start();
require_once __DIR__ . '/../admin/connection.php';

// Check if staff is logged in
if (!isset($_SESSION['staffLogin']) || $_SESSION['staffLogin'] !== true) {
    header("Location: index.php");
    exit();
}

// Check if taskID is provided
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: task.php");
    exit();
}

$taskID = (int) $_GET['id'];
$staffID = $_SESSION['staffID'];

// Update the task status to 'Completed' only if it belongs to the logged-in staff
$sql = "UPDATE assignedtask 
        SET task_status = 'Completed' 
        WHERE taskID = ? AND staffID = ?";

$stmt = $con->prepare($sql);
$stmt->bind_param("ii", $taskID, $staffID);

if ($stmt->execute()) {
    $_SESSION['message'] = "Task marked as completed.";
} else {
    $_SESSION['message'] = "Failed to update task.";
}

$stmt->close();
header("Location: task.php");
exit();
