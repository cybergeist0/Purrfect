<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
  header("Location: login.php");
  exit();
}
include('includes/db.php');

// Fetch pets ordered by id ascending (for simplicity)
$result = $conn->query("SELECT * FROM pets ORDER BY id ASC");
$pets = [];
while ($row = $result->fetch_assoc()) {
  $pets[] = $row;
}
$pets_json = json_encode($pets);
?>

<?php include('includes/header.php'); ?>

<main id="main-container">
  <h1>Swipe Through Adorable Pets!</h1>
  <div id="pet-wrapper">
    <!-- The pet card will be rendered here -->
    <div id="pet-container"></div>
  </div>
</main>

<script>
// Load pets data from PHP
const pets = <?php echo $pets_json; ?>;
let currentPetIndex = 0;

function showPet(index) {
  if (index >= pets.length) {
    document.getElementById('pet-container').innerHTML = "<p>No more pets to show!</p>";
    return;
  }
  const pet = pets[index];
  const petHTML = `
    <div class="pet-card" data-pet-id="${pet.id}">
      <img src="${pet.image}" alt="${pet.name}" class="pet-image" onclick="showBio('${encodeURIComponent(pet.bio)}')">
      <h2>${pet.name} (${pet.age})</h2>
      <p><strong>Breed:</strong> ${pet.breed}</p>
      <p><strong>Personality:</strong> ${pet.personality}</p>
    </div>
  `;
  document.getElementById('pet-container').innerHTML = petHTML;
}

function nextPet() {
  currentPetIndex++;
  showPet(currentPetIndex);
}

function saveCurrentPet() {
  const pet = pets[currentPetIndex];
  fetch('save-favorite.php', {
    method: 'POST',
    body: JSON.stringify({ pet_id: pet.id }),
    headers: { 'Content-Type': 'application/json' }
  })
  .then(response => response.text())
  .then(msg => alert(msg))
  .finally(() => nextPet());
}

function showBio(encodedBio) {
  const bio = decodeURIComponent(encodedBio);
  alert(bio);
}

// Attach a click listener to the main container
document.getElementById('main-container').addEventListener('click', function(event) {
  // Avoid handling clicks on the pet image (which shows the bio)
  if (event.target.classList.contains('pet-image')) {
    return;
  }
  const petCard = document.querySelector('.pet-card');
  if (!petCard) return;
  
  const cardRect = petCard.getBoundingClientRect();
  const clickX = event.clientX;
  
  // If click is to the left of the card, skip to next pet.
  if (clickX < cardRect.left) {
    nextPet();
  }
  // If click is to the right of the card, save the pet.
  else if (clickX > cardRect.right) {
    saveCurrentPet();
  }
  // Otherwise, do nothing.
});

// Show the first pet on page load
showPet(currentPetIndex);
</script>

<?php include('includes/footer.php'); ?>
