<?php
include 'db.php';

$result = $conn->query("SELECT * FROM data"); // No row-level security

while ($row = $result->fetch_assoc()) {
    echo $row['data_point'] . "<br>";
}


