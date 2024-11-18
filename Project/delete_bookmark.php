<?php
session_start();
include 'database.php'; // Assuming this file contains the database connection

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'User not logged in']);
    exit;
}

$user_id = $_SESSION['user_id']; // Get logged-in user ID from session
$destination = isset($_POST['destination']) ? $_POST['destination'] : '';

if ($destination) {
    // Delete the bookmark from the database
    $sql = "DELETE FROM bookmarks WHERE user_id = ? AND destination = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('is', $user_id, $destination);
    $stmt->execute();

    echo json_encode(['status' => 'success', 'message' => 'Bookmark deleted']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'No destination provided']);
}
?>
