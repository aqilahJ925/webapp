<?php
session_start();
require "connection.php";

// Check admin login
if (!(isset($_SESSION['adminLogin']) && $_SESSION['adminLogin'] == true)) {
    header("Location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name  = $_POST['staff_name'];
    $email = $_POST['staff_email'];
    $phone = $_POST['staff_phone'];

    // Insert new staff into staff table
    $stmt = $con->prepare("INSERT INTO staff (staff_name, staff_email, staff_phone) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $phone);
    
    if ($stmt->execute()) {
        // Redirect back to staff page
        header("Location: staff.php");
        exit();
    } else {
        echo "Error adding staff: " . $stmt->error;
    }
} else {
    header("Location: staff.php");
    exit();
}
?>
