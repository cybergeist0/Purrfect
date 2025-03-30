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
$stmt = $conn->prepare("DELETE FROM favorites WHERE user_id = ? AND pet_id = ?");
$stmt->bind_param("ii", $user_id, $pet_id);
if ($stmt->execute()) {
  echo "Pet removed from favorites!";
} else {
  echo "Failed to remove pet from favorites.";
}
?>
