<?php
session_start();
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    header('Location: ../pages/login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <div class="container">
        <h1>Admin Dashboard</h1>
        <ul>
            <li><a href="users.php">Manage Users</a></li>
            <li><a href="products.php">Manage Products</a></li>
            <li><a href="orders.php">Manage Orders</a></li>
            <li><a href="cart_items.php">View Cart Items</a></li>
        </ul>
    </div>

    <?php include 'includes/footer.php'; ?>
</body>
</html>