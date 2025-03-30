<?php
session_start();
include('includes/db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = $_POST['username'];
  $password = $_POST['password'];
  $stmt = $conn->prepare("SELECT id, password FROM users WHERE username = ?");
  $stmt->bind_param("s", $username);
  $stmt->execute();
  $stmt->store_result();
  $stmt->bind_result($id, $hashed_password);
  $stmt->fetch();
  if ($stmt->num_rows > 0 && password_verify($password, $hashed_password)) {
    $_SESSION['user_id'] = $id;
    $_SESSION['logged_in'] = true;
    $_SESSION['username'] = $username;
    header("Location: index.php");
    exit();
  } else {
    $error = "Invalid username or password.";
  }
}
?>

<?php include('includes/header.php'); ?>

<main>
  <h1>Login</h1>
  <form method="POST" class="auth-form">
    <input type="text" name="username" placeholder="Username" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit">Login</button>
  </form>
  <?php if(isset($error)) echo "<p class='error'>$error</p>"; ?>
  <p>Don't have an account? <a href="signup.php">Sign Up</a></p>
</main>

<?php include('includes/footer.php'); ?>
