<?php
if (isset($_POST['comment'])) {
    $comment = htmlspecialchars($_POST['comment'], ENT_QUOTES, 'UTF-8');
    echo "User comment: " . $comment; // XSS prevention by encoding
}

