<?php
session_start();
include('includes/db.php');
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
  echo "Please log in.";
  exit();
}
$data = json_decode(file_get_contents("php://input"), true);
$pet_id = $data['pet_id'];
$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("INSERT INTO favorites (user_id, pet_id) VALUES (?, ?)");
$stmt->bind_param("ii", $user_id, $pet_id);
if ($stmt->execute()) {
  echo "Pet added to favorites!";
} else {
  echo "Failed to add pet to favorites.";
}
?>
