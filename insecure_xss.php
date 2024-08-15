<?php
if (isset($_POST['comment'])) {
    $comment = $_POST['comment'];
    echo "User comment: " . $comment; // Vulnerable to XSS
}

