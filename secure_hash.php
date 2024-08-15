<?php
// secure_hash.php
$conn = new mysqli("localhost", "root", "12345678", "WebSecurityDemo");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$username = 'goodTester'; 
$password = $_POST['password'];
// hashes passwords using bcrypt before storing them.
$hashed_password = password_hash($password, PASSWORD_BCRYPT); 

$stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
$stmt->bind_param("ss", $username, $hashed_password);
if ($stmt->execute()) {
    echo "New record created successfully";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();

