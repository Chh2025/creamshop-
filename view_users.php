<?php
session_start();
if (!isset($_SESSION['username'])) {
  header("Location: login.html");
  exit();
}
include 'db.php';

$result = $conn->query("SELECT id, username FROM users");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>View Users</title>
  <link rel="stylesheet" href="style.css">
  <style>
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }
    th, td {
      border: 1px solid #ccc;
      padding: 10px;
      text-align: center;
    }
    th {
      background-color: #2ecc71;
      color: white;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>Registered Users</h1>
    <table>
      <tr>
        <th>ID</th>
        <th>Username</th>
      </tr>
      <?php while ($user = $result->fetch_assoc()): ?>
        <tr>
          <td><?php echo $user['id']; ?></td>
          <td><?php echo htmlspecialchars($user['username']); ?></td>
        </tr>
      <?php endwhile; ?>
    </table>
  </div>
</body>
</html>
