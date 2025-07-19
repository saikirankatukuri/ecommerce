<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// CSRF Token check and order processing
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die('Invalid CSRF token');
    }

    if (empty($_SESSION['cart'])) {
        header('Location: cart.php');
        exit;
    }

    // Validate delivery address fields
    $address = trim($_POST['address'] ?? '');
    $city = trim($_POST['city'] ?? '');
    $state = trim($_POST['state'] ?? '');
    $zip = trim($_POST['zip'] ?? '');

    if (!$address || !$city || !$state || !$zip) {
        $error = "Please fill in all delivery address fields.";
    } else {
        // Process order (for demo, just clear cart and redirect)
        $order_id = rand(1000, 9999); // Dummy order ID for demo

        // Save order details and address in session for order_success.php
        $_SESSION['last_order'] = [
            'id' => $order_id,
            'address' => [
                'address' => $address,
                'city' => $city,
                'state' => $state,
                'zip' => $zip
            ],
            'items' => $_SESSION['cart'],
            'total' => 0
        ];

        foreach ($_SESSION['cart'] as $item) {
            $_SESSION['last_order']['total'] += $item['price'] * $item['quantity'];
        }

        // Clear cart
        $_SESSION['cart'] = [];

        header('Location: order_success.php?order_id=' . $order_id);
        exit;
    }
}

// Generate CSRF token if not set
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$total = 0;
if (!empty($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $item) {
        $total += $item['price'] * $item['quantity'];
    }
} else {
    header('Location: cart.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Checkout</title>
    <link rel="stylesheet" href="style.css" />
    <style>
        .checkout-container {
            max-width: 800px;
            margin: 20px auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        .order-summary, .delivery-address {
            margin-bottom: 20px;
        }
        .order-summary table {
            width: 100%;
            border-collapse: collapse;
        }
        .order-summary th, .order-summary td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
            vertical-align: middle;
        }
        .order-summary th {
            background-color: #f4f4f4;
        }
        .order-summary img {
            width: 50px;
            height: auto;
            margin-right: 12px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .delivery-address label {
            display: block;
            margin-bottom: 6px;
            font-weight: bold;
        }
        .delivery-address input {
            width: 100%;
            padding: 8px;
            margin-bottom: 12px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .error-message {
            color: red;
            margin-bottom: 12px;
        }
        .checkout-btn {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
            transition: background-color 0.3s ease;
        }
        .checkout-btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<header>
    <h1>Checkout</h1>
    <nav>
        <a href="index.php">Home</a>
        <a href="cart.php">Cart</a>
        <a href="logout.php">Logout</a>
    </nav>
</header>

<div class="container checkout-container">
    <?php if (!empty($error)): ?>
        <div class="error-message"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <div class="order-summary">
        <h2>Order Summary</h2>
        <table>
            <tr>
                <th>Product</th>
                <th>Qty</th>
                <th>Price</th>
                <th>Subtotal</th>
            </tr>
            <?php foreach ($_SESSION['cart'] as $item): ?>
            <tr>
                <td>
                    <img src="../<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['name']) ?>">
                    <?= htmlspecialchars($item['name']) ?>
                </td>
                <td><?= $item['quantity'] ?></td>
                <td>$<?= number_format($item['price'], 2) ?></td>
                <td>$<?= number_format($item['price'] * $item['quantity'], 2) ?></td>
            </tr>
            <?php endforeach; ?>
            <tr>
                <th colspan="3" style="text-align:right;">Total:</th>
                <th>$<?= number_format($total, 2) ?></th>
            </tr>
        </table>
    </div>

    <div class="delivery-address">
        <h2>Delivery Address</h2>
        <form method="POST" action="checkout.php">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
            <label for="address">Address</label>
            <input type="text" id="address" name="address" required>

            <label for="city">City</label>
            <input type="text" id="city" name="city" required>

            <label for="state">State</label>
            <input type="text" id="state" name="state" required>

            <label for="zip">Zip Code</label>
            <input type="text" id="zip" name="zip" required>

            <button type="submit" class="checkout-btn">Place Order</button>
        </form>
    </div>
</div>

</body>
</html>
