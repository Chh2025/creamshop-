<?php
include 'db.php';

$username = $_POST['username'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

// Check if username/email already exists
$check = $conn->query("SELECT * FROM users WHERE username = '$username'");
if ($check->num_rows > 0) {
  echo "⚠️ User already exists with this email.";
} else {
  $sql = "INSERT INTO users (username, password) VALUES ('$username', '$password')";
  if ($conn->query($sql)) {
    echo "✅ Registration successful!";
  } else {
    echo "❌ Error: " . $conn->error;
  }
}
?>