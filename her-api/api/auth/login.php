<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
header("Access-Control-Allow-Origin: *");
include "../../config/dbconfig.php";

// Sanitize input
$name = 'herAdmin';
$password = 'Gudboy24@';

// Prepare SQL statement
$query = $pdo->prepare("SELECT * FROM users WHERE name = :name");
$query->execute(array(':name' => $name));

// Check if user exists
if ($query->rowCount() > 0) {
  $rows = $query->fetch(PDO::FETCH_ASSOC);
  
  // Verify password
  if (password_verify($password, $rows['password'])) {
    // Direct pages with different user levels
    if ($rows['status'] != 1) {
      echo json_encode("Your account needs activation please contact info@daladalasmart.com");
    } else {
      echo json_encode($rows['id']);
    }
  } else {
    echo json_encode("wrong");
  }
} else {
  echo json_encode("wrong");
}
?>