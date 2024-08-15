<?php
include 'db.php';

if (isset($_POST['username'])) {
    $username = $_POST['username'];
    $query = "SELECT * FROM users WHERE username = '$username'"; // Vulnerable to SQL Injection
    $result = $conn->query($query);
    
    if ($result->num_rows > 0) {
        echo "User found!";
    } else {
        echo "No user found!";
    }
}
