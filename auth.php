<?php
include 'db.php';

function hashPassword($password) {
    return password_hash($password, PASSWORD_BCRYPT);
}

if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $password = hashPassword($_POST['password']);
    $role_name = $_POST['role']; // Role name from the form

    // Fetch role_id based on role_name
    $stmt = $conn->prepare("SELECT id FROM roles WHERE role_name = ?");
    $stmt->bind_param("s", $role_name);
    $stmt->execute();
    $stmt->bind_result($role_id);
    $stmt->fetch();
    $stmt->close();

    if (!$role_id) {
        die("Invalid role selected.");
    }

    $stmt = $conn->prepare("INSERT INTO users (username, password, role_id) VALUES (?, ?, ?)");
    $stmt->bind_param("ssi", $username, $password, $role_id);

    if (!$stmt->execute()) {
        die("Error: " . $stmt->error);
    }
    $stmt->close();

    // Redirect to index.html
    header("Location: index.html");
    exit();
}

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, password, role_id FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($user_id, $hashed_password, $role_id);
    $stmt->fetch();
    $stmt->close();

    if (password_verify($password, $hashed_password)) {
        session_start();
        $_SESSION['user_id'] = $user_id;
        $_SESSION['role_id'] = $role_id;
        header("Location: index.html");
        exit();
    } else {
        echo "Invalid credentials!";
    }
}
