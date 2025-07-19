<?php
// Connect to your database
$servername = "localhost"; // or your server name
$username = "root";         // your database username
$password = "";             // your database password
$database = "ecommerce";    // your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Admin details
$admin_username = 'admin';
$admin_password_plain = 'sai1234'; // plain password

// Hash the password securely
$admin_password_hashed = password_hash($admin_password_plain, PASSWORD_DEFAULT);

// Insert into users table
$sql = "INSERT INTO users (username, password, is_admin) VALUES (?, ?, 1)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $admin_username, $admin_password_hashed);

if ($stmt->execute()) {
    echo "Admin user created successfully!";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
