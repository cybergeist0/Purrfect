<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Purrfect - Pet Adoption</title>
  <link rel="stylesheet" href="styles/style.css">
</head>
<body>
<header>
  <nav>
    <a href="index.php">Home</a>
    <a href="favorites.php">Favorites</a>
    <a href="add-pet.php">Add Pet</a>
    <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true): ?>
      <span>Welcome, <?php echo htmlspecialchars($_SESSION['username'] ?? 'User'); ?>!</span>
      <a href="logout.php">Logout</a>
    <?php else: ?>
      <a href="login.php">Login</a>
      <a href="signup.php">Sign Up</a>
    <?php endif; ?>
  </nav>
</header>
