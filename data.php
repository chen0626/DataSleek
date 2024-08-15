<?php
include 'db.php';

session_start();
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role_id'])) {
    die("Unauthorized access.");
}

$user_id = $_SESSION['user_id'];
$role_id = $_SESSION['role_id'];

function hasPermission($conn, $role_id, $permission_name) {
    $stmt = $conn->prepare("SELECT COUNT(*) FROM role_permissions rp
                            JOIN permissions p ON rp.permission_id = p.id
                            WHERE rp.role_id = ? AND p.permission_name = ?");
    $stmt->bind_param("is", $role_id, $permission_name);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();
    return $count > 0;
}

if (isset($_POST['add_data'])) {
    if (hasPermission($conn, $role_id, 'Add Data')) {
        $data_point = $_POST['data_point'];

        $stmt = $conn->prepare("INSERT INTO data (user_id, data_point) VALUES (?, ?)");
        $stmt->bind_param("is", $user_id, $data_point);
        if (!$stmt->execute()) {
            die("Error: " . $stmt->error);
        }
        $stmt->close();
        echo "Data added successfully!";
    } else {
        echo "Permission denied!";
    }
}

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
