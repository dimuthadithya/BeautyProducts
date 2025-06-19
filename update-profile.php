<?php
require_once 'config/db_conn.php';
session_start();

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Please login to update your profile']);
    exit;
}

$user_id = $_SESSION['user_id'];

// Validate required fields
$required_fields = ['first_name', 'last_name'];
$missing_fields = [];
foreach ($required_fields as $field) {
    if (!isset($_POST[$field]) || empty(trim($_POST[$field]))) {
        $missing_fields[] = $field;
    }
}

if (!empty($missing_fields)) {
    echo json_encode([
        'success' => false,
        'message' => 'Please fill in all required fields',
        'missing_fields' => $missing_fields
    ]);
    exit;
}

try {
    // Update user information
    $stmt = $conn->prepare("
        UPDATE users 
        SET first_name = ?, 
            last_name = ?, 
            phone = ?
        WHERE user_id = ?
    ");

    $stmt->bind_param(
        "sssi",
        $_POST['first_name'],
        $_POST['last_name'],
        $_POST['phone'],
        $user_id
    );

    if ($stmt->execute()) {
        echo json_encode([
            'success' => true,
            'message' => 'Profile updated successfully'
        ]);
    } else {
        throw new Exception('Error updating profile');
    }
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}

$conn->close();
