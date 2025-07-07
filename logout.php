<?php
session_start();
session_destroy();
header("Location: login.html");
?>

<!-- admin.php -->
<?php
session_start();
if (!isset($_SESSION['username'])) {
  header("Location: login.html");
  exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin - Dukan</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="container">
    <h1>Welcome, <?php echo $_SESSION['username']; ?>!</h1>
    <p>You are logged in as admin.</p>
    <a href="logout.php">Logout</a>
  </div>
</body>
</html>