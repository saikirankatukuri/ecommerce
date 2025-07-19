<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

require_once '../includes/config.php';

try {
    $stmt = $pdo->query("SELECT * FROM products");
    $products = $stmt->fetchAll();
} catch (Exception $e) {
    $products = [
        [
            'name' => 'Notebook',
            'price' => 3.99,
            'image' => 'images/notebook.jpeg'
        ],
        [
            'name' => 'Ballpoint Pen',
            'price' => 1.49,
            'image' => 'images/ballpoint_pen.jpg'
        ],
        [
            'name' => 'Sketchbook',
            'price' => 5.99,
            'image' => 'images/sketch_book.jpeg'
        ],
        [
            'name' => 'Color Markers Set',
            'price' => 7.99,
            'image' => 'images/colour_markers_set.jpeg'
        ],
        [
            'name' => 'Stapler',
            'price' => 4.50,
            'image' => 'images/stapler.jpeg'
        ],
        [
            'name' => 'Paper Clips (100pcs)',
            'price' => 2.00,
            'image' => 'images/paperclip.jpeg'
        ],
        [
            'name' => 'Craft Scissors',
            'price' => 3.75,
            'image' => 'images/craft_scissors.jpeg'
        ],
        [
            'name' => 'Sticky Notes',
            'price' => 2.25,
            'image' => 'images/sticky_notes.jpeg'
        ]
    ];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Stationery Store</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .product-list {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }
        .product {
            border: 1px solid #ccc;
            border-radius: 8px;
            padding: 10px;
            width: 200px;
            box-sizing: border-box;
            text-align: center;
            background-color: #fff;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .product-image {
            max-width: 100%;
            height: 150px;
            object-fit: contain;
            margin-bottom: 10px;
        }
        .add-btn {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            transition: background-color 0.3s ease;
        }
        .add-btn:hover {
            background-color: #0056b3;
        }
        .welcome-text {
            text-align: center;
            margin-bottom: 30px;
        }
    </style>
</head>
<body>

<header>
    <h1>Dashboard</h1>
</header>

<div class="container">
    <div class="welcome-text">
        <h2>Welcome to your Dashboard</h2>
        <p>Here you can view your recent orders and account details.</p>
    </div>

    <h2>Products</h2>
    <div class="product-list">
        <?php
        foreach ($products as $product) {
            echo '<div class="product">';
            echo '<img src="../' . htmlspecialchars($product['image']) . '" alt="' . htmlspecialchars($product['name']) . '" class="product-image">';
            echo '<h3>' . htmlspecialchars($product['name']) . '</h3>';
            echo '<p>$' . number_format($product['price'], 2) . '</p>';
            echo '<form method="post" action="cart.php">';
            echo '<input type="hidden" name="product_id" value="' . (isset($product['id']) ? htmlspecialchars($product['id']) : '') . '">';
            echo '<input type="hidden" name="product_name" value="' . (isset($product['name']) ? htmlspecialchars($product['name']) : '') . '">';
            echo '<input type="hidden" name="product_price" value="' . (isset($product['price']) ? htmlspecialchars($product['price']) : '') . '">';
            echo '<input type="hidden" name="product_image" value="' . (isset($product['image']) ? htmlspecialchars($product['image']) : '') . '">';
            echo '<button type="submit" class="add-btn">Add to Cart</button>';
            echo '</form>';
            echo '</div>';
        }
        ?>
    </div>
</div>

</body>
</html>
