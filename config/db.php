<?php
$host = "127.0.0.1";
$db   = "storagedb";
$user = "root";
$pass = "";

try {
  $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
} catch (PDOException $e) {
  echo "ERROR: " . $e->getMessage();
}
