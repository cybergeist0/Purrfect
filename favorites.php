<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
  header("Location: login.php");
  exit();
}
include('includes/db.php');

$user_id = $_SESSION['user_id'];
$query = "SELECT pets.* FROM pets 
          JOIN favorites ON pets.id = favorites.pet_id 
          WHERE favorites.user_id = $user_id";
$result = $conn->query($query);
?>

<?php include('includes/header.php'); ?>

<main>
  <h1>Your Favorite Pets</h1>
  <div class="pet-grid">
    <?php while($row = $result->fetch_assoc()): ?>
      <div class="pet-card">
        <img src="<?php echo $row['image']; ?>" alt="<?php echo $row['name']; ?>">
        <h2><?php echo $row['name']; ?> (<?php echo $row['age']; ?>)</h2>
        <p><strong>Breed:</strong> <?php echo $row['breed']; ?></p>
        <p><strong>Personality:</strong> <?php echo $row['personality']; ?></p>
        <button onclick="window.location.href='<?php echo $row['adoption_link']; ?>'">🐾 Adopt</button>
        <button class="remove-button" onclick="removeFavorite(<?php echo $row['id']; ?>)">❌</button>
      </div>
    <?php endwhile; ?>
  </div>
</main>

<script>
function removeFavorite(petId) {
  fetch('remove-favorite.php', {
    method: 'POST',
    body: JSON.stringify({ pet_id: petId }),
    headers: { 'Content-Type': 'application/json' }
  })
  .then(response => response.text())
  .then(() => location.reload());
}
</script>

<?php include('includes/footer.php'); ?>
