<?php
session_start();
include 'db.php';

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

// Check if user exists
$sql = "SELECT * FROM users WHERE username = '$username'";
$result = $conn->query($sql);

if ($result->num_rows === 1) {
  $row = $result->fetch_assoc();

  if (password_verify($password, $row['password'])) {
    $_SESSION['username'] = $username;
    header("Location: admin.php"); // or products.php
    exit();
  } else {
    echo "❌ Incorrect password";
  }
} else {
  echo "❌ User not found";
}
?>
