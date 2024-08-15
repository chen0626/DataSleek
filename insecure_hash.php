<?php
// insecure_hash.php
$conn = new mysqli("localhost", "root", "12345678", "WebSecurityDemo");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$username = 'carelessTester'; 
$password = $_POST['password'];

$sql = "INSERT INTO users (username, password) VALUES ('$username', '$password')";
if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();

