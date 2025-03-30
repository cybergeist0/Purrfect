<?php
// NOTE: THIS IS ONLY FOR XAMPP
$host = "localhost";
$user = "root";
$pass = "";
$db_name = "purrfect_db";

$conn = new mysqli($host, $user, $pass, $db_name);
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}
?>
