<?php
session_start();
require_once __DIR__ . '/../admin/connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // If editing single existing item
    if (isset($_POST['itemID']) && !empty($_POST['itemID'])) {
        $itemID = (int)$_POST['itemID'];
        $item_name = $_POST['item_name'];
        $storage_location = $_POST['storage_location'];

        $imagePath = null;
        if (isset($_FILES['item_image']) && $_FILES['item_image']['error'] === 0) {
            $uploadDir = '../uploads/items/';
            if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
            $fileName = time().'_'.basename($_FILES['item_image']['name']);
            $targetFile = $uploadDir.$fileName;
            if(move_uploaded_file($_FILES['item_image']['tmp_name'],$targetFile)){
                $imagePath = 'uploads/items/'.$fileName;
            }
        }

        if ($imagePath) {
            $stmt = $con->prepare("UPDATE storageitem SET item_name=?, storage_location=?, item_image=? WHERE itemID=?");
            $stmt->bind_param("sssi",$item_name,$storage_location,$imagePath,$itemID);
        } else {
            $stmt = $con->prepare("UPDATE storageitem SET item_name=?, storage_location=? WHERE itemID=?");
            $stmt->bind_param("ssi",$item_name,$storage_location,$itemID);
        }
        $stmt->execute();
        $stmt->close();

    } 
    // Adding multiple items at once
    elseif (isset($_POST['bookingID']) && isset($_POST['item_name']) && !empty($_POST['item_name'])) {
        $bookingID = (int)$_POST['bookingID'];
        $storage_location = $_POST['storage_location'];
        $item_names = $_POST['item_name'];
        $images = $_FILES['item_image'];

        foreach($item_names as $index => $name){
            $imagePath = null;
            if (isset($images['tmp_name'][$index]) && $images['error'][$index] == 0) {
                $uploadDir = '../uploads/items/';
                if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
                $fileName = time().'_'.basename($images['name'][$index]);
                $targetFile = $uploadDir.$fileName;
                if(move_uploaded_file($images['tmp_name'][$index],$targetFile)){
                    $imagePath = 'uploads/items/'.$fileName;
                }
            }

            $stmt = $con->prepare("INSERT INTO storageitem (bookingID, item_name, storage_location, item_image) VALUES (?,?,?,?)");
            $stmt->bind_param("isss",$bookingID,$name,$storage_location,$imagePath);
            $stmt->execute();
        }
    }

    header("Location: bookitem.php");
    exit();
}
