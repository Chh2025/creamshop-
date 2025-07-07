<?php
include 'db.php';

$username = 'chhotugcega51@gmail.com';
$password = password_hash('Lakshmi', PASSWORD_DEFAULT);

// Check if username exists
$check = $conn->query("SELECT * FROM users WHERE username = '$username'");
if ($check->num_rows > 0) {
  echo "⚠️ User already exists.";
  exit();
}

$sql = "INSERT INTO users (username, password) VALUES ('$username', '$password')";
if ($conn->query($sql)) {
  echo "✅ Admin user added successfully.";
} else {
  echo "❌ Error: " . $conn->error;
}
?>