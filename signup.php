<?php
session_start();
include('includes/db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = $_POST['username'];
  $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
  $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
  $stmt->bind_param("ss", $username, $password);
  if ($stmt->execute()) {
    $_SESSION['user_id'] = $conn->insert_id;
    $_SESSION['logged_in'] = true;
    $_SESSION['username'] = $username;
    header("Location: index.php");
    exit();
  } else {
    $error = "Username already taken.";
  }
}
?>

<?php include('includes/header.php'); ?>

<main>
  <h1>Sign Up</h1>
  <form method="POST" class="auth-form">
    <input type="text" name="username" placeholder="Choose a Username" required>
    <input type="password" name="password" placeholder="Choose a Password" required>
    <button type="submit">Sign Up</button>
  </form>
  <?php if(isset($error)) echo "<p class='error'>$error</p>"; ?>
  <p>Already have an account? <a href="login.php">Login</a></p>
</main>

<?php include('includes/footer.php'); ?>
