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
  <title>Admin Dashboard - Dukan</title>
  <link rel="stylesheet" href="style.css">
  <style>
    .dashboard {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 20px;
      margin-top: 30px;
    }
    .card {
      background-color: #f39c12;
      color: white;
      padding: 20px;
      border-radius: 10px;
      text-align: center;
      transition: 0.3s;
    }
    .card:hover {
      background-color: #e67e22;
    }
    .card a {
      color: white;
      text-decoration: none;
      font-weight: bold;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>Admin Dashboard</h1>
    <p>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</p>
    <div class="dashboard">
      <div class="card">
        <h2>Manage Products</h2>
        <a href="product.php">Go to Products</a>
      </div>
      <div class="card">
        <h2>View Users</h2>
        <a href="view_users.php">See Users</a>
      </div>
      <div class="card" style="background-color: #c0392b;">
        <h2>Logout</h2>
        <a href="logout.php">Logout</a>
      </div>
    </div>
  </div>
</body>
</html>
