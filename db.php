<?php
$host = 'localhost:3307';
$user = 'root';
$pass = '';
$db = 'dukan';
$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
  die('Connection Failed: ' . $conn->connect_error);
}
?>
