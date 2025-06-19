<?php
session_start();

// Return JSON response
header('Content-Type: application/json');

echo json_encode([
    'isLoggedIn' => isset($_SESSION['user_id']),
]);
