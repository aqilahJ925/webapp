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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $staffID = $_POST['staffID'];
    $name = $_POST['staff_name'];
    $email = $_POST['staff_email'];
    $phone = $_POST['staff_phone'];

    // Prepared statement to prevent SQL injection
    $stmt = $con->prepare("UPDATE staff SET staff_name=?, staff_email=?, staff_phone=? WHERE staffID=?");
    $stmt->bind_param("sssi", $name, $email, $phone, $staffID);

    if ($stmt->execute()) {
        echo "<script>alert('Staff updated successfully.'); window.location='staff.php';</script>";
    } else {
        echo "<script>alert('Error updating staff.'); window.location='staff.php';</script>";
    }

    $stmt->close();
}
?>
