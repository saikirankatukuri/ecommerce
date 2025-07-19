<?php
session_start();
include __DIR__ . '/../includes/config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ? AND is_admin = 1");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['is_admin'] = true;
        header('Location: dashboard.php'); // Redirect to admin dashboard
        exit;
    } else {
        $error = "Invalid admin username or password!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>

<header>
    <h1>Admin Login</h1>
</header>

<div class="container">
    <?php if (isset($error)): ?>
        <p style="color: red;"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <form method="post">
        <input type="text" name="username" placeholder="Admin Username" required><br><br>
        <input type="password" name="password" placeholder="Password" required><br><br>
        <button type="submit">Login</button>
    </form>

    <p><a href="../index.php">Back to Home</a></p>
</div>

<footer style="text-align:center; margin-top: 20px;">
    <p>&copy; <?= date('Y') ?> Stationery Shop</p>
</footer>

</body>
</html>