<?php
session_start();
if (!isset($_SESSION['username'])) {
  header("Location: login.html");
  exit();
}
include 'db.php';
// Insert default products if table is empty
$productCheck = $conn->query("SELECT COUNT(*) as count FROM products");
$countRow = $productCheck->fetch_assoc();

if ($countRow['count'] == 0) {
  $defaultProducts = [
    ['name' => 'Apple iPhone 14', 'price' => 69999, 'image' => 'uploads/iphone.jpg'],
    ['name' => 'Samsung Galaxy S23', 'price' => 64999, 'image' => 'uploads/galaxy.jpg'],
    ['name' => 'OnePlus 11', 'price' => 59999, 'image' => 'uploads/oneplus.jpg'],
  ];

  foreach ($defaultProducts as $prod) {
    $stmt = $conn->prepare("INSERT INTO products (name, price, image) VALUES (?, ?, ?)");
    $stmt->bind_param("sds", $prod['name'], $prod['price'], $prod['image']);
    $stmt->execute();
  }
}
// Handle delete
if (isset($_GET['delete'])) {
  $id = intval($_GET['delete']);

  // Delete image file
  $result = $conn->query("SELECT image FROM products WHERE id = $id");
  $row = $result->fetch_assoc();
  if ($row && file_exists($row['image'])) {
    unlink($row['image']);
  }

  $conn->query("DELETE FROM products WHERE id = $id");
  header("Location: products.php");
  exit();
}

// Handle add product
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = $_POST['name'];
  $price = $_POST['price'];
  $imagePath = '';

  // Handle image upload
  if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
    $uploadDir = 'uploads/';
    $imageName = uniqid() . '_' . basename($_FILES['image']['name']);
    $imagePath = $uploadDir . $imageName;
    move_uploaded_file($_FILES['image']['tmp_name'], $imagePath);
  }

  $stmt = $conn->prepare("INSERT INTO products (name, price, image) VALUES (?, ?, ?)");
  $stmt->bind_param("sds", $name, $price, $imagePath);
  $stmt->execute();
}

$products = $conn->query("SELECT * FROM products");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Manage Products</title>
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
      background-color: #3498db;
      color: white;
    }
    .delete-btn {
      color: white;
      background-color: #e74c3c;
      padding: 5px 10px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }
    .form-box {
      margin-top: 20px;
      background: #ecf0f1;
      padding: 20px;
      border-radius: 10px;
    }
    .form-box input {
      padding: 8px;
      margin-right: 10px;
    }
    img {
      width: 60px;
      height: auto;
      border-radius: 6px;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>Product Management</h1>

    <form method="POST" enctype="multipart/form-data" class="form-box">
      <input type="text" name="name" placeholder="Product Name" required>
      <input type="number" name="price" step="0.01" placeholder="Price" required>
      <input type="file" name="image" accept="image/*" required>
      <button type="submit">Add Product</button>
    </form>

    <table>
      <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Price (₹)</th>
        <th>Image</th>
        <th>Action</th>
      </tr>
      <?php while ($row = $products->fetch_assoc()): ?>
        <tr>
          <td><?php echo $row['id']; ?></td>
          <td><?php echo htmlspecialchars($row['name']); ?></td>
          <td>&#8377;<?php echo $row['price']; ?></td>
          <td>
            <?php if ($row['image']): ?>
              <img src="<?php echo $row['image']; ?>" alt="Product Image">
            <?php else: ?>
              No image
            <?php endif; ?>
          </td>
          <td>
            <a href="products.php?delete=<?php echo $row['id']; ?>" class="delete-btn" onclick="return confirm('Delete this product?')">Delete</a>
          </td>
        </tr>
      <?php endwhile; ?>
    </table>
  </div>
</body>
</html>