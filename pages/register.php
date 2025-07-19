<?php
session_start();
include __DIR__ . '/../includes/config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Check if user already exists
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);

    if ($stmt->rowCount() > 0) {
        $error = "Username already exists!";
    } else {
        $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        $stmt->execute([$username, $password]);
        // Get the inserted user id
        $user_id = $pdo->lastInsertId();
        $_SESSION['user_id'] = $user_id;
        header('Location: dashboard.php');
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
    <h1>Register</h1>
    <nav>
        <a href="cart.php">Cart</a>
        <a href="logout.php">Logout</a>
        <a href="index.php">Home</a>
    </nav>
</header>

<div class="container">
    <?php if (isset($error)): ?>
        <p style="color: red;"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <form method="post">
        <input type="text" name="username" placeholder="Username" required><br><br>
        <input type="password" name="password" placeholder="Password" required><br><br>
        <button type="submit">Register</button>
    </form>

    <p>Already have an account? <a href="login.php">Login Here</a></p>
</div>

<footer style="text-align:center; margin-top: 20px;">
    <p>&copy; 2024 Stationery Shop</p>
</footer>

</body>
</html>
