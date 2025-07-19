<?php
session_start();
// Ensure the config.php file exists and initializes the $pdo variable
if (!file_exists(__DIR__ . '/includes/config.php')) {
    die('Error: config.php file is missing.');
}
include __DIR__ . '/includes/config.php';

// Check if $pdo is properly initialized
if (!isset($pdo)) {
    die('Database connection not initialized.');
}

// Manually define products with corrected image paths
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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stationery Store</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
    <h1>Stationery Shop</h1>
    <nav>
        <a href="pages/cart.php">Cart</a>
        <?php if (isset($_SESSION['user_id'])): ?>
            <a href="pages/logout.php">Logout</a>
        <?php else: ?>
            <a href="pages/login.php">Login</a>
            <a href="pages/register.php">Register</a>
        <?php endif; ?>
    </nav>
</header>

<!-- Added Get Started button -->
<div style="text-align: center; margin: 20px;">
    <a href="pages/register.php" class="add-btn">Get Started</a>
</div>

<div class="container">
    <h2>Products</h2>
    <div class="product-list">
        <?php
        // Loop through manually defined products and display them
        foreach ($products as $product) {
            echo '<div class="product">';
            echo '<img src="' . htmlspecialchars($product['image']) . '" alt="' . htmlspecialchars($product['name']) . '" class="product-image">';
            echo '<h3>' . htmlspecialchars($product['name']) . '</h3>';
            echo '<p>$' . htmlspecialchars($product['price']) . '</p>';
            echo '</div>';
        }
        ?>
    </div>
</div>

</body>
</html>
