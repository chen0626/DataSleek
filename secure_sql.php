<?php
include 'db.php';

if (isset($_POST['username'])) {
    $username = $_POST['username'];
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");// use prepared sql statement
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        echo "User found!";
    } else {
        echo "No user found!";
    }
    $stmt->close();
}

