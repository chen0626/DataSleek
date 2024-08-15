<?php
include 'db.php';

session_start();
$user_id = $_SESSION['user_id'];
$role_id = $_SESSION['role_id'];

if (hasPermission($conn, $role_id, 'View Data')) {
    $stmt = $conn->prepare("SELECT data_point FROM data WHERE user_id = ? OR ? = (SELECT id FROM roles WHERE role_name = 'Admin')");
    $stmt->bind_param("ii", $user_id, $role_id);
    $stmt->execute();
    $stmt->bind_result($data_point);

    while ($stmt->fetch()) {
        echo htmlspecialchars($data_point) . "<br>"; // XSS prevention by encoding
    }
    $stmt->close();
} else {
    echo "Permission denied!";
}
