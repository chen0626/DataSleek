<?php
include 'db.php';

session_start();
$user_id = $_SESSION['user_id'];

$result = $conn->query("SELECT * FROM data"); // No row-level security

while ($row = $result->fetch_assoc()) {
    echo htmlspecialchars($row['data_point']) . "<br>";
}
