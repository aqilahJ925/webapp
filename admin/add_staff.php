<?php
require 'connection.php';
session_start();

// Admin session check
if (!(isset($_SESSION['adminLogin']) && $_SESSION['adminLogin'] === true)) {
    header('Location: index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $con->real_escape_string($_POST['staff_name']);
    $email = $con->real_escape_string($_POST['staff_email']);
    $phone = $con->real_escape_string($_POST['staff_phone']);
    $shift = $con->real_escape_string($_POST['shift']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // hash password

    $sql = "INSERT INTO staff (staff_name, staff_email, staff_phone, shift, password)
            VALUES ('$name', '$email', '$phone', '$shift', '$password')";

    if ($con->query($sql)) {
        $_SESSION['success'] = "Staff added successfully.";
    } else {
        $_SESSION['error'] = "Error: " . $con->error;
    }

    header("Location: staff.php");
    exit;
}
?>
