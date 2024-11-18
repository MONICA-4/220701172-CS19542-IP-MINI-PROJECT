<?php
session_start();
include 'database.php'; // Database connection

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'User not logged in']);
    exit;
}

$user_id = $_SESSION['user_id']; // Get the logged-in user's ID
$destination = isset($_POST['destination']) ? $_POST['destination'] : '';

if ($destination) {
    // Check if the destination is already bookmarked by the user
    $sql = "SELECT * FROM bookmarks WHERE user_id = ? AND destination = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('is', $user_id, $destination);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // If bookmarked, remove it
        $delete_sql = "DELETE FROM bookmarks WHERE user_id = ? AND destination = ?";
        $delete_stmt = $conn->prepare($delete_sql);
        $delete_stmt->bind_param('is', $user_id, $destination);
        $delete_stmt->execute();
        echo json_encode(['status' => 'success', 'message' => 'Bookmark removed']);
    } else {
        // If not bookmarked, add it
        $insert_sql = "INSERT INTO bookmarks (user_id, destination) VALUES (?, ?)";
        $insert_stmt = $conn->prepare($insert_sql);
        $insert_stmt->bind_param('is', $user_id, $destination);
        $insert_stmt->execute();
        echo json_encode(['status' => 'success', 'message' => 'Bookmark added']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'No destination provided']);
}
?>
