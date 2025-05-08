<?php
$conn = new mysqli("localhost", "root", "", "montero_users");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$username = trim($_POST['username']);
$email = trim($_POST['email']);
$password = $_POST['password'];

if (empty($username) || empty($email) || empty($password) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "Invalid input.";
    exit;
}

$stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    echo "Email already registered.";
    exit;
}

$passwordHash = password_hash($password, PASSWORD_DEFAULT);
$stmt = $conn->prepare("INSERT INTO users (username, email, password_hash) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $username, $email, $passwordHash);

if ($stmt->execute()) {
    header("Location: LD2_Montero_Jon_Andrew");
    exit;
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>