<?php
session_start();

if (!isset($_SESSION['last_order'])) {
    header('Location: ../index.php');
    exit;
}

$order = $_SESSION['last_order'];
unset($_SESSION['last_order']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Order Successful</title>
    <link rel="stylesheet" href="../style.css">
    <style>
        .order-success-container {
            max-width: 600px;
            margin: 30px auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            text-align: center;
        }
        .order-summary {
            text-align: left;
            margin-top: 20px;
        }
        .order-summary ul {
            list-style: none;
            padding: 0;
        }
        .order-summary li {
            margin-bottom: 12px;
            display: flex;
            align-items: center;
        }
        .order-summary img {
            width: 50px;
            height: auto;
            margin-right: 12px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .delivery-address {
            margin-top: 20px;
            text-align: left;
        }
        .delivery-address p {
            margin: 4px 0;
        }
        .thank-you {
            margin-top: 20px;
            font-size: 18px;
            font-weight: bold;
            color: #28a745;
        }
    </style>
</head>
<body>

<header>
    <h1>Order Placed Successfully!</h1>
    <nav>
        <a href="../index.php">Home</a>
        <a href="logout.php">Logout</a>
    </nav>
</header>

<div class="container order-success-container">
    <h2>Order Summary (Order ID: <?= htmlspecialchars($order['id']) ?>)</h2>
    <div class="order-summary">
        <ul>
            <?php foreach ($order['items'] as $item): ?>
                <li>
                    <img src="<?= htmlspecialchars('../' . $item['image']) ?>" alt="<?= htmlspecialchars($item['name']) ?>">
                    <?= htmlspecialchars($item['name']) ?> - <?= $item['quantity'] ?> pcs - $<?= number_format($item['price'] * $item['quantity'], 2) ?>
                </li>
            <?php endforeach; ?>
        </ul>
        <p><strong>Total Price:</strong> $<?= number_format($order['total'], 2) ?></p>
    </div>

    <div class="delivery-address">
        <h3>Delivery Address</h3>
        <p><?= htmlspecialchars($order['address']['address']) ?></p>
        <p><?= htmlspecialchars($order['address']['city']) ?>, <?= htmlspecialchars($order['address']['state']) ?> <?= htmlspecialchars($order['address']['zip']) ?></p>
    </div>

    <div class="thank-you">
        Thank you for shopping with us!
    </div>
</div>

</body>
</html>
