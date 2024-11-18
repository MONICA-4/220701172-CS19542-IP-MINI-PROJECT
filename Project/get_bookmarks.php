<?php
session_start();
include 'database.php'; // Database connection

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'User not logged in']);
    exit;
}

$user_id = $_SESSION['user_id']; // Get the logged-in user's ID

// Fetch bookmarks for the logged-in user
$sql = "SELECT destination FROM bookmarks WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$bookmarked_destinations = [];
while ($row = $result->fetch_assoc()) {
    $bookmarked_destinations[] = $row['destination'];
}

echo json_encode($bookmarked_destinations); // Output as JSON
?>
