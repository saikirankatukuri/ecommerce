<?php
session_start();

// Redirect to login if user is not logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Initialize cart in session if not set
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// CSRF Token Generation
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Add to cart
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'], $_POST['product_name'], $_POST['product_price'], $_POST['product_image'])) {
    $product_id = intval($_POST['product_id']);
    $product_name = $_POST['product_name'];
    $product_price = floatval($_POST['product_price']);
    $product_image = $_POST['product_image'];

    if (isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id]['quantity'] += 1;
    } else {
        $_SESSION['cart'][$product_id] = [
            'name' => $product_name,
            'price' => $product_price,
            'image' => $product_image,
            'quantity' => 1
        ];
    }
    header('Location: cart.php');
    exit;
}

// Remove from cart
if (isset($_GET['remove'])) {
    $remove_id = intval($_GET['remove']);
    if (isset($_SESSION['cart'][$remove_id])) {
        unset($_SESSION['cart'][$remove_id]);
    }
    header('Location: cart.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Your Cart</title>
    <link rel="stylesheet" href="../style.css" />
</head>
<body>

<header>
    <h1>Your Cart</h1>
    <nav>
        <a href="../index.php">Home</a>
        <a href="checkout.php">Checkout</a>
        <a href="logout.php">Logout</a>
    </nav>
</header>

<div class="container">
    <?php if (!empty($_SESSION['cart'])): ?>
        <table>
            <tr>
                <th>Product</th>
                <th>Qty</th>
                <th>Price</th>
                <th>Remove</th>
            </tr>
            <?php
            $total = 0;
            foreach ($_SESSION['cart'] as $id => $item):
                $subtotal = $item['price'] * $item['quantity'];
                $total += $subtotal;
            ?>
            <tr>
                <td>
                    <img src="../<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['name']) ?>" style="width:50px; height:auto;">
                    <?= htmlspecialchars($item['name']) ?>
                </td>
                <td><?= $item['quantity'] ?></td>
                <td>$<?= number_format($subtotal, 2) ?></td>
                <td><a href="cart.php?remove=<?= $id ?>">Remove</a></td>
            </tr>
            <?php endforeach; ?>
        </table>
        <h3>Total: $<?= number_format($total, 2) ?></h3>
        <form action="checkout.php" method="POST">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
            <button type="submit" class="checkout-btn">Proceed to Checkout</button>
        </form>
    <?php else: ?>
        <p>Your cart is empty!</p>
    <?php endif; ?>
</div>

</body>
</html>
