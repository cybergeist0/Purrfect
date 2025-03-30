<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
  header("Location: login.php");
  exit();
}
include('includes/db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $name = $_POST['name'];
  $age = $_POST['age'];
  $breed = $_POST['breed'];
  $personality = $_POST['personality'];
  $bio = $_POST['bio'];
  $adoption_link = $_POST['adoption_link'];
  $image = $_POST['image_url'];
  $added_by = $_SESSION['user_id'];
  
  $stmt = $conn->prepare("INSERT INTO pets (name, age, breed, personality, bio, image, adoption_link, added_by) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
  $stmt->bind_param("sssssssi", $name, $age, $breed, $personality, $bio, $image, $adoption_link, $added_by);
  $stmt->execute();
  header("Location: index.php");
  exit();
}
?>

<?php include('includes/header.php'); ?>

<main>
  <h1>Add a New Pet</h1>
  <?php if (isset($error)) { echo "<p class='error'>$error</p>"; } ?>
  <form method="POST" class="add-pet-form">
    <input type="text" name="name" placeholder="Pet Name" required>
    <input type="text" name="age" placeholder="Age" required>
    <input type="text" name="breed" placeholder="Breed" required>
    <textarea name="personality" placeholder="Personality" required></textarea>
    <textarea name="bio" placeholder="Short Bio" required></textarea>
    <input type="url" name="adoption_link" placeholder="Adoption Link" required>
    <input type="url" name="image_url" placeholder="Image URL" required>
    <button type="submit">Add Pet</button>
  </form>
</main>

<?php include('includes/footer.php'); ?>
