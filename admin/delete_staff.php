<?php
// Session protection
function adminLogin()
{
    session_start();
    if (!(isset($_SESSION['adminLogin']) && $_SESSION['adminLogin'] == true)) {
        echo "<script>window.location.href='index.php';</script>";
        exit;
    }
}
adminLogin();

require "connection.php";

if (isset($_GET['id'])) {
    $staffID = $_GET['id'];

    // Use prepared statement to prevent SQL injection
    $stmt = $con->prepare("DELETE FROM staff WHERE staffID = ?");
    $stmt->bind_param("i", $staffID);

    if ($stmt->execute()) {
        echo "<script>alert('Staff deleted successfully.'); window.location='staff.php';</script>";
    } else {
        echo "<script>alert('Error deleting staff.'); window.location='staff.php';</script>";
    }

    $stmt->close();
} else {
    // If no id is provided, redirect back
    header("Location: staff.php");
    exit;
}
?>
